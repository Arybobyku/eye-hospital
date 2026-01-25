<table style="border-collapse: collapse; width: 100%;">
    {{-- HEADER --}}
    <tr style="border-top: 1px solid black; border-right: 1px solid black; border-left: 1px solid black;">
        <td style="padding: 0;">
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td style="border-right: 1px solid black; text-align: center; width: 30%;">
                    <img style="width:  60%; height: 100px; display: block; margin: 0 auto;"
                        src="data:image/png;base64,<?php echo base64_encode(file_get_contents($fullpath)); ?>" />
                    </td>

                    <td style="
                        border-right: 1px solid black;
                        width: 40%;
                        text-align: center;
                        vertical-align: middle;
                        font-weight: bold;">
                        CATATAN KUNJUNGAN DOKTER <br> (DOCTOR VISIT RECORD)
                    </td>

                    <td style="width: 30%;">
                        <table style="width: 100%; border: 0;">
                            <tr>
                                <td width="20%">Nama</td>
                                <td width="1%">:</td>
                                <td width="50%">{{ $pasien->nama }}</td>
                            </tr>
                            <tr>
                                <td width="20%">Tgl. Lahir</td>
                                <td width="1%">:</td>
                                <td width="50%">{{ $pasien->tanggal_lahir }}</td>
                            </tr>
                            <tr>
                                <td width="20%">No.RM</td>
                                <td width="1%">:</td>
                                <td width="50%">{{ $pasien->rekam_medis }}</td>
                            </tr>
                            <tr>
                                <td width="20%">Lantai/Kamar</td>
                                <td width="1%">:</td>
                                <td width="50%">{{ $pasien->no_identitas }}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
