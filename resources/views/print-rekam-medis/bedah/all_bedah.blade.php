<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Resume Medis Bedah</title>
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
	@include('print-rekam-medis.bedah.rm1dot8')
    <div class="page_break"></div>
	@include('print-rekam-medis.bedah.rm1dot9') 
    <div class="page_break"></div>
	@include('print-rekam-medis.bedah.rm1dot10')
    <div class="page_break"></div>
	@include('print-rekam-medis.bedah.rm2dot0')
    <div class="page_break"></div>
	@include('print-rekam-medis.bedah.rm2dot2')
    <div class="page_break"></div>
	@include('print-rekam-medis.bedah.rm2dot3')
    <div class="page_break"></div>
	@include('print-rekam-medis.bedah.rm2dot9')
    <div class="page_break"></div>
    @include('print-rekam-medis.bedah.rm4dot9')
    <div class="page_break"></div>
    @include('print-rekam-medis.bedah.rm8dot7')
    <div class="page_break"></div>
    @include('print-rekam-medis.bedah.rm8dot8')
    <div class="page_break"></div>
    @include('print-rekam-medis.bedah.rm8dot9')
    <div class="page_break"></div>
    @include('print-rekam-medis.bedah.rm8dot10')
    <div class="page_break"></div>
    @include('print-rekam-medis.bedah.rm9dot0')
    <div class="page_break"></div>
    @include('print-rekam-medis.bedah.rm9dot1')
    <div class="page_break"></div>
</body>

</html>