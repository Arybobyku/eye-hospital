<template>
  <div>
    <button @click="$emit('back')" class="btn-back">Kembali</button>

    <div class="container py-4">
      <div class="form-wrapper position-relative">

<!-- OVERLAY SAAT VIEW -->
<div v-if="disabledSubmit" class="view-overlay"></div>

<!-- ================= PILIHAN JENIS FORM ================= -->
<!-- Tampilkan hanya saat CREATE (bukan EDIT dan bukan VIEW) -->
<div class="box-rme mb-4" v-if="!isEditMode && !viewData">
  <h5 class="section-title-rme">Pilih Jenis Formulir</h5>
  <div class="form-type-selector">
    <label class="radio-card" :class="{ active: form.jenis_form === 'penolakan' }">
      <input 
        type="radio" 
        v-model="form.jenis_form" 
        value="penolakan"
        name="jenis_form"
      />
      <div class="radio-card-content">
        <h4>PENOLAKAN</h4>
        <p>Tindakan Anestesi</p>
        <span class="code">RM 4.2/PTA/22</span>
      </div>
    </label>
    
    <label class="radio-card" :class="{ active: form.jenis_form === 'persetujuan' }">
      <input 
        type="radio" 
        v-model="form.jenis_form" 
        value="persetujuan"
        name="jenis_form"
      />
      <div class="radio-card-content">
        <h4>PERSETUJUAN</h4>
        <p>Tindakan Anestesi</p>
        <span class="code">RM 4.3/PTA/22</span>
      </div>
    </label>
  </div>
</div>

<!-- Tampilkan jenis form yang sudah dipilih saat EDIT/VIEW -->
<div class="box-rme mb-4" v-else>
  <h5 class="section-title-rme">Jenis Formulir</h5>
  <div class="alert alert-info">
    <strong>{{ formTitle }}</strong> - {{ formCode }}
  </div>
