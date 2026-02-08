<template>
    <div class="patient-data-form">
        <!-- Header Section -->
        <div class="header-section">
            <h2 class="form-title">
                {{ isEditMode ? 'Edit' : 'Tambah' }} Pengkajian Data Umum Pasien
            </h2>
            <div class="date-time-inputs">
                <div class="input-group">
                    <input
                        type="date"
                        v-model="formData.tanggal"
                        class="form-control"
                    />
                </div>
                <div class="input-group">
                    <input
                        type="time"
                        v-model="formData.waktu"
                        class="form-control"
                    />
                </div>
            </div>
        </div>

        <!-- Form Section -->
        <div class="form-section">
            <h3 class="section-title">Pengkajian Data Umum Pasien</h3>

            <div class="form-row">
                <!-- Left Column -->
                <div class="form-column">
                    <div class="form-group">
                        <label>NIK :</label>
                        <input
                            type="text"
                            v-model="formData.nik"
                            class="form-control"
                        />
                    </div>

                    <div class="form-group">
                        <label>Kode MR :</label>
                        <input
                            type="text"
                            v-model="formData.kodemr"
                            class="form-control"
                        />
                    </div>

                    <div class="form-group">
                        <label>Nama :</label>
                        <input
                            type="text"
                            v-model="formData.nama"
                            class="form-control"
                        />
                    </div>

                    <div class="form-group">
                        <label>Nama Suami / Istri :</label>
                        <input
                            type="text"
                            v-model="formData.nama_pasangan"
                            class="form-control"
                        />
                    </div>

                    <div class="form-group">
                        <label>NIK Suami / Istri :</label>
                        <input
                            type="text"
                            v-model="formData.nik_pasangan"
                            class="form-control"
                        />
                    </div>

                    <div class="form-group">
                        <label>Pekerjaan :</label>
                        <select
                            v-model="formData.pekerjaan"
                            class="form-control"
                        >
                            <option value="">Pilih Pekerjaan</option>
                            <option value="PNS">PNS</option>
                            <option value="Swasta">Swasta</option>
                            <option value="Wiraswasta">Wiraswasta</option>
                            <option value="Petani">Petani</option>
                            <option value="Ibu Rumah Tangga">
                                Ibu Rumah Tangga
                            </option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Alamat :</label>
                        <input
                            type="text"
                            v-model="formData.alamat"
                            class="form-control"
                        />
                    </div>
                </div>

                <!-- Right Column -->
                <div class="form-column">
                    <div class="form-group">
                        <label>Agama :</label>
                        <input
                            type="text"
                            v-model="formData.agama"
                            class="form-control"
                        />
                    </div>

                    <div class="form-group">
                        <label>Jenis Kelamin :</label>
                        <input
                            type="text"
                            v-model="formData.jenis_kelamin"
                            class="form-control"
                        />
                    </div>

                    <div class="form-group">
                        <label>Tempat Tanggal Lahir :</label>
                        <input
                            type="text"
                            v-model="formData.tempat_tanggal_lahir"
                            class="form-control"
                        />
                    </div>

                    <div class="form-group">
                        <label>Status Pembiayaan :</label>
                        <select
                            v-model="formData.status_pembiayaan"
                            class="form-control"
                        >
                            <option value="">Pilih Status</option>
                            <option value="BPJS">BPJS</option>
                            <option value="Umum">Umum</option>
                            <option value="Asuransi">Asuransi</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Status Perkawinan :</label>
                        <select
                            v-model="formData.status_perkawinan"
                            class="form-control"
                        >
                            <option value="">Pilih Status</option>
                            <option value="Menikah">Menikah</option>
                            <option value="Belum Menikah">Belum Menikah</option>
                            <option value="Cerai">Cerai</option>
                            <option value="Janda/Duda">Janda/Duda</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Pendidikan :</label>
                        <select
                            v-model="formData.pendidikan"
                            class="form-control"
                        >
                            <option value="">Pilih Pendidikan</option>
                            <option value="SD">SD</option>
                            <option value="SMP">SMP</option>
                            <option value="SMA">SMA</option>
                            <option value="D3">D3</option>
                            <option value="S1">S1</option>
                            <option value="S2">S2</option>
                            <option value="S3">S3</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="form-actions">
                <button
                    class="btn-save-form"
                    @click="submitForm"
                    :disabled="loadingSubmit"
                >
                    <span v-if="loadingSubmit">Menyimpan...</span>
                    <span v-else>{{ isEditMode ? 'Update' : 'Save' }}</span>
                </button>

                <button
                    class="btn-back"
                    @click="$emit('back')"
                    :disabled="loadingSubmit"
                >
                    Back
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: "CreatePengkajianData",

    props: {
        selectedPatient: {
            type: Object,
            required: true,
        },
        editData: {
            type: Object,
            default: null,
        },
        isEditMode: {
            type: Boolean,
            default: false,
        },
    },

    watch: {
        selectedPatient: {
            immediate: true,
            handler() {
                this.SetDataForm();
            },
        },
        editData: {
            immediate: true,
            handler(newVal) {
                if (newVal) {
                    this.loadEditData(newVal);
                }
            },
        },
    },

    data() {
        return {
            loadingSubmit: false,

            formData: {
                id: null, // ✅ GANTI: uuid menjadi id
                tanggal: this.getCurrentDate(),
                uuid_pasien: "",
                waktu: this.getCurrentTime(),
                nik: "",
                kodemr: "",
                nama: "",
                nama_pasangan: "",
                nik_pasangan: "",
                pekerjaan: "",
                alamat: "",
                agama: "",
                jenis_kelamin: "",
                tempat_tanggal_lahir: "",
                status_pembiayaan: "",
                status_perkawinan: "",
                pendidikan: "",
            },
        };
    },

    methods: {
        getCurrentDate() {
            const today = new Date();
            return today.toISOString().split('T')[0];
        },

        getCurrentTime() {
            const now = new Date();
            return now.toTimeString().split(' ')[0].substring(0, 5);
        },

        SetDataForm() {
            if (!this.isEditMode) {
                this.formData.uuid_pasien = this.selectedPatient?.uuid || "";
                this.formData.nama = this.selectedPatient?.nama || "";
                this.formData.nik = this.selectedPatient?.no_identitas || "";
                this.formData.kodemr = this.selectedPatient?.mr || "";
                this.formData.jenis_kelamin = this.selectedPatient?.jenis_kelamin || "";
                this.formData.agama = this.selectedPatient?.agama || "";
                this.formData.alamat = this.selectedPatient?.alamat || "";
            }
        },

        loadEditData(data) {
            this.formData = {
                id: data.id, // ✅ GANTI: uuid menjadi id
                tanggal: data.tanggal || this.getCurrentDate(),
                uuid_pasien: data.uuid_pasien || this.selectedPatient?.uuid,
                waktu: data.waktu || this.getCurrentTime(),
                nik: data.nik || "",
                kodemr: data.kodemr || "",
                nama: data.nama || "",
                nama_pasangan: data.nama_pasangan || "",
                nik_pasangan: data.nik_pasangan || "",
                pekerjaan: data.pekerjaan || "",
                alamat: data.alamat || "",
                agama: data.agama || "",
                jenis_kelamin: data.jenis_kelamin || "",
                tempat_tanggal_lahir: data.tempat_tanggal_lahir || "",
                status_pembiayaan: data.status_pembiayaan || "",
                status_perkawinan: data.status_perkawinan || "",
                pendidikan: data.pendidikan || "",
            };
        },

        async submitForm() {
            this.loadingSubmit = true;

            try {
                const fd = new FormData();

                // Set uuid_pasien
                this.formData.uuid_pasien = this.selectedPatient.uuid;

                // Append all form data
                Object.keys(this.formData).forEach((key) => {
                    if (this.formData[key] !== null && this.formData[key] !== undefined) {
                        fd.append(key, this.formData[key]);
                    }
                });

                let response;
                
                // ✅ GANTI: Check id bukan uuid
                if (this.isEditMode && this.formData.id) {
                    // UPDATE
                    response = await axios.post(
                        `/master/pasien/pengkajian-data-umum-update/${this.formData.id}`,
                        fd,
                        { headers: { "Content-Type": "multipart/form-data" } }
                    );
                    alert("Data berhasil diupdate!");
                } else {
                    // CREATE
                    response = await axios.post(
                        "/master/pasien/pengkajian-data-umum",
                        fd,
                        { headers: { "Content-Type": "multipart/form-data" } }
                    );
                    alert("Data berhasil disimpan!");
                }

                console.log("BERHASIL:", response.data);

                // Emit back to parent
                this.$emit("back");

            } catch (error) {
                console.error("ERROR:", error.response?.data || error);
                alert("Gagal menyimpan data: " + (error.response?.data?.message || error.message));
            } finally {
                this.loadingSubmit = false;
            }
        },
    },

    mounted() {
        this.SetDataForm();
    },
};
</script>

