<table style="border-collapse: collapse;">
    {{-- HEADER --}}
    <tr style="border-top: 1px solid black; border-right: 1px solid black; border-left: 1px solid black;">
        <div style="width: 100%;">
            <table style="width: 100%;">
                <tr>
                    <td style="border-right: 1px solid black; width:50%">
                        <img style="width: 100%;"
                            src="data:image/png;base64,
            <?php echo base64_encode(file_get_contents($fullpath)); ?>" />
                    </td>
                    <td style="
                      border-right: 1px solid black;
                      width: 50%;
                      text-align: center;
                      vertical-align: middle;">
                      <b>PROSES PERAWATAN PERI – OPERATIVE</b> <br><i>(Peri – Operative Care Proces)</i>
                    </td>
                    <td style="width: 50%">
                        <table style="width: 100%" border="0">
                            <tr>
                                <td width="20%">Nama</td>
                                <td width="1%">:</td>
                                <td width=50%>{{ $pasien->nama }}</td>
                            </tr>
                            <tr>
                                <td width="20%">Tgl. Lahir</td>
                                <td width="1%">:</td>
                                <td width=50%>{{ $pasien->tanggal_lahir }}</td>
                            </tr>
                            <tr>
                                <td width="20%">No.RM</td>
                                <td width="1%">:</td>
                                <td width=50%>{{ $pasien->rekam_medis }}</td>
                            </tr>
                            <tr>
                                <td width="10%">NIK</td>
                                <td width="1%">:</td>
                                <td width=50%>{{ $pasien->no_identitas }}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </tr>
</table>