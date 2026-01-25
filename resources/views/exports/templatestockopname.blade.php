<table border="1">
    <tr>
        <td>nama_penginput</td>
        <td>tanggal</td>
        <td>waktu</td>
        <td>unit</td>
        <td>uuid</td>
        <td>nama_obat_alkes</td>
        <td>jenis</td>
        <td>jumlah_fisik</td>
    </tr>

    @foreach ($data as $row)
        <tr>
            <td>{{$name}}</td>
            <td>{{$tanggal}}</td>
            <td>{{$waktu}}</td>
            <td>{{$row->nama_unit}}</td>
            <td>{{$row->obat_uuid}}</td>
            <td>{{$row->nama}}</td>
            <td>{{$row->jenis}}</td>
            <td>0</td>
        </tr>
    @endforeach

</table>
