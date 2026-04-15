<template>
  <button @click="$emit('back')" class="btn-back">Kembali</button>

  <div class="container py-4">
    <div class="text-center mb-4">
      <h3 class="fw-bold">LAPORAN ANESTESI</h3>
      <p class="text-muted">{{ form.no_surat}}</p>
    </div>

    <!-- TABS NAVIGATION -->
    <div class="tabs-navigation mb-4">
      <button 
        v-for="tab in 3" 
        :key="tab" 
        @click="currentTab = tab"
        :class="['tab-button', { 'tab-active': currentTab === tab }]"
      >
        Halaman {{ tab }}
      </button>
    </div>

    <!-- HALAMAN 1 - DATA UTAMA & TEKNIK ANESTESI -->
    <div v-show="currentTab === 1">
      <!-- IDENTITAS PASIEN -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Identitas Pasien</h5>
        <div class="row mb-3">
          <div class="col-md-3">
            <label>Tanggal</label>
            <input type="date" v-model="form.tanggal" class="input-rme" />
          </div>
          <div class="col-md-3">
            <label>No. RM</label>
            <input v-model="form.no_rm" class="input-rme" readonly />
          </div>
          <div class="col-md-6">
            <label>Nama Pasien</label>
            <input v-model="form.nama" class="input-rme" readonly />
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-md-4">
            <label>Tanggal Lahir / Umur</label>
            <input v-model="form.tanggal_lahir" class="input-rme" readonly />
          </div>
          <div class="col-md-2">
            <label>L/P</label>
            <input v-model="form.jenis_kelamin" class="input-rme" readonly />
          </div>
          <div class="col-md-6">
            <label>NIK</label>
            <input v-model="form.nik" class="input-rme" readonly />
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-md-4">
            <label>DPJP Anestesi</label>
            <div class="dropdown-dokter mt-2">
              <select v-model="form.dpjp_anestesi" class="form-select-dokter">
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
          <div class="col-md-4">
            <label>Asisten Anestesi</label>
            <input v-model="form.asisten_anestesi" class="input-rme" />
          </div>
          <div class="col-md-4">
            <label>DPJP Bedah</label>
            <div class="dropdown-dokter mt-2">
              <select v-model="form.dpjp_bedah" class="form-select-dokter">
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

      <!-- DIAGNOSIS -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Diagnosis & Pembedahan</h5>
        <div class="row mb-3">
          <div class="col-md-4">
            <label>Diagnosis Pra Bedah</label>
            <textarea v-model="form.diagnosis_pra_bedah" class="textarea-rme"></textarea>
          </div>
          <div class="col-md-4">
            <label>Jenis Pembedahan</label>
            <textarea v-model="form.jenis_pembedahan" class="textarea-rme"></textarea>
          </div>
          <div class="col-md-4">
            <label>Diagnosis Pasca Bedah</label>
            <textarea v-model="form.diagnosis_pasca_bedah" class="textarea-rme"></textarea>
          </div>
        </div>
      </div>

      <!-- TEKNIK ANESTESI -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Teknik Anestesi</h5>
        <div class="row mb-3">
          <div class="col-md-4">
            <label class="checkbox-label">
              <input type="checkbox" v-model="form.teknik_sedasi" class="me-2" />
              Sedasi
            </label>
            <input v-if="form.teknik_sedasi" v-model="form.teknik_sedasi_detail" class="input-rme mt-2" placeholder="Detail sedasi..." />
          </div>
          <div class="col-md-4">
            <label class="checkbox-label">
              <input type="checkbox" v-model="form.teknik_anestesi_umum" class="me-2" />
              Anestesi Umum
            </label>
            <input v-if="form.teknik_anestesi_umum" v-model="form.teknik_anestesi_umum_detail" class="input-rme mt-2" placeholder="Detail anestesi umum..." />
          </div>
          <div class="col-md-4">
            <label class="checkbox-label">
              <input type="checkbox" v-model="form.teknik_lain" class="me-2" />
              Lain-lain
            </label>
            <input v-if="form.teknik_lain" v-model="form.teknik_lain_detail" class="input-rme mt-2" placeholder="Detail lain-lain..." />
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <label class="checkbox-label">
              <input type="checkbox" v-model="form.teknik_spinal" class="me-2" />
              Spinal
            </label>
          </div>
          <div class="col-md-4">
            <label class="checkbox-label">
              <input type="checkbox" v-model="form.teknik_epidural" class="me-2" />
              Epidural
            </label>
          </div>
          <div class="col-md-4">
            <label class="checkbox-label">
              <input type="checkbox" v-model="form.teknik_kaudal" class="me-2" />
              Kaudal
            </label>
          </div>
        </div>
        <div class="row mt-2">
          <div class="col-md-12">
            <label>Blok Perifer</label>
            <input v-model="form.blok_perifer" class="input-rme" placeholder="Jelaskan blok perifer..." />
          </div>
        </div>
      </div>

      <!-- TEKNIK DAN ALAT KHUSUS -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Teknik dan Alat Khusus</h5>
        <div class="row mb-2">
          <div class="col-md-3">
            <label class="checkbox-label">
              <input type="checkbox" v-model="form.alat_hipotensi" class="me-2" />
              Hipotensi
            </label>
          </div>
          <div class="col-md-3">
            <label class="checkbox-label">
              <input type="checkbox" v-model="form.alat_tci" class="me-2" />
              TCI
            </label>
          </div>
          <div class="col-md-3">
            <label class="checkbox-label">
              <input type="checkbox" v-model="form.alat_cpb" class="me-2" />
              CPB
            </label>
          </div>
          <div class="col-md-3">
            <label class="checkbox-label">
              <input type="checkbox" v-model="form.alat_ventilasi_satu_paru" class="me-2" />
              Ventilasi Satu Paru
            </label>
          </div>
        </div>
        <div class="row mb-2">
          <div class="col-md-3">
            <label class="checkbox-label">
              <input type="checkbox" v-model="form.alat_bronkoskopi" class="me-2" />
              Bronkoskopi
            </label>
          </div>
          <div class="col-md-3">
            <label class="checkbox-label">
              <input type="checkbox" v-model="form.alat_glidescope" class="me-2" />
              Glidescope
            </label>
          </div>
          <div class="col-md-3">
            <label class="checkbox-label">
              <input type="checkbox" v-model="form.alat_usg" class="me-2" />
              USG
            </label>
          </div>
          <div class="col-md-3">
            <label class="checkbox-label">
              <input type="checkbox" v-model="form.alat_stimulator_saraf" class="me-2" />
              Stimulator Saraf
            </label>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <label class="checkbox-label">
              <input type="checkbox" v-model="form.alat_lainnya_check" class="me-2" />
              Lain-lain
            </label>
            <input v-if="form.alat_lainnya_check" v-model="form.alat_lainnya" class="input-rme mt-2" placeholder="Jelaskan alat lainnya..." />
          </div>
        </div>
      </div>

      <!-- MONITORING -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Monitoring</h5>
        <div class="row mb-2">
          <div class="col-md-3">
            <label class="checkbox-label">
              <input type="checkbox" v-model="form.monitoring_ekg" class="me-2" />
              EKG Lead
            </label>
            <input v-if="form.monitoring_ekg" v-model="form.monitoring_ekg_lead" class="input-rme mt-2" placeholder="Lead..." />
          </div>
          <div class="col-md-3">
            <label class="checkbox-label">
              <input type="checkbox" v-model="form.monitoring_arteri_line" class="me-2" />
              Arteri Line
            </label>
            <input v-if="form.monitoring_arteri_line" v-model="form.monitoring_arteri_line_detail" class="input-rme mt-2" placeholder="Detail..." />
          </div>
          <div class="col-md-3">
            <label class="checkbox-label">
              <input type="checkbox" v-model="form.monitoring_etco2" class="me-2" />
              EtCO2
            </label>
          </div>
          <div class="col-md-3">
            <label class="checkbox-label">
              <input type="checkbox" v-model="form.monitoring_stetoskop" class="me-2" />
              Stetoskop
            </label>
          </div>
        </div>
        <div class="row mb-2">
          <div class="col-md-3">
            <label class="checkbox-label">
              <input type="checkbox" v-model="form.monitoring_nibp" class="me-2" />
              NIBP
            </label>
          </div>
          <div class="col-md-3">
            <label class="checkbox-label">
              <input type="checkbox" v-model="form.monitoring_ngt" class="me-2" />
              NGT
            </label>
          </div>
          <div class="col-md-3">
            <label class="checkbox-label">
              <input type="checkbox" v-model="form.monitoring_bis" class="me-2" />
              BIS
            </label>
          </div>
          <div class="col-md-3">
            <label class="checkbox-label">
              <input type="checkbox" v-model="form.monitoring_cvp" class="me-2" />
              CVP
            </label>
            <input v-if="form.monitoring_cvp" v-model="form.monitoring_cvp_detail" class="input-rme mt-2" placeholder="Detail..." />
          </div>
        </div>
        <div class="row mb-2">
          <div class="col-md-3">
            <label class="checkbox-label">
              <input type="checkbox" v-model="form.monitoring_cath_a_pulmo" class="me-2" />
              Cath A Pulmo
            </label>
          </div>
          <div class="col-md-3">
            <label class="checkbox-label">
              <input type="checkbox" v-model="form.monitoring_spo2" class="me-2" />
              SpO2
            </label>
          </div>
          <div class="col-md-3">
            <label class="checkbox-label">
              <input type="checkbox" v-model="form.monitoring_kateter_urine" class="me-2" />
              Kateter Urine
            </label>
          </div>
          <div class="col-md-3">
            <label class="checkbox-label">
              <input type="checkbox" v-model="form.monitoring_temp" class="me-2" />
              Temp
            </label>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <label class="checkbox-label">
              <input type="checkbox" v-model="form.monitoring_lainnya_check" class="me-2" />
              Lain-lain
            </label>
            <input v-if="form.monitoring_lainnya_check" v-model="form.monitoring_lainnya" class="input-rme mt-2" placeholder="Jelaskan monitoring lainnya..." />
          </div>
        </div>
      </div>

      <!-- STATUS FISIK ASA -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Status Fisik</h5>
        <div class="row mb-3">
          <div class="col-md-8">
            <label class="me-3">ASA:</label>
            <label class="me-3">
              <input type="radio" v-model="form.asa" value="1" class="me-1" />
              1
            </label>
            <label class="me-3">
              <input type="radio" v-model="form.asa" value="2" class="me-1" />
              2
            </label>
            <label class="me-3">
              <input type="radio" v-model="form.asa" value="3" class="me-1" />
              3
            </label>
            <label class="me-3">
              <input type="radio" v-model="form.asa" value="4" class="me-1" />
              4
            </label>
            <label class="me-3">
              <input type="radio" v-model="form.asa" value="5" class="me-1" />
              5
            </label>
            <label>
              <input type="radio" v-model="form.asa" value="E" class="me-1" />
              E
            </label>
          </div>
          <div class="col-md-4">
            <label class="me-3">Alergi:</label>
            <label class="me-3">
              <input type="radio" v-model="form.alergi" value="ya" class="me-1" />
              Ya
            </label>
            <label>
              <input type="radio" v-model="form.alergi" value="tidak" class="me-1" />
              Tidak
            </label>
          </div>
        </div>
        <div class="row" v-if="form.alergi === 'ya'">
          <div class="col-md-12">
            <label>Detail Alergi</label>
            <input v-model="form.alergi_detail" class="input-rme" placeholder="Jelaskan alergi..." />
          </div>
        </div>
      </div>

      <!-- PENYULIT PRA ANESTESI -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Penyulit Pra Anestesi</h5>
        <textarea v-model="form.penyulit_pra_anestesi" class="textarea-rme"></textarea>
      </div>

      <!-- CEK LIST PERSIAPAN ANESTESI -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Cek List Persiapan Anestesi</h5>
        <div class="row mb-2">
          <div class="col-md-3">
            <label class="checkbox-label">
              <input type="checkbox" v-model="form.cek_informed_consent" class="me-2" />
              Informed Consent
            </label>
          </div>
          <div class="col-md-3">
            <label class="checkbox-label">
              <input type="checkbox" v-model="form.cek_obat_anestesi" class="me-2" />
              Obat-obatan Anestesi
            </label>
          </div>
          <div class="col-md-3">
            <label class="checkbox-label">
              <input type="checkbox" v-model="form.cek_tatalaksana_jalan_nafas" class="me-2" />
              Tatalaksana Jalan Nafas
            </label>
          </div>
          <div class="col-md-3">
            <label class="checkbox-label">
              <input type="checkbox" v-model="form.cek_mesin_anestesi" class="me-2" />
              Mesin Anestesi
            </label>
          </div>
        </div>
        <div class="row">
          <div class="col-md-3">
            <label class="checkbox-label">
              <input type="checkbox" v-model="form.cek_monitoring" class="me-2" />
              Monitoring
            </label>
          </div>
          <div class="col-md-3">
            <label class="checkbox-label">
              <input type="checkbox" v-model="form.cek_obat_emergensi" class="me-2" />
              Obat-obatan Emergensi
            </label>
          </div>
          <div class="col-md-3">
            <label class="checkbox-label">
              <input type="checkbox" v-model="form.cek_suction_apparatus" class="me-2" />
              Suction Apparatus
            </label>
          </div>
        </div>
      </div>

      <!-- PENILAIAN PRA INDUKSI -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Penilaian Pra Induksi</h5>
        <div class="row mb-3">
          <div class="col-md-3">
            <label>Jam</label>
            <input type="time" v-model="form.pra_induksi_jam" class="input-rme" />
          </div>
          <div class="col-md-3">
            <label>Kesadaran</label>
            <input v-model="form.pra_induksi_kesadaran" class="input-rme" />
          </div>
          <div class="col-md-3">
            <label>Tekanan Darah</label>
            <input v-model="form.pra_induksi_td" class="input-rme" placeholder="mmHg" />
          </div>
          <div class="col-md-3">
            <label>Nadi</label>
            <input v-model="form.pra_induksi_nadi" class="input-rme" placeholder="x/menit" />
          </div>
        </div>
        <div class="row">
          <div class="col-md-3">
            <label>RR</label>
            <input v-model="form.pra_induksi_rr" class="input-rme" placeholder="x/menit" />
          </div>
          <div class="col-md-3">
            <label>Suhu</label>
            <input v-model="form.pra_induksi_suhu" class="input-rme" placeholder="°C" />
          </div>
          <div class="col-md-3">
            <label>Saturasi O2</label>
            <input v-model="form.pra_induksi_spo2" class="input-rme" placeholder="%" />
          </div>
          <div class="col-md-3">
            <label>Lain-lain</label>
            <input v-model="form.pra_induksi_lainnya" class="input-rme" />
          </div>
        </div>
      </div>

      <!-- CATATAN HALAMAN 1 -->
      <div class="box-rme">
        <h5 class="section-title-rme">Catatan</h5>
        <textarea v-model="form.catatan_halaman1" class="textarea-rme" rows="5"></textarea>
      </div>
    </div>

    <!-- HALAMAN 2 - DETAIL PROSEDUR ANESTESI -->
    <div v-show="currentTab === 2">
      <!-- INFUS & CVC -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Infus & CVC</h5>
        <label>Infus Perifer - Tempat dan Ukuran</label>
        <div class="row mb-2">
          <div class="col-md-6">
            <input v-model="form.infus_perifer_1" class="input-rme" placeholder="1. Tempat dan ukuran..." />
          </div>
          <div class="col-md-6">
            <input v-model="form.infus_perifer_2" class="input-rme" placeholder="2. Tempat dan ukuran..." />
          </div>
        </div>
        <label>CVC</label>
        <input v-model="form.cvc" class="input-rme" placeholder="Detail CVC..." />
      </div>

      <!-- POSISI -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Posisi</h5>
        <div class="row mb-2">
          <div class="col-md-3">
            <label class="checkbox-label">
              <input type="checkbox" v-model="form.posisi_terlentang" class="me-2" />
              Terlentang
            </label>
          </div>
          <div class="col-md-3">
            <label class="checkbox-label">
              <input type="checkbox" v-model="form.posisi_lithotomi" class="me-2" />
              Lithotomi
            </label>
          </div>
          <div class="col-md-3">
            <label class="checkbox-label">
              <input type="checkbox" v-model="form.posisi_prone" class="me-2" />
              Prone
            </label>
          </div>
          <div class="col-md-3">
            <label class="checkbox-label">
              <input type="checkbox" v-model="form.posisi_perlindungan_mata" class="me-2" />
              Perlindungan Mata
            </label>
          </div>
        </div>
        <div class="row mb-2">
          <div class="col-md-4">
            <label class="me-3">Lateral:</label>
            <label class="me-3">
              <input type="radio" v-model="form.posisi_lateral" value="ka" class="me-1" />
              Ka
            </label>
            <label>
              <input type="radio" v-model="form.posisi_lateral" value="ki" class="me-1" />
              Ki
            </label>
          </div>
          <div class="col-md-8">
            <label class="checkbox-label">
              <input type="checkbox" v-model="form.posisi_lainnya_check" class="me-2" />
              Lain-lain
            </label>
            <input v-if="form.posisi_lainnya_check" v-model="form.posisi_lainnya" class="input-rme mt-2" placeholder="Detail posisi lainnya..." />
          </div>
        </div>
      </div>

      <!-- PREMEDIKASI -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Premedikasi</h5>
        <div class="row">
          <div class="col-md-4">
            <label>Oral</label>
            <input v-model="form.premedikasi_oral" class="input-rme" />
          </div>
          <div class="col-md-4">
            <label>I.M</label>
            <input v-model="form.premedikasi_im" class="input-rme" />
          </div>
          <div class="col-md-4">
            <label>I.V</label>
            <input v-model="form.premedikasi_iv" class="input-rme" />
          </div>
        </div>
      </div>

      <!-- INDUKSI -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Induksi</h5>
        <div class="row">
          <div class="col-md-6">
            <label>Intravena</label>
            <input v-model="form.induksi_intravena" class="input-rme" />
          </div>
          <div class="col-md-6">
            <label>Inhalasi</label>
            <input v-model="form.induksi_inhalasi" class="input-rme" />
          </div>
        </div>
      </div>

      <!-- TATA LAKSANA JALAN NAFAS -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Tata Laksana Jalan Nafas</h5>
        <div class="row mb-3">
          <div class="col-md-3">
            <label>Face Mask No</label>
            <input v-model="form.face_mask_no" class="input-rme" />
          </div>
          <div class="col-md-3">
            <label>Oro/Nasopharing No</label>
            <input v-model="form.oro_nasopharing_no" class="input-rme" />
          </div>
          <div class="col-md-3">
            <label>ETT No</label>
            <input v-model="form.ett_no" class="input-rme" />
          </div>
          <div class="col-md-3">
            <label>ETT Jenis</label>
            <input v-model="form.ett_jenis" class="input-rme" />
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-md-3">
            <label>Fiksasi (cm)</label>
            <input v-model="form.ett_fiksasi_cm" class="input-rme" />
          </div>
          <div class="col-md-3">
            <label>LMA No</label>
            <input v-model="form.lma_no" class="input-rme" />
          </div>
          <div class="col-md-3">
            <label>LMA Jenis</label>
            <input v-model="form.lma_jenis" class="input-rme" />
          </div>
        </div>
        <div class="row">
          <div class="col-md-3">
            <label class="checkbox-label">
              <input type="checkbox" v-model="form.trakheostomi" class="me-2" />
              Trakheostomi
            </label>
          </div>
          <div class="col-md-3">
            <label class="checkbox-label">
              <input type="checkbox" v-model="form.bronkoskopi_fiberoptik" class="me-2" />
              Bronkoskopi Fiberoptik
            </label>
          </div>
          <div class="col-md-3">
            <label class="checkbox-label">
              <input type="checkbox" v-model="form.glidescope_jalan_nafas" class="me-2" />
              Glidescope
            </label>
          </div>
          <div class="col-md-3">
            <label class="checkbox-label">
              <input type="checkbox" v-model="form.jalan_nafas_lainnya_check" class="me-2" />
              Lain-lain
            </label>
            <input v-if="form.jalan_nafas_lainnya_check" v-model="form.jalan_nafas_lainnya" class="input-rme mt-2" placeholder="Detail..." />
          </div>
        </div>
      </div>

      <!-- INTUBASI -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Intubasi</h5>
        <div class="row mb-2">
          <div class="col-md-3">
            <label class="checkbox-label">
              <input type="checkbox" v-model="form.intubasi_sesudah_tidur" class="me-2" />
              Sesudah Tidur
            </label>
          </div>
          <div class="col-md-3">
            <label class="checkbox-label">
              <input type="checkbox" v-model="form.intubasi_blind" class="me-2" />
              Blind
            </label>
          </div>
          <div class="col-md-3">
            <label class="me-3">Oral/Nasal:</label>
            <label class="me-2">
              <input type="radio" v-model="form.intubasi_oral_nasal" value="oral" class="me-1" />
              Oral
            </label>
            <label>
              <input type="radio" v-model="form.intubasi_oral_nasal" value="nasal" class="me-1" />
              Nasal
            </label>
          </div>
          <div class="col-md-3">
            <label class="me-3">Nasal:</label>
            <label class="me-2">
              <input type="radio" v-model="form.intubasi_nasal_ka_ki" value="ka" class="me-1" />
              Ka
            </label>
            <label>
              <input type="radio" v-model="form.intubasi_nasal_ka_ki" value="ki" class="me-1" />
              Ki
            </label>
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-md-3">
            <label class="checkbox-label">
              <input type="checkbox" v-model="form.intubasi_trakheostomi" class="me-2" />
              Trakheostomi
            </label>
          </div>
          <div class="col-md-3">
            <label>Sulit Ventilasi</label>
            <input v-model="form.sulit_ventilasi" class="input-rme" />
          </div>
          <div class="col-md-3">
            <label>Sulit Intubasi</label>
            <input v-model="form.sulit_intubasi" class="input-rme" />
          </div>
          <div class="col-md-3">
            <label class="checkbox-label">
              <input type="checkbox" v-model="form.dengan_stilet" class="me-2" />
              Dengan Stilet
            </label>
          </div>
        </div>
        <div class="row">
          <div class="col-md-3">
            <label>Cuff</label>
            <input v-model="form.cuff" class="input-rme" />
          </div>
          <div class="col-md-3">
            <label>Level ETT</label>
            <input v-model="form.level_ett" class="input-rme" />
          </div>
          <div class="col-md-3">
            <label>Pack</label>
            <input v-model="form.pack" class="input-rme" />
          </div>
        </div>
      </div>

      <!-- VENTILASI -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Ventilasi</h5>
        <div class="row mb-3">
          <div class="col-md-4">
            <label class="checkbox-label">
              <input type="checkbox" v-model="form.ventilasi_spontan" class="me-2" />
              Spontan
            </label>
          </div>
          <div class="col-md-4">
            <label class="checkbox-label">
              <input type="checkbox" v-model="form.ventilasi_kendali" class="me-2" />
              Kendali
            </label>
          </div>
        </div>
        <label>Ventilator</label>
        <div class="row mb-3">
          <div class="col-md-4">
            <label>TV</label>
            <input v-model="form.ventilator_tv" class="input-rme" />
          </div>
          <div class="col-md-4">
            <label>RR</label>
            <input v-model="form.ventilator_rr" class="input-rme" />
          </div>
          <div class="col-md-4">
            <label>PEEP</label>
            <input v-model="form.ventilator_peep" class="input-rme" />
          </div>
        </div>
        <label>Lain-lain</label>
        <input v-model="form.ventilasi_lainnya" class="input-rme" />
      </div>

      <!-- TEKNIK REGIONAL / BLOK PERIFER -->
      <div class="box-rme">
        <h5 class="section-title-rme">Teknik Regional / Blok Perifer</h5>
        <div class="row mb-3">
          <div class="col-md-6">
            <label>Jenis</label>
            <input v-model="form.regional_jenis" class="input-rme" />
          </div>
          <div class="col-md-6">
            <label>Lokasi</label>
            <input v-model="form.regional_lokasi" class="input-rme" />
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-md-6">
            <label>Jenis Jarum / No</label>
            <input v-model="form.regional_jarum" class="input-rme" />
          </div>
          <div class="col-md-6">
            <label class="me-3">Kateter:</label>
            <label class="me-3">
              <input type="radio" v-model="form.regional_kateter" value="ya" class="me-1" />
              Ya
            </label>
            <label>
              <input type="radio" v-model="form.regional_kateter" value="tidak" class="me-1" />
              Tidak
            </label>
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-md-6">
            <label>Fiksasi (cm)</label>
            <input v-model="form.regional_fiksasi_cm" class="input-rme" />
          </div>
          <div class="col-md-6">
            <label>Obat-obat</label>
            <input v-model="form.regional_obat" class="input-rme" />
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-md-12">
            <label>Komplikasi</label>
            <textarea v-model="form.regional_komplikasi" class="textarea-rme"></textarea>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <label class="me-3">Hasil:</label>
            <label class="me-3">
              <input type="radio" v-model="form.regional_hasil" value="total_blok" class="me-1" />
              Total Blok
            </label>
            <label class="me-3">
              <input type="radio" v-model="form.regional_hasil" value="partial" class="me-1" />
              Partial
            </label>
            <label>
              <input type="radio" v-model="form.regional_hasil" value="gagal" class="me-1" />
              Gagal
            </label>
          </div>
        </div>
      </div>
    </div>

    <!-- HALAMAN 3 - MONITORING FISIOLOGIS -->
    <div v-show="currentTab === 3">
      <!-- OBAT-OBATAN / INFUS -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Obat-obatan / Infus</h5>
        <table class="therapy-table">
          <thead>
            <tr>
              <th style="width: 30%">Nama Obat/Infus</th>
              <th style="width: 15%">Dosis</th>
              <th style="width: 15%">Waktu</th>
              <th style="width: 30%">Keterangan</th>
              <th style="width: 10%">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(obat, idx) in form.obat_infus" :key="idx">
              <td><input v-model="obat.nama" class="input-table" /></td>
              <td><input v-model="obat.dosis" class="input-table" /></td>
              <td><input type="time" v-model="obat.waktu" class="input-table" /></td>
              <td><input v-model="obat.keterangan" class="input-table" /></td>
              <td class="text-center">
                <button @click="removeObatInfus(idx)" class="btn-remove">Hapus</button>
              </td>
            </tr>
          </tbody>
        </table>
        <button @click="addObatInfus" class="btn-add mt-2">+ Tambah Obat/Infus</button>
      </div>

      <!-- MONITORING FISIOLOGIS TABLE -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Monitoring Fisiologis Pasien Selama Anestesi</h5>
        <p class="text-muted mb-3">
          <small>
            Mulai anestesia X, Selesai anestesia ←X, Mulai pembedahan O→, Selesai pembedahan ←O, Intubasi ↑, Ekstubasi ↓
          </small>
        </p>
        
        <div class="monitoring-grid-container">
          <table class="monitoring-table">
            <thead>
              <tr>
                <th style="width: 15%">Waktu</th>
                <th style="width: 10%">N (Nadi)</th>
                <th style="width: 10%">Sis (Sistolik)</th>
                <th style="width: 10%">Dis (Diastolik)</th>
                <th style="width: 10%">TVS</th>
                <th style="width: 10%">R (RR)</th>
                <th style="width: 35%">Catatan/Event</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(monitor, idx) in form.monitoring_fisiologis" :key="idx">
                <td><input type="time" v-model="monitor.waktu" class="input-table" /></td>
                <td><input v-model="monitor.nadi" class="input-table" placeholder="x/mnt" /></td>
                <td><input v-model="monitor.sistolik" class="input-table" placeholder="mmHg" /></td>
                <td><input v-model="monitor.diastolik" class="input-table" placeholder="mmHg" /></td>
                <td><input v-model="monitor.tvs" class="input-table" /></td>
                <td><input v-model="monitor.rr" class="input-table" placeholder="x/mnt" /></td>
                <td><input v-model="monitor.catatan" class="input-table" placeholder="X, O, ↑, ↓..." /></td>
              </tr>
            </tbody>
          </table>
          <button @click="addMonitoringRow" class="btn-add mt-2">+ Tambah Baris Monitoring</button>
        </div>
      </div>

      <!-- PEMANTAUAN -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Pemantauan</h5>
        <div class="row mb-3">
          <div class="col-md-6">
            <label>Cairan Infus (N2O / O2 / Air)</label>
            <input v-model="form.pemantauan_cairan_infus" class="input-rme" placeholder="ml" />
          </div>
          <div class="col-md-6">
            <label>Gas (Isof/Sevo/Des %)</label>
            <input v-model="form.pemantauan_gas" class="input-rme" placeholder="%" />
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-md-3">
            <label>SpO2 (%)</label>
            <input v-model="form.pemantauan_spo2" class="input-rme" placeholder="%" />
          </div>
          <div class="col-md-3">
            <label>PE CO2 (mm Hg)</label>
            <input v-model="form.pemantauan_peco2" class="input-rme" placeholder="mm Hg" />
          </div>
          <div class="col-md-3">
            <label>FiO2</label>
            <input v-model="form.pemantauan_fio2" class="input-rme" />
          </div>
          <div class="col-md-3">
            <label>Urin (ml)</label>
            <input v-model="form.pemantauan_urin" class="input-rme" placeholder="ml" />
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-md-6">
            <label>Perdarahan (ml)</label>
            <input v-model="form.pemantauan_perdarahan" class="input-rme" placeholder="ml" />
          </div>
          <div class="col-md-6">
            <label>Lain-lain</label>
            <input v-model="form.pemantauan_lainnya" class="input-rme" />
          </div>
        </div>
      </div>

      <!-- DURASI -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Durasi</h5>
        <div class="row">
          <div class="col-md-6">
            <label>Lama Pembiusan</label>
            <div class="row">
              <div class="col-6">
                <input v-model="form.lama_pembiusan_jam" class="input-rme" placeholder="jam" />
              </div>
              <div class="col-6">
                <input v-model="form.lama_pembiusan_menit" class="input-rme" placeholder="menit" />
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <label>Lama Pembedahan</label>
            <div class="row">
              <div class="col-6">
                <input v-model="form.lama_pembedahan_jam" class="input-rme" placeholder="jam" />
              </div>
              <div class="col-6">
                <input v-model="form.lama_pembedahan_menit" class="input-rme" placeholder="menit" />
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- CATATAN HALAMAN 3 -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Catatan</h5>
        <textarea v-model="form.catatan_halaman3" class="textarea-rme" rows="5"></textarea>
      </div>

    </div>
    
      <!-- TANDA TANGAN -->
      <div class="box-rme">
        <h5 class="section-title-rme">Yang Membuat</h5>

        <div class="row mb-4">
          <div class="col-md-6">
            <label>dr. Anestesi</label>
            <VueSignaturePad
              ref="ttd_dr_anestesi"
              :options="sigOption"
              class="signature2-box-rme"
            />
            <button class="btn-save" @click="saveSign('ttd_dr_anestesi')">Simpan ✔</button>
            <button class="btn-clear" @click="clearSign('ttd_dr_anestesi')">Clear ✖</button>
            <div class="dropdown-dokter mt-2">
              <select v-model="form.nama_dr_anestesi" class="form-select-dokter">
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

          <div class="col-md-6">
            <label>Perawat Anestesi</label>
            <VueSignaturePad
              ref="ttd_perawat_anestesi"
              :options="sigOption"
              class="signature2-box-rme"
            />
            <button class="btn-save" @click="saveSign('ttd_perawat_anestesi')">Simpan ✔</button>
            <button class="btn-clear" @click="clearSign('ttd_perawat_anestesi')">Clear ✖</button>
            <input v-model="form.nama_perawat_anestesi" class="input-rme mt-2" placeholder="Nama Jelas Perawat Anestesi" />
          </div>
        </div>
      </div>
  </div>

  <!-- FOOTER ACTIONS -->
  <div class="action-footer">
    <button 
      v-if="currentTab > 1" 
      class="btn-back" 
      @click="currentTab--"
    >
      ← Halaman Sebelumnya
    </button>
    <button 
      v-if="currentTab < 3" 
      class="btn-save-form" 
      @click="currentTab++"
    >
      Halaman Selanjutnya →
    </button>
    <button 
      v-if="currentTab === 3"
      class="btn-save-form" 
      @click="submitForm" 
      :disabled="loading"
    >
      {{ loading ? "Menyimpan..." : "Simpan Data" }}
    </button>
    <button class="btn-back" @click="$emit('back')" :disabled="loading">Kembali</button>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "FormStatusAnestesi",
  props: {
    selectedPatient: { 
      type: Object, 
      required: true 
    },
    editUuid: {
      type: String,
      default: null,
    },
  },
  data() {
    return {
      currentTab: 1,
      loading: false,
      sigOption: { penColor: "black", backgroundColor: "white" },
      form: {
        uuid: "",
        uuid_pasien: "",
        
        // Identitas
        tanggal: "",
        no_rm: "",
        no_surat: "",
        nama: "",
        tanggal_lahir: "",
        jenis_kelamin: "",
        nik: "",
        dpjp_anestesi: "",
        asisten_anestesi: "",
        dpjp_bedah: "",
        
        // Diagnosis
        diagnosis_pra_bedah: "",
        jenis_pembedahan: "",
        diagnosis_pasca_bedah: "",
        
        // Teknik Anestesi
        teknik_sedasi: false,
        teknik_sedasi_detail: "",
        teknik_anestesi_umum: false,
        teknik_anestesi_umum_detail: "",
        teknik_lain: false,
        teknik_lain_detail: "",
        teknik_spinal: false,
        teknik_epidural: false,
        teknik_kaudal: false,
        blok_perifer: "",
        
        // Alat Khusus
        alat_hipotensi: false,
        alat_tci: false,
        alat_cpb: false,
        alat_ventilasi_satu_paru: false,
        alat_bronkoskopi: false,
        alat_glidescope: false,
        alat_usg: false,
        alat_stimulator_saraf: false,
        alat_lainnya_check: false,
        alat_lainnya: "",
        
        // Monitoring
        monitoring_ekg: false,
        monitoring_ekg_lead: "",
        monitoring_arteri_line: false,
        monitoring_arteri_line_detail: "",
        monitoring_etco2: false,
        monitoring_stetoskop: false,
        monitoring_nibp: false,
        monitoring_ngt: false,
        monitoring_bis: false,
        monitoring_cvp: false,
        monitoring_cvp_detail: "",
        monitoring_cath_a_pulmo: false,
        monitoring_spo2: false,
        monitoring_kateter_urine: false,
        monitoring_temp: false,
        monitoring_lainnya_check: false,
        monitoring_lainnya: "",
        
        // Status Fisik
        asa: "",
        alergi: "tidak",
        alergi_detail: "",
        
        // Penyulit & Cek List
        penyulit_pra_anestesi: "",
        cek_informed_consent: false,
        cek_obat_anestesi: false,
        cek_tatalaksana_jalan_nafas: false,
        cek_mesin_anestesi: false,
        cek_monitoring: false,
        cek_obat_emergensi: false,
        cek_suction_apparatus: false,
        
        // Penilaian Pra Induksi
        pra_induksi_jam: "",
        pra_induksi_kesadaran: "",
        pra_induksi_td: "",
        pra_induksi_nadi: "",
        pra_induksi_rr: "",
        pra_induksi_suhu: "",
        pra_induksi_spo2: "",
        pra_induksi_lainnya: "",
        
        catatan_halaman1: "",
        
        // HALAMAN 2
        infus_perifer_1: "",
        infus_perifer_2: "",
        cvc: "",
        
        // Posisi
        posisi_terlentang: false,
        posisi_lithotomi: false,
        posisi_prone: false,
        posisi_perlindungan_mata: false,
        posisi_lateral: "",
        posisi_lainnya_check: false,
        posisi_lainnya: "",
        
        // Premedikasi
        premedikasi_oral: "",
        premedikasi_im: "",
        premedikasi_iv: "",
        
        // Induksi
        induksi_intravena: "",
        induksi_inhalasi: "",
        
        // Tata Laksana Jalan Nafas
        face_mask_no: "",
        oro_nasopharing_no: "",
        ett_no: "",
        ett_jenis: "",
        ett_fiksasi_cm: "",
        lma_no: "",
        lma_jenis: "",
        trakheostomi: false,
        bronkoskopi_fiberoptik: false,
        glidescope_jalan_nafas: false,
        jalan_nafas_lainnya_check: false,
        jalan_nafas_lainnya: "",
        
        // Intubasi
        intubasi_sesudah_tidur: false,
        intubasi_blind: false,
        intubasi_oral_nasal: "",
        intubasi_nasal_ka_ki: "",
        intubasi_trakheostomi: false,
        sulit_ventilasi: "",
        sulit_intubasi: "",
        dengan_stilet: false,
        cuff: "",
        level_ett: "",
        pack: "",
        
        // Ventilasi
        ventilasi_spontan: false,
        ventilasi_kendali: false,
        ventilator_tv: "",
        ventilator_rr: "",
        ventilator_peep: "",
        ventilasi_lainnya: "",
        
        // Regional
        regional_jenis: "",
        regional_lokasi: "",
        regional_jarum: "",
        regional_kateter: "",
        regional_fiksasi_cm: "",
        regional_obat: "",
        regional_komplikasi: "",
        regional_hasil: "",
        
        // HALAMAN 3
        obat_infus: [
          { nama: "", dosis: "", waktu: "", keterangan: "" }
        ],
        monitoring_fisiologis: [
          { waktu: "", nadi: "", sistolik: "", diastolik: "", tvs: "", rr: "", catatan: "" }
        ],
        
        // Pemantauan
        pemantauan_cairan_infus: "",
        pemantauan_gas: "",
        pemantauan_spo2: "",
        pemantauan_peco2: "",
        pemantauan_fio2: "",
        pemantauan_urin: "",
        pemantauan_perdarahan: "",
        pemantauan_lainnya: "",
        
        // Durasi
        lama_pembiusan_jam: "",
        lama_pembiusan_menit: "",
        lama_pembedahan_jam: "",
        lama_pembedahan_menit: "",
        
        catatan_halaman3: "",
        
        // Signature
        ttd_dr_anestesi: "",
        nama_dr_anestesi: "",
        ttd_perawat_anestesi: "",
        nama_perawat_anestesi: "",
      },
    };
  },
  computed: {
    isEditMode() {
      return !!this.editUuid;
    }
  },
  async mounted() {
    await this.fetchDokter();
    await this.fetchTahunAkreditasi();
    if (this.isEditMode) {
      this.loadDataForEdit();
    } else {
      this.setDataPasien();
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
    async fetchTahunAkreditasi() {
      try {
        const response = await axios.get('/api/tahun-akreditasi');
        const tahun = response.data.tahun || '22';

        if (!this.form.no_surat) {
          this.form.no_surat = `RM 5.2/LA/${tahun}`;
        }

        console.log("✅ Tahun akreditasi:", tahun);
        console.log("✅ No surat:", this.form.no_surat);
      } catch (error) {
        console.error("❌ Error fetch tahun:", error);
        if (!this.form.no_surat) {
          this.form.no_surat = 'RM 5.2/LA/22';
        }
      }
    },
    setDataPasien() {
      const p = this.selectedPatient;
      this.form.uuid_pasien = p?.uuid;
      this.form.nama = p?.nama;
      this.form.tanggal_lahir = p?.tanggal_lahir;
      this.form.no_rm = p?.rekam_medis;
      this.form.nik = p?.no_ktp;
      this.form.jenis_kelamin = p?.jenis_kelamin;
    },

    async loadDataForEdit() {
      try {
        const response = await axios.get(
          `/master/rekammedis/lampiran/${this.editUuid}?type=status_anestesi`
        );

        if (response.data.status) {
          const data = response.data.data;
          
          Object.keys(this.form).forEach(key => {
            if (key === 'obat_infus' && data.obat_infus) {
              this.form.obat_infus = typeof data.obat_infus === 'string' 
                ? JSON.parse(data.obat_infus) 
                : data.obat_infus;
            } else if (key === 'monitoring_fisiologis' && data.monitoring_fisiologis) {
              this.form.monitoring_fisiologis = typeof data.monitoring_fisiologis === 'string' 
                ? JSON.parse(data.monitoring_fisiologis) 
                : data.monitoring_fisiologis;
            } else if (data[key] !== undefined && key !== 'obat_infus' && key !== 'monitoring_fisiologis') {
              this.form[key] = data[key];
            }
          });

          this.$nextTick(() => {
            if (this.form.ttd_dr_anestesi && this.$refs.ttd_dr_anestesi) {
              this.$refs.ttd_dr_anestesi.fromDataURL(this.form.ttd_dr_anestesi);
            }
            if (this.form.ttd_perawat_anestesi && this.$refs.ttd_perawat_anestesi) {
              this.$refs.ttd_perawat_anestesi.fromDataURL(this.form.ttd_perawat_anestesi);
            }
          });
        }
      } catch (error) {
        console.error("Error loading data:", error);
        alert("Gagal memuat data untuk edit!");
        this.$emit('back');
      }
    },

    addObatInfus() {
      this.form.obat_infus.push({
        nama: "",
        dosis: "",
        waktu: "",
        keterangan: ""
      });
    },

    removeObatInfus(idx) {
      if (this.form.obat_infus.length > 1) {
        this.form.obat_infus.splice(idx, 1);
      }
    },

    addMonitoringRow() {
      this.form.monitoring_fisiologis.push({
        waktu: "",
        nadi: "",
        sistolik: "",
        diastolik: "",
        tvs: "",
        rr: "",
        catatan: ""
      });
    },

    saveSign(ref) {
      const pad = this.$refs[ref];
      if (!pad) {
        console.error("REF tidak ditemukan:", ref);
        return;
      }
      const { data } = pad.saveSignature();
      this.form[ref] = data;
      alert("Tanda Tangan Berhasil Disimpan");
      console.log("TTD saved:", ref);
    },

    clearSign(ref) {
      const pad = this.$refs[ref];
      if (!pad) return;
      pad.clearSignature();
      this.form[ref] = "";
    },

    async submitForm() {
      this.loading = true;
      try {
        const fd = new FormData();
        
        Object.keys(this.form).forEach((k) => {
          if (k === 'uuid' && !this.form[k]) {
            return;
          }
          
          if (k === "obat_infus" || k === "monitoring_fisiologis") {
            fd.append(k, JSON.stringify(this.form[k]));
          } else {
            fd.append(k, this.form[k] || '');
          }
        });

        const response = await axios.post(
          "/master/pasien/dokumen-status-anestesi", 
          fd,
          { headers: { "Content-Type": "multipart/form-data" } }
        );

        if (response.data.status) {
          alert(response.data.message || "Data berhasil disimpan");
          this.$emit("back");
        }
      } catch (e) {
        console.error("Error:", e.response?.data || e);
        alert("Gagal menyimpan data");
      } finally {
        this.loading = false;
      }
    },
  },
};
</script>

