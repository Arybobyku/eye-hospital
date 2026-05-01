
<style scoped>
.dropdown-dokter {
  position: relative;
  width: 100%;
}
.btn-clear {
  background: #f44336;
  color: white;
  padding: 6px 12px;
  border: none;
  border-radius: 4px;
  margin-top: 10px;
  cursor: pointer;
  font-size: 12px;
  transition: background 0.3s;
}

.btn-clear:hover {
  background: #d32f2f;
}

.form-select-dokter {
  width: 100%;
  padding: 10px 40px 10px 14px;
  font-size: 14px;
  color: #2d3748;
  background-color: #fff;
  border: 1.5px solid #cbd5e0;
  border-radius: 10px;
  appearance: none;
  -webkit-appearance: none;
  cursor: pointer;
  transition: border-color 0.2s, box-shadow 0.2s;
  outline: none;
}

.form-select-dokter:focus {
  border-color: #667eea;
  box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.2);
}

.form-select-dokter:hover {
  border-color: #a0aec0;
}

.dropdown-icon {
  position: absolute;
  right: 14px;
  top: 50%;
  transform: translateY(-50%);
  color: #718096;
  font-size: 16px;
  pointer-events: none;
}

/* CSS UNTUK MASUKKAN POTO GES */
.foto-operasi-container {
  border: 1px dashed #cbd5e0;
  border-radius: 8px;
  padding: 15px;
  background: #f8fafc;
  margin-top: 10px;
}

.btn-group-upload {
  display: flex;
  gap: 10px;
  flex-wrap: wrap;
}

.btn-upload {
  background: #0288d1;
  color: white;
  padding: 8px 16px;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  font-size: 13px;
  font-weight: 500;
  transition: all 0.2s;
  display: flex;
  align-items: center;
}

.btn-upload:hover {
  background: #0277bd;
  transform: translateY(-1px);
}

.btn-camera {
  background: #2e7d32;
  color: white;
  padding: 8px 16px;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  font-size: 13px;
  font-weight: 500;
  transition: all 0.2s;
  display: flex;
  align-items: center;
}

.btn-camera:hover {
  background: #1b5e20;
  transform: translateY(-1px);
}

.foto-preview-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
  gap: 15px;
  margin-top: 15px;
}

.foto-item {
  position: relative;
  border: 1px solid #e2e8f0;
  border-radius: 8px;
  overflow: hidden;
  background: white;
  transition: all 0.2s;
}

