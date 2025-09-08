<table border="1">
    <tr>
        <td>metode</td>
        <td>uuid</td>
        <td>nama</td>
        <td>label</td>
        <td>default</td>
        <td>harga</td>
    </tr>

    @foreach ($data as $row)
        <tr>
            <td>{{$metode}}</td>
            <td>{{$row->uuid}}</td>
            <td>{{$row->nama}}</td>
            <td>{{$row->jenis}}</td>
            <td>0</td>
            <td>0</td>
        </tr>
    @endforeach

</table>
