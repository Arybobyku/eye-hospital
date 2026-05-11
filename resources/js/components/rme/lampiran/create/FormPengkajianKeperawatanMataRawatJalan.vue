<template>
  <div>
    <button @click="$emit('back')" class="btn-back">Kembali</button>

    <div class="container py-4">
      <div class="form-wrapper position-relative">

       <!-- OVERLAY SAAT VIEW -->
     <div v-if="disabledSubmit" class="view-overlay"></div>
      <!-- ================= HEADER ================= -->
      <div class="text-center mb-4">
        <h2 class="fw-bold">PENGKAJIAN KEPERAWATAN MATA RAWAT JALAN</h2>
        <h4 class="fw-semibold">{{form.no_surat}}</h4>
      </div>

<!-- DATE & TIME -->
<div style="display: flex; flex-direction: column; gap: 10px;">
  <div style="display: flex !important; flex-direction: row !important; gap: 20px;">
    <div style="display: flex; flex-direction: column; gap: 4px; flex: 1;">
      <label>Tanggal :</label>
      <input type="date" v-model="form.tanggal" class="input-rme" />
    </div>
    <div style="display: flex; flex-direction: column; gap: 4px; flex: 1;">
      <label>Waktu :</label>
      <input type="time" v-model="form.waktu" class="input-rme" />
    </div>
  </div>
  <div style="display: flex; flex-direction: column; gap: 4px;">
    <label>Perawat Pengkaji :</label>
    <input type="text" v-model="form.perawat_pengkaji" class="input-rme" style="margin-bottom: 20px;" />
  </div>
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
          <input type="text" v-model="form.jenis_kelamin" class="input-rme" readonly />
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
                  <h5 class="section-title-rme">Status Fungsional</h5>        
                  <div class="grid-2">
                    <label class="checkbox-label">
                      <input type="checkbox" v-model="form.jalan_tanpa_bantuan"  > Jalan Tanpa Bantuan
                    </label>
                    <label class="checkbox-label">
                      <input type="checkbox" v-model="form.kursi_roda"  > Kursi Roda
                    </label>
                  </div>
                  <div class="grid-2">
                    <label class="checkbox-label">
                      <input type="checkbox" v-model="form.tempat_tidur_dorong"  > Tempat Tidur Dorong
                    </label>
                    <label class="checkbox-label">
                      <input type="checkbox" v-model="form.jalan_dengan_bantuan"  > Jalan Dengan Bantuan
                    </label>
                  </div>
                </div>
              <!-- Box Kanan -->
              <div class="box-rme mb-2">
                <h5 class="section-title-rme">Kasus Urgent :</h5>
                <div class="grid-2">
                    <label class="checkbox-label">
                      <input type="checkbox" v-model="form.urgent_mata_merah"  > MATA MERAH 
                    </label>
                    <label class="checkbox-label">
                      <input type="checkbox" v-model="form.urgent_trauma_kesakitan"  > TRAUMA / KESAKITAN
                    </label>
                  </div>
                  <div class="grid-2">
                    <label class="checkbox-label">
                      <input type="checkbox" v-model="form.urgent_mata_kabur_mendadak"  > MATA KABUR MENDADAK
                    </label>
                    <label class="checkbox-label">
                      <input type="checkbox" v-model="form.urgent_balita_manula"  > BALITA / MANULA
                    </label>
                  </div>
                  <div class="grid-2">
                    <label class="checkbox-label">
                      <input type="checkbox" v-model="form.urgent_lain_lain"  > Lain - Lain
                      <input type="text" v-model="form.urgent_lain_lain_text" class="line-input"/>
                    </label>
                  </div>
              </div>
            </div>

            <div class="two-box-wrapper">
                <div class="box-rme mb-2">
                  <h5 class="section-title-rme">Keluhan Utama : </h5>        
                      <input type="text" v-model="form.keluhan_utama" class="line-input"/>
                </div>
              <!-- Box Kanan -->
              <div class="box-rme mb-2">
                <h5 class="section-title-rme">Riwayat Penyakit : </h5>
                <input type="text" v-model="form.riwayat_penyakit" class="line-input"/>
              </div>
            </div>


    <div class="box-rme mb-4">
      <h5 class="section-title-rme">PEMERIKSAAN FISIK </h5>
    
      <div class="form-row-3-3">
        <div>
          <label>TD :
          <input type="text" v-model="form.td" class="input-rme1"  /> mmHg</label>
        </div>
        <div>
          <label>BB :
          <input type="text" v-model="form.bb" class="input-rme1"/> kg</label>
        </div>
      </div>
    
      <div class="form-row-3-3">
        <div>
          <label>TB :
          <input type="text" v-model="form.tb" class="input-rme1"  /> cm </label>
        </div>
        <div>
          <label>Nadi :
          <input type="text" v-model="form.nadi" class="input-rme1"/> x/menit </label>
        </div>
      </div>
    
      <div class="form-row-3-3">
        <div>
          <label>RR:
          <input type="text" v-model="form.rr" class="input-rme1"/> x/menit </label>
        </div>
        <div>
          <label>Suhu :
          <input type="text" v-model="form.suhu" class="input-rme1"/> °C</label>
        </div>
      </div>
    </div>

        <!-- ================= Riwayat Kesehatan     ================= -->
        <div class="form-section">
          <div class="box-rme mb-4">
            <h5 class="section-title-rme">Riwayat Kesehatan   </h5>            
            <div class="form-row-inline">
              <span class="row-label">1. Penyakit yang pernah diderita:</span>
              <label class="checkbox-item">
                <input type="checkbox" v-model="form.penyakit_diabetes"   />
                Diabetes
              </label>
              <label class="checkbox-item">
                <input type="checkbox" v-model="form.penyakit_hipertensi"   />
                Hipertensi
              </label>
              <label class="checkbox-item">
                <input type="checkbox" v-model="form.penyakit_jantung"   />
                Jantung
              </label>
              <label class="checkbox-item">
                <input type="checkbox" v-model="form.penyakit_hepatitis"   />
                Hepatitis
              </label>
                <label class="checkbox-item">
                <input type="checkbox" v-model="form.penyakit_asma"   />
                Asma
              </label>
                <label class="checkbox-item">
                <input type="checkbox" v-model="form.penyakit_lainnya"   />
                Lainnya <input type="text" v-model="form.penyakit_lainnya_text" class="line-input"/>
              </label>
            </div>
            
            <div class="form-row-inline">
              <span class="row-label">2. Pernah Di Operasi :</span>
              <label class="checkbox-item">
                <input type="radio" v-model="form.pernah_operasi" />
                Ya
              </label>
              <label class="checkbox-item">
                <input type="radio" v-model="form.pernah_operasi" />
                Tidak
              </label>
            </div>
            <div class="form-row-inline">
              <span class="row-label">Jenis Operasi :</span>
              <label class="checkbox-item"><input type="text" v-model="form.jenis_operasi" class="line-input"/>
              </label>
            </div>
            <div class="form-row-inline">
              <span class="row-label">3. Riwayat Alergi  :</span>
              <label class="checkbox-item">
                <input type="radio" v-model="form.riwayat_alergi" />
                Ya
              </label>
              <label class="checkbox-item">
                <input type="radio" v-model="form.riwayat_alergi"  />
                Tidak
              </label>
            </div>
            <div class="form-row-inline">
              <span class="row-label">Alergi Terhadap  :</span>
              <label class="checkbox-item">
                <input type="checkbox" v-model="form.alergi_makanan"   />
                Makanan <input type="text" v-model="form.alergi_makanan_text" class="line-input"/>
              </label>
            </div>
            <div class="form-row-inline">
              <span class="row-label">4. Obat yang digunakan saat ini:</span>
              <label class="checkbox-item">
                <input type="checkbox" v-model="form.obat_pencair_darah"   />
                Obat pencair darah 
              </label>
              <label class="checkbox-item">
                <input type="checkbox" v-model="form.obat_asma"   />
                Obat Asma
              </label>
              <label class="checkbox-item">
                <input type="checkbox" v-model="form.obat_alergi_steroid"   />
                Obat Alergi / steroid
              </label>
              <label class="checkbox-item">
                <input type="checkbox" v-model="form.obat_prostat"   />
                 Obat prostat 
              </label>
                <label class="checkbox-item">
                <input type="checkbox" v-model="form.obat_lain"   />
                Lain:  <input type="text" v-model="form.obat_lain_text" class="line-input"/>
              </label>
            </div>
          </div>
          
        </div>


                <!-- ================= Riwayat Kesehatan     ================= -->
        <div class="form-section">
          <div class="box-rme mb-4">
            <h5 class="section-title-rme">PENILAIAN RESIKO JATUH</h5>            
            <div class="form-row-inline">
              <span class="row-label">1. Resiko Jatuh:</span>
              <label class="checkbox-item">
                <input type="radio" v-model="form.resiko_jatuh" />
                Ya 
              </label>
              <label class="checkbox-item">
                <input type="radio" v-model="form.resiko_jatuh" />
                Tidak
              </label>
            </div>
          </div>
          
        </div>
      <div class="box-rme mb-4">
  <h5 class="section-title-rme">SKRINING NYERI</h5>
  <div style="display: flex; gap: 20px; align-items: stretch;">
    <!-- Kolom Kiri: Pain Assessment Tool - DIPERBESAR -->
    <div style="flex: 0 0 400px; border: 2px solid #333; padding: 15px; display: flex; flex-direction: column;">
      <h6 style="text-align: center; margin-bottom: 10px; font-weight: bold;">PAIN ASSESSMENT TOOL</h6>
      
      <!-- Tempat untuk gambar Pain Scale -->
      <div style="text-align: center; margin-bottom: 10px;">
        <img src="/storage/images/PAT.png" alt="Pain Scale" style="width: 100%; max-width: 370px;" />
      </div>
      
      <!-- Radio button 0-10 -->
      <div style="display: flex; justify-content: space-between; align-items: center; margin-top: auto;">
        <label style="display: flex; flex-direction: column; align-items: center; font-size: 12px;">
          <input type="radio" v-model="form.pain_scale_value" value="0" />
          <span>0</span>
        </label>
        <label style="display: flex; flex-direction: column; align-items: center; font-size: 12px;">
          <input type="radio" v-model="form.pain_scale_value" value="1" />
          <span>1</span>
        </label>
        <label style="display: flex; flex-direction: column; align-items: center; font-size: 12px;">
          <input type="radio" v-model="form.pain_scale_value" value="2" />
          <span>2</span>
        </label>
        <label style="display: flex; flex-direction: column; align-items: center; font-size: 12px;">
          <input type="radio" v-model="form.pain_scale_value" value="3" />
          <span>3</span>
        </label>
        <label style="display: flex; flex-direction: column; align-items: center; font-size: 12px;">
          <input type="radio" v-model="form.pain_scale_value" value="4" />
          <span>4</span>
        </label>
        <label style="display: flex; flex-direction: column; align-items: center; font-size: 12px;">
          <input type="radio" v-model="form.pain_scale_value" value="5" />
          <span>5</span>
        </label>
        <label style="display: flex; flex-direction: column; align-items: center; font-size: 12px;">
          <input type="radio" v-model="form.pain_scale_value" value="6" />
          <span>6</span>
        </label>
        <label style="display: flex; flex-direction: column; align-items: center; font-size: 12px;">
          <input type="radio" v-model="form.pain_scale_value" value="7" />
          <span>7</span>
        </label>
        <label style="display: flex; flex-direction: column; align-items: center; font-size: 12px;">
          <input type="radio" v-model="form.pain_scale_value" value="8" />
          <span>8</span>
        </label>
        <label style="display: flex; flex-direction: column; align-items: center; font-size: 12px;">
          <input type="radio" v-model="form.pain_scale_value" value="9" />
          <span>9</span>
        </label>
        <label style="display: flex; flex-direction: column; align-items: center; font-size: 12px;">
          <input type="radio" v-model="form.pain_scale_value" value="10" />
          <span>10</span>
        </label>
      </div>
    </div>
    
    <!-- Kolom Kanan: Form Skrining -->
    <div style="flex: 1; border: 2px solid #333; padding: 15px;">
      <!-- Checkbox horizontal -->
      <div style="display: flex; gap: 20px; margin-bottom: 10px;">
        <label>
          <input type="checkbox" v-model="form.tidak_ada_nyeri"   /> Tidak ada nyeri
        </label>
        <label>
          <input type="checkbox" v-model="form.nyeri_akut"   /> Nyeri Akut
        </label>
        <label>
          <input type="checkbox" v-model="form.nyeri_kronis"   /> Nyeri Kronis
        </label>
      </div>
      
      <div style="margin-bottom: 10px;">
        <label style="display: inline-block; width: 150px;">Skala Nyeri:</label>
        <input type="text" v-model="form.skala_nyeri" class="input-rme" style="width: 80px; display: inline-block;" />
        <label style="margin-left: 20px; display: inline-block; width: 80px;">Lokasi:</label>
        <input type="text" v-model="form.lokasi_nyeri" class="input-rme" style="width: 200px; display: inline-block;" />
      </div>
      
      <div style="margin-bottom: 10px;">
        <label style="display: inline-block; width: 150px;">Karakteristik:</label>
        <input type="text" v-model="form.karakteristik_nyeri" class="input-rme" style="width: 150px; display: inline-block;" />
        <label style="margin-left: 20px; display: inline-block; width: 80px;">Durasi:</label>
        <input type="text" v-model="form.durasi_nyeri" class="input-rme" style="width: 150px; display: inline-block;" />
      </div>
      
      <div style="margin-bottom: 5px;">
        <span style="display: block; margin-bottom: 8px; font-weight: bold;">Nyeri hilang, bila:</span>
        
        <!-- Baris 1: minum obat dan istirahat -->
        <div style="display: flex; gap: 10px; margin-bottom: 8px;">
          <label style="width: 20%;">
            <input type="checkbox" v-model="form.nyeri_hilang_minum_obat"   /> minum obat
          </label>
          <label style="width: 80%;">
            <input type="checkbox" v-model="form.nyeri_hilang_istirahat"   /> istirahat
          </label>
        </div>
        
        <!-- Baris 2: berubah posisi dan Lainnya -->
        <div style="display: flex; gap: 10px;">
          <label style="width: 20%;">
            <input type="checkbox" v-model="form.nyeri_hilang_berubah_posisi"   /> berubah posisi
          </label>
          <label style="width: 80%; display: flex; align-items: center; gap: 5px;">
            <input type="checkbox" v-model="form.nyeri_hilang_lainnya"   />
            <span>Lainnya:</span>
            <input type="text" v-model="form.nyeri_hilang_lainnya_text" class="input-rme" style="flex: 1;" />
          </label>
        </div>
      </div>
    </div>
  </div>
      </div>

      <div class="box-rme mb-4">
        <h5 class="section-title-rme">DAFTAR DIAGNOSA KEPERAWATAN</h5>
        
        <table style="width: 100%; border-collapse: collapse; border: 2px solid #333;">
          <thead>
            <tr>
              <th style="border: 2px solid #333; padding: 10px; background-color: #ffffff; text-align: center; width: 50%;">
                Diagnosa Keperawatan
              </th>
              <th style="border: 2px solid #333; padding: 10px; background-color: #ffffff; text-align: center; width: 50%;">
                Intervensi Keperawatan
              </th>
            </tr>
          </thead>
          <tbody>
            <tr style="vertical-align: top;">
              <!-- Kolom Diagnosa Keperawatan -->
              <td style="border: 2px solid #333; padding: 10px;">
                <div style="margin-bottom: 8px;">
                  <label style="display: flex; gap: 8px;">
                    <input type="checkbox" v-model="form.diagnosa_gangguan_sensori"   style="margin-top: 3px; flex-shrink: 0;" />
                    <span>Gangguan Sensori Persepsi: Visual berhubungan dengan penerimaan sensori.</span>
                  </label>
                </div>
                
                <div style="margin-bottom: 8px;">
                  <label style="display: flex; gap: 8px;">
                    <input type="checkbox" v-model="form.diagnosa_resiko_jatuh"   style="margin-top: 3px; flex-shrink: 0;" />
                    <span>Resiko Jatuh berhubungan dengan kesulitan visual dan tingkah laku</span>
                  </label>
                </div>
                
                <div style="margin-bottom: 8px;">
                  <label style="display: flex; gap: 8px;">
                    <input type="checkbox" v-model="form.diagnosa_resiko_infeksi"   style="margin-top: 3px; flex-shrink: 0;" />
                    <span>Resiko Infeksi berhubungan dengan peningkatan paparan lingkungan yang berpatogen</span>
                  </label>
                </div>
                
                <div style="margin-bottom: 8px;">
                  <label style="display: flex; gap: 8px;">
                    <input type="checkbox" v-model="form.diagnosa_nyeri"   style="margin-top: 3px; flex-shrink: 0;" />
                    <span>Nyeri berhubungan dengan agen cidera fisik</span>
                  </label>
                </div>
                
                <div style="margin-bottom: 8px;">
                  <label style="display: flex; gap: 8px;">
                    <input type="checkbox" v-model="form.diagnosa_kurang_pengetahuan"   style="margin-top: 3px; flex-shrink: 0;" />
                    <span>Kurangnya pengetahuan berhubungan dengan kurang terpapar informasi</span>
                  </label>
                </div>
                
                <div style="margin-bottom: 8px;">
                  <label style="display: flex; gap: 8px;">
                    <input type="checkbox" v-model="form.diagnosa_cemas"   style="margin-top: 3px; flex-shrink: 0;" />
                    <span>Cemas berhubungan dengan perubahan status kesehatan</span>
                  </label>
                </div>
                
                <div style="margin-bottom: 8px;">
                  <label style="display: flex; gap: 8px;">
                    <input type="checkbox" v-model="form.diagnosa_tertunda_pemulihan"   style="margin-top: 3px; flex-shrink: 0;" />
                    <span>Tertundanya pemulihan post operasi berhubungan dengan ketidaknyamanan</span>
                  </label>
                </div>
                
                <div>
                  <label style="display: flex; gap: 8px;">
                    <input type="checkbox" v-model="form.diagnosa_ketidakefektifan_proteksi"   style="margin-top: 3px; flex-shrink: 0;" />
                    <span>Ketidakefektifan proteksi berhubungan dengan perawatan (pembedahan)</span>
                  </label>
                </div>
              </td>
              
              <!-- Kolom Intervensi Keperawatan -->
              <td style="border: 2px solid #333; padding: 10px;">
                <div style="margin-bottom: 8px;">
                  <label style="display: flex; gap: 8px;">
                    <input type="checkbox" v-model="form.intervensi_pengkajian_awal"   style="margin-top: 3px; flex-shrink: 0;" />
                    <span>Melakukan pengkajian awal mata dan mengamati keluhan pasien terutama kasus urgent</span>
                  </label>
                </div>
                
                <div style="margin-bottom: 8px;">
                  <label style="display: flex; gap: 8px;">
                    <input type="checkbox" v-model="form.intervensi_edukasi_jatuh"   style="margin-top: 3px; flex-shrink: 0;" />
                    <span>Memberikan edukasi kepada keluarga tentang resiko jatuh</span>
                  </label>
                </div>
                
                <div style="margin-bottom: 8px;">
                  <label style="display: flex; gap: 8px;">
                    <input type="checkbox" v-model="form.intervensi_cuci_tangan"   style="margin-top: 3px; flex-shrink: 0;" />
                    <span>Mencuci tangan sebelum dan sesudah kontak dengan pasien</span>
                  </label>
                </div>
                
                <div style="margin-bottom: 8px;">
                  <label style="display: flex; gap: 8px;">
                    <input type="checkbox" v-model="form.intervensi_edukasi_infeksi"   style="margin-top: 3px; flex-shrink: 0;" />
                    <span>Mengajarkan pasien dan keluarga tentang tanda dan gejala infeksi agar melapor ke tenaga kesehatan saat terjadi</span>
                  </label>
                </div>
                
                <div style="margin-bottom: 8px;">
                  <label style="display: flex; gap: 8px;">
                    <input type="checkbox" v-model="form.intervensi_penilaian_nyeri"   style="margin-top: 3px; flex-shrink: 0;" />
                    <span>Melakukan penilaian awal nyeri (<em>assesment</em>) dan melakukan penilaian derajat nyeri</span>
                  </label>
                </div>
                
                <div style="margin-bottom: 8px;">
                  <label style="display: flex; gap: 8px;">
                    <input type="checkbox" v-model="form.intervensi_tetes_mata"   style="margin-top: 3px; flex-shrink: 0;" />
                    <span>Memberikan tetes mata sesuai petunjuk dokter</span>
                  </label>
                </div>
                
                <div style="margin-bottom: 8px;">
                  <label style="display: flex; gap: 8px;">
                    <input type="checkbox" v-model="form.intervensi_bersihkan_luka"   style="margin-top: 3px; flex-shrink: 0;" />
                    <span>Membersihkan luka dan mengganti balutan</span>
                  </label>
                </div>
                
                <div style="margin-bottom: 8px;">
                  <label style="display: flex; gap: 8px;">
                    <input type="checkbox" v-model="form.intervensi_jelaskan_prosedur"   style="margin-top: 3px; flex-shrink: 0;" />
                    <span>Menjelaskan kepada orangtua tindakan/prosedur yang akan dilakukan</span>
                  </label>
                </div>
                
                <div style="margin-bottom: 8px;">
                  <label style="display: flex; gap: 8px;">
                    <input type="checkbox" v-model="form.intervensi_info_preoperasi"   style="margin-top: 3px; flex-shrink: 0;" />
                    <span>Menginformasikan kepada keluarga tentang preoperasi termasuk jadwal operasi</span>
                  </label>
                </div>
                
                <div>
                  <label style="display: flex; gap: 8px;">
                    <input type="checkbox" v-model="form.intervensi_patching"   style="margin-top: 3px; flex-shrink: 0;" />
                    <span>Membantu menggunakan <em>patching</em> jika diperlukan</span>
                  </label>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- ================= TANDA TANGAN ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Tanda Tangan</h5>
      
        <!-- Tanggal dan Waktu -->
        <div style="display: flex; gap: 20px; margin-bottom: 20px;">
          <div style="display: flex; flex-direction: column; gap: 4px; flex: 1;">
            <label>Tanggal :</label>
            <input type="date" v-model="form.tanggal_ttd" class="input-rme" />
          </div>
          <div style="display: flex; flex-direction: column; gap: 4px; flex: 1;">
            <label>Waktu :</label>
            <input type="time" v-model="form.waktu_ttd" class="input-rme" />
          </div>
        </div>
      
        <!-- Tanda Tangan Perawat -->
        <div class="signature-row-3">
        <div>
    <label class="fw-bold mb-2">Perawat Yang Melakukan Pengkajian</label>

    <!-- <VueSignaturePad
      ref="ttd_perawat"
      :options="sigOption"
      class="signature-box-rme mx-auto"
    /> -->

            <div v-if="form.ttd_perawat && !ttdPerawatCleared" class="signature-preview text-center">
              <img :src="form.ttd_perawat" alt="TTD Perawat " class="img-signature" />
              <p v-if="form.perawat_ttd_timestamp" class="timestamp-ttd">
                Ditandatangani: {{ form.perawat_ttd_timestamp }}
              </p>
              <button @click="clearSign('ttd_perawat')" class="btn-clear mt-2">Hapus & Tanda Tangan Ulang</button>
            </div>
            <div v-else class="text-center">
              <VueSignaturePad ref="ttd_perawat" :options="sigOption" class="signature-box-rme mx-auto" />
              <button @click="saveSign('ttd_perawat')" class="btn-save mt-2">Simpan ✔</button>
            </div>


    <!-- INPUT NAMA (BARIS TERPISAH) -->
    <input
      type="text"
      v-model="form.nama_perawat_ttd"
      class="input-rme mt-2"
      placeholder="Nama Lengkap Perawat"
    />
  </div>