.foto-item:hover {
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.foto-thumbnail {
  width: 100%;
  height: 150px;
  object-fit: cover;
  display: block;
}

.foto-label {
  display: block;
  text-align: center;
  padding: 5px;
  font-size: 12px;
  color: #718096;
  background: #f7fafc;
}

.btn-hapus-foto {
  position: absolute;
  top: 5px;
  right: 5px;
  background: rgba(220, 38, 38, 0.9);
  color: white;
  border: none;
  border-radius: 50%;
  width: 25px;
  height: 25px;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  font-size: 12px;
  transition: all 0.2s;
  padding: 0;
}

.btn-hapus-foto:hover {
  background: rgba(185, 28, 28, 1);
  transform: scale(1.1);
}

</style>

<template>
  <div>
    <button @click="$emit('back')" class="btn-back">Kembali</button>

    <div class="container py-4">
      <!-- ================= HEADER ================= -->
      <div class="text-center mb-4">
        <h2 class="fw-bold">LAPORAN PEMBEDAHAN</h2>
        <p class="text-muted">RM 2.2/LP/22</p>
      </div>

      <!-- ================= INFORMASI PASIEN ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Informasi Pasien</h5>

        <div class="row mb-3">
          <div class="col-md-6">
            <label>No. RM :</label>
            <input type="text" v-model="form.no_rm" class="input-rme" readonly />
          </div>
          <div class="col-md-6">
            <label>NIK :</label>
            <input type="text" v-model="form.nik" class="input-rme" readonly />
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-6">
            <label>Nama Pasien :</label>
            <input type="text" v-model="form.nama" class="input-rme" readonly />
          </div>
          <div class="col-md-6">
            <label>Tanggal Lahir :</label>
            <div class="d-flex gap-2">
              <input
                type="date"
                v-model="form.tanggal_lahir"
                class="input-rme"
                readonly
              />
              <div class="col-md-6">
            <label>Jenis Kelamin :</label>
            <input
              type="text"
              v-model="form.jenis_kelamin"
              class="input-rme"
              readonly />
          </div>
            </div>
          </div>
        </div>
      </div>

      <!-- ================= INFORMASI OPERASI ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Informasi Operasi</h5>

        <div class="row mb-3">
          <div class="col-md-4">
            <label>Ruang Operasi :</label>
            <input type="text" v-model="form.ruang_operasi" class="input-rme" />
          </div>
          <div class="col-md-4">
            <label>Kamar :</label>
            <input type="text" v-model="form.kamar" class="input-rme" />
          </div>
          <div class="col-md-4">
            <label>Tanggal :</label>
            <input type="date" v-model="form.tanggal_operasi" class="input-rme" />
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-6">
            <label>Jenis Operasi :</label>
            <div class="d-flex gap-3">
              <label class="radio-label">
                <input type="radio" v-model="form.jenis_operasi" value="akut" /> Akut
              </label>
              <label class="radio-label">
                <input type="radio" v-model="form.jenis_operasi" value="terencana" />
                Terencana
              </label>
            </div>
          </div>
        </div>
      </div>

      <!-- ================= TIM MEDIS ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Tim Medis</h5>

        <div class="row mb-3">
          <div class="col-md-6">
            <label>Pembedahan :</label>
            <input type="text" v-model="form.pembedahan" class="input-rme" />
          </div>
          <div class="col-md-6">
            <label>Ahli Anestesi :</label>
            <input type="text" v-model="form.ahli_anestesi" class="input-rme" />
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-4">
            <label>Asisten I :</label>
            <input type="text" v-model="form.asisten_1" class="input-rme" />
          </div>
          <div class="col-md-4">
            <label>Asisten II :</label>
            <input type="text" v-model="form.asisten_2" class="input-rme" />
          </div>
          <div class="col-md-4">
            <label>Perawat Instrument :</label>
            <input type="text" v-model="form.perawat_instrument" class="input-rme" />
          </div>
        </div>
      </div>

      <!-- ================= JENIS ANESTESI ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Jenis Anestesi</h5>

        <div class="row">
          <div class="col-md-12">
            <div class="checkbox-grid">
              <label class="checkbox-label">
                <input type="checkbox" v-model="form.anestesi_umum" /> Umum
              </label>
              <label class="checkbox-label">
                <input type="checkbox" v-model="form.anestesi_spiral" /> Spiral
              </label>
              <label class="checkbox-label">
                <input type="checkbox" v-model="form.anestesi_epidural" /> Epidural
              </label>
              <label class="checkbox-label">
                <input type="checkbox" v-model="form.anestesi_bsp" /> BSP*
              </label>
              <label class="checkbox-label">
                <input type="checkbox" v-model="form.anestesi_csp" /> CSP*
              </label>
              <label class="checkbox-label">
                <input type="checkbox" v-model="form.anestesi_lokal" /> Lokal
              </label>
            </div>
          </div>
        </div>
      </div>

      <!-- ================= DIAGNOSA ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Diagnosa dan Indikasi</h5>

        <div class="row mb-3">
          <div class="col-md-6">
            <label>Indikasi Operasi :</label>
            <textarea
              v-model="form.indikasi_operasi"
              class="textarea-rme"
              rows="3"
            ></textarea>
          </div>
          <div class="col-md-6">
            <label>Diagnosa Pra-Bedah :</label>
            <textarea
              v-model="form.diagnosa_pra_bedah"
              class="textarea-rme"
              rows="3"
            ></textarea>
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-6">
            <label>Diagnosa Pasca-Bedah :</label>
            <textarea
              v-model="form.diagnosa_pasca_bedah"
              class="textarea-rme"
              rows="3"
            ></textarea>
          </div>
          <div class="col-md-6">
            <label>Jenis Operasi :</label>
            <textarea
              v-model="form.jenis_operasi_detail"
              class="textarea-rme"
              rows="3"
            ></textarea>
          </div>
        </div>
      </div>

      <!-- ================= DETAIL OPERASI ================= -->
       <div class="box-rme mb-4">
        <h5 class="section-title-rme">Detail Operasi</h5>

        <div class="row mb-3">
          <div class="col-md-12">
            <label>Desinfeksi Kulit dengan :</label>
            <input type="text" v-model="form.desinfeksi_kulit" class="input-rme" />
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-4">
            <label>Jam Operasi Dimulai :</label>
            <input type="time" v-model="form.jam_mulai" class="input-rme" />
          </div>
          <div class="col-md-4">
            <label>Jam Operasi Selesai :</label>
            <input type="time" v-model="form.jam_selesai" class="input-rme" />
          </div>
          <div class="col-md-4">
            <label>Lama Operasi (menit) :</label>
            <input
              type="number"
              v-model="form.lama_operasi"
              class="input-rme"
              placeholder="Menit"
            />
          </div>
        </div>

        <!-- MACAM SAYATAN -->
        <div class="row mb-3">
          <div class="col-md-12">
            <label class="mb-2">Macam Sayatan (bila perlu dengan gambar) :</label>
            <textarea
              v-model="form.macam_sayatan_teks"
              class="textarea-rme mb-2"
              rows="2"
              placeholder="Deskripsikan macam sayatan..."
            ></textarea>

            <div v-if="form.macam_sayatan_gambar && !macamSayatanCleared" class="signature-preview text-center">
              <img :src="form.macam_sayatan_gambar" alt="Gambar Macam Sayatan" class="img-signature" />
              <button @click="clearMacamSayatan()" class="btn-clear">
                Hapus & Gambar Ulang
              </button>
            </div>
            <div v-else class="text-center">
              <VueSignaturePad
                ref="macam_sayatan_pad"
                :options="sigOption"
                class="signature-box-rme"
              />
              <button type="button" @click="saveSign('macam_sayatan_pad')" class="btn-save mt-2">Simpan Gambar ✔</button>
            </div>
          </div>
        </div>

        <!-- POSISI PENDERITA -->
        <div class="row mb-3">
          <div class="col-md-12">
            <label class="mb-2">Posisi Penderita (bila perlu dengan gambar) :</label>
            <textarea
              v-model="form.posisi_penderita_teks"
              class="textarea-rme mb-2"
              rows="2"
              placeholder="Deskripsikan posisi penderita..."
            ></textarea>

            <div v-if="form.posisi_penderita_gambar && !posisiPenderitaCleared" class="signature-preview text-center">
              <img :src="form.posisi_penderita_gambar" alt="Gambar Posisi Penderita" class="img-signature" />
              <button @click="clearPosisiPenderita()" class="btn-clear">
                Hapus & Gambar Ulang
              </button>
            </div>
            <div v-else class="text-center">
              <VueSignaturePad
                ref="posisi_penderita_pad"
                :options="sigOption"
                class="signature-box-rme"
              />
              <button type="button" @click="saveSign('posisi_penderita_pad')" class="btn-save mt-2">Simpan Gambar ✔</button>
            </div>
          </div>
        </div>

        <!-- TEKNIK OPERASI + UPLOAD FOTO/PDF -->
        <div class="row mb-3">
          <div class="col-md-12">
            <label>Teknik Operasi dan Temuan Intra-Operasi :</label>
            <textarea
              v-model="form.teknik_operasi"
              class="textarea-rme mb-3"
              rows="6"
              placeholder="Deskripsikan teknik operasi dan temuan intra-operasi..."
            ></textarea>

            <div class="foto-operasi-container">
              <label class="fw-semibold mb-2">
                📸 Dokumentasi Operasi (Foto/PDF)
              </label>

              <div class="btn-group-upload mb-3">
                <button
                  type="button"
                  class="btn-upload"
                  @click="triggerFileUpload('teknik_operasi', 'image/*')"
                >
                  📁 Upload Foto
                </button>

                <button
                  type="button"
                  class="btn-camera"
                  @click="triggerCamera('teknik_operasi')"
                >
                  📷 Buka Kamera
                </button>

                <button
                  type="button"
                  class="btn-upload-pdf"
                  @click="triggerFileUpload('teknik_operasi', '.pdf')"
                >
                  📄 Upload PDF
                </button>

                <input
                  type="file"
                  ref="fileInput_teknik_operasi"
                  style="display: none"
                  @change="handleFileUpload($event, 'teknik_operasi')"
                />
              </div>

              <!-- Preview File -->
<div v-if="form.teknik_operasi_files.length > 0" class="foto-preview-grid">
  <div
    v-for="(file, index) in form.teknik_operasi_files"
    :key="index"
    class="foto-item"
  >
    <!-- ✅ Preview Image pakai URL storage -->
    <img
      v-if="file.type === 'image'"
      :src="file.preview || file.url"
      alt="Foto Operasi"
      class="foto-thumbnail"
      @error="handleImageError($event)"
    />

    <!-- ✅ Preview PDF -->
    <div v-else class="pdf-thumbnail">
      <a :href="file.url" target="_blank" class="pdf-link">
        <div class="pdf-icon">📄</div>
        <div class="pdf-name">{{ file.name }}</div>
      </a>
    </div>

    <button
      @click="hapusFile('teknik_operasi', index)"
      class="btn-hapus-foto"
      title="Hapus file"
    >
      ✕
    </button>
    <span class="foto-label">{{ file.type === 'image' ? 'Foto' : 'PDF' }} {{ index + 1 }}</span>
  </div>
</div>
              <div v-else class="text-muted small text-center py-3">
                Belum ada file yang ditambahkan
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- ================= BAHAN LABORATORIUM ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Bahan Laboratorium</h5>

        <div class="row mb-3">
          <div class="col-md-6">
            <label>Jenis Bahan Yang dikirim ke laboratorium :</label>
            <input type="text" v-model="form.jenis_bahan_lab" class="input-rme" />
          </div>
          <div class="col-md-6">
            <label>Untuk pemeriksaan :</label>
            <input type="text" v-model="form.pemeriksaan_lab" class="input-rme" />
          </div>
        </div>
      </div>

      <!-- ================= AMHP & KOMPLIKASI ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">AMHP Khusus & Komplikasi</h5>

        <div class="row mb-3">
          <div class="col-md-6">
            <label>Penggunaan AMHP Khusus :</label>
            <div class="d-flex gap-3">
              <label class="radio-label">
                <input type="radio" v-model="form.penggunaan_amhp" value="ya" /> Ya
              </label>
              <label class="radio-label">
                <input type="radio" v-model="form.penggunaan_amhp" value="tidak" /> Tidak
              </label>
            </div>
          </div>
          <div class="col-md-6" v-if="form.penggunaan_amhp === 'ya'">
            <label>Jenis dan Jumlah (AMHP Khusus) :</label>
            <input type="text" v-model="form.jenis_amhp" class="input-rme" />
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-6">
            <label>Komplikasi Intra-operasi :</label>
            <div class="d-flex gap-3">
              <label class="radio-label">
                <input type="radio" v-model="form.komplikasi" value="ya" /> Ya
              </label>
              <label class="radio-label">
                <input type="radio" v-model="form.komplikasi" value="tidak" /> Tidak
              </label>
            </div>
          </div>
        </div>

        <div class="row mb-3" v-if="form.komplikasi === 'ya'">
          <div class="col-md-12">
            <label>Penjabaran Komplikasi Intra-Operasi :</label>
            <textarea
              v-model="form.penjabaran_komplikasi"
              class="textarea-rme"
              rows="4"
            ></textarea>
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-6">
            <label>Perdarahan (cc) :</label>
            <input
              type="number"
              v-model="form.perdarahan"
              class="input-rme"
              placeholder="cc"
            />
          </div>
        </div>
      </div>

      <!-- ================= INSTRUKSI ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Instruksi Anestesi & Pasca-Bedah</h5>

        <div class="row mb-3">
          <div class="col-md-12">
            <label>Instruksi Anestesi :</label>
            <textarea
              v-model="form.instruksi_anestesi"
              class="textarea-rme"
              rows="3"
            ></textarea>
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-12">
            <label class="fw-bold mb-2">Instruksi Pasca-Bedah :</label>
          </div>
        </div>

        <div class="row mb-2">
          <div class="col-md-6">
            <label>1. Kontrol nadi/Tensi/pernapasan/suhu :</label>
            <input type="text" v-model="form.instruksi_kontrol" class="input-rme" />
          </div>
          <div class="col-md-6">
            <label>2. Puasa :</label>
            <input type="text" v-model="form.instruksi_puasa" class="input-rme" />
          </div>
        </div>

        <div class="row mb-2">
          <div class="col-md-6">
            <label>3. Drain :</label>
            <input type="text" v-model="form.instruksi_drain" class="input-rme" />
          </div>
          <div class="col-md-6">
            <label>4. Infus :</label>
            <input type="text" v-model="form.instruksi_infus" class="input-rme" />
          </div>
        </div>

        <div class="row mb-2">
          <div class="col-md-6">
            <label>5. Obat-obatan :</label>
            <textarea
              v-model="form.instruksi_obat"
              class="textarea-rme"
              rows="2"
            ></textarea>
          </div>
          <div class="col-md-6">
            <label>6. Ganti Balut :</label>
            <input type="text" v-model="form.instruksi_ganti_balut" class="input-rme" />
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-12">
            <label>7. Lain-lain :</label>
            <textarea
              v-model="form.instruksi_lainnya"
              class="textarea-rme"
              rows="2"
            ></textarea>
          </div>
        </div>
      </div>

      <!-- ================= TANDA TANGAN ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Tanda Tangan Operator Bedah</h5>

        <div class="row">
          <div class="col-md-6">
            <label>Medan, Tanggal :</label>
            <input type="date" v-model="form.tanggal_ttd" class="input-rme" />
          </div>
        </div>

        <div class="row mt-1">
          <div class="col-md-6 text-center">
            <label class="fw-bold mb-2">Operator Bedah</label>
            <!-- Preview TTD yang sudah ada -->
            <div v-if="form.operator_bedah_ttd && !signatureCleared" class="signature-preview">
              <img :src="form.operator_bedah_ttd" alt="TTD Dokter" class="img-signature" />
              <button @click="clearSignature()" class="btn-clear">
                Hapus & Tanda Tangan Ulang
              </button>
            </div>

            <!-- Signature Pad -->
            <div v-else>
              <VueSignaturePad
                ref="operator_bedah_ttd"
                :options="sigOption"
                class="signature-box-rme"
              />
              <button @click="saveSign('operator_bedah_ttd')" class="btn-save">Simpan ✔</button>
            </div>

            <div class="dropdown-dokter mt-2">
              <select v-model="form.nama_operator" class="form-select-dokter">
                <option value="" disabled>🩺 Pilih Dokter</option>
                <option
                  v-for="dokter in listDokter"
                  :key="dokter.id"
                  :value="dokter.nama"
                >
                  {{ dokter.nama }}
                </option>
              </select>
              <span class="dropdown-icon">▾</span>
            </div>
          </div>
        </div>
    </div>
  </div>

    <!-- ================= BUTTON BOTTOM ================= -->
    <div class="action-footer">
      <button v-if="!disabledSubmit" class="btn-save-form" @click="submitForm" :disabled="loadingSubmit">
      <span v-if="loadingSubmit">Menyimpan...</span>
      <span v-else>Simpan</span>
    </button>

      <button class="btn-back" @click="$emit('back')" :disabled="loadingSubmit">
        Kembali
      </button>
    </div>
  </div>

</template>

<script>
import axios from "axios";

export default {
  name: "FormLaporanPembedahan",
  props: {
    selectedPatient: {
      type: Object,
      required: true,
    },
    viewData: {
      type: Object,
      default: null,
    },
    editData: {
      // ✨ Props untuk data edit
      type: Object,
      default: null,
    },
    isEditMode: {
      // ✨ Props flag edit mode
      type: Boolean,
      default: false,
    },
  },
  data() {
    return {
      loadingSubmit: false,
      listDokter: [],
      signatureCleared: false,
      macamSayatanCleared: false,
      disabledSubmit: false,
      posisiPenderitaCleared: false,
      sigOption: {
        penColor: "black",
        backgroundColor: "white",

      },
      cameraStream: null,
      form: {
        uuid: "", // ✨ Tambahkan field uuid
        uuid_pasien: "",
        no_rm: "",
        nik: "",
        nama: "",
        tanggal_lahir: "",
        jenis_kelamin: "",
        ruang_operasi: "",
        kamar: "",
        tanggal_operasi: "",
        jenis_operasi: "terencana",
        pembedahan: "",
        ahli_anestesi: "",
        asisten_1: "",
        asisten_2: "",
        perawat_instrument: "",
        anestesi_umum: false,
        anestesi_spiral: false,
        anestesi_epidural: false,
        anestesi_bsp: false,
        anestesi_csp: false,
        anestesi_lokal: false,
        diagnosa_pra_bedah: "",
        indikasi_operasi: "",
        diagnosa_pasca_bedah: "",
        jenis_operasi_detail: "",
        desinfeksi_kulit: "",
        jam_mulai: "",
        jam_selesai: "",
        lama_operasi: "",
        macam_sayatan_teks: "",        // ✨ Teks macam sayatan
        macam_sayatan_gambar: "",      // ✨ Gambar macam sayatan
        posisi_penderita_teks: "",     // ✨ Teks posisi penderita
        posisi_penderita_gambar: "",
        teknik_operasi: "",
        teknik_operasi_files: [],
        jenis_bahan_lab: "",
        pemeriksaan_lab: "",
        penggunaan_amhp: "tidak",
        jenis_amhp: "",
        komplikasi: "tidak",
        penjabaran_komplikasi: "",
        perdarahan: "",
        instruksi_anestesi: "",
        instruksi_kontrol: "",
        instruksi_puasa: "",
        instruksi_drain: "",
        instruksi_infus: "",
        instruksi_obat: "",
        instruksi_ganti_balut: "",
        instruksi_lainnya: "",
        tanggal_ttd: "",
        nama_operator: "",
        operator_bedah_ttd: "",

      },
    };
  },
  async mounted() {
    await this.fetchDokter();
     if (this.viewData && typeof this.viewData === 'object' && Object.keys(this.viewData).length > 0) {
    this.disabledSubmit = true;
    this.editData = this.viewData; // Pakai sebagai data view
    this.loadDataForEdit();
  } else if (this.editData && typeof this.editData === 'object') {
    this.loadDataForEdit();
  } else {
    this.setDataForm();
  }

  },
  methods: {
    async fetchDokter() {
      try {
        const response = await axios.get('/master/pasien/master-dokter-all');
        this.listDokter = response.data.data;
      } catch (error) {
        console.error('Gagal memuat data dokter:', error);
      }
    },
    beforeUnmount() {
    // Matikan kamera kalau komponen di-destroy
    this.closeCameraModal();
    },
    handleImageError(event) {
        console.error('Gagal load gambar:', event.target.src);
        event.target.style.display = 'none';
    },
    clearSignature() {
      this.signatureCleared = true;
      this.form.operator_bedah_ttd = "";
      this.$nextTick(() => {
        const pad = this.$refs.operator_bedah_ttd;
        if (pad) pad.clearSignature();
      });
    },
    // Hapus gambar yang sudah tersimpan → tampilkan pad kosong kembali
    clearMacamSayatan() {
        this.macamSayatanCleared = true;
        this.form.macam_sayatan_gambar = "";  // ✨ Ganti dari macam_sayatan
        this.$nextTick(() => {
            const pad = this.$refs.macam_sayatan_pad;  // ✨ Ganti ref
            if (pad) pad.clearSignature();
        });
    },
    clearPosisiPenderita() {
        this.posisiPenderitaCleared = true;
        this.form.posisi_penderita_gambar = "";  // ✨ Ganti dari posisi_penderita
        this.$nextTick(() => {
            const pad = this.$refs.posisi_penderita_pad;  // ✨ Ganti ref
            if (pad) pad.clearSignature();
        });
    },
    // ✨ FUNGSI BARU UPLOAD FOTO
    triggerFileUpload(section, accept) {
    const input = this.$refs[`fileInput_${section}`];
    if (input) {
        input.setAttribute('accept', accept);
        input.removeAttribute('capture');
        input.click();
    }
    },

   triggerCamera(section) {
    // Deteksi apakah perangkat mobile
    const isMobile = /Android|iPhone|iPad|iPod|webOS/i.test(navigator.userAgent);

    if (isMobile) {
        // Mobile → buka kamera native lewat input file
        const input = this.$refs[`fileInput_${section}`];
        if (input) {
        input.setAttribute('accept', 'image/*');
        input.setAttribute('capture', 'environment');
        input.click();
        }
    } else {
        // Desktop → buka modal kamera custom
        this.openCameraModal(section);
    }
    },

    openCameraModal(section) {
  // Tutup kamera sebelumnya dulu
  this.closeCameraModal();

  const modalHtml = `
    <div id="camera-modal" style="
      position: fixed; top: 0; left: 0; width: 100%; height: 100%;
      background: rgba(0,0,0,0.9); z-index: 9999;
      display: flex; flex-direction: column; align-items: center; justify-content: center;
    ">
      <video id="camera-video" autoplay playsinline style="
        max-width: 100%; max-height: 70vh; border-radius: 8px;
      "></video>
      <div style="margin-top: 20px; display: flex; gap: 15px;">
        <button id="capture-btn" style="
          background: #4CAF50; color: white; padding: 12px 30px;
          border: none; border-radius: 30px; font-size: 16px; cursor: pointer;
        ">📸 Ambil Foto</button>
        <button id="close-camera-btn" style="
          background: #f44336; color: white; padding: 12px 30px;
          border: none; border-radius: 30px; font-size: 16px; cursor: pointer;
        ">❌ Tutup</button>
      </div>
      <canvas id="camera-canvas" style="display: none;"></canvas>
    </div>
  `;

  document.body.insertAdjacentHTML('beforeend', modalHtml);

  const video = document.getElementById('camera-video');
  const canvas = document.getElementById('camera-canvas');

  // Minta akses kamera
  navigator.mediaDevices.getUserMedia({
    video: {
      width: { ideal: 1280 },
      height: { ideal: 720 },
      facingMode: 'environment'
    }
  })
  .then((mediaStream) => {
    this.cameraStream = mediaStream;  // ✅ Simpan stream ke component
    video.srcObject = mediaStream;
  })
  .catch((err) => {
    console.error('Gagal akses kamera:', err);
    alert('Tidak dapat mengakses kamera. Pastikan kamera tersedia dan izin diberikan.');
    this.closeCameraModal();
  });

  // Tombol ambil foto
  document.getElementById('capture-btn').addEventListener('click', () => {
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    canvas.getContext('2d').drawImage(video, 0, 0);

    const base64String = canvas.toDataURL('image/jpeg', 0.9);

    const timestamp = new Date().getTime();
    const fileName = `camera_capture_${timestamp}.jpg`;

    const fileData = {
      preview: base64String,
      name: fileName,
      type: 'image',
      size: Math.round(base64String.length * 0.75),
      extension: 'jpg',
    };

    this.form.teknik_operasi_files.push(fileData);
    this.closeCameraModal();  // ✅ Tutup modal + matikan kamera
    console.log('Foto dari kamera berhasil disimpan');
  });

  // Tombol tutup
  document.getElementById('close-camera-btn').addEventListener('click', () => {
    this.closeCameraModal();  // ✅ Tutup modal + matikan kamera
  });
},

// ✅ Fungsi close yang robust
closeCameraModal() {
  // ✅ Matikan semua track kamera
  if (this.cameraStream) {
    this.cameraStream.getTracks().forEach(track => {
      track.stop();  // Stop track
    });
    this.cameraStream = null;  // Reset stream
  }

  // Hapus modal dari DOM
  const modal = document.getElementById('camera-modal');
  if (modal) {
    modal.remove();
  }
},

    handleFileUpload(event, section) {
        const file = event.target.files[0];
        if (!file) return;

        // Validasi tipe file
        const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'application/pdf'];
        if (!allowedTypes.includes(file.type)) {
            alert('File harus berupa gambar (JPG/PNG/GIF) atau PDF!');
            return;
        }

        // Validasi ukuran (max 10MB)
        if (file.size > 10 * 1024 * 1024) {
            alert('Ukuran file maksimal 10MB!');
            return;
        }

        const fileData = {
            file: file,              // File object asli untuk upload
            name: file.name,
            type: file.type.startsWith('image/') ? 'image' : 'pdf',
            size: file.size,
        };

        // Buat preview
        if (fileData.type === 'image') {
            const reader = new FileReader();
            reader.onload = (e) => {
            fileData.preview = e.target.result;
            this.form.teknik_operasi_files.push(fileData);
            };
            reader.readAsDataURL(file);
        } else {
            // PDF tidak perlu preview
            fileData.preview = null;
            this.form.teknik_operasi_files.push(fileData);
        }

        event.target.value = '';
    },

    hapusFile(section, index) {
    if (confirm('Yakin ingin menghapus file ini?')) {
        this.form.teknik_operasi_files.splice(index, 1);
    }
    },

    // Bersihkan canvas saja (tanpa mengubah state preview) — tombol Bersihkan di pad aktif
    // async loadDataForEdit() {
    //   // try {
    //   // console.log("yudha", this.editData);
    //     // Option 1: Jika data lengkap sudah ada di editData props
    //     // if (this.editData.uuid) {
    //       // Fetch detail dari server untuk data lengkap
    //       // const response = await axios.get(
    //       //   `/master/pasien/dokumen-laporan-pembedahan/${this.editData.uuid}`
    //       // );
    //        this.editData;
    //       // console.log("yudha2", response.data.data);
    //       if (this.editData) {
    //         // Populate form dengan data dari server
    //         Object.keys(this.form).forEach((key) => {
    //           if (this.editData[key] !== undefined) {
    //             this.form[key] = this.editData[key];
    //           }
    //         });

    //         // Reset semua flag — WAJIB di luar kondisi ttd_dokter
    //         this.$nextTick(() => {
    //           if (this.form.macam_sayatan) this.macamSayatanCleared = false;
    //           if (this.form.posisi_penderita) this.posisiPenderitaCleared = false;
    //           if (this.form.operator_bedah_ttd) this.signatureCleared = false;
    //         });

    //         // ✨ Load signature jika ada
    //         if (this.editData.ttd_dokter) {
    //           this.$nextTick(() => {
    //             // Set signature dari base64
    //             // Note: vue-signature-pad biasanya perlu di-load manual
    //           });
    //         }
    //       }
    //     // }

    //     // Option 2: Atau langsung gunakan editData jika sudah lengkap
    //     // Object.keys(this.form).forEach(key => {
    //     //   if (this.editData[key] !== undefined) {
    //     //     this.form[key] = this.editData[key];
    //     //   }
    //     // });
    //   // } catch (error) {
    //   //   console.error("Error loading data:", error);
    //   //   alert("Gagal memuat data untuk edit!");
    //   //   this.$emit("back");
    //   // }
    // },
    loadDataForEdit() {
    if (this.editData) {
        Object.keys(this.form).forEach((key) => {
        if (this.editData[key] !== undefined) {

            if (key === 'teknik_operasi_files') {
            try {
                let files = this.editData[key];

                // Parse JSON string → array
                if (typeof files === 'string') {
                files = JSON.parse(files);
                }

                console.log('Files setelah parse:', files);

                if (Array.isArray(files) && files.length > 0) {
                this.form[key] = files.map(f => {
                    // ✅ Hapus SEMUA backslash dari path
                    const cleanPath = f.path ? f.path.replace(/\\/g, '') : '';

                    console.log('Path bersih:', cleanPath);

                    return {
                    path: cleanPath,
                    name: f.name,
                    type: f.type,
                    size: f.size,
                    preview: f.type === 'image' ? `/storage/${cleanPath}` : null,
                    url: `/storage/${cleanPath}`,
                    };
                });
                } else {
                this.form[key] = [];
                }
            } catch (e) {
                console.error('Gagal parse teknik_operasi_files:', e);
                this.form[key] = [];
            }
            } else {
            this.form[key] = this.editData[key];
            }
        }
        });

        console.log('form.teknik_operasi_files setelah load:', this.form.teknik_operasi_files);
        console.log('Jumlah file:', this.form.teknik_operasi_files.length);

        this.$nextTick(() => {
        if (this.form.macam_sayatan_gambar) this.macamSayatanCleared = false;
        if (this.form.posisi_penderita_gambar) this.posisiPenderitaCleared = false;
        if (this.form.operator_bedah_ttd) this.signatureCleared = false;
        });
    }
    },
    setDataForm() {
      const today = new Date();
      this.form.tanggal_operasi = today.toISOString().split("T")[0];
      this.form.tanggal_ttd = today.toISOString().split("T")[0];

      if (this.selectedPatient) {
        this.form.uuid_pasien = this.selectedPatient.uuid;
        this.form.no_rm = this.selectedPatient.rekam_medis;
        this.form.nik = this.selectedPatient.no_identitas || "";
        this.form.nama = this.selectedPatient.nama;
        this.form.tanggal_lahir = this.selectedPatient.tanggal_lahir;
        this.form.jenis_kelamin = this.selectedPatient.jenis_kelamin;
      }
    },

    saveSign(refName) {
        const pad = this.$refs[refName];
        if (!pad) {
            console.error("REF tidak ditemukan:", refName);
            return;
        }

        const { isEmpty, data } = pad.saveSignature();  // ✨ Tanpa parameter

        if (isEmpty) {
            alert("Gambar masih kosong!");
            return;
        }

        // ✨ Switch case untuk mapping field
        switch (refName) {
            case 'operator_bedah_ttd':
            this.signatureCleared = false;
            this.form.operator_bedah_ttd = data;
            break;
            case 'macam_sayatan_pad':
            this.macamSayatanCleared = false;
            this.form.macam_sayatan_gambar = data;
            break;
            case 'posisi_penderita_pad':
            this.posisiPenderitaCleared = false;
            this.form.posisi_penderita_gambar = data;
            break;
        }

        console.log("Saved:", refName);
    },
    mapJenisKelamin(jk) {
    const val = jk?.toLowerCase();

    if (val === 'perempuan' || val === 'wanita') return 'P';
    if (val === 'laki laki' || val === 'laki-laki' || val === 'pria') return 'L';

    return jk; // fallback biar aman
    },

   async submitForm() {
  this.loadingSubmit = true;

  try {
    const fd = new FormData();

    // ==========================================
    // Convert file dokumentasi ke Base64 dulu
    // ==========================================
    const filesBase64 = [];

    for (const fileData of this.form.teknik_operasi_files) {
      if (fileData.file) {
        // File baru → convert ke Base64
        const base64 = await this.fileToBase64(fileData.file);
        filesBase64.push({
          data: base64,
          name: fileData.name,
          type: fileData.type,
          size: fileData.size,
          extension: fileData.name.split('.').pop(),
        });
      } else {
        // File lama (edit mode) → tetap pakai path
        filesBase64.push({
          path: fileData.path,
          name: fileData.name,
          type: fileData.type,
          size: fileData.size,
        });
      }
    }

    // ==========================================
    // Kirim semua data form
    // ==========================================
    Object.keys(this.form).forEach((key) => {
      let value = this.form[key];

      if (key === 'jenis_kelamin') {
        value = this.mapJenisKelamin(value);
      }

      // ✅ Field dokumentasi → kirim Base64
      if (key === 'teknik_operasi_files') {
        fd.append(key, JSON.stringify(filesBase64));
      }
      // ❌ Field lama — skip
      else if (key === 'teknik_operasi_foto') {
        // Tidak dipakai
      }
      // Field lainnya (termasuk TTD, gambar sayatan, dll)
      else {
        if (value !== undefined && value !== null) {
          fd.append(key, value);
        }
      }
    });

    const response = await axios.post(
      "/master/pasien/dokumen-laporan-pembedahan",
      fd,
      { headers: { "Content-Type": "multipart/form-data" } }
    );

    console.log("BERHASIL:", response.data);
    alert("Laporan Pembedahan berhasil disimpan!");
    this.$emit("back");

  } catch (error) {
    console.error("ERROR:", error.response?.data || error);
    alert("Gagal menyimpan laporan pembedahan!");
  } finally {
    this.loadingSubmit = false;
  }
},

// Helper: Convert File ke Base64
fileToBase64(file) {
  return new Promise((resolve, reject) => {
    const reader = new FileReader();
    reader.onload = () => resolve(reader.result);
    reader.onerror = reject;
    reader.readAsDataURL(file);
  });
},
  }
};
</script>

