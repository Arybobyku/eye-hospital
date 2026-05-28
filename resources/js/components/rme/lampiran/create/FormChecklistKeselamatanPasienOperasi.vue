<template>
  <div>
    <button @click="$emit('back')" class="btn-back">Kembali</button>

    <div class="container py-4">
      <div class="position-relative">
        <div v-if="disabledSubmit" class="view-overlay"></div>

        <!-- HEADER -->
        <div class="text-center mb-4">
          <h2 class="fw-bold">CHECKLIST KESELAMATAN PASIEN OPERASI</h2>
          <h4 class="fw-semibold">RM/4.9/CLKPO/22</h4>
        </div>

        <!-- INFORMASI PASIEN -->
        <div class="box-rme mb-4">
          <h5 class="section-title-rme">Informasi Pasien</h5>
          <div class="patient-grid">
            <div class="patient-item">
              <span class="patient-label">No. RM</span>
              <span class="patient-sep">:</span>
              <span class="patient-val">{{ form.no_rm || '-' }}</span>
            </div>
            <div class="patient-item">
              <span class="patient-label">NIK</span>
              <span class="patient-sep">:</span>
              <span class="patient-val">{{ form.nik || '-' }}</span>
            </div>
            <div class="patient-item">
              <span class="patient-label">Nama Pasien</span>
              <span class="patient-sep">:</span>
              <span class="patient-val">{{ form.nama || '-' }}</span>
            </div>
            <div class="patient-item">
              <span class="patient-label">Jenis Kelamin</span>
              <span class="patient-sep">:</span>
              <span class="patient-val">{{ form.jenis_kelamin || '-' }}</span>
            </div>
          </div>
        </div>

        <!-- 3 KOLOM UTAMA -->
        <div class="box-rme mb-4">
          <h5 class="section-title-rme">Checklist Keselamatan</h5>
          <div class="clkpo-grid">

            <!-- ====== SIGN IN ====== -->
            <div class="clkpo-col">
              <div class="clkpo-col-header">Sebelum Induksi Anestesi / Sign In</div>
              <div class="clkpo-col-body">

                <div class="field-row">
                  <label class="field-label">Waktu</label>
                  <input type="time" v-model="form.signin_waktu" class="input-table" :disabled="disabledSubmit" />
                </div>

                <div class="clkpo-note"><em>Minimal ada perawat, perawat Anestesi dan Dokter Anestesi</em></div>

                <div class="field-row">
                  <label class="field-label">Apakah identitas pasien sudah benar, rencana tindakan sudah jelas, dan ada persetujuan tindakan medis (informed consent)?</label>
                  <div class="radio-group">
                    <label class="radio-item"><input type="radio" v-model="form.signin_q1" value="Ya" :disabled="disabledSubmit"> Ya</label>
                    <label class="radio-item"><input type="radio" v-model="form.signin_q1" value="Tidak" :disabled="disabledSubmit"> Tidak</label>
                  </div>
                </div>

                <div class="field-row">
                  <label class="field-label">Apakah area yang akan dioperasi sudah diberi tanda?</label>
                  <div class="radio-group">
                    <label class="radio-item"><input type="radio" v-model="form.signin_q2" value="Ya" :disabled="disabledSubmit"> Ya</label>
                    <label class="radio-item"><input type="radio" v-model="form.signin_q2" value="Tidak" :disabled="disabledSubmit"> Tidak diperlukan</label>
                  </div>
                </div>

                <div class="field-row">
                  <label class="field-label">Apakah mesin anestesi dan obat-obatan sudah lengkap?</label>
                  <div class="radio-group">
                    <label class="radio-item"><input type="radio" v-model="form.signin_q3" value="Ya" :disabled="disabledSubmit"> Ya</label>
                    <label class="radio-item"><input type="radio" v-model="form.signin_q3" value="Tidak" :disabled="disabledSubmit"> Tidak</label>
                  </div>
                </div>

                <div class="field-row">
                  <label class="field-label">Apakah sudah terpasang <em>pulse oksimetri</em> pada pasien dan sudah berfungsi baik?</label>
                  <div class="radio-group">
                    <label class="radio-item"><input type="radio" v-model="form.signin_q4" value="Ya" :disabled="disabledSubmit"> Ya</label>
                    <label class="radio-item"><input type="radio" v-model="form.signin_q4" value="Tidak" :disabled="disabledSubmit"> Tidak</label>
                  </div>
                </div>

                <div class="field-row">
                  <label class="field-label">Apakah pasien memiliki riwayat alergi?</label>
                  <div class="radio-group">
                    <label class="radio-item"><input type="radio" v-model="form.signin_q5" value="Ya" :disabled="disabledSubmit"> Ya</label>
                    <label class="radio-item"><input type="radio" v-model="form.signin_q5" value="Tidak" :disabled="disabledSubmit"> Tidak</label>
                  </div>
                </div>

                <div class="field-row">
                  <label class="field-label">Apakah pasien memiliki gangguan pernapasan?</label>
                  <div class="radio-group">
                    <label class="radio-item"><input type="radio" v-model="form.signin_q6" value="Ya" :disabled="disabledSubmit"> Ya, dan alat/bantuan sudah tersedia</label>
                    <label class="radio-item"><input type="radio" v-model="form.signin_q6" value="Tidak" :disabled="disabledSubmit"> Tidak</label>
                  </div>
                </div>

                <div class="field-row">
                  <label class="field-label">Risiko perdarahan &gt; 500ml (7ml/kg bagi anak-anak)</label>
                  <div class="radio-group">
                    <label class="radio-item"><input type="radio" v-model="form.signin_q7" value="Ya" :disabled="disabledSubmit"> Ya, dan sudah direncanakan pemasangan infus 2 (<em>line</em>)</label>
                    <label class="radio-item"><input type="radio" v-model="form.signin_q7" value="Tidak" :disabled="disabledSubmit"> Tidak</label>
                  </div>
                </div>

                <!-- TTD Sign In -->
                <div style="margin-top:103%;" class="ttd-section">
                  <div class="ttd-title">Tanda Tangan</div>

                  <div class="ttd-card">
                    <div class="ttd-role">dr. Anestesi</div>
                    <div class="signature-cell">
                      <template v-if="form.signin_ttd_dr_anestesi && !ttdCleared.si_anestesi">
                        <img :src="form.signin_ttd_dr_anestesi" class="ttd-preview" />
                        <button v-if="!disabledSubmit" @click="clearSign('si_anestesi', 'signin_ttd_dr_anestesi')" class="btn-clear-mini" type="button">Hapus</button>
                      </template>
                      <template v-else-if="!disabledSubmit">
                        <VueSignaturePad ref="ttd_si_anestesi" :options="sigOption" class="signature-box-table" />
                        <button @click="saveSign('ttd_si_anestesi', 'si_anestesi', 'signin_ttd_dr_anestesi')" class="btn-save-mini" type="button">Simpan ✔</button>
                      </template>
                    </div>
                    <div class="dropdown-dokter mt-1">
                      <select v-model="form.signin_nama_dr_anestesi" class="form-select-dokter" :disabled="disabledSubmit">
                        <option value="" disabled>🩺 Pilih Dokter</option>
                        <option v-for="d in listDokter" :key="d.id" :value="d.nama">{{ d.nama }}</option>
                      </select>
                      <span class="dropdown-icon">▾</span>
                    </div>
                  </div>

                  <div class="ttd-card">
                    <div class="ttd-role">Perawat Anestesi</div>
                    <div class="signature-cell">
                      <template v-if="form.signin_ttd_perawat_anestesi && !ttdCleared.si_p_anestesi">
                        <img :src="form.signin_ttd_perawat_anestesi" class="ttd-preview" />
                        <button v-if="!disabledSubmit" @click="clearSign('si_p_anestesi', 'signin_ttd_perawat_anestesi')" class="btn-clear-mini" type="button">Hapus</button>
                      </template>
                      <template v-else-if="!disabledSubmit">
                        <VueSignaturePad ref="ttd_si_p_anestesi" :options="sigOption" class="signature-box-table" />
                        <button @click="saveSign('ttd_si_p_anestesi', 'si_p_anestesi', 'signin_ttd_perawat_anestesi')" class="btn-save-mini" type="button">Simpan ✔</button>
                      </template>
                    </div>
                    <input type="text" v-model="form.signin_nama_perawat_anestesi" class="input-table mt-1" placeholder="Nama perawat anestesi" :disabled="disabledSubmit" />
                  </div>

                  <div class="ttd-card">
                    <div class="ttd-role">Perawat</div>
                    <div class="signature-cell">
                      <template v-if="form.signin_ttd_perawat && !ttdCleared.si_perawat">
                        <img :src="form.signin_ttd_perawat" class="ttd-preview" />
                        <button v-if="!disabledSubmit" @click="clearSign('si_perawat', 'signin_ttd_perawat')" class="btn-clear-mini" type="button">Hapus</button>
                      </template>
                      <template v-else-if="!disabledSubmit">
                        <VueSignaturePad ref="ttd_si_perawat" :options="sigOption" class="signature-box-table" />
                        <button @click="saveSign('ttd_si_perawat', 'si_perawat', 'signin_ttd_perawat')" class="btn-save-mini" type="button">Simpan ✔</button>
                      </template>
                    </div>
                    <input type="text" v-model="form.signin_nama_perawat" class="input-table mt-1" placeholder="Nama perawat" :disabled="disabledSubmit" />
                  </div>
                </div>

              </div>
            </div>

            <!-- ====== TIME OUT ====== -->
            <div class="clkpo-col">
              <div class="clkpo-col-header">Sebelum Insisi / Time Out</div>
              <div class="clkpo-col-body">

                <div class="field-row">
                  <label class="field-label">Waktu</label>
                  <input type="time" v-model="form.timeout_waktu" class="input-table" :disabled="disabledSubmit" />
                </div>

                <div class="clkpo-note"><em>Dengan perawat, perawat Anestesi dan Dokter Anestesi</em></div>

                <div class="field-row">
                  <label class="field-label">Memastikan bahwa semua anggota tim medis sudah memperkenalkan diri (nama dan peran masing-masing)</label>
                  <div class="radio-group">
                    <label class="radio-item"><input type="radio" v-model="form.timeout_q1" value="Ya" :disabled="disabledSubmit"> Ya</label>
                    <label class="radio-item"><input type="radio" v-model="form.timeout_q1" value="Tidak" :disabled="disabledSubmit"> Tidak</label>
                  </div>
                </div>

                <div class="field-row">
                  <label class="field-label">Memastikan dan baca ulang nama pasien, tindakan medis dan area yang akan diinsisi</label>
                  <div class="radio-group">
                    <label class="radio-item"><input type="radio" v-model="form.timeout_q2" value="Ya" :disabled="disabledSubmit"> Ya</label>
                    <label class="radio-item"><input type="radio" v-model="form.timeout_q2" value="Tidak" :disabled="disabledSubmit"> Tidak</label>
                  </div>
                </div>

                <div class="field-row">
                  <label class="field-label">Apakah profilaksis antibiotik sudah diberikan 1 jam sebelumnya?</label>
                  <div class="radio-group">
                    <label class="radio-item"><input type="radio" v-model="form.timeout_q3" value="Ya" :disabled="disabledSubmit"> Ya</label>
                    <label class="radio-item"><input type="radio" v-model="form.timeout_q3" value="Tidak" :disabled="disabledSubmit"> Tidak perlu</label>
                  </div>
                </div>

                <div class="field-row">
                  <label class="field-label">Apakah tindakan berisiko atau tindakan tidak rutin yang akan dilakukan? <small>(Dokter Bedah)</small></label>
                  <textarea v-model="form.timeout_q4_tindakan_beresiko" class="input-table" rows="2" placeholder="Keterangan..." :disabled="disabledSubmit"></textarea>
                </div>

                <div class="field-row">
                  <label class="field-label">Berapa lama tindakan ini akan dikerjakan?</label>
                  <textarea v-model="form.timeout_q4_lama_tindakan" class="input-table" rows="2" placeholder="Keterangan..." :disabled="disabledSubmit"></textarea>
                </div>

                <div class="field-row">
                  <label class="field-label">Apakah sudah antisipasi perdarahan? <small>(Dokter Bedah)</small></label>
                  <div class="radio-group">
                    <label class="radio-item"><input type="radio" v-model="form.timeout_q4_antisipasi_perdarahan" value="Ya" :disabled="disabledSubmit"> Ya</label>
                    <label class="radio-item"><input type="radio" v-model="form.timeout_q4_antisipasi_perdarahan" value="Tidak" :disabled="disabledSubmit"> Tidak</label>
                  </div>
                </div>

                <div class="field-row">
                  <label class="field-label">Apakah ada hal khusus untuk pasien ini? <small>(Dokter Anestesi)</small></label>
                  <div class="radio-group">
                    <label class="radio-item"><input type="radio" v-model="form.timeout_q5" value="Ya" :disabled="disabledSubmit"> Ya</label>
                    <label class="radio-item"><input type="radio" v-model="form.timeout_q5" value="Tidak" :disabled="disabledSubmit"> Tidak</label>
                  </div>
                </div>

                <div class="field-row">
                  <label class="field-label">Apakah sudah dipastikan kesterilan peralatan? <small>(Tim Perawat)</small></label>
                  <div class="radio-group">
                    <label class="radio-item"><input type="radio" v-model="form.timeout_q6_kesterilan" value="Ya" :disabled="disabledSubmit"> Ya</label>
                    <label class="radio-item"><input type="radio" v-model="form.timeout_q6_kesterilan" value="Tidak" :disabled="disabledSubmit"> Tidak</label>
                  </div>
                </div>

                <div class="field-row">
                  <label class="field-label">Apakah alat implan yang dibutuhkan sudah disterilan?</label>
                  <div class="radio-group">
                    <label class="radio-item"><input type="radio" v-model="form.timeout_q6_implan" value="Ya" :disabled="disabledSubmit"> Ya</label>
                    <label class="radio-item"><input type="radio" v-model="form.timeout_q6_implan" value="Tidak" :disabled="disabledSubmit"> Tidak</label>
                  </div>
                </div>

                <div class="field-row">
                  <label class="field-label">Apakah ada masalah dengan peralatan yang dikhawatirkan?</label>
                  <div class="radio-group">
                    <label class="radio-item"><input type="radio" v-model="form.timeout_q6_masalah_alat" value="Ya" :disabled="disabledSubmit"> Ya</label>
                    <label class="radio-item"><input type="radio" v-model="form.timeout_q6_masalah_alat" value="Tidak" :disabled="disabledSubmit"> Tidak</label>
                  </div>
                </div>

                <div class="field-row">
                  <label class="field-label">Apakah hasil radiologi yang diperlukan sudah ada?</label>
                  <div class="radio-group">
                    <label class="radio-item"><input type="radio" v-model="form.timeout_q6_radiologi" value="Ya" :disabled="disabledSubmit"> Ya</label>
                    <label class="radio-item"><input type="radio" v-model="form.timeout_q6_radiologi" value="Tidak" :disabled="disabledSubmit"> Tidak</label>
                  </div>
                </div>

                <!-- TTD Time Out -->
                <div style="margin-top:35%;" class="ttd-section">
                  <div class="ttd-title">Tanda Tangan</div>

                  <div class="ttd-card">
                    <div class="ttd-role">dr. Anestesi</div>
                    <div class="signature-cell">
                      <template v-if="form.timeout_ttd_dr_anestesi && !ttdCleared.to_anestesi">
                        <img :src="form.timeout_ttd_dr_anestesi" class="ttd-preview" />
                        <button v-if="!disabledSubmit" @click="clearSign('to_anestesi', 'timeout_ttd_dr_anestesi')" class="btn-clear-mini" type="button">Hapus</button>
                      </template>
                      <template v-else-if="!disabledSubmit">
                        <VueSignaturePad ref="ttd_to_anestesi" :options="sigOption" class="signature-box-table" />
                        <button @click="saveSign('ttd_to_anestesi', 'to_anestesi', 'timeout_ttd_dr_anestesi')" class="btn-save-mini" type="button">Simpan ✔</button>
                      </template>
                    </div>
                    <div class="dropdown-dokter mt-1">
                      <select v-model="form.timeout_nama_dr_anestesi" class="form-select-dokter" :disabled="disabledSubmit">
                        <option value="" disabled>🩺 Pilih Dokter</option>
                        <option v-for="d in listDokter" :key="d.id" :value="d.nama">{{ d.nama }}</option>
                      </select>
                      <span class="dropdown-icon">▾</span>
                    </div>
                  </div>

                  <div class="ttd-card">
                    <div class="ttd-role">Perawat Anestesi</div>
                    <div class="signature-cell">
                      <template v-if="form.timeout_ttd_perawat_anestesi && !ttdCleared.to_p_anestesi">
                        <img :src="form.timeout_ttd_perawat_anestesi" class="ttd-preview" />
                        <button v-if="!disabledSubmit" @click="clearSign('to_p_anestesi', 'timeout_ttd_perawat_anestesi')" class="btn-clear-mini" type="button">Hapus</button>
                      </template>
                      <template v-else-if="!disabledSubmit">
                        <VueSignaturePad ref="ttd_to_p_anestesi" :options="sigOption" class="signature-box-table" />
                        <button @click="saveSign('ttd_to_p_anestesi', 'to_p_anestesi', 'timeout_ttd_perawat_anestesi')" class="btn-save-mini" type="button">Simpan ✔</button>
                      </template>
                    </div>
                    <input type="text" v-model="form.timeout_nama_perawat_anestesi" class="input-table mt-1" placeholder="Nama perawat anestesi" :disabled="disabledSubmit" />
                  </div>

                  <div class="ttd-card">
                    <div class="ttd-role">Perawat Sirkuler</div>
                    <div class="signature-cell">
                      <template v-if="form.timeout_ttd_perawat_sirkuler && !ttdCleared.to_sirkuler">
                        <img :src="form.timeout_ttd_perawat_sirkuler" class="ttd-preview" />
                        <button v-if="!disabledSubmit" @click="clearSign('to_sirkuler', 'timeout_ttd_perawat_sirkuler')" class="btn-clear-mini" type="button">Hapus</button>
                      </template>
                      <template v-else-if="!disabledSubmit">
                        <VueSignaturePad ref="ttd_to_sirkuler" :options="sigOption" class="signature-box-table" />
                        <button @click="saveSign('ttd_to_sirkuler', 'to_sirkuler', 'timeout_ttd_perawat_sirkuler')" class="btn-save-mini" type="button">Simpan ✔</button>
                      </template>
                    </div>
                    <input type="text" v-model="form.timeout_nama_perawat_sirkuler" class="input-table mt-1" placeholder="Nama perawat sirkuler" :disabled="disabledSubmit" />
                  </div>
                </div>

              </div>
            </div>

            <!-- ====== SIGN OUT ====== -->
            <div class="clkpo-col">
              <div class="clkpo-col-header">Sebelum Pasien Meninggalkan Kamar Operasi / Sign Out</div>
              <div class="clkpo-col-body">

                <div class="field-row">
                  <label class="field-label">Waktu</label>
                  <input type="time" v-model="form.signout_waktu" class="input-table" :disabled="disabledSubmit" />
                </div>

                <div class="clkpo-note"><em>Dengan perawat, perawat Anestesi dan Dokter Anestesi</em></div>

                <div class="field-row">
                  <label class="field-label">Secara verbal perawat memastikan nama tindakan</label>
                  <div class="radio-group">
                    <label class="radio-item"><input type="radio" v-model="form.signout_q1" value="Ya" :disabled="disabledSubmit"> Ya</label>
                    <label class="radio-item"><input type="radio" v-model="form.signout_q1" value="Tidak" :disabled="disabledSubmit"> Tidak</label>
                  </div>
                </div>

                <div class="field-row">
                  <label class="field-label">Kelengkapan alat, jumlah kasa dan jarum</label>
                  <div class="radio-group">
                    <label class="radio-item"><input type="radio" v-model="form.signout_q2" value="Ya" :disabled="disabledSubmit"> Lengkap</label>
                    <label class="radio-item"><input type="radio" v-model="form.signout_q2" value="Tidak" :disabled="disabledSubmit"> Tidak</label>
                  </div>
                </div>

                <div class="field-row">
                  <label class="field-label">Pelebelan spesimen (baca label spesimen dan nama pasien dengan keras)</label>
                  <div class="radio-group">
                    <label class="radio-item"><input type="radio" v-model="form.signout_q3" value="Ya" :disabled="disabledSubmit"> Ya</label>
                    <label class="radio-item"><input type="radio" v-model="form.signout_q3" value="Tidak" :disabled="disabledSubmit"> Tidak</label>
                  </div>
                </div>

                <div class="field-row">
                  <label class="field-label">Apakah ada masalah peralatan yang perlu disampaikan?</label>
                  <div class="radio-group">
                    <label class="radio-item"><input type="radio" v-model="form.signout_q4" value="Ya" :disabled="disabledSubmit"> Ya</label>
                    <label class="radio-item"><input type="radio" v-model="form.signout_q4" value="Tidak" :disabled="disabledSubmit"> Tidak</label>
                  </div>
                </div>

                <div class="field-row">
                  <label class="field-label">Apakah ada catatan khusus untuk proses <em>recovery</em> dan penanganan perawatan pasien ini?</label>
                  <div class="radio-group">
                    <label class="radio-item"><input type="radio" v-model="form.signout_q5" value="Ya" :disabled="disabledSubmit"> Ya</label>
                    <label class="radio-item"><input type="radio" v-model="form.signout_q5" value="Tidak" :disabled="disabledSubmit"> Tidak</label>
                  </div>
                </div>
                <div class="field-row">
                  <label class="field-label">Medan, </label>
                  <input type="date" v-model="form.signout_tanggal" :disabled="disabledSubmit" class="input-table" />
                </div>

                <!-- TTD Sign Out -->
                <div class="ttd-section">
                  <div class="ttd-title">Tanda Tangan</div>

                  <div class="ttd-card">
                    <div class="ttd-role">dr. Bedah</div>
                    <div class="signature-cell">
                      <template v-if="form.signout_ttd_dr_bedah && !ttdCleared.so_bedah">
                        <img :src="form.signout_ttd_dr_bedah" class="ttd-preview" />
                        <button v-if="!disabledSubmit" @click="clearSign('so_bedah', 'signout_ttd_dr_bedah')" class="btn-clear-mini" type="button">Hapus</button>
                      </template>
                      <template v-else-if="!disabledSubmit">
                        <VueSignaturePad ref="ttd_so_bedah" :options="sigOption" class="signature-box-table" />
                        <button @click="saveSign('ttd_so_bedah', 'so_bedah', 'signout_ttd_dr_bedah')" class="btn-save-mini" type="button">Simpan ✔</button>
                      </template>
                    </div>
                    <div class="dropdown-dokter mt-1">
                      <select v-model="form.signout_nama_dr_bedah" class="form-select-dokter" :disabled="disabledSubmit">
                        <option value="" disabled>🩺 Pilih Dokter Bedah</option>
                        <option v-for="d in listDokter" :key="d.id" :value="d.nama">{{ d.nama }}</option>
                      </select>
                      <span class="dropdown-icon">▾</span>
                    </div>
                  </div>

                  <div class="ttd-card">
                    <div class="ttd-role">dr. Anestesi</div>
                    <div class="signature-cell">
                      <template v-if="form.signout_ttd_dr_anestesi && !ttdCleared.so_anestesi">
                        <img :src="form.signout_ttd_dr_anestesi" class="ttd-preview" />
                        <button v-if="!disabledSubmit" @click="clearSign('so_anestesi', 'signout_ttd_dr_anestesi')" class="btn-clear-mini" type="button">Hapus</button>
                      </template>
                      <template v-else-if="!disabledSubmit">
                        <VueSignaturePad ref="ttd_so_anestesi" :options="sigOption" class="signature-box-table" />
                        <button @click="saveSign('ttd_so_anestesi', 'so_anestesi', 'signout_ttd_dr_anestesi')" class="btn-save-mini" type="button">Simpan ✔</button>
                      </template>
                    </div>
                    <div class="dropdown-dokter mt-1">
                      <select v-model="form.signout_nama_dr_anestesi" class="form-select-dokter" :disabled="disabledSubmit">
                        <option value="" disabled>🩺 Pilih Dokter</option>
                        <option v-for="d in listDokter" :key="d.id" :value="d.nama">{{ d.nama }}</option>
                      </select>
                      <span class="dropdown-icon">▾</span>
                    </div>
                  </div>

                  <div class="ttd-card">
                    <div class="ttd-role">Perawat Anestesi</div>
                    <div class="signature-cell">
                      <template v-if="form.signout_ttd_perawat_anestesi && !ttdCleared.so_p_anestesi">
                        <img :src="form.signout_ttd_perawat_anestesi" class="ttd-preview" />
                        <button v-if="!disabledSubmit" @click="clearSign('so_p_anestesi', 'signout_ttd_perawat_anestesi')" class="btn-clear-mini" type="button">Hapus</button>
                      </template>
                      <template v-else-if="!disabledSubmit">
                        <VueSignaturePad ref="ttd_so_p_anestesi" :options="sigOption" class="signature-box-table" />
                        <button @click="saveSign('ttd_so_p_anestesi', 'so_p_anestesi', 'signout_ttd_perawat_anestesi')" class="btn-save-mini" type="button">Simpan ✔</button>
                      </template>
                    </div>
                    <input type="text" v-model="form.signout_nama_perawat_anestesi" class="input-table mt-1" placeholder="Nama perawat anestesi" :disabled="disabledSubmit" />
                  </div>

                  <div class="ttd-card">
                    <div class="ttd-role">Perawat Instrumen</div>
                    <div class="signature-cell">
                      <template v-if="form.signout_ttd_perawat_instrument && !ttdCleared.so_instrument">
                        <img :src="form.signout_ttd_perawat_instrument" class="ttd-preview" />
                        <button v-if="!disabledSubmit" @click="clearSign('so_instrument', 'signout_ttd_perawat_instrument')" class="btn-clear-mini" type="button">Hapus</button>
                      </template>
                      <template v-else-if="!disabledSubmit">
                        <VueSignaturePad ref="ttd_so_instrument" :options="sigOption" class="signature-box-table" />
                        <button @click="saveSign('ttd_so_instrument', 'so_instrument', 'signout_ttd_perawat_instrument')" class="btn-save-mini" type="button">Simpan ✔</button>
                      </template>
                    </div>
                    <input type="text" v-model="form.signout_nama_perawat_instrument" class="input-table mt-1" placeholder="Nama perawat instrumen" :disabled="disabledSubmit" />
                  </div>

                  <div class="ttd-card">
                    <div class="ttd-role">Perawat Sirkuler</div>
                    <div class="signature-cell">
                      <template v-if="form.signout_ttd_perawat_sirkuler && !ttdCleared.so_sirkuler">
                        <img :src="form.signout_ttd_perawat_sirkuler" class="ttd-preview" />
                        <button v-if="!disabledSubmit" @click="clearSign('so_sirkuler', 'signout_ttd_perawat_sirkuler')" class="btn-clear-mini" type="button">Hapus</button>
                      </template>
                      <template v-else-if="!disabledSubmit">
                        <VueSignaturePad ref="ttd_so_sirkuler" :options="sigOption" class="signature-box-table" />
                        <button @click="saveSign('ttd_so_sirkuler', 'so_sirkuler', 'signout_ttd_perawat_sirkuler')" class="btn-save-mini" type="button">Simpan ✔</button>
                      </template>
                    </div>
                    <input type="text" v-model="form.signout_nama_perawat_sirkuler" class="input-table mt-1" placeholder="Nama perawat sirkuler" :disabled="disabledSubmit" />
                  </div>

                </div>

              </div>
            </div>

          </div><!-- /clkpo-grid -->
        </div>

      </div><!-- /position-relative -->
    </div><!-- /container -->

    <!-- FOOTER ACTIONS -->
    <div class="action-footer">
      <button class="btn-back" @click="$emit('back')">Kembali</button>
      <button v-if="!disabledSubmit" class="btn-save-form" @click="submit" :disabled="saving">
        <span v-if="saving">Menyimpan...</span>
        <span v-else>{{ editUuid ? 'Update' : 'Simpan' }}</span>
      </button>
    </div>

  </div>
