<template>
  <div>
    <button @click="$emit('back')" class="btn-back">Kembali</button>

    <div class="container py-4">
      <div v-if="disabledSubmit" class="view-overlay"></div>
      <!-- HEADER -->
      <div class="text-center mb-4">
        <h2 class="fw-bold">LAPORAN OPERASI VITREO RETINA</h2>
        <p class="text-muted">{{ form.no_surat}}</p>
      </div>

      <!-- IDENTITAS PASIEN -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Identitas Pasien</h5>
        <div class="row mb-3">
          <div class="col-md-6">
            <label>Nama</label>
            <input v-model="form.nama" class="input-rme" readonly />
          </div>
          <div class="col-md-6">
            <label>Tanggal Lahir</label>
            <input type="date" v-model="form.tanggal_lahir" class="input-rme" readonly />
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <label>No. RM</label>
            <input v-model="form.no_rm" class="input-rme" readonly />
          </div>
          <div class="col-md-6">
            <label>NIK</label>
            <input v-model="form.nik" class="input-rme" readonly />
          </div>
        </div>
      </div>

      <!-- INFORMASI OPERASI -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Informasi Operasi</h5>
        <div class="row mb-3">
          <div class="col-md-4">
            <label>Tanggal Operasi</label>
            <input type="date" v-model="form.tanggal_operasi" class="input-rme" />
          </div>
          <div class="col-md-4">
            <label>Jam Mulai Operasi</label>
            <input type="time" v-model="form.jam_mulai_operasi" class="input-rme" />
          </div>
          <div class="col-md-4">
            <label>Jam Selesai Operasi</label>
            <input type="time" v-model="form.jam_selesai_operasi" class="input-rme" />
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-12">
            <label class="fw-bold mb-2">Area Operasi:</label>
            <div class="checkbox-group-inline">
              <label class="checkbox-label">
                <input type="checkbox" v-model="form.area_operasi_od" />
                OD
              </label>
              <label class="checkbox-label">
                <input type="checkbox" v-model="form.area_operasi_os" />
                OS
              </label>
            </div>
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-4">
            <label>DPJP Bedah</label>
            <input v-model="form.dpjp_bedah" class="input-rme" />
          </div>
          <div class="col-md-4">
            <label>Asisten</label>
            <input v-model="form.asisten" class="input-rme" />
          </div>
          <div class="col-md-4">
            <label>Perawat Instrumen</label>
            <input v-model="form.perawat_instrumen" class="input-rme" />
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-6">
            <label>Diagnosis Pre Operasi</label>
            <textarea v-model="form.diagnosis_pre_operasi" class="textarea-rme" rows="3"></textarea>
          </div>
          <div class="col-md-6">
            <label>Diagnosis Post Operasi</label>
            <textarea v-model="form.diagnosis_post_operasi" class="textarea-rme" rows="3"></textarea>
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-6">
            <label>Jenis Tindakan Pembedahan</label>
            <textarea v-model="form.jenis_tindakan_pembedahan" class="textarea-rme" rows="3"></textarea>
          </div>
          <div class="col-md-6">
            <label class="fw-bold mb-2">Jenis Anestesi:</label>
            <div class="checkbox-group">
              <label class="checkbox-label">
                <input type="checkbox" v-model="form.anestesi_lokal" />
                Lokal
              </label>
              <label class="checkbox-label">
                <input type="checkbox" v-model="form.anestesi_umum" />
                Anestesi Umum
              </label>
              <label class="checkbox-label">
                <input type="checkbox" v-model="form.anestesi_sedasi" />
                Sedasi
              </label>
              <label class="checkbox-label">
                <input type="checkbox" v-model="form.anestesi_blok" />
                Anestesi Blok
              </label>
            </div>
            <label class="mt-2">DPJP Anestesi</label>
            <input v-model="form.dpjp_anestesi" class="input-rme" />
          </div>
        </div>
      </div>

      <!-- PERITOMI, KENDALA OTOT, BAKEL SKLERA -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Peritomi, Kendala Otot & Bakel Sklera</h5>
        
        <div class="row mb-3">
          <div class="col-md-4">
            <label class="fw-bold mb-2">Peritomi:</label>
            <div class="checkbox-group">
              <label class="checkbox-label">
                <input type="checkbox" v-model="form.peritomi_360" />
                360°
              </label>
              <label class="checkbox-label">
                <input type="checkbox" v-model="form.peritomi_sebagian" />
                Sebagian
              </label>
            </div>
          </div>

          <div class="col-md-4">
            <label class="fw-bold mb-2">Kendala Otot:</label>
            <div class="checkbox-group">
              <label class="checkbox-label">
                <input type="checkbox" v-model="form.kendala_4_rektus" />
                4 rektus
              </label>
              <label class="checkbox-label">
                <input type="checkbox" v-model="form.kendala_rektus_superior" />
                Rektus superior saja
              </label>
              <label class="checkbox-label">
                <input type="checkbox" v-model="form.kendala_tak_dilakukan" />
                Tak dilakukan
              </label>
            </div>
          </div>

          <div class="col-md-4">
            <label class="fw-bold mb-2">Bakel Sklera:</label>
            <div class="checkbox-group">
              <label class="checkbox-label">
                <input type="checkbox" v-model="form.bakel_sirkuler_5mm" />
                Sirkuler 5 mm
              </label>
              <label class="checkbox-label">
                <input type="checkbox" v-model="form.bakel_sirkuler_4mm" />
                Sirkuler 4 mm
              </label>
              <label class="checkbox-label">
                <input type="checkbox" v-model="form.bakel_sirkuler_2_5mm" />
                Sirkuler 2,5 mm
              </label>
              <label class="checkbox-label">
                <input type="checkbox" v-model="form.bakel_sirkuler_2mm" />
                Sirkuler 2 mm
              </label>
              <label class="checkbox-label">
                <input type="checkbox" v-model="form.bakel_sponge" />
                Sponge
              </label>
              <label class="checkbox-label">
                <input type="checkbox" v-model="form.bakel_tyre" />
                Tyre, type
                <input v-model="form.bakel_tyre_type" class="input-rme mt-1" placeholder="Type..." />
              </label>
              <label class="checkbox-label">
                <input type="checkbox" v-model="form.bakel_tak_dilakukan" />
                Tak dilakukan
              </label>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6">
            <label class="fw-bold mb-2">Ikatan sleeve di:</label>
            <div class="checkbox-group-inline">
              <label class="checkbox-label">
                <input type="checkbox" v-model="form.ikatan_sleeve_ni" />
                NI
              </label>
              <label class="checkbox-label">
                <input type="checkbox" v-model="form.ikatan_sleeve_ns" />
                NS
              </label>
              <label class="checkbox-label">
                <input type="checkbox" v-model="form.ikatan_sleeve_ts" />
                TS
              </label>
              <label class="checkbox-label">
                <input type="checkbox" v-model="form.ikatan_sleeve_ti" />
                TI
              </label>
            </div>
          </div>

          <div class="col-md-6">
            <label class="fw-bold mb-2">Ikatan dengan benang di:</label>
            <div class="checkbox-group-inline">
              <label class="checkbox-label">
                <input type="checkbox" v-model="form.ikatan_benang_ni" />
                NI
              </label>
              <label class="checkbox-label">
                <input type="checkbox" v-model="form.ikatan_benang_ns" />
                NS
              </label>
              <label class="checkbox-label">
                <input type="checkbox" v-model="form.ikatan_benang_ts" />
                TS
              </label>
              <label class="checkbox-label">
                <input type="checkbox" v-model="form.ikatan_benang_ti" />
                TI
              </label>
            </div>
          </div>
        </div>
      </div>

      <!-- JAHITAN BAKEL -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Jahitan Bakel</h5>
        <div class="row">
          <div class="col-md-6">
            <div class="checkbox-group">
              <label class="checkbox-label">
                <input type="checkbox" v-model="form.jahitan_bakel_5_0" />
                5,0
              </label>
              <label class="checkbox-label">
                <input type="checkbox" v-model="form.jahitan_bakel_6_0" />
                6,0
              </label>
              <label class="checkbox-label">
                <input type="checkbox" v-model="form.jahitan_bakel_4_0" />
                4,0
              </label>
              <label class="checkbox-label">
                <input type="checkbox" v-model="form.jahitan_bakel_5_0_material" />
                5,0
              </label>
            </div>
          </div>

          <div class="col-md-6">
            <div class="checkbox-group">
              <label class="checkbox-label">
                <input type="checkbox" v-model="form.jahitan_bakel_nylon" />
                Nylon
              </label>
              <label class="checkbox-label">
                <input type="checkbox" v-model="form.jahitan_bakel_prolene" />
                Prolene
              </label>
              <label class="checkbox-label">
                <input type="checkbox" v-model="form.jahitan_bakel_vycril" />
                Vycril
                <input v-model="form.jahitan_bakel_vycril_detail" class="input-rme mt-1" />
              </label>
            </div>
          </div>
        </div>
      </div>

      <!-- JAHITAN SKLERETOMI & KANULA -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Jahitan Skleretomi & Kanula</h5>
        <div class="row mb-3">
          <div class="col-md-6">
            <label class="fw-bold mb-2">Jahitan Skleretomi:</label>
            <div class="checkbox-group">
              <label class="checkbox-label">
                <input type="checkbox" v-model="form.skleretomi_3_lubang" />
                3 lubang
              </label>
              <label class="checkbox-label">
                <input type="checkbox" v-model="form.skleretomi_4_lubang" />
                4 lubang/pindah
              </label>
            </div>
          </div>

          <div class="col-md-6">
            <label class="fw-bold mb-2">Kanula:</label>
            <div class="checkbox-group">
              <label class="checkbox-label">
                <input type="checkbox" v-model="form.kanula_3mm" />
                3 mm
              </label>
              <label class="checkbox-label">
                <input type="checkbox" v-model="form.kanula_4mm" />
                4 mm
              </label>
              <label class="checkbox-label">
                <input type="checkbox" v-model="form.kanula_tak_tembus" />
                Tak tembus, pindah
                <input v-model="form.kanula_3_5mm" class="input-rme mt-1" placeholder="3,5 mm" />
              </label>
              <label class="checkbox-label">
                <input type="checkbox" v-model="form.kanula_ujung_tak_terlihat" />
                Ujung kanula tak terlihat (blind)
              </label>
            </div>
          </div>
        </div>
      </div>

      <!-- TEKNIK OPERASI (PART 1) -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Teknik Operasi (Bagian 1)</h5>
        <div class="checkbox-group">
          <label class="checkbox-label">
            <input type="checkbox" v-model="form.teknik_pneumatic_retinopexy" />
            Pneumatic retinopexy
          </label>
          <label class="checkbox-label">
            <input type="checkbox" v-model="form.teknik_fge" />
            FGE
          </label>
          <label class="checkbox-label">
            <input type="checkbox" v-model="form.teknik_sice" />
            SICE
          </label>
          <label class="checkbox-label">
            <input type="checkbox" v-model="form.teknik_core_vitrectomy" />
            Core Vitrectomy
          </label>
          <label class="checkbox-label">
            <input type="checkbox" v-model="form.teknik_endblock" />
            Endblock/delaminasi
          </label>
          <label class="checkbox-label">
            <input type="checkbox" v-model="form.teknik_ekstirpasi_iol" />
            Ekstirpasi IOL
          </label>
          <label class="checkbox-label">
            <input type="checkbox" v-model="form.teknik_reposisi_iol" />
            Reposisi IOL
          </label>
          <label class="checkbox-label">
            <input type="checkbox" v-model="form.teknik_iridektomi_perifer" />
            Iridektomi perifer
          </label>
          <label class="checkbox-label">
            <input type="checkbox" v-model="form.teknik_drainase_cairan" />
            Drainase cairan subretina
          </label>
        </div>
      </div>

      <!-- TEKNIK OPERASI (PART 2) -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Teknik Operasi (Bagian 2)</h5>
        <div class="checkbox-group">
          <label class="checkbox-label">
            <input type="checkbox" v-model="form.teknik_pneumatic_dysplacement" />
            Pneumatic dysplacement
          </label>
          <label class="checkbox-label">
            <input type="checkbox" v-model="form.teknik_kriopeksi" />
            Kriopeksi 360º/PCR/cyclocryo
          </label>
          <label class="checkbox-label">
            <input type="checkbox" v-model="form.teknik_injeksi_intravitreal" />
            Injeksi Intravitreal, Lokasi:
            <input v-model="form.teknik_injeksi_lokasi" class="input-rme mt-1" />
          </label>
          <label class="checkbox-label">
            <input type="checkbox" v-model="form.teknik_pewarna_membran" />
            Pewarna membran/vitreus
          </label>
          <label class="checkbox-label">
            <input type="checkbox" v-model="form.teknik_bersihkan_vitreous" />
            Bersihkan vitreous base
          </label>
          <label class="checkbox-label">
            <input type="checkbox" v-model="form.teknik_ekstirpasi_benda_asing" />
            Ekstirpasi benda asing
          </label>
          <label class="checkbox-label">
            <input type="checkbox" v-model="form.teknik_ekstirpasi_lensa" />
            Ekstirpasi lensa
          </label>
          <label class="checkbox-label">
            <input type="checkbox" v-model="form.teknik_evakuasi_silicone" />
            Evakuasi silicone oil
          </label>
        </div>
      </div>

      <!-- TEKNIK OPERASI (PART 3) -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Teknik Operasi (Bagian 3)</h5>
        <div class="checkbox-group">
          <label class="checkbox-label">
            <input type="checkbox" v-model="form.teknik_tpa" />
            TPA
          </label>
          <label class="checkbox-label">
            <input type="checkbox" v-model="form.teknik_ilm_peeling" />
            ILM peeling
          </label>
          <label class="checkbox-label">
            <input type="checkbox" v-model="form.teknik_membrane_peeling" />
            Membrane Peeling
          </label>
          <label class="checkbox-label">
            <input type="checkbox" v-model="form.teknik_lensectomy" />
            Lensectomy
          </label>
          <label class="checkbox-label">
            <input type="checkbox" v-model="form.teknik_ac_fiksasi" />
            AC/Fiksasi skelera
          </label>
          <label class="checkbox-label">
            <input type="checkbox" v-model="form.teknik_tidak_dipasang_iol" />
            Tidak dipasang IOL
          </label>
          <label class="checkbox-label">
            <input type="checkbox" v-model="form.teknik_fako" />
            FAKO
          </label>
        </div>
      </div>

      <!-- DRAINASE & LASER -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Drainase Cairan Subretina & Laser</h5>
        
        <div class="row mb-3">
          <div class="col-md-6">
            <label class="fw-bold mb-2">Drainase cairan subretina:</label>
            <div class="checkbox-group">
              <label class="checkbox-label">
                <input type="checkbox" v-model="form.drainase_lubang_retina_baru" />
                Dari lubang retina baru
              </label>
              <label class="checkbox-label">
                <input type="checkbox" v-model="form.drainase_robekan_ada" />
                Dari robekan yang ada
              </label>
              <label class="checkbox-label">
                <input type="checkbox" v-model="form.drainase_external" />
                Drainase external
              </label>
            </div>
          </div>

          <div class="col-md-6">
            <label class="fw-bold mb-2">Laser:</label>
            <div class="checkbox-group">
              <label class="checkbox-label">
                <input type="checkbox" v-model="form.laser_dilakukan" />
                Dilakukan
              </label>
              <label class="checkbox-label">
                <input type="checkbox" v-model="form.laser_el" />
                EL
              </label>
              <label class="checkbox-label">
                <input type="checkbox" v-model="form.laser_lio" />
                LIO
              </label>
              <label class="checkbox-label">
                <input type="checkbox" v-model="form.laser_tidak_dilakukan" />
                Tidak dilakukan
              </label>
            </div>

            <div v-if="form.laser_dilakukan" class="mt-2">
              <label>Jumlah</label>
              <input v-model="form.laser_jumlah" class="input-rme mb-2" />
              <label>Power</label>
              <input v-model="form.laser_power" class="input-rme mb-2" />
              <label>Time Exposure</label>
              <input v-model="form.laser_time_exposure" class="input-rme" />
            </div>
          </div>
        </div>
      </div>

      <!-- TAMPONADE/INTRAVITREAL INJECTION -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Tamponade/Intravitreal Injection</h5>
        <div class="row">
          <div class="col-md-6">
            <div class="checkbox-group">
              <label class="checkbox-label">
                <input type="checkbox" v-model="form.tamponade_cairan" />
                Cairan
              </label>
              <label class="checkbox-label">
                <input type="checkbox" v-model="form.tamponade_c3f8" />
                C3F8
                <input v-model="form.tamponade_c3f8_persen" class="input-rme mt-1" placeholder="14% / ..." />
              </label>
              <label class="checkbox-label">
                <input type="checkbox" v-model="form.tamponade_f6h8" />
                F6H8
              </label>
              <label class="checkbox-label">
                <input type="checkbox" v-model="form.tamponade_silicon_oil" />
                Silicon oil
                <input v-model="form.tamponade_silicon_oil_type" class="input-rme mt-1" placeholder="1000/1300/5000" />
              </label>
              <label class="checkbox-label">
                <input type="checkbox" v-model="form.tamponade_corneal_debridemant" />
                Corneal debridemant
              </label>
              <label class="checkbox-label">
                <input type="checkbox" v-model="form.tamponade_retina_melekat_sempurna" />
                Retina melekat sempurna
              </label>
              <label class="checkbox-label">
                <input type="checkbox" v-model="form.tamponade_sisa_cairan" />
                Sisa cairan sub retina
              </label>
              <label class="checkbox-label">
                <input type="checkbox" v-model="form.tamponade_ya" />
                Ya
              </label>
            </div>
          </div>

          <div class="col-md-6">
            <div class="checkbox-group">
              <label class="checkbox-label">
                <input type="checkbox" v-model="form.tamponade_udara_steril" />
                Udara steril
              </label>
              <label class="checkbox-label">
                <input type="checkbox" v-model="form.tamponade_sf6" />
                SF6
                <input v-model="form.tamponade_sf6_persen" class="input-rme mt-1" placeholder="20% / ..." />
              </label>
              <label class="checkbox-label">
                <input type="checkbox" v-model="form.tamponade_perfluorocarbon" />
                Perfluorocarbon
              </label>
              <label class="checkbox-label">
                <input type="checkbox" v-model="form.tamponade_lensa_kontak" />
                Lensa Kontak
              </label>
              <label class="checkbox-label">
                <input type="checkbox" v-model="form.tamponade_retina_melekat_tidak_sempurna" />
                Retina melekat tidak sempurna
              </label>
              <label class="checkbox-label">
                <input type="checkbox" v-model="form.tamponade_retina_tak_melekat" />
                Retina tak melekat
              </label>
              <label class="checkbox-label">
                <input type="checkbox" v-model="form.tamponade_tidak" />
                Tidak
              </label>
            </div>

            <div class="mt-2">
              <label>Antibiotik</label>
              <input v-model="form.tamponade_antibiotik" class="input-rme mb-2" />
              <label>Anti VEGF</label>
              <input v-model="form.tamponade_anti_vegf" class="input-rme mb-2" />
              <label>Lain-lain</label>
              <input v-model="form.tamponade_lainnya" class="input-rme" />
            </div>
          </div>
        </div>
      </div>

      <!-- JENIS SPECIMEN -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Jenis Specimen Pemeriksaan</h5>
        <textarea v-model="form.jenis_specimen" class="textarea-rme" rows="3"></textarea>
      </div>

      <!-- KOMPLIKASI & PERDARAHAN -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Komplikasi & Perdarahan</h5>
        <div class="row mb-3">
          <div class="col-md-6">
            <label class="fw-bold mb-2">Komplikasi dan penanganannya:</label>
            <div class="checkbox-group-inline mb-2">
              <label class="checkbox-label">
                <input type="checkbox" v-model="form.komplikasi_ya" />
                Ya
              </label>
              <label class="checkbox-label">
                <input type="checkbox" v-model="form.komplikasi_tidak" />
                Tidak
              </label>
            </div>
            <label>Jika Ya:</label>
            <textarea v-model="form.komplikasi_detail" class="textarea-rme" rows="3"></textarea>
          </div>

          <div class="col-md-6">
            <label class="fw-bold mb-2">Perdarahan:</label>
            <div class="checkbox-group-inline mb-2">
              <label class="checkbox-label">
                <input type="checkbox" v-model="form.perdarahan_ya" />
                Ya
              </label>
              <label class="checkbox-label">
                <input type="checkbox" v-model="form.perdarahan_tidak" />
                Tidak
              </label>
            </div>
            <label>Jumlah Perdarahan (cc):</label>
            <input v-model="form.jumlah_perdarahan" class="input-rme mb-2" />

            <div class="checkbox-group-inline mb-2">
              <label class="checkbox-label">
                <input type="checkbox" v-model="form.transfusi_ya" />
                Ya
              </label>
              <label class="checkbox-label">
                <input type="checkbox" v-model="form.transfusi_tidak" />
                Tidak
              </label>
            </div>
            <label>Jumlah (cc):</label>
            <input v-model="form.jumlah_transfusi" class="input-rme" />
          </div>
        </div>
      </div>

      <!-- GAMBAR SKEMA OPERASI -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Gambar Skema Operasi</h5>
        <VueSignaturePad
          ref="gambar_skema"
          :options="sigOptionSkema"
          class="sketch-box-rme"
        />
        <button @click="clearSketch" class="btn-clear mt-2">Clear ✖</button>
      </div>

      <!-- TATALAKSANA PASCA BEDAH -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Tatalaksana Pasca Bedah</h5>
        
        <div class="row mb-3">
          <div class="col-md-12">
            <label class="fw-bold mb-2">Posisi Tidur:</label>
            <div class="checkbox-group-inline">
              <label class="checkbox-label">
                <input type="checkbox" v-model="form.tidur_telungkup_3hr" />
                Tidur telungkup 3 hr
              </label>
              <label class="checkbox-label">
                <input type="checkbox" v-model="form.tidur_telungkup_10hr" />
                10 hr
              </label>
              <label class="checkbox-label">
                <input type="checkbox" v-model="form.tidur_telungkup_1bl" />
                1 bl
              </label>
              <label class="checkbox-label">
                <input type="checkbox" v-model="form.tidur_biasa" />
                Tidur biasa
              </label>
              <label class="checkbox-label">
                <input type="checkbox" v-model="form.lepas_lensa_kontak" />
                Lepas lensa kontak stlh 2 hr
              </label>
            </div>
          </div>
        </div>

        <div class="row mb-2">
          <div class="col-md-6">
            <label>1. Kontrol nadi/tensi/pernafasan/suhu</label>
            <input v-model="form.tatalaksana_1" class="input-rme" />
          </div>
          <div class="col-md-6">
            <label>2. Puasa</label>
            <input v-model="form.tatalaksana_2" class="input-rme" />
          </div>
        </div>

        <div class="row mb-2">
          <div class="col-md-6">
            <label>3. Drain</label>
            <input v-model="form.tatalaksana_3" class="input-rme" />
          </div>
          <div class="col-md-6">
            <label>4. Infus</label>
            <input v-model="form.tatalaksana_4" class="input-rme" />
          </div>
        </div>

        <div class="row mb-2">
          <div class="col-md-6">
            <label>5. Obat-obatan</label>
            <textarea v-model="form.tatalaksana_5" class="textarea-rme" rows="3"></textarea>
          </div>
          <div class="col-md-6">
            <label>6. Ganti Balut</label>
            <input v-model="form.tatalaksana_6" class="input-rme" />
          </div>
        </div>

        <div class="row">
          <div class="col-md-6">
            <label>7. Lain-lain</label>
            <textarea v-model="form.tatalaksana_7" class="textarea-rme" rows="3"></textarea>
          </div>
        </div>
      </div>

      <!-- STIKER IMPLANT -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Stiker Implant</h5>
        <input 
          type="file" 
          @change="uploadStikerImplant" 
          accept="image/*"
          class="input-rme mb-2"
        />
        <div v-if="form.stiker_implant" class="mt-2">
          <img :src="form.stiker_implant" style="max-width: 300px; border: 1px solid #ccc;" />
        </div>
      </div>

      <!-- TANDA TANGAN DPJP BEDAH -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Tanda Tangan</h5>
        <div class="row">
          <div class="col-md-6 text-center">
            <label class="fw-bold mb-2">DPJP Bedah</label>
            <VueSignaturePad
              ref="ttd_dpjp_bedah"
              :options="sigOption"
              class="signature2-box-rme mx-auto"
            />
            <button @click="saveSign('ttd_dpjp_bedah')" class="btn-save mt-2">
              Simpan ✔
            </button>
            <input
              type="text"
              v-model="form.nama_dpjp_bedah_ttd"
              class="input-rme mt-2"
              placeholder="Nama Lengkap DPJP Bedah"
            />
          </div>

          <div class="col-md-6">
            <label class="fw-bold mb-2">Laporan operasi selesai ditulis:</label>
            <div class="row mb-2">
              <div class="col-md-6">
                <label>Tanggal</label>
                <input type="date" v-model="form.tanggal_selesai_laporan" class="input-rme" />
              </div>
              <div class="col-md-6">
                <label>Jam</label>
                <input type="time" v-model="form.jam_selesai_laporan" class="input-rme" />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- BUTTON BOTTOM -->
    <div class="action-footer">
      <button v-if="!disabledSubmit"  class="btn-save-form" @click="submitForm" :disabled="loadingSubmit">
        <span v-if="loadingSubmit">Menyimpan...</span>
        <span v-else>{{ editUuid ? 'Update' : 'Simpan' }}</span>
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
  name: "FormLaporanOperasiVitreoRetina",
  props: {
    selectedPatient: {
      type: Object,
      required: true,
    },
    editData: {
      type: String,
      default: null,
    },
    viewData: {
      type: String,
      default: null,
    },
  },
  data() {
    return {
      loadingSubmit: false,
      disabledSubmit: false,
      editUuid : "",
      sigOption: {
        penColor: "black",
        backgroundColor: "white",
      },
      sigOptionSkema: {
        penColor: "#2d74b7",
        backgroundColor: "white",
      },
      form: {
        uuid: "",
        uuid_pasien: "",
        no_rm: "",
        no_surat: "",
        nik: "",
        nama: "",
        tanggal_lahir: "",
        
        // Informasi Operasi
        tanggal_operasi: "",
        jam_mulai_operasi: "",
        jam_selesai_operasi: "",
        area_operasi_od: false,
        area_operasi_os: false,
        dpjp_bedah: "",
        asisten: "",
        perawat_instrumen: "",
        diagnosis_pre_operasi: "",
        diagnosis_post_operasi: "",
        jenis_tindakan_pembedahan: "",
        
        // Jenis Anestesi
        anestesi_lokal: false,
        anestesi_umum: false,
        anestesi_sedasi: false,
        anestesi_blok: false,
        dpjp_anestesi: "",
        
        // Peritomi
        peritomi_360: false,
        peritomi_sebagian: false,
        
        // Kendala Otot
        kendala_4_rektus: false,
        kendala_rektus_superior: false,
        kendala_tak_dilakukan: false,
        
        // Bakel Sklera
        bakel_sirkuler_5mm: false,
        bakel_sirkuler_4mm: false,
        bakel_sirkuler_2_5mm: false,
        bakel_sirkuler_2mm: false,
        bakel_sponge: false,
        bakel_tyre: false,
        bakel_tyre_type: "",
        bakel_tak_dilakukan: false,
        
        // Ikatan
        ikatan_sleeve_ni: false,
        ikatan_sleeve_ns: false,
        ikatan_sleeve_ts: false,
        ikatan_sleeve_ti: false,
        ikatan_benang_ni: false,
        ikatan_benang_ns: false,
        ikatan_benang_ts: false,
        ikatan_benang_ti: false,
        
        // Jahitan Bakel
        jahitan_bakel_5_0: false,
        jahitan_bakel_6_0: false,
        jahitan_bakel_4_0: false,
        jahitan_bakel_5_0_material: false,
        jahitan_bakel_nylon: false,
        jahitan_bakel_prolene: false,
        jahitan_bakel_vycril: false,
        jahitan_bakel_vycril_detail: "",
        
        // Skleretomi & Kanula
        skleretomi_3_lubang: false,
        skleretomi_4_lubang: false,
        kanula_3mm: false,
        kanula_4mm: false,
        kanula_tak_tembus: false,
        kanula_3_5mm: "",
        kanula_ujung_tak_terlihat: false,
        
        // Teknik Operasi
        teknik_pneumatic_retinopexy: false,
        teknik_fge: false,
        teknik_sice: false,
        teknik_core_vitrectomy: false,
        teknik_endblock: false,
        teknik_ekstirpasi_iol: false,
        teknik_reposisi_iol: false,
        teknik_iridektomi_perifer: false,
        teknik_drainase_cairan: false,
        teknik_pneumatic_dysplacement: false,
        teknik_kriopeksi: false,
        teknik_injeksi_intravitreal: false,
        teknik_injeksi_lokasi: "",
        teknik_pewarna_membran: false,
        teknik_bersihkan_vitreous: false,
        teknik_ekstirpasi_benda_asing: false,
        teknik_ekstirpasi_lensa: false,
        teknik_evakuasi_silicone: false,
        teknik_tpa: false,
        teknik_ilm_peeling: false,
        teknik_membrane_peeling: false,
        teknik_lensectomy: false,
        teknik_ac_fiksasi: false,
        teknik_tidak_dipasang_iol: false,
        teknik_fako: false,
        
        // Drainase & Laser
        drainase_lubang_retina_baru: false,
        drainase_robekan_ada: false,
        drainase_external: false,
        laser_dilakukan: false,
        laser_el: false,
        laser_lio: false,
        laser_tidak_dilakukan: false,
        laser_jumlah: "",
        laser_power: "",
        laser_time_exposure: "",
        
        // Tamponade
        tamponade_cairan: false,
        tamponade_c3f8: false,
        tamponade_c3f8_persen: "",
        tamponade_f6h8: false,
        tamponade_silicon_oil: false,
        tamponade_silicon_oil_type: "",
        tamponade_corneal_debridemant: false,
        tamponade_retina_melekat_sempurna: false,
        tamponade_sisa_cairan: false,
        tamponade_ya: false,
        tamponade_udara_steril: false,
        tamponade_sf6: false,
        tamponade_sf6_persen: "",
        tamponade_perfluorocarbon: false,
        tamponade_lensa_kontak: false,
        tamponade_retina_melekat_tidak_sempurna: false,
        tamponade_retina_tak_melekat: false,
        tamponade_tidak: false,
        tamponade_antibiotik: "",
        tamponade_anti_vegf: "",
        tamponade_lainnya: "",
        
        // Specimen
        jenis_specimen: "",
        
        // Komplikasi & Perdarahan
        komplikasi_ya: false,
        komplikasi_tidak: false,
        komplikasi_detail: "",
        perdarahan_ya: false,
        perdarahan_tidak: false,
        jumlah_perdarahan: "",
        transfusi_ya: false,
        transfusi_tidak: false,
        jumlah_transfusi: "",
        
        // Gambar Skema
        gambar_skema: "",
        
        // Tatalaksana
        tidur_telungkup_3hr: false,
        tidur_telungkup_10hr: false,
        tidur_telungkup_1bl: false,
        tidur_biasa: false,
        lepas_lensa_kontak: false,
        tatalaksana_1: "",
        tatalaksana_2: "",
        tatalaksana_3: "",
        tatalaksana_4: "",
        tatalaksana_5: "",
        tatalaksana_6: "",
        tatalaksana_7: "",
        
        // Stiker & TTD
        stiker_implant: "",
        ttd_dpjp_bedah: "",
        nama_dpjp_bedah_ttd: "",
        tanggal_selesai_laporan: "",
        jam_selesai_laporan: "",
      }
    };
  },
  computed: {
    isEditMode() {
      // return !!this.editUuid;
    }
  },
  async mounted() {
  await this.fetchTahunAkreditasi();
    if(this.viewData) {
      console.log(this.editUuid);
      this.editUuid = this.editData.uuid;
      this.disabledSubmit = true;
      this.loadDataForEdit();
    } else if (this.editData) {
      this.editUuid = this.editData.uuid;
      this.disabledSubmit = false;
      this.loadDataForEdit();
    } else {
      this.disabledSubmit = false;
      this.setDataForm();
    }
  },
  methods: {
    async fetchTahunAkreditasi() {
      try {
        const response = await axios.get('/api/tahun-akreditasi');
        const tahun = response.data.tahun || '22';

        if (!this.form.no_surat) {
          this.form.no_surat = `RM 10.1/LOVR/${tahun}`;
        }

        console.log("✅ Tahun akreditasi:", tahun);
        console.log("✅ No surat:", this.form.no_surat);
      } catch (error) {
        console.error("❌ Error fetch tahun:", error);
        if (!this.form.no_surat) {
          this.form.no_surat = 'RM 10.1/LOVR/22';
        }
      }
    },
    setDataForm() {
      if (this.selectedPatient) {
        this.form.uuid_pasien = this.selectedPatient.uuid;
        this.form.no_rm = this.selectedPatient.rekam_medis;
        this.form.nik = this.selectedPatient.no_ktp || "";
        this.form.nama = this.selectedPatient.nama;
        this.form.tanggal_lahir = this.selectedPatient.tanggal_lahir;
      }
      
      // Set default tanggal operasi hari ini
      const today = new Date().toISOString().split('T')[0];
      this.form.tanggal_operasi = today;
      this.form.tanggal_selesai_laporan = today;
    },

    async loadDataForEdit() {
      try {
        const response = await axios.get(
          `/master/rekammedis/lampiran/${this.editUuid}?type=laporan_operasi_vitreo_retina`
        );

        if (response.data.status) {
          const data = response.data.data;
          
          Object.keys(this.form).forEach(key => {
            if (data[key] !== undefined) {
              this.form[key] = data[key];
            }
          });

          // Load signatures & sketches
          this.$nextTick(() => {
            if (this.form.ttd_dpjp_bedah && this.$refs.ttd_dpjp_bedah) {
              this.$refs.ttd_dpjp_bedah.fromDataURL(this.form.ttd_dpjp_bedah);
            }
            if (this.form.gambar_skema && this.$refs.gambar_skema) {
              this.$refs.gambar_skema.fromDataURL(this.form.gambar_skema);
            }
          });
        }
      } catch (error) {
        console.error("Error loading data:", error);
        alert("Gagal memuat data untuk edit!");
        this.$emit('back');
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

    clearSketch() {
      const pad = this.$refs.gambar_skema;
      if (!pad) return;
      
      pad.clearSignature();
      this.form.gambar_skema = "";
    },

    uploadStikerImplant(event) {
      const file = event.target.files[0];
      if (!file) return;

      const reader = new FileReader();
      reader.onload = (e) => {
        this.form.stiker_implant = e.target.result;
      };
      reader.readAsDataURL(file);
    },

    async submitForm() {
      // Simpan sketch sebelum submit
      if (this.$refs.gambar_skema) {
        const { data } = this.$refs.gambar_skema.saveSignature();
        this.form.gambar_skema = data;
      }

      // Validasi minimal
      if (!this.form.tanggal_operasi) {
        alert("Tanggal operasi wajib diisi!");
        return;
      }

      if (!this.form.dpjp_bedah) {
        alert("DPJP Bedah wajib diisi!");
        return;
      }

      this.loadingSubmit = true;

      try {
        const fd = new FormData();

        Object.keys(this.form).forEach((key) => {
          if (key === 'uuid' && !this.form[key]) {
            return;
          }
          fd.append(key, this.form[key] || '');
        });

        const response = await axios.post(
          "/master/pasien/dokumen-laporan-operasi-vitreo-retina",
          fd,
          { headers: { "Content-Type": "multipart/form-data" } }
        );

        if (response.data.status) {
          alert(response.data.message);
          this.$emit("back");
        }
      } catch (error) {
        console.error("ERROR:", error.response?.data || error);
        alert("Gagal menyimpan laporan operasi!");
      } finally {
        this.loadingSubmit = false;
      }
    },
  },
};
</script>

<style scoped>
.container {
  max-width: 1400px;
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

/* CHECKBOX */
.checkbox-group {
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.checkbox-group-inline {
  display: flex;
  gap: 15px;
  flex-wrap: wrap;
}

.checkbox-label {
  display: flex;
  align-items: flex-start;
  gap: 8px;
  cursor: pointer;
  font-size: 14px;
}

.checkbox-label input[type="checkbox"] {
  width: 18px;
  height: 18px;
  cursor: pointer;
  margin-top: 2px;
  flex-shrink: 0;
}

/* SIGNATURE & SKETCH */
.signature2-box-rme {
  width: 500px !important;
  height: 110px !important;
  border: 2px solid #999;
  border-radius: 4px;
  display: block;
  margin: 0 auto;
}

.sketch-box-rme {
  width: 100%;
  height: 400px;
  border: 2px solid #999;
  border-radius: 4px;
  background: white;
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
  background: #e53935;
  color: white;
  padding: 6px 16px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-weight: 500;
}

/* ACTION FOOTER */
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
  z-index: 10;
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

/* RESPONSIVE GRID */
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
  flex: 0 0 33.333%;
  max-width: 33.333%;
}

.col-md-6 {
  flex: 0 0 50%;
  max-width: 50%;
}

.col-md-12 {
  flex: 0 0 100%;
  max-width: 100%;
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

.fw-bold {
  font-weight: bold;
}

.text-center {
  text-align: center;
}

.text-muted {
  color: #6c757d;
}

.mx-auto {
  margin-left: auto;
  margin-right: auto;
}

.py-4 {
  padding-top: 24px;
  padding-bottom: 24px;
}

@media (max-width: 768px) {
  .col-md-4,
  .col-md-6 {
    flex: 0 0 100%;
    max-width: 100%;
  }

  .sketch-box-rme {
    height: 300px;
  }
}
</style>