<style scoped>
.container {
  max-width: 1200px;
  margin: 0 auto;
}

.box-rme {
  border: 1px solid #dcdcdc;
  padding: 20px;
  border-radius: 6px;
  background: white;
}

.section-title-rme {
  font-weight: bold;
  margin-bottom: 15px;
  color: #2d74b7;
  border-bottom: 2px solid #2d74b7;
  padding-bottom: 8px;
}

.input-rme {
  width: 100%;
  border: 1px solid #ccc;
  border-radius: 4px;
  padding: 8px;
  background: #f9f9f9;
  font-size: 14px;
}

.input-rme:focus {
  outline: none;
  border-color: #2d74b7;
  background: white;
}

.textarea-rme {
  width: 100%;
  border: 1px solid #ccc;
  border-radius: 4px;
  padding: 8px;
  background: #f9f9f9;
  font-size: 14px;
  resize: vertical;
}

.textarea-rme:focus {
  outline: none;
  border-color: #2d74b7;
  background: white;
}

.radio-label,
.checkbox-label {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  cursor: pointer;
  font-size: 14px;
}

.checkbox-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 12px;
}

.signature-box-rme {
  width: 500px !important;
  height: 110px !important;
  border: 2px solid #999;
  border-radius: 4px;
  display: block;
  margin: 0 auto;
}

