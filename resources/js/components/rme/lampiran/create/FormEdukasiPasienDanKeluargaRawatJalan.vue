<template>
  <div>
    <button @click="$emit('back')" class="btn-back">Kembali</button>

    <div class="container py-4">
      <div class="form-wrapper position-relative">

       <!-- OVERLAY SAAT VIEW -->
     <div v-if="disabledSubmit" class="view-overlay"></div>
      <!-- ================= HEADER ================= -->
        <div class="text-center mb-4">
          <h2 class="fw-bold">
            FORMULIR EDUKASI PASIEN DAN KELUARGA RAWAT JALAN <br>
            <small style="font-size: 15px; font-weight: normal;">
              (BERI TANDA CHEKLIST (√) PADA KOTAK YANG SESUAI DENGAN KEBUTUHAN PASIEN DAN KELUARGA)
            </small>
          </h2>
      
          <h4 class="fw-semibold">RM 1.2/FEPDKRJ/22</h4>
        </div>


   <!-- ================= INFORMASI PASIEN ================= -->
    <div class="box-rme mb-4">
      <h5 class="section-title-rme">Informasi Pasien</h5>
    
      <div class="form-row-3-3">
        <div>
          <label>No. RM :</label>
          <input type="text" v-model="form.no_rm" class="input-rme" readonly />
        </div>
        <div>
          <label>NIK :</label>
          <input type="text" v-model="form.nik" class="input-rme" readonly />
        </div>
      </div>
    
      <div class="form-row-3-3">
        <div>
          <label>Nama Pasien :</label>
          <input type="text" v-model="form.nama_pasien" class="input-rme" readonly />
        </div>
        <div>
          <label>Tanggal Lahir / Usia :</label>
          <input type="text" v-model="form.tanggal_lahir" class="input-rme" readonly />
        </div>
      </div>
    
      <div class="form-row-3-3">
        <div>
          <label>Jenis Kelamin :</label>
          <select v-model="form.jenis_kelamin" class="input-rme" disabled>
            <option value="L">Laki-laki</option>
            <option value="P">Perempuan</option>
          </select>
        </div>
        <div>
          <label>Alamat :</label>
          <input type="text" v-model="form.alamat" class="input-rme" readonly />
        </div>
      </div>
    </div>

            <!-- ================= INFORMASI KLINIK ================= -->
            <div class="two-box-wrapper">
                <div class="box-rme mb-2">
                  <h5 class="section-title-rme">Pengkajian Hambatan</h5>
                
                
                  <div class="grid-3">
                    <label class="checkbox-label">
                      <input type="checkbox" v-model="form.hambatan_bahasa" true-value="1" false-value="0"> Bahasa
                    </label>
                
                    <label class="checkbox-label">
                      <input type="checkbox" v-model="form.hambatan_emosi" true-value="1" false-value="0">  Emosi
                    </label>
                
                    <label class="checkbox-label">
                      <input type="checkbox" v-model="form.hambatan_penglihatan" true-value="1" false-value="0"> Masalah Penglihatan
                    </label>
                
                    <label class="checkbox-label">
                      <input type="checkbox" v-model="form.hambatan_bicara_buruk" true-value="1" false-value="0"> Bicara Buruk
                    </label>
                
                    <label class="checkbox-label">
                      <input type="checkbox" v-model="form.hambatan_cemas" true-value="1" false-value="0"> Cemas
                    </label>
                
                    <label class="checkbox-label">
                      <input type="checkbox" v-model="form.hambatan_tidak_partisipasi" true-value="1" false-value="0">  Tidak ada partisipasi
                    </label>
                
                    <label class="checkbox-label">
                      <input type="checkbox" v-model="form.hambatan_kognitif" true-value="1" false-value="0"> Kognitif
                    </label>
                
                    <label class="checkbox-label">
                      <input type="checkbox" v-model="form.hambatan_motivasi" true-value="1" false-value="0"> Motivasi
                    </label>
                
                    <label class="checkbox-label">
                      <input type="checkbox" v-model="form.hambatan_fisiologi" true-value="1" false-value="0">Secara fisiologi tidak mampu belajar
                    </label>
                
                    <label class="checkbox-label">
                      <input type="checkbox" v-model="form.hambatan_pendengaran" true-value="1" false-value="0"> Pendengaran
                    </label>
                
                    <label class="checkbox-label">
                      <input type="checkbox" v-model="form.hambatan_hilang_memori" true-value="1" false-value="0">  Hilang Memori 
                    </label>
                
                    <label class="checkbox-label">
                      <input type="checkbox" v-model="form.hambatan_tidak_ada" true-value="1" false-value="0"> Tidak ditemukan hambatan belajar
                    </label>
                  </div>
                </div>
              <!-- Box Kanan -->
              <div class="box-rme mb-2">
                <h5 class="section-title-rme">Metode Cara Belajar Yang Disukai </h5>
                <div class="grid-display ">
                  <div class="col-md-12">
                    <div class="grid-display">
                      <label >
                        1 = Audio
                      </label>
                      <label>
                        2 = Demonstrasi
                      </label>
                      <label>
                        3 = Lisan
                      </label>
                      <label >
                        4 = Tulisan
                      </label>
                      <label>
                        5 = Visual
                      </label>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="two-box-wrapper">
                <div class="box-rme mb-2">
                  <h5 class="section-title-rme">Edukasi</h5>        
                  <div class="grid-2">
                    <label class="checkbox-label">
                      <input type="checkbox" v-model="form.edukasi_tata_tertib" true-value="1" false-value="0"> Tata Tertib RS
                    </label>
                
                    <label class="checkbox-label">
                      <input type="checkbox" v-model="form.edukasi_hak_kewajiban" true-value="1" false-value="0">  Hak  Dan Kewajiban Pasien
                    </label>
                  </div>
                </div>
              <!-- Box Kanan -->
              <div class="box-rme mb-2">
                <h5 class="section-title-rme">Pengkajian Bicara</h5>
                <div class="grid-2">
                      <label class="checkbox-label">
                        <input type="checkbox" v-model="form.bicara_normal" true-value="1" false-value="0">Normal
                      </label>
                      <label class="checkbox-label">
                        <input type="checkbox" v-model="form.bicara_gangguan" true-value="1" false-value="0">Gangguan Bicara
                      </label>
                </div>
              </div>
            </div>

            <div class="two-box-wrapper">
                <div class="box-rme mb-2">
                  <h5 class="section-title-rme">Bahasa Sehari-Hari</h5>        
                  <div class="grid-2">
                    <label class="checkbox-label">
                      <input type="checkbox" v-model="form.bahasa_indonesia" true-value="1" false-value="0"> Indonesia
                    </label>
                    <label class="checkbox-label">
                      <input type="checkbox" v-model="form.bahasa_daerah" true-value="1" false-value="0" />
                      Daerah, Jelaskan 
                      <input type="text" v-model="form.bahasa_daerah_jelaskan" class="line-input"/>
                    </label>
                  </div>
                  <div class="grid-2">
                    <label class="checkbox-label">
                      <input type="checkbox" v-model="form.bahasa_inggris" true-value="1" false-value="0"> Inggris
                    </label>
                
                    <label class="checkbox-label">
                      <input type="checkbox" v-model="form.bahasa_lainnya" true-value="1" false-value="0">Lainnya                       
                      <input type="text" v-model="form.bahasa_lainnya_jelaskan" class="line-input"/>
                    </label>
                  </div>
                </div>
              <!-- Box Kanan -->
              <div class="box-rme mb-2">
                <h5 class="section-title-rme">Bahasa isyarat</h5>
                <div class="grid-2">
                      <label class="checkbox-label">
                        <input type="checkbox" v-model="form.bahasa_isyarat_ya" true-value="1" false-value="0">Ya
                      </label>
                      <label class="checkbox-label">
                        <input type="checkbox" v-model="form.bahasa_isyarat_tidak" true-value="1" false-value="0">Tidak
                      </label>
                </div>
              </div>
            </div>

            <div class="two-box-wrapper">
                <div class="box-rme mb-2">
                  <h5 class="section-title-rme">Tingkat Pendidikan</h5>        
                  <div class="grid-3">
                    <label class="checkbox-label">
                      <input type="checkbox" v-model="form.pendidikan_tk" true-value="1" false-value="0"> TK
                    </label>
                    <label class="checkbox-label">
                      <input type="checkbox" v-model="form.pendidikan_sd" true-value="1" false-value="0"> SD
                    </label>
                    <label class="checkbox-label">
                      <input type="checkbox" v-model="form.pendidikan_smp" true-value="1" false-value="0">SMP
                    </label>
                  </div>
                  <div class="grid-3">
                    <label class="checkbox-label">
                      <input type="checkbox" v-model="form.pendidikan_sma" true-value="1" false-value="0"> SMA
                    </label>
                    <label class="checkbox-label">
                      <input type="checkbox" v-model="form.pendidikan_diploma" true-value="1" false-value="0">Diploma
                    </label>
                
                    <label class="checkbox-label">
                      <input type="checkbox" v-model="form.pendidikan_sarjana" true-value="1" false-value="0">Sarjana
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-label">
                      <input type="checkbox" v-model="form.pendidikan_lainnya" true-value="1" false-value="0">Lainnya                       
                      <input type="text" v-model="form.pendidikan_lainnya_jelaskan" class="line-input"/>
                    </label>
                  </div>
                </div>
              <!-- Box Kanan -->
              <div class="box-rme mb-2">
                <h5 class="section-title-rme">Agama</h5>
                <div class="grid-3">
                   <label class="checkbox-label">
                     <input type="checkbox" v-model="form.agama_islam" true-value="1" false-value="0">Islam
                   </label>
                   <label class="checkbox-label">
                     <input type="checkbox" v-model="form.agama_protestan" true-value="1" false-value="0">Protestan
                   </label>
                   <label class="checkbox-label">
                     <input type="checkbox" v-model="form.agama_katolik" true-value="1" false-value="0">Katolik
                   </label>
                </div>
                                <div class="grid-3">
                   <label class="checkbox-label">
                     <input type="checkbox" v-model="form.agama_hindu" true-value="1" false-value="0">Hindu
                   </label>
                   <label class="checkbox-label">
                     <input type="checkbox" v-model="form.agama_budha" true-value="1" false-value="0">Budha
                   </label>
                   <label class="checkbox-label">
                     <input type="checkbox" v-model="form.agama_lainnya" true-value="1" false-value="0">Lain-lain
                   </label>
                </div>
              </div>
            </div>

            
            <div class="two-box-wrapper">
                <div class="box-rme mb-2">
                  <h5 class="section-title-rme">Tingkat Pengetahuan Tingkat Kesehatan Pasien</h5>        
                  <div class="grid-3">
                    <label class="checkbox-label">
                      <input type="checkbox" v-model="form.pengetahuan_paham" true-value="1" false-value="0"> Paham
                    </label>
                    <label class="checkbox-label">
                      <input type="checkbox" v-model="form.pengetahuan_kurang_paham" true-value="1" false-value="0"> Kurang Paham
                    </label>
                    <label class="checkbox-label">
                      <input type="checkbox" v-model="form.pengetahuan_tidak_paham" true-value="1" false-value="0">Tidak Paham
                    </label>
                  </div>
                </div>
              <!-- Box Kanan -->
              <div class="box-rme mb-2">
                <h5 class="section-title-rme">Nilai-Nilai Pasien Dan Budaya</h5>
                <div class="grid-3">
                   <label class="checkbox-label">
                     <input type="checkbox" v-model="form.budaya_modern" true-value="1" false-value="0">Modern
                   </label>
                   <label class="checkbox-label">
                     <input type="checkbox" v-model="form.budaya_moderat" true-value="1" false-value="0">Moderat
                   </label>
                   <label class="checkbox-label">
                     <input type="checkbox" v-model="form.budaya_konvensional" true-value="1" false-value="0">Konvensional
                   </label>
                </div>
              </div>
            </div>

            <div class="two-box-wrapper">
                <div class="box-rme mb-2">
                  <h5 class="section-title-rme">Merokok</h5>        
                  <div class="grid-2">
                    <label class="checkbox-label">
                      <input type="checkbox" v-model="form.merokok_ya" true-value="1" false-value="0"> Ya
                    </label>
                    <label class="checkbox-label">
                      <input type="checkbox" v-model="form.merokok_tidak" true-value="1" false-value="0"> Tidak
                    </label>
                  </div>
                </div>
              <!-- Box Kanan -->
              <div class="box-rme mb-2">
                <h5 class="section-title-rme">Konsumsi Alkohol</h5>
                <div class="grid-2">
                   <label class="checkbox-label">
                     <input type="checkbox" v-model="form.alkohol_ya" true-value="1" false-value="0">Ya
                   </label>
                   <label class="checkbox-label">
                     <input type="checkbox" v-model="form.alkohol_tidak" true-value="1" false-value="0">Tidak
                   </label>
                </div>
              </div>
            </div>

            <div class="two-box-wrapper">
                <div class="box-rme mb-2">
                  <h5 class="section-title-rme">Ketersedian Menerima Informasi</h5>        
                  <div class="grid-2">
                    <label class="checkbox-label">
                      <input type="checkbox" v-model="form.menerima_informasi_ya" true-value="1" false-value="0"> Ya
                    </label>
                    <label class="checkbox-label">
                      <input type="checkbox" v-model="form.menerima_informasi_tidak" true-value="1" false-value="0"> Tidak , Alasan
                      <input type="text" v-model="form.menerima_informasi_alasan" class="line-input"/>
                    </label>
                  </div>
                </div>
              <!-- Box Kanan -->
              <div class="box-rme mb-2">
                <h5 class="section-title-rme">Rencana Pendidikan Kesehatan</h5>
                <div class="grid-2">
                    <label class="checkbox-label">
                      <input type="checkbox" v-model="form.rencana_proses_penyakit" true-value="1" false-value="0"> Proses Penyakit
                    </label>
                    <label class="checkbox-label">
                      <input type="checkbox" v-model="form.rencana_pengobatan" true-value="1" false-value="0"/>Pengobatan/Tindakan 
                    </label>
                  </div>
                  <div class="grid-2">
                    <label class="checkbox-label">
                      <input type="checkbox" v-model="form.rencana_nutrisi" true-value="1" false-value="0"> Nutrisi
                    </label>
                    <label class="checkbox-label">
                      <input type="checkbox" v-model="form.rencana_edukasi_kolaboratif" true-value="1" false-value="0"/>Edukasi kolaboratif
                    </label>
                  </div>
                  <div class="grid-2">
                    <label class="checkbox-label">
                      <input type="checkbox" v-model="form.rencana_lain_lain" true-value="1" false-value="0"> Lain Lain
                    </label>
                    <label class="checkbox-label"> Jelaskan
                      <input type="text" v-model="form.rencana_lain_lain_jelaskan" class="line-input"/>
                    </label>
                </div>
              </div>
            </div>
            <div class="two-box-wrapper">
                <div class="box-rme mb-2">
                  <h5 class="section-title-rme">Penerima Pendidikan</h5>        
                  <div class="grid-2">
                    <label >
                       P = Pasien
                    </label>
                    <label >
                       K = Keluarga
                    </label>
                  </div>
                  <div class="grid-2">
                    <label >
                       L = Lain-lain
                    </label>
                  </div>
                </div>
              <div class="box-rme mb-2">
                <h5 class="section-title-rme">Frekuensi Edukasi :</h5>
                <div class="grid-2">
                    <label c>
                       1 = Edukasi Pertama 
                    </label>
                    <label >
                      2 = Re-edukasi ke 2/3 atau lebih 
                    </label>
                  </div>
              </div>
            </div>

            <div class="two-box-wrapper">
                <div class="box-rme mb-2">
                  <h5 class="section-title-rme">Evaluasi Respon</h5>        
                  <div class="grid-2">
                    <label >
                       1 =  Tidak Mengerti
                    </label>
                    <label >
                       2 = Menyatakan Paham
                    </label>
                  </div>
                  <div class="grid-2">
                    <label >
                       3 = Mampu Menjelaskan
                    </label>
                    <label >
                      4 = Mampu Demonstrasi / Simulasi 
                    </label>
                  </div>
                </div>
              <!-- Box Kanan -->
              <div class="box-rme mb-2">
                <h5 class="section-title-rme">Kebutuhan Privasi :</h5>
                <div class="grid-2">
                    <label class="checkbox-label">
                      <input type="checkbox" v-model="form.privasi_ya" true-value="1" false-value="0"> Ya 
                    </label>
                    <label class="checkbox-label">
                      <input type="checkbox" v-model="form.privasi_tidak" true-value="1" false-value="0">Tidak
                    </label>
                  </div>
              </div>
            </div>

      <!-- ================= TANDA TANGAN ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Tanda Tangan</h5>
      
        <div class="signature-row-3">
          <!-- KOLOM 1 -->
          <div>
            <label class="fw-bold mb-2">Pengkaji</label>
                <input type="text" v-model="form.nama_pengkaji" class="input-rme mt-2" placeholder="Nama Pengkaji" />
                        <div class="date-time-wrapper">
                          <div>
                            <label>Tanggal :</label>
                            <input type="date" v-model="form.tanggal_pengkaji" class="input-rme" />
                          </div>
                          <div>
                            <label>Waktu :</label>
                            <input type="time" v-model="form.waktu_pengkaji" class="input-rme" />
                          </div>
                        </div>
                    <VueSignaturePad ref="ttd_pengkaji" :options="sigOption" class="signature-box-rme mx-auto" />
                    <div class="signature-actions mt-2">
                    <button @click="clearSign('ttd_pengkaji')" class="btn-clear mt-2">Clear ↻</button>
                    <button @click="saveSign('ttd_pengkaji')" class="btn-save mt-2">Simpan ✔</button>
                </div>
              </div>
            </div>
        </div>
