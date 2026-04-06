<style>
  .nice-table {
    width: 100%;
    border-collapse: collapse;
    font-family: Arial, sans-serif;
    margin-top: 15px;
    background: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
  }

  .nice-table thead {
    background: #3498db;
    color: white;
  }

  .nice-table th,
  .nice-table td {
    padding: 10px 14px;
    text-align: left;
    font-size: 14px;
  }

  .nice-table tbody tr:nth-child(even) {
    background: #f7f9fc;
  }

  .nice-table tbody tr:hover {
    background: #eaf4ff;
    transition: 0.2s;
  }

  .nice-table th {
    letter-spacing: 0.5px;
    font-size: 13px;
    text-transform: uppercase;
  }
</style>
<template>
    
    <button @click="$emit('back')" class="btn-back">Kembali</button>

    <div class="container py-4">
        <!-- ================= HEADER ================= -->
        <div class="text-center mb-4">
            <h2 class="fw-bold">
                Detail Obat
            </h2>
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
                    <label>Kode RME :</label>
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
        <table class="nice-table">
  <thead>
    <tr>
      <th>NO</th>
      <th>NAMA OBAT</th>
      <th>JUMLAH</th>
    </tr>
  </thead>

  <tbody>
    <tr v-for="(item, index) in data" :key="item.id">
      <td>{{ index + 1 + (currentPage - 1) * perPage }}</td>
      <td>{{ item.nama_obat }}</td>
      <td>{{ item.jumlah_kecil }}</td>
    </tr>
  </tbody>
</table>
        <!-- ================= PEMBERIAN INFORMASI ================= -->
</div>
    <!-- ================= BUTTON BOTTOM ================= -->

    <div class="action-footer">
        <button class="btn-back" @click="$emit('back')">Back</button>
    </div>
</template>

<script>
import axios from "axios";
// import vueSignature from "vue-signature";
export default {
    name: "HistoryKunjungan",
    components: {
        // vueSignature,
    },

    data() {
        return {
            perPage: 10,
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
                date: "",
                time: "",
                kodeMR: "",
                nama: "",
                usia: "",
                alamat: "",
                petugas: "",
                pemberiInfo: "",
                penerimaInfo: "",
                isiInformasi: "",
            },
        };
    },
    props: {
        selectedPatient: {
            type: Object,
            required: true,
        },
        registrasi: {
            type: Object,
            required: true,
        },

    },

    watch: {
        selectedPatient: {
            immediate: true,
            handler(newVal) {
            },
        },
    },

    computed: {},
    mounted() {
        this.setDataForm();
        this.loadResep();
        console.log("Halo",this.registrasi);

    },

    methods: {
        async loadResep() {
            this.loading = true;

            try {
                const formData = new FormData();
                console.log("Halo",this.registrasi);
                formData.append("registrasiId", this.registrasi.uuid);
                formData.append("search", this.selectedPatient.uuid);
                formData.append("limit", 10);
                formData.append("page", 1);

                const res = await axios.post(
                    "/rme/pasien/detailobat",
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