.sign-btn-group {
  display: flex;
  justify-content: center;
  gap: 8px;
}

.btn-clear-sign {
  background: #e53935;
  color: white;
  padding: 6px 16px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-weight: 500;
}

.btn-clear-sign:hover {
  background: #b71c1c;
}

.btn-save {
  background: #1e88e5;
  color: white;
  padding: 6px 16px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-weight: 500;
}

.btn-save:hover {
  background: #1565c0;
}

.action-footer {
  margin-top: 30px;
  padding: 20px;
  display: flex;
  justify-content: flex-end;
  gap: 12px;
  background: #f5f5f5;
  border-top: 2px solid #ddd;
}

.btn-save-form {
  background: #0288d1;
  color: white;
  padding: 10px 24px;
  border: none;
  border-radius: 4px;
  font-weight: bold;
  cursor: pointer;
  font-size: 16px;
}

.btn-save-form:hover {
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
  font-size: 16px;
}

.btn-back:hover {
  background: #f57c00;
}

.btn-back:disabled {
  background: #ccc;
  cursor: not-allowed;
}

label {
  display: block;
  margin-bottom: 5px;
  font-weight: 500;
  font-size: 14px;
  color: #333;
}

.row {
  display: flex;
  flex-wrap: wrap;
  margin-left: -8px;
  margin-right: -8px;
}