<div class="box-rme mb-4">
  <h5 class="section-title-rme">Tabel Edukasi Pasien dan Keluarga</h5>
  
  <table class="form-rs">
    <thead>
      <tr>
        <th>Tgl</th>
        <th>Poliklinik</th>
        <th>Penjelasan Edukasi Tentang</th>
        <th>Tanda Tangan Nama Petugas & Profesi</th>
        <th>Sasaran Edukasi<br>(Nama & Hubungannya dengan pasien)</th>
        <th>Evaluasi</th>
        <th style="width: 60px;">Aksi</th>
      </tr>
    </thead>

    <tbody>
      <tr v-for="(item, index) in form.tabel_edukasi" :key="index">
        <td>
          <input 
            type="date" 
            v-model="item.tanggal" 
            class="line-input1"
            :disabled="disabledSubmit"
          >
        </td>
        <td>
          <input 
            type="text" 
            v-model="item.poliklinik" 
            class="line-input1"
            :disabled="disabledSubmit"
          >
        </td>
        <td>
          <input 
            type="text" 
            v-model="item.penjelasan_edukasi" 
            class="line-input1"
            :disabled="disabledSubmit"
          >
        </td>
        <td>
          <div class="dokter-dpjp-box">
            <div class="ttd-container-small">
              <VueSignaturePad 
                :ref="`ttd_petugas_${index}`" 
                :options="sigOption" 
                class="signature-box-header" 
              />
              <div class="signature-actions mt-2" v-if="!disabledSubmit">
                <button 
                  @click="clearSign(index)" 
                  class="btn-clear mt-2"
                  type="button"
                >
                  Clear ↻
                </button>
                <button 
                  @click="saveSign(index)" 
                  class="btn-save mt-2"
                  type="button"
                >
                  Simpan ✔
                </button>
              </div>
            </div>
            <div class="input-dokter-dpjp">
              <input 
                type="text" 
                v-model="item.nama_petugas" 
                class="line-input1" 
                placeholder="Nama Dokter DPJP"
                :disabled="disabledSubmit"
              >
            </div>
          </div>
        </td>
        <td>
          <input 
            type="text" 
            v-model="item.sasaran_edukasi" 
            class="line-input1"
            :disabled="disabledSubmit"
          >
        </td>
        <td>
          <div class="checkbox-group">
            <label class="checkbox-label">
              <input 
                type="checkbox" 
                v-model="item.eval_sudah_dimengerti" 
                true-value="1" 
                false-value="0"
                :disabled="disabledSubmit"
              >
              <span>Sudah Dimengerti</span>
            </label>
            <label class="checkbox-label">
              <input 
                type="checkbox" 
                v-model="item.eval_re_demonstrasi" 
                true-value="1" 
                false-value="0"
                :disabled="disabledSubmit"
              >
              <span>Re-Demonstrasi</span>
            </label>
            <label class="checkbox-label">
              <input 
                type="checkbox" 
                v-model="item.eval_re_edukasi" 
                true-value="1" 
                false-value="0"
                :disabled="disabledSubmit"
              >
              <span>Re Edukasi</span>
            </label>
          </div>
        </td>
        <td style="text-align: center;">
          <button 
            @click="hapusTabelEdukasi(index)" 
            class="btn-delete-small" 
            v-if="form.tabel_edukasi.length > 1 && !disabledSubmit"
            type="button"
            title="Hapus baris"
          >
            ✕
          </button>
        </td>
      </tr>
    </tbody>
  </table>
  
  <!-- Tombol Tambah Baris -->
  <button 
    @click="tambahTabelEdukasi" 
    class="btn-add mt-2"
    type="button"
    v-if="!disabledSubmit"
  >
    ➕ Tambah Baris
  </button>
