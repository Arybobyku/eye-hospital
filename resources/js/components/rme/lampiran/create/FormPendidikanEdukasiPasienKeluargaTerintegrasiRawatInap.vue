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
            PENDIDIKAN EDUKASI PASIEN KELUARGA TERINTEGRASI RAWAT INAP <br>
          </h2>
      
          <h4 class="fw-semibold">RM 2.4/PEPKTRI/22 </h4>
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
          <input type="text" v-model="form.nama" class="input-rme" readonly />
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
                      <input type="checkbox" v-model="form.hambatan_bahasa"> Bahasa
                    </label>
                
                    <label class="checkbox-label">
                      <input type="checkbox" v-model="form.hambatan_emosi">  Emosi
                    </label>
                
                    <label class="checkbox-label">
                      <input type="checkbox" v-model="form.hambatan_masalah_penglihatan"> Masalah Penglihatan
                    </label>
                
                    <label class="checkbox-label">
                      <input type="checkbox" v-model="form.hambatan_bicara_buruk"> Bicara Buruk
                    </label>
                
                    <label class="checkbox-label">
                      <input type="checkbox" v-model="form.hambatan_cemas"> Cemas
                    </label>
                
                    <label class="checkbox-label">
                      <input type="checkbox" v-model="form.hambatan_tidak_ada_partisipasi">  Tidak ada partisipasi
                    </label>
                
                    <label class="checkbox-label">
                      <input type="checkbox" v-model="form.hambatan_kognitif"> Kognitif
                    </label>
                
                    <label class="checkbox-label">
                      <input type="checkbox" v-model="form.hambatan_motivasi"> Motivasi
                    </label>
                
                    <label class="checkbox-label">
                      <input type="checkbox" v-model="form.hambatan_fisiologi_tidak_mampu">Secara fisiologi tidak mampu belajar
                    </label>
                
                    <label class="checkbox-label">
                      <input type="checkbox" v-model="form.hambatan_pendengaran"> Pendengaran
                    </label>
                
                    <label class="checkbox-label">
                      <input type="checkbox" v-model="form.hambatan_hilang_memori">  Hilang Memori 
                    </label>
                
                    <label class="checkbox-label">
                      <input type="checkbox" v-model="form.hambatan_tidak_ditemukan"> Tidak ditemukan hambatan belajar
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
                      <input type="checkbox" v-model="form.edukasi_tata_tertib_rs"> Tata Tertib RS
                    </label>
                
                    <label class="checkbox-label">
                      <input type="checkbox" v-model="form.edukasi_hak_kewajiban">  Hak  Dan Kewajiban Pasien
                    </label>
                  </div>
                </div>
              <!-- Box Kanan -->
              <div class="box-rme mb-2">
                <h5 class="section-title-rme">Pengkajian Bicara</h5>
                <div class="grid-2">
                      <label class="checkbox-label">
                        <input type="checkbox" v-model="form.bicara_normal">Normal
                      </label>
                      <label class="checkbox-label">
                        <input type="checkbox" v-model="form.bicara_gangguan">Gangguan Bicara
                      </label>
                </div>
              </div>
            </div>

            <div class="two-box-wrapper">
                <div class="box-rme mb-2">
                  <h5 class="section-title-rme">Bahasa Sehari-Hari</h5>        
                  <div class="grid-2">
                    <label class="checkbox-label">
                      <input type="checkbox" v-model="form.bahasa_indonesia"> Indonesia
                    </label>
                    <label class="checkbox-label">
                      <input type="checkbox" v-model="form.bahasa_daerah" />
                      Daerah, Jelaskan 
                      <input type="text" class="line-input" v-model="form.bahasa_daerah_text"/>
                    </label>
                  </div>
                  <div class="grid-2">
                    <label class="checkbox-label">
                      <input type="checkbox" v-model="form.bahasa_inggris"> Inggris
                    </label>
                
                    <label class="checkbox-label">
                      <input type="checkbox" v-model="form.bahasa_lainnya">Lainnya                       
                      <input type="text" class="line-input" v-model="form.bahasa_lainnya_text"/>
                    </label>
                  </div>
                </div>
              <!-- Box Kanan -->
              <div class="box-rme mb-2">
                <h5 class="section-title-rme">Bahasa isyarat</h5>
                <div class="grid-2">
                      <label class="checkbox-label">
                        <input type="checkbox" v-model="form.bahasa_isyarat_ya">Ya
                      </label>
                      <label class="checkbox-label">
                        <input type="checkbox" v-model="form.bahasa_isyarat_tidak">Tidak
                      </label>
                </div>
              </div>
            </div>

            <div class="two-box-wrapper">
                <div class="box-rme mb-2">
                  <h5 class="section-title-rme">Tingkat Pendidikan</h5>        
                  <div class="grid-3">
                    <label class="checkbox-label">
                      <input type="checkbox" v-model="form.pendidikan_tk"> TK
                    </label>
                    <label class="checkbox-label">
                      <input type="checkbox" v-model="form.pendidikan_sd"> SD
                    </label>
                    <label class="checkbox-label">
                      <input type="checkbox" v-model="form.pendidikan_smp">SMP
                    </label>
                  </div>
                  <div class="grid-3">
                    <label class="checkbox-label">
                      <input type="checkbox" v-model="form.pendidikan_sma"> SMA
                    </label>
                    <label class="checkbox-label">
                      <input type="checkbox" v-model="form.pendidikan_diploma">Diploma
                    </label>
                
                    <label class="checkbox-label">
                      <input type="checkbox" v-model="form.pendidikan_sarjana">Sarjana
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-label">
                      <input type="checkbox" v-model="form.pendidikan_lainnya">Lainnya                       
                      <input type="text" class="line-input" v-model="form.pendidikan_lainnya_text"/>
                    </label>
                  </div>
                </div>
              <!-- Box Kanan -->
              <div class="box-rme mb-2">
                <h5 class="section-title-rme">Agama</h5>
                <div class="grid-3">
                   <label class="checkbox-label">
                     <input type="checkbox" v-model="form.agama_islam">Islam
                   </label>
                   <label class="checkbox-label">
                     <input type="checkbox" v-model="form.agama_protestan">Protestan
                   </label>
                   <label class="checkbox-label">
                     <input type="checkbox" v-model="form.agama_katolik">Katolik
                   </label>
                </div>
                                <div class="grid-3">
                   <label class="checkbox-label">
                     <input type="checkbox" v-model="form.agama_hindu">Hindu
                   </label>
                   <label class="checkbox-label">
                     <input type="checkbox" v-model="form.agama_budha">Budha
                   </label>
                   <label class="checkbox-label">
                     <input type="checkbox" v-model="form.agama_lainnya">Lain-lain
                   </label>
                </div>
              </div>
            </div>

            
            <div class="two-box-wrapper">
                <div class="box-rme mb-2">
                  <h5 class="section-title-rme">Tingkat Pengetahuan Tingkat Kesehatan Pasien</h5>        
                  <div class="grid-3">
                    <label class="checkbox-label">
                      <input type="checkbox" v-model="form.pengetahuan_paham"> Paham
                    </label>
                    <label class="checkbox-label">
                      <input type="checkbox" v-model="form.pengetahuan_kurang_paham"> Kurang Paham
                    </label>
                    <label class="checkbox-label">
                      <input type="checkbox" v-model="form.pengetahuan_tidak_paham">Tidak Paham
                    </label>
                  </div>
                </div>
              <!-- Box Kanan -->
              <div class="box-rme mb-2">
                <h5 class="section-title-rme">Nilai-Nilai Pasien Dan Budaya</h5>
                <div class="grid-3">
                   <label class="checkbox-label">
                     <input type="checkbox" v-model="form.budaya_modern">Modern
                   </label>
                   <label class="checkbox-label">
                     <input type="checkbox" v-model="form.budaya_moderat">Moderat
                   </label>
                   <label class="checkbox-label">
                     <input type="checkbox" v-model="form.budaya_konvensional">Konvensional
                   </label>
                </div>
              </div>
            </div>

            <div class="two-box-wrapper">
                <div class="box-rme mb-2">
                  <h5 class="section-title-rme">Merokok</h5>        
                  <div class="grid-2">
                    <label class="checkbox-label">
                      <input type="checkbox" v-model="form.merokok_ya"> Ya
                    </label>
                    <label class="checkbox-label">
                      <input type="checkbox" v-model="form.merokok_tidak"> Tidak
                    </label>
                  </div>
                </div>
              <!-- Box Kanan -->
              <div class="box-rme mb-2">
                <h5 class="section-title-rme">Konsumsi Alkohol</h5>
                <div class="grid-2">
                   <label class="checkbox-label">
                     <input type="checkbox" v-model="form.alkohol_ya">Ya
                   </label>
                   <label class="checkbox-label">
                     <input type="checkbox" v-model="form.alkohol_tidak">Tidak
                   </label>
                </div>
              </div>
            </div>

            <div class="two-box-wrapper">
                <div class="box-rme mb-2">
                  <h5 class="section-title-rme">Ketersedian Menerima Informasi</h5>        
                  <div class="grid-2">
                    <label class="checkbox-label">
                      <input type="checkbox" v-model="form.menerima_info_ya"> Ya
                    </label>
                    <label class="checkbox-label">
                      <input type="checkbox" v-model="form.menerima_info_tidak"> Tidak , Alasan
                      <input type="text" class="line-input" v-model="form.menerima_info_alasan"/>
                    </label>
                  </div>
                </div>
              <!-- Box Kanan -->
              <div class="box-rme mb-2">
                <h5 class="section-title-rme">Rencana Pendidikan Kesehatan</h5>
                <div class="grid-2">
                    <label class="checkbox-label">
                      <input type="checkbox" v-model="form.rencana_proses_penyakit"> Proses Penyakit
                    </label>
                    <label class="checkbox-label">
                      <input type="checkbox" v-model="form.rencana_pengobatan_tindakan"/>Pengobatan/Tindakan 
                    </label>
                  </div>
                  <div class="grid-2">
                    <label class="checkbox-label">
                      <input type="checkbox" v-model="form.rencana_nutrisi"> Nutrisi
                    </label>
                    <label class="checkbox-label">
                      <input type="checkbox" v-model="form.rencana_edukasi_kolaboratif"/>Edukasi kolaboratif
                    </label>
                  </div>
                  <div class="grid-2">
                    <label class="checkbox-label">
                      <input type="checkbox" v-model="form.rencana_lain_lain"> Lain Lain
                    </label>
                    <label class="checkbox-label"> Jelaskan
                      <input type="text" class="line-input" v-model="form.rencana_lain_lain_text"/>
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
              <!-- Box Kanan -->
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
                      <input type="checkbox" v-model="form.privasi_ya"> Ya 
                    </label>
                    <label class="checkbox-label">
                      <input type="checkbox" v-model="form.privasi_tidak">Tidak
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
                    <VueSignaturePad ref="ttd_dokter" :options="sigOption" class="signature-box-rme mx-auto" />
                    <div class="signature-actions mt-2">
                      <button @click="clearSign('ttd_dokter')" class="btn-clear mt-2">Clear ↻</button>
                      <button @click="saveSign('ttd_dokter')" class="btn-save mt-2">Simpan ✔</button>
                    </div>
                </div>
            </div>
        </div>
