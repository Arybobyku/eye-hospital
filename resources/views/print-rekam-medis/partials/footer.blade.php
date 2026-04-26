@php
    $footerPath = storage_path('app/public/images/footer_rme.png');
@endphp

<div style="
    position: fixed;
    bottom: 10px; /* naik sedikit dari bawah */
    left: -20px; /* geser sedikit ke kiri */
    width: 110%; /* lebih lebar dari halaman biar mentok kiri-kanan */
    text-align: center;
    padding-top: 8px;
    margin: 0;
">
    <img 
        style="width: 100%; height: auto; display: block; margin: 0; padding: 0;" 
        src="data:image/png;base64,{{ base64_encode(file_get_contents($footerPath)) }}" 
        alt="Footer Image"
    >
</div>
