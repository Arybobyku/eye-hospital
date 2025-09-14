<table border="1">
    <tr>
        <td>metode</td>
        <td>uuid</td>
        <td>label</td>
        <td>sub_label</td>
        <td>nama</td>
        <td>default</td>
        <td>harga</td>
    </tr>

    @foreach ($data as $row)
        <tr>
            <td>{{$metode}}</td>
            <td>{{$row->uuid}}</td>
            <td>{{$row->label}}</td>
            <td>{{$row->sub_label}}</td>
            <td>{{$row->nama}}</td>
            <td>0</td>
            <td>{{$row->harga}}</td>
        </tr>
    @endforeach

</table>