<style scoped>
/* TABS NAVIGATION */
.tabs-navigation {
  display: flex;
  gap: 10px;
  margin-bottom: 20px;
  border-bottom: 2px solid #ddd;
}
.tab-button {
  padding: 10px 20px;
  border: none;
  background: #f0f0f0;
  cursor: pointer;
  border-radius: 6px 6px 0 0;
  font-weight: 500;
  transition: all 0.3s;
}
.tab-button:hover {
  background: #e0e0e0;
}
.tab-active {
  background: #2d74b7;
  color: white;
}

/* BOXES */
.box-rme {
  border: 1px solid #ddd;
  padding: 20px;
  border-radius: 6px;
  margin-bottom: 20px;
  background: #fafafa;
}
.section-title-rme {
  font-weight: bold;
  color: #2d74b7;
  margin-bottom: 15px;
}

/* INPUTS */
.input-rme,
.textarea-rme {
  width: 100%;
  border: 1px solid #ccc;
  padding: 8px;
  border-radius: 4px;
  margin-bottom: 10px;
  background: white;
}
.textarea-rme {
  min-height: 90px;
  resize: vertical;
}

/* CHECKBOX LABEL */
.checkbox-label {
  display: flex;
  align-items: center;
  margin-bottom: 8px;
  font-weight: 500;
}