</div>

      <!-- ================= HEADER (Dynamic) ================= -->
      <div class="text-center mb-4">
        <h2 class="fw-bold">{{ formTitle }}</h2>
        <h4 class="fw-semibold">{{ formCode }}</h4>
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


      <!-- ================= PEMBERIAN INFORMASI TINDAKAN PEMBIUSAN  ================= -->
        <div class="box-rme mb-4">
        <h5 class="section-title-rme">PEMBERIAN INFORMASI TINDAKAN PEMBIUSAN </h5>
          <div class="form-row-2">
            <div>
              <label>Dokter Pelaksana Tindakan :</label>
              <input type="text" v-model="form.dokter_pelaksana" class="input-rme" />
            </div>
            <div>
              <label>Pemberi Informasi :</label>
              <input type="text" v-model="form.perawat_asisten" class="input-rme" />
            </div>
          </div>
          <div class="form-row-2">
            <div>
              <label>Penerima informasi/{{ form.jenis_form === 'penolakan' ? 'pemberi penolakan' : 'pemberi persetujuan' }}* :</label>
              <input type="text" v-model="form.penerima_informasi" class="input-rme" />
            </div>
          </div>
        </div>

        <!-- ================= Diagnosis (WD & DD)   ================= -->
        <div class="box-rme mb-4">
        <h5 class="section-title-rme">Diagnosis (WD & DD)  </h5>
            <div class="form-row-2">
                <div>
                  <label>Status Fisik ASA :</label>
                  <input type="text" v-model="form.status_fisik_asa" class="input-rme" />
                </div>
            </div>
            <h5 class="section-title-rme">Dasar Diagnosis</h5>
            <div class="form-row-2">
                <div>
                  <label>Klinis :</label>
                  <input type="text" v-model="form.klinis" class="input-rme" />
                </div>
                <div>
                  <label>Radiologi :</label>
                  <input type="text" v-model="form.radiologi" class="input-rme" />
                </div>
                <div>
                  <label>EKG :</label>
                  <input type="text" v-model="form.ekg" class="input-rme" />
                </div>
                <div>
                  <label>Laboratorium :</label>
                  <input type="text" v-model="form.laboratorium" class="input-rme" />
                </div>
            </div>
        </div>

        <!-- ================= Tindakan Kedokteran   ================= -->
        <div class="form-section">
          <div class="box-rme mb-4">
            <h5 class="section-title-rme">Tindakan Kedokteran</h5>
            
            <div class="form-row-2">
              <label>Anestesi / Pembiusan :</label>
            </div>
            
            <div class="form-row-inline">
              <span class="row-label">1. Umum :</span>
              <label class="checkbox-item">
                <input type="checkbox" v-model="form.umum_intubasi" />
                Intubasi
              </label>
              <label class="checkbox-item">
                <input type="checkbox" v-model="form.umum_lma" />
                LMA
              </label>
              <label class="checkbox-item">
                <input type="checkbox" v-model="form.umum_fm" />
                FM
              </label>
              <label class="checkbox-item">
                <input type="checkbox" v-model="form.umum_tiva" />
                TIVA
              </label>
            </div>
            
            <div class="form-row-inline">
              <span class="row-label">2. Regional :</span>
              <label class="checkbox-item">
                <input type="checkbox" v-model="form.regional_spinal1" />
                Spinal
              </label>
              <label class="checkbox-item">
                <input type="checkbox" v-model="form.regional_spinal2" />
                Epidural
              </label>
              <label class="checkbox-item">
                <input type="checkbox" v-model="form.regional_blok_perifer" />
                Blok Perifer
              </label>
            </div>
            <div class="form-row-2">
              <div style="display: flex; flex-direction: column;">
                <label>Indikasi Tindakan & Tujuan :</label>
                <input type="text" v-model="form.indikasi_tindakan" class="input-rme" />
              </div>
            </div>
            <div class="form-row-2">
              <div style="display: flex; flex-direction: column;">
                <label>Tata Cara Tindakan :</label>
                <input type="text" v-model="form.tata_cara_tindakan" class="input-rme" />
              </div>
            </div>
          </div>
        </div>

        <!-- ================= Risiko  ================= -->
        <div class="box-rme mb-4">
            <h5 class="section-title-rme">Risiko</h5>
            <div class="form-row-2">
                <div>
                  <label>
                    <input type="checkbox" v-model="form.shock" />
                    Shock
                  </label>
                </div>
                <div>
                  <label>
                    <input type="checkbox" v-model="form.henti_jantung" />
                    Henti Jantung
                  </label>
                </div>
                <div>
                  <label>
                    <input type="checkbox" v-model="form.meninggal_dunia" />
                    Meninggal dunia di meja operasi
                  </label>
                </div>
            </div>
        </div>

        <!-- ================= Komplikasi   ================= -->
        <div class="form-section">
          <div class="box-rme mb-4">
            <h5 class="section-title-rme">Komplikasi</h5>
            
            <div class="form-row-2">
              <label>1. Anestesi Umum :</label>
            </div>

            <div style="display: flex; flex-direction: column; gap: 10px; padding-left: 20px;">
              <label style="display: flex; align-items: flex-start; gap: 8px; cursor: pointer;">
                <input type="checkbox" v-model="form.anestesi_umum_pernafasan" style="margin-top: 3px;" />
                <span>Sistem pernafasan : kejang dan penyempitan jalan nafas, kekurangan kadar O2 dalam darah, kekurangan atau kelebihan Co2 dalam darah, aspirasi pneumonia/masuknya isi lambung kedalam saluran nafas/paru</span>
              </label>

              <label style="display: flex; align-items: flex-start; gap: 8px; cursor: pointer;">
                <input type="checkbox" v-model="form.anestesi_umum_jantung" style="margin-top: 3px;" />
                <span>Jantung dan pembuluh darah : tekanan darah turun, tekanan darah naik, gangguan irama jantung sampai henti jantung</span>
              </label>

              <label style="display: flex; align-items: flex-start; gap: 8px; cursor: pointer;">
                <input type="checkbox" v-model="form.anestesi_umum_saraf" style="margin-top: 3px;" />
                <span>Sistem saraf : kejang, bangun lambat, trauma saraf tepi</span>
              </label>

              <label style="display: flex; align-items: flex-start; gap: 8px; cursor: pointer;">
                <input type="checkbox" v-model="form.anestesi_umum_intubasi" style="margin-top: 3px;" />
                <span>Tindakan laringoskopi intubasi (gigi patah, luka mulut, pendarahan)</span>
              </label>

              <label style="display: flex; align-items: flex-start; gap: 8px; cursor: pointer;">
                <input type="checkbox" v-model="form.anestesi_umum_suhu" style="margin-top: 3px;" />
                <span>Suhu tubuh naik/turun.</span>
              </label>
                <label style="display: flex; align-items: flex-start; gap: 8px; cursor: pointer;">
                  <input type="checkbox" v-model="form.anestesi_umum_posisi" style="margin-top: 3px;" />
                  <div style="display: flex; flex-direction: column; gap: 5px; width: 100%;">
                    <span>Cedera akibat posisi saat operasi</span>
                    <div style="padding-left: 20px; display: flex; gap: 20px; flex-wrap: wrap;">
                      <label style="display: flex; align-items: center; gap: 5px; cursor: pointer;">
                        <input type="checkbox" v-model="form.posisi_cedera_mata" />
                        <span>Cedera mata</span>
                      </label>
                      <label style="display: flex; align-items: center; gap: 5px; cursor: pointer;">
                        <input type="checkbox" v-model="form.posisi_cedera_saraf" />
                        <span>Cedera saraf</span>
                      </label>
                      <label style="display: flex; align-items: center; gap: 5px; cursor: pointer;">
                        <input type="checkbox" v-model="form.posisi_cedera_kulit" />
                        <span>Cedera kulit/jaringan lunak</span>
                      </label>
                    </div>
                  </div>
                </label>
            </div>

            <div class="form-row-2">
              <label>2. Anestesi Regional: <i>Spinal / Epidural</i></label>
            </div>

            <div style="padding-left: 20px;">
              <label style="display: flex; align-items: flex-start; gap: 8px; cursor: pointer; margin-bottom: 5px;">
                <span>Komplikasi segera:</span>
              </label>

              <div style="padding-left: 40px; margin-bottom: 8px;">
                <label style="display: inline-flex; align-items: center; gap: 5px; cursor: pointer; margin-right: 15px;">
                  <input type="checkbox" v-model="form.komplikasi_penurunan_tekanan" />
                  <span>Penurunan tekan darah</span>
                </label>

                <label style="display: inline-flex; align-items: center; gap: 5px; cursor: pointer; margin-right: 15px;">
                  <input type="checkbox" v-model="form.komplikasi_anestesi_spinal" />
                  <span>Anestesi spinal tinggi (kesadaran, pernafasan, jantung, nafas berhenti)</span>
                </label>

                <label style="display: inline-flex; align-items: center; gap: 5px; cursor: pointer; margin-right: 15px;">
                  <input type="checkbox" v-model="form.komplikasi_reaksi_toksik" />
                  <span>Reaksi toksik (kejang, henti jantung)</span>
                </label>

                <label style="display: inline-flex; align-items: center; gap: 5px; cursor: pointer; margin-right: 15px;">
                  <input type="checkbox" v-model="form.komplikasi_reaksi_alergi" />
                  <span>Reaksi alergi (syok anafilatik sampai meninggal)</span>
                </label>
              </div>
            
              <label style="display: inline-flex; align-items: center; gap: 5px; cursor: pointer; margin-right: 15px; margin-bottom: 5px;">
                <input type="checkbox" v-model="form.anestesi_regional_komplikasi_lanjutan" />
                <span>Komplikasi lanjutan</span>
              </label>
            
              <label style="display: inline-flex; align-items: center; gap: 5px; cursor: pointer; margin-right: 15px; margin-bottom: 5px;">
                <input type="checkbox" v-model="form.anestesi_regional_nyeri_kepala" />
                <span>Nyeri kepala cekot-cekot</span>
              </label>
            
              <label style="display: inline-flex; align-items: center; gap: 5px; cursor: pointer; margin-right: 15px; margin-bottom: 5px;">
                <input type="checkbox" v-model="form.anestesi_regional_nyeri_punggung" />
                <span>Nyeri punggung</span>
              </label>
            
              <label style="display: inline-flex; align-items: center; gap: 5px; cursor: pointer; margin-right: 15px; margin-bottom: 5px;">
                <input type="checkbox" v-model="form.anestesi_regional_infeksi" />
                <span>Infeksi</span>
              </label>
            
              <label style="display: inline-flex; align-items: center; gap: 5px; cursor: pointer; margin-right: 15px; margin-bottom: 5px;">
                <input type="checkbox" v-model="form.anestesi_regional_tidak_bisa_berkemih" />
                <span>Tidak bisa berkemih</span>
              </label>
            
              <label style="display: inline-flex; align-items: center; gap: 5px; cursor: pointer; margin-right: 15px; margin-bottom: 5px;">
                <input type="checkbox" v-model="form.anestesi_regional_cedera_saraf" />
                <span>Cedera saraf</span>
              </label>
            
              <label style="display: inline-flex; align-items: center; gap: 5px; cursor: pointer; margin-bottom: 5px;">
                <input type="checkbox" v-model="form.anestesi_regional_pendarahan" />
                <span>Pendarahan</span>
              </label>
            </div>
            <div class="form-row-2">
              <div style="display: flex; flex-direction: column;">
                <label>Prognosis  :</label>
                <input type="text" v-model="form.prognosis" class="input-rme" />
              </div>
            </div>
            <div class="form-row-2">
              <div style="display: flex; flex-direction: column;">
                <label>Alternatif tindakan :</label>
                <input type="text" v-model="form.alternatif_tindakan" class="input-rme" />
              </div>
            </div>
            <div class="form-row-2">
              <div style="display: flex; flex-direction: column;">
                <label>Lain-lain :</label>
                <input type="text" v-model="form.lain_lain" class="input-rme" />
              </div>
            </div>
          </div>
        </div>

        <div class="box-rme mb-4">
            <h5 class="section-title-rme">PEMBERIAN INFORMASI</h5>
          <div class="signature-row">
              <div>
                  <label class="text-center d-block" style="margin-bottom:20px; line-height:1.6;">
                      Dengan ini menyatakan bahwa saya telah menerangkan hal-hal di atas secara benar dan jelas dan memberikan kesempatan untuk bertanya dan atau berdiskusi 
                  </label><br>
                
                  <div class="text-center">
                      <label class="fw-bold mb-2 d-block">Dokter Pelaksana</label>
                      <VueSignaturePad ref="ttd_dokter" :options="sigOption" class="signature-box-rme mx-auto" />
                      <div class="signature-actions mt-2">
                      <button @click="clearSign('ttd_dokter')" class="btn-clear mt-2">Clear ↻</button>
                      <button @click="saveSign('ttd_dokter')" class="btn-save mt-2">Simpan ✔</button></div>
                      <input type="text" v-model="form.nama_dokter_ttd" class="input-rme mt-2" placeholder="Nama Lengkap Dokter" />
                  </div>
                  <div>
                      <label>Tanggal :</label>
                      <input type="date" v-model="form.tanggal_dokter" class="input-rme" />
                  </div>
                  <div>
                      <label>Waktu :</label>
                      <input type="time" v-model="form.waktu_dokter" class="input-rme" />
                  </div>
              </div>
          
            <div>
                <label class="text-center d-block" style="margin-bottom:20px; line-height:1.6;">
                    Dengan ini menyatakan bahwa saya telah menerima informasi dari dokter sebagaimana di atas kemudian yang saya beri tanda/paraf di kolom kanannya, dan telah memahaminya              
                </label>          
                <div class="text-center">
                    <label class="fw-bold mb-2 d-block">Pasien/Keluarga</label>
                    <VueSignaturePad ref="ttd_pasien" :options="sigOption" class="signature-box-rme mx-auto" />
                    <div class="signature-actions mt-2">
                      <button @click="clearSign('ttd_pasien')" class="btn-clear mt-2">Clear ↻</button>
                    <button @click="saveSign('ttd_pasien')" class="btn-save mt-2">Simpan ✔</button></div>
                    <input type="text" v-model="form.nama_pasien_ttd" class="input-rme mt-2" placeholder="Nama Lengkap Pasien/Keluarga" />
                </div>
                <div>
                    <label>Tanggal :</label>
                    <input type="date" v-model="form.tanggal_pasien" class="input-rme" />
                </div>
                <div>
                    <label>Waktu :</label>
                    <input type="time" v-model="form.waktu_pasien" class="input-rme" />
                </div>
            </div>
        </div>
    <label class="d-block" style="margin-bottom:20px; line-height:1.6;">
        * Bila pasien tidak kompeten atau tidak mau menerima informasi, maka penerima informasi adalah wali atau keluarga terdekat.
    </label> 
        </div>

        <!-- ================= PERNYATAAN (Dynamic Title) ================= -->
        <div class="box-rme mb-4">
          <h5 class="section-title-rme">{{ pernyataanTitle }}</h5>

          <div class="row mt-4">
            <div class="col-md-12 mb-4">
              <label style="margin-bottom: 20px; text-align: justify; display: block; line-height: 1.6;">
                  Yang bertanda tangan di bawah ini, saya nama 
                  <span style="color: rgb(0, 127, 247); font-weight: 700;">
                      <input type="text" v-model="form.pernyataan_nama" class="line-input" style="border-bottom: 2px dotted rgb(0, 127, 247); padding: 0 5px; min-width: 200px;">
                  </span>
                  , tanggal lahir
                  <span style="color: rgb(0, 127, 247); font-weight: 700;">
                      <input type="date" v-model="form.pernyataan_tanggal_lahir" class="line-input" style="border-bottom: 2px dotted rgb(0, 127, 247); padding: 0 5px; min-width: 150px;">
                  </span>
                  <select v-model="form.pernyataan_jenis_kelamin" class="line-input" style="border-bottom: 2px dotted rgb(0, 127, 247); padding: 0 5px; min-width: 100px; color: #667eea; font-weight: 700;">
                    <option value="L">laki-laki</option>
                    <option value="P">perempuan</option>
                  </select>, alamat
                  <span style="color: rgb(0, 127, 247); font-weight: 700;">
                      <input type="text" v-model="form.pernyataan_alamat" class="line-input"  style="border-bottom: 2px dotted rgb(0, 127, 247); padding: 0 5px; min-width: 250px;">
                  </span>
                  Dengan ini menyatakan <b>{{ pernyataanAction }}</b> untuk dilakukannya tindakan <b>ANESTESI</b> terhadap saya /
                  <span style="color: rgb(0, 127, 247); font-weight: 700;">
                      <input type="text" v-model="form.pernyataan_hubungan" class="line-input"style="border-bottom: 2px dotted rgb(0, 127, 247); padding: 0 5px; min-width: 120px;">
                  </span>
                   saya* bernama
                  <span style="color: rgb(0, 127, 247); font-weight: 700;">
                      <input type="text" v-model="form.pernyataan_nama_pasien" class="line-input" style="border-bottom: 2px dotted rgb(0, 127, 247); padding: 0 5px; min-width: 200px;">
                  </span>
                  tanggal lahir
                  <span style="color: rgb(0, 127, 247); font-weight: 700;">
                      <input type="date" v-model="form.pernyataan_tanggal_lahir_pasien" class="line-input" style="border-bottom: 2px dotted rgb(0, 127, 247); padding: 0 5px; min-width: 150px;">
                  </span> 
                  <select v-model="form.pernyataan_jenis_kelamin_pasien" class="line-input" style="border-bottom: 2px dotted rgb(0, 127, 247); padding: 0 5px; min-width: 100px; color: #667eea; font-weight: 700;">
                    <option value="L">laki-laki</option>
                    <option value="P">perempuan</option>
                  </select>, alamat
                  <span style="color: rgb(0, 127, 247); font-weight: 700;">
                      <input type="text" v-model="form.pernyataan_alamat_pasien" class="line-input" style="border-bottom: 2px dotted rgb(0, 127, 247); padding: 0 5px; min-width: 250px;">
                  </span> <br> <br>
                  Saya telah dijelaskan dan memahami tentang jenis tindakan pembiusan beserta manfaat, risiko dan komplikasi lain yang mungkin timbul.                 
                  <br> 
                  Saya juga menyadari bahwa dokter melakukan suatu upaya dan oleh karena ilmu kedokteran bukanlah ilmu pasti, maka keberhasilan tindakan kedokteran bukanlah keniscayaan, melainkan sangat bergantung kepada izin Tuhan Yang Maha Esa.
              </label>
              <div class="row mb-3">
                <div class="col-md-6 mb-2">
                  <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                    <span>Medan, Tanggal</span>
                    <input 
                      type="date" 
                      v-model="form.pernyataan_tanggal" 
                      class="input-rme"
                      style="width: 200px;"
                    />
                    <span>Waktu</span>
                    <input 
                      type="time" 
                      v-model="form.pernyataan_waktu" 
                      class="input-rme"
                      style="width: 130px;"
                    />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>


