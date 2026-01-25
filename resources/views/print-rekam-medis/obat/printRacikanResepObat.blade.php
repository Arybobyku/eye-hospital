<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resep Medis - KLINIK PRATAMA</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
            }
            .no-print {
                display: none;
            }
        }

        body {
            font-family: 'Courier New', monospace;
            padding: 20px;
            background: white;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .header p {
            font-size: 11px;
            margin: 2px 0;
        }

        .title {
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            margin: 20px 0;
            letter-spacing: 2px;
        }

        .info-section {
            margin-bottom: 15px;
        }

        .info-row {
            display: flex;
            font-size: 12px;
            margin: 3px 0;
        }

        .info-label {
            width: 100px;
            flex-shrink: 0;
        }

        .info-colon {
            width: 10px;
            flex-shrink: 0;
        }

        .info-value {
            flex: 1;
        }

        .divider {
            border-bottom: 1px solid #000;
            margin: 10px 0;
        }

        .prescription-item {
            margin: 15px 0;
        }

        .prescription-header {
            display: flex;
            font-size: 12px;
            margin-bottom: 5px;
        }

        .prescription-header .rx {
            width: 40px;
            flex-shrink: 0;
        }

        .prescription-header .medicine {
            flex: 1;
        }

        .prescription-header .number {
            width: 80px;
            text-align: right;
        }

        .prescription-usage {
            font-size: 11px;
            margin-left: 40px;
            margin-top: 2px;
        }

        .footer-section {
            margin-top: 30px;
        }

        .print-button {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 10px 20px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }

        .print-button:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    {{-- <button class="print-button no-print" onclick="window.print()">Print PDF</button> --}}
    <?php $fullpath = storage_path('app/public/images/header_rme.png');  ?>  

    <div class="container">
        <div class="header">
            @include('print-rekam-medis.partials.header')

        </div>

        <div class="title">R E S E P ({{ $registrasi->nomor }})</div>

        <div class="info-section">
            <div class="info-row">
                <div class="info-label">DOKTER</div>
                <div class="info-colon">:</div>
                <div class="info-value">{{ $registrasi->nama_dokter }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">DARI</div>
                <div class="info-colon">:</div>
                <div class="info-value">{{ $registrasi->jenis }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Reg/MR</div>
                <div class="info-colon">:</div>
                <div class="info-value">{{ $registrasi->rekam_medis }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Tanggal</div>
                <div class="info-colon">:</div>
                <div class="info-value">{{ $registrasi->created_at }}</div>
            </div>
        </div>

        <div class="divider"></div>
        @foreach ( $racikans as $item)
            
        
        <div class="prescription-item">
            <div class="prescription-header">
                <div class="">Signa : {{ $item->signa }}</div>
                <div class="medicine">{{ $item->label }}</div>
                <div class="number">{{ $item->jumlah }} {{ $item->kemasan }}</div>
            </div>
            {{-- <div class="prescription-usage">S. 1 X 1 Dioleskan ke wajah</div> --}}
        </div>
        @endforeach


        <div class="divider"></div>

        {{-- <div class="footer-section">
            <div class="info-row">
                <div class="info-label">Pro</div>
                <div class="info-colon">:</div>
                <div class="info-value">MAWAR MERAH</div>
            </div>
            <div class="info-row">
                <div class="info-label">Umur</div>
                <div class="info-colon">:</div>
                <div class="info-value">41 Tahun 4 Bulan</div>
            </div>
        </div> --}}
    </div>
</body>
</html>