</div>
     </div>
     

    <!-- ================= BUTTON BOTTOM ================= -->
    <div class="action-footer" v-if="!disabledSubmit">
      <button class="btn-save-form" @click="submitForm" :disabled="loadingSubmit">
        <span v-if="loadingSubmit">Menyimpan...</span>
        <span v-else>Simpan</span>
      </button>

      <button class="btn-back" @click="$emit('back')" :disabled="loadingSubmit">
        Kembali
      </button>
    </div>
  </div>
</div>
</template>


<script>
import axios from "axios";

export default {
  name: "FormEdukasiPasienDanKeluargaRawatJalan",
  
  props: {
    selectedPatient: {
      type: Object,
      required: true,
    },
    editData: {
      type: Object,
      default: null,
    },
    viewData: {
      type: Object,
      default: null,
    },
    documentType: {
      type: String,
      default: "",
    },
  },
  
  data() {
    return {
      loadingSubmit: false,
      disabledSubmit: false, // ✅ TAMBAHKAN
      sigOption: {
        penColor: "black",
        backgroundColor: "white",
      },
      form: {
        uuid: "",
        uuid_pasien: "",
        no_rm: "",
        nama_pasien: "",
        nama: "",
        nik: "", 
        tanggal_lahir: "",
        jenis_kelamin: "L",
        alamat: "",
        
        // Pengkajian Hambatan
        hambatan_bahasa: "0",
        hambatan_emosi: "0",
        hambatan_penglihatan: "0",
        hambatan_bicara_buruk: "0",
        hambatan_cemas: "0",
        hambatan_tidak_partisipasi: "0",
        hambatan_kognitif: "0",
        hambatan_motivasi: "0",
        hambatan_fisiologi: "0",
        hambatan_pendengaran: "0",
        hambatan_hilang_memori: "0",
        hambatan_tidak_ada: "0",
        
        // Edukasi
        edukasi_tata_tertib: "0",
        edukasi_hak_kewajiban: "0",
        
        // Pengkajian Bicara
        bicara_normal: "0",
        bicara_gangguan: "0",
        
        // Bahasa Sehari-hari
        bahasa_indonesia: "0",
        bahasa_daerah: "0",
        bahasa_daerah_jelaskan: "",
        bahasa_inggris: "0",
        bahasa_lainnya: "0",
        bahasa_lainnya_jelaskan: "",
        
        // Bahasa Isyarat
        bahasa_isyarat_ya: "0",
        bahasa_isyarat_tidak: "0",
        
        // Tingkat Pendidikan
        pendidikan_tk: "0",
        pendidikan_sd: "0",
        pendidikan_smp: "0",
        pendidikan_sma: "0",
        pendidikan_diploma: "0",
        pendidikan_sarjana: "0",
        pendidikan_lainnya: "0",
        pendidikan_lainnya_jelaskan: "",
        
        // Agama
        agama_islam: "0",
        agama_protestan: "0",
        agama_katolik: "0",
        agama_hindu: "0",
        agama_budha: "0",
        agama_lainnya: "0",
        
        // Tingkat Pengetahuan
        pengetahuan_paham: "0",
        pengetahuan_kurang_paham: "0",
        pengetahuan_tidak_paham: "0",
        
        // Nilai Budaya
        budaya_modern: "0",
        budaya_moderat: "0",
        budaya_konvensional: "0",
        
        // Merokok
        merokok_ya: "0",
        merokok_tidak: "0",
        
        // Konsumsi Alkohol
        alkohol_ya: "0",
        alkohol_tidak: "0",
        
        // Menerima Informasi
        menerima_informasi_ya: "0",
        menerima_informasi_tidak: "0",
        menerima_informasi_alasan: "",
        
        // Rencana Pendidikan Kesehatan
        rencana_proses_penyakit: "0",
        rencana_pengobatan: "0",
        rencana_nutrisi: "0",
        rencana_edukasi_kolaboratif: "0",
        rencana_lain_lain: "0",
        rencana_lain_lain_jelaskan: "",
        
        // Kebutuhan Privasi
        privasi_ya: "0",
        privasi_tidak: "0",

        // ✅ TABEL EDUKASI DINAMIS
        tabel_edukasi: [
          {
            tanggal: "",
            poliklinik: "",
            penjelasan_edukasi: "",
            ttd_petugas: "",
            nama_petugas: "",
            sasaran_edukasi: "",
            eval_sudah_dimengerti: "0",
            eval_re_demonstrasi: "0",
            eval_re_edukasi: "0"
          }
        ],
        
        // Tanda Tangan Pengkaji
        ttd_pengkaji: "",
        nama_pengkaji: "",
        tanggal_pengkaji: "",
        waktu_pengkaji: "",
        
        created_by: "",
        updated_by: "",
      }
    };
  },
  
  mounted() {
    console.log("🟢 COMPONENT - Mounted");
    console.log("🟢 COMPONENT - editData:", this.editData);
    console.log("🟢 COMPONENT - viewData:", this.viewData);
    console.log("🟢 COMPONENT - selectedPatient:", this.selectedPatient);
    
    this.disabledSubmit = false;
    
    if (this.viewData) {
      this.disabledSubmit = true;
      this.loadDataForEdit();
    } else if (this.editData) {
      console.log("🟢 MODE: EDIT");
      this.loadDataForEdit();
    } else {
      console.log("🟢 MODE: CREATE");
      this.setDataForm();
    }
  },
  
  methods: {
    // ✅ LOAD DATA FOR EDIT
    loadDataForEdit() {
      console.log("🟢 LOAD EDIT - Mulai load data");
      
      try {
        const dataSource = this.editData || this.viewData;
      
        if (!dataSource) {
          console.warn("🟢 LOAD EDIT - Tidak ada data!");
          this.setDataForm();
          return;
        }
      
        // Populate form (skip tabel_edukasi)
        Object.keys(this.form).forEach((key) => {
          if (key === 'tabel_edukasi') return; // Skip, handle terpisah
          
          if (dataSource.hasOwnProperty(key)) {
            let value = dataSource[key];
            this.form[key] = value !== null ? value : "";
          }
        });

        // ✅ Load tabel_edukasi
        if (dataSource.tabel_edukasi) {
          try {
            // Jika string JSON, parse
            if (typeof dataSource.tabel_edukasi === 'string') {
              this.form.tabel_edukasi = JSON.parse(dataSource.tabel_edukasi);
            } 
            // Jika sudah array
            else if (Array.isArray(dataSource.tabel_edukasi)) {
              this.form.tabel_edukasi = dataSource.tabel_edukasi;
            }
            
            // Validasi: pastikan minimal 1 baris
            if (!this.form.tabel_edukasi || this.form.tabel_edukasi.length === 0) {
              this.form.tabel_edukasi = [this.createEmptyTabelRow()];
            }
          } catch (e) {
            console.error("Error parsing tabel_edukasi:", e);
            this.form.tabel_edukasi = [this.createEmptyTabelRow()];
          }
        } else {
          // Jika tidak ada data tabel, buat baris kosong
          this.form.tabel_edukasi = [this.createEmptyTabelRow()];
        }
      
        console.log("🟢 LOAD EDIT - Form setelah populate:", this.form);
        console.log("🟢 LOAD EDIT - tabel_edukasi:", this.form.tabel_edukasi);
      
        // Load signature setelah DOM siap
        this.$nextTick(() => {
          this.loadSignatures(dataSource);
        });
      
      } catch (error) {
        console.error("🟢 LOAD EDIT - Error:", error);
        alert("Gagal memuat data untuk edit!");
        this.$emit("back");
      }
    },

    // ✅ LOAD SIGNATURES
    loadSignatures(data) {
      // Load signature pengkaji
      if (data.ttd_pengkaji && this.$refs.ttd_pengkaji) {
        try {
          this.$refs.ttd_pengkaji.fromDataURL(data.ttd_pengkaji);
          console.log("✅ Loaded ttd_pengkaji");
        } catch (err) {
          console.error('Gagal load signature ttd_pengkaji:', err);
        }
      }

      // Load signatures tabel
      if (this.form.tabel_edukasi && Array.isArray(this.form.tabel_edukasi)) {
        this.form.tabel_edukasi.forEach((item, index) => {
          if (item.ttd_petugas) {
            this.$nextTick(() => {
              const refKey = `ttd_petugas_${index}`;
              const pad = this.$refs[refKey];
              
              if (pad) {
                try {
                  // Ref dalam v-for adalah array
                  if (Array.isArray(pad) && pad[0]) {
                    pad[0].fromDataURL(item.ttd_petugas);
                  } else {
                    pad.fromDataURL(item.ttd_petugas);
                  }
                  console.log(`✅ Loaded signature tabel ${index}`);
                } catch (err) {
                  console.error(`Gagal load ttd tabel ${index}:`, err);
                }
              }
            });
          }
        });
      }
    },

    // ✅ SET DATA FORM (untuk mode CREATE)
    setDataForm() {
      const today = new Date();
      this.form.tanggal_pengkaji = today.toISOString().split("T")[0];
      this.form.waktu_pengkaji = today.toTimeString().substring(0, 5);

      if (this.selectedPatient) {
        this.form.uuid_pasien = this.selectedPatient.uuid;
        this.form.no_rm = this.selectedPatient.rekam_medis;
        this.form.nama_pasien = this.selectedPatient.nama;
        this.form.nik = this.selectedPatient.nik || ""; 
        this.form.tanggal_lahir = this.selectedPatient.tanggal_lahir;
        this.form.jenis_kelamin = this.selectedPatient.jenis_kelamin || "L";
        this.form.alamat = this.selectedPatient.alamat || "";
      }
      
      // Pastikan tabel_edukasi ada minimal 1 baris
      if (!this.form.tabel_edukasi || this.form.tabel_edukasi.length === 0) {
        this.form.tabel_edukasi = [this.createEmptyTabelRow()];
      }
    },

    // ✅ CREATE EMPTY ROW
    createEmptyTabelRow() {
      return {
        tanggal: "",
        poliklinik: "",
        penjelasan_edukasi: "",
        ttd_petugas: "",
        nama_petugas: "",
        sasaran_edukasi: "",
        eval_sudah_dimengerti: "0",
        eval_re_demonstrasi: "0",
        eval_re_edukasi: "0"
      };
    },

    // ✅ TAMBAH BARIS TABEL
    tambahTabelEdukasi() {
      this.form.tabel_edukasi.push(this.createEmptyTabelRow());
      console.log("✅ Baris baru ditambahkan. Total:", this.form.tabel_edukasi.length);
    },

    // ✅ HAPUS BARIS TABEL
    hapusTabelEdukasi(index) {
      if (this.form.tabel_edukasi.length > 1) {
        this.form.tabel_edukasi.splice(index, 1);
        console.log(`✅ Baris ${index} dihapus. Total:`, this.form.tabel_edukasi.length);
      } else {
        alert("Minimal harus ada 1 baris!");
      }
    },

    // ✅ SAVE SIGNATURE (support tabel dinamis)
    saveSign(refNameOrIndex) {
      let pad;
      
      // Jika angka (untuk tabel)
      if (typeof refNameOrIndex === 'number') {
        const index = refNameOrIndex;
        const refKey = `ttd_petugas_${index}`;
        pad = this.$refs[refKey];
        
        if (pad) {
          try {
            // Ref dalam v-for adalah array
            const signPad = Array.isArray(pad) ? pad[0] : pad;
            const { data } = signPad.saveSignature();
            
            this.form.tabel_edukasi[index].ttd_petugas = data;
            console.log(`✅ TTD tabel ${index} saved`);
            alert(`Tanda tangan baris ${index + 1} tersimpan!`);
          } catch (err) {
            console.error(`Error save ttd tabel ${index}:`, err);
            alert("Gagal menyimpan tanda tangan!");
          }
        } else {
          console.error(`Ref ${refKey} tidak ditemukan`);
        }
      } 
      // Jika string (untuk signature lain seperti pengkaji)
      else {
        pad = this.$refs[refNameOrIndex];
        if (pad) {
          const { data } = pad.saveSignature();
          this.form[refNameOrIndex] = data;
          console.log("✅ TTD saved:", refNameOrIndex);
          alert("Tanda tangan tersimpan!");
        } else {
          console.error("REF tidak ditemukan:", refNameOrIndex);
        }
      }
    },

    // ✅ CLEAR SIGNATURE (support tabel dinamis)
    clearSign(refNameOrIndex) {
      let pad;
      
      if (typeof refNameOrIndex === 'number') {
        const index = refNameOrIndex;
        const refKey = `ttd_petugas_${index}`;
        pad = this.$refs[refKey];
        
        if (pad) {
          const signPad = Array.isArray(pad) ? pad[0] : pad;
          signPad.clearSignature();
          this.form.tabel_edukasi[index].ttd_petugas = "";
          console.log(`✅ TTD tabel ${index} cleared`);
        }
      } else {
        pad = this.$refs[refNameOrIndex];
        if (pad) {
          pad.clearSignature();
          this.form[refNameOrIndex] = "";
          console.log("✅ TTD cleared:", refNameOrIndex);
        }
      }
    },

    // ✅ SUBMIT FORM
    async submitForm() {
      this.loadingSubmit = true;

      try {
        const fd = new FormData();

        // Append semua field kecuali tabel_edukasi
        Object.keys(this.form).forEach((key) => {
          if (key === "uuid" && !this.form[key]) {
            return;
          }
          
          // Skip tabel_edukasi, akan di-handle terpisah
          if (key === "tabel_edukasi") {
            return;
          }
          
          fd.append(key, this.form[key]);
        });

        // ✅ Serialize tabel_edukasi sebagai JSON
        fd.append('tabel_edukasi', JSON.stringify(this.form.tabel_edukasi));

        console.log("📤 Mengirim data form:");
        console.log("📤 tabel_edukasi:", this.form.tabel_edukasi);

        const response = await axios.post(
          "/master/pasien/form-edukasi-pasien-dan-keluarga-rawat-jalan",
          fd,
          { headers: { "Content-Type": "multipart/form-data" } }
        );

        if (response.data.status) {
          alert(response.data.message);
          this.$emit("back");
        } else {
          alert(response.data.message || "Gagal menyimpan!");
        }
      } catch (error) {
        console.error("ERROR:", error.response?.data || error);
        alert("Gagal menyimpan form!");
      } finally {
        this.loadingSubmit = false;
      }
    },
  },
};
</script>