<style scoped>
/* ... style tetap sama ... */
.patient-data-form {
    background-color: #f5f5f5;
    min-height: 100vh;
    padding: 20px;
}

.header-section {
    background-color: white;
    padding: 20px;
    margin-bottom: 20px;
    border-radius: 4px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.form-title {
    color: #2196f3;
    font-size: 24px;
    font-weight: 600;
    margin: 0 0 15px 0;
    text-align: center;
}

.date-time-inputs {
    display: flex;
    gap: 15px;
    justify-content: center;
    align-items: center;
}

.input-group {
    flex: 0 0 200px;
}

.form-section {
    background-color: white;
    padding: 25px;
    border-radius: 4px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.section-title {
    color: #2196f3;
    font-size: 18px;
    font-weight: 500;
    margin: 0 0 20px 0;
    padding-bottom: 10px;
    border-bottom: 2px solid #e0e0e0;
}

.form-row {
    display: flex;
    gap: 30px;
}

.form-column {
    flex: 1;
}

.form-group {
    margin-bottom: 15px;
    display: flex;
    align-items: center;
}

.form-group label {
    flex: 0 0 180px;
    font-size: 14px;
    color: #333;
    font-weight: 500;
    text-align: right;
    padding-right: 15px;
}

.form-control {
    flex: 1;
    padding: 8px 12px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 14px;
    background-color: #f5f5f5;
    transition: border-color 0.3s;
}

.form-control:focus {
    outline: none;
    border-color: #2196f3;
    background-color: white;
}

.form-actions {
    margin-top: 30px;
    display: flex;
    gap: 10px;
    padding-top: 20px;
    border-top: 2px solid #e0e0e0;
}

.btn-save-form {
    background: #0288d1;
    color: white;
    padding: 10px 24px;
    border: none;
    border-radius: 4px;
    font-weight: bold;
    cursor: pointer;
    transition: background 0.2s;
}

.btn-save-form:hover:not(:disabled) {
    background: #0277bd;
}

.btn-save-form:disabled {
    background: #ccc;
    cursor: not-allowed;
}

.btn-back {
    background: #ff9800;
    color: white;
    padding: 10px 24px;
    border: none;
    border-radius: 4px;
    font-weight: bold;
    cursor: pointer;
    transition: background 0.2s;
}

.btn-back:hover:not(:disabled) {
    background: #f57c00;
}

@media (max-width: 768px) {
    .form-row {
        flex-direction: column;
        gap: 0;
    }

    .form-group {
        flex-direction: column;
        align-items: flex-start;
    }

    .form-group label {
        text-align: left;
        padding-right: 0;
        margin-bottom: 5px;
    }
}
</style>