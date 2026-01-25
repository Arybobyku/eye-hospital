<table border="1">
    <tr>
        <td>name</td>
        <td>label</td>
        <td>sublabel</td>
        <td>uuid</td>
        <td>carabayar_uuid</td>
        <td>carabayar</td>
        <td>nama</td>
        <td>jenis</td>
        <td>quantity</td>
        <td>harga</td>
    </tr>

    @foreach ($data as $row)
        <tr>
            <td>{{$name}}</td>
            <td>{{$row->jenis}}</td>
            <td>{{$row->jenis}}</td>
            <td>{{$row->uuid}}</td>
            <td>{{$row->carabayar_uuid}}</td>
            <td>{{$row->carabayar_nama}}</td>
            <td>{{$row->nama_tindakan_rawat_jalan}}</td>
            <td>{{$row->jenis}}</td>
            <td>1</td>
            <td>{{$row->harga}}</td>
        </tr>
    @endforeach

</table>
