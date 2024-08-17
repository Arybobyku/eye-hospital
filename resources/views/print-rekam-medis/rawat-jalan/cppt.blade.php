<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
         .table, td {
            border: 1px solid #767171;
            border-collapse: collapse;
        }
    </style>
</head>

<body>
    @php
        $sorted = [];
        $data = $cppt->sortBy('created_at')->values(); // Urutkan data berdasarkan created_at

        // Loop untuk mengatur urutan
        while ($data->isNotEmpty()) {
            foreach (['PERAWAT', 'RO', 'DOKTER'] as $sebagai) {
                $item = $data->firstWhere('sebagai', $sebagai);
                if ($item) {
                    $sorted[] = $item;
                    // Hapus item dari koleksi asli
                    $data = $data->reject(function($i) use ($item) {
                        return $i->id == $item->id;
                    });
                }
            }
        }
    @endphp

    @foreach ($sorted as $item)
        <table style="border-collapse:collapse; width:400px">
            <tr style="border-collapse:collapse; border:1px solid #767171; width:100px;">
                <td style="width:150px; padding:5px;">Nama Pemeriksa</td>
                <td>: {{ $item->pengguna->nama ?? "" }}</td>
            </tr>
            <tr style="border-collapse:collapse; border:1px solid #767171; width:100px;">
                <td style="width:150px; padding:5px;">Tanggal Pemeriksaan</td>
                <td>: {{ $item->created_at }}</td>
            </tr>
            <tr>
                <td style="border-collapse:collapse; border-left:1px solid #767171; border-right:1px solid #767171; padding:5px;" colspan="2">
                    <b>Subject:</b><br> 
                    {!! $item->subjek !!}
                </td>
            </tr>
            <tr>
                <td style="border-collapse:collapse; border-left:1px solid #767171; border-right:1px solid #767171; padding:5px;" colspan="2">
                    <b>Object:</b><br> 
                    {!! $item->objek !!}
                </td>
            </tr>
            <tr>
                <td style="border-collapse:collapse; border-left:1px solid #767171; border-right:1px solid #767171; padding:5px;" colspan="2">
                    <b>Assessment:</b><br> 
                    {!! $item->asesmen !!}
                </td>
            </tr>
            <tr>
                <td style="border-collapse:collapse; border-bottom:1px solid #767171; border-left:1px solid #767171; border-right:1px solid #767171; padding:5px;" colspan="2">
                    <b>Plan:</b><br> 
                    {!! $item->plan !!}
                </td>
            </tr>
        </table>
        <br>
    @endforeach
</body>

</html>