/* SIGNATURE */
.signature-box-rme {
  width: 100%;
  height: 160px;
  border: 1px solid #999;
  margin-bottom: 10px;
  background: white;
}

/* BUTTONS */
.btn-save {
  background: #1e88e5;
  color: #fff;
  padding: 6px 14px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}
.btn-clear {
  background: #e53935;
  color: #fff;
  padding: 6px 14px;
  border: none;
  border-radius: 4px;
  margin-left: 8px;
  cursor: pointer;
}
.btn-add {
  background: #4caf50;
  color: white;
  padding: 6px 14px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}
.btn-remove {
  background: #f44336;
  color: white;
  padding: 4px 10px;
  border: none;
  border-radius: 3px;
  cursor: pointer;
  font-size: 12px;
}

/* ACTION FOOTER */
.action-footer {
  display: flex;
  justify-content: flex-end;
  gap: 10px;
  margin-top: 40px;
  padding: 20px 0;
}
.btn-save-form {
  background: #0288d1;
  color: white;
  padding: 10px 20px;
  border: none;
  border-radius: 4px;
  font-weight: bold;
  cursor: pointer;
}
.btn-back {
  background: #ff9800;
  color: white;
  padding: 10px 20px;
  border: none;
  border-radius: 4px;
  font-weight: bold;
  cursor: pointer;
}
.btn-save-form:disabled,
.btn-back:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

.dropdown-dokter {
  position: relative;
  width: 100%;
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

/* THERAPY TABLE */
.therapy-table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 10px;
}
.therapy-table th,
.therapy-table td {
  border: 1px solid #ccc;
  padding: 8px;
}
.therapy-table th {
  background: #f0f0f0;
  font-weight: bold;
  text-align: left;
}
.input-table {
  width: 100%;
  border: 1px solid #ccc;
  padding: 4px;
  border-radius: 3px;
}

/* MONITORING TABLE */
.monitoring-grid-container {
  overflow-x: auto;
}
.monitoring-table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 10px;
  min-width: 800px;
}
.monitoring-table th,
.monitoring-table td {
  border: 1px solid #999;
  padding: 6px;
}
.monitoring-table th {
  background: #e3f2fd;
  font-weight: bold;
  text-align: center;
  font-size: 13px;
}
/* SIGNATURE */
.signature2-box-rme {
  width: 500px !important;
  height: 110px !important;
  border: 2px solid #999;
  border-radius: 4px;
  display: block;
  margin: 0 auto;
}
</style>