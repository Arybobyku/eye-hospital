<template>
  <div>
    <button @click="$emit('back')" class="btn-back">Kembali</button>

    <div class="container py-4">
      <div class="form-wrapper position-relative">

        <div v-if="disabledSubmit" class="view-overlay"></div>

        <!-- HEADER -->
        <div class="text-center mb-4">
          <h2 class="fw-bold">INFORMASI TINDAKAN ANASTESI DAN SEDASI</h2>
          <h5 class="text-muted">{{ form.no_surat }}</h5>
          <span v-if="isEditMode && !disabledSubmit" class="badge bg-warning">Mode Edit</span>
        </div>

        <!-- INFORMASI PASIEN -->
        <div class="box-rme mb-4">
          <h5 class="section-title-rme">Informasi Pasien</h5>
          <div class="form-row-2">
            <div>
              <label>Nama :</label>
              <input type="text" v-model="form.nama" class="input-rme" readonly />
            </div>
            <div>
              <label>Tgl Lahir :</label>
              <input type="text" v-model="form.tanggal_lahir" class="input-rme" readonly />
            </div>
          </div>
          <div class="form-row-2">
            <div>
              <label>No. RM :</label>
              <input type="text" v-model="form.no_rm" class="input-rme" readonly />
            </div>
            <div>
              <label>NIK :</label>
              <input type="text" v-model="form.nik" class="input-rme" readonly />
            </div>
          </div>
        </div>

        <!-- ISI INFORMASI - ACCORDION -->
        <div class="box-rme mb-4">
          <h5 class="section-title-rme">Informasi Tindakan Anastesi dan Sedasi</h5>
          <p class="text-muted" style="font-size:13px; margin-bottom:14px;">Klik judul untuk membaca informasi. Centang &#10003; setelah selesai membaca.</p>

          <!-- 1. ANASTESIA UMUM -->
          <div class="accordion-item" :class="{ read: form.baca_au }">
            <div class="accordion-header" @click="toggleSection('au')">
              <label class="acc-checkbox" @click.stop>
                <input type="checkbox" v-model="form.baca_au" />
                <span class="checkmark"></span>
              </label>
              <span class="acc-title">&#9658; ANASTESIA UMUM (AU)</span>
              <span class="acc-arrow">{{ openSections.au ? '&#9650;' : '&#9660;' }}</span>
            </div>
            <div class="accordion-body" v-show="openSections.au">
              <p class="content-text">AU adalah teknik pembiusan dengan bius total dimana pasien tidak sadar, tidak dapat diransang dan tidak 
              merasakan sakit. Obat bius untuk AU berupa obat yang disuntikkan  kedalam pembuluh darah atau zat anastesi 
              yang dapat dihirup/ dihisap,terutaman pada bayi/anak, lama kerja obat disesuaikan dengan lama operasi. Sesuai 
              dengan kebutuhan operasi dan kondisi pasien, teknik ini akan mempengaruhi kemampuan untuk mempertahankan 
              patensi jalan nafas, terjadi depresi fungsi pernafasan spontan atau depresi fungsi otot. Sehingga pasien sering 
              memerlukan pemasangan alat pernafasan untuk mempertahankan patensi jalan nafas dan pemberian nafas bantu.</p>
              <div class="sub-title">KELEBIHAN TEKNIK AU :</div>
              <div class="bullet-item">• Dari awal pembiusan pasien sudah tidak sadar, tidak merasakan nyeri, teknik dan lama pembiusan bisa disesuaikan dengan lama operasi.</div>
              <div class="sub-title">KEKURANGAN TEKNIK AU :</div>
              <div class="bullet-item">• Pasca bedah pasien harus sadar penuh sebelum bisa diberi minum.</div>
              <div class="bullet-item">• Obat bius yang diberikan dapat memiliki efek keseluruh tubuh termasuk ke aliran pembuluh janin dalam kandungan.</div>
              <div class="sub-title">KOMPLIKASI / EFEK SAMPING :</div>
              <div class="bullet-item">• Efek samping pasca bedah berupa mual muntah, menggigil, pusing, mengantuk, sakit tenggorokan yang bisa diatasi dengan obat-obatan.</div>
              <div class="bullet-item">• Beresiko pada pasien yang tidak puasa, bisa terjadi aspirasi yaitu masuknya isi lambung ke jalan nafas/ paru.</div>
              <div class="bullet-item">• Kesulitan pemasangan alat/ pipa pernafasan yang tidak terduga sebelumnya.</div>
              <div class="bullet-item">• Alergi/hipersensitif terhadap obat (sangat jarang), mulai derajat ringan hingga berat/ fatal.</div>
            </div>
          </div>

          <!-- 2. ANESTESIA SPINAL / EPIDURAL -->
          <div class="accordion-item" :class="{ read: form.baca_spinal }">
            <div class="accordion-header" @click="toggleSection('spinal')">
              <label class="acc-checkbox" @click.stop>
                <input type="checkbox" v-model="form.baca_spinal" />
                <span class="checkmark"></span>
              </label>
              <span class="acc-title">&#9658; ANESTESIA SPINAL / EPIDURAL</span>
              <span class="acc-arrow">{{ openSections.spinal ? '&#9650;' : '&#9660;' }}</span>
            </div>
            <div class="accordion-body" v-show="openSections.spinal">
              <div class="bullet-item">• Anestesia spinal/ epidural adalah pembiusan yang hanya meliputi daerah perut ke bawah (perut sampai ujung kaki) dengan pasien tetap sadar tanpa merasakan nyeri. Bila pasien menginginkan untuk tidur maka dokter dapat memberi obat tidur/ penenang melalui suntikan. Obat bius yang dipakai adalah obat bius lokal (Anestesi Lokal) dan bisa ditambah dengan obat lain yang bisa menambah kekuatan obat maupun menambah lama kerja obat bius lokal. Untuk anestesia spinal, obat bius lokal tersebut disuntikan dengan jarum yang sangat kecil di celah tulang belakang di daerah tulang punggung.</div>
              <div class="bullet-item">• Untuk anestesia epidural didaerah punggung penyuntikan didahului dengan pemberian obat bius lokal dan melalui jarum epidural yang disuntikan di celah tulang belakang akan dimasukkan selang kecil kearah pinggiran tulang belakang, yang berfungsi untuk menyalurkan obat ke sekitar saraf yang ada di pinggiran tulang belakang.</div>
              <div class="bullet-item">• Pada kedua teknik diatas, penyuntikan dilakukan pada pasien dalam keadaan posisi duduk membungkuk atau miring kesalah satu sisi. Hilang rasa ini bisa berlangsung kira-kira 2 sampai 3 jam sesuai jenis obat anestesi lokal yang digunakan.</div>
              <div class="sub-title">KELEBIHAN TEKNIK ANESTESI SPINAL / EPIDURAL :</div>
              <div class="bullet-item">• Jumlah obat yang diberikan sedikit sekali (untuk epidural jumlah obat lebih banyak).</div>
              <div class="bullet-item">• Obat bius tidak masuk ke dalam sirkulasi ari-ari/ rahim sehingga baik untuk operasi besar.</div>
              <div class="bullet-item">• Obat bius tidak mempengaruhi organ lain dalam tubuh.</div>
              <div class="bullet-item">• Bisa ditambahkan obat penghilang rasa sakit yang bisa bertahan hingga 24 jam pasca bedah.</div>
              <div class="bullet-item">• Bila tidak mual/ muntah pasca bedah bisa langsung minum tanpa harus menunggu flatus (buang angin).</div>
              <div class="bullet-item">• Lebih aman untuk pasien yang tidak puasa/ operasi darurat.</div>
              <div class="sub-title">KELEMAHAN SPINAL / EPIDURAL :</div>
              <div class="bullet-item">• Pasca bedah harus berbaring, tidak boleh duduk/ bangun selama 6 jam.</div>
              <div class="sub-title">KOMPLIKASI / EFEK SAMPING :</div>
              <div class="bullet-item">• Efek samping pasca bedah yang sering adalah mual/ muntah, gatal-gatal terutama di daerah wajah, semua bisa diatasi dengan obat-obatan.</div>
              <div class="bullet-item">• Efek samping yang jarang adalah sakit kepala dibagian depan atau belakang kepala pada hari ke-2/ ke-3 terutama pada waktu mengangkat kepala dan menghilang 5 sampai 7 hari. Bila tidak menghilang maka akan dilakukan tindakan khusus berupa pemberian darah pasien pada tempat disuntikan semula.</div>
              <div class="bullet-item">• Efek samping lain berupa kesulitan buang air kecil.</div>
              <div class="bullet-item">• Alergi hipersensitif terhadap obat (sangat jarang), mulai derajat ringan hinggah berat/fatal.</div>
              <div class="bullet-item">• Gangguan pernafasan mulai dari ringan (terasa pernafasannya agak berat) sampai berat (henti nafas).</div>
              <div class="bullet-item">• Kelumpuhan atau kesemutan/ rasa baal ditungkai yang memanjang, bersifat sementara dan bisa sembuh kembali.</div>
              <div class="bullet-item">• Untuk epidural bisa terjadi kejang bila obat masuk kedalam pembuluh darah (jarang terjadi) dan dapat ditangani sesuai prosedur tanpa gejala sisa.</div>
            </div>
          </div>

          <!-- 3. BLOK PERIFER -->
          <div class="accordion-item" :class="{ read: form.baca_blok }">
            <div class="accordion-header" @click="toggleSection('blok')">
              <label class="acc-checkbox" @click.stop>
                <input type="checkbox" v-model="form.baca_blok" />
                <span class="checkmark"></span>
              </label>
              <span class="acc-title">&#9658; BLOK PERIFER</span>
              <span class="acc-arrow">{{ openSections.blok ? '&#9650;' : '&#9660;' }}</span>
            </div>
            <div class="accordion-body" v-show="openSections.blok">
              <p class="content-text">Blok Perifer adalah teknik pembiusan yang hanya melibatkan sebagian tubuh saja (misalnya lengan atas atau bawah, tangan, kaki dan sebagainya). Teknik ini dilakukan dengan penyuntikkan obat bius lokal didaerah sekitar saraf yang mensyarafi sebagian tubuh yang akan dioperasi. Pada saat mencari lokasi syaraf yang akan disuntik mungkin akan merasakan sedikit nyeri. Kadang bila syaraf sudah terkena maka akan terasa seperti kesetrum dibagian tubuh yang akan dioperasi. Demikian juga pada saat penyuntikan obat bius lokal akan terasa nyeri, tapi lama kelamaan bagian tubuh yang dioperasi akan terasa kesemutan dan akhirnya terasa berat sampai tidak bisa digerakkan. Efek bius berlangsung antara 2-4 jam tergantung jenis obat yang dipakai.</p>
              <div class="sub-title">KOMPLIKASI / EFEK SAMPING :</div>
              <div class="bullet-item">• Rasa kesemutan dan atau gangguan bergerak (motorik) yang berkepanjangan tetapi bersifat sementara.</div>
              <div class="bullet-item">• Pendarahan dibawah kulit (hematom).</div>
              <div class="bullet-item">• Tertusuknya lapisan paru.</div>
              <div class="bullet-item">• Pembiusan yang tidak komplit (sebagian tubuh terbius).</div>
              <div class="bullet-item">• Reaksi alergi atau hipersensitif yang ringan hingga berat (fatal).</div>
              <div class="bullet-item">• Kejang bila obat masuk ke dalam pembuluh darah yang dapat ditangani sesuai prosedur tanpa gejala sisa.</div>
            </div>
          </div>

          <!-- 4. SEDASI -->
          <div class="accordion-item" :class="{ read: form.baca_sedasi }">
            <div class="accordion-header" @click="toggleSection('sedasi')">
              <label class="acc-checkbox" @click.stop>
                <input type="checkbox" v-model="form.baca_sedasi" />
                <span class="checkmark"></span>
              </label>
              <span class="acc-title">&#9658; SEDASI</span>
              <span class="acc-arrow">{{ openSections.sedasi ? '&#9650;' : '&#9660;' }}</span>
            </div>
            <div class="accordion-body" v-show="openSections.sedasi">
              <div class="sub-title">&#9658; Sedasi Ringan</div>
              <p class="content-text">Teknik pembiusan dengan penyuntikkan obat yang dapat menyebabkan pasien mengantuk, tetapi masih memiliki respon normal terhadap rangsangan verbal dan tetap dapat mempertahankan patensi dari jalan nafasnya, sedang fungsi pernafasan dan kerja jantung serta pembuluh darah tidak dipengaruhi.</p>
              <div class="sub-title">&#9658; Sedasi Sedang</div>
              <p class="content-text">Teknik pembiusan dengan penyuntikkan obat yang dapat menyebabkan pasien mengantuk, tetapi masih memiliki respon terhadap rangsangan verbal, dapat diikuti atau tidak diikuti oleh rangsangan tekan yang ringan dan pasien masih dapat menjaga patensi jalan nafasnya sendiri. Pada sedasi moderat terjadi perubahan ringan dari respon pernafasan namun fungsi kerja jantung serta pembuluh darah masih tetap dipertahankan dalam keadaan normal. Pada sedasi moderat dapat diikuti gangguan orientasi lingkungan serta gangguan fungsi motorik ringan sampai sedang.</p>
              <div class="sub-title">&#9658; Sedasi Dalam</div>
              <p class="content-text">Teknik pembiusan dengan penyuntikkan obat yang dapat menyebabkan pasien mengantuk, tidur, serta tidak mudah dibangunkan tetapi masih memberikan respon terhadap rangsangan berulang atau rangsangan nyeri. Respon pernafasan sudah mulai terganggu dimana nafas spontan sudah mulai tidak adekuat dan pasien tidak dapat mempertahankan patensi dari jalan nafasnya (mengakibatkan hilangnya sebagian atau seluruh refleksi protektif jalan nafas). Sedasi dalam dapat berpengaruh terhadap fungsi kerja jantung dan pembuluh darah terutama pada pasien sakit berat, sehingga tindakan sedasi dalam membutuhkan alat monitoring yang lebih lengkap dari sedasi ringan maupun sedasi moderat.</p>
              <div class="sub-title">KELEBIHAN TEKNIK SEDASI :</div>
              <div class="bullet-item">• Obat diberikan secara bertahap.</div>
              <div class="bullet-item">• Selama tindakan pasien dalam keadaan mengantuk dan tidur.</div>
              <div class="bullet-item">• Obat yang diberikan dapat memiliki efek amnesia.</div>
              <div class="sub-title">KELEMAHAN TEKNIK SEDASI :</div>
              <div class="bullet-item">• Pasca sedasi pasien harus sadar penuh sebelum bisa diberi minum.</div>
              <div class="bullet-item">• Sampai 24 jam pasca sedasi pasien tidak diperbolehkan mengendarai mobil, mengoperasikan mesin dan menandatangani dokumen penting yang bersifat legal.</div>
              <div class="sub-title">KOMPLIKASI SEDASI :</div>
              <div class="bullet-item">• Oleh karena tindakan sedasi merupakan rangkaian proses dinamik dan dapat berubah, maka sedasi ringan ataupun moderat bisa bergeser menjadi sedasi dalam.</div>
              <div class="bullet-item">• Efek samping pasca sedasi dapat berupa: mual muntah, menggigil, pusing, mengantuk, yang bisa diatasi dengan obat-obatan.</div>
              <div class="bullet-item">• Alergi/ hipersensitif terhadap obat (sangat jarang), mulai derajat ringan hingga berat/ fatal.</div>
              <div class="bullet-item">• Beresiko pada pasien yang tidak puasa, bisa terjadi aspirasi yaitu masuknya isi lambung ke jalan nafas/ paru.</div>
              <div class="bullet-item">• Pada sedasi dalam terdapat kemungkinan pemasangan alat atau pipa pernafasan.</div>
            </div>
          </div>

          <!-- 5. ANESTESIA TOPIKAL -->
          <div class="accordion-item" :class="{ read: form.baca_topikal }">
            <div class="accordion-header" @click="toggleSection('topikal')">
              <label class="acc-checkbox" @click.stop>
                <input type="checkbox" v-model="form.baca_topikal" />
                <span class="checkmark"></span>
              </label>
              <span class="acc-title">&#9658; ANESTESIA TOPIKAL</span>
              <span class="acc-arrow">{{ openSections.topikal ? '&#9650;' : '&#9660;' }}</span>
            </div>
            <div class="accordion-body" v-show="openSections.topikal">
              <p class="content-text">Anestesia topikal adalah teknik pembiusan yang hanya melibatkan bagian tubuh tertentu saja (misalnya mata, gusi, dll). Teknik pembiusan dilakukan dengan memberikan obat bius tetes, spray/ jelly pada bagian tubuh yang akan dibius. Efek bius berlangsung kira-kira 15-30 menit tergantung jenis obat yang dipakai.</p>
              <div class="sub-title">KOMPLIKASI :</div>
              <p class="content-text">Hampir tidak pernah ditemukan.</p>
            </div>
          </div>

          <!-- Progress baca -->
          <div class="read-progress">
            <span>Sudah dibaca: {{ readCount }} / 5 bagian</span>
            <div class="progress-bar-wrap">
              <div class="progress-bar-fill" :style="{ width: (readCount / 5 * 100) + '%' }"></div>
            </div>
          </div>

        </div>

        <!-- PERNYATAAN & ISIAN -->
        <div class="box-rme mb-4">
          <h5 class="section-title-rme">Pernyataan & Data</h5>

          <p class="sign-intro">
            Saya yang bertanda tangan di bawah ini telah membaca atau dibacakan keterangan diatas dan telah dijelaskan terkait dengan prosedur anestesia dan sedasi yang akan dilakukan terhadap:
          </p>

          <!-- Hubungan selector -->
          <div class="mb-3">
            <div class="hubungan-selector">
              <label v-for="opt in hubunganOptions" :key="opt" class="hubungan-item" :class="{ active: form.hubungan === opt }">
                <input type="radio" v-model="form.hubungan" :value="opt" name="hubungan" />
                {{ opt }}
              </label>
            </div>
            <small class="text-muted">*) Pilih hubungan dengan pasien</small>
          </div>

          <div class="form-row-2">
            <div>
              <label>Nama :</label>
              <input type="text" v-model="form.nama_pasien_atau_wali" class="input-rme" placeholder="Nama pasien / wali yang menandatangani" />
            </div>
            <div>
              <label>Umur / Jenis Kelamin :</label>
              <input type="text" v-model="form.umur_jenis_kelamin" class="input-rme" placeholder="Contoh: 45 Tahun / Laki-laki" />
            </div>
          </div>
          <div class="form-row-2">
            <div>
              <label>No. Telp :</label>
              <input type="text" v-model="form.no_telp" class="input-rme" placeholder="Nomor telepon" />
            </div>
            <div>
              <label>No. Rekam Medis :</label>
              <input type="text" v-model="form.no_rm" class="input-rme" readonly />
            </div>
          </div>
          <div class="form-row-2">
            <div>
              <label>Diagnosa :</label>
              <input type="text" v-model="form.diagnosa" class="input-rme" placeholder="Diagnosa" />
            </div>
            <div>
              <label>Rencana Tindakan :</label>
              <input type="text" v-model="form.rencana_tindakan" class="input-rme" placeholder="Rencana tindakan" />
            </div>
          </div>
          <div class="form-row-2">
            <div>
              <label>Jenis Anestesia :</label>
              <input type="text" v-model="form.jenis_anestesia" class="input-rme" placeholder="Contoh: Anastesia Umum / Spinal" />
            </div>
          </div>

          <div class="form-row-2" style="margin-top:8px;">
            <div>
              <label>Medan, Tanggal :</label>
              <input type="date" v-model="form.tanggal_surat" class="input-rme" />
            </div>
            <div>
              <label>Jam :</label>
              <input type="time" v-model="form.jam_surat" class="input-rme" />
            </div>
          </div>
        </div>

        <!-- TANDA TANGAN -->
        <div class="box-rme mb-4">
          <h5 class="section-title-rme">Tanda Tangan</h5>
          <div class="signature-row">

            <!-- TTD DOKTER -->
            <div>
              <label class="fw-bold mb-2 d-block text-center">Dokter yang Menjelaskan</label>
              <div v-if="form.ttd_dokter && !ttdDokterCleared" class="signature-preview text-center">
                <img :src="form.ttd_dokter" alt="TTD Dokter" class="img-signature" />
                <p v-if="form.ttd_dokter_timestamp" class="timestamp-ttd">
                  Ditandatangani: {{ formatTimestamp(form.ttd_dokter_timestamp) }}
                </p>
                <button @click="clearSign('ttd_dokter')" class="btn-clear mt-2">Hapus & Tanda Tangan Ulang</button>
              </div>
              <div v-else class="text-center">
                <VueSignaturePad ref="ttd_dokter" :options="sigOption" class="signature-box-rme mx-auto" />
                <button @click="saveSign('ttd_dokter')" class="btn-save mt-2">Simpan ✔</button>
              </div>
              <div class="mt-2">
                <label>Nama Dokter :</label>
                <div class="dropdown-dokter">
                  <select v-model="form.nama_dokter" class="form-select-dokter">
                    <option value="" disabled>🩺 Pilih Dokter</option>
                    <option v-for="dokter in listDokter" :key="dokter.id" :value="dokter.nama">
                      {{ dokter.nama }}
                    </option>
                  </select>
                  <span class="dropdown-icon">▾</span>
                </div>
              </div>
            </div>

            <!-- TTD PIHAK YANG DIJELASKAN -->
            <div>
              <label class="fw-bold mb-2 d-block text-center">Pihak yang Dijelaskan</label>
              <div v-if="form.ttd_pihak && !ttdPihakCleared" class="signature-preview text-center">
                <img :src="form.ttd_pihak" alt="TTD Pihak" class="img-signature" />
                <p v-if="form.ttd_pihak_timestamp" class="timestamp-ttd">
                  Ditandatangani: {{ formatTimestamp(form.ttd_pihak_timestamp) }}
                </p>
                <button @click="clearSign('ttd_pihak')" class="btn-clear mt-2">Hapus & Tanda Tangan Ulang</button>
              </div>
              <div v-else class="text-center">
                <VueSignaturePad ref="ttd_pihak" :options="sigOption" class="signature-box-rme mx-auto" />
                <button @click="saveSign('ttd_pihak')" class="btn-save mt-2">Simpan ✔</button>
              </div>
              <div class="mt-2">
                <label>Nama Pihak :</label>
                <input type="text" v-model="form.nama_pihak" class="input-rme" placeholder="Nama pasien/wali yang menandatangani" />
              </div>
            </div>

          </div>
        </div>

        <!-- BUTTON BOTTOM -->
        <div class="action-footer" v-if="!disabledSubmit">
          <button class="btn-save-form" @click="submitForm" :disabled="loadingSubmit">
            <span v-if="loadingSubmit">Menyimpan...</span>
            <span v-else>{{ isEditMode ? 'Update' : 'Simpan' }}</span>
          </button>
          <button class="btn-back" @click="$emit('back')" :disabled="loadingSubmit">Kembali</button>
        </div>

      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "FormInformasiTindakanAnastesi",
  props: {
    selectedPatient: { type: Object, required: true },
    editData:        { type: Object, default: null },
    viewData:        { type: Object, default: null },
    documentType:    { type: String, default: "" },
  },
  data() {
    return {
      loadingSubmit:    false,
      disabledSubmit:   false,
      ttdDokterCleared: false,
      ttdPihakCleared:  false,
      listDokter: [],
      hubunganOptions: ['diri saya sendiri', 'istri', 'suami', 'anak', 'ayah', 'ibu'],
      sigOption: { penColor: "black", backgroundColor: "white" },
      openSections: { au: false, spinal: false, blok: false, sedasi: false, topikal: false },
      form: {
        uuid:                  "",
        uuid_pasien:           "",
        no_rm:                 "",
        nik:                   "",
        nama:                  "",
        tanggal_lahir:         "",
        jenis_kelamin:         "",
        no_surat:              "",

        nama_pasien_atau_wali: "",
        umur_jenis_kelamin:    "",
        no_telp:               "",
        hubungan:              "diri saya sendiri",
        diagnosa:              "",
        rencana_tindakan:      "",
        jenis_anestesia:       "",
        tanggal_surat:         "",
        jam_surat:             "",

        baca_au:      false,
        baca_spinal:  false,
        baca_blok:    false,
        baca_sedasi:  false,
        baca_topikal: false,

        ttd_dokter:           "",
        nama_dokter:          "",
        ttd_dokter_timestamp: "",

        ttd_pihak:            "",
        nama_pihak:           "",
        ttd_pihak_timestamp:  "",
      },
    };
  },

  computed: {
    isEditMode() {
      return this.editData !== null && this.editData !== undefined;
    },
    readCount() {
      return ['baca_au','baca_spinal','baca_blok','baca_sedasi','baca_topikal']
        .filter(k => this.form[k]).length;
    },
  },

  async mounted() {
    await this.fetchDokter();
    await this.fetchTahunAkreditasi();

    if (this.viewData === true) {
      this.disabledSubmit = true;
      if (this.editData) this.loadDataForEdit();
      else this.$emit("back");
    } else if (this.viewData && typeof this.viewData === "object") {
      this.disabledSubmit = true;
      this.loadDataForEdit();
    } else if (this.editData) {
      this.loadDataForEdit();
    } else {
      this.setDataForm();
    }
  },

  methods: {
    toggleSection(key) {
      this.openSections[key] = !this.openSections[key];
      if (this.openSections[key]) this.form['baca_' + key] = true;
    },

    async fetchDokter() {
      try {
        const res = await axios.get("/master/pasien/master-dokter-all");
        this.listDokter = res.data.data;
      } catch (e) {
        console.error("Gagal memuat data dokter:", e);
      }
    },

    async fetchTahunAkreditasi() {
      try {
        const res = await axios.get("/api/tahun-akreditasi");
        const tahun = res.data.tahun || "22";
        if (!this.form.no_surat) {
          this.form.no_surat = `RM 8.2/ITADS/${tahun}`;
        }
      } catch (e) {
        console.error("Error fetch tahun:", e);
      }
    },

    setDataForm() {
      if (this.selectedPatient) {
        this.form.uuid_pasien          = this.selectedPatient.uuid;
        this.form.no_rm                = this.selectedPatient.rekam_medis;
        this.form.nik                  = this.selectedPatient.no_identitas || "";
        this.form.nama                 = this.selectedPatient.nama;
        this.form.tanggal_lahir        = this.selectedPatient.tanggal_lahir;
        this.form.jenis_kelamin        = this.selectedPatient.jenis_kelamin || "";
        this.form.nama_pasien_atau_wali = this.selectedPatient.nama;
        this.form.nama_pihak           = this.selectedPatient.nama;
        const today = new Date();
        this.form.tanggal_surat = today.toISOString().split("T")[0];
        this.form.jam_surat     = today.toTimeString().slice(0, 5);
      }
    },

    loadDataForEdit() {
      const src = (this.viewData === true || !this.viewData) ? this.editData : this.viewData;
      if (!src) { this.setDataForm(); return; }
      const boolFields = ['baca_au','baca_spinal','baca_blok','baca_sedasi','baca_topikal'];
      Object.keys(this.form).forEach((key) => {
        if (Object.prototype.hasOwnProperty.call(src, key)) {
          const val = src[key];
          if (boolFields.includes(key)) {
            this.form[key] = val === 1 || val === '1' || val === true;
          } else {
            this.form[key] = val !== null ? val : "";
          }
        }
      });
    },

    formatTimestamp(iso) {
      if (!iso) return "";
      try {
        return new Date(iso).toLocaleString("id-ID", {
          day: "2-digit", month: "2-digit", year: "numeric",
          hour: "2-digit", minute: "2-digit", second: "2-digit",
        });
      } catch { return iso; }
    },

    saveSign(refName) {
      const pad = this.$refs[refName];
      if (!pad) return;
      const { isEmpty, data } = pad.saveSignature();
      if (isEmpty) { alert("Tanda tangan masih kosong!"); return; }
      const flagMap      = { ttd_dokter: "ttdDokterCleared", ttd_pihak: "ttdPihakCleared" };
      const timestampMap = { ttd_dokter: "ttd_dokter_timestamp", ttd_pihak: "ttd_pihak_timestamp" };
      if (flagMap[refName])      this[flagMap[refName]] = false;
      this.form[refName] = data;
      if (timestampMap[refName]) this.form[timestampMap[refName]] = new Date().toISOString();
    },

    clearSign(refName) {
      const flagMap      = { ttd_dokter: "ttdDokterCleared", ttd_pihak: "ttdPihakCleared" };
      const timestampMap = { ttd_dokter: "ttd_dokter_timestamp", ttd_pihak: "ttd_pihak_timestamp" };
      if (flagMap[refName]) { this[flagMap[refName]] = true; this.form[refName] = ""; }
      if (timestampMap[refName]) this.form[timestampMap[refName]] = "";
      this.$nextTick(() => { const pad = this.$refs[refName]; if (pad) pad.clearSignature(); });
    },

    async submitForm() {
      if (!this.form.uuid_pasien) { alert("❌ Data pasien tidak valid!"); return; }
      if (!this.form.hubungan)    { alert("❌ Pilih hubungan dengan pasien!"); return; }
      this.loadingSubmit = true;
      try {
        const fd = new FormData();
        const boolFields = ['baca_au','baca_spinal','baca_blok','baca_sedasi','baca_topikal'];
        Object.keys(this.form).forEach((key) => {
          const val = this.form[key];
          if (boolFields.includes(key)) {
            fd.append(key, val ? '1' : '0');
          } else {
            fd.append(key, val === null || val === undefined ? "" : val);
          }
        });
        const res = await axios.post(
          "/master/pasien/dokumen-informasi-tindakan-anestesi",
          fd,
          { headers: { "Content-Type": "multipart/form-data" } }
        );
        if (res.data.status) {
          alert(`✅ ${res.data.message}`);
          this.$emit("back");
        } else {
          alert(`❌ ${res.data.message || "Gagal menyimpan form!"}`);
        }
      } catch (e) {
        console.error(e);
        alert(e.response?.data?.message || "❌ Gagal menyimpan form!");
      } finally {
        this.loadingSubmit = false;
      }
    },
  },
};
</script>

