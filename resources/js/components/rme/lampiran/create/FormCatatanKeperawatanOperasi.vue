<template>
  <button @click="$emit('back')" class="btn-back">Kembali</button>

  <div class="container py-4">
    <div class="form-wrapper position-relative">
      <div v-if="disabledSubmit" class="view-overlay"></div>

      <div v-if="loadingData" class="loading-overlay">
        <div class="spinner-rme"></div>
        <p>Memuat data...</p>
      </div>

      <!-- HEADER -->
      <div class="text-center mb-4">
        <img src="/logo-rs.png" alt="Logo RS" class="logo-rs mb-3" style="max-width:150px" />
        <h2 class="fw-bold text-uppercase">RS KHUSUS MATA PRIMA VISION</h2>
        <hr class="my-3" style="border:2px solid #000" />
        <h3 class="fw-bold mt-3 mb-1">CATATAN KEPERAWATAN INTRA DAN PASCA OPERASI</h3>
        <h4 class="fw-semibold">{{ form.no_surat }}</h4>
        <span v-if="isEditMode && !disabledSubmit" class="badge bg-warning">Mode Edit</span>
      </div>

      <!-- IDENTITAS PASIEN -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Identitas Pasien</h5>
        <div class="row mb-2">
          <div class="col-md-6">
            <label>Nama :</label>
            <input type="text" v-model="form.nama" class="input-rme" readonly />
          </div>
          <div class="col-md-6">
            <label>No. Rekam Medis :</label>
            <input type="text" v-model="form.no_rm" class="input-rme" readonly />
          </div>
        </div>
        <div class="row mb-2">
          <div class="col-md-4">
            <label>Jenis Kelamin :</label>
            <input type="text" v-model="form.jenis_kelamin" class="input-rme" readonly />
          </div>
          <div class="col-md-4">
            <label>NIK :</label>
            <input type="text" v-model="form.nik" class="input-rme" readonly />
          </div>
          <div class="col-md-4">
            <label>Tanggal Lahir :</label>
            <input type="date" v-model="form.tanggal_lahir" class="form-control" />
          </div>
        </div>
      </div>

      <!-- WAKTU OPERASI -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Waktu Operasi</h5>
        <div class="row mb-2">
          <div class="col-md-3">
            <label>Jam Mulai :</label>
            <input type="time" v-model="form.jam_mulai" class="form-control" />
          </div>
          <div class="col-md-3">
            <label>Jam Selesai :</label>
            <input type="time" v-model="form.jam_selesai" class="form-control" />
          </div>
          <div class="col-md-3">
            <label>Anestesi Mulai :</label>
            <input type="time" v-model="form.jam_anestesi_mulai" class="form-control" />
          </div>
          <div class="col-md-3">
            <label>Anestesi Selesai :</label>
            <input type="time" v-model="form.jam_anestesi_selesai" class="form-control" />
          </div>
        </div>
        <div class="row mb-2">
          <div class="col-md-3">
            <label>Pembedahan Mulai :</label>
            <input type="time" v-model="form.jam_pembedahan_mulai" class="form-control" />
          </div>
          <div class="col-md-3">
            <label>Pembedahan Selesai :</label>
            <input type="time" v-model="form.jam_pembedahan_selesai" class="form-control" />
          </div>
        </div>
      </div>

      <!-- SECTION A: CATATAN INTRA OPERASI -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">A. Catatan Intra Operasi</h5>

        <!-- 1. Tipe Operasi -->
        <div class="item-row mb-3">
          <label class="fw-bold">1. Tipe Operasi :</label>
          <div class="checkbox-group">
            <label class="cb-item"><input type="checkbox" v-model="form.tipe_elektif" /> Elektif</label>
            <label class="cb-item"><input type="checkbox" v-model="form.tipe_darurat" /> Darurat</label>
            <label class="cb-item"><input type="checkbox" v-model="form.tipe_rawat_jalan" /> Rawat Jalan</label>
          </div>
        </div>

        <!-- 2. Jenis Pembiusan -->
        <div class="item-row mb-3">
          <label class="fw-bold">2. Jenis Pembiusan :</label>
          <div class="checkbox-group">
            <label class="cb-item"><input type="checkbox" v-model="form.biusan_umum" /> Umum</label>
            <label class="cb-item"><input type="checkbox" v-model="form.biusan_lokal" /> Lokal</label>
            <label class="cb-item"><input type="checkbox" v-model="form.biusan_regional" /> Regional</label>
          </div>
        </div>

        <!-- 3. Kesadaran -->
        <div class="item-row mb-3">
          <label class="fw-bold">3. Kesadaran :</label>
          <div class="checkbox-group">
            <label class="cb-item"><input type="checkbox" v-model="form.kesadaran_terjaga" /> Terjaga</label>
            <label class="cb-item"><input type="checkbox" v-model="form.kesadaran_mudah_dibangunkan" /> Mudah Dibangunkan</label>
            <div class="cb-item-text">
              <span>Lainnya:</span>
              <input type="text" v-model="form.kesadaran_lainnya" class="input-inline" placeholder="Sebutkan..." />
            </div>
          </div>
        </div>

        <!-- 4. Status Emosi -->
        <div class="item-row mb-3">
          <label class="fw-bold">4. Status Emosi :</label>
          <div class="checkbox-group">
            <label class="cb-item"><input type="checkbox" v-model="form.emosi_rileks" /> Rileks</label>
            <label class="cb-item"><input type="checkbox" v-model="form.emosi_gelisah" /> Gelisah</label>
            <label class="cb-item"><input type="checkbox" v-model="form.emosi_tidak_ada_respon" /> Tidak Ada Respon</label>
          </div>
        </div>

        <!-- 5. Posisi Canul Intravena -->
        <div class="item-row mb-3">
          <label class="fw-bold">5. Posisi Canul Intravena :</label>
          <div class="checkbox-group">
            <label class="cb-item"><input type="checkbox" v-model="form.canul_tangan" /> Tangan</label>
            <label class="cb-item"><input type="checkbox" v-model="form.canul_kaki" /> Kaki</label>
            <label class="cb-item"><input type="checkbox" v-model="form.canul_cvp" /> CVP</label>
            <div class="cb-item-text">
              <span>Lainnya:</span>
              <input type="text" v-model="form.canul_lainnya" class="input-inline" placeholder="Sebutkan..." />
            </div>
          </div>
        </div>

        <!-- 6. Jenis Operasi -->
        <div class="item-row mb-3">
          <label class="fw-bold">6. Jenis Operasi :</label>
          <div class="checkbox-group">
            <label class="cb-item"><input type="checkbox" v-model="form.jenis_op_bersih" /> Bersih</label>
            <label class="cb-item"><input type="checkbox" v-model="form.jenis_op_terkontaminasi" /> Terkontaminasi</label>
            <label class="cb-item"><input type="checkbox" v-model="form.jenis_op_bersih_terkontaminasi" /> Bersih Terkontaminasi</label>
            <label class="cb-item"><input type="checkbox" v-model="form.jenis_op_kotor_infeksi" /> Kotor / Infeksi</label>
          </div>
        </div>

        <!-- 7. Posisi Operasi -->
        <div class="item-row mb-3">
          <label class="fw-bold">7. Posisi Operasi :</label>
          <div class="checkbox-group flex-wrap">
            <label class="cb-item"><input type="checkbox" v-model="form.posisi_supine" /> Supine</label>
            <label class="cb-item"><input type="checkbox" v-model="form.posisi_prone" /> Prone</label>
            <label class="cb-item"><input type="checkbox" v-model="form.posisi_lithotomi" /> Lithotomi</label>
            <label class="cb-item"><input type="checkbox" v-model="form.posisi_kidney" /> Kidney</label>
            <label class="cb-item"><input type="checkbox" v-model="form.posisi_lateral" /> Lateral</label>
          </div>
          <div class="row mt-1">
            <div class="col-md-6">
              <label>Lainnya:</label>
              <input type="text" v-model="form.posisi_lainnya" class="form-control" />
            </div>
            <div class="col-md-6">
              <label>Diawasi Oleh:</label>
              <input type="text" v-model="form.posisi_diawasi_oleh" class="form-control" />
            </div>
          </div>
        </div>

        <!-- 8. Posisi Selengantangan -->
        <div class="item-row mb-3">
          <label class="fw-bold">8. Posisi Selengantangan :</label>
          <div class="checkbox-group">
            <label class="cb-item"><input type="checkbox" v-model="form.selengantangan_adduksi" /> Adduksi</label>
            <label class="cb-item"><input type="checkbox" v-model="form.selengantangan_abduksi" /> Abduksi</label>
            <div class="cb-item-text">
              <span>Lainnya:</span>
              <input type="text" v-model="form.selengantangan_lainnya" class="input-inline" />
            </div>
          </div>
        </div>

        <!-- 9. Urine Catheter -->
        <div class="item-row mb-3">
          <label class="fw-bold">9. Urine Catheter :</label>
          <div class="checkbox-group">
            <label class="cb-item"><input type="checkbox" v-model="form.urine_ya" /> Ya</label>
            <label class="cb-item"><input type="checkbox" v-model="form.urine_tidak" /> Tidak</label>
            <label class="cb-item"><input type="checkbox" v-model="form.urine_ok" /> OK</label>
            <label class="cb-item"><input type="checkbox" v-model="form.urine_ruangan" /> Ruangan</label>
          </div>
          <div class="row mt-1">
            <div class="col-md-6">
              <label>Dipasang Oleh:</label>
              <input type="text" v-model="form.urine_dipasang_oleh" class="form-control" />
            </div>
            <div class="col-md-6">
              <label>Jenis:</label>
              <input type="text" v-model="form.urine_jenis" class="form-control" />
            </div>
          </div>
        </div>

        <!-- 10. Desinfeksi Kulit -->
        <div class="item-row mb-3">
          <label class="fw-bold">10. Desinfeksi Kulit :</label>
          <div class="checkbox-group">
            <label class="cb-item"><input type="checkbox" v-model="form.desinfeksi_iodium" /> Iodium</label>
            <label class="cb-item"><input type="checkbox" v-model="form.desinfeksi_alkohol" /> Alkohol</label>
            <label class="cb-item"><input type="checkbox" v-model="form.desinfeksi_povidone" /> Povidone Iodine</label>
            <label class="cb-item"><input type="checkbox" v-model="form.desinfeksi_chlorhexidine" /> Chlorhexidine</label>
          </div>
        </div>

        <!-- 11. Insisi Kulit -->
        <div class="item-row mb-3">
          <label class="fw-bold">11. Insisi Kulit :</label>
          <div class="checkbox-group">
            <label class="cb-item"><input type="checkbox" v-model="form.insisi_pfannenstiel" /> Pfannenstiel</label>
            <div class="cb-item-text">
              <span>Lainnya:</span>
              <input type="text" v-model="form.insisi_lainnya" class="input-inline" />
            </div>
          </div>
        </div>

        <!-- 12. Alat Bantu -->
        <div class="item-row mb-3">
          <label class="fw-bold">12. Alat Bantu :</label>
          <div class="checkbox-group flex-wrap">
            <label class="cb-item"><input type="checkbox" v-model="form.alat_hand_rest" /> Hand Rest</label>
            <label class="cb-item"><input type="checkbox" v-model="form.alat_lithotomi_support" /> Lithotomi Support</label>
            <label class="cb-item"><input type="checkbox" v-model="form.alat_lateral_support" /> Lateral Support</label>
            <label class="cb-item"><input type="checkbox" v-model="form.alat_chest_support" /> Chest Support</label>
            <label class="cb-item"><input type="checkbox" v-model="form.alat_heat_frame" /> Heat Frame</label>
            <div class="cb-item-text">
              <span>Lainnya:</span>
              <input type="text" v-model="form.alat_lainnya" class="input-inline" />
            </div>
          </div>
        </div>

        <!-- 13. Diatermi -->
        <div class="item-row mb-3">
          <label class="fw-bold">13. Diatermi :</label>
          <div class="checkbox-group">
            <label class="cb-item"><input type="checkbox" v-model="form.diatermi_ya" /> Ya</label>
            <label class="cb-item"><input type="checkbox" v-model="form.diatermi_tidak" /> Tidak</label>
          </div>
          <div class="checkbox-group mt-1">
            <label class="cb-item"><input type="checkbox" v-model="form.diatermi_monopolar" /> Monopolar</label>
            <label class="cb-item"><input type="checkbox" v-model="form.diatermi_bipolar" /> Bipolar</label>
          </div>
          <div class="mt-2">
            <label class="fw-bold" style="font-size:13px;">Pad Netral :</label>
            <div class="checkbox-group flex-wrap">
              <label class="cb-item"><input type="checkbox" v-model="form.diatermi_netral_bokong" /> Bokong</label>
              <label class="cb-item"><input type="checkbox" v-model="form.diatermi_netral_tungkai_atas" /> Tungkai Atas</label>
              <label class="cb-item"><input type="checkbox" v-model="form.diatermi_netral_tungkai_bawah" /> Tungkai Bawah</label>
              <label class="cb-item"><input type="checkbox" v-model="form.diatermi_netral_punggung" /> Punggung</label>
              <label class="cb-item"><input type="checkbox" v-model="form.diatermi_netral_bahu" /> Bahu</label>
            </div>
          </div>
          <div class="row mt-1">
            <div class="col-md-6">
              <label>Dipasang Oleh:</label>
              <input type="text" v-model="form.diatermi_dipasang_oleh" class="form-control" />
            </div>
          </div>
          <div class="row mt-1">
            <div class="col-md-6">
              <label class="fw-bold" style="font-size:13px;">Kondisi Kulit Sebelum :</label>
              <div class="checkbox-group">
                <label class="cb-item"><input type="checkbox" v-model="form.diatermi_kulit_sbl_utuh" /> Utuh</label>
                <label class="cb-item"><input type="checkbox" v-model="form.diatermi_kulit_sbl_bulosa" /> Bulosa</label>
                <label class="cb-item"><input type="checkbox" v-model="form.diatermi_kulit_sbl_eritema" /> Eritema</label>
                <label class="cb-item"><input type="checkbox" v-model="form.diatermi_kulit_sbl_luka_bakar" /> Luka Bakar</label>
              </div>
            </div>
            <div class="col-md-6">
              <label class="fw-bold" style="font-size:13px;">Kondisi Kulit Sesudah :</label>
              <div class="checkbox-group">
                <label class="cb-item"><input type="checkbox" v-model="form.diatermi_kulit_ssd_utuh" /> Utuh</label>
                <label class="cb-item"><input type="checkbox" v-model="form.diatermi_kulit_ssd_bulosa" /> Bulosa</label>
                <label class="cb-item"><input type="checkbox" v-model="form.diatermi_kulit_ssd_eritema" /> Eritema</label>
                <label class="cb-item"><input type="checkbox" v-model="form.diatermi_kulit_ssd_luka_bakar" /> Luka Bakar</label>
              </div>
            </div>
          </div>
        </div>

        <!-- 14. Warm Blanket -->
        <div class="item-row mb-3">
          <label class="fw-bold">14. Warm Blanket :</label>
          <div class="checkbox-group">
            <label class="cb-item"><input type="checkbox" v-model="form.warm_blanket_ya" /> Ya</label>
            <label class="cb-item"><input type="checkbox" v-model="form.warm_blanket_tidak" /> Tidak</label>
          </div>
          <div class="row mt-1">
            <div class="col-md-4">
              <label>Jenis:</label>
              <input type="text" v-model="form.warm_blanket_jenis" class="form-control" />
            </div>
            <div class="col-md-4">
              <label>Jam Mulai:</label>
              <input type="time" v-model="form.warm_blanket_jam_mulai" class="form-control" />
            </div>
            <div class="col-md-4">
              <label>Jam Selesai:</label>
              <input type="time" v-model="form.warm_blanket_jam_selesai" class="form-control" />
            </div>
          </div>
        </div>

        <!-- 15. Tourniquet -->
        <div class="item-row mb-3">
          <label class="fw-bold">15. Tourniquet :</label>
          <div class="checkbox-group">
            <label class="cb-item"><input type="checkbox" v-model="form.tourniquet_ya" /> Ya</label>
            <label class="cb-item"><input type="checkbox" v-model="form.tourniquet_tidak" /> Tidak</label>
          </div>
          <div class="row mt-1">
            <div class="col-md-6">
              <label>Lokasi:</label>
              <input type="text" v-model="form.tourniquet_lokasi" class="form-control" />
            </div>
            <div class="col-md-6">
              <label>Dipasang Oleh:</label>
              <input type="text" v-model="form.tourniquet_dipasang_oleh" class="form-control" />
            </div>
          </div>
          <div class="mt-2">
            <label class="fw-bold" style="font-size:13px;">Lengan :</label>
            <div class="checkbox-group">
              <label class="cb-item"><input type="checkbox" v-model="form.tourniquet_lengan" /> Lengan</label>
            </div>
            <div class="row mt-1">
              <div class="col-md-4">
                <label>Jam Mulai:</label>
                <input type="time" v-model="form.tourniquet_lengan_jam_mulai" class="form-control" />
              </div>
              <div class="col-md-4">
                <label>Jam Selesai:</label>
                <input type="time" v-model="form.tourniquet_lengan_jam_selesai" class="form-control" />
              </div>
              <div class="col-md-4">
                <label>TD:</label>
                <input type="text" v-model="form.tourniquet_lengan_td" class="form-control" />
              </div>
            </div>
          </div>
          <div class="mt-2">
            <label class="fw-bold" style="font-size:13px;">Kaki :</label>
            <div class="checkbox-group">
              <label class="cb-item"><input type="checkbox" v-model="form.tourniquet_kaki" /> Kaki</label>
            </div>
            <div class="row mt-1">
              <div class="col-md-4">
                <label>Jam Mulai:</label>
                <input type="time" v-model="form.tourniquet_kaki_jam_mulai" class="form-control" />
              </div>
              <div class="col-md-4">
                <label>Jam Selesai:</label>
                <input type="time" v-model="form.tourniquet_kaki_jam_selesai" class="form-control" />
              </div>
              <div class="col-md-4">
                <label>TD:</label>
                <input type="text" v-model="form.tourniquet_kaki_td" class="form-control" />
              </div>
            </div>
          </div>
        </div>

        <!-- 16. Implant -->
        <div class="item-row mb-3">
          <label class="fw-bold">16. Implant :</label>
          <div class="checkbox-group">
            <label class="cb-item"><input type="checkbox" v-model="form.implant_ya" /> Ya</label>
            <label class="cb-item"><input type="checkbox" v-model="form.implant_tidak" /> Tidak</label>
          </div>
          <div class="row mt-1">
            <div class="col-md-6">
              <label>Jenis:</label>
              <input type="text" v-model="form.implant_jenis" class="form-control" />
            </div>
            <div class="col-md-6">
              <label>Lokasi:</label>
              <input type="text" v-model="form.implant_lokasi" class="form-control" />
            </div>
          </div>
        </div>

        <!-- 17. Drain -->
        <div class="item-row mb-3">
          <label class="fw-bold">17. Drain :</label>
          <div class="checkbox-group">
            <label class="cb-item"><input type="checkbox" v-model="form.drain_ya" /> Ya</label>
            <label class="cb-item"><input type="checkbox" v-model="form.drain_tidak" /> Tidak</label>
          </div>
          <div class="row mt-1">
            <div class="col-md-6">
              <label>Jenis:</label>
              <input type="text" v-model="form.drain_jenis" class="form-control" />
            </div>
            <div class="col-md-6">
              <label>Lokasi:</label>
              <input type="text" v-model="form.drain_lokasi" class="form-control" />
            </div>
          </div>
        </div>

        <!-- 18. Irigasi Luka -->
        <div class="item-row mb-3">
          <label class="fw-bold">18. Irigasi Luka :</label>
          <div class="checkbox-group">
            <label class="cb-item"><input type="checkbox" v-model="form.irigasi_ya" /> Ya</label>
            <label class="cb-item"><input type="checkbox" v-model="form.irigasi_tidak" /> Tidak</label>
          </div>
          <div class="checkbox-group mt-1">
            <label class="cb-item"><input type="checkbox" v-model="form.irigasi_nacl" /> NaCl</label>
            <label class="cb-item"><input type="checkbox" v-model="form.irigasi_h2o2" /> H₂O₂</label>
            <label class="cb-item"><input type="checkbox" v-model="form.irigasi_antibiotik" /> Antibiotik</label>
            <div class="cb-item-text">
              <span>Lainnya:</span>
              <input type="text" v-model="form.irigasi_lainnya" class="input-inline" />
            </div>
          </div>
        </div>

        <!-- 19. Tampon -->
        <div class="item-row mb-3">
          <label class="fw-bold">19. Tampon :</label>
          <div class="checkbox-group">
            <label class="cb-item"><input type="checkbox" v-model="form.tampon_ya" /> Ya</label>
            <label class="cb-item"><input type="checkbox" v-model="form.tampon_tidak" /> Tidak</label>
          </div>
          <div class="row mt-1">
            <div class="col-md-6">
              <label>Lokasi:</label>
              <input type="text" v-model="form.tampon_lokasi" class="form-control" />
            </div>
            <div class="col-md-6">
              <label>Jumlah:</label>
              <input type="text" v-model="form.tampon_jumlah" class="form-control" />
            </div>
          </div>
        </div>

        <!-- 20. Spesimen -->
        <div class="item-row mb-3">
          <label class="fw-bold">20. Spesimen :</label>
          <div class="row mt-1">
            <div class="col-md-6">
              <div class="checkbox-row mb-2">
                <label class="cb-item">
                  <input type="checkbox" v-model="form.spesimen_histology" /> Histology
                </label>
                <input type="text" v-model="form.spesimen_histology_jenis" class="form-control mt-1" placeholder="Jenis spesimen..." />
              </div>
            </div>
            <div class="col-md-6">
              <div class="checkbox-row mb-2">
                <label class="cb-item">
                  <input type="checkbox" v-model="form.spesimen_kultur" /> Kultur
                </label>
                <input type="text" v-model="form.spesimen_kultur_jenis" class="form-control mt-1" placeholder="Jenis spesimen..." />
              </div>
            </div>
            <div class="col-md-6">
              <div class="checkbox-row mb-2">
                <label class="cb-item">
                  <input type="checkbox" v-model="form.spesimen_cytologi" /> Cytologi
                </label>
                <input type="text" v-model="form.spesimen_cytologi_jenis" class="form-control mt-1" placeholder="Jenis spesimen..." />
              </div>
            </div>
            <div class="col-md-6">
              <div class="checkbox-row mb-2">
                <label class="cb-item">
                  <input type="checkbox" v-model="form.spesimen_frozen" /> Frozen Section
                </label>
                <input type="text" v-model="form.spesimen_frozen_jenis" class="form-control mt-1" placeholder="Jenis spesimen..." />
              </div>
            </div>
          </div>
        </div>

        <!-- 21. Cairan Infus -->
        <div class="item-row mb-3">
          <label class="fw-bold">21. Cairan Infus :</label>
          <table class="cairan-table">
            <thead>
              <tr>
                <th>Cairan</th>
                <th>Input (ml)</th>
                <th>Output (ml)</th>
                <th>Total (ml)</th>
                <th style="width:50px;">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(row, idx) in form.cairan_infus" :key="idx">
                <td><input type="text" v-model="row.cairan" class="form-control" /></td>
                <td><input type="number" v-model="row.input" class="form-control" /></td>
                <td><input type="number" v-model="row.output" class="form-control" /></td>
                <td><input type="number" v-model="row.total" class="form-control" /></td>
                <td>
                  <button type="button" @click="removeCairan(idx)" class="btn-remove-row">✕</button>
                </td>
              </tr>
            </tbody>
          </table>
          <button type="button" @click="addCairan" class="btn-add-row mt-2">+ Tambah Baris</button>
        </div>

        <!-- 22–24. Kassa, Jarum, Bisturi -->
        <div class="item-row mb-3">
          <label class="fw-bold">22–24. Kassa / Jarum / Bisturi :</label>
          <table class="count-table mt-1">
            <thead>
              <tr>
                <th>Jenis</th>
                <th>Sebelum</th>
                <th>+ Penambahan</th>
                <th>= Sesudah</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><strong>22. Kassa</strong></td>
                <td><input type="text" v-model="form.kassa_sebelum" class="form-control" /></td>
                <td><input type="text" v-model="form.kassa_penambahan" class="form-control" /></td>
                <td><input type="text" v-model="form.kassa_setelah" class="form-control" /></td>
              </tr>
              <tr>
                <td><strong>23. Jarum</strong></td>
                <td><input type="text" v-model="form.jarum_sebelum" class="form-control" /></td>
                <td><input type="text" v-model="form.jarum_penambahan" class="form-control" /></td>
                <td><input type="text" v-model="form.jarum_setelah" class="form-control" /></td>
              </tr>
              <tr>
                <td><strong>24. Bisturi</strong></td>
                <td><input type="text" v-model="form.bisturi_sebelum" class="form-control" /></td>
                <td><input type="text" v-model="form.bisturi_penambahan" class="form-control" /></td>
                <td><input type="text" v-model="form.bisturi_setelah" class="form-control" /></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- SECTION B: TABEL KASA DAN INSTRUMEN -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">B. Tabel Kasa dan Alat Instrumen</h5>
        <table class="instrumen-table">
          <thead>
            <tr>
              <th>Nama Alat / Kasa</th>
              <th>Persediaan</th>
              <th>Terpakai</th>
              <th>Sisa</th>
              <th>Keterangan</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><strong>Kasa Besar</strong></td>
              <td><input type="text" v-model="form.kasa_besar_persediaan" class="form-control" /></td>
              <td><input type="text" v-model="form.kasa_besar_terpakai" class="form-control" /></td>
              <td><input type="text" v-model="form.kasa_besar_sisa" class="form-control" /></td>
              <td><input type="text" v-model="form.kasa_besar_keterangan" class="form-control" /></td>
            </tr>
            <tr>
              <td><strong>Kasa</strong></td>
              <td><input type="text" v-model="form.kasa_persediaan" class="form-control" /></td>
              <td><input type="text" v-model="form.kasa_terpakai" class="form-control" /></td>
              <td><input type="text" v-model="form.kasa_sisa" class="form-control" /></td>
              <td><input type="text" v-model="form.kasa_keterangan" class="form-control" /></td>
            </tr>
            <tr>
              <td><strong>Kasa Kacang</strong></td>
              <td><input type="text" v-model="form.kasa_kacang_persediaan" class="form-control" /></td>
              <td><input type="text" v-model="form.kasa_kacang_terpakai" class="form-control" /></td>
              <td><input type="text" v-model="form.kasa_kacang_sisa" class="form-control" /></td>
              <td><input type="text" v-model="form.kasa_kacang_keterangan" class="form-control" /></td>
            </tr>
            <tr>
              <td><strong>Kasa Tampon</strong></td>
              <td><input type="text" v-model="form.kasa_tampon_persediaan" class="form-control" /></td>
              <td><input type="text" v-model="form.kasa_tampon_terpakai" class="form-control" /></td>
              <td><input type="text" v-model="form.kasa_tampon_sisa" class="form-control" /></td>
              <td><input type="text" v-model="form.kasa_tampon_keterangan" class="form-control" /></td>
            </tr>
            <tr>
              <td><strong>Instrumen</strong></td>
              <td><input type="text" v-model="form.instrumen_persediaan" class="form-control" /></td>
              <td><input type="text" v-model="form.instrumen_terpakai" class="form-control" /></td>
              <td><input type="text" v-model="form.instrumen_sisa" class="form-control" /></td>
              <td><input type="text" v-model="form.instrumen_keterangan" class="form-control" /></td>
            </tr>
            <tr>
              <td><strong>Jarum Atraumatik</strong></td>
              <td><input type="text" v-model="form.jarum_atraumatik_persediaan" class="form-control" /></td>
              <td><input type="text" v-model="form.jarum_atraumatik_terpakai" class="form-control" /></td>
              <td><input type="text" v-model="form.jarum_atraumatik_sisa" class="form-control" /></td>
              <td><input type="text" v-model="form.jarum_atraumatik_keterangan" class="form-control" /></td>
            </tr>
            <tr>
              <td><strong>Jarum Lepas</strong></td>
              <td><input type="text" v-model="form.jarum_lepas_persediaan" class="form-control" /></td>
              <td><input type="text" v-model="form.jarum_lepas_terpakai" class="form-control" /></td>
              <td><input type="text" v-model="form.jarum_lepas_sisa" class="form-control" /></td>
              <td><input type="text" v-model="form.jarum_lepas_keterangan" class="form-control" /></td>
            </tr>
            <tr>
              <td><strong>Selang</strong></td>
              <td><input type="text" v-model="form.selang_persediaan" class="form-control" /></td>
              <td><input type="text" v-model="form.selang_terpakai" class="form-control" /></td>
              <td><input type="text" v-model="form.selang_sisa" class="form-control" /></td>
              <td><input type="text" v-model="form.selang_keterangan" class="form-control" /></td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- TANDA TANGAN -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Tanda Tangan</h5>
        <div class="row">
          <!-- Dokter Operator -->
          <div class="col-md-4">
            <div class="sign-box">
              <label class="fw-bold text-center" style="display:block;">Dokter Operator</label>
              <div v-if="!signatureDokterCleared && form.ttd_dokter_operator" class="signature-preview">
                <img :src="form.ttd_dokter_operator" class="img-ttd" />
              </div>
              <VueSignaturePad
                v-else
                ref="ttd_dokter"
                :options="sigOption"
                class="signature-box-ttd"
              />
              <div class="sign-actions mt-1">
                <button type="button" @click="saveTtdDokter" class="btn-sign-save">Simpan TTD</button>
                <button type="button" @click="clearTtdDokter" class="btn-sign-clear">Hapus</button>
              </div>
              <div class="mt-2">
                <label>Nama Dokter Operator:</label>
                <input type="text" v-model="form.nama_dokter_operator" class="form-control" />
              </div>
            </div>
          </div>

          <!-- Perawat Instrumen -->
          <div class="col-md-4">
            <div class="sign-box">
              <label class="fw-bold text-center" style="display:block;">Perawat Instrumen</label>
              <div v-if="!signatureInstrumenCleared && form.ttd_perawat_instrumen" class="signature-preview">
                <img :src="form.ttd_perawat_instrumen" class="img-ttd" />
              </div>
              <VueSignaturePad
                v-else
                ref="ttd_instrumen"
                :options="sigOption"
                class="signature-box-ttd"
              />
              <div class="sign-actions mt-1">
                <button type="button" @click="saveTtdInstrumen" class="btn-sign-save">Simpan TTD</button>
                <button type="button" @click="clearTtdInstrumen" class="btn-sign-clear">Hapus</button>
              </div>
              <div class="mt-2">
                <label>Nama Perawat Instrumen:</label>
                <input type="text" v-model="form.nama_perawat_instrumen" class="form-control" />
              </div>
            </div>
          </div>

          <!-- Perawat Sirkuler -->
          <div class="col-md-4">
            <div class="sign-box">
              <label class="fw-bold text-center" style="display:block;">Perawat Sirkuler</label>
              <div v-if="!signatureSirkulerCleared && form.ttd_perawat_sirkuler" class="signature-preview">
                <img :src="form.ttd_perawat_sirkuler" class="img-ttd" />
              </div>
              <VueSignaturePad
                v-else
                ref="ttd_sirkuler"
                :options="sigOption"
                class="signature-box-ttd"
              />
              <div class="sign-actions mt-1">
                <button type="button" @click="saveTtdSirkuler" class="btn-sign-save">Simpan TTD</button>
                <button type="button" @click="clearTtdSirkuler" class="btn-sign-clear">Hapus</button>
              </div>
              <div class="mt-2">
                <label>Nama Perawat Sirkuler:</label>
                <input type="text" v-model="form.nama_perawat_sirkuler" class="form-control" />
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- SECTION C: DIAGNOSA INTRA OPERASI -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">C. Diagnosa Keperawatan Intra Operasi</h5>
        <table class="diagnosa-table">
          <thead>
            <tr>
              <th style="width:28%">Diagnosa</th>
              <th style="width:34%">Intervensi</th>
              <th style="width:24%">Evaluasi</th>
              <th style="width:14%">Paraf &amp; Nama</th>
            </tr>
          </thead>
          <tbody>
            <!-- C1: Gangguan pola nafas -->
            <tr>
              <td>
                <div class="diag-label">C1. Gangguan Pola Nafas b/d:</div>
                <label class="cb-item"><input type="checkbox" v-model="form.c_gn_neuro_muskular" /> Gangguan neuromuskular</label>
                <label class="cb-item"><input type="checkbox" v-model="form.c_gn_penumpukan_sekret" /> Penumpukan sekret</label>
              </td>
              <td>
                <label class="cb-item"><input type="checkbox" v-model="form.c_gn_int_jalan_nafas" /> Pertahankan jalan nafas</label>
                <label class="cb-item"><input type="checkbox" v-model="form.c_gn_int_hiperekstensi" /> Posisi hiperekstensi</label>
                <label class="cb-item"><input type="checkbox" v-model="form.c_gn_int_observasi_rr" /> Observasi RR</label>
                <label class="cb-item"><input type="checkbox" v-model="form.c_gn_int_pantau_ttv" /> Pantau TTV</label>
                <label class="cb-item"><input type="checkbox" v-model="form.c_gn_int_suction" /> Suction</label>
                <label class="cb-item"><input type="checkbox" v-model="form.c_gn_int_o2" /> Beri O2</label>
                <label class="cb-item"><input type="checkbox" v-model="form.c_gn_int_obat" /> Kolaborasi obat</label>
              </td>
              <td>
                <label class="cb-item"><input type="checkbox" v-model="form.c_gn_eval_ttv_normal" /> TTV normal</label>
                <label class="cb-item"><input type="checkbox" v-model="form.c_gn_eval_nafas_spontan" /> Nafas spontan</label>
                <label class="cb-item"><input type="checkbox" v-model="form.c_gn_eval_sianosis" /> Tidak sianosis</label>
                <label class="cb-item"><input type="checkbox" v-model="form.c_gn_eval_observasi_ruangan" /> Obs. ruangan</label>
                <div class="mt-1">
                  <label style="font-size:12px;">O2:</label>
                  <input type="text" v-model="form.c_gn_eval_o2_value" class="form-control" style="font-size:12px;padding:3px 6px;" />
                </div>
              </td>
              <td>
                <div v-if="!sigCgnCleared && form.c_gn_paraf" class="sig-mini-preview">
                  <img :src="form.c_gn_paraf" class="img-ttd-mini" />
                </div>
                <VueSignaturePad v-else ref="sig_cgn" :options="sigOption" class="sig-mini-box" />
                <div class="sig-mini-actions">
                  <button type="button" @click="saveSigCgn" class="btn-sign-save btn-sm-ttd">Simpan</button>
                  <button type="button" @click="clearSigCgn" class="btn-sign-clear btn-sm-ttd">Hapus</button>
                </div>
                <input type="text" v-model="form.c_gn_nama" class="form-control mt-1" placeholder="Nama..." style="font-size:12px;padding:3px 6px;" />
              </td>
            </tr>
            <!-- C2: Resiko kekurangan cairan -->
            <tr>
              <td>
                <div class="diag-label">C2. Resiko Tinggi Kekurangan Cairan b/d:</div>
                <label class="cb-item"><input type="checkbox" v-model="form.c_rc_pembatasan_intake" /> Pembatasan intake</label>
                <label class="cb-item"><input type="checkbox" v-model="form.c_rc_hilang_cairan" /> Hilangnya cairan</label>
                <label class="cb-item"><input type="checkbox" v-model="form.c_rc_pengeluaran_integritas" /> Pengeluaran integritas</label>
              </td>
              <td>
                <label class="cb-item"><input type="checkbox" v-model="form.c_rc_int_ukur_io" /> Ukur Input/Output</label>
                <label class="cb-item"><input type="checkbox" v-model="form.c_rc_int_pantau_ttv" /> Pantau TTV</label>
                <label class="cb-item"><input type="checkbox" v-model="form.c_rc_int_mual_muntah" /> Atasi mual/muntah</label>
                <label class="cb-item"><input type="checkbox" v-model="form.c_rc_int_periksa_pembalut" /> Periksa pembalut</label>
                <label class="cb-item"><input type="checkbox" v-model="form.c_rc_int_pantau_suhu" /> Pantau suhu</label>
              </td>
              <td>
                <label class="cb-item"><input type="checkbox" v-model="form.c_rc_eval_ttv_normal" /> TTV normal</label>
                <div class="mt-1">
                  <label style="font-size:12px;">Input (ml):</label>
                  <input type="text" v-model="form.c_rc_eval_input" class="form-control" style="font-size:12px;padding:3px 6px;" />
                </div>
                <div class="mt-1">
                  <label style="font-size:12px;">Output (ml):</label>
                  <input type="text" v-model="form.c_rc_eval_output" class="form-control" style="font-size:12px;padding:3px 6px;" />
                </div>
                <label class="cb-item mt-1"><input type="checkbox" v-model="form.c_rc_eval_mukosa_lembab" /> Mukosa lembab</label>
                <label class="cb-item"><input type="checkbox" v-model="form.c_rc_eval_turgor_elastis" /> Turgor elastis</label>
              </td>
              <td>
                <div v-if="!sigCrcCleared && form.c_rc_paraf" class="sig-mini-preview">
                  <img :src="form.c_rc_paraf" class="img-ttd-mini" />
                </div>
                <VueSignaturePad v-else ref="sig_crc" :options="sigOption" class="sig-mini-box" />
                <div class="sig-mini-actions">
                  <button type="button" @click="saveSigCrc" class="btn-sign-save btn-sm-ttd">Simpan</button>
                  <button type="button" @click="clearSigCrc" class="btn-sign-clear btn-sm-ttd">Hapus</button>
                </div>
                <input type="text" v-model="form.c_rc_nama" class="form-control mt-1" placeholder="Nama..." style="font-size:12px;padding:3px 6px;" />
              </td>
            </tr>
            <!-- C3: Resiko cedera -->
            <tr>
              <td>
                <div class="diag-label">C3. Resiko Tinggi Cedera b/d:</div>
                <label class="cb-item"><input type="checkbox" v-model="form.c_rd_pemajanan_peralatan" /> Pemajanan peralatan</label>
                <label class="cb-item"><input type="checkbox" v-model="form.c_rd_hipoksia_jaringan" /> Hipoksia jaringan</label>
              </td>
              <td>
                <label class="cb-item"><input type="checkbox" v-model="form.c_rd_int_lepas_gigi" /> Lepas gigi palsu</label>
                <label class="cb-item"><input type="checkbox" v-model="form.c_rd_int_periksa_identitas" /> Periksa identitas</label>
                <label class="cb-item"><input type="checkbox" v-model="form.c_rd_int_brankar" /> Kunci brankar</label>
                <label class="cb-item"><input type="checkbox" v-model="form.c_rd_int_sabuk" /> Pasang sabuk</label>
                <label class="cb-item"><input type="checkbox" v-model="form.c_rd_int_peralatan_posisi" /> Peralatan posisi</label>
                <label class="cb-item"><input type="checkbox" v-model="form.c_rd_int_keamanan_elektrikal" /> Keamanan elektrikal</label>
                <label class="cb-item"><input type="checkbox" v-model="form.c_rd_int_plate_diatermi" /> Plate diatermi</label>
                <label class="cb-item"><input type="checkbox" v-model="form.c_rd_int_pantau_io" /> Pantau I/O</label>
                <label class="cb-item"><input type="checkbox" v-model="form.c_rd_int_catat_kassa" /> Catat kassa</label>
              </td>
              <td>
                <label class="cb-item"><input type="checkbox" v-model="form.c_rd_eval_posisi" /> Posisi terpenuhi</label>
                <label class="cb-item"><input type="checkbox" v-model="form.c_rd_eval_alat_elektro" /> Alat elektro aman</label>
                <label class="cb-item"><input type="checkbox" v-model="form.c_rd_eval_kassa" /> Kassa lengkap</label>
              </td>
              <td>
                <div v-if="!sigCrdCleared && form.c_rd_paraf" class="sig-mini-preview">
                  <img :src="form.c_rd_paraf" class="img-ttd-mini" />
                </div>
                <VueSignaturePad v-else ref="sig_crd" :options="sigOption" class="sig-mini-box" />
                <div class="sig-mini-actions">
                  <button type="button" @click="saveSigCrd" class="btn-sign-save btn-sm-ttd">Simpan</button>
                  <button type="button" @click="clearSigCrd" class="btn-sign-clear btn-sm-ttd">Hapus</button>
                </div>
                <input type="text" v-model="form.c_rd_nama" class="form-control mt-1" placeholder="Nama..." style="font-size:12px;padding:3px 6px;" />
              </td>
            </tr>
            <!-- C4: Resiko infeksi intra -->
            <tr>
              <td>
                <div class="diag-label">C4. Resiko Infeksi b/d:</div>
                <label class="cb-item"><input type="checkbox" v-model="form.c_ri_trauma_post" /> Trauma post op</label>
                <label class="cb-item"><input type="checkbox" v-model="form.c_ri_pemajanan_lingkungan" /> Pemajanan lingkungan</label>
                <label class="cb-item"><input type="checkbox" v-model="form.c_ri_pemajanan_peralatan" /> Pemajanan peralatan</label>
              </td>
              <td>
                <label class="cb-item"><input type="checkbox" v-model="form.c_ri_int_cuci_tangan" /> Cuci tangan</label>
                <label class="cb-item"><input type="checkbox" v-model="form.c_ri_int_desinfeksi" /> Desinfeksi</label>
                <label class="cb-item"><input type="checkbox" v-model="form.c_ri_int_kadaluarsa" /> Cek kadaluarsa</label>
                <label class="cb-item"><input type="checkbox" v-model="form.c_ri_int_sterilitas" /> Jaga sterilitas</label>
                <label class="cb-item"><input type="checkbox" v-model="form.c_ri_int_tutup_luka" /> Tutup luka</label>
              </td>
              <td>
                <label class="cb-item"><input type="checkbox" v-model="form.c_ri_eval_lingkungan_steril" /> Lingkungan steril</label>
              </td>
              <td>
                <div v-if="!sigCriCleared && form.c_ri_paraf" class="sig-mini-preview">
                  <img :src="form.c_ri_paraf" class="img-ttd-mini" />
                </div>
                <VueSignaturePad v-else ref="sig_cri" :options="sigOption" class="sig-mini-box" />
                <div class="sig-mini-actions">
                  <button type="button" @click="saveSigCri" class="btn-sign-save btn-sm-ttd">Simpan</button>
                  <button type="button" @click="clearSigCri" class="btn-sign-clear btn-sm-ttd">Hapus</button>
                </div>
                <input type="text" v-model="form.c_ri_nama" class="form-control mt-1" placeholder="Nama..." style="font-size:12px;padding:3px 6px;" />
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- SECTION D: PENGKAJIAN PASCA OPERASI -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">D. Pengkajian Pasca Operasi</h5>

        <div class="item-row mb-3">
          <label class="fw-bold">Ruang Pemulihan :</label>
          <div class="checkbox-group">
            <label class="cb-item"><input type="checkbox" v-model="form.d_ruang_pemulihan_ya" /> Ya</label>
            <label class="cb-item"><input type="checkbox" v-model="form.d_ruang_pemulihan_tidak" /> Tidak</label>
          </div>
          <div class="row mt-2">
            <div class="col-md-3">
              <label>Jam Masuk :</label>
              <input type="time" v-model="form.d_masuk_jam" class="form-control" />
            </div>
            <div class="col-md-3">
              <label>Jam Keluar :</label>
              <input type="time" v-model="form.d_keluar_jam" class="form-control" />
            </div>
            <div class="col-md-6">
              <label>Kembali ke :</label>
              <div class="checkbox-group">
                <label class="cb-item"><input type="checkbox" v-model="form.d_kembali_ruangan" /> Ruangan</label>
                <label class="cb-item"><input type="checkbox" v-model="form.d_kembali_icu" /> ICU</label>
                <div class="cb-item-text">
                  <span>Lainnya:</span>
                  <input type="text" v-model="form.d_kembali_lainnya" class="input-inline" />
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6 mb-3">
            <div class="item-row">
              <label class="fw-bold">1. Keadaan Umum :</label>
              <div class="checkbox-group">
                <label class="cb-item"><input type="checkbox" v-model="form.d_keadaan_baik" /> Baik</label>
                <label class="cb-item"><input type="checkbox" v-model="form.d_keadaan_sedang" /> Sedang</label>
                <label class="cb-item"><input type="checkbox" v-model="form.d_keadaan_buruk" /> Buruk</label>
              </div>
            </div>
          </div>
          <div class="col-md-6 mb-3">
            <div class="item-row">
              <label class="fw-bold">2. Kesadaran :</label>
              <div class="checkbox-group flex-wrap">
                <label class="cb-item"><input type="checkbox" v-model="form.d_kesadaran_cm" /> CM</label>
                <label class="cb-item"><input type="checkbox" v-model="form.d_kesadaran_apatis" /> Apatis</label>
                <label class="cb-item"><input type="checkbox" v-model="form.d_kesadaran_somnolen" /> Somnolen</label>
                <label class="cb-item"><input type="checkbox" v-model="form.d_kesadaran_sopor" /> Sopor</label>
                <label class="cb-item"><input type="checkbox" v-model="form.d_kesadaran_koma" /> Koma</label>
              </div>
            </div>
          </div>
          <div class="col-md-6 mb-3">
            <div class="item-row">
              <label class="fw-bold">3. Kulit (Datang) :</label>
              <div class="checkbox-group">
                <label class="cb-item"><input type="checkbox" v-model="form.d_kulit_datang_kering" /> Kering</label>
                <label class="cb-item"><input type="checkbox" v-model="form.d_kulit_datang_merah_muda" /> Merah Muda</label>
                <label class="cb-item"><input type="checkbox" v-model="form.d_kulit_datang_hangat" /> Hangat</label>
              </div>
            </div>
          </div>
          <div class="col-md-6 mb-3">
            <div class="item-row">
              <label class="fw-bold">4. Kulit (Keluar) :</label>
              <div class="checkbox-group">
                <label class="cb-item"><input type="checkbox" v-model="form.d_kulit_keluar_kering" /> Kering</label>
                <label class="cb-item"><input type="checkbox" v-model="form.d_kulit_keluar_merah_muda" /> Merah Muda</label>
                <label class="cb-item"><input type="checkbox" v-model="form.d_kulit_keluar_hangat" /> Hangat</label>
              </div>
            </div>
          </div>
          <div class="col-md-6 mb-3">
            <div class="item-row">
              <label class="fw-bold">5. Sirkulasi :</label>
              <div class="checkbox-group">
                <label class="cb-item"><input type="checkbox" v-model="form.d_sirkulasi_merah_muda" /> Merah Muda</label>
                <label class="cb-item"><input type="checkbox" v-model="form.d_sirkulasi_kebiruan" /> Kebiruan</label>
              </div>
            </div>
          </div>
          <div class="col-md-6 mb-3">
            <div class="item-row">
              <label class="fw-bold">6. Posisi :</label>
              <div class="checkbox-group flex-wrap">
                <label class="cb-item"><input type="checkbox" v-model="form.d_posisi_lateral" /> Lateral</label>
                <label class="cb-item"><input type="checkbox" v-model="form.d_posisi_datar" /> Datar</label>
                <label class="cb-item"><input type="checkbox" v-model="form.d_posisi_head_up" /> Head Up</label>
                <label class="cb-item"><input type="checkbox" v-model="form.d_posisi_semi_fowler" /> Semi Fowler</label>
              </div>
            </div>
          </div>
          <div class="col-md-6 mb-3">
            <div class="item-row">
              <label class="fw-bold">7. Perdarahan :</label>
              <div class="checkbox-group">
                <label class="cb-item"><input type="checkbox" v-model="form.d_perdarahan_ya" /> Ya</label>
                <label class="cb-item"><input type="checkbox" v-model="form.d_perdarahan_tidak" /> Tidak</label>
              </div>
              <div class="row mt-1">
                <div class="col-md-6">
                  <label>CC :</label>
                  <input type="text" v-model="form.d_perdarahan_cc" class="form-control" />
                </div>
                <div class="col-md-6">
                  <label>Lokasi :</label>
                  <input type="text" v-model="form.d_perdarahan_lokasi" class="form-control" />
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6 mb-3">
            <div class="item-row">
              <label class="fw-bold">8. Muntah :</label>
              <div class="checkbox-group">
                <label class="cb-item"><input type="checkbox" v-model="form.d_muntah_ya" /> Ya</label>
                <label class="cb-item"><input type="checkbox" v-model="form.d_muntah_tidak" /> Tidak</label>
              </div>
            </div>
          </div>
          <div class="col-md-6 mb-3">
            <div class="item-row">
              <label class="fw-bold">9. Mukosa Mulut :</label>
              <div class="checkbox-group">
                <label class="cb-item"><input type="checkbox" v-model="form.d_mukosa_lembab" /> Lembab</label>
                <label class="cb-item"><input type="checkbox" v-model="form.d_mukosa_kering" /> Kering</label>
              </div>
            </div>
          </div>
          <div class="col-md-6 mb-3">
            <div class="item-row">
              <label class="fw-bold">10. Jaringan PA :</label>
              <div class="checkbox-group flex-wrap">
                <label class="cb-item"><input type="checkbox" v-model="form.d_jaringan_pa_ya" /> Ya</label>
                <label class="cb-item"><input type="checkbox" v-model="form.d_jaringan_pa_tidak" /> Tidak</label>
                <label class="cb-item"><input type="checkbox" v-model="form.d_jaringan_pa_k_bedah" /> K. Bedah</label>
                <label class="cb-item"><input type="checkbox" v-model="form.d_jaringan_pa_ruangan" /> Ruangan</label>
              </div>
              <div class="mt-1">
                <label>Jumlah :</label>
                <input type="text" v-model="form.d_jaringan_pa_jumlah" class="form-control" />
              </div>
            </div>
          </div>
          <div class="col-md-6 mb-3">
            <div class="item-row">
              <label class="fw-bold">11. Skrining Nyeri :</label>
              <div class="checkbox-group">
                <label class="cb-item"><input type="checkbox" v-model="form.d_nyeri_ya" /> Ya</label>
                <label class="cb-item"><input type="checkbox" v-model="form.d_nyeri_tidak" /> Tidak</label>
              </div>
            </div>
          </div>
          <div class="col-md-6 mb-3">
            <div class="item-row">
              <label class="fw-bold">12. Resiko Jatuh :</label>
              <div class="checkbox-group">
                <label class="cb-item"><input type="checkbox" v-model="form.d_jatuh_ringan" /> Ringan</label>
                <label class="cb-item"><input type="checkbox" v-model="form.d_jatuh_sedang" /> Sedang</label>
                <label class="cb-item"><input type="checkbox" v-model="form.d_jatuh_tinggi" /> Tinggi</label>
              </div>
            </div>
          </div>
        </div>

        <div class="row mt-2">
          <div class="col-md-6">
            <label class="fw-bold">Tabel Nadi :</label>
            <table class="nadi-table">
              <thead>
                <tr><th>Nadi</th><th>Masuk</th><th>Keluar</th></tr>
              </thead>
              <tbody>
                <tr><td>Teratur</td>
                  <td class="text-center"><input type="checkbox" v-model="form.d_nadi_teratur_masuk" /></td>
                  <td class="text-center"><input type="checkbox" v-model="form.d_nadi_teratur_keluar" /></td>
                </tr>
                <tr><td>Tidak Teratur</td>
                  <td class="text-center"><input type="checkbox" v-model="form.d_nadi_tidak_teratur_masuk" /></td>
                  <td class="text-center"><input type="checkbox" v-model="form.d_nadi_tidak_teratur_keluar" /></td>
                </tr>
                <tr><td>Lemah</td>
                  <td class="text-center"><input type="checkbox" v-model="form.d_nadi_lemah_masuk" /></td>
                  <td class="text-center"><input type="checkbox" v-model="form.d_nadi_lemah_keluar" /></td>
                </tr>
                <tr><td>Takikardia</td>
                  <td class="text-center"><input type="checkbox" v-model="form.d_nadi_takikardia_masuk" /></td>
                  <td class="text-center"><input type="checkbox" v-model="form.d_nadi_takikardia_keluar" /></td>
                </tr>
                <tr><td>Normal</td>
                  <td class="text-center"><input type="checkbox" v-model="form.d_nadi_normal_masuk" /></td>
                  <td class="text-center"><input type="checkbox" v-model="form.d_nadi_normal_keluar" /></td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="col-md-6">
            <label class="fw-bold">Tabel Pernafasan :</label>
            <table class="nadi-table">
              <thead>
                <tr><th>Pernafasan</th><th>Masuk</th><th>Keluar</th></tr>
              </thead>
              <tbody>
                <tr><td>Teratur</td>
                  <td class="text-center"><input type="checkbox" v-model="form.d_nafas_teratur_masuk" /></td>
                  <td class="text-center"><input type="checkbox" v-model="form.d_nafas_teratur_keluar" /></td>
                </tr>
                <tr><td>Tidak Teratur</td>
                  <td class="text-center"><input type="checkbox" v-model="form.d_nafas_tidak_teratur_masuk" /></td>
                  <td class="text-center"><input type="checkbox" v-model="form.d_nafas_tidak_teratur_keluar" /></td>
                </tr>
                <tr><td>Dangkal</td>
                  <td class="text-center"><input type="checkbox" v-model="form.d_nafas_dangkal_masuk" /></td>
                  <td class="text-center"><input type="checkbox" v-model="form.d_nafas_dangkal_keluar" /></td>
                </tr>
                <tr><td>Dalam</td>
                  <td class="text-center"><input type="checkbox" v-model="form.d_nafas_dalam_masuk" /></td>
                  <td class="text-center"><input type="checkbox" v-model="form.d_nafas_dalam_keluar" /></td>
                </tr>
                <tr><td>Sukar</td>
                  <td class="text-center"><input type="checkbox" v-model="form.d_nafas_sukar_masuk" /></td>
                  <td class="text-center"><input type="checkbox" v-model="form.d_nafas_sukar_keluar" /></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- SECTION E: DIAGNOSA PASCA OPERASI -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">E. Diagnosa Keperawatan Pasca Operasi</h5>
        <table class="diagnosa-table">
          <thead>
            <tr>
              <th style="width:28%">Diagnosa</th>
              <th style="width:34%">Intervensi</th>
              <th style="width:24%">Evaluasi</th>
              <th style="width:14%">Paraf &amp; Nama</th>
            </tr>
          </thead>
          <tbody>
            <!-- E1: Nyeri akut -->
            <tr>
              <td>
                <div class="diag-label">E1. Nyeri Akut b/d:</div>
                <label class="cb-item"><input type="checkbox" v-model="form.e_na_gangguan_kulit" /> Gangguan integritas kulit</label>
                <label class="cb-item"><input type="checkbox" v-model="form.e_na_selang_drain" /> Adanya selang/drain</label>
              </td>
              <td>
                <label class="cb-item"><input type="checkbox" v-model="form.e_na_int_kaji_lokasi" /> Kaji lokasi nyeri</label>
                <label class="cb-item"><input type="checkbox" v-model="form.e_na_int_kaji_ttv" /> Kaji TTV</label>
                <label class="cb-item"><input type="checkbox" v-model="form.e_na_int_atur_posisi" /> Atur posisi nyaman</label>
                <label class="cb-item"><input type="checkbox" v-model="form.e_na_int_relaksasi" /> Teknik relaksasi</label>
              </td>
              <td>
                <label class="cb-item"><input type="checkbox" v-model="form.e_na_eval_ttv_normal" /> TTV normal</label>
                <label class="cb-item"><input type="checkbox" v-model="form.e_na_eval_nyeri_terkontrol" /> Nyeri terkontrol</label>
                <label class="cb-item"><input type="checkbox" v-model="form.e_na_eval_nyeri_berkurang" /> Nyeri berkurang</label>
                <label class="cb-item"><input type="checkbox" v-model="form.e_na_eval_observasi_ruangan" /> Obs. ruangan</label>
              </td>
              <td><span style="font-size:12px;color:#aaa;">—</span></td>
            </tr>
            <!-- E2: Resiko infeksi pasca -->
            <tr>
              <td>
                <div class="diag-label">E2. Resiko Infeksi b/d:</div>
                <label class="cb-item"><input type="checkbox" v-model="form.e_ri_trauma_post" /> Trauma post op</label>
                <label class="cb-item"><input type="checkbox" v-model="form.e_ri_pemajanan_lingkungan" /> Pemajanan lingkungan</label>
                <label class="cb-item"><input type="checkbox" v-model="form.e_ri_pemajanan_peralatan" /> Pemajanan peralatan</label>
              </td>
              <td>
                <label class="cb-item"><input type="checkbox" v-model="form.e_ri_int_cuci_tangan" /> Cuci tangan</label>
                <label class="cb-item"><input type="checkbox" v-model="form.e_ri_int_desinfeksi" /> Desinfeksi</label>
                <label class="cb-item"><input type="checkbox" v-model="form.e_ri_int_kadaluarsa" /> Cek kadaluarsa</label>
                <label class="cb-item"><input type="checkbox" v-model="form.e_ri_int_sterilitas" /> Jaga sterilitas</label>
                <label class="cb-item"><input type="checkbox" v-model="form.e_ri_int_tutup_luka" /> Tutup luka</label>
              </td>
              <td>
                <label class="cb-item"><input type="checkbox" v-model="form.e_ri_eval_lingkungan_steril" /> Lingkungan steril</label>
              </td>
              <td>
                <div v-if="!sigEriCleared && form.e_ri_paraf" class="sig-mini-preview">
                  <img :src="form.e_ri_paraf" class="img-ttd-mini" />
                </div>
                <VueSignaturePad v-else ref="sig_eri" :options="sigOption" class="sig-mini-box" />
                <div class="sig-mini-actions">
                  <button type="button" @click="saveSigEri" class="btn-sign-save btn-sm-ttd">Simpan</button>
                  <button type="button" @click="clearSigEri" class="btn-sign-clear btn-sm-ttd">Hapus</button>
                </div>
                <input type="text" v-model="form.e_ri_nama" class="form-control mt-1" placeholder="Nama..." style="font-size:12px;padding:3px 6px;" />
              </td>
            </tr>
            <!-- E3: Resiko suhu -->
            <tr>
              <td>
                <div class="diag-label">E3. Resiko Perubahan Suhu Tubuh b/d:</div>
                <label class="cb-item"><input type="checkbox" v-model="form.e_rs_suhu_rendah" /> Suhu rendah lingkungan</label>
                <label class="cb-item"><input type="checkbox" v-model="form.e_rs_penggunaan_obat" /> Penggunaan obat</label>
                <label class="cb-item"><input type="checkbox" v-model="form.e_rs_dehidrasi" /> Dehidrasi</label>
              </td>
              <td>
                <label class="cb-item"><input type="checkbox" v-model="form.e_rs_int_catat_suhu" /> Catat suhu</label>
                <label class="cb-item"><input type="checkbox" v-model="form.e_rs_int_kaji_suhu" /> Kaji suhu tiap 15'</label>
                <label class="cb-item"><input type="checkbox" v-model="form.e_rs_int_kolaborasi_obat" /> Kolaborasi obat</label>
              </td>
              <td>
                <label class="cb-item"><input type="checkbox" v-model="form.e_rs_eval_dingin_berkurang" /> Dingin berkurang</label>
                <label class="cb-item"><input type="checkbox" v-model="form.e_rs_eval_tidak_menggigil" /> Tidak menggigil</label>
                <div class="mt-1">
                  <label style="font-size:12px;">Suhu:</label>
                  <input type="text" v-model="form.e_rs_eval_suhu" class="form-control" style="font-size:12px;padding:3px 6px;" />
                </div>
              </td>
              <td><span style="font-size:12px;color:#aaa;">—</span></td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- SECTION F: TTD PERAWAT PASCA OPERASI -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">F. Tanda Tangan Perawat (Pasca Operasi)</h5>
        <div class="row">
          <div class="col-md-4">
            <div class="sign-box">
              <label class="fw-bold text-center" style="display:block;">Perawat Instrumen</label>
              <div v-if="!sigFInstrumenCleared && form.f_ttd_perawat_instrumen" class="signature-preview">
                <img :src="form.f_ttd_perawat_instrumen" class="img-ttd" />
              </div>
              <VueSignaturePad v-else ref="sig_f_instrumen" :options="sigOption" class="signature-box-ttd" />
              <div class="sign-actions mt-1">
                <button type="button" @click="saveSigFInstrumen" class="btn-sign-save">Simpan TTD</button>
                <button type="button" @click="clearSigFInstrumen" class="btn-sign-clear">Hapus</button>
              </div>
              <div class="mt-2">
                <label>Nama:</label>
                <input type="text" v-model="form.f_nama_perawat_instrumen" class="form-control" />
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="sign-box">
              <label class="fw-bold text-center" style="display:block;">Perawat Sirkuler</label>
              <div v-if="!sigFSirkulerCleared && form.f_ttd_perawat_sirkuler" class="signature-preview">
                <img :src="form.f_ttd_perawat_sirkuler" class="img-ttd" />
              </div>
              <VueSignaturePad v-else ref="sig_f_sirkuler" :options="sigOption" class="signature-box-ttd" />
              <div class="sign-actions mt-1">
                <button type="button" @click="saveSigFSirkuler" class="btn-sign-save">Simpan TTD</button>
                <button type="button" @click="clearSigFSirkuler" class="btn-sign-clear">Hapus</button>
              </div>
              <div class="mt-2">
                <label>Nama:</label>
                <input type="text" v-model="form.f_nama_perawat_sirkuler" class="form-control" />
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="sign-box">
              <label class="fw-bold text-center" style="display:block;">Perawat Anestesi</label>
              <div v-if="!sigFAnestesiCleared && form.f_ttd_perawat_anestesi" class="signature-preview">
                <img :src="form.f_ttd_perawat_anestesi" class="img-ttd" />
              </div>
              <VueSignaturePad v-else ref="sig_f_anestesi" :options="sigOption" class="signature-box-ttd" />
              <div class="sign-actions mt-1">
                <button type="button" @click="saveSigFAnestesi" class="btn-sign-save">Simpan TTD</button>
                <button type="button" @click="clearSigFAnestesi" class="btn-sign-clear">Hapus</button>
              </div>
              <div class="mt-2">
                <label>Nama:</label>
                <input type="text" v-model="form.f_nama_perawat_anestesi" class="form-control" />
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- SUBMIT -->
      <div class="action-footer">
        <button type="button" @click="$emit('back')" class="btn-cancel">Batal</button>
        <button
          type="button"
          @click="submitForm"
          :disabled="loadingSubmit || disabledSubmit"
          class="btn-save-form"
        >
          {{ loadingSubmit ? 'Menyimpan...' : (isEditMode ? 'Update Data' : 'Simpan Data') }}
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import { VueSignaturePad } from 'vue-signature-pad';

