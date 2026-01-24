<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>RM1.5</title>
    <style>
        @page {
            margin: 18px;
        }

        body {
            margin: 18px;
        }

        .wrap {
            width: 100%;
            height: auto;
            display: inline-block;
        }

        .tablee {
            border: 1px solid black;
            border-collapse: collapse;
        }

        .page_break {
            page-break-before: always;
        }

        .table tr td {
            border: 1px solid #767676;
            border-collapse: collapse;
        }
    </style>

</head>

<body>
    <div style="position:fixed; right: 13px; bottom: 10px;">
    </div>
    <?php $fullpath = storage_path('app/public/images/header_rme.png'); ?>
    <?php $eyero = storage_path('app/public/images/EYE-RO.png'); ?>
    <div class="wrap">
        <div style="width:100%; text-align:right; margin-bottom:5px">
            RM 1.5/CPPT/22
        </div>
        @include('print-rekam-medis.partials.header')
        {{-- table content --}}
        <h3 style="text-align: center">CATATAN PERKEMBANGAN PASIEN TERINTEGERASI RAWAT JALAN</h3>
        <table class="tablee" style="width:100%; position:relative">
            <tr class="tablee">
                <th class="tablee">Tanggal/Jam</th>
                <th class="tablee">Profesionnal Pemberi Asuhan (PPA)</th>
                <th class="tablee">Hasil Asesmen Pasien dan Pemberian Pelayanan (SOAP)</th>
                <th class="tablee">Instruksi PPA Termasuk Pasca Bedah</th>
                <th class="tablee">Review & Verifikasi DPJP (Paraf)</th>
            </tr>

            @foreach ($cppt as $itemcppt)
                @php
                    [$date, $time] = explode(' ', $itemcppt->created_at);
                    $timeWithoutMilliseconds = explode('.', $time)[0];
                @endphp
                <tr>
                    <td class="tablee">
                        {{ $date }} <br> {{ $timeWithoutMilliseconds }}
                    </td>
                    <td class="tablee">
                        {{ $itemcppt->pengguna_nama_pengguna }}
                    </td>
                    <td class="tablee">
                        @if ($itemcppt->subjek)
                            <b>Subject :</b><br>
                            {!! fix_richtext_table_html($itemcppt->subjek ?? '') !!}
                            <br>
                        @endif

                        @if ($itemcppt->objek)
                            <b>Object :</b><br>
                            {!! fix_richtext_table_html($itemcppt->objek ?? '') !!}
                            <br>
                        @endif

                        @if ($itemcppt->asesmen)
                            <b>Assessment :</b><br>
                            {!! fix_richtext_table_html($itemcppt->asesmen ?? '') !!}
                            <br>
                        @endif
                        @if ($itemcppt->plan)
                            <b>Plan :</b><br>
                            {!! fix_richtext_table_html($itemcppt->plan ?? '') !!}
                        @endif
                    </td>

                    <td class="tablee"></td>
                    <td class="tablee">
                        <img src="{{ $itemcppt->ttd }}" alt="Base64 Image" width="50px">
                        <br>
                        {{ $itemcppt->pengguna_nama_pengguna }}
                        <br>
                        {{-- {{ $date }} <br> {{ $timeWithoutMilliseconds }} --}}
                    </td>
                </tr>
            @endforeach

        </table>
    </div>
</body>

@php
    function richtext_to_handwriting(string $html): string
    {
        $html = trim($html);
        if ($html === '') {
            return '';
        }

        libxml_use_internal_errors(true);

        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->loadHTML(
            '<?xml encoding="UTF-8"><div id="root">' . $html . '</div>',
            LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD,
        );

        $xpath = new DOMXPath($dom);

        // ============ Extract tables ============
        $tables = $xpath->query('//table');
        $tableTexts = [];

        foreach ($tables as $table) {
            $tableTexts[] = extract_ocular_table_text($xpath, $table);

            // hapus table / figure parent
            $parent = $table->parentNode;
            if ($parent && $parent->nodeName === 'figure') {
                $parent->parentNode?->removeChild($parent);
            } else {
                $table->parentNode?->removeChild($table);
            }
        }

        // ============ Remaining text (tanpa table) ============
        $root = $xpath->query('//*[@id="root"]')->item(0);
        $remainingHtml = $root ? $dom->saveHTML($root) : '';
        $remainingHtml = preg_replace('~^<div id="root">|</div>$~', '', $remainingHtml);

        $remainingHtml = preg_replace('~<\s*br\s*/?\s*>~i', "\n", $remainingHtml);
        $remainingHtml = preg_replace('~</\s*p\s*>~i', "\n", $remainingHtml);

        $remainingText = strip_tags($remainingHtml);
        $remainingText = html_entity_decode($remainingText, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        // rapihin whitespace
        $remainingText = preg_replace("/\r\n|\r/", "\n", $remainingText);
        $remainingText = preg_replace("/[ \t]+/", ' ', $remainingText);
        $remainingText = preg_replace("/\n{3,}/", "\n\n", $remainingText);
        $remainingText = trim($remainingText);

        // gabung
        $out = [];
        if ($remainingText !== '') {
            $out[] = $remainingText;
        }

        $tableTexts = array_values(array_filter(array_map('trim', $tableTexts)));
        if (!empty($tableTexts)) {
            $out[] = implode("\n\n", $tableTexts);
        }

        return trim(implode("\n\n", $out));
    }

    // ===== helper function untuk table ocular (3 kolom: label, OD, OS) =====
    function extract_ocular_table_text(DOMXPath $xpath, DOMNode $table): string
    {
        // ambil header
        $headerCells = $xpath->query('.//thead//tr[1]/*', $table);
        $hOD = node_text($headerCells?->item(1));
        $hOS = node_text($headerCells?->item(2));

        $odName = $hOD !== '' ? $hOD : 'Ocular Dextra (OD)';
        $osName = $hOS !== '' ? $hOS : 'Ocular Sinistra (OS)';

        $lines = [];
        $lines[] = "{$odName} / {$osName}:";

        $rows = $xpath->query('.//tbody//tr', $table);
        foreach ($rows as $tr) {
            $cells = $xpath->query('./td|./th', $tr);

            $label = node_text($cells?->item(0));
            $od = node_text($cells?->item(1));
            $os = node_text($cells?->item(2));

            if ($label === '') {
                continue;
            }

            $od = $od !== '' ? $od : '-';
            $os = $os !== '' ? $os : '-';

            $lines[] = "{$label}: OD {$od} | OS {$os}";
        }

        return implode("\n", $lines);
    }

    function node_text(?DOMNode $node): string
    {
        if (!$node) {
            return '';
        }
        $t = $node->textContent ?? '';
        $t = html_entity_decode($t, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $t = preg_replace('/\s+/', ' ', $t);
        return trim($t);
    }
    function fix_richtext_table_html(string $html): string
    {
        $html = trim($html);
        if ($html === '') {
            return '';
        }

        libxml_use_internal_errors(true);

        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->loadHTML(
            '<?xml encoding="UTF-8"><div id="root">' . $html . '</div>',
            LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD,
        );

        $xpath = new DOMXPath($dom);

        // Tambah style ke figure.table (kalau ada)
        $figures = $xpath->query('//figure[contains(@class,"table")]');
        foreach ($figures as $fig) {
            $style = $fig->attributes?->getNamedItem('style')?->nodeValue ?? '';
            $styleAdd = 'margin:6px 0; padding:0;';
            $fig->setAttribute('style', trim($style . ';' . $styleAdd, ';'));
        }

        // Rapikan semua table
        $tables = $xpath->query('//table');
        foreach ($tables as $table) {
            // add class
            $existingClass = $table->attributes?->getNamedItem('class')?->nodeValue ?? '';
            $table->setAttribute('class', trim($existingClass . ' report-table'));

            // add inline style (paling kompatibel untuk PDF/print)
            $style = $table->attributes?->getNamedItem('style')?->nodeValue ?? '';
            $styleAdd = 'width:100%; border-collapse:collapse; table-layout:fixed; font-size:12px;';
            $table->setAttribute('style', trim($style . ';' . $styleAdd, ';'));

            // thead td/th bold + bg (opsional)
            $heads = $xpath->query('.//thead//td | .//thead//th', $table);
            foreach ($heads as $cell) {
                $cStyle = $cell->attributes?->getNamedItem('style')?->nodeValue ?? '';
                $cAdd = 'border:1px solid #000; padding:4px 6px; font-weight:bold; text-align:center;';
                $cell->setAttribute('style', trim($cStyle . ';' . $cAdd, ';'));
            }

            // tbody td/th
            $cells = $xpath->query('.//tbody//td | .//tbody//th', $table);
            foreach ($cells as $cell) {
                $cStyle = $cell->attributes?->getNamedItem('style')?->nodeValue ?? '';
                $cAdd = 'border:1px solid #000; padding:4px 6px; vertical-align:top; word-wrap:break-word;';
                $cell->setAttribute('style', trim($cStyle . ';' . $cAdd, ';'));
            }

            // Set lebar kolom default untuk table 3 kolom (label + OD + OS)
            $firstRow = $xpath->query('.//tr[1]', $table)->item(0);
            if ($firstRow) {
                $colCount = $xpath->query('./td|./th', $firstRow)->length;
                if ($colCount === 3) {
                    // set width tiap kolom pada semua row
                    $rows = $xpath->query('.//tr', $table);
                    foreach ($rows as $tr) {
                        $cs = $xpath->query('./td|./th', $tr);
                        if ($cs->length === 3) {
                            $cs->item(0)->setAttribute(
                                'style',
                                trim(($cs->item(0)->getAttribute('style') ?? '') . ';width:45%;', ';'),
                            );
                            $cs->item(1)->setAttribute(
                                'style',
                                trim(($cs->item(1)->getAttribute('style') ?? '') . ';width:27.5%;', ';'),
                            );
                            $cs->item(2)->setAttribute(
                                'style',
                                trim(($cs->item(2)->getAttribute('style') ?? '') . ';width:27.5%;', ';'),
                            );
                        }
                    }
                }
            }
        }

        // Ambil kembali inner HTML root
        $root = $xpath->query('//*[@id="root"]')->item(0);
        $out = $root ? $dom->saveHTML($root) : $html;
        $out = preg_replace('~^<div id="root">|</div>$~', '', $out);

        return $out;
    }

@endphp


</html>