<table class="form-rs">
  <thead>
    <tr>
      <th rowspan="2">Profesi</th>
      <th rowspan="2">Tanggal<br>Jam</th>
<th rowspan="2">
  KEBUTUHAN EDUKASI /<br>TOPIK EDUKASI
  <div class="dokter-dpjp-box">
    <div class="ttd-container-small">
      <VueSignaturePad ref="ttd_dokter_dpjp" :options="sigOption" class="signature-box-header" />
      <div class="signature-actions mt-2">
      <button @click="clearSign('ttd_dokter_dpjp')" class="btn-clear mt-2">Clear ↻</button>
      <button @click="saveSign('ttd_dokter_dpjp')" class="btn-save mt-2">Simpan ✔</button>
      </div>
    </div>
    <div class="input-dokter-dpjp">
      <input type="text" v-model="form.nama_dokter_dpjp" class="line-input1" placeholder="Nama Dokter DPJP">
    </div>
  </div>
</th>
      <th class="profesi-header">Penerima Pendidikan</th>
      <th class="profesi-header">Metode</th>
      <th class="profesi-header">Frekuensi Edukasi</th>
      <th class="profesi-header">Evaluasi Respon</th>
      <th colspan="2" rowspan="">Nama dan Tanda<br>Tangan</th>
    </tr>
    <tr>
<th class="center sub-header">
  <div class="number-box">P</div>
  <div class="number-box">K</div> <br>
  <div class="number-box">L</div>
</th>
<th class="center sub-header">
  <div class="number-box">1</div>
  <div class="number-box">2</div> <br>
  <div class="number-box">3</div>
  <div class="number-box">4</div> <br>
  <div class="number-box">5</div>
</th>
<th class="center sub-header">
  <div class="number-box">1</div>
  <div class="number-box">2</div>
</th>
<th class="center sub-header">
  <div class="number-box">1</div>
  <div class="number-box">2</div> <br>
  <div class="number-box">3</div>
  <div class="number-box">4</div>