export default {
  name: 'FormCatatanKeperawatanOperasi',
  components: { VueSignaturePad },

  props: {
    selectedPatient: { type: Object, default: null },
    editData:        { type: [Object, String], default: null },
    viewData:        { type: Boolean, default: false },
  },

  emits: ['back'],

  data() {
    return {
      isEditMode:               false,
      loadingData:              false,
      loadingSubmit:            false,
      disabledSubmit:           true,
      signatureDokterCleared:   true,
      signatureInstrumenCleared: true,
      signatureSirkulerCleared: true,
      sigCgnCleared: true, sigCrcCleared: true, sigCrdCleared: true, sigCriCleared: true,
      sigEriCleared: true,
      sigFInstrumenCleared: true, sigFSirkulerCleared: true, sigFAnestesiCleared: true,
      sigOption: { penColor: 'black', backgroundColor: 'white' },

      form: {
        uuid: '', uuid_pasien: '',
        no_rm: '', no_surat: '', jenis_kelamin: '', nama: '', nik: '', tanggal_lahir: '',

        // Waktu
        jam_mulai: '', jam_selesai: '',
        jam_anestesi_mulai: '', jam_anestesi_selesai: '',
        jam_pembedahan_mulai: '', jam_pembedahan_selesai: '',

        // 1. Tipe
        tipe_elektif: false, tipe_darurat: false, tipe_rawat_jalan: false,

        // 2. Biusan
        biusan_umum: false, biusan_lokal: false, biusan_regional: false,

        // 3. Kesadaran
        kesadaran_terjaga: false, kesadaran_mudah_dibangunkan: false, kesadaran_lainnya: '',

        // 4. Emosi
        emosi_rileks: false, emosi_gelisah: false, emosi_tidak_ada_respon: false,

        // 5. Canul
        canul_tangan: false, canul_kaki: false, canul_cvp: false, canul_lainnya: '',

        // 6. Jenis operasi
        jenis_op_bersih: false, jenis_op_terkontaminasi: false,
        jenis_op_bersih_terkontaminasi: false, jenis_op_kotor_infeksi: false,

        // 7. Posisi
        posisi_supine: false, posisi_prone: false, posisi_lithotomi: false,
        posisi_kidney: false, posisi_lateral: false,
        posisi_lainnya: '', posisi_diawasi_oleh: '',

        // 8. Selengantangan
        selengantangan_adduksi: false, selengantangan_abduksi: false, selengantangan_lainnya: '',

        // 9. Urine
        urine_ya: false, urine_tidak: false, urine_ok: false, urine_ruangan: false,
        urine_dipasang_oleh: '', urine_jenis: '',

        // 10. Desinfeksi
        desinfeksi_iodium: false, desinfeksi_alkohol: false,
        desinfeksi_povidone: false, desinfeksi_chlorhexidine: false,

        // 11. Insisi
        insisi_pfannenstiel: false, insisi_lainnya: '',

        // 12. Alat
        alat_hand_rest: false, alat_lithotomi_support: false,
        alat_lateral_support: false, alat_chest_support: false,
        alat_heat_frame: false, alat_lainnya: '',

        // 13. Diatermi
        diatermi_ya: false, diatermi_tidak: false,
        diatermi_monopolar: false, diatermi_bipolar: false,
        diatermi_netral_bokong: false, diatermi_netral_tungkai_atas: false,
        diatermi_netral_tungkai_bawah: false, diatermi_netral_punggung: false,
        diatermi_netral_bahu: false, diatermi_dipasang_oleh: '',
        diatermi_kulit_sbl_utuh: false, diatermi_kulit_sbl_bulosa: false,
        diatermi_kulit_sbl_eritema: false, diatermi_kulit_sbl_luka_bakar: false,
        diatermi_kulit_ssd_utuh: false, diatermi_kulit_ssd_bulosa: false,
        diatermi_kulit_ssd_eritema: false, diatermi_kulit_ssd_luka_bakar: false,

        // 14. Warm Blanket
        warm_blanket_ya: false, warm_blanket_tidak: false,
        warm_blanket_jenis: '', warm_blanket_jam_mulai: '', warm_blanket_jam_selesai: '',

        // 15. Tourniquet
        tourniquet_ya: false, tourniquet_tidak: false, tourniquet_lokasi: '',
        tourniquet_lengan: false, tourniquet_lengan_jam_mulai: '',
        tourniquet_lengan_jam_selesai: '', tourniquet_lengan_td: '',
        tourniquet_dipasang_oleh: '',
        tourniquet_kaki: false, tourniquet_kaki_jam_mulai: '',
        tourniquet_kaki_jam_selesai: '', tourniquet_kaki_td: '',

        // 16. Implant
        implant_ya: false, implant_tidak: false, implant_jenis: '', implant_lokasi: '',

        // 17. Drain
        drain_ya: false, drain_tidak: false, drain_jenis: '', drain_lokasi: '',

        // 18. Irigasi
        irigasi_ya: false, irigasi_tidak: false, irigasi_nacl: false,
        irigasi_h2o2: false, irigasi_antibiotik: false, irigasi_lainnya: '',

        // 19. Tampon
        tampon_ya: false, tampon_tidak: false, tampon_lokasi: '', tampon_jumlah: '',

        // 20. Spesimen
        spesimen_histology: false, spesimen_histology_jenis: '',
        spesimen_kultur: false, spesimen_kultur_jenis: '',
        spesimen_cytologi: false, spesimen_cytologi_jenis: '',
        spesimen_frozen: false, spesimen_frozen_jenis: '',

        // 21. Cairan Infus (array)
        cairan_infus: [{ cairan: '', input: '', output: '', total: '' }],

        // 22–24
        kassa_sebelum: '', kassa_penambahan: '', kassa_setelah: '',
        jarum_sebelum: '', jarum_penambahan: '', jarum_setelah: '',
        bisturi_sebelum: '', bisturi_penambahan: '', bisturi_setelah: '',

        // Section B
        kasa_besar_persediaan: '', kasa_besar_terpakai: '', kasa_besar_sisa: '', kasa_besar_keterangan: '',
        kasa_persediaan: '', kasa_terpakai: '', kasa_sisa: '', kasa_keterangan: '',
        kasa_kacang_persediaan: '', kasa_kacang_terpakai: '', kasa_kacang_sisa: '', kasa_kacang_keterangan: '',
        kasa_tampon_persediaan: '', kasa_tampon_terpakai: '', kasa_tampon_sisa: '', kasa_tampon_keterangan: '',
        instrumen_persediaan: '', instrumen_terpakai: '', instrumen_sisa: '', instrumen_keterangan: '',
        jarum_atraumatik_persediaan: '', jarum_atraumatik_terpakai: '', jarum_atraumatik_sisa: '', jarum_atraumatik_keterangan: '',
        jarum_lepas_persediaan: '', jarum_lepas_terpakai: '', jarum_lepas_sisa: '', jarum_lepas_keterangan: '',
        selang_persediaan: '', selang_terpakai: '', selang_sisa: '', selang_keterangan: '',

        // TTD
        ttd_dokter_operator: '', nama_dokter_operator: '',
        ttd_perawat_instrumen: '', nama_perawat_instrumen: '',
        ttd_perawat_sirkuler: '', nama_perawat_sirkuler: '',

        // Section C - Diagnosa Intra Operasi
        // C1 Gangguan pola nafas
        c_gn_neuro_muskular: false, c_gn_penumpukan_sekret: false,
        c_gn_int_jalan_nafas: false, c_gn_int_hiperekstensi: false, c_gn_int_observasi_rr: false,
        c_gn_int_pantau_ttv: false, c_gn_int_suction: false, c_gn_int_o2: false, c_gn_int_obat: false,
        c_gn_eval_ttv_normal: false, c_gn_eval_nafas_spontan: false, c_gn_eval_sianosis: false,
        c_gn_eval_o2_value: '', c_gn_eval_observasi_ruangan: false,
        c_gn_paraf: '', c_gn_nama: '',
        // C2 Resiko kekurangan cairan
        c_rc_pembatasan_intake: false, c_rc_hilang_cairan: false, c_rc_pengeluaran_integritas: false,
        c_rc_int_ukur_io: false, c_rc_int_pantau_ttv: false, c_rc_int_mual_muntah: false,
        c_rc_int_periksa_pembalut: false, c_rc_int_pantau_suhu: false,
        c_rc_eval_ttv_normal: false, c_rc_eval_input: '', c_rc_eval_output: '',
        c_rc_eval_mukosa_lembab: false, c_rc_eval_turgor_elastis: false,
        c_rc_paraf: '', c_rc_nama: '',
        // C3 Resiko cedera
        c_rd_pemajanan_peralatan: false, c_rd_hipoksia_jaringan: false,
        c_rd_int_lepas_gigi: false, c_rd_int_periksa_identitas: false, c_rd_int_brankar: false,
        c_rd_int_sabuk: false, c_rd_int_peralatan_posisi: false, c_rd_int_keamanan_elektrikal: false,
        c_rd_int_plate_diatermi: false, c_rd_int_pantau_io: false, c_rd_int_catat_kassa: false,
        c_rd_eval_posisi: false, c_rd_eval_alat_elektro: false, c_rd_eval_kassa: false,
        c_rd_paraf: '', c_rd_nama: '',
        // C4 Resiko infeksi intra
        c_ri_trauma_post: false, c_ri_pemajanan_lingkungan: false, c_ri_pemajanan_peralatan: false,
        c_ri_int_cuci_tangan: false, c_ri_int_desinfeksi: false, c_ri_int_kadaluarsa: false,
        c_ri_int_sterilitas: false, c_ri_int_tutup_luka: false,
        c_ri_eval_lingkungan_steril: false,
        c_ri_paraf: '', c_ri_nama: '',

        // Section D - Pengkajian Pasca Operasi
        d_ruang_pemulihan_ya: false, d_ruang_pemulihan_tidak: false,
        d_masuk_jam: '', d_keluar_jam: '',
        d_kembali_ruangan: false, d_kembali_icu: false, d_kembali_lainnya: '',
        d_keadaan_baik: false, d_keadaan_sedang: false, d_keadaan_buruk: false,
        d_kesadaran_cm: false, d_kesadaran_apatis: false, d_kesadaran_somnolen: false,
        d_kesadaran_sopor: false, d_kesadaran_koma: false,
        d_kulit_datang_kering: false, d_kulit_datang_merah_muda: false, d_kulit_datang_hangat: false,
        d_kulit_keluar_kering: false, d_kulit_keluar_merah_muda: false, d_kulit_keluar_hangat: false,
        d_sirkulasi_merah_muda: false, d_sirkulasi_kebiruan: false,
        d_posisi_lateral: false, d_posisi_datar: false, d_posisi_head_up: false, d_posisi_semi_fowler: false,
        d_perdarahan_ya: false, d_perdarahan_cc: '', d_perdarahan_tidak: false, d_perdarahan_lokasi: '',
        d_muntah_ya: false, d_muntah_tidak: false,
        d_mukosa_lembab: false, d_mukosa_kering: false,
        d_jaringan_pa_ya: false, d_jaringan_pa_tidak: false, d_jaringan_pa_k_bedah: false,
        d_jaringan_pa_ruangan: false, d_jaringan_pa_jumlah: '',
        d_nyeri_ya: false, d_nyeri_tidak: false,
        d_jatuh_ringan: false, d_jatuh_sedang: false, d_jatuh_tinggi: false,
        d_nadi_teratur_masuk: false, d_nadi_teratur_keluar: false,
        d_nadi_tidak_teratur_masuk: false, d_nadi_tidak_teratur_keluar: false,
        d_nadi_lemah_masuk: false, d_nadi_lemah_keluar: false,
        d_nadi_takikardia_masuk: false, d_nadi_takikardia_keluar: false,
        d_nadi_normal_masuk: false, d_nadi_normal_keluar: false,
        d_nafas_teratur_masuk: false, d_nafas_teratur_keluar: false,
        d_nafas_tidak_teratur_masuk: false, d_nafas_tidak_teratur_keluar: false,
        d_nafas_dangkal_masuk: false, d_nafas_dangkal_keluar: false,
        d_nafas_dalam_masuk: false, d_nafas_dalam_keluar: false,
        d_nafas_sukar_masuk: false, d_nafas_sukar_keluar: false,

        // Section E - Diagnosa Pasca Operasi
        // E1 Nyeri akut
        e_na_gangguan_kulit: false, e_na_selang_drain: false,
        e_na_int_kaji_lokasi: false, e_na_int_kaji_ttv: false,
        e_na_int_atur_posisi: false, e_na_int_relaksasi: false,
        e_na_eval_ttv_normal: false, e_na_eval_nyeri_terkontrol: false,
        e_na_eval_nyeri_berkurang: false, e_na_eval_observasi_ruangan: false,
        // E2 Resiko infeksi pasca
        e_ri_trauma_post: false, e_ri_pemajanan_lingkungan: false, e_ri_pemajanan_peralatan: false,
        e_ri_int_cuci_tangan: false, e_ri_int_desinfeksi: false, e_ri_int_kadaluarsa: false,
        e_ri_int_sterilitas: false, e_ri_int_tutup_luka: false,
        e_ri_eval_lingkungan_steril: false,
        e_ri_paraf: '', e_ri_nama: '',
        // E3 Resiko suhu
        e_rs_suhu_rendah: false, e_rs_penggunaan_obat: false, e_rs_dehidrasi: false,
        e_rs_int_catat_suhu: false, e_rs_int_kaji_suhu: false, e_rs_int_kolaborasi_obat: false,
        e_rs_eval_dingin_berkurang: false, e_rs_eval_tidak_menggigil: false, e_rs_eval_suhu: '',

        // Section F - TTD Pasca Operasi
        f_ttd_perawat_instrumen: '', f_nama_perawat_instrumen: '',
        f_ttd_perawat_sirkuler: '', f_nama_perawat_sirkuler: '',
        f_ttd_perawat_anestesi: '', f_nama_perawat_anestesi: '',
      },
    };
  },

  watch: {
    selectedPatient: {
      immediate: true,
      handler(v) { if (v && !this.isEditMode) this.setDataForm(); },
    },
    editData: {
      immediate: true,
      handler(v) { if (v) this.loadEditData(); },
    },
  },

  async mounted() {
    await this.fetchTahunAkreditasi();
    this.disabledSubmit = false;
    if (this.viewData) {
      this.disabledSubmit = true;
      this.loadEditData();
    } else if (this.editData) {
      this.loadEditData();
    } else {
      this.setDataForm();
    }
  },

  methods: {
    async fetchTahunAkreditasi() {
      try {
        const res = await axios.get('/api/tahun-akreditasi');
        const tahun = res.data.tahun || '22';
        if (!this.form.no_surat) this.form.no_surat = `RM 4.6/CKIDPO/${tahun}`;
      } catch {
        if (!this.form.no_surat) this.form.no_surat = 'RM 4.6/CKIDPO/22';
      }
    },

    setDataForm() {
      this.form.uuid_pasien   = this.selectedPatient?.uuid          || '';
      this.form.no_rm         = this.selectedPatient?.rekam_medis   || '';
      this.form.jenis_kelamin = this.selectedPatient?.jenis_kelamin || '';
      this.form.nama          = this.selectedPatient?.nama          || '';
      this.form.nik           = this.selectedPatient?.no_identitas  || '';
      if (this.selectedPatient?.tanggal_lahir)
        this.form.tanggal_lahir = this.formatDate(new Date(this.selectedPatient.tanggal_lahir));
    },

    async loadEditData() {
      this.loadingData = true;
      this.isEditMode  = true;
      try {
        let data = null;
        if (typeof this.editData === 'string') {
          const res = await axios.get(
            `/master/rekammedis/lampiran/${this.editData}?type=dokumen_catatan_keperawatan_operasi`
          );
          data = res.data.data;
        } else {
          data = this.editData;
        }

        if (data) {
          Object.keys(this.form).forEach(k => {
            if (data[k] !== undefined && data[k] !== null) this.form[k] = data[k];
          });

          if (data.tanggal_lahir)
            this.form.tanggal_lahir = this.formatDate(new Date(data.tanggal_lahir));

          // Restore cairan_infus
          if (data.cairan_infus) {
            this.form.cairan_infus = typeof data.cairan_infus === 'string'
              ? JSON.parse(data.cairan_infus)
              : data.cairan_infus;
          }
          if (!this.form.cairan_infus || !this.form.cairan_infus.length) {
            this.form.cairan_infus = [{ cairan: '', input: '', output: '', total: '' }];
          }

          // Restore TTD pads
          this.$nextTick(() => {
            if (data.ttd_dokter_operator)      this.signatureDokterCleared   = false;
            if (data.ttd_perawat_instrumen)    this.signatureInstrumenCleared = false;
            if (data.ttd_perawat_sirkuler)     this.signatureSirkulerCleared  = false;
            if (data.c_gn_paraf)               this.sigCgnCleared   = false;
            if (data.c_rc_paraf)               this.sigCrcCleared   = false;
            if (data.c_rd_paraf)               this.sigCrdCleared   = false;
            if (data.c_ri_paraf)               this.sigCriCleared   = false;
            if (data.e_ri_paraf)               this.sigEriCleared   = false;
            if (data.f_ttd_perawat_instrumen)  this.sigFInstrumenCleared = false;
            if (data.f_ttd_perawat_sirkuler)   this.sigFSirkulerCleared  = false;
            if (data.f_ttd_perawat_anestesi)   this.sigFAnestesiCleared  = false;
          });
        }
      } catch (e) {
        console.error('Error loading edit data:', e);
        alert('Gagal memuat data!');
        this.$emit('back');
      } finally {
        this.loadingData = false;
      }
    },

    formatDate(date) {
      if (!date) return '';
      return new Date(date).toISOString().split('T')[0];
    },

    // ── Cairan Infus ──────────────────────────────────────────────────────────
    addCairan() {
      this.form.cairan_infus.push({ cairan: '', input: '', output: '', total: '' });
    },
    removeCairan(idx) {
      this.form.cairan_infus.splice(idx, 1);
      if (!this.form.cairan_infus.length) {
        this.form.cairan_infus = [{ cairan: '', input: '', output: '', total: '' }];
      }
    },

    // ── TTD Dokter Operator ───────────────────────────────────────────────────
    saveTtdDokter() {
      const pad = this.$refs.ttd_dokter;
      if (!pad) return;
      const { isEmpty, data } = pad.saveSignature();
      if (isEmpty) { alert('Tanda tangan Dokter Operator masih kosong!'); return; }
      this.form.ttd_dokter_operator  = data;
      this.signatureDokterCleared    = false;
    },
    clearTtdDokter() {
      this.signatureDokterCleared   = true;
      this.form.ttd_dokter_operator = '';
      this.$nextTick(() => {
        const pad = this.$refs.ttd_dokter;
        if (pad) pad.clearSignature();
      });
    },

    // ── TTD Perawat Instrumen ─────────────────────────────────────────────────
    saveTtdInstrumen() {
      const pad = this.$refs.ttd_instrumen;
      if (!pad) return;
      const { isEmpty, data } = pad.saveSignature();
      if (isEmpty) { alert('Tanda tangan Perawat Instrumen masih kosong!'); return; }
      this.form.ttd_perawat_instrumen  = data;
      this.signatureInstrumenCleared   = false;
    },
    clearTtdInstrumen() {
      this.signatureInstrumenCleared    = true;
      this.form.ttd_perawat_instrumen   = '';
      this.$nextTick(() => {
        const pad = this.$refs.ttd_instrumen;
        if (pad) pad.clearSignature();
      });
    },

    // ── TTD Perawat Sirkuler ──────────────────────────────────────────────────
    saveTtdSirkuler() {
      const pad = this.$refs.ttd_sirkuler;
      if (!pad) return;
      const { isEmpty, data } = pad.saveSignature();
      if (isEmpty) { alert('Tanda tangan Perawat Sirkuler masih kosong!'); return; }
      this.form.ttd_perawat_sirkuler  = data;
      this.signatureSirkulerCleared   = false;
    },
    clearTtdSirkuler() {
      this.signatureSirkulerCleared    = true;
      this.form.ttd_perawat_sirkuler   = '';
      this.$nextTick(() => {
        const pad = this.$refs.ttd_sirkuler;
        if (pad) pad.clearSignature();
      });
    },

    // ── Section C paraf signatures ─────────────────────────────────────────────
    saveSigCgn() {
      const pad = this.$refs.sig_cgn; if (!pad) return;
      const { isEmpty, data } = pad.saveSignature();
      if (isEmpty) { alert('Tanda tangan C1 masih kosong!'); return; }
      this.form.c_gn_paraf = data; this.sigCgnCleared = false;
    },
    clearSigCgn() {
      this.sigCgnCleared = true; this.form.c_gn_paraf = '';
      this.$nextTick(() => { const p = this.$refs.sig_cgn; if (p) p.clearSignature(); });
    },
    saveSigCrc() {
      const pad = this.$refs.sig_crc; if (!pad) return;
      const { isEmpty, data } = pad.saveSignature();
      if (isEmpty) { alert('Tanda tangan C2 masih kosong!'); return; }
      this.form.c_rc_paraf = data; this.sigCrcCleared = false;
    },
    clearSigCrc() {
      this.sigCrcCleared = true; this.form.c_rc_paraf = '';
      this.$nextTick(() => { const p = this.$refs.sig_crc; if (p) p.clearSignature(); });
    },
    saveSigCrd() {
      const pad = this.$refs.sig_crd; if (!pad) return;
      const { isEmpty, data } = pad.saveSignature();
      if (isEmpty) { alert('Tanda tangan C3 masih kosong!'); return; }
      this.form.c_rd_paraf = data; this.sigCrdCleared = false;
    },
    clearSigCrd() {
      this.sigCrdCleared = true; this.form.c_rd_paraf = '';
      this.$nextTick(() => { const p = this.$refs.sig_crd; if (p) p.clearSignature(); });
    },
    saveSigCri() {
      const pad = this.$refs.sig_cri; if (!pad) return;
      const { isEmpty, data } = pad.saveSignature();
      if (isEmpty) { alert('Tanda tangan C4 masih kosong!'); return; }
      this.form.c_ri_paraf = data; this.sigCriCleared = false;
    },
    clearSigCri() {
      this.sigCriCleared = true; this.form.c_ri_paraf = '';
      this.$nextTick(() => { const p = this.$refs.sig_cri; if (p) p.clearSignature(); });
    },

    // ── Section E paraf signature ─────────────────────────────────────────────
    saveSigEri() {
      const pad = this.$refs.sig_eri; if (!pad) return;
      const { isEmpty, data } = pad.saveSignature();
      if (isEmpty) { alert('Tanda tangan E2 masih kosong!'); return; }
      this.form.e_ri_paraf = data; this.sigEriCleared = false;
    },
    clearSigEri() {
      this.sigEriCleared = true; this.form.e_ri_paraf = '';
      this.$nextTick(() => { const p = this.$refs.sig_eri; if (p) p.clearSignature(); });
    },

    // ── Section F TTD signatures ──────────────────────────────────────────────
    saveSigFInstrumen() {
      const pad = this.$refs.sig_f_instrumen; if (!pad) return;
      const { isEmpty, data } = pad.saveSignature();
      if (isEmpty) { alert('Tanda tangan Perawat Instrumen masih kosong!'); return; }
      this.form.f_ttd_perawat_instrumen = data; this.sigFInstrumenCleared = false;
    },
    clearSigFInstrumen() {
      this.sigFInstrumenCleared = true; this.form.f_ttd_perawat_instrumen = '';
      this.$nextTick(() => { const p = this.$refs.sig_f_instrumen; if (p) p.clearSignature(); });
    },
    saveSigFSirkuler() {
      const pad = this.$refs.sig_f_sirkuler; if (!pad) return;
      const { isEmpty, data } = pad.saveSignature();
      if (isEmpty) { alert('Tanda tangan Perawat Sirkuler masih kosong!'); return; }
      this.form.f_ttd_perawat_sirkuler = data; this.sigFSirkulerCleared = false;
    },
    clearSigFSirkuler() {
      this.sigFSirkulerCleared = true; this.form.f_ttd_perawat_sirkuler = '';
      this.$nextTick(() => { const p = this.$refs.sig_f_sirkuler; if (p) p.clearSignature(); });
    },
    saveSigFAnestesi() {
      const pad = this.$refs.sig_f_anestesi; if (!pad) return;
      const { isEmpty, data } = pad.saveSignature();
      if (isEmpty) { alert('Tanda tangan Perawat Anestesi masih kosong!'); return; }
      this.form.f_ttd_perawat_anestesi = data; this.sigFAnestesiCleared = false;
    },
    clearSigFAnestesi() {
      this.sigFAnestesiCleared = true; this.form.f_ttd_perawat_anestesi = '';
      this.$nextTick(() => { const p = this.$refs.sig_f_anestesi; if (p) p.clearSignature(); });
    },

    async submitForm() {
      this.loadingSubmit = true;
      try {
        const fd = new FormData();
        Object.keys(this.form).forEach(k => {
          if (k === 'cairan_infus') {
            fd.append(k, JSON.stringify(this.form[k]));
          } else {
            fd.append(k, this.form[k] !== null && this.form[k] !== undefined ? this.form[k] : '');
          }
        });

        await axios.post('/master/pasien/dokumen-catatan-keperawatan-operasi', fd, {
          headers: { 'Content-Type': 'multipart/form-data' },
        });

        alert(this.isEditMode
          ? 'Catatan Keperawatan Operasi berhasil diupdate!'
          : 'Catatan Keperawatan Operasi berhasil disimpan!');
        this.$emit('back');
      } catch (e) {
        console.error('ERROR:', e.response?.data || e);
        alert('Gagal menyimpan data!');
      } finally {
        this.loadingSubmit = false;
      }
    },
  },
};
</script>