<style scoped>
.container { max-width: 1200px; margin: 0 auto; }
.form-wrapper { position: relative; }
.view-overlay { position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(255,251,251,0.1); z-index: 10; cursor: not-allowed; }

/* Box */
.box-rme { border: 1px solid #dcdcdc; padding: 20px; border-radius: 6px; background: white; margin-bottom: 20px; }
.section-title-rme { font-weight: bold; margin-bottom: 15px; color: #2d74b7; border-bottom: 2px solid #2d74b7; padding-bottom: 8px; }

/* Accordion */
.accordion-item { border: 1px solid #e0e0e0; border-radius: 8px; margin-bottom: 10px; overflow: hidden; transition: box-shadow 0.2s; }
.accordion-item:hover { box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
.accordion-item.read { border-color: #4caf50; }
.accordion-item.read .accordion-header { background: #f1faf2; }
.accordion-header { display: flex; align-items: center; gap: 12px; padding: 14px 16px; cursor: pointer; background: #f5f7fa; user-select: none; transition: background 0.2s; }
.accordion-header:hover { background: #e8eef7; }
.acc-title { flex: 1; font-weight: bold; font-size: 14px; color: #1a3a5c; }
.acc-arrow { font-size: 11px; color: #888; }
.accordion-body { padding: 14px 18px 16px 18px; background: white; border-top: 1px solid #eee; }

/* Custom checkbox */
.acc-checkbox { display: flex; align-items: center; cursor: pointer; margin: 0; }
.acc-checkbox input[type="checkbox"] { display: none; }
.checkmark { width: 20px; height: 20px; border: 2px solid #bbb; border-radius: 4px; display: flex; align-items: center; justify-content: center; background: white; transition: all 0.2s; flex-shrink: 0; }
.acc-checkbox input:checked + .checkmark { background: #4caf50; border-color: #4caf50; }
.acc-checkbox input:checked + .checkmark::after { content: '✓'; color: white; font-size: 13px; font-weight: bold; }

/* Progress */
.read-progress { margin-top: 14px; display: flex; align-items: center; gap: 12px; font-size: 13px; color: #555; }
.progress-bar-wrap { flex: 1; height: 8px; background: #e0e0e0; border-radius: 4px; overflow: hidden; }
.progress-bar-fill { height: 100%; background: #4caf50; border-radius: 4px; transition: width 0.3s ease; }

/* Static content text */
.sub-title { font-weight: bold; font-size: 13px; margin: 10px 0 3px 0; }
.content-text { font-size: 13px; margin: 4px 0 6px 0; text-align: justify; line-height: 1.6; color: #222; }
.bullet-item { font-size: 13px; margin: 3px 0 3px 18px; line-height: 1.6; color: #222; }

/* Form rows */
.form-row-2 { display: flex; gap: 1rem; margin-bottom: 8px; }
.form-row-2 > div { flex: 1; min-width: 0; padding: 0.5rem; }
.input-rme { width: 100%; border: 1px solid #ccc; border-radius: 4px; padding: 8px; background: #f9f9f9; font-size: 14px; box-sizing: border-box; }
.input-rme:focus { outline: none; border-color: #2d74b7; background: white; }
.input-rme[readonly] { background: #e9ecef; cursor: not-allowed; }

/* Pernyataan intro */
.sign-intro { font-size: 13px; margin-bottom: 10px; text-align: justify; line-height: 1.6; color: #222; }

/* Hubungan */
.mb-3 { margin-bottom: 16px; }
.hubungan-selector { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 6px; }
.hubungan-item { display: flex; align-items: center; gap: 6px; padding: 7px 16px; border: 2px solid #ddd; border-radius: 20px; cursor: pointer; font-size: 13px; font-weight: 500; transition: all 0.2s; background: white; }
.hubungan-item:hover { border-color: #2d74b7; background: #f0f7ff; }
.hubungan-item.active { border-color: #2d74b7; background: #2d74b7; color: white; }
.hubungan-item input[type="radio"] { display: none; }

/* Signature */
.signature-row { display: flex; gap: 2rem; margin-top: 1rem; }
.signature-row > div { flex: 1; padding: 1rem; box-sizing: border-box; }
.signature-preview { width: 100%; background: white; padding: 10px; border-radius: 4px; margin-bottom: 10px; }
.img-signature { max-width: 100%; height: 180px; object-fit: contain; border: 1px dashed #ccc; background: white; display: block; margin: 0 auto; }
.timestamp-ttd { font-size: 12px; color: #2d74b7; font-weight: 500; padding: 6px 16px; background: #e9f5ff; border-radius: 4px; display: block; width: fit-content; margin: 6px auto; }
.signature-box-rme { width: 350px !important; height: 220px !important; border: 2px solid #ccc; border-radius: 6px; }
.dropdown-dokter { position: relative; width: 100%; }
.form-select-dokter { width: 100%; padding: 10px 40px 10px 14px; font-size: 14px; color: #2d3748; background-color: #fff; border: 1.5px solid #cbd5e0; border-radius: 10px; appearance: none; -webkit-appearance: none; cursor: pointer; outline: none; }
.form-select-dokter:focus { border-color: #667eea; box-shadow: 0 0 0 3px rgba(102,126,234,0.2); }
.dropdown-icon { position: absolute; right: 14px; top: 50%; transform: translateY(-50%); color: #718096; font-size: 16px; pointer-events: none; }

/* Buttons */
.action-footer { margin-top: 30px; padding: 20px; display: flex; justify-content: flex-end; gap: 12px; background: #f5f5f5; border-top: 2px solid #ddd; position: sticky; bottom: 0; }
.btn-save-form { background: #0288d1; color: white; padding: 10px 24px; border: none; border-radius: 4px; font-weight: bold; cursor: pointer; font-size: 16px; }
.btn-save-form:hover { background: #0277bd; }
.btn-save-form:disabled { background: #ccc; cursor: not-allowed; }
.btn-save { background: #1e88e5; color: white; padding: 6px 16px; border: none; border-radius: 4px; cursor: pointer; font-weight: 500; }
.btn-save:hover { background: #1565c0; }
.btn-clear { background: #f44336; color: white; padding: 6px 16px; border: none; border-radius: 4px; cursor: pointer; font-weight: 500; margin-left: 10px; }
.btn-back { background: #ff9800; color: white; padding: 10px 24px; border: none; border-radius: 4px; font-weight: bold; cursor: pointer; font-size: 16px; }
.btn-back:hover { background: #f57c00; }
.btn-back:disabled { background: #ccc; cursor: not-allowed; }
.badge { display: inline-block; padding: 4px 10px; border-radius: 4px; font-size: 12px; font-weight: bold; }
.bg-warning { background: #ffc107; color: #333; }
label { display: block; margin-bottom: 5px; font-weight: 500; font-size: 14px; color: #333; }
.fw-bold { font-weight: bold; }
.text-center { text-align: center; }
.text-muted { color: #6c757d; font-size: 12px; }
.d-block { display: block; }
.mt-2 { margin-top: 8px; }
.mb-2 { margin-bottom: 8px; }
.mb-4 { margin-bottom: 24px; }
.mx-auto { margin-left: auto; margin-right: auto; }
.py-4 { padding-top: 24px; padding-bottom: 24px; }
</style>