<style scoped>


.form-rs {
  width: 100%;
  border-collapse: collapse;
  font-size: 14px;
}

.form-rs th,
.form-rs td {
  border: 1px solid #000;
  padding: 4px 6px;
  vertical-align: middle;
}

.form-rs th.center,
.form-rs td.center {
  text-align: center;
}

/* Tambahan untuk tabel edukasi */
.form-rs th {
  background-color: #f0f0f0;
  font-weight: bold;
  text-align: center;
}

.checkbox-group {
  display: flex;
  flex-direction: column;
  gap: 6px;
}

.checkbox-label {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  cursor: pointer;
  font-size: 14px;
}

.btn-add {
  background: #4caf50;
  color: white;
  padding: 10px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-weight: 500;
  font-size: 14px;
  margin-top: 10px;
}

.btn-add:hover {
  background: #45a049;
}

.btn-delete-small {
  background: #f44336;
  color: white;
  border: none;
  border-radius: 50%;
  width: 28px;
  height: 28px;
  cursor: pointer;
  font-size: 16px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
}

.btn-delete-small:hover {
  background: #d32f2f;
}

.dokter-dpjp-box {
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.ttd-container-small {
  width: 100%;
}

.signature-box-header {
  width: 100% !important;
  height: 120px !important;
  border: 1px solid #ccc;
  border-radius: 4px;
}

.line-input {
  width: 100%;
  border: none;
  padding: 2px;
  font-size: 14px;
}

.line-input1 {
  width: 100%;
  border: 1px solid #000;
  padding: 2px;
  font-size: 14px;
}

.grid-3 {
  display: grid;
  grid-template-columns: 0.8fr 1fr 2.1fr;  /* kolom 1 kecil, 2 sedang, 3 besar */
  column-gap: 25px;
  row-gap: 10px;
}

.grid-2 {
  display: grid;
  grid-template-columns: 0.5fr 1fr; /* kolom 1 kecil, 2 sedang, 3 besar */
  column-gap: 25px;
  row-gap: 10px;
}



.box-rme {
  border: 1px solid #dcdcdc;
  padding: 20px;
  border-radius: 6px;
  background: white;
  margin-bottom: 20px;
}

.line-input {
  border: none;
  border-bottom: 1px solid #000;
  width: 40%;        /* atur panjang garis */
  padding: 2px 4px;
  outline: none;
  background: transparent;
  font-size: 14px;
}

/* Layout kiri–kanan 50% */
.two-box-wrapper {
  display: flex;
  gap: 20px;
}

.two-box-wrapper .box-rme {
  flex: 1;
  width: 50%;
}

/* Jika mau responsif di HP */
@media (max-width: 768px) {
  .two-box-wrapper {
    flex-direction: column;
  }
}

.container {
  max-width: 1200px;
  margin: 0 auto;
}

.form-row-3-3 {
  display: flex;
  gap: 1rem; /* jarak antar kolom */
}

.form-row-3-3 > div {
  flex: 1;
  min-width: 0;
  padding: 0.5rem; /* tambahkan padding di dalam setiap kolom */
}

.signature-row-3 {
  display: flex;
  gap: 0.1rem;     /* jarak antar kolom */
  margin-top: 1.5rem;
}

.signature-row-3 > div {
  flex: 1;         /* biar ukurannya seimbang */
  padding: 1rem;   /* ruang di dalam setiap kolom */
  text-align: center;
  box-sizing: border-box;
}

.box-rme {
  border: 1px solid #dcdcdc;
  padding: 20px;
  border-radius: 6px;
  background: white;
  margin-bottom: 20px;
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

.input-rme:disabled,
.input-rme[readonly] {
  background: #e9ecef;
  cursor: not-allowed;
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

.checkbox-label {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  cursor: pointer;
  font-size: 14px;
}

.signature-box-rme {
  width: 350px !important;   /* paksa lebar */
  height: 220px !important;  /* paksa tinggi */
  border: 2px solid #ccc;
  border-radius: 6px;
}
.signature-actions {
  display: flex;
  justify-content: center; /* tombol rata tengah */
  gap: 10px;               /* jarak antar tombol */
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

.btn-clear {
  background: #f44336;
  color: white;
  padding: 6px 16px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-weight: 500;
  margin-left: 10px;
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
  position: sticky;
  bottom: 0;
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

.date-time-wrapper {
  display: flex;
  gap: 1rem;       /* jarak antar kolom */
}

.date-time-wrapper > div {
  flex: 1;         /* biar ukurannya seimbang */
  padding: 0.5rem; /* ruang di dalam setiap kolom */
}

.form-row-2 {
  display: flex;
  gap: 1rem;       /* jarak antar kolom */
}

.form-row-2 > div {
  flex: 1;         /* biar ukurannya seimbang */
  padding: 0.5rem; /* ruang di dalam setiap kolom */
}

.signature-row {
  display: flex;
  gap: 2rem;       /* jarak antar kolom kiri-kanan */
  margin-top: 2rem;
}

.signature-row > div {
  flex: 1;         /* biar ukurannya seimbang */
  padding: 1rem;   /* ruang di dalam setiap kolom */
  box-sizing: border-box;
}
.row {
  display: flex;
  flex-wrap: wrap;
  margin-left: -8px;
  margin-right: -8px;
}

.grid-display {
  display: grid;
  grid-template-columns: repeat(3, 1,1fr);
  column-gap: 25px;
  row-gap: 10px;
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

.mt-2 {
  margin-top: 8px;
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

.mx-auto {
  margin-left: auto;
  margin-right: auto;
}

.view-overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(255, 251, 251, 0.1); /* transparan */
  z-index: 10;
  cursor: not-allowed;
}

.form-wrapper {
  position: relative;
}

@media (max-width: 768px) {
  .col-md-4,
  .col-md-6 {
    flex: 0 0 100%;
    max-width: 100%;
  }
}
</style>
