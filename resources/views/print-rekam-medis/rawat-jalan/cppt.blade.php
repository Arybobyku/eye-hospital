<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>

<body>
    @foreach ($cppt as $item)
        
    <table style="border-collapse:collapse;   width:400px">
   
            <tr  style="border-collapse:collapse; border:1px solid #767171; width:100px;" >
                <td style="width:150px;  padding:5px;">Nama Pemeriksa </td>
                <td>: </td>
          
            </tr>
            <tr  style="border-collapse:collapse; border:1px solid #767171; width:100px;" >
                <td style="width:150px;  padding:5px;">Tanggal Pemeriksaan </td>
                <td>: @php
                    list($date, $time) = explode(' ', $item->created_at);
                    $timeWithoutMilliseconds = explode('.', $time)[0];
                @endphp {{ $date }} / {{ $timeWithoutMilliseconds }}</td>
              
            </tr>
            <tr>
                <td style="border-collapse:collapse; 
                border-left:1px solid #767171;
                border-right:1px solid #767171;  
                padding:5px;" colspan="2">
                    <b>Subject : </b><br> 
                    {!! $item->subjek !!}
                </td>
            </tr>
            <tr>
                <td style="border-collapse:collapse;
                 border-left:1px solid  #767171;
                  border-right:1px solid #767171;
                 
                
                padding:5px;" colspan="2">
                 <b>   Obect :</b> <br> 
                    {!! $item->objek !!}</td>
            </tr>
            <tr>
                <td style="border-collapse:collapse; 
                border-left:1px solid  #767171; 
                 border-right:1px solid #767171;
                
                padding:5px;" colspan="2">
                  <b>  Assessment : </b><br> 
                    {!! $item->asesmen !!}</td>
            </tr>
            <tr>
                <td style="border-collapse:collapse; 
                border-bottom:1px solid  #767171; 
                 border-left:1px solid  #767171; 
                 border-right:1px solid #767171;
                 padding:5px;" colspan="2">
                 <b>  Plan : </b><br> 
                    {!! $item->plan !!}</td>
            </tr>
       
    </table>
    <br>
    @endforeach
</body>

</html>