<style scoped>
.container { max-width: 1100px; margin: 0 auto; padding: 20px; }
.py-4 { padding-top: 1.5rem; padding-bottom: 1.5rem; }
.fw-bold { font-weight: 700; }
.text-uppercase { text-transform: uppercase; }
.text-center { text-align: center; }
.text-center h2 { font-size: 18px; margin-bottom: 10px; }
.text-center h3 { font-size: 16px; margin-top: 10px; margin-bottom: 4px; }
hr { margin: 20px 0; }
.logo-rs { display: block; margin: 0 auto 15px; }
.badge { display: inline-block; padding: 6px 14px; border-radius: 20px; font-size: 13px; font-weight: bold; margin-top: 10px; }
.badge.bg-warning { background: #ff9800; color: white; }

.box-rme { border: 1px solid #dcdcdc; padding: 20px; border-radius: 6px; background: #fafafa; margin-bottom: 20px; }
.section-title-rme { font-weight: bold; margin-bottom: 15px; color: #2d74b7; font-size: 16px; border-bottom: 2px solid #2d74b7; padding-bottom: 8px; }

label { display: block; margin-bottom: 5px; font-weight: 500; color: #555; font-size: 14px; }
.input-rme { width: 100%; border: 1px solid #ccc; border-radius: 4px; padding: 10px 12px; background: #fff; font-size: 14px; box-sizing: border-box; }
.input-rme[readonly] { background: #f5f5f5; cursor: not-allowed; color: #666; }
.form-control { width: 100%; padding: 8px 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 14px; box-sizing: border-box; }
.form-control:focus { outline: none; border-color: #2d74b7; }
.input-inline { border: none; border-bottom: 1px solid #999; padding: 2px 6px; width: 150px; font-size: 14px; }

.checkbox-group { display: flex; gap: 16px; flex-wrap: wrap; padding: 10px; background: white; border-radius: 4px; border: 1px solid #e0e0e0; align-items: center; }
.cb-item { display: flex; align-items: center; gap: 6px; font-weight: normal; color: #333; font-size: 14px; cursor: pointer; margin: 0; }
.cb-item input[type=checkbox] { width: 16px; height: 16px; cursor: pointer; flex-shrink: 0; }
.cb-item-text { display: flex; align-items: center; gap: 8px; font-size: 14px; color: #333; }

.flex-wrap { flex-wrap: wrap; }
.item-row { padding-bottom: 8px; border-bottom: 1px solid #f0f0f0; }
.checkbox-row { display: flex; flex-direction: column; }

.row { display: flex; flex-wrap: wrap; margin: 0 -8px; }
.mb-1 { margin-bottom: 5px; }
.mb-2 { margin-bottom: 10px; }
.mb-3 { margin-bottom: 15px; }
.mb-4 { margin-bottom: 20px; }
.mt-1 { margin-top: 8px; }
.mt-2 { margin-top: 12px; }
.col-md-3, .col-md-4, .col-md-6, .col-md-12 { padding: 0 8px; margin-bottom: 12px; box-sizing: border-box; }
.col-md-3  { flex: 0 0 25%;  max-width: 25%; }
.col-md-4  { flex: 0 0 33.333%; max-width: 33.333%; }
.col-md-6  { flex: 0 0 50%;  max-width: 50%; }
.col-md-12 { flex: 0 0 100%; max-width: 100%; }

/* Cairan Infus Table */
.cairan-table { width: 100%; border-collapse: collapse; }
.cairan-table th, .cairan-table td { border: 1px solid #ccc; padding: 6px 8px; }
.cairan-table th { background: #f0f4f8; font-weight: bold; font-size: 13px; text-align: center; }
.cairan-table td .form-control { border: none; padding: 4px; }

.btn-add-row { background: #2d74b7; color: white; padding: 6px 14px; border: none; border-radius: 4px; cursor: pointer; font-size: 13px; }
.btn-add-row:hover { background: #1e5fa3; }
.btn-remove-row { background: #e53935; color: white; border: none; border-radius: 4px; padding: 4px 8px; cursor: pointer; font-size: 12px; }

/* Instrumen Table */
.instrumen-table { width: 100%; border-collapse: collapse; }
.instrumen-table th, .instrumen-table td { border: 1px solid #ccc; padding: 6px 8px; }
.instrumen-table th { background: #f0f4f8; font-weight: bold; font-size: 13px; text-align: center; }
.instrumen-table td .form-control { border: none; padding: 4px; }
.instrumen-table td:first-child { min-width: 140px; }

/* Count Table */
.count-table { width: 100%; border-collapse: collapse; }
.count-table th, .count-table td { border: 1px solid #ccc; padding: 6px 8px; }
.count-table th { background: #f0f4f8; font-weight: bold; font-size: 13px; text-align: center; }
.count-table td .form-control { border: none; padding: 4px; max-width: 80px; }

/* TTD */
.sign-box { border: 1px solid #ddd; border-radius: 6px; padding: 12px; background: white; }
.signature-box-ttd { width: 100%; height: 140px; border: 2px solid #999; background: white; border-radius: 4px; }
.signature-preview { border: 2px solid #999; background: white; padding: 4px; border-radius: 4px; text-align: center; min-height: 140px; display: flex; align-items: center; justify-content: center; }
.img-ttd { max-width: 100%; max-height: 130px; object-fit: contain; }
.sign-actions { display: flex; gap: 8px; }
.btn-sign-save { background: #388e3c; color: white; padding: 6px 12px; border: none; border-radius: 4px; cursor: pointer; font-size: 13px; }
.btn-sign-save:hover { background: #2e7d32; }
.btn-sign-clear { background: #c62828; color: white; padding: 6px 12px; border: none; border-radius: 4px; cursor: pointer; font-size: 13px; }
.btn-sign-clear:hover { background: #b71c1c; }

.action-footer { margin-top: 30px; display: flex; justify-content: flex-end; gap: 12px; padding: 20px 0; border-top: 1px solid #e0e0e0; }
.btn-save-form { background: #0288d1; color: white; padding: 12px 30px; border: none; border-radius: 4px; font-weight: bold; cursor: pointer; font-size: 16px; }
.btn-save-form:hover { background: #0277bd; }
.btn-save-form:disabled { background: #b0bec5; cursor: not-allowed; }
.btn-cancel { background: #e0e0e0; color: #333; padding: 12px 24px; border: none; border-radius: 4px; font-weight: bold; cursor: pointer; font-size: 16px; }
.btn-cancel:hover { background: #bdbdbd; }

.view-overlay { position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(255,255,255,0.5); z-index: 10; cursor: not-allowed; border-radius: 6px; }
.loading-overlay { position: fixed; top: 50%; left: 50%; transform: translate(-50%,-50%); background: rgba(255,255,255,0.95); padding: 30px 40px; border-radius: 10px; box-shadow: 0 4px 20px rgba(0,0,0,0.2); text-align: center; z-index: 9999; }
.spinner-rme { width: 40px; height: 40px; border: 4px solid #ccc; border-top-color: #2d74b7; border-radius: 50%; animation: spin 0.8s linear infinite; margin: 0 auto 16px; }
@keyframes spin { to { transform: rotate(360deg); } }
.btn-back { background: #546e7a; color: white; padding: 8px 20px; border: none; border-radius: 4px; cursor: pointer; margin-bottom: 10px; font-size: 14px; }
.btn-back:hover { background: #455a64; }

/* Diagnosa Table (Section C & E) */
.diagnosa-table { width: 100%; border-collapse: collapse; }
.diagnosa-table th, .diagnosa-table td { border: 1px solid #ccc; padding: 8px; vertical-align: top; }
.diagnosa-table th { background: #f0f4f8; font-weight: bold; font-size: 13px; text-align: center; }
.diagnosa-table .cb-item { display: flex; align-items: flex-start; gap: 5px; font-size: 13px; color: #333; margin-bottom: 4px; font-weight: normal; cursor: pointer; }
.diagnosa-table .cb-item input[type=checkbox] { margin-top: 2px; flex-shrink: 0; }
.diag-label { font-weight: bold; font-size: 13px; margin-bottom: 6px; color: #2d74b7; }

/* Mini signature pad (inside table cells) */
.sig-mini-box { width: 100%; height: 80px; border: 1px solid #999; background: white; border-radius: 3px; }
.sig-mini-preview { border: 1px solid #999; background: white; padding: 3px; border-radius: 3px; min-height: 80px; display: flex; align-items: center; justify-content: center; }
.img-ttd-mini { max-width: 100%; max-height: 75px; object-fit: contain; }
.sig-mini-actions { display: flex; gap: 4px; margin-top: 3px; }
.btn-sm-ttd { padding: 3px 7px; font-size: 11px; border: none; border-radius: 3px; cursor: pointer; }

/* Nadi/Nafas Table (Section D) */
.nadi-table { width: 100%; border-collapse: collapse; }
.nadi-table th, .nadi-table td { border: 1px solid #ccc; padding: 5px 8px; font-size: 13px; }
.nadi-table th { background: #f0f4f8; font-weight: bold; text-align: center; }
.nadi-table .text-center { text-align: center; }
</style>
