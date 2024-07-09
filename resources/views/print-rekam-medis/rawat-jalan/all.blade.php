<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Resume Medis</title>
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
            border:1px solid black;
            border-collapse: collapse;
        }
        .page_break{
    page-break-before: always;
}
    </style>

</head>

<body>
	@include('print-rekam-medis.rawat-jalan.rm1dot1')
    <div class="page_break"></div>
	@include('print-rekam-medis.rawat-jalan.rm1dot2') 
    <div class="page_break"></div>
	@include('print-rekam-medis.rawat-jalan.rm1dot3')
    <div class="page_break"></div>
	@include('print-rekam-medis.rawat-jalan.rm1dot4')
    <div class="page_break"></div>
	@include('print-rekam-medis.rawat-jalan.rm1dot5')
    <div class="page_break"></div>
	@include('print-rekam-medis.rawat-jalan.rm1dot6')
    <div class="page_break"></div>
	@include('print-rekam-medis.rawat-jalan.rm1dot7')
    <div class="page_break"></div>
	{{-- @include('print-rekam-medis.rawat-jalan.rm1dot8') --}}
</body>

</html>