<template>
    <button @click="$emit('back')" class="btn-back">Kembali</button>

    <div class="container py-4">
        <!-- ================= HEADER ================= -->
        <div class="text-center mb-4">
            <h2 class="fw-bold">
                Surat Persetujuan / Penolakan Tindakan Medis
            </h2>
            <h4 class="fw-semibold">(Informed Consent)</h4>
        </div>

        <!-- DATE & TIME -->
        <div class="row mb-3">
            <div class="col-md-6 mb-2">
                <input type="date" v-model="form.date" class="form-control" readonly />
            </div>
            <div class="col-md-6 mb-2">
                <input type="time" v-model="form.time" class="form-control" readonly />
            </div>
        </div>

        <!-- ================= INFORMASI PASIEN ================= -->
        <div class="box-rme mb-4">
            <h5 class="section-title-rme">Informasi Pasien</h5>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label>Kode MR :</label>
                    <input type="text" v-model="form.kodeMR" class="input-rme" readonly />
                </div>

                <div class="col-md-6">
                    <label>Nama Pasien :</label>
                    <input type="text" v-model="form.nama" class="input-rme" readonly />
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <label>Usia :</label>
                    <input type="text" v-model="form.usia" class="input-rme" readonly />
                </div>

                <div class="col-md-6">
                    <label>Alamat :</label>
                    <input type="text" v-model="form.alamat" class="input-rme" readonly />
                </div>
            </div>
        </div>

        <!-- ================= PEMBERIAN INFORMASI ================= -->
        <div class="box-rme mb-4">
            <h5 class="section-title-rme">Pemberian Informasi</h5>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label>Petugas Pelaksana Tindakan :</label>
                    <input type="text" v-model="form.petugas" class="input-rme" />
                </div>

                <div class="col-md-6">
                    <label>Pemberi Informasi :</label>
                    <input type="text" v-model="form.nama_pemberi_informasi" class="input-rme" />
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-md-12">
                    <label>Penerima Informasi :</label>
                    <input type="text" v-model="form.nama_penerima_informasi" class="input-rme" />
                </div>
            </div>

            <p class="small mt-1">
                *) Bila pasien tidak kompeten atau tidak mau menerima informasi,
                maka penerima informasi adalah wali/keluarga terdekat.
            </p>

            <!-- ================= TABLE INFORMASI ================= -->
            <b style="color: blue;">
                <center>
                    PASIEN / WALI PASIEN HARUS MEMBACA, MEMAHAMI DAN MENGISI
                    INFORMASI BERIKUT
                </center>
            </b>

            <br />

            <div style="
                    width: 100%;
                    text-align: center;
                    margin-top: -14px;
                    margin-bottom: 3px;
                    font-weight: bold;
                ">
                PERSETUJUAN UMUM (GENERAL CONSENT)
            </div>

            <div style="width: 100%; height: 1px; background: #353535"></div>
            <br />

            <div style="
                    width: 100%;
                    text-align: center;
                    margin-top: 0px;
                    line-height: 21px;
                    margin-bottom: 3px;
                    font-weight: bold;
                ">
                PASIEN/KELUARGA DAN ATAU WALI HUKUM HARUS MEMBACA, MEMAHAMI DAN
                MENGISI INFORMASI BERIKUT
            </div>

            <table style="width: 100%; margin-top: 20px" cellpadding="0" cellspacing="0">
                <tr>
                    <td style="width: 100%">
                        <b>1. PERSETUJUAN UNTUK PERAWATAN DAN PENGOBATAN</b>
                    </td>
                </tr>
                <tr>
                    <td style="
                            width: 100%;
                            font-size: 12pt;
                            line-height: 22px;
                            padding-top: 10px;
                            text-align: justify;
                        ">
                        &nbsp;&nbsp;&nbsp;&nbsp;Saya menyetujui untuk
                        mendapatkan perawatan di Rumah Sakit Khusus Prima Vision
                        Medan sebagai pasien rawat jalan/rawat inap tergantung
                        kepada kebutuhan medis. Pengobatan dapat meliputi
                        pemeriksaan visus, tonometri dan prosedur rutin seperti
                        cairan infuse atau suntikan dan evaluasi (wawancara dan
                        pemeriksaan fisik).
                    </td>
                </tr>
                <tr>
                    <td style="
                            width: 100%;
                            font-size: 12pt;
                            line-height: 22px;
                            padding-top: 5px;
                            text-align: justify;
                        ">
                        Persetujuan yang saya berikan tidak termasuk persetujuan
                        untuk prosedur/tindakan invasif (misalnya operasi) atau
                        tindakan yang mempunyai resiko tingi.
                    </td>
                </tr>
                <tr>
                    <td style="
                            width: 100%;
                            font-size: 12pt;
                            line-height: 22px;
                            padding-top: 5px;
                            text-align: justify;
                        ">
                        Jika saya memutuskan untuk menghentikan perawatan medis
                        untuk diri saya, saya memahami dan menyadari bahwa Rumah
                        Sakit Khusus Mata Prima Vision ataupun dokter tidak
                        bertanggung jawab atau hasil yang merugikan saya.
                    </td>
                </tr>
                <tr>
                    <td style="width: 100%; padding-top: 15px">
                        <b>2. PERSETUJUAN PELEPASAN INFORMASI</b>
                    </td>
                </tr>
                <tr>
                    <td style="
                            width: 100%;
                            font-size: 12pt;
                            line-height: 22px;
                            padding-top: 10px;
                            text-align: justify;
                        ">
                        &nbsp;&nbsp;&nbsp;&nbsp;Saya memahami informasi yang ada
                        di dalam Saya, termasuk diagnosis, hasil laboratorium
                        dan hasil tes diagnostic yang digunakan untuk perawatan
                        medis, Rumah Sakit Khusus Mata Prima Vision Medan akan
                        menjamin kerahasiannya.
                    </td>
                </tr>
                <tr>
                    <td style="
                            width: 100%;
                            font-size: 12pt;
                            line-height: 22px;
                            padding-top: 5px;
                            text-align: justify;
                        ">
                        Saya memberi wewenang kepada Rumah Sakit Khusus Mata
                        Prima Vision Medan untuk memberikan informasi tentang
                        diagnosis, hasil pelayanan dan pengobatan bila
                        diperlukan untuk memproses klaim asuransi/perusahaan
                        atau lembaga pemerintah.
                    </td>
                </tr>
                <tr>
                    <td style="
                            width: 100%;
                            font-size: 12pt;
                            line-height: 22px;
                            padding-top: 5px;
                            text-align: justify;
                        ">
                        Saya memberi wewenang kepada Rumah Sakit Khusus Mata
                        Prima Vision Medan untuk memberikan informasi tentang
                        diagnosis, hasil pelayanan dan pengobatan saya kepada
                        anggota keluarga saya
                    </td>
                </tr>
                <tr>
                    <td style="width: 100%; padding-top: 15px">
                        <b>3. HAK DAN TANGGUNG JAWAB PASIEN</b>
                    </td>
                </tr>
                <tr>
                    <td style="
                            width: 100%;
                            font-size: 12pt;
                            line-height: 22px;
                            padding-top: 10px;
                            text-align: justify;
                        ">
                        &nbsp;&nbsp;&nbsp;&nbsp;Saya memiliki hak untuk
                        mengambil bagian dalam keputusan mengenai penyakit saya
                        dalam hal perawatan medis dan rencana pengobatan. Saya
                        telah mendapat informasi tentang Hak dan tanggung Jawab
                        Pasien Rumah Sakit Khusus Mata Prima Vision Medan
                        melalui leaflet dan banner yang disediakan petugas.
                    </td>
                </tr>
                <tr>
                    <td style="
                            width: 100%;
                            font-size: 12pt;
                            line-height: 22px;
                            padding-top: 5px;
                            text-align: justify;
                        ">
                        Saya memahami bahwa Rumah Sakit Khusus Mata Prima Vision
                        Medan tidak bertanggung jawab atas kehilangan
                        barang-barang pribadi dan barang yang dibawa ke Rumah
                        Sakit Khusus Mata Prima Vision Medan
                    </td>
                </tr>

                <tr>
                    <td style="
                            width: 100%;
                            font-size: 12pt;
                            line-height: 22px;
                            padding-top: 5px;
                            text-align: justify;
                        ">
                        Saya memahami bahwa Rumah Sakit Khusus Mata Prima Vision
                        Medan tidak memperbolehkan pendokumentasian semua
                        tindakan yang dilakukan di Rumah Sakit Khusus Mata Prima
                        Vision, baik berbentuk Foto/Video/Audio (Sesuai UU
                        Praktik Kedokteran No. 29/2004 Pasal 48 dan 51, UU
                        Telekomunikasi No. 36/1999).
                    </td>
                </tr>
                <tr>
                    <td style="width: 100%; padding-top: 15px">
                        <b>4. INFORMASI RAWAT INAP</b>
                    </td>
                </tr>
                <tr>
                    <td style="
                            width: 100%;
                            font-size: 12pt;
                            line-height: 22px;
                            padding-top: 10px;
                            text-align: justify;
                        ">
                        &nbsp;&nbsp;&nbsp;&nbsp;Saya telah menerima informasi
                        tentang peraturan yang telah diberlakukan oleh Rumah
                        Sakit Khusus Mata Prima Vision Medan dan saya beserta
                        keluarga bersedia untuk mematuhinya, termasuk mematuhi
                        berkunjung pasien sesuai dengan aturan di Rumah Sakit
                        Khusu Mata Prima Vision Medan.
                    </td>
                </tr>
                <tr>
                    <td style="
                            width: 100%;
                            font-size: 12pt;
                            line-height: 22px;
                            padding-top: 5px;
                            text-align: justify;
                        ">
                        Anggota keluarga saya yang menunggu saya bersedia untuk
                        selalu memakai tanda pengenal khusus yang diberikan
                        Rumah Sakit Khusus Mata Prima Vision Medan, dan demi
                        keamanan seluruh pasien setiap keluarga dan siapapun
                        yang akan mengunjungi saya diluar jam berkunjung
                        bersedia untuk diminta/diperiksa identitasnya dan
                        memakai identitas yang diberikan Rumah Sakit Khusus Mata
                        Prima Vision Medan.
                    </td>
                </tr>
                <tr>
                    <td style="
                            width: 100%;
                            font-size: 12pt;
                            line-height: 22px;
                            padding-top: 5px;
                            text-align: justify;
                        ">
                        Saya memahami bahwa saya dapat memilih turun kelas
                        perawatan apabila kamar perawatan yang menjadi hak saya
                        sesuai fasilitas kartu BPJS saya tidak akan tersedia.
                        Dan saya telah memahami apa yang menjadi kewajiban dan
                        hak saya memilih hal tersebut. Dan saya bersedia
                        mengikuti peraturan Rumah Sakit Khusus Mata Prima Vision
                        Medan yang berlaku saat ini.
                    </td>
                </tr>

                <tr>
                    <td style="width: 100%; padding-top: 15px">
                        <b>5. BIAYA PERAWATAN</b>
                    </td>
                </tr>
                <tr>
                    <td style="
                            width: 100%;
                            font-size: 12pt;
                            line-height: 22px;
                            padding-top: 10px;
                            text-align: justify;
                        ">
                        &nbsp;&nbsp;&nbsp;&nbsp;Saya menyatakan setuju sebagai
                        pasien/penanggung jawab dengan status umum untuk
                        membayar total biaya perawatan yang diberikan sesuai
                        rincian biaya dan ketentuan Rumah Sakit Khusus Mata
                        Prima Vision Medan.
                    </td>
                </tr>
                <tr>
                    <td style="
                            width: 100%;
                            font-size: 12pt;
                            line-height: 22px;
                            padding-top: 5px;
                            text-align: justify;
                        ">
                        Saya menyatakan setuju sebagai pasien/penanggung jawab
                        pasien dengan biaya ditanggung penjamin untuk segera
                        melengkapi berkas persyaratan administrasi paling lambat
                        3x24 jam.
                    </td>
                </tr>
                <tr>
                    <td style="
                            width: 100%;
                            font-size: 12pt;
                            line-height: 22px;
                            padding-top: 5px;
                            text-align: justify;
                        ">
                        Saya telah membaca isi dari pernyataan ini/telah
                        dibacakan isi dari pernyataan ini, dan saya telah
                        memahami isi dari pernyataan ini. Dan semua pernyataan
                        saya telah dijawab dengan jelas.
                    </td>
                </tr>
            </table>


        </div>

        <!-- ================= Persetujuan tindakan dokter ================= -->
      <div class="tanggal-tempat">MEDAN, {{ currentDate }} WIB</div>
          

        <div class="signature-section">
        <!-- Yang Menyatakan -->
        <div class="sign-box" style="height: 200px">
          <label>Pemberi Informasi</label>
          <br>
          <label>RS Khusus Mata Prima Vision</label>

          <VueSignaturePad
            ref="pemberi_inf_ttd"
            :options="sigOption"
            class="signature-box-rme"
          />

          <button @click="saveSign('pemberi_inf_ttd')" class="btn-save">
            Simpan ✔
          </button>

          <input
            v-model="form.nama_terang_pemberi_inf"
            class="input-rme"
            placeholder="Tanda Tangan dan Nama Terang"
          />
        </div>

        <!-- Saksi 1 -->
        <div class="sign-box" style="height: 200px">
          <label>Penerima Informasi</label>
          <br>
          <label>(Pasien/Keluarga Pasien)</label>

          <VueSignaturePad
            ref="pasien_ttd"
            :options="sigOption"
            class="signature-box-rme"
          />

          <button @click="saveSign('pasien_ttd')" class="btn-save">Simpan ✔</button>

          <input
            v-model="form.nama_terang_pasien"
            class="input-rme"
            placeholder="Tanda Tangan dan Nama Terang"
          />
        </div>

      </div>
        </div>
    <!-- ================= BUTTON BOTTOM ================= -->
    <br>
    <br>
    <br>
    <div class="action-footer">
        <button class="btn-save-form" @click="submitForm" :disabled="loadingSubmit">
      <span v-if="loadingSubmit">Menyimpan...</span>
      <span v-else>Save</span>
    </button>
        <button class="btn-back" @click="$emit('back')">Back</button>
    </div>
</template>

<script>
import axios from "axios";
export default {
    name: "HistoryKunjungan",
    components: {
    },

    data() {
        const now = new Date();
        return {
            currentDate:
            now.toLocaleDateString('en-GB') + ' ' +
            now.toLocaleTimeString('en-GB', { hour: '2-digit', minute: '2-digit' }),
            perPage: 10,
            loadingSubmit: false,
            currentPage: 1,
            searchQuery: "",
            loading: false,
            sigOption: {
                penColor: "black",
                backgroundColor: "white",
            },
            data: [],
            form: {
                uuid_pasien: "",
                nama_pemberi_informasi: "",
                nama_penerima_informasi: "",
                nama_terang_pasien: "",
                nama_terang_pemberi_inf: "",
                nama_terang_pasien: "",
                pasien_ttd: "",
                pemberi_inf_ttd: "",
                kodeMR: "",
                nama: "",
                nik: "",
                tanggal_lahir: "",
                jenis_kelamin: ""
            },
        };
    },
    props: {
        selectedPatient: {
            type: Object,
            required: true,
        },
    },

    watch: {
        selectedPatient: {
            immediate: true,
            handler(newVal) {
                // if (newVal?.id) {
                //   this.fetchHistory();
                // }
            },
        },
    },

    computed: {},
    mounted() {
        this.setDataForm();
    },

    methods: {
        async saveData() {
            this.loading = true;

            try {
                const formData = new FormData();
                formData.append("search", this.selectedPatient.uuid);
                formData.append("limit", 10);
                formData.append("page", 1);

                const res = await axios.post(
                    "/master/pasien/history",
                    formData,
                    {
                        headers: {
                            "Content-Type": "multipart/form-data",
                        },
                    }
                );

                // 👇 pastikan data backend berupa array
                this.data = res.data?.data ?? [];
            } catch (err) {
                console.error("Gagal memuat history:", err);
                alert("Gagal memuat data history.");
            } finally {
                this.loading = false;
            }
        },
        formatDate(d) {
            return d.toISOString().split("T")[0];
        },

        formatTime(d) {
            return d.toTimeString().substring(0, 5);
        },
        setDataForm() {
            this.form.date = this.formatDate(new Date());
            this.form.time = this.formatTime(new Date());
            this.form.uuid_pasien = this.selectedPatient?.uuid;
            this.form.kodeMR = this.selectedPatient?.rekam_medis;
            this.form.nama = this.selectedPatient?.nama;
            this.form.usia = this.selectedPatient?.tanggal_lahir;
            this.form.alamat = this.selectedPatient?.alamat;
        },
          saveSign(refName) {
      const pad = this.$refs[refName];

      if (!pad) {
        console.error("REF tidak ditemukan:", refName);
        return;
      }

      // fungsi yang benar untuk vue-signature-pad
      const { isEmpty, data } = pad.saveSignature();

      if (isEmpty) {
        alert("Tanda tangan masih kosong!");
        return;
      }

      this.form[refName] = data; // base64 string

      console.log("TTD saved:", refName);
    },
        async submitForm() {
            this.loadingSubmit = true;

            try {
                const fd = new FormData();

                Object.keys(this.form).forEach((key) => {
                fd.append(key, this.form[key]);
                });

                console.log("PERSETUJUAN UMUM: ",fd);

                const response = await axios.post(
                "/master/pasien/dokumen-persetujuan-umum",
                fd,
                { headers: { "Content-Type": "multipart/form-data" } }
                );

                console.log("BERHASIL:", response.data);

                // tampilkan notif
                alert("Data berhasil disimpan!");

                // kembali ke parent component
                this.$emit("back");
            } catch (error) {
                console.error("ERROR:", error.response?.data || error);
                alert("Gagal menyimpan data!");
            } finally {
                this.loadingSubmit = false;
            }
        },
    },
};
</script>

<style scoped>
.box-rme {
    border: 1px solid #dcdcdc;
    padding: 20px;
    border-radius: 6px;
}

.section-title-rme {
    font-weight: bold;
    margin-bottom: 10px;
    color: #2d74b7;
}

.input-rme {
    width: 100%;
    border: 1px solid #ccc;
    border-radius: 4px;
    padding: 6px;
    background: #f4f4f4;
}

.textarea-rme {
    width: 100%;
    min-height: 80px;
    border: 1px solid #ccc;
    border-radius: 4px;
    padding: 6px;
}

.info-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.info-table th,
.info-table td {
    border: 1px solid #ccc;
    padding: 8px;
}

.signature-box-rme {
    width: 180px;
    height: 90px;
    border: 1px solid #aaa;
    margin-bottom: 8px;
}

.btn-rme {
    background: #2d74b7;
    color: #fff;
    padding: 4px 12px;
    border-radius: 4px;
}

/* LOADING OVERLAY */
.loading-overlay {
    position: absolute;
    inset: 0;
    background: rgba(255, 255, 255, 0.8);
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    font-size: 18px;
    z-index: 10;
}

.spinner-rme {
    width: 32px;
    height: 32px;
    border: 4px solid #ddd;
    border-top-color: #1d72c9;
    border-radius: 50%;
    animation: spin-rme 0.8s linear infinite;
    margin-bottom: 10px;
}