</div>

      </div>
    </div>

    <!-- ================= BUTTON BOTTOM ================= -->
    <div class="action-footer" v-if="!disabledSubmit">
      <button class="btn-save-form" @click="submitForm" :disabled="loadingSubmit">
        <span v-if="loadingSubmit">Menyimpan...</span>
        <span v-else>{{ isEditMode ? 'Update' : 'Simpan' }}</span>
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
  name: "FormPengkajianKeperawatanMataRawatJalan",
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
      disabledSubmit: false,
      ttdPerawatCleared: false,
      sigOption: {
        penColor: "black",
        backgroundColor: "white",
      },
      form: {
        uuid: "",
        uuid_pasien: "",
        tanggal: "",
        waktu: "",
        perawat_pengkaji: "",
        no_rm: "",
        no_surat: "",
        nik: "",
        nama: "",
        tanggal_lahir: "",
        jenis_kelamin: "L",
        alamat: "",
        
        // Status Fungsional
        jalan_tanpa_bantuan: "false",
        kursi_roda: "false",
        tempat_tidur_dorong: "false",
        jalan_dengan_bantuan: "false",
        
        // Kasus Urgent
        urgent_mata_merah: "false",
        urgent_trauma_kesakitan: "false",
        urgent_mata_kabur_mendadak: "false",
        urgent_balita_manula: "false",
        urgent_lain_lain: "false",
        urgent_lain_lain_text: "",
        
        keluhan_utama: "",
        riwayat_penyakit: "",
        
        // Pemeriksaan Fisik
        td: "",
        bb: "",
        tb: "",
        nadi: "",
        rr: "",
        suhu: "",
        
        // Riwayat Kesehatan
        penyakit_diabetes: "false",
        penyakit_hipertensi: "false",
        penyakit_jantung: "false",
        penyakit_hepatitis: "false",
        penyakit_asma: "false",
        penyakit_lainnya: "false",
        penyakit_lainnya_text: "",
        
        pernah_operasi: "false",
        jenis_operasi: "",
        
        riwayat_alergi: "false",
        alergi_makanan: "false",
        alergi_makanan_text: "",
        
        obat_pencair_darah: "false",
        obat_asma: "false",
        obat_alergi_steroid: "false",
        obat_prostat: "false",
        obat_lain: "false",
        obat_lain_text: "",
        
        resiko_jatuh: "false",
        
        // Skrining Nyeri
        tidak_ada_nyeri: "false",
        nyeri_akut: "false",
        nyeri_kronis: "false",
        skala_nyeri: "",
        pain_scale_value: "",
        lokasi_nyeri: "",
        karakteristik_nyeri: "",
        durasi_nyeri: "",
        nyeri_hilang_minum_obat: "false",
        nyeri_hilang_istirahat: "false",
        nyeri_hilang_berubah_posisi: "false",
        nyeri_hilang_lainnya: "false",
        nyeri_hilang_lainnya_text: "",
        
        // Diagnosa Keperawatan
        diagnosa_gangguan_sensori: "false",
        diagnosa_resiko_jatuh: "false",
        diagnosa_resiko_infeksi: "false",
        diagnosa_nyeri: "false",
        diagnosa_kurang_pengetahuan: "false",
        diagnosa_cemas: "false",
        diagnosa_tertunda_pemulihan: "false",
        diagnosa_ketidakefektifan_proteksi: "false",
        
        // Intervensi Keperawatan
        intervensi_pengkajian_awal: "false",
        intervensi_edukasi_jatuh: "false",
        intervensi_cuci_tangan: "false",
        intervensi_edukasi_infeksi: "false",
        intervensi_penilaian_nyeri: "false",
        intervensi_tetes_mata: "false",
        intervensi_bersihkan_luka: "false",
        intervensi_jelaskan_prosedur: "false",
        intervensi_info_preoperasi: "false",
        intervensi_patching: "false",
        
        // Tanda Tangan
        tanggal_ttd: "",
        waktu_ttd: "",
        ttd_perawat: "",
        perawat_ttd_timestamp: "",
        nama_perawat_ttd: "",
      },
    };
  },