</th>
      <th class="center sub-header"> Pemberi Edukasi</th>
      <th class="center sub-header"> Penerima Edukasi</th>
    </tr>
  </thead>

  <tbody>
    <!-- Dokter Section -->
    <tr>
      <td rowspan="9"><b>Dokter</b></td>
      <td rowspan="9">
        <div class="date-time-wrapper">
          <div>
            <label>Tanggal:</label>
            <input type="date" v-model="form.tanggal_dokter" class="input-rme" />
          </div>
          <div>
            <label>Waktu:</label>
            <input type="time" v-model="form.waktu_dokter" class="input-rme" />
          </div>
        </div>
      </td>
      <td>
        <label class="checkbox-label">
          <input type="checkbox" v-model="form.edukasi_dokter1" value="Penjelasan penyakit">
          <span>Penjelasan penyakit, penyebab, tanda, gejala, prognosi dan terapi</span>
        </label>
      </td>
      <td class="center">
        <select v-model="form.promotif_dokter_1" class="form-select">
          <option value="">-</option>
          <option value="P">P</option>
          <option value="K">K</option>
          <option value="L">L</option>
        </select>
      </td>
      <td class="center">
        <select v-model="form.metode_dokter_1" class="form-select">
          <option value="">-</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
        </select>
      </td>
      <td class="center">
        <select v-model="form.profesional_dokter_1" class="form-select">
          <option value="">-</option>
          <option value="1">1</option>
          <option value="2">2</option>
        </select>
      </td>
      <td class="center">
        <select v-model="form.evaluasi_dokter_1" class="form-select">
          <option value="">-</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
        </select>
      </td>
      <td rowspan="9">
          <div class="text-center">
            <VueSignaturePad ref="ttd_pemberi_dokter" :options="sigOption" class="signature-box-rme1 mx-auto" />
            <input type="text" v-model="form.nama_pemberi_dokter" class="input-rme1 mt-2" placeholder="Nama Dokter" />
            <div class="signature-actions1 mt-2">
              <button @click="clearSign('ttd_pemberi_dokter')" class="btn-clear mt-2">Clear</button>
              <button @click="saveSign('ttd_pemberi_dokter')" class="btn-save mt-2 d-block mx-auto">Simpan</button>
              </div>          
            </div>
      </td>
      <td rowspan="9">
          <div class="text-center">
            <VueSignaturePad ref="ttd_penerima_dokter" :options="sigOption" class="signature-box-rme1 mx-auto" />
            <input type="text" v-model="form.nama_penerima_dokter" class="input-rme1 mt-2" placeholder="Nama Dokter" />
            <div class="signature-actions1 mt-2">
              <button @click="clearSign('ttd_penerima_dokter')" class="btn-clear mt-2">Clear</button>
            <button @click="saveSign('ttd_penerima_dokter')" class="btn-save mt-2 d-block mx-auto">Simpan</button>
            </div>
          </div>
      </td>
    </tr>

    

    <tr>
      <td>
        <label class="checkbox-label">
          <input type="checkbox" v-model="form.edukasi_dokter2" value="Hasil pemeriksaan">
          <span>Hasil pemeriksaan penunjang</span>
        </label>
      </td>
      <td class="center">
        <select v-model="form.promotif_dokter_2" class="form-select">
          <option value="">-</option>
          <option value="P">P</option>
          <option value="K">K</option>
          <option value="L">L</option>
        </select>
      </td>
      <td class="center">
        <select v-model="form.metode_dokter_2" class="form-select">
          <option value="">-</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
        </select>
      </td>
      <td class="center">
        <select v-model="form.profesional_dokter_2" class="form-select">
          <option value="">-</option>
          <option value="1">1</option>
          <option value="2">2</option>
        </select>
      </td>
      <td class="center">
        <select v-model="form.evaluasi_dokter_2" class="form-select">
          <option value="">-</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
        </select>
      </td>
    </tr>

    <tr>
      <td>
        <label class="checkbox-label">
          <input type="checkbox" v-model="form.edukasi_dokter3" value="Hasil pengobatan">
          <span>Hasil pengobatan</span>
        </label>
      </td>
      <td class="center">
        <select v-model="form.promotif_dokter_3" class="form-select">
          <option value="">-</option>
          <option value="P">P</option>
          <option value="K">K</option>
          <option value="L">L</option>
        </select>
      </td>
      <td class="center">
        <select v-model="form.metode_dokter_3" class="form-select">
          <option value="">-</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
        </select>
      </td>
      <td class="center">
        <select v-model="form.profesional_dokter_3" class="form-select">
          <option value="">-</option>
          <option value="1">1</option>
          <option value="2">2</option>
        </select>
      </td>
      <td class="center">
        <select v-model="form.evaluasi_dokter_3" class="form-select">
          <option value="">-</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
        </select>
      </td>
    </tr>

    <tr>
      <td>
        <label class="checkbox-label">
          <input type="checkbox" v-model="form.edukasi_dokter4" value="Rencana penatalaksanaan">
          <span>Rencana penatalaksanaan/hasil yang tidak diharapkan</span>
        </label>
      </td>
      <td class="center">
        <select v-model="form.promotif_dokter_4" class="form-select">
          <option value="">-</option>
          <option value="P">P</option>
          <option value="K">K</option>
          <option value="L">L</option>
        </select>
      </td>
      <td class="center">
        <select v-model="form.metode_dokter_4" class="form-select">
          <option value="">-</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
        </select>
      </td>
      <td class="center">
        <select v-model="form.profesional_dokter_4" class="form-select">
          <option value="">-</option>
          <option value="1">1</option>
          <option value="2">2</option>
        </select>
      </td>
      <td class="center">
        <select v-model="form.evaluasi_dokter_4" class="form-select">
          <option value="">-</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
        </select>
      </td>
    </tr>

    <tr>
      <td>
        <label class="checkbox-label">
          <input type="checkbox" v-model="form.edukasi_dokter5" value="Tindakan medis">
          <span>Tindakan medis</span>
        </label>
      </td>
      <td class="center">
        <select v-model="form.promotif_dokter_5" class="form-select">
          <option value="">-</option>
          <option value="P">P</option>
          <option value="K">K</option>
          <option value="L">L</option>
        </select>
      </td>
      <td class="center">
        <select v-model="form.metode_dokter_5" class="form-select">
          <option value="">-</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
        </select>
      </td>
      <td class="center">
        <select v-model="form.profesional_dokter_5" class="form-select">
          <option value="">-</option>
          <option value="1">1</option>
          <option value="2">2</option>
        </select>
      </td>
      <td class="center">
        <select v-model="form.evaluasi_dokter_5" class="form-select">
          <option value="">-</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
        </select>
      </td>
    </tr>

    <tr>
      <td>
        <label class="checkbox-label">
          <input type="checkbox" v-model="form.edukasi_dokter6" value="Nama obat">
          <span>Nama obat, kegunaan, cara pemberian, efek samping dan interaksi</span>
        </label>
      </td>
      <td class="center">
        <select v-model="form.promotif_dokter_6" class="form-select">
          <option value="">-</option>
          <option value="P">P</option>
          <option value="K">K</option>
          <option value="L">L</option>
        </select>
      </td>
      <td class="center">
        <select v-model="form.metode_dokter_6" class="form-select">
          <option value="">-</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
        </select>
      </td>
      <td class="center">
        <select v-model="form.profesional_dokter_6" class="form-select">
          <option value="">-</option>
          <option value="1">1</option>
          <option value="2">2</option>
        </select>
      </td>
      <td class="center">
        <select v-model="form.evaluasi_dokter_6" class="form-select">
          <option value="">-</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
        </select>
      </td>
    </tr>

    <tr>
      <td>
        <label class="checkbox-label">
          <input type="checkbox" v-model="form.edukasi_dokter7" value="Perkiraan hari rawat">
          <span>Perkiraan hari rawat</span>
        </label>
      </td>
      <td class="center">
        <select v-model="form.promotif_dokter_7" class="form-select">
          <option value="">-</option>
          <option value="P">P</option>
          <option value="K">K</option>
          <option value="L">L</option>
        </select>
      </td>
      <td class="center">
        <select v-model="form.metode_dokter_7" class="form-select">
          <option value="">-</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
        </select>
      </td>
      <td class="center">
        <select v-model="form.profesional_dokter_7" class="form-select">
          <option value="">-</option>
          <option value="1">1</option>
          <option value="2">2</option>
        </select>
      </td>
      <td class="center">
        <select v-model="form.evaluasi_dokter_7" class="form-select">
          <option value="">-</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
        </select>
      </td>
    </tr>

    <tr>
      <td>
        <label class="checkbox-label">
          <input type="checkbox" v-model="form.edukasi_dokter8" value="Komplikasi penyakit">
          <span>Komplikasi penyakit yang mungkin terjadi</span>
        </label>
      </td>
      <td class="center">
        <select v-model="form.promotif_dokter_8" class="form-select">
          <option value="">-</option>
          <option value="P">P</option>
          <option value="K">K</option>
          <option value="L">L</option>
        </select>
      </td>
      <td class="center">
        <select v-model="form.metode_dokter_8" class="form-select">
          <option value="">-</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
        </select>
      </td>
      <td class="center">
        <select v-model="form.profesional_dokter_8" class="form-select">
          <option value="">-</option>
          <option value="1">1</option>
          <option value="2">2</option>
        </select>
      </td>
      <td class="center">
        <select v-model="form.evaluasi_dokter_8" class="form-select">
          <option value="">-</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
        </select>
      </td>
    </tr>

    <tr>
      <td>
        <label class="checkbox-label">
          <input type="checkbox" v-model="form.edukasi_dokter9" value="Manajemen nyeri">
          <span>Manajemen nyeri farmakologis</span>
        </label>
      </td>
      <td class="center">
        <select v-model="form.promotif_dokter_9" class="form-select">
          <option value="">-</option>
          <option value="P">P</option>
          <option value="K">K</option>
          <option value="L">L</option>
        </select>
      </td>
      <td class="center">
        <select v-model="form.metode_dokter_9" class="form-select">
          <option value="">-</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
        </select>
      </td>
      <td class="center">
        <select v-model="form.profesional_dokter_9" class="form-select">
          <option value="">-</option>
          <option value="1">1</option>
          <option value="2">2</option>
        </select>
      </td>
      <td class="center">
        <select v-model="form.evaluasi_dokter_9" class="form-select">
          <option value="">-</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
        </select>
      </td>
    </tr>

    <!-- Perawat/Bidan Section -->
    <tr>
      <td rowspan="16"><b>Perawat/Bidan</b></td>
      <td rowspan="16">
        <div class="date-time-wrapper">
          <div>
            <label>Tanggal:</label>
            <input type="date" v-model="form.tanggal_perawat" class="input-rme" />
          </div>
          <div>
            <label>Waktu:</label>
            <input type="time" v-model="form.waktu_perawat" class="input-rme" />
          </div>
        </div>
      </td>
      <td>
        <label class="checkbox-label">
          <input type="checkbox" v-model="form.edukasi_perawat1" value="Guna gelang nama">
          <span>Guna gelang nama</span>
        </label>
      </td>
      <td class="center">
        <select v-model="form.promotif_perawat_1" class="form-select">
          <option value="">-</option>
          <option value="P">P</option>
          <option value="K">K</option>
          <option value="L">L</option>
        </select>
      </td>
      <td class="center">
        <select v-model="form.metode_perawat_1" class="form-select">
          <option value="">-</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
        </select>
      </td>
      <td class="center">
        <select v-model="form.profesional_perawat_1" class="form-select">
          <option value="">-</option>
          <option value="1">1</option>
          <option value="2">2</option>
        </select>
      </td>
      <td class="center">
        <select v-model="form.evaluasi_perawat_1" class="form-select">
          <option value="">-</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
        </select>
      </td>
      <td rowspan="16">
          <div class="text-center">
              <VueSignaturePad ref="ttd_pemberi_perawat" :options="sigOption" class="signature-box-rme1 mx-auto" />
              <input type="text" v-model="form.nama_pemberi_perawat" class="input-rme1 mt-2" placeholder="Nama Perawat" />
              <div class="signature-actions1 mt-2">
              <button @click="clearSign('ttd_pemberi_perawat')" class="btn-clear mt-2">Clear</button>
              <button @click="saveSign('ttd_pemberi_perawat')" class="btn-save mt-2 d-block mx-auto">Simpan</button>
          </div></div>
      </td>
      <td rowspan="16">
            <div class="text-center">
              <VueSignaturePad ref="ttd_penerima_perawat" :options="sigOption" class="signature-box-rme1 mx-auto" />
              <input type="text" v-model="form.nama_penerima_perawat" class="input-rme1 mt-2" placeholder="Nama Perawat" />
              <div class="signature-actions1 mt-2">
              <button @click="clearSign('ttd_penerima_perawat')" class="btn-clear mt-2">Clear</button>
              <button @click="saveSign('ttd_penerima_perawat')" class="btn-save mt-2 d-block mx-auto">Simpan</button> </div>
          </div>
      </td>
    </tr>

    <tr>
      <td>
        <label class="checkbox-label">
          <input type="checkbox" v-model="form.edukasi_perawat2" value="Guna pemasangan infus">
          <span>Guna pemasangan infus</span>
        </label>
      </td>
      <td class="center">
        <select v-model="form.promotif_perawat_2" class="form-select">
          <option value="">-</option>
          <option value="P">P</option>
          <option value="K">K</option>
          <option value="L">L</option>
        </select>
      </td>
      <td class="center">
        <select v-model="form.metode_perawat_2" class="form-select">
          <option value="">-</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
        </select>
      </td>
      <td class="center">
        <select v-model="form.profesional_perawat_2" class="form-select">
          <option value="">-</option>
          <option value="1">1</option>
          <option value="2">2</option>
        </select>
      </td>
      <td class="center">
        <select v-model="form.evaluasi_perawat_2" class="form-select">
          <option value="">-</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
        </select>
      </td>
    </tr>

    <tr>
      <td>
        <label class="checkbox-label">
          <input type="checkbox" v-model="form.edukasi_perawat3" value="Penundan/terlambat">
          <span>Penundan/terlambat pelayanan, alasan alternatif lain</span>
        </label>
      </td>
      <td class="center">
        <select v-model="form.promotif_perawat_3" class="form-select">
          <option value="">-</option>
          <option value="P">P</option>
          <option value="K">K</option>
          <option value="L">L</option>
        </select>
      </td>
      <td class="center">
        <select v-model="form.metode_perawat_3" class="form-select">
          <option value="">-</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
        </select>
      </td>
      <td class="center">
        <select v-model="form.profesional_perawat_3" class="form-select">
          <option value="">-</option>
          <option value="1">1</option>
          <option value="2">2</option>
        </select>
      </td>
      <td class="center">
        <select v-model="form.evaluasi_perawat_3" class="form-select">
          <option value="">-</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
        </select>
      </td>
    </tr>

    <tr>
      <td>
        <label class="checkbox-label">
          <input type="checkbox" v-model="form.edukasi_perawat4" value="Penggunaan peralatan">
          <span>Penggunaan peralatan medis yang aman</span>
        </label>
      </td>
      <td class="center">
        <select v-model="form.promotif_perawat_4" class="form-select">
          <option value="">-</option>
          <option value="P">P</option>
          <option value="K">K</option>
          <option value="L">L</option>
        </select>
      </td>
      <td class="center">
        <select v-model="form.metode_perawat_4" class="form-select">
          <option value="">-</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
        </select>
      </td>
      <td class="center">
        <select v-model="form.profesional_perawat_4" class="form-select">
          <option value="">-</option>
          <option value="1">1</option>
          <option value="2">2</option>
        </select>
      </td>
      <td class="center">
        <select v-model="form.evaluasi_perawat_4" class="form-select">
          <option value="">-</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
        </select>
      </td>
    </tr>

    <tr>
      <td>
        <label class="checkbox-label">
          <input type="checkbox" v-model="form.edukasi_perawat5" value="Manajemen nyeri farmakologis">
          <span>Manajemen nyeri farmakologis</span>
        </label>
      </td>
      <td class="center">
        <select v-model="form.promotif_perawat_5" class="form-select">
          <option value="">-</option>
          <option value="P">P</option>
          <option value="K">K</option>
          <option value="L">L</option>
        </select>
      </td>
      <td class="center">
        <select v-model="form.metode_perawat_5" class="form-select">
          <option value="">-</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
        </select>
      </td>
      <td class="center">
        <select v-model="form.profesional_perawat_5" class="form-select">
          <option value="">-</option>
          <option value="1">1</option>
          <option value="2">2</option>
        </select>
      </td>
      <td class="center">
        <select v-model="form.evaluasi_perawat_5" class="form-select">
          <option value="">-</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
        </select>
      </td>
    </tr>

    <tr>
      <td>
        <label class="checkbox-label">
          <input type="checkbox" v-model="form.edukasi_perawat6" value="Manajemen nyeri intervensi">
          <span>Manajemen nyeri intervensi</span>
        </label>
      </td>
      <td class="center">
        <select v-model="form.promotif_perawat_6" class="form-select">
          <option value="">-</option>
          <option value="P">P</option>
          <option value="K">K</option>
          <option value="L">L</option>
        </select>
      </td>
      <td class="center">
        <select v-model="form.metode_perawat_6" class="form-select">
          <option value="">-</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
        </select>
      </td>
      <td class="center">
        <select v-model="form.profesional_perawat_6" class="form-select">
          <option value="">-</option>
          <option value="1">1</option>
          <option value="2">2</option>
        </select>
      </td>
      <td class="center">
        <select v-model="form.evaluasi_perawat_6" class="form-select">
          <option value="">-</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
        </select>
      </td>
    </tr>

    <!-- TAMBAHAN SECTION -->
    <tr>
      <td>
        <label class="checkbox-label">
          <input type="checkbox" v-model="form.edukasi_tambahan1" value="Edukasi persetujuan tindakan operasi">
          <span>Edukasi persetujuan tindakan operasi</span>
        </label>
      </td>
      <td class="center">
        <select v-model="form.promotif_tambahan1_1" class="form-select">
          <option value="">-</option>
          <option value="P">P</option>
          <option value="K">K</option>
          <option value="L">L</option>
        </select>
      </td>
      <td class="center">
        <select v-model="form.metode_tambahan1_1" class="form-select">
          <option value="">-</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
        </select>
      </td>
      <td class="center">
        <select v-model="form.profesional_tambahan1_1" class="form-select">
          <option value="">-</option>
          <option value="1">1</option>
          <option value="2">2</option>
        </select>
      </td>
      <td class="center">
        <select v-model="form.evaluasi_tambahan1_1" class="form-select">
          <option value="">-</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
        </select>
      </td>
    </tr>

    <tr>
      <td>
        <label class="checkbox-label">
          <input type="checkbox" v-model="form.edukasi_tambahan2" value="Cara mencuci tangan yang benar">
          <span>Cara mencuci tangan yang benar</span>
        </label>
      </td>
      <td class="center">
        <select v-model="form.promotif_tambahan1_2" class="form-select">
          <option value="">-</option>
          <option value="P">P</option>
          <option value="K">K</option>
          <option value="L">L</option>
        </select>
      </td>
      <td class="center">
        <select v-model="form.metode_tambahan1_2" class="form-select">
          <option value="">-</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
        </select>
      </td>
      <td class="center">
        <select v-model="form.profesional_tambahan1_2" class="form-select">
          <option value="">-</option>
          <option value="1">1</option>
          <option value="2">2</option>
        </select>
      </td>
      <td class="center">
        <select v-model="form.evaluasi_tambahan1_2" class="form-select">
          <option value="">-</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
        </select>
        </td>
    </tr>

      <tr>
        <td>
          <label class="checkbox-label">
            <input type="checkbox" v-model="form.edukasi_tambahan3" value="Persetujuan biaya">
            <span>Persetujuan biaya ...</span>
          </label>
        </td>
        <td class="center">
          <select v-model="form.promotif_tambahan1_3" class="form-select">
            <option value="">-</option>
            <option value="P">P</option>
            <option value="K">K</option>
            <option value="L">L</option>
          </select>
        </td>
        <td class="center">
          <select v-model="form.metode_tambahan1_3" class="form-select">
            <option value="">-</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
          </select>
        </td>
        <td class="center">
          <select v-model="form.profesional_tambahan1_3" class="form-select">
            <option value="">-</option>
            <option value="1">1</option>
            <option value="2">2</option>
          </select>
        </td>
        <td class="center">
          <select v-model="form.evaluasi_tambahan1_3" class="form-select">
            <option value="">-</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
          </select>
        </td>
      </tr>

      <tr>
        <td>
          <label class="checkbox-label">
            <input type="checkbox" v-model="form.edukasi_tambahan4" value="Pemberian imunisasi">
            <span>Pemberian imunisasi</span>
          </label>
        </td>
        <td class="center">
          <select v-model="form.promotif_tambahan1_4" class="form-select">
            <option value="">-</option>
            <option value="P">P</option>
            <option value="K">K</option>
            <option value="L">L</option>
          </select>
        </td>
        <td class="center">
          <select v-model="form.metode_tambahan1_4" class="form-select">
            <option value="">-</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
          </select>
        </td>
        <td class="center">
          <select v-model="form.profesional_tambahan1_4" class="form-select">
            <option value="">-</option>
            <option value="1">1</option>
            <option value="2">2</option>
          </select>
        </td>
        <td class="center">
          <select v-model="form.evaluasi_tambahan1_4" class="form-select">
            <option value="">-</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
          </select>
        </td>
      </tr>

      <tr>
        <td>
          <label class="checkbox-label">
            <input type="checkbox" v-model="form.edukasi_tambahan5" value="Inisiasi menyusui dini">
            <span>Inisiasi menyusui dini</span>
          </label>
        </td>
        <td class="center">
          <select v-model="form.promotif_tambahan1_5" class="form-select">
            <option value="">-</option>
            <option value="P">P</option>
            <option value="K">K</option>
            <option value="L">L</option>
          </select>
        </td>
        <td class="center">
          <select v-model="form.metode_tambahan1_5" class="form-select">
            <option value="">-</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
          </select>
        </td>
        <td class="center">
          <select v-model="form.profesional_tambahan1_5" class="form-select">
            <option value="">-</option>
            <option value="1">1</option>
            <option value="2">2</option>
          </select>
        </td>
        <td class="center">
          <select v-model="form.evaluasi_tambahan1_5" class="form-select">
            <option value="">-</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
          </select>
        </td>
      </tr>

      <tr>
        <td>
          <label class="checkbox-label">
            <input type="checkbox" v-model="form.edukasi_tambahan6" value="Perawatan metode kangguru">
            <span>Perawatan metode kangguru</span>
          </label>
        </td>
        <td class="center">
          <select v-model="form.promotif_tambahan1_6" class="form-select">
            <option value="">-</option>
            <option value="P">P</option>
            <option value="K">K</option>
            <option value="L">L</option>
          </select>
        </td>
        <td class="center">
          <select v-model="form.metode_tambahan1_6" class="form-select">
            <option value="">-</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
          </select>
        </td>
        <td class="center">
          <select v-model="form.profesional_tambahan1_6" class="form-select">
            <option value="">-</option>
            <option value="1">1</option>
            <option value="2">2</option>
          </select>
        </td>
        <td class="center">
          <select v-model="form.evaluasi_tambahan1_6" class="form-select">
            <option value="">-</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
          </select>
        </td>
      </tr>

      <tr>
        <td>
          <label class="checkbox-label">
            <input type="checkbox" v-model="form.edukasi_tambahan7" value="Cara merawat tali pusat dirumah">
            <span>Cara merawat tali pusat dirumah</span>
          </label>
        </td>
        <td class="center">
          <select v-model="form.promotif_tambahan1_7" class="form-select">
            <option value="">-</option>
            <option value="P">P</option>
            <option value="K">K</option>
            <option value="L">L</option>
          </select>
        </td>
        <td class="center">
          <select v-model="form.metode_tambahan1_7" class="form-select">
            <option value="">-</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
          </select>
        </td>
        <td class="center">
          <select v-model="form.profesional_tambahan1_7" class="form-select">
            <option value="">-</option>
            <option value="1">1</option>
            <option value="2">2</option>
          </select>
        </td>
        <td class="center">
          <select v-model="form.evaluasi_tambahan1_7" class="form-select">
            <option value="">-</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
          </select>
        </td>
      </tr>

      <tr>
        <td>
          <label class="checkbox-label">
            <input type="checkbox" v-model="form.edukasi_tambahan8" value="Imunisasi lanjutan">
            <span>Imunisasi lanjutan</span>
          </label>
        </td>
        <td class="center">
          <select v-model="form.promotif_tambahan1_8" class="form-select">
            <option value="">-</option>
            <option value="P">P</option>
            <option value="K">K</option>
            <option value="L">L</option>
          </select>
        </td>
        <td class="center">
          <select v-model="form.metode_tambahan1_8" class="form-select">
            <option value="">-</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
          </select>
        </td>
        <td class="center">
          <select v-model="form.profesional_tambahan1_8" class="form-select">
            <option value="">-</option>
            <option value="1">1</option>
            <option value="2">2</option>
          </select>
        </td>
        <td class="center">
          <select v-model="form.evaluasi_tambahan1_8" class="form-select">
            <option value="">-</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
          </select>
        </td>
      </tr>

      <tr>
        <td>
          <label class="checkbox-label">
            <input type="checkbox" v-model="form.edukasi_tambahan9" value="Intake output cairan">
            <span>Intake output cairan</span>
          </label>
        </td>
        <td class="center">
          <select v-model="form.promotif_tambahan1_9" class="form-select">
            <option value="">-</option>
            <option value="P">P</option>
            <option value="K">K</option>
            <option value="L">L</option>
          </select>
        </td>
        <td class="center">
          <select v-model="form.metode_tambahan1_9" class="form-select">
            <option value="">-</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
          </select>
        </td>
        <td class="center">
          <select v-model="form.profesional_tambahan1_9" class="form-select">
            <option value="">-</option>
            <option value="1">1</option>
            <option value="2">2</option>
          </select>
        </td>
        <td class="center">
          <select v-model="form.evaluasi_tambahan1_9" class="form-select">
            <option value="">-</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
          </select>
        </td>
      </tr>

      <tr>
        <td>
          <label class="checkbox-label">
            <input type="checkbox" v-model="form.edukasi_tambahan10" value="Pembatasan konsumsi ABG">
            <span>Pembatasan konsumsi ABG (air,buah, garam)</span>
          </label>
        </td>
        <td class="center">
          <select v-model="form.promotif_tambahan1_10" class="form-select">
            <option value="">-</option>
            <option value="P">P</option>
            <option value="K">K</option>
            <option value="L">L</option>
          </select>
        </td>
        <td class="center">
          <select v-model="form.metode_tambahan1_10" class="form-select">
            <option value="">-</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
          </select>
        </td>
        <td class="center">
          <select v-model="form.profesional_tambahan1_10" class="form-select">
            <option value="">-</option>
            <option value="1">1</option>
            <option value="2">2</option>
          </select>
        </td>
        <td class="center">
          <select v-model="form.evaluasi_tambahan1_10" class="form-select">
            <option value="">-</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
          </select>
        </td>
      </tr>

      <!-- Analis/Lab -->
      <tr>
        <td rowspan="1"> <b>Analis/Lab</b></td>
        <td rowspan="1">
          <div class="date-time-wrapper">
            <div>
              <label>Tanggal:</label>
              <input type="date" v-model="form.tanggal_analis" class="input-rme" />
            </div>
            <div>
              <label>Waktu:</label>
              <input type="time" v-model="form.waktu_analis" class="input-rme" />
            </div>
          </div>
        </td>
        <td>
          <label class="checkbox-label">
            <input type="checkbox" v-model="form.edukasi_analis" value="Pemeriksaan Lab">
            <span>Pemeriksaan Lab</span>
          </label>
        </td>
        <td class="center">
          <select v-model="form.promotif_analis" class="form-select">
            <option value="">-</option>
            <option value="P">P</option>
            <option value="K">K</option>
            <option value="L">L</option>
          </select>
        </td>
        <td class="center">
          <select v-model="form.metode_analis" class="form-select">
            <option value="">-</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
          </select>
        </td>
        <td class="center">
          <select v-model="form.profesional_analis" class="form-select">
            <option value="">-</option>
            <option value="1">1</option>
            <option value="2">2</option>
          </select>
        </td>
        <td class="center">
          <select v-model="form.evaluasi_analis" class="form-select">
            <option value="">-</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
          </select>
        </td>
        <td rowspan="1">
            <div class="text-center">
                <VueSignaturePad ref="ttd_pemberi_analis" :options="sigOption" class="signature-box-rme1 mx-auto" />
                <input type="text" v-model="form.nama_pemberi_analis" class="input-rme1 mt-2" placeholder="Nama Analis" />
              <div class="signature-actions1 mt-2">
              <button @click="clearSign('ttd_pemberi_analis')" class="btn-clear mt-2">Clear</button>
                <button @click="saveSign('ttd_pemberi_analis')" class="btn-save mt-2 d-block mx-auto">Simpan</button> </div>
            </div>
        </td>
        <td rowspan="1">
              <div class="text-center">
                <VueSignaturePad ref="ttd_penerima_analis" :options="sigOption" class="signature-box-rme1 mx-auto" />
                <input type="text" v-model="form.nama_penerima_analis" class="input-rme1 mt-2" placeholder="Nama Analis" />
              <div class="signature-actions1 mt-2">
              <button @click="clearSign('ttd_penerima_analis')" class="btn-clear mt-2">Clear</button>
                <button @click="saveSign('ttd_penerima_analis')" class="btn-save mt-2 d-block mx-auto">Simpan</button> </div>
            </div>
        </td>
      </tr>

      <!-- Ahli Gizi -->
      <tr>
        <td rowspan="2"><b>Ahli Gizi</b></td>
        <td rowspan="2">
          <div class="date-time-wrapper">
            <div>
              <label>Tanggal:</label>
              <input type="date" v-model="form.tanggal_gizi" class="input-rme" />
            </div>
            <div>
              <label>Waktu:</label>
              <input type="time" v-model="form.waktu_gizi" class="input-rme" />
            </div>
          </div>
        </td>
        <td>
          <label class="checkbox-label">
            <input type="checkbox" v-model="form.edukasi_gizi1" value="Diet yang memadai/food mode">
            <span>Diet yang memadai/food mode</span>
          </label>
        </td>
        <td class="center">
          <select v-model="form.promotif_gizi_1" class="form-select">
            <option value="">-</option>
            <option value="P">P</option>
            <option value="K">K</option>
            <option value="L">L</option>
          </select>
        </td>
        <td class="center">
          <select v-model="form.metode_gizi_1" class="form-select">
            <option value="">-</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
          </select>
        </td>
        <td class="center">
          <select v-model="form.profesional_gizi_1" class="form-select">
            <option value="">-</option>
            <option value="1">1</option>
            <option value="2">2</option>
          </select>
        </td>
        <td class="center">
          <select v-model="form.evaluasi_gizi_1" class="form-select">
            <option value="">-</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
          </select>
        </td>
        <td rowspan="2">
            <div class="text-center">
                <VueSignaturePad ref="ttd_pemberi_gizi" :options="sigOption" class="signature-box-rme1 mx-auto" />
                <input type="text" v-model="form.nama_pemberi_gizi" class="input-rme1 mt-2" placeholder="Nama Ahli Gizi" />
                              <div class="signature-actions1 mt-2">
              <button @click="clearSign('ttd_pemberi_gizi')" class="btn-clear mt-2">Clear</button>
                <button @click="saveSign('ttd_pemberi_gizi')" class="btn-save mt-2 d-block mx-auto">Simpan</button></div>
            </div>
        </td>
        <td rowspan="2">
              <div class="text-center">
                <VueSignaturePad ref="ttd_penerima_gizi" :options="sigOption" class="signature-box-rme1 mx-auto" />
                <input type="text" v-model="form.nama_penerima_gizi" class="input-rme1 mt-2" placeholder="Nama Ahli Gizi" />
              <div class="signature-actions1 mt-2">
              <button @click="clearSign('ttd_penerima_gizi')" class="btn-clear mt-2">Clear</button>
                <button @click="saveSign('ttd_penerima_gizi')" class="btn-save mt-2 d-block mx-auto">Simpan</button> </div>
            </div>
        </td>
      </tr>

      <tr>
        <td>
          <label class="checkbox-label">
            <input type="checkbox" v-model="form.edukasi_gizi2" value="Diet pasien pulang">
            <span>Diet pasien pulang</span>
          </label>
        </td>
        <td class="center">
          <select v-model="form.promotif_gizi_2" class="form-select">
            <option value="">-</option>
            <option value="P">P</option>
            <option value="K">K</option>
            <option value="L">L</option>
          </select>
        </td>
        <td class="center">
          <select v-model="form.metode_gizi_2" class="form-select">
            <option value="">-</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
          </select>
        </td>
        <td class="center">
          <select v-model="form.profesional_gizi_2" class="form-select">
            <option value="">-</option>
            <option value="1">1</option>
            <option value="2">2</option>
          </select>
        </td>
        <td class="center">
          <select v-model="form.evaluasi_gizi_2" class="form-select">
            <option value="">-</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
          </select>
        </td>
      </tr>

      <!-- Farmasi -->
      <tr>
        <td rowspan="4"> <b>Farmasi</b></td>
        <td rowspan="4">
          <div class="date-time-wrapper">
            <div>
              <label>Tanggal:</label>
              <input type="date" v-model="form.tanggal_farmasi" class="input-rme" />
            </div>
            <div>
              <label>Waktu:</label>
              <input type="time" v-model="form.waktu_farmasi" class="input-rme" />
            </div>
          </div>
        </td>
        <td>
          <label class="checkbox-label">
            <input type="checkbox" v-model="form.edukasi_farmasi1" value="Penggunaan obat-obatan secara efektif dan aman">
            <span>Penggunaan obat-obatan secara efektif dan aman</span>
          </label>
        </td>
        <td class="center">
          <select v-model="form.promotif_farmasi_1" class="form-select">
            <option value="">-</option>
            <option value="P">P</option>
            <option value="K">K</option>
            <option value="L">L</option>
          </select>
        </td>
        <td class="center">
          <select v-model="form.metode_farmasi_1" class="form-select">
            <option value="">-</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
          </select>
        </td>
        <td class="center">
          <select v-model="form.profesional_farmasi_1" class="form-select">
            <option value="">-</option>
            <option value="1">1</option>
            <option value="2">2</option>
          </select>
        </td>
        <td class="center">
          <select v-model="form.evaluasi_farmasi_1" class="form-select">
            <option value="">-</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
          </select>
        </td>
        <td rowspan="4">
            <div class="text-center">
                <VueSignaturePad ref="ttd_pemberi_farmasi" :options="sigOption" class="signature-box-rme1 mx-auto" />
                <input type="text" v-model="form.nama_pemberi_farmasi" class="input-rme1 mt-2" placeholder="Nama Farmasi" />
              <div class="signature-actions1 mt-2">
              <button @click="clearSign('ttd_pemberi_farmasi')" class="btn-clear mt-2">Clear</button>
                <button @click="saveSign('ttd_pemberi_farmasi')" class="btn-save mt-2 d-block mx-auto">Simpan</button></div>
            </div>
        </td>
        <td rowspan="4">
              <div class="text-center">
                <VueSignaturePad ref="ttd_penerima_farmasi" :options="sigOption" class="signature-box-rme1 mx-auto" />
                <input type="text" v-model="form.nama_penerima_farmasi" class="input-rme1 mt-2" placeholder="Nama Farmasi" />
                              <div class="signature-actions1 mt-2">
              <button @click="clearSign('ttd_penerima_farmasi')" class="btn-clear mt-2">Clear</button>
                <button @click="saveSign('ttd_penerima_farmasi')" class="btn-save mt-2 d-block mx-auto">Simpan</button> </div>
            </div>
        </td>
      </tr>

      <tr>
        <td>
          <label class="checkbox-label">
            <input type="checkbox" v-model="form.edukasi_farmasi2" value="Potensi efek samping obat">
            <span>Potensi efek samping obat</span>
          </label>
        </td>
        <td class="center">
          <select v-model="form.promotif_farmasi_2" class="form-select">
            <option value="">-</option>
            <option value="P">P</option>
            <option value="K">K</option>
            <option value="L">L</option>
          </select>
        </td>
        <td class="center">
          <select v-model="form.metode_farmasi_2" class="form-select">
            <option value="">-</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
          </select>
        </td>
        <td class="center">
          <select v-model="form.profesional_farmasi_2" class="form-select">
            <option value="">-</option>
            <option value="1">1</option>
            <option value="2">2</option>
          </select>
        </td>
        <td class="center">
          <select v-model="form.evaluasi_farmasi_2" class="form-select">
            <option value="">-</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
          </select>
        </td>
      </tr>

      <tr>
        <td>
          <label class="checkbox-label">
            <input type="checkbox" v-model="form.edukasi_farmasi3" value="Potensi interaksi obat">
            <span>Potensi interaksi obat antar obat konvensional, obat bebas, serta suplemen</span>
          </label>
        </td>
        <td class="center">
          <select v-model="form.promotif_farmasi_3" class="form-select">
            <option value="">-</option>
            <option value="P">P</option>
            <option value="K">K</option>
            <option value="L">L</option>
          </select>
        </td>
        <td class="center">
          <select v-model="form.metode_farmasi_3" class="form-select">
            <option value="">-</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
          </select>
        </td>
        <td class="center">
          <select v-model="form.profesional_farmasi_3" class="form-select">
            <option value="">-</option>
            <option value="1">1</option>
            <option value="2">2</option>
          </select>
        </td>
        <td class="center">
          <select v-model="form.evaluasi_farmasi_3" class="form-select">
            <option value="">-</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
          </select>
        </td>
      </tr>

      <tr>
        <td>
          <label class="checkbox-label">
            <input type="checkbox" v-model="form.edukasi_terapi" value="Terapi/obat pulang">
            <span>Terapi/obat pulang</span>
          </label>
        </td>
        <td class="center">
          <select v-model="form.promotif_farmasi_4" class="form-select">
            <option value="">-</option>
            <option value="P">P</option>
            <option value="K">K</option>
            <option value="L">L</option>
          </select>
        </td>
        <td class="center">
          <select v-model="form.metode_farmasi_4" class="form-select">
            <option value="">-</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
          </select>
        </td>
        <td class="center">
          <select v-model="form.profesional_farmasi_4" class="form-select">
            <option value="">-</option>
            <option value="1">1</option>
            <option value="2">2</option>
          </select>
        </td>
        <td class="center">
          <select v-model="form.evaluasi_farmasi_4" class="form-select">
            <option value="">-</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
          </select>
        </td>
      </tr>

      <!-- Fisioterapis -->
      <tr>
        <td rowspan="2"><b>Fisioterapis</b></td>
        <td rowspan="2">
          <div class="date-time-wrapper">
            <div>
              <label>Tanggal:</label>
              <input type="date" v-model="form.tanggal_fisio" class="input-rme" />
            </div>
            <div>
              <label>Waktu:</label>
              <input type="time" v-model="form.waktu_fisio" class="input-rme" />
            </div>
          </div>
        </td>
      
        <!-- Edukasi 1 -->
        <td>
          <label class="checkbox-label">
            <input type="checkbox" v-model="form.edukasi_fisio1" value="Tekhnik Rehabilitasi">
            <span>Tekhnik Rehabilitasi</span>
          </label>
        </td>
      
        <td class="center">
          <select v-model="form.promotif_fisio_1" class="form-select">
            <option value="">-</option>
            <option value="P">P</option>
            <option value="K">K</option>
            <option value="L">L</option>
          </select>
        </td>
      
        <td class="center">
          <select v-model="form.metode_fisio_1" class="form-select">
            <option value="">-</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
          </select>
        </td>
      
        <td class="center">
          <select v-model="form.profesional_fisio_1" class="form-select">
            <option value="">-</option>
            <option value="1">1</option>
            <option value="2">2</option>
          </select>
        </td>
      
        <td class="center">
          <select v-model="form.evaluasi_fisio_1" class="form-select">
            <option value="">-</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
          </select>
        </td>
      
        <td rowspan="2">
            <div class="text-center">
                <VueSignaturePad ref="ttd_pemberi_fisio" :options="sigOption" class="signature-box-rme1 mx-auto" />
                <input type="text" v-model="form.nama_pemberi_fisio" class="input-rme1 mt-2" placeholder="Nama Fisioterapis" />
              <div class="signature-actions1 mt-2">
              <button @click="clearSign('ttd_pemberi_fisio')" class="btn-clear mt-2">Clear</button>
                <button @click="saveSign('ttd_pemberi_fisio')" class="btn-save mt-2 d-block mx-auto">Simpan</button> </div>
            </div>
        </td>
        <td rowspan="2">
              <div class="text-center">
                <VueSignaturePad ref="ttd_penerima_fisio" :options="sigOption" class="signature-box-rme1 mx-auto" />
                <input type="text" v-model="form.nama_penerima_fisio" class="input-rme1 mt-2" placeholder="Nama Fisioterapis" />
              <div class="signature-actions1 mt-2">
              <button @click="clearSign('ttd_penerima_fisio')" class="btn-clear mt-2">Clear</button>
                <button @click="saveSign('ttd_penerima_fisio')" class="btn-save mt-2 d-block mx-auto">Simpan</button> </div>
            </div>
        </td>
      </tr>

      <tr>
        <td>
          <label class="checkbox-label">
            <input type="checkbox" v-model="form.edukasi_fisio2" value="Jenis-jenis Rehabilitasi">
            <span>Jenis-jenis Rehabilitasi</span>
          </label>
        </td>
      
        <td class="center">
          <select v-model="form.promotif_fisio_2" class="form-select">
            <option value="">-</option>
            <option value="P">P</option>
            <option value="K">K</option>
            <option value="L">L</option>
          </select>
        </td>
      
        <td class="center">
          <select v-model="form.metode_fisio_2" class="form-select">
            <option value="">-</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
          </select>
        </td>
      
        <td class="center">
          <select v-model="form.profesional_fisio_2" class="form-select">
            <option value="">-</option>
            <option value="1">1</option>
            <option value="2">2</option>
          </select>
        </td>
      
        <td class="center">
          <select v-model="form.evaluasi_fisio_2" class="form-select">
            <option value="">-</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
          </select>
        </td>
      </tr>
     </tbody>
    </table>
  </div>

         
      <!-- ================= BUTTON BOTTOM ================= -->
      <div class="action-footer"  v-if="!disabledSubmit">
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
  name: "FormPendidikanEdukasiPasienKeluargaTerintegrasiRawatInap",
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
      sigOption: { penColor: "black", backgroundColor: "white" },
      form: {
        uuid: "",
        uuid_pasien: "",
        
        // Informasi Pasien
        no_rm: "",
        nik: "",
        nama: "",
        tanggal_lahir: "",
        jenis_kelamin: "L",
        alamat: "",
        
        // Pengkajian Hambatan
        hambatan_bahasa: "0",
        hambatan_emosi: "0",
        hambatan_masalah_penglihatan: "0",
        hambatan_bicara_buruk: "0",
        hambatan_cemas: "0",
        hambatan_tidak_ada_partisipasi: "0",
        hambatan_kognitif: "0",
        hambatan_motivasi: "0",
        hambatan_fisiologi_tidak_mampu: "0",
        hambatan_pendengaran: "0",
        hambatan_hilang_memori: "0",
        hambatan_tidak_ditemukan: "0",
        
        // Edukasi
        edukasi_tata_tertib_rs: "0",
        edukasi_hak_kewajiban: "0",
        
        // Pengkajian Bicara
        bicara_normal: "0",
        bicara_gangguan: "0",
        
        // Bahasa Sehari-hari
        bahasa_indonesia: "0",
        bahasa_daerah: "0",
        bahasa_daerah_text: "",
        bahasa_inggris: "0",
        bahasa_lainnya: "0",
        bahasa_lainnya_text: "",
        
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
        pendidikan_lainnya_text: "",
        
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
        
        // Nilai-nilai Budaya
        budaya_modern: "0",
        budaya_moderat: "0",
        budaya_konvensional: "0",
        
        // Merokok & Alkohol
        merokok_ya: "0",
        merokok_tidak: "0",
        alkohol_ya: "0",
        alkohol_tidak: "0",
        
        // Ketersediaan Menerima Informasi
        menerima_info_ya: "0",
        menerima_info_tidak: "",
        menerima_info_alasan: "",
        
        // Rencana Pendidikan Kesehatan
        rencana_proses_penyakit: "0",
        rencana_pengobatan_tindakan: "0",
        rencana_nutrisi: "0",
        rencana_edukasi_kolaboratif: "0",
        rencana_lain_lain: "0",
        rencana_lain_lain_text: "",
      
        
        // Kebutuhan Privasi
        privasi_ya: "0",
        privasi_tidak: "0",
        
        // SECTION DOKTER
        edukasi_dokter1: '0', edukasi_dokter2: 0, edukasi_dokter3: 0, edukasi_dokter4: 0, edukasi_dokter5: 0,
        edukasi_dokter6: 0, edukasi_dokter7: 0, edukasi_dokter8: 0, edukasi_dokter9: 0,
        
        promotif_dokter_1: '', promotif_dokter_2: '', promotif_dokter_3: '', promotif_dokter_4: '', promotif_dokter_5: '',
        promotif_dokter_6: '', promotif_dokter_7: '', promotif_dokter_8: '', promotif_dokter_9: '',

        metode_dokter_1: '', metode_dokter_2: '', metode_dokter_3: '', metode_dokter_4: '', metode_dokter_5: '',
        metode_dokter_6: '', metode_dokter_7: '', metode_dokter_8: '', metode_dokter_9: '',

        profesional_dokter_1: '', profesional_dokter_2: '', profesional_dokter_3: '', profesional_dokter_4: '', profesional_dokter_5: '',
        profesional_dokter_6: '', profesional_dokter_7: '', profesional_dokter_8: '', profesional_dokter_9: '',

        evaluasi_dokter_1: '', evaluasi_dokter_2: '', evaluasi_dokter_3: '', evaluasi_dokter_4: '', evaluasi_dokter_5: '',
        evaluasi_dokter_6: '', evaluasi_dokter_7: '', evaluasi_dokter_8: '', evaluasi_dokter_9: '',
        
        // SECTION PERAWAT
        edukasi_perawat1: 0, edukasi_perawat2: 0, edukasi_perawat3: 0, edukasi_perawat4: 0,
        edukasi_perawat5: 0, edukasi_perawat6: 0,
        
        promotif_perawat_1: '', promotif_perawat_2: '', promotif_perawat_3: '', promotif_perawat_4: '',
        promotif_perawat_5: '', promotif_perawat_6: '', promotif_perawat_7: '',

        metode_perawat_1: '', metode_perawat_2: '', metode_perawat_3: '', metode_perawat_4: '',
        metode_perawat_5: '', metode_perawat_6: '', metode_perawat_7: '',

        profesional_perawat_1: '', profesional_perawat_2: '', profesional_perawat_3: '', profesional_perawat_4: '',
        profesional_perawat_5: '', profesional_perawat_6: '', profesional_perawat_7: '',

        evaluasi_perawat_1: '', evaluasi_perawat_2: '', evaluasi_perawat_3: '', evaluasi_perawat_4: '',
        evaluasi_perawat_5: '', evaluasi_perawat_6: '', evaluasi_perawat_7: '',
        
        // SECTION TAMBAHAN
        edukasi_tambahan1: 0, edukasi_tambahan2: 0, edukasi_tambahan3: 0, edukasi_tambahan4: 0, edukasi_tambahan5: 0,
        edukasi_tambahan6: 0, edukasi_tambahan7: 0, edukasi_tambahan8: 0, edukasi_tambahan9: 0, edukasi_tambahan10: 0,
        
        promotif_tambahan1_1: '', promotif_tambahan1_2: '', promotif_tambahan1_3: '',promotif_tambahan1_4: '', promotif_tambahan1_4: '',
        promotif_tambahan1_5: '', promotif_tambahan1_6: '', promotif_tambahan1_7: '', promotif_tambahan1_8: '',
        promotif_tambahan1_9: '', promotif_tambahan1_10: '',

        metode_tambahan1_1: '', metode_tambahan1_2: '', metode_tambahan1_3: '',metode_tambahan1_4: '', metode_tambahan1_5: '',
        metode_tambahan1_6: '', metode_tambahan1_7: '', metode_tambahan1_8: '', metode_tambahan1_9: '',
        metode_tambahan1_10: '', 

        profesional_tambahan1_1: '', profesional_tambahan1_2: '', profesional_tambahan1_3: '',profesional_tambahan1_4: '', profesional_tambahan1_5: '',
        profesional_tambahan1_6: '', profesional_tambahan1_7: '', profesional_tambahan1_8: '', profesional_tambahan1_9: '',
        profesional_tambahan1_10: '',
        
        evaluasi_tambahan1_1: '', evaluasi_tambahan1_2: '', evaluasi_tambahan1_3: '',evaluasi_tambahan1_4: '', evaluasi_tambahan1_5: '',
        evaluasi_tambahan1_6: '', evaluasi_tambahan1_7: '', evaluasi_tambahan1_8: '', evaluasi_tambahan1_9: '',
        evaluasi_tambahan1_10: '',
        
        // SECTION ANALIS/LAB
        edukasi_analis: 0,
        promotif_analis: '', metode_analis: '', profesional_analis: '', evaluasi_analis: '',
        
        // SECTION AHLI GIZI
        edukasi_gizi1: 0, edukasi_gizi2: 0,
        promotif_gizi_1: '', promotif_gizi_2: '',
        metode_gizi_1: '', metode_gizi_2: '',
        profesional_gizi_1: '', profesional_gizi_2: '',
        evaluasi_gizi_1: '', evaluasi_gizi_2: '',
        
        // SECTION FARMASI
        edukasi_farmasi1: 0, edukasi_farmasi2: 0, edukasi_farmasi3: 0, edukasi_terapi: 0,
        promotif_farmasi_1: '', promotif_farmasi_2: '', promotif_farmasi_3: '', promotif_farmasi_4: '',
        metode_farmasi_1: '', metode_farmasi_2: '', metode_farmasi_3: '', metode_farmasi_4: '',
        profesional_farmasi_1: '', profesional_farmasi_2: '', profesional_farmasi_3: '', profesional_farmasi_4: '',
        evaluasi_farmasi_1: '', evaluasi_farmasi_2: '', evaluasi_farmasi_3: '', evaluasi_farmasi_4: '',
        
        // SECTION FISIOTERAPIS
        edukasi_fisio1: 0, edukasi_fisio2: 0,
        promotif_fisio_1: '', promotif_fisio_2: '',
        metode_fisio_1: '', metode_fisio_2: '',
        profesional_fisio_1: '', profesional_fisio_2: '',
        evaluasi_fisio_1: '', evaluasi_fisio_2: '',
        
        // Tanda Tangan Pengkaji
        ttd_pengkaji: "",
        nama_pengkaji: "",
        tanggal_pengkaji: "",
        waktu_pengkaji: "",

        //nama-nama di tabel
        nama_pemberi_perawat:"",
        
        // Dokter DPJP
        ttd_dokter_dpjp: "",
        ttd_dokter:"",
        nama_dokter_dpjp: "",

        //Nama Profesi
        nama_pemberi_dokter: "",
        nama_penerima_dokter: "",
        nama_pemberi_perawat: "",
        nama_penerima_perawat: "",
        nama_pemberi_analis: "",
        nama_penerima_analis: "",
        nama_pemberi_gizi: "",
        nama_penerima_gizi: "",
        nama_pemberi_farmasi: "",
        nama_penerima_farmasi: "",
        nama_pemberi_fisio: "",
        nama_penerima_fisio: "",
        
        // TTD Profesi
        ttd_pemberi_dokter: "",
        ttd_penerima_dokter: "",
        ttd_pemberi_perawat: "",
        ttd_penerima_perawat: "",
        ttd_pemberi_analis: "",
        ttd_penerima_analis: "",
        ttd_pemberi_gizi: "",
        ttd_penerima_gizi: "",
        ttd_pemberi_farmasi: "",
        ttd_penerima_farmasi: "",
        ttd_pemberi_fisio: "",
        ttd_penerima_fisio: "",
        
        // Tanggal Waktu Profesi
        tanggal_dokter: "",
        waktu_dokter: "",
        tanggal_perawat: "",
        waktu_perawat: "",
        tanggal_analis: "",
        waktu_analis: "",
        tanggal_gizi: "",
        waktu_gizi: "",
        tanggal_farmasi: "",
        waktu_farmasi: "",
        tanggal_fisio: "",
        waktu_fisio: "",
      },
    };
  },

  computed: {
  isEditMode() {
    return this.editData !== null && this.editData !== undefined;
  }
},
  
