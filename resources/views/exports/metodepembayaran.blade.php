<table border="1">
    <tr>
        <td colspan="18">Daftar Metode Pembayaran RS Prima Vision</td>
    </tr>
    <tr>
        {{-- <td colspan="18">Periode {{ tglse($dari) }} sampai {{ tglse($ke) }}</td> --}}
    </tr>
    <tr>
        <td>Metode Pembayaran</td>
        <td>Tindakan</td>
        <td>Label</td>
        <td>Default</td>
        <td>Harga</td>
    </tr>

    @foreach ($data as $row)
        @php
            $count = count($row->tindakanrawatjalan);
        @endphp

        @foreach ($row->tindakanrawatjalan as $i => $rj)
            <tr>
                {{-- tampilkan hanya sekali lalu merge ke bawah --}}
                {{-- @if ($i === 0)
                    <td rowspan="{{ $count }}">{{ $row->nama }}</td>
                @endif --}}
                <td>{{ $row->nama }}</td>
                <td>{{ $rj->nama_tindakan_rawat_jalan }}</td>
                <td>{{ $rj->jenis }}</td>
                <td>{{ $rj->default }}</td>
                <td>{{ $rj->harga }}</td>
            </tr>
        @endforeach
    @endforeach

</table>