computed: {
  isEditMode() {
    return this.editData !== null && this.editData !== undefined;
  }
},
async mounted() {
  console.log("🟢 COMPONENT - Mounted");
  console.log("🟢 COMPONENT - editData:", this.editData);
  console.log("🟢 COMPONENT - selectedPatient:", this.selectedPatient);

  await this.fetchTahunAkreditasi();
  
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
  async fetchTahunAkreditasi() {
    try {
      const response = await axios.get('/api/tahun-akreditasi');
      const tahun = response.data.tahun || '22';
      
      if (!this.form.no_surat) {
        this.form.no_surat = `RM 1.3/PKMRJ/${tahun}`;
      }
      
      console.log("✅ Tahun akreditasi:", tahun);
      console.log("✅ No surat:", this.form.no_surat);
    } catch (error) {
      console.error("❌ Error fetch tahun:", error);
      if (!this.form.no_surat) {
        this.form.no_surat = 'RM 1.3/PKMRJ/22';
      }
    }
  },
loadDataForEdit() {
  console.log("🟢 LOAD EDIT - Mulai load data");
  console.log("🟢 LOAD EDIT - editData yang diterima:", this.editData);

  try {
    if (!this.editData) {
      console.warn("🟢 LOAD EDIT - Tidak ada editData!");
      this.setDataForm();
      return;
    }

    // ✅ List SEMUA checkbox fields di form ini
    const checkboxFields = [
      // Status Fungsional
      'jalan_tanpa_bantuan', 'kursi_roda', 'tempat_tidur_dorong', 'jalan_dengan_bantuan',

      // Kasus Urgent
      'urgent_mata_merah', 'urgent_trauma_kesakitan', 'urgent_mata_kabur_mendadak',
      'urgent_balita_manula', 'urgent_lain_lain',

      // Riwayat Kesehatan
      'penyakit_diabetes', 'penyakit_hipertensi', 'penyakit_jantung', 'penyakit_hepatitis',
      'penyakit_asma', 'penyakit_lainnya', 'alergi_makanan',
      'obat_pencair_darah', 'obat_asma', 'obat_alergi_steroid', 'obat_prostat', 'obat_lain',

      // Skrining Nyeri
      'tidak_ada_nyeri', 'nyeri_akut', 'nyeri_kronis',
      'nyeri_hilang_minum_obat', 'nyeri_hilang_istirahat', 'nyeri_hilang_berubah_posisi',
      'nyeri_hilang_lainnya',

      // Diagnosa Keperawatan
      'diagnosa_gangguan_sensori', 'diagnosa_resiko_jatuh', 'diagnosa_resiko_infeksi',
      'diagnosa_nyeri', 'diagnosa_kurang_pengetahuan', 'diagnosa_cemas',
      'diagnosa_tertunda_pemulihan', 'diagnosa_ketidakefektifan_proteksi',

      // Intervensi Keperawatan
      'intervensi_pengkajian_awal', 'intervensi_edukasi_jatuh', 'intervensi_cuci_tangan',
      'intervensi_edukasi_infeksi', 'intervensi_penilaian_nyeri', 'intervensi_tetes_mata',
      'intervensi_bersihkan_luka', 'intervensi_jelaskan_prosedur', 'intervensi_info_preoperasi',
      'intervensi_patching'
    ];

    // ✅ Radio button fields
    const radioFields = ['pernah_operasi', 'riwayat_alergi', 'resiko_jatuh'];

    // ✅ Populate form dari editData
    Object.keys(this.form).forEach((key) => {
      if (!this.editData.hasOwnProperty(key)) return;

      const value = this.editData[key];

      // ✅ Checkbox & radio → boolean
      if (checkboxFields.includes(key) || radioFields.includes(key)) {
        this.form[key] = value === true || value === 1 || value === "1";
      }
      // ✅ Field lain (text, date, number, dll)
      else {
        this.form[key] = value ?? "";
      }

      console.log(`🟢 Set ${key}:`, this.form[key]);
    });

    this.$nextTick(() => {
      const flagMap = {
        ttd_perawat: 'ttdPerawatCleared',
      };
    
      Object.keys(flagMap).forEach(refName => {
        if (this.form[refName]) {
          this[flagMap[refName]] = false;
        }
      });
    });

      } catch (error) {
        console.error("🟢 LOAD EDIT - Error:", error);
        alert("Gagal memuat data untuk edit!");
        this.$emit("back");
      }
},


    renderSignature(refName, data) {
      this.$nextTick(() => {
        const pad = this.$refs[refName];
        if (pad && data) {
          pad.clearSignature();
          pad.fromDataURL(data);
        }
      });
    },
    
    setDataForm() {
      const today = new Date();
      this.form.tanggal = today.toISOString().split("T")[0];
      this.form.waktu = today.toTimeString().substring(0, 5);
      this.form.tanggal_ttd = today.toISOString().split("T")[0];
      this.form.waktu_ttd = today.toTimeString().substring(0, 5);

      if (this.selectedPatient) {
        this.form.uuid_pasien = this.selectedPatient.uuid;
        this.form.no_rm = this.selectedPatient.rekam_medis;
        this.form.nik = this.selectedPatient.no_identitas || "";
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
    
      if (isEmpty) {
        alert("Tanda tangan masih kosong!");
        return;
      }
    
      const flagMap = {
        ttd_perawat: 'ttdPerawatCleared',
      };
    
      if (flagMap[refName] !== undefined) {
        this[flagMap[refName]] = false;
      }
    
      this.form[refName] = data;

      const now = new Date();
      const timestamp = now.toLocaleString('id-ID', {
        day: '2-digit', month: '2-digit', year: 'numeric',
        hour: '2-digit', minute: '2-digit', second: '2-digit'
      });
    
      if (refName === 'ttd_perawat') this.form.perawat_ttd_timestamp = timestamp
      console.log("TTD saved:", refName);
    },
    
    clearSign(refName) {
      const flagMap = {
        ttd_perawat: 'ttdPerawatCleared',
      };
    
      if (flagMap[refName] !== undefined) {
        this[flagMap[refName]] = true;
        this.form[refName] = "";
      }

      if (refName === 'ttd_perawat') this.form.perawat_ttd_timestamp = "";
    
      this.$nextTick(() => {
        const pad = this.$refs[refName];
        if (pad) pad.clearSignature();
      });
    },



    async submitForm() {
      this.loadingSubmit = true;

      try {
        const fd = new FormData();

Object.keys(this.form).forEach((key) => {
  if (key === "uuid" && !this.form[key]) return;

  let value = this.form[key];

  // boolean → 1 / 0 (jika backend mau angka)
  if (typeof value === "boolean") {
    value = value ? 1 : 0;
  }

  fd.append(key, value ?? "");
});


        const response = await axios.post(
          "/master/pasien/form-pengkajian-keperawatan-mata-rawat-jalan",
          fd,
          { headers: { "Content-Type": "multipart/form-data" } }
        );

        if (response.data.status) {
          alert(response.data.message);
          this.$emit("back");
        } else {
          alert(response.data.message || "Gagal menyimpan form!");
        }
      } catch (error) {
        console.error("ERROR:", error.response?.data || error);
        alert(error.response?.data?.message || "Gagal menyimpan form!");
      } finally {
        this.loadingSubmit = false;
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

  .metode-box {
      display: flex;
      flex-direction: column;
      gap: 2px;
  }

  .profesi-header {
      writing-mode: vertical-rl;
      text-orientation: mixed;
      padding: 8px 4px;
  }

  input[type="checkbox"] {
      cursor: pointer;
      margin-top: 3px;
  }

  .timestamp-ttd {
  font-size: 12px;
  color: #2d74b7;
  font-weight: 500;
  padding: 6px 16px;
  background: #e9f5ff;
  border-radius: 4px;
  display: block;
  width: fit-content;
  margin: 6px auto;
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

.grid-3 {
  display: grid;
  grid-template-columns: 0.8fr 1fr 2.1fr;  /* kolom 1 kecil, 2 sedang, 3 besar */
  column-gap: 25px;
  row-gap: 10px;
}

.grid-2 {
  display: grid;
  grid-template-columns: 0.7fr 1fr; /* kolom 1 kecil, 2 sedang, 3 besar */
  column-gap: 25px;
  row-gap: 10px;
}

.signature-preview {
  width: 100%;
  background: white;
  padding: 10px;
  border-radius: 4px;
  margin-bottom: 10px;
}

.img-signature {
  max-width: 100%;
  height: 180px;
  object-fit: contain;
  border: 1px dashed #ccc;
  background: white;
  display: block;
  margin: 0 auto;
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

.signature-actions {
  display: flex;
  justify-content: center; /* tombol rata tengah */
  gap: 10px;               /* jarak antar tombol */
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

/* Override CSS lama */
.date-time-wrapper > div {
  display: block !important;
  flex-direction: unset !important;
}

/* CSS baru */
.date-time-wrapper {
  display: flex;
  flex-direction: column;
  gap: 10px;
}

.date-time-wrapper .date-time-row {
  display: flex;
  gap: 20px;
}

.date-time-wrapper .date-time-row > div {
  display: flex;
  flex-direction: column;
  gap: 4px;
  flex: 1;
}

.date-time-wrapper .name-row {
  display: flex;
  flex-direction: column;
  gap: 4px;
}

.form-row-2 {
  display: flex;
  gap: 1rem;       /* jarak antar kolom */
}

.form-row-inline {
  display: flex;
  align-items: center;
  margin-bottom: 10px;
  gap: 20px;
}

.row-label {
  min-width: 100px;
  font-weight: normal;
}

.checkbox-item {
  display: flex;
  align-items: center;
  gap: 5px;
  margin: 0;
  white-space: nowrap;
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