mounted() {
  console.log("🟢 COMPONENT - Mounted");
  console.log("🟢 COMPONENT - editData:", this.editData);
  console.log("🟢 COMPONENT - selectedPatient:", this.selectedPatient);
  
this.disabledSubmit = false;
  if(this.viewData){
    this.disabledSubmit = true;
    this.loadDataForEdit();
  }else if (this.editData) {
    console.log("🟢 MODE: EDIT");
    this.loadDataForEdit();
  } else {
    console.log("🟢 MODE: CREATE");
    this.setDataForm();
  }
},
  
  methods: {
loadDataForEdit() {
  console.log("🟢 LOAD EDIT - Mulai load data");
  console.log("🟢 LOAD EDIT - editData yang diterima:", this.editData);
  
  try {
    const dataSource = this.editData || this.viewData;
    
    if (!dataSource) {
      console.warn("🟢 LOAD EDIT - Tidak ada editData/viewData!");
      this.setDataForm();
      return;
    }

    // ✅ List SEMUA checkbox fields di form ini
    const checkboxFields = [
      // Pengkajian Hambatan
      'hambatan_bahasa', 'hambatan_emosi', 'hambatan_masalah_penglihatan', 'hambatan_bicara_buruk',
      'hambatan_cemas', 'hambatan_tidak_ada_partisipasi', 'hambatan_kognitif', 'hambatan_motivasi',
      'hambatan_fisiologi_tidak_mampu', 'hambatan_pendengaran', 'hambatan_hilang_memori', 'hambatan_tidak_ditemukan',
      
      // Edukasi
      'edukasi_tata_tertib_rs', 'edukasi_hak_kewajiban',
      
      // Pengkajian Bicara
      'bicara_normal', 'bicara_gangguan',
      
      // Bahasa
      'bahasa_indonesia', 'bahasa_daerah', 'bahasa_inggris', 'bahasa_lainnya',
      'bahasa_isyarat_ya', 'bahasa_isyarat_tidak',
      
      // Pendidikan
      'pendidikan_tk', 'pendidikan_sd', 'pendidikan_smp', 'pendidikan_sma',
      'pendidikan_diploma', 'pendidikan_sarjana', 'pendidikan_lainnya',
      
      // Agama
      'agama_islam', 'agama_protestan', 'agama_katolik', 'agama_hindu', 'agama_budha', 'agama_lainnya',
      
      // Pengetahuan & Budaya
      'pengetahuan_paham', 'pengetahuan_kurang_paham', 'pengetahuan_tidak_paham',
      'budaya_modern', 'budaya_moderat', 'budaya_konvensional',
      
      // Merokok & Alkohol
      'merokok_ya', 'merokok_tidak', 'alkohol_ya', 'alkohol_tidak',
      
      // Menerima Info
      'menerima_info_ya', 'menerima_info_tidak',
      
      // Rencana Pendidikan
      'rencana_proses_penyakit', 'rencana_pengobatan_tindakan', 'rencana_nutrisi',
      'rencana_edukasi_kolaboratif', 'rencana_lain_lain',
      
      // Privasi
      'privasi_ya', 'privasi_tidak',
      
      // Edukasi Dokter (1-9)
      'edukasi_dokter1', 'edukasi_dokter2', 'edukasi_dokter3', 'edukasi_dokter4', 'edukasi_dokter5',
      'edukasi_dokter6', 'edukasi_dokter7', 'edukasi_dokter8', 'edukasi_dokter9',
      
      // Edukasi Perawat (1-6)
      'edukasi_perawat1', 'edukasi_perawat2', 'edukasi_perawat3', 'edukasi_perawat4',
      'edukasi_perawat5', 'edukasi_perawat6',
      
      // Edukasi Tambahan (1-10)
      'edukasi_tambahan1', 'edukasi_tambahan2', 'edukasi_tambahan3', 'edukasi_tambahan4', 'edukasi_tambahan5',
      'edukasi_tambahan6', 'edukasi_tambahan7', 'edukasi_tambahan8', 'edukasi_tambahan9', 'edukasi_tambahan10',
      
      // Edukasi Profesi Lainnya
      'edukasi_analis', 'edukasi_gizi1', 'edukasi_gizi2',
      'edukasi_farmasi1', 'edukasi_farmasi2', 'edukasi_farmasi3', 'edukasi_terapi',
      'edukasi_fisio1', 'edukasi_fisio2'
    ];

    // ✅ Populate form dengan data
    Object.keys(this.form).forEach((key) => {
      if (dataSource.hasOwnProperty(key)) {
        let value = dataSource[key];
        
        if (checkboxFields.includes(key)) {
          // Convert to string "1" or "0"
          this.form[key] = (value === 1 || value === "1" || value === true) ? true: false;
        } else {
          // Normal fields
          this.form[key] = value !== null ? value : "";
        }
        
        console.log(`🟢 Set ${key}:`, this.form[key]);
      }
    });

    console.log("🟢 LOAD EDIT - Form setelah populate:", this.form);

    // ✅ Load signatures jika ada
    this.$nextTick(() => {
      this.loadSignatures(dataSource);
    });

  } catch (error) {
    console.error("🟢 LOAD EDIT - Error:", error);
    alert("Gagal memuat data untuk edit!");
    this.$emit("back");
  }
},
    
    loadSignatures(data) {
      const signatures = [
        'ttd_pengkaji',
        'ttd_dokter_dpjp',
        'ttd_dokter',
        'ttd_pemberi_dokter',
        'ttd_penerima_dokter',
        'ttd_pemberi_perawat',
        'ttd_penerima_perawat',
        'ttd_pemberi_analis',
        'ttd_penerima_analis',
        'ttd_pemberi_gizi',
        'ttd_penerima_gizi',
        'ttd_pemberi_farmasi',
        'ttd_penerima_farmasi',
        'ttd_pemberi_fisio',
        'ttd_penerima_fisio'
      ];
      
      signatures.forEach(sig => {
        if (data[sig] && this.$refs[sig]) {
          try {
            this.$refs[sig].fromDataURL(data[sig]);
          } catch (err) {
            console.error(`Error loading signature ${sig}:`, err);
          }
        }
      });
    },
    
    setDataForm() {
      const today = new Date();
      this.form.tanggal_pengkaji = today.toISOString().split("T")[0];
      this.form.waktu_pengkaji = today.toTimeString().substring(0, 5);
      
      if (this.selectedPatient) {
        this.form.uuid_pasien = this.selectedPatient.uuid;
        this.form.no_rm = this.selectedPatient.rekam_medis;
        this.form.nik = this.selectedPatient.nik || "";
        this.form.nama = this.selectedPatient.nama;
        this.form.tanggal_lahir = this.selectedPatient.tanggal_lahir;
        this.form.alamat = this.selectedPatient.alamat;
        this.form.jenis_kelamin = this.selectedPatient.jenis_kelamin || "L";
      }
    },
    
    saveSign(refName) {
      const pad = this.$refs[refName];
      if (!pad) {
        console.error("REF tidak ditemukan:", refName);
        return;
      }
      
      const { isEmpty, data } = pad.saveSignature();
      if (!isEmpty) {
        this.form[refName] = data;
        console.log("TTD saved:", refName);
      }
    },
    
async submitForm() {
  if (!this.form.nama_pengkaji) {
    alert("Nama Pengkaji harus diisi!");
    return;
  }
  
  this.loadingSubmit = true;
  
  try {
    const fd = new FormData();
    
    // ✅ Append ALL fields including UUID
    Object.keys(this.form).forEach((key) => {
      let value = this.form[key];
    
      if (typeof value === "boolean") {
        value = value ? 1 : 0;
      }
    
      fd.append(key, value ?? "");
    });

    
    console.log("🟡 SUBMIT - Is Edit Mode:", this.isEditMode);
    console.log("🟡 SUBMIT - UUID:", this.form.uuid);
    
    // ✅ Same route for both create and update
    const response = await axios.post(
      "/master/pasien/form-pendidikan-edukasi-pasien-keluarga-terintegrasi-rawat-inap",
      fd,
      {
        headers: { "Content-Type": "multipart/form-data" },
      }
    );
    
    console.log("🟡 SUBMIT - Response:", response.data);
    
    if (response.data.status) {
      alert(response.data.message || "Data berhasil disimpan!");
      this.$emit("back");
    } else {
      alert(response.data.message || "Gagal menyimpan data!");
    }
  } catch (error) {
    console.error("🟡 SUBMIT - ERROR:", error.response?.data || error);
    
    if (error.response?.data?.errors) {
      const errors = Object.values(error.response.data.errors).flat();
      alert("Error:\n" + errors.join("\n"));
    } else {
      alert(error.response?.data?.message || "Gagal menyimpan form!");
    }
  } finally {
    this.loadingSubmit = false;
  }
},
    
    clearSign(refName) {
      const pad = this.$refs[refName];
      if (pad) {
        pad.clearSignature();
        this.form[refName] = "";
      }
    },
  },
};
</script>