</template>

<script>
export default {
  name: "FormChecklistKeselamatanPasienOperasi",

  props: {
    selectedPatient: { type: Object, default: null },
    editData:        { type: Object, default: null },
    viewData:        { type: Object, default: null },
    documentType:    { type: String, default: "" },
  },

  data() {
    return {
      saving:         false,
      disabledSubmit: false,
      editUuid:       "",
      listDokter:     [],
      sigOption: { penColor: "black", backgroundColor: "white" },
      ttdCleared: {
        si_anestesi:   true,
        si_p_anestesi: true,
        si_perawat:    true,
        to_anestesi:   true,
        to_p_anestesi: true,
        to_sirkuler:   true,
        so_bedah:      true,
        so_anestesi:   true,
        so_p_anestesi: true,
        so_instrument: true,
        so_sirkuler:   true,
      },
      form: {
        uuid_pasien:   "",
        no_rm:         "",
        no_surat:      "RM/4.9/CLKPO/22",
        nama:          "",
        jenis_kelamin: "",
        nik:           "",

        // Sign In
        signin_waktu:                "",
        signin_q1:                   "",
        signin_q2:                   "",
        signin_q3:                   "",
        signin_q4:                   "",
        signin_q5:                   "",
        signin_q6:                   "",
        signin_q7:                   "",
        signin_ttd_dr_anestesi:      "",
        signin_nama_dr_anestesi:     "",
        signin_ttd_perawat_anestesi: "",
        signin_nama_perawat_anestesi:"",
        signin_ttd_perawat:          "",
        signin_nama_perawat:         "",

        // Time Out
        timeout_waktu:                   "",
        timeout_q1:                      "",
        timeout_q2:                      "",
        timeout_q3:                      "",
        timeout_q4_tindakan_beresiko:    "",
        timeout_q4_lama_tindakan:        "",
        timeout_q4_antisipasi_perdarahan:"",
        timeout_q5:                      "",
        timeout_q6_kesterilan:           "",
        timeout_q6_implan:               "",
        timeout_q6_masalah_alat:         "",
        timeout_q6_radiologi:            "",
        timeout_ttd_dr_anestesi:         "",
        timeout_nama_dr_anestesi:        "",
        timeout_ttd_perawat_anestesi:    "",
        timeout_nama_perawat_anestesi:   "",
        timeout_ttd_perawat_sirkuler:    "",
        timeout_nama_perawat_sirkuler:   "",

        // Sign Out
        signout_waktu:                    "",
        signout_q1:                       "",
        signout_q2:                       "",
        signout_q3:                       "",
        signout_q4:                       "",
        signout_q5:                       "",
        signout_tanggal:                       "",
        signout_ttd_dr_bedah:             "",
        signout_nama_dr_bedah:            "",
        signout_ttd_dr_anestesi:          "",
        signout_nama_dr_anestesi:         "",
        signout_ttd_perawat_anestesi:     "",
        signout_nama_perawat_anestesi:    "",
        signout_ttd_perawat_instrument:   "",
        signout_nama_perawat_instrument:  "",
        signout_ttd_perawat_sirkuler:     "",
        signout_nama_perawat_sirkuler:    "",
      },
    };
  },

  async mounted() {
    await this.fetchDokter();

    if (this.selectedPatient) {
      this.form.uuid_pasien   = this.selectedPatient.uuid          || "";
      this.form.no_rm         = this.selectedPatient.rekam_medis   || "";
      this.form.nama          = this.selectedPatient.nama          || "";
      this.form.jenis_kelamin = this.selectedPatient.jenis_kelamin || "";
      this.form.nik           = this.selectedPatient.no_identitas  || "";
    }

    if (this.viewData) {
      this.disabledSubmit = true;
      this.editUuid = this.editData?.uuid || "";
      await this.loadDataForEdit();
    } else if (this.editData) {
      this.disabledSubmit = false;
      this.editUuid = this.editData.uuid;
      await this.loadDataForEdit();
    }
  },

  methods: {
    async fetchDokter() {
      try {
        const res = await axios.get("/master/pasien/master-dokter-all");
        this.listDokter = res.data.data;
      } catch (e) {
        console.error("Gagal memuat dokter:", e);
      }
    },

    async loadDataForEdit() {
      if (!this.editUuid) return;
      try {
        const res = await axios.get(
          `/master/rekammedis/lampiran/${this.editUuid}?type=checklist_keselamatan_pasien_operasi`
        );
        const data = res.data.data;
        if (!data) return;

        Object.keys(this.form).forEach((f) => {
          if (data[f] !== undefined && data[f] !== null) {
            this.form[f] = data[f];
          }
        });

        this.$nextTick(() => {
          this.ttdCleared.si_anestesi   = !this.form.signin_ttd_dr_anestesi;
          this.ttdCleared.si_p_anestesi = !this.form.signin_ttd_perawat_anestesi;
          this.ttdCleared.si_perawat    = !this.form.signin_ttd_perawat;
          this.ttdCleared.to_anestesi   = !this.form.timeout_ttd_dr_anestesi;
          this.ttdCleared.to_p_anestesi = !this.form.timeout_ttd_perawat_anestesi;
          this.ttdCleared.to_sirkuler   = !this.form.timeout_ttd_perawat_sirkuler;
          this.ttdCleared.so_bedah      = !this.form.signout_ttd_dr_bedah;
          this.ttdCleared.so_anestesi   = !this.form.signout_ttd_dr_anestesi;
          this.ttdCleared.so_p_anestesi = !this.form.signout_ttd_perawat_anestesi;
          this.ttdCleared.so_instrument = !this.form.signout_ttd_perawat_instrument;
          this.ttdCleared.so_sirkuler   = !this.form.signout_ttd_perawat_sirkuler;
        });
      } catch (err) {
        console.error("Gagal memuat data:", err);
      }
    },

    saveSign(refKey, clearedKey, formField) {
      const pad = this.$refs[refKey];
      const sp  = Array.isArray(pad) ? pad[0] : pad;
      if (!sp) { console.error("REF tidak ditemukan:", refKey); return; }

      const { isEmpty, data } = sp.saveSignature();
      if (isEmpty) { alert("Tanda tangan masih kosong!"); return; }

      this.form[formField]      = data;
      this.ttdCleared[clearedKey] = false;
    },

    clearSign(clearedKey, formField) {
      this.form[formField]        = "";
      this.ttdCleared[clearedKey] = true;

      this.$nextTick(() => {
        this.$nextTick(() => {
          const refKey = "ttd_" + clearedKey;
          const pad    = this.$refs[refKey];
          const sp     = Array.isArray(pad) ? pad[0] : pad;
          if (sp) sp.clearSignature();
        });
      });
    },

    async submit() {
      if (!this.form.uuid_pasien) {
        alert("Pasien belum dipilih.");
        return;
      }
      this.saving = true;
      try {
        const payload = { ...this.form };
        if (this.editUuid) payload.uuid = this.editUuid;

        const res = await axios.post(
          "/master/pasien/dokumen-checklist-keselamatan-pasien-operasi",
          payload
        );
        if (res.data.status) {
          alert(res.data.message);
          this.$emit("back");
        } else {
          alert(res.data.message || "Gagal menyimpan.");
        }
      } catch (err) {
        console.error(err);
        alert("Terjadi kesalahan saat menyimpan.");
      } finally {
        this.saving = false;
      }
    },
  },
};
</script>

<style scoped>
.container { max-width: 1700px; margin: 0 auto; }
.position-relative { position: relative; }
.py-4 { padding: 24px 0; }
.text-center { text-align: center; }
.fw-bold { font-weight: bold; }
.fw-semibold { font-weight: 600; }
.mb-4 { margin-bottom: 24px; }
.mt-1 { margin-top: 4px; }

/* === PATIENT INFO === */
.patient-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 6px 20px; }
.patient-item { display: flex; align-items: center; gap: 6px; padding: 4px 0; border-bottom: 1px dashed #eee; }
.patient-label { font-weight: 600; font-size: 13px; color: #555; min-width: 120px; flex-shrink: 0; }
.patient-sep   { color: #888; flex-shrink: 0; }
.patient-val   { font-size: 13px; color: #222; }

/* === BOX & SECTION === */
.box-rme { border: 1px solid #dcdcdc; padding: 20px; border-radius: 6px; background: white; margin-bottom: 20px; }
.section-title-rme { font-weight: bold; margin-bottom: 15px; color: #2d74b7; border-bottom: 2px solid #2d74b7; padding-bottom: 8px; }

/* === 3-COLUMN GRID === */
.clkpo-grid { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 12px; }
.clkpo-col { border: 1px solid #ddd; border-radius: 5px; overflow: hidden; }
.clkpo-col-header { background: #2d74b7; color: white; font-weight: bold; font-size: 12px; padding: 8px 10px; text-align: center; }
.clkpo-col-body { padding: 10px; }
.clkpo-note { font-size: 11px; color: #555; background: #f0f8ff; border-left: 3px solid #2d74b7; padding: 4px 7px; margin-bottom: 8px; border-radius: 2px; }

/* === FIELD ROW === */
.field-row { margin-bottom: 10px; }
.field-label { display: block; font-weight: 600; font-size: 12px; margin-bottom: 4px; color: #333; }

/* === INPUT === */
.input-table { width: 100%; border: 1px solid #ccc; border-radius: 3px; padding: 4px 5px; font-size: 12px; box-sizing: border-box; }
.input-table:focus { outline: none; border-color: #2d74b7; }
.input-table:disabled { background: #f5f5f5; }

/* === RADIO === */
.radio-group { display: flex; flex-direction: column; gap: 4px; }
.radio-item { display: flex; align-items: flex-start; gap: 6px; font-size: 12px; color: #333; cursor: pointer; font-weight: normal; }
.radio-item input[type="radio"] { margin-top: 2px; flex-shrink: 0; }

/* === TTD SECTION === */
.ttd-section { margin-top: 12px; border-top: 2px dashed #2d74b7; padding-top: 10px; }
.ttd-title { font-weight: bold; font-size: 12px; color: #2d74b7; margin-bottom: 8px; }
.ttd-card { border: 1px solid #ddd; border-radius: 4px; padding: 8px; background: #fafafa; margin-bottom: 8px; }
.ttd-role { font-weight: bold; font-size: 11px; color: #444; margin-bottom: 6px; }
.signature-cell { display: flex; flex-direction: column; align-items: center; gap: 4px; margin-bottom: 5px; }
.signature-box-table { width: 160px; height: 70px; border: 2px solid #999; border-radius: 4px; background: white; }
.ttd-preview { width: 160px; height: 70px; object-fit: contain; border: 1px dashed #ccc; display: block; }
.btn-save-mini  { background: #1e88e5; color: white; padding: 3px 10px; border: none; border-radius: 3px; cursor: pointer; font-size: 11px; width: 100%; margin-top: 3px; }
.btn-clear-mini { background: #f44336; color: white; padding: 3px 10px; border: none; border-radius: 3px; cursor: pointer; font-size: 11px; margin-top: 3px; }

/* === DROPDOWN DOKTER === */
.dropdown-dokter { position: relative; width: 100%; }
.form-select-dokter { width: 100%; padding: 5px 28px 5px 8px; font-size: 12px; border: 1px solid #ccc; border-radius: 3px; appearance: none; -webkit-appearance: none; background: #fff; cursor: pointer; box-sizing: border-box; }
.form-select-dokter:focus { outline: none; border-color: #2d74b7; }
.form-select-dokter:disabled { background: #f5f5f5; }
.dropdown-icon { position: absolute; right: 8px; top: 50%; transform: translateY(-50%); pointer-events: none; color: #555; font-size: 13px; }

/* === FOOTER === */
.action-footer { margin-top: 30px; padding: 20px; display: flex; justify-content: flex-end; gap: 12px; background: #f5f5f5; border-top: 2px solid #ddd; position: sticky; bottom: 0; }
.btn-save-form { background: #0288d1; color: white; padding: 10px 24px; border: none; border-radius: 4px; font-weight: bold; cursor: pointer; font-size: 16px; }
.btn-save-form:disabled { background: #ccc; cursor: not-allowed; }
.btn-back { background: #ff9800; color: white; padding: 10px 24px; border: none; border-radius: 4px; font-weight: bold; cursor: pointer; font-size: 16px; }
.view-overlay { position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(255,255,255,0.1); z-index: 10; cursor: not-allowed; }
</style>