<!-- ================= TANDA TANGAN ================= -->
<div class="box-rme mb-4">
  <h5 class="section-title-rme">Tanda Tangan</h5>

  <div class="signature-grid-2x2" style="text-align: center; margin-top: 30px;">
    <!-- BARIS 1 KOLOM 1 -->
    <div>
      <label class="fw-bold mb-2">Yang Menyatakan (Pasien)</label>
      <VueSignaturePad ref="ttd_pasien_pernyataan" :options="sigOption" class="signature-box-rme mx-auto" />
      <div class="signature-actions mt-2">
        <button @click="clearSign('ttd_pasien_pernyataan')" class="btn-clear mt-2">Clear ↻</button>
        <button @click="saveSign('ttd_pasien_pernyataan')" class="btn-save mt-2">Simpan ✔</button>
      </div>
      <input type="text" v-model="form.nama_pasien_pernyataan" class="input-rme mt-2" placeholder="Nama Lengkap Pasien" />
    </div>

    <!-- BARIS 1 KOLOM 2 -->
    <div>
      <label class="fw-bold mb-2">Dokter</label>
      <VueSignaturePad ref="ttd_dokter_persetujuan" :options="sigOption" class="signature-box-rme mx-auto" />
      <div class="signature-actions mt-2">
        <button @click="clearSign('ttd_dokter_persetujuan')" class="btn-clear mt-2">Clear ↻</button>
        <button @click="saveSign('ttd_dokter_persetujuan')" class="btn-save mt-2">Simpan ✔</button>
      </div>
      <input type="text" v-model="form.nama_dokter_persetujuan" class="input-rme mt-2" placeholder="Nama Lengkap Dokter" />
    </div>
  </div>

  <!-- SAKSI DI TENGAH -->
  <div style="text-align: center; margin-top: 30px;">
    <h4 class="fw-bold mb-3">Saksi</h4>

    <div class="signature-grid-2x2">
      <!-- SAKSI 1 - KELUARGA -->
      <div>
        <VueSignaturePad ref="ttd_keluarga" :options="sigOption" class="signature-box-rme mx-auto" />
        <input type="text" v-model="form.nama_keluarga_ttd" class="input-rme mt-2" placeholder="Nama Lengkap Saksi" />
        <div class="signature-actions mt-2">
          <button @click="clearSign('ttd_keluarga')" class="btn-clear mt-2">Clear ↻</button>
          <button @click="saveSign('ttd_keluarga')" class="btn-save mt-2">Simpan ✔</button>
        </div>
      </div>

      <!-- SAKSI 2 - PERAWAT -->
      <div>
        <VueSignaturePad ref="ttd_perawat" :options="sigOption" class="signature-box-rme mx-auto" />
        <input type="text" v-model="form.nama_perawat_ttd" class="input-rme mt-2" placeholder="Nama Lengkap Saksi" />
        <div class="signature-actions mt-2">
          <button @click="clearSign('ttd_perawat')" class="btn-clear mt-2">Clear ↻</button>
          <button @click="saveSign('ttd_perawat')" class="btn-save mt-2">Simpan ✔</button>
        </div>
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
</div></div></div>
</div>
</template>