<style scoped>


        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background-color: #f5f5f5;
        }
        
        .form-rs {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
            background: white;
        }

        .form-rs th,
        .form-rs td {
            border: 1px solid #000;
            padding: 6px 8px;
            vertical-align: middle;
        }

        .form-rs th {
            background-color: #f0f0f0;
            font-weight: bold;
            text-align: center;
        }

        .form-rs th.center,
        .form-rs td.center {
            text-align: center;
        }

        .checkbox-label {
            display: inline-flex;
            align-items: flex-start;
            gap: 6px;
            cursor: pointer;
            font-size: 12px;
            margin: 2px 0;
        }

        .line-input {
            width: 100%;
            border: none;
            padding: 2px;
            font-size: 12px;
        }
        
        .profesi-header {
            writing-mode: vertical-rl;
            text-orientation: mixed;
            padding: 8px 4px;
        }

        .line-input1 {
            width: 100%;
            border: 1px solid #000;
            padding: 4px;
            font-size: 12px;
            text-align: center;            /* TEKS CENTER */
            background: transparent;
        }


        .metode-box {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        input[type="checkbox"] {
            cursor: pointer;
            margin-top: 3px;
        }

        .grid-form {
  display: grid;
  grid-template-columns: 0.8fr 0.1fr 2.1fr;
  column-gap: 15px;
  row-gap: 10px;
}


/* Number Box untuk Sub Header */
.number-box {
  display: inline-block;
  width: 25px;
  height: 25px;
  line-height: 25px;
  border: 1px solid #000;
  margin: 2px;
  text-align: center;
  font-size: 11px;
  font-weight: bold;
  background-color: #fff;
  border-radius: 3px;
}

.sub-header {
  font-size: 11px;
  line-height: 1.3;
  padding: 8px 4px;
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
  background-color: #ffffff;
  font-weight: bold;
  text-align: center;
}



.checkbox-label {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  cursor: pointer;
  font-size: 14px;
}

.line-input {
  width: 100%;
  border: none;
  padding: 2px;
  font-size: 14px;
}

.grid-display {
  display: grid;
  grid-template-columns: repeat(3, 1,1fr);
  column-gap: 25px;
  row-gap: 10px;
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

.signature-actions {
  display: flex;
  justify-content: center; /* tombol rata tengah */
  gap: 10px;               /* jarak antar tombol */
}
.signature-actions1 {
  display: flex;
  justify-content: center; /* tombol rata tengah */
  gap: 2px;               /* jarak antar tombol */
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

.date-time-wrapper {
  display: flex;
  gap: 1rem;       /* jarak antar kolom */
}

.date-time-wrapper > div {
  flex: 1;         /* biar ukurannya seimbang */
  padding: 0.5rem; /* ruang di dalam setiap kolom */
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

.input-rme1 {
  width: 80%;
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

.signature-box-rme1 {
  width: 140px !important;   /* paksa lebar */
  height: 100px !important;  /* paksa tinggi */
  border: 2px solid #ccc;
  border-radius: 6px;
}

.signature-box-rme-small {
  width: 150px !important;   /* lebih kecil */
  height: 100px !important;  /* lebih kecil */
  border: 1px solid #000;
  border-radius: 4px;
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

.date-time-wrapper > div {
  display: flex;
  flex-direction: column;
  gap: 4px;
}

.date-time-wrapper label {
  font-size: 11px;
  font-weight: bold;
  display: block;
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
