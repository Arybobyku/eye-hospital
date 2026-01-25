<table border="1">
    <tr>
        <td>nama paket bedah</td>
        <td>label</td>
        <td>sub label</td>
        <td>nama</td>
        <td>quantity</td>
        <td>harga</td>
        <td>status</td>
    </tr>

    @foreach ($data as $row)
        <tr>
            <td>{{$row->nama_paket_bedah ?? "-"}}</td>
            <td>{{$row->label}}</td>
            <td>{{$row->sub_label}}</td>
            <td>{{$row->nama}}</td>
            <td>{{$row->quantity}}</td>
            <td>{{$row->harga}}</td>
            <td>{{$row->status}}</td>
        </tr>
    @endforeach

</table>