<script>
import axios from "axios";

export default {
  name: "FormPenolakanAnestesi",
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
      sigOption: {
        penColor: "black",
        backgroundColor: "white",
      },
      form: {
        uuid: "",
        uuid_pasien: "",
        jenis_form: "penolakan", // 🔥 TAMBAHAN: default penolakan
        tanggal: "",
        waktu: "",
        no_rm: "",
        no_surat: "",
        nik: "",
        nama: "",
        tanggal_lahir: "",
        jenis_kelamin: "L",
        alamat: "",
        
        // Pemberian Informasi
        dokter_pelaksana: "",
        perawat_asisten: "",
        penerima_informasi: "",
        
        // Diagnosis
        status_fisik_asa: "",
        klinis: "",
        radiologi: "",
        ekg: "",
        laboratorium: "",
        
        // Tindakan Kedokteran - Anestesi Umum
        umum_intubasi: false,
        umum_lma: false,
        umum_fm: false,
        umum_tiva: false,
        
        // Tindakan Kedokteran - Anestesi Regional
        regional_spinal1: false,
        regional_spinal2: false,
        regional_blok_perifer: false,
        
        indikasi_tindakan: "",
        tata_cara_tindakan: "",
        
        // Risiko
        shock: false,
        henti_jantung: false,
        meninggal_dunia: false,
        
        // Komplikasi Anestesi Umum
        anestesi_umum_pernafasan: false,
        anestesi_umum_jantung: false,
        anestesi_umum_saraf: false,
        anestesi_umum_intubasi: false,
        anestesi_umum_suhu: false,
        anestesi_umum_posisi: false,
        posisi_cedera_mata: false,
        posisi_cedera_saraf: false,
        posisi_cedera_kulit: false,
        
        // Komplikasi Anestesi Regional
        anestesi_regional_komplikasi_segera: false,
        komplikasi_penurunan_tekanan: false,
        komplikasi_anestesi_spinal: false,
        komplikasi_reaksi_toksik: false,
        komplikasi_reaksi_alergi: false,
        anestesi_regional_komplikasi_lanjutan: false,
        anestesi_regional_nyeri_kepala: false,
        anestesi_regional_nyeri_punggung: false,
        anestesi_regional_infeksi: false,
        anestesi_regional_tidak_bisa_berkemih: false,
        anestesi_regional_cedera_saraf: false,
        anestesi_regional_pendarahan: false,
        
        prognosis: "",
        alternatif_tindakan: "",
        lain_lain: "",
        
        // Data Pernyataan
        pernyataan_nama: "",
        pernyataan_tanggal_lahir: "",
        pernyataan_jenis_kelamin: "L",
        pernyataan_alamat: "",
        pernyataan_hubungan: "",
        pernyataan_nama_pasien: "",
        pernyataan_tanggal_lahir_pasien: "",
        pernyataan_jenis_kelamin_pasien: "L",
        pernyataan_alamat_pasien: "",
        pernyataan_tanggal: "",
        pernyataan_waktu: "",

        // Tanda Tangan Pemberian Informasi
        ttd_dokter: "",
        nama_dokter_ttd: "",
        tanggal_dokter: "",
        waktu_dokter: "",
        ttd_pasien: "",
        nama_pasien_ttd: "",
        tanggal_pasien: "",
        waktu_pasien: "",
        
        // Tanda Tangan Persetujuan
        ttd_pasien_pernyataan: "",
        nama_pasien_pernyataan: "",
        ttd_dokter_persetujuan: "",
        nama_dokter_persetujuan: "",
        
        // Saksi
        ttd_keluarga: "",
        nama_keluarga_ttd: "",
        ttd_perawat: "",
        nama_perawat_ttd: "",
      },
    };
  },

  computed: {
    isEditMode() {
      return this.editData !== null && this.editData !== undefined;
    },
    
    // 🔥 COMPUTED PROPERTIES UNTUK DYNAMIC CONTENT
    formTitle() {
      return this.form.jenis_form === 'penolakan' 
        ? 'PENOLAKAN TINDAKAN ANESTESI'
        : 'PERSETUJUAN TINDAKAN ANESTESI';
    },
    
    formCode() {
      return this.form.no_surat || 
        (this.form.jenis_form === 'penolakan' ? 'RM 4.2/PTA/22' : 'RM 4.3/PTA/22');
    },
    
    pernyataanTitle() {
      return this.form.jenis_form === 'penolakan'
        ? 'PERNYATAAN PENOLAKAN TINDAKAN KEDOKTERAN'
        : 'PERSETUJUAN TINDAKAN KEDOKTERAN';
    },
    
    pernyataanAction() {
      return this.form.jenis_form === 'penolakan'
        ? 'PENOLAKAN'
        : 'PERSETUJUAN';
    }
  },