.col-md-4,
.col-md-6,
.col-md-12 {
  padding-left: 8px;
  padding-right: 8px;
}

.col-md-4 {
  flex: 0 0 33.333333%;
  max-width: 33.333333%;
}

.col-md-6 {
  flex: 0 0 50%;
  max-width: 50%;
}

.col-md-12 {
  flex: 0 0 100%;
  max-width: 100%;
}

.d-flex {
  display: flex;
}

.gap-2 {
  gap: 8px;
}

.gap-3 {
  gap: 12px;
}

.mb-2 {
  margin-bottom: 8px;
}

.mb-3 {
  margin-bottom: 16px;
}

.mb-4 {
  margin-bottom: 24px;
}

.mt-1 {
  margin-top: 4px;
}

.mt-2 {
  margin-top: 8px;
}

.mt-3 {
  margin-top: 16px;
}

.text-center {
  text-align: center;
}

.fw-bold {
  font-weight: bold;
}

.fw-semibold {
  font-weight: 600;
}

.text-muted {
  color: #6c757d;
}

.mx-auto {
  margin-left: auto;
  margin-right: auto;
}

@media (max-width: 768px) {
  .col-md-4,
  .col-md-6 {
    flex: 0 0 100%;
    max-width: 100%;
  }

  .checkbox-grid {
    grid-template-columns: repeat(2, 1fr);
  }
   .signature-box-rme {
    width: 100% !important;
  }

  /* ✨ TAMBAHKAN INI */
  .btn-group-upload {
    flex-direction: column;
  }

  .foto-preview-grid {
    grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
  }

  .foto-thumbnail {
    height: 120px;
  }
}
.signature-preview {
  text-align: center;
  padding: 10px;
  border: 1px dashed #ccc;
  border-radius: 4px;
}

.img-signature {
  max-width: 100%;
  max-height: 200px;
  margin-bottom: 10px;
}

.text-muted.small {
  font-size: 13px;
  color: #a0aec0;
}

.fw-semibold {
  font-weight: 600;
}
.pdf-link {
  text-decoration: none;
  color: inherit;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  width: 100%;
  height: 100%;
}

.pdf-link:hover {
  background: #e8f0fe;
}
.btn-upload-pdf {
  background: #c62828;
  color: white;
  padding: 8px 16px;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  font-size: 13px;
  font-weight: 500;
  transition: all 0.2s;
  display: flex;
  align-items: center;
}

.btn-upload-pdf:hover {
  background: #b71c1c;
  transform: translateY(-1px);
}

.pdf-thumbnail {
  width: 100%;
  height: 150px;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  background: #f0f4ff;
  border: 2px dashed #b0c4de;
}

.pdf-icon {
  font-size: 48px;
  margin-bottom: 8px;
}

.pdf-name {
  font-size: 11px;
  color: #4a5568;
  text-align: center;
  word-break: break-all;
  padding: 0 8px;
}
</style>