.consent-container {
    padding: 20px;
    background: white;
}

.input-rme {
    padding: 4px 8px;
    border: 1px solid #ccc;
}

.input-rme.small {
    width: 80px;
}

.input-rme.large {
    width: 250px;
}

.signature-section {
    display: flex;
    justify-content: space-between;
    margin-top: 30px;
}

.sign-box {
    width: 30%;
    text-align: center;
}

.signature-box-rme {
    width: 100%;
    height: 160px;
    border: 1px solid #999;
    margin-bottom: 10px;
}

.btn-save {
    background: #1e88e5;
    color: white;
    padding: 5px 12px;
    border: none;
    margin-bottom: 10px;
    cursor: pointer;
}

.action-footer {
    margin-top: 90px;
    display: flex;
    justify-content: flex-end;
    /* tombol ke kanan */
    gap: 12px;
    /* jarak antar tombol */
}

.btn-save-form {
    background: #0288d1;
    color: white;
    padding: 8px 18px;
    border: none;
    border-radius: 4px;
    font-weight: bold;
    cursor: pointer;
}

.btn-back {
    background: #ff9800;
    color: white;
    padding: 8px 18px;
    border: none;
    border-radius: 4px;
    font-weight: bold;
    cursor: pointer;
}

@keyframes spin-rme {
    to {
        transform: rotate(360deg);
    }
}
</style>