async mounted() {
  console.log("🟢 COMPONENT - Mounted");
  console.log("🟢 COMPONENT - editData:", this.editData);
  console.log("🟢 COMPONENT - viewData:", this.viewData);
  console.log("🟢 COMPONENT - selectedPatient:", this.selectedPatient);

  await this.fetchTahunAkreditasi();
  
  this.disabledSubmit = false;
  
  // ✅ PERBAIKAN: Cek apakah viewData adalah boolean true
  if (this.viewData === true) {
    console.warn("⚠️ viewData adalah boolean, pakai editData");
    this.disabledSubmit = true;
    // Gunakan editData untuk VIEW mode
    if (this.editData) {
      this.loadDataForEdit();
    } else {
      console.error("❌ Tidak ada data untuk VIEW mode!");
      this.$emit("back");
    }
  } else if (this.viewData && typeof this.viewData === 'object') {
    // viewData adalah object (correct)
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

    async fetchTahunAkreditasi() {
      try {
        const response = await axios.get('/api/tahun-akreditasi');
        const tahun = response.data.tahun || '22';
        
        // Update no_surat untuk display
        if (!this.form.no_surat && this.form.jenis_form) {
          this.form.no_surat = this.form.jenis_form === 'penolakan'
            ? `RM 4.2/PTA/${tahun}`
            : `RM 4.3/PTA/${tahun}`;
        }
      } catch (error) {
        console.error("Error fetch tahun:", error);
      }
    },
    
    // 🔥 METHOD BARU: Update form type
    updateFormType() {
      console.log('📝 Form type changed to:', this.form.jenis_form);
      // Optional: reset beberapa field jika diperlukan
    },

loadDataForEdit() {
  console.log("🟢 LOAD EDIT - Mulai load data");
  console.log("🟢 LOAD EDIT - editData:", this.editData);
  console.log("🟢 LOAD EDIT - viewData:", this.viewData);

  try {
    // ✅ PERBAIKAN: Handle viewData boolean
    let sourceData;
    
    if (this.viewData === true) {
      // Jika viewData boolean, gunakan editData
      sourceData = this.editData;
    } else if (this.viewData && typeof this.viewData === 'object') {
      // Jika viewData object, gunakan viewData
      sourceData = this.viewData;
    } else {
      // Fallback ke editData
      sourceData = this.editData;
    }
    
    console.log("🔍 SOURCE DATA:", sourceData);
    
    if (!sourceData) {
      console.warn("⚠️ LOAD EDIT - Tidak ada data!");
      this.setDataForm();
      return;
    }

    console.log("🔍 jenis_form dari sourceData:", sourceData.jenis_form);

    // ✅ List SEMUA checkbox fields
    const checkboxFields = [
      'umum_intubasi', 'umum_lma', 'umum_fm', 'umum_tiva',
      'regional_spinal1', 'regional_spinal2', 'regional_blok_perifer',
      'shock', 'henti_jantung', 'meninggal_dunia',
      'anestesi_umum_pernafasan', 'anestesi_umum_jantung', 'anestesi_umum_saraf',
      'anestesi_umum_intubasi', 'anestesi_umum_suhu', 'anestesi_umum_posisi',
      'posisi_cedera_mata', 'posisi_cedera_saraf', 'posisi_cedera_kulit',
      'anestesi_regional_komplikasi_segera', 'komplikasi_penurunan_tekanan',
      'komplikasi_anestesi_spinal', 'komplikasi_reaksi_toksik', 'komplikasi_reaksi_alergi',
      'anestesi_regional_komplikasi_lanjutan', 'anestesi_regional_nyeri_kepala',
      'anestesi_regional_nyeri_punggung', 'anestesi_regional_infeksi',
      'anestesi_regional_tidak_bisa_berkemih', 'anestesi_regional_cedera_saraf',
      'anestesi_regional_pendarahan'
    ];

    // ✅ Populate form dari sourceData
    Object.keys(this.form).forEach((key) => {
      if (sourceData.hasOwnProperty(key)) {
        const value = sourceData[key];

        if (checkboxFields.includes(key)) {
          this.form[key] = (value === 1 || value === "1" || value === true);
        } else {
          this.form[key] = value !== null ? value : "";
        }

        if (key === 'jenis_form' || key === 'uuid') {
          console.log(`🔍 Set ${key}:`, this.form[key]);
        }
      }
    });

    console.log("🔍 Form jenis_form setelah populate:", this.form.jenis_form);

    // ✅ Render signatures
    this.$nextTick(() => {
      console.log("🖊️ Rendering signatures...");
      this.renderSignature("ttd_dokter", this.form.ttd_dokter);
      this.renderSignature("ttd_pasien", this.form.ttd_pasien);
      this.renderSignature("ttd_pasien_pernyataan", this.form.ttd_pasien_pernyataan);
      this.renderSignature("ttd_dokter_persetujuan", this.form.ttd_dokter_persetujuan);
      this.renderSignature("ttd_keluarga", this.form.ttd_keluarga);
      this.renderSignature("ttd_perawat", this.form.ttd_perawat);
    });

    console.log("✅ LOAD EDIT - Form setelah populate:", this.form);

  } catch (error) {
    console.error("❌ LOAD EDIT - Error:", error);
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

      const { data } = pad.saveSignature();
      this.form[refName] = data;
      console.log("TTD saved:", refName);
    },

    clearSign(refName) {
      const pad = this.$refs[refName];
      if (pad) {
        pad.clearSignature();
      }
    },

async submitForm() {
  console.log("🔥 SUBMIT - Form Data:", this.form);
  console.log("🔥 SUBMIT - Jenis Form:", this.form.jenis_form);

  // ✅ Validasi jenis form
  if (!this.form.jenis_form) {
    alert("❌ Pilih jenis formulir terlebih dahulu!");
    return;
  }

  // ✅ Validasi data pernyataan
  if (!this.form.pernyataan_nama?.trim()) {
    alert("❌ Nama yang menyatakan harus diisi!");
    return;
  }

  if (!this.form.pernyataan_tanggal_lahir) {
    alert("❌ Tanggal lahir yang menyatakan harus diisi!");
    return;
  }

  // ✅ Validasi UUID Pasien
  if (!this.form.uuid_pasien) {
    alert("❌ Data pasien tidak valid!");
    return;
  }

  this.loadingSubmit = true;

  try {
    const fd = new FormData();

    // ✅ Append semua field
    Object.keys(this.form).forEach((key) => {
      let value = this.form[key];
      
      if (typeof value === 'boolean') {
        fd.append(key, value ? '1' : '0');
      } else if (value === null || value === undefined) {
        fd.append(key, '');
      } else {
        fd.append(key, value);
      }
    });

    // ✅ Debug: Lihat apa yang dikirim
    console.log("📤 FORM DATA yang dikirim:");
    for (let [key, value] of fd.entries()) {
      console.log(`   ${key}:`, value);
    }

    const response = await axios.post(
      "/master/pasien/penolakan-tindakan-anestesi",
      fd,
      { 
        headers: { 
          "Content-Type": "multipart/form-data" 
        } 
      }
    );

    console.log("✅ SUBMIT - Response:", response.data);

    if (response.data.status) {
      alert(`✅ ${response.data.message}`);
      this.$emit("back");
    } else {
      alert(`❌ ${response.data.message || "Gagal menyimpan form!"}`);
    }
  } catch (error) {
    console.error("❌ SUBMIT - ERROR:", error);
    
    let errorMsg = "❌ Gagal menyimpan form!";
    
    if (error.response?.data) {
      const data = error.response.data;
      errorMsg = data.message || errorMsg;
      
      // Tampilkan detail error validasi
      if (data.errors) {
        const errorList = Object.keys(data.errors)
          .map(key => `• ${key}: ${data.errors[key][0]}`)
          .join('\n');
        errorMsg += '\n\n📋 Detail Error:\n' + errorList;
      }
      
      // Debug mode
      console.log("📋 Error Details:", {
        message: data.message,
        errors: data.errors,
        full: data
      });
    }
    
    alert(errorMsg);
  } finally {
    this.loadingSubmit = false;
  }
},
  },
};
</script>

<style scoped>

.signature-grid-2x2 {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 30px 20px;
  margin-top: 20px;
}

.form-row-block {
  display: flex;
  flex-direction: column;
  gap: 10px;
  padding-left: 20px;
}

.form-row-block .checkbox-item {
  display: flex;
  align-items: flex-start;
  gap: 8px;
  margin: 0;
  cursor: pointer;
}

.form-row-block .checkbox-item input[type="checkbox"] {
  margin-top: 3px;
  flex-shrink: 0;
  cursor: pointer;
}

.form-section {
  margin-bottom: 20px;
}

.anesthesia-section {
  border-top: 1px solid #ccc;
  padding-top: 10px;
}

.section-label {
  display: block;
  margin-bottom: 10px;
  font-weight: normal;
}

.line-input {
  border: none;
  border-bottom: 2px dotted;
  background: transparent;
  outline: none;
  text-align: center;
  font-family: inherit;
  font-size: inherit;
  font-weight: 700;
}

.line-input:focus {
  border-bottom: 2px solid ;
  background: #f0f4ff;
}

.form-row-inline {
  display: flex;
  align-items: center;
  margin-bottom: 10px;
  gap: 20px;
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

.alert {
  padding: 15px;
  border-radius: 6px;
  margin-bottom: 20px;
}

.alert-info {
  background-color: #e3f2fd;
  border-left: 4px solid #2196f3;
  color: #1565c0;
}

.checkbox-item input[type="checkbox"] {
  margin: 0;
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

.radio-label {
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

.form-type-selector {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 20px;
  margin-top: 20px;
}

.radio-card {
  position: relative;
  border: 3px solid #ddd;
  border-radius: 12px;
  padding: 30px 20px;
  cursor: pointer;
  transition: all 0.3s ease;
  background: white;
  display: block;
}

.radio-card input[type="radio"] {
  position: absolute;
  opacity: 0;
  pointer-events: none;
}

.radio-card:hover {
  border-color: rgb(0, 127, 247);
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(102, 126, 234, 0.2);
}

.radio-card.active {
  border-color: rgb(0, 127, 247);
  background: linear-gradient(135deg, #f5f7ff 0%, #e8ecff 100%);
  box-shadow: 0 6px 20px rgba(102, 126, 234, 0.3);
}

.radio-card-content {
  text-align: center;
}

.radio-card-content h4 {
  color: rgb(0, 127, 247);
  font-size: 24px;
  font-weight: 700;
  margin: 0 0 10px 0;
}

.radio-card-content p {
  color: #666;
  font-size: 16px;
  margin: 0 0 15px 0;
}

.radio-card-content .code {
  display: inline-block;
  background: rgb(0, 127, 247);
  color: white;
  padding: 6px 16px;
  border-radius: 20px;
  font-size: 14px;
  font-weight: 600;
}

.radio-card.active .radio-card-content h4 {
  color: rgb(0, 127, 247);
}

.radio-card.active .radio-card-content .code {
  background: rgb(0, 127, 247);
}

@media (max-width: 768px) {
  .col-md-4,
  .col-md-6 {
    flex: 0 0 100%;
    max-width: 100%;
  }

    .form-type-selector {
    grid-template-columns: 1fr;
  }
}

</style>
