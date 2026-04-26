<template>
  <button @click="$emit('back')" class="btn-back">Kembali</button>

  <div class="container py-4">
    <!-- HEADER -->
    <div class="text-center mb-4">
      <h2 class="fw-bold">Surat Persetujuan / Penolakan Tindakan Medis</h2>
      <h4 class="fw-semibold">(Informed Consent)</h4>
    </div>

    <!-- DATE & TIME -->
    <div class="row mb-3">
      <div class="col-md-6 mb-2">
        <input type="date" :value="item.date" class="form-control" disabled />
      </div>
      <div class="col-md-6 mb-2">
        <input type="time" :value="item.time" class="form-control" disabled />
      </div>
    </div>

    <!-- INFORMASI PASIEN -->
    <div class="box-rme mb-4">
      <h5 class="section-title-rme">Informasi Pasien</h5>
      <div class="row mb-3">
        <div class="col-md-6">
          <label>Kode RM :</label>
          <input type="text" :value="item.kodemr" class="input-rme" disabled />
        </div>
        <div class="col-md-6">
          <label>Nama Pasien :</label>
          <input type="text" :value="item.nama" class="input-rme" disabled />
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <label>Usia :</label>
          <input type="text" :value="item.usia" class="input-rme" disabled />
        </div>
        <div class="col-md-6">
          <label>Alamat :</label>
          <input type="text" :value="item.alamat" class="input-rme" disabled />
        </div>
      </div>
    </div>

    <!-- PEMBERIAN INFORMASI -->
    <div class="box-rme mb-4">
      <h5 class="section-title-rme">Pemberian Informasi</h5>
      <div class="row mb-3">
        <div class="col-md-6">
          <label>Petugas Pelaksana Tindakan :</label>
          <input type="text" :value="item.petugas" class="input-rme" disabled />
        </div>
        <div class="col-md-6">
          <label>Pemberi Informasi :</label>
          <input type="text" :value="item.pemberi_info" class="input-rme" disabled />
        </div>
      </div>
      <div class="row mb-2">
        <div class="col-md-12">
          <label>Penerima Informasi :</label>
          <input type="text" :value="item.penerima_info" class="input-rme" disabled />
        </div>
      </div>
      <p class="small mt-1">
        *) Bila pasien tidak kompeten atau tidak mau menerima informasi, maka penerima
        informasi adalah wali/keluarga terdekat.
      </p>

      <!-- TABLE INFORMASI -->
      <table class="info-table mt-3">
        <thead>
          <tr>
            <th style="width:60px">No</th>
            <th style="width:250px">Jenis Informasi</th>
            <th>Isi Informasi</th>
            <th style="width:150px">Tandai ✓</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="row in infoRows" :key="row.field">
            <td>{{ row.no }}</td>
            <td>{{ row.label }}</td>
            <td><textarea :value="item[row.field]" class="textarea-rme" disabled></textarea></td>
            <td class="text-center">
              <div class="checkbox-paraf">
                <input type="checkbox" :checked="!!item[row.ttdField]" class="checkbox-input" disabled />
              </div>
            </td>
          </tr>

          <!-- Tanda Tangan Dokter -->
          <tr>
            <td colspan="3">
              Dengan ini menyatakan bahwa saya telah menerangkan hal-hal di atas secara
              benar dan jelas dan memberikan kesempatan untuk bertanya dan atau berdiskusi
              (dokter yang memberikan informasi / tindakan).
            </td>
            <td class="text-center">
              <div style="display:flex; flex-direction:column; align-items:center; gap:10px;">
                <label class="fw-bold label-small">Dokter</label>
                <div class="sig-display-box">
                  <img v-if="item.menyatakan_menerangkan_ttd" :src="item.menyatakan_menerangkan_ttd" class="sig-img" alt="TTD Dokter" />
                  <span v-else class="sig-empty">—</span>
                </div>
                <input :value="item.yang_menyatakan" class="input-rme" disabled />
              </div>
            </td>
          </tr>

          <!-- Tanda Tangan Penerima Informasi -->
          <tr>
            <td colspan="3">
              Dengan ini menyatakan bahwa saya telah menerima informasi sebagaimana di
              atas yang saya beri paraf di kolom kanannya dan telah memahaminya.
            </td>
            <td class="text-center">
              <div style="display:flex; flex-direction:column; align-items:center; gap:10px;">
                <label class="fw-bold label-small">Penerima Informasi</label>
                <div class="sig-display-box">
                  <img v-if="item.menyatakan_memahami_ttd" :src="item.menyatakan_memahami_ttd" class="sig-img" alt="TTD Penerima" />
                  <span v-else class="sig-empty">—</span>
                </div>
                <input :value="item.yang_menyatakan" class="input-rme" disabled placeholder="Tanda Tangan dan Nama Terang" />
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- PERSETUJUAN TINDAKAN DOKTER -->
    <div class="consent-container">
      <h3>Persetujuan / Penolakan Tindakan Kedokteran</h3>

      <div>
        Yang bertanda tangan di bawah ini, saya
        <input :value="item.yang_bertanda_tangan" class="input-rme" disabled />, berumur
        <input :value="item.berumur" class="input-rme small" disabled /> tahun, berjenis kelamin
        <input :value="item.jenis_kelamin === 'L' ? 'Laki - laki' : 'Perempuan'" class="input-rme small" disabled />,
        yang beralamatkan di
        <input :value="item.alamat" class="input-rme" disabled />
      </div>

      <div style="margin-top:10px">
        Dengan ini menyatakan
        <input :value="item.menyatakan" class="input-rme small" disabled />
        untuk dilakukan tindakan
        <input :value="item.dilakukan_tindakan" class="input-rme large" disabled />
        terhadap saya / keluarga saya yang bernama
        <input :value="item.nama_anak" class="input-rme" disabled />
      </div>

      <br />

      <div>
        Saya memahami perlunya dan manfaat tindakan tersebut sebagaimana telah dijelaskan
        seperti di atas kepada saya, termasuk risiko dan komplikasi yang timbul.
      </div>

      <div>
        Saya juga menyadari bahwa oleh karena Ilmu kedokteran bukanlah ilmu pasti, maka
        saya tidak akan menuntut hasil dan kemungkinan risiko yang timbul seperti telah
        dijelaskan di atas.
      </div>

      <div class="tanggal-tempat">Medan, {{ formattedDate }} WIB</div>

      <!-- SIGNATURE AREA -->
      <div class="signature-section">
        <div class="sign-box">
          <label>Yang Menyatakan</label>
          <div class="sig-display-box sig-display-box--large">
            <img v-if="item.yang_menyatakan_ttd" :src="item.yang_menyatakan_ttd" class="sig-img" alt="TTD" />
            <span v-else class="sig-empty">—</span>
          </div>
          <input :value="item.yang_menyatakan" class="input-rme" disabled placeholder="Nama Terang" />
        </div>

        <div class="sign-box">
          <label>Saksi 1</label>
          <div class="sig-display-box sig-display-box--large">
            <img v-if="item.saksi_1_ttd" :src="item.saksi_1_ttd" class="sig-img" alt="TTD" />
            <span v-else class="sig-empty">—</span>
          </div>
          <input :value="item.saksi_1" class="input-rme" disabled placeholder="Nama Terang" />
        </div>

        <div class="sign-box">
          <label>Saksi 2</label>
          <div class="sig-display-box sig-display-box--large">
            <img v-if="item.saksi_2_ttd" :src="item.saksi_2_ttd" class="sig-img" alt="TTD" />
            <span v-else class="sig-empty">—</span>
          </div>
          <input :value="item.saksi_2" class="input-rme" disabled placeholder="Nama Terang" />
        </div>
      </div>
    </div>
  </div>

  <!-- BUTTON BOTTOM -->
  <div class="action-footer">
    <button class="btn-edit-form" @click="$emit('edit')">Edit</button>
    <button class="btn-back" @click="$emit('back')">Kembali</button>
  </div>
</template>

<script>
export default {
  name: "ViewInformedConsent",
  emits: ["back", "edit"],
  props: {
    item: {
      type: Object,
      required: true,
    },
  },
  computed: {
    formattedDate() {
      const d = this.item.date ? new Date(this.item.date) : new Date();
      const months = ['Januari','Februari','Maret','April','Mei','Juni',
                      'Juli','Agustus','September','Oktober','November','Desember'];
      return `${d.getDate()} ${months[d.getMonth()]} ${d.getFullYear()}`;
    },
    infoRows() {
      return [
        { no: 1,  label: 'Diagnosis (WD&DD)',  field: 'diagnosis',           ttdField: 'diagnosis_ttd' },
        { no: 2,  label: 'Dasar Diagnosis',    field: 'dasar_diagnosis',     ttdField: 'dasar_diagnosis_ttd' },
        { no: 3,  label: 'Tindakan Kedokteran',field: 'tindakan_kedokteran', ttdField: 'tindakan_kedokteran_ttd' },
        { no: 4,  label: 'Indikasi Tindakan',  field: 'indikasi_tindakan',   ttdField: 'indikasi_tindakan_ttd' },
        { no: 5,  label: 'Tata Cara',          field: 'tata_cara',           ttdField: 'tata_cara_ttd' },
        { no: 6,  label: 'Tujuan',             field: 'tujuan',              ttdField: 'tujuan_ttd' },
        { no: 7,  label: 'Risiko',             field: 'risiko',              ttdField: 'risiko_ttd' },
        { no: 8,  label: 'Komplikasi',         field: 'komplikasi',          ttdField: 'komplikasi_ttd' },
        { no: 9,  label: 'Prognosis',          field: 'prognosis',           ttdField: 'prognosis_ttd' },
        { no: 10, label: 'Alternatif & Resiko',field: 'alternatif_dan_risiko',ttdField: 'alternatif_dan_risiko_ttd' },
        { no: 11, label: 'Lain - Lain',        field: 'lainlain',            ttdField: 'lainlain_ttd' },
      ];
    },
  },
};
</script>

<style scoped>
.box-rme {
  border: 1px solid #dcdcdc;
  padding: 20px;
  border-radius: 6px;
}
.section-title-rme {
  font-weight: bold;
  margin-bottom: 10px;
  color: #2d74b7;
}
.input-rme {
  width: 100%;
  border: 1px solid #ccc;
  border-radius: 4px;
  padding: 6px;
  background: #f4f4f4;
}
.input-rme:disabled { background: #f4f4f4; color: #333; cursor: default; }
.input-rme.small  { width: 80px; }
.input-rme.large  { width: 250px; }
.textarea-rme {
  width: 100%;
  min-height: 80px;
  border: 1px solid #ccc;
  border-radius: 4px;
  padding: 6px;
  background: #f4f4f4;
  resize: none;
}
.textarea-rme:disabled { color: #333; cursor: default; }
.info-table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
}
.info-table th, .info-table td {
  border: 1px solid #ccc;
  padding: 8px;
}
.label-small { font-size: 15px; }

.checkbox-paraf {
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 10px;
}
.checkbox-input {
  width: 20px;
  height: 20px;
  accent-color: #2d74b7;
  cursor: default;
}

/* Signature display */
.sig-display-box {
  width: 180px;
  height: 90px;
  border: 1px solid #aaa;
  border-radius: 4px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #fafafa;
  margin-bottom: 8px;
}
.sig-display-box--large {
  width: 100%;
  height: 120px;
}
.sig-img {
  max-width: 100%;
  max-height: 100%;
  object-fit: contain;
}
.sig-empty {
  color: #bbb;
  font-size: 22px;
}

.consent-container {
  padding: 20px;
  background: white;
}
.tanggal-tempat {
  margin-top: 20px;
  font-weight: 600;
}
.signature-section {
  display: flex;
  justify-content: space-between;
  margin-top: 30px;
}
.sign-box {
  width: 30%;
  text-align: center;
}

.action-footer {
  margin-top: 30px;
  display: flex;
  justify-content: flex-end;
  gap: 12px;
  padding-bottom: 40px;
}
.btn-edit-form {
  background: #1d72c9;
  color: white;
  padding: 8px 18px;
  border: none;
  border-radius: 4px;
  font-weight: bold;
  cursor: pointer;
}
.btn-back {
  background: #f59e0b;
  color: white;
  padding: 8px 18px;
  border: none;
  border-radius: 4px;
  font-weight: bold;
  cursor: pointer;
}
</style>
