<template>
  <button @click="$emit('back')" class="btn-back">Kembali</button>

  <div class="container py-4">
    <div class="form-wrapper position-relative">
      <div v-if="disabledSubmit" class="view-overlay"></div>
      <!-- LOADING OVERLAY -->
      <div v-if="loadingData" class="loading-overlay">
        <div class="spinner-rme"></div>
        <p>Memuat data...</p>
      </div>

      <!-- ================= HEADER ================= -->
      <div class="text-center mb-4">
        <img
          src="/logo-rs.png"
          alt="Logo RS"
          class="logo-rs mb-3"
          style="max-width: 150px"
        />
        <h2 class="fw-bold text-uppercase">RS KHUSUS MATA PRIMA VISION</h2>
        <p class="mb-3">Email: rsprimavision@gmail.com</p>
        <hr class="my-3" style="border: 2px solid #000" />

        <h3 class="fw-bold mt-4 mb-4">CATATAN OPERASI</h3>
        <p class="text-muted">RM 2.3/COK/22</p>

        <span v-if="isEditMode && !disabledSubmit" class="badge bg-warning"
          >Mode Edit</span
        >
        <!-- <span v-else class="badge bg-success">Mode Baru</span> -->
      </div>

      <!-- ================= DATA PASIEN ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Data Pasien</h5>

        <div class="row mb-2">
          <div class="col-md-6">
            <label>Nama :</label>
            <input type="text" v-model="form.nama_pasien" class="input-rme" readonly />
          </div>
          <div class="col-md-6">
            <label>No. RM :</label>
            <input type="text" v-model="form.no_rm_pasien" class="input-rme" readonly />
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-md-6">
            <label>Tanggal Lahir :</label>
            <input
              type="text"
              v-model="form.tanggal_lahir_display"
              class="input-rme"
              readonly
            />
          </div>
          <div class="col-md-6">
            <label>NIK :</label>
            <input type="text" v-model="form.nik_pasien" class="input-rme" readonly />
          </div>
        </div>
      </div>

      <!-- ================= INFO OPERASI ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Informasi Operasi</h5>

        <div class="row mb-3">
          <div class="col-md-4">
            <label>Dokter Bedah : <span class="text-danger">*</span></label>
            <input
              type="text"
              v-model="form.dokter_bedah"
              class="form-control"
              placeholder="Nama dokter bedah"
            />
          </div>
          <div class="col-md-4">
            <label>Perawat Scrub :</label>
            <input
              type="text"
              v-model="form.perawat_scrub"
              class="form-control"
              placeholder="Nama perawat scrub"
            />
          </div>
          <div class="col-md-4">
            <label>Tanggal : <span class="text-danger">*</span></label>
            <input type="date" v-model="form.tanggal" class="form-control" />
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-4">
            <label>Operasi Mulai :</label>
            <input type="time" v-model="form.operasi_mulai" class="form-control" />
          </div>
          <div class="col-md-4">
            <label>Operasi Selesai :</label>
            <input type="time" v-model="form.operasi_selesai" class="form-control" />
          </div>
          <div class="col-md-4">
            <label>Dokter Anestesi :</label>
            <input
              type="text"
              v-model="form.dokter_anestesi"
              class="form-control"
              placeholder="Nama dokter anestesi"
            />
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-6">
            <label>Diagnosis Pra Bedah :</label>
            <textarea
              v-model="form.diagnosis_pra_bedah"
              class="form-control"
              rows="2"
            ></textarea>
          </div>
          <div class="col-md-6">
            <label>Tindakan Operasi :</label>
            <textarea
              v-model="form.tindakan_operasi"
              class="form-control"
              rows="2"
            ></textarea>
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-12">
            <label>Diagnosis Pasca Bedah :</label>
            <textarea
              v-model="form.diagnosis_pasca_bedah"
              class="form-control"
              rows="2"
            ></textarea>
          </div>
        </div>
      </div>

      <!-- ================= DETAIL OPERASI (CHECKBOXES) ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Detail Teknik Operasi</h5>

        <!-- ANESTHESI -->
        <div class="checkbox-section">
          <label class="fw-bold">Anesthesi:</label>
          <div class="checkbox-grid">
            <div class="form-check">
              <input
                type="checkbox"
                v-model="form.anesthesi_topikal"
                class="form-check-input"
                id="anTopikal"
              /><label class="form-check-label" for="anTopikal">Topikal</label>
            </div>
            <div class="form-check">
              <input
                type="checkbox"
                v-model="form.anesthesi_intracamelar"
                class="form-check-input"
                id="anIntra"
              /><label class="form-check-label" for="anIntra">Intracamelar</label>
            </div>
            <div class="form-check">
              <input
                type="checkbox"
                v-model="form.anesthesi_retrobulbar"
                class="form-check-input"
                id="anRetro"
              /><label class="form-check-label" for="anRetro"
                >Retrobulbar/Peribulbar</label
              >
            </div>
            <div class="form-check">
              <input
                type="checkbox"
                v-model="form.anesthesi_nu"
                class="form-check-input"
                id="anNU"
              /><label class="form-check-label" for="anNU">NU / bius umum</label>
            </div>
            <div class="form-check">
              <input
                type="checkbox"
                v-model="form.anesthesi_subconjunctival"
                class="form-check-input"
                id="anSub"
              /><label class="form-check-label" for="anSub">Subconjunctival</label>
            </div>
            <div class="form-check">
              <input
                type="checkbox"
                v-model="form.anesthesi_xylocain"
                class="form-check-input"
                id="anXylo"
              /><label class="form-check-label" for="anXylo">Xylocain</label>
            </div>
            <div class="form-check">
              <input
                type="checkbox"
                v-model="form.anesthesi_lidocain"
                class="form-check-input"
                id="anLido"
              /><label class="form-check-label" for="anLido">Lidocain</label>
            </div>
          </div>
        </div>

        <!-- INSISI -->
        <div class="checkbox-section">
          <label class="fw-bold">Insisi:</label>
          <div class="checkbox-grid">
            <div class="form-check">
              <input
                type="checkbox"
                v-model="form.insisi_kornea"
                class="form-check-input"
                id="insKornea"
              /><label class="form-check-label" for="insKornea">Kornea</label>
            </div>
            <div class="form-check">
              <input
                type="checkbox"
                v-model="form.insisi_limbus"
                class="form-check-input"
                id="insLimbus"
              /><label class="form-check-label" for="insLimbus">Limbus</label>
            </div>
            <div class="form-check">
              <input
                type="checkbox"
                v-model="form.insisi_sclera"
                class="form-check-input"
                id="insSclera"
              /><label class="form-check-label" for="insSclera">Sclera</label>
            </div>
          </div>
        </div>

        <!-- WOUND (TUNNEL) -->
        <div class="checkbox-section">
          <label class="fw-bold">Wound (Tunnel):</label>
          <div class="checkbox-grid">
            <div class="form-check">
              <input
                type="checkbox"
                v-model="form.wound_main_port"
                class="form-check-input"
                id="wMain"
              /><label class="form-check-label" for="wMain">Main port</label>
            </div>
            <div class="form-check">
              <input
                type="checkbox"
                v-model="form.wound_two_side_port"
                class="form-check-input"
                id="wTwo"
              /><label class="form-check-label" for="wTwo">Two side port</label>
            </div>
            <div class="form-check">
              <input
                type="checkbox"
                v-model="form.wound_one_side_port"
                class="form-check-input"
                id="wOne"
              /><label class="form-check-label" for="wOne">One Side port</label>
            </div>
            <div class="form-check">
              <input
                type="checkbox"
                v-model="form.wound_keratome"
                class="form-check-input"
                id="wKera"
              /><label class="form-check-label" for="wKera">keratome 2.75 mm</label>
            </div>
            <div class="form-check">
              <input
                type="checkbox"
                v-model="form.wound_crescen_knife"
                class="form-check-input"
                id="wCres"
              /><label class="form-check-label" for="wCres">Crescen knife</label>
            </div>
          </div>
        </div>

        <!-- CAPSULOTOMI ANTERIOR -->
        <div class="checkbox-section">
          <label class="fw-bold">Capsulotomi Anterior:</label>
          <div class="checkbox-grid">
            <div class="form-check">
              <input
                type="checkbox"
                v-model="form.capsulotomi_ccc"
                class="form-check-input"
                id="capCCC"
              /><label class="form-check-label" for="capCCC">CCC</label>
            </div>
            <div class="form-check">
              <input
                type="checkbox"
                v-model="form.capsulotomi_xmas_tree"
                class="form-check-input"
                id="capXmas"
              /><label class="form-check-label" for="capXmas">X'mas tree</label>
            </div>
            <div class="form-check">
              <input
                type="checkbox"
                v-model="form.capsulotomi_linear"
                class="form-check-input"
                id="capLinear"
              /><label class="form-check-label" for="capLinear">Linear</label>
            </div>
            <div class="form-check">
              <input
                type="checkbox"
                v-model="form.capsulotomi_can_opener"
                class="form-check-input"
                id="capCan"
              /><label class="form-check-label" for="capCan">Can Opener</label>
            </div>
            <div class="form-check">
              <input
                type="checkbox"
                v-model="form.capsulotomi_tryphan_blue"
                class="form-check-input"
                id="capTryphan"
              /><label class="form-check-label" for="capTryphan">Tryphan blue</label>
            </div>
          </div>
        </div>

        <!-- TEKNIK TAMBAHAN -->
        <div class="checkbox-section">
          <label class="fw-bold">Teknik Tambahan:</label>
          <div class="checkbox-grid">
            <div class="form-check">
              <input
                type="checkbox"
                v-model="form.teknik_ctr"
                class="form-check-input"
                id="tekCTR"
              /><label class="form-check-label" for="tekCTR">CTR</label>
            </div>
            <div class="form-check">
              <input
                type="checkbox"
                v-model="form.teknik_kapsulotomi_posterior"
                class="form-check-input"
                id="tekKap"
              /><label class="form-check-label" for="tekKap">Kapsulotomi posterior</label>
            </div>
            <div class="form-check">
              <input
                type="checkbox"
                v-model="form.teknik_vitrektomi_anterior"
                class="form-check-input"
                id="tekVit"
              /><label class="form-check-label" for="tekVit">Vitrektomi anterior</label>
            </div>
          </div>
        </div>

        <!-- CAIRAN IRIGASI -->
        <div class="checkbox-section">
          <label class="fw-bold">Cairan Irigasi:</label>
          <div class="checkbox-grid">
            <div class="form-check">
              <input
                type="checkbox"
                v-model="form.cairan_rl"
                class="form-check-input"
                id="cairRL"
              /><label class="form-check-label" for="cairRL">RL</label>
            </div>
            <div class="form-check">
              <input
                type="checkbox"
                v-model="form.cairan_bss"
                class="form-check-input"
                id="cairBSS"
              /><label class="form-check-label" for="cairBSS">B.S.S</label>
            </div>
          </div>
        </div>

        <!-- LENSA INTRA OKULAR -->
        <div class="checkbox-section">
          <label class="fw-bold">Lensa Intra Okular:</label>
          <div class="checkbox-grid">
            <div class="form-check">
              <input
                type="checkbox"
                v-model="form.lensa_dalam_kantung"
                class="form-check-input"
                id="lensDalam"
              /><label class="form-check-label" for="lensDalam"
                >Dalam kantung kapsul</label
              >
            </div>
            <div class="form-check">
              <input
                type="checkbox"
                v-model="form.lensa_diluar_kantung"
                class="form-check-input"
                id="lensDiluar"
              /><label class="form-check-label" for="lensDiluar"
                >Diluar kantung capsul</label
              >
            </div>
            <div class="form-check">
              <input
                type="checkbox"
                v-model="form.lensa_bilik_mata_depan"
                class="form-check-input"
                id="lensBilik"
              /><label class="form-check-label" for="lensBilik">Bilik mata depan</label>
            </div>
            <div class="form-check">
              <input
                type="checkbox"
                v-model="form.lensa_afakia"
                class="form-check-input"
                id="lensAfakia"
              /><label class="form-check-label" for="lensAfakia">Afakia</label>
            </div>
            <div class="form-check">
              <input
                type="checkbox"
                v-model="form.lensa_sulcus_siliaris"
                class="form-check-input"
                id="lensSulcus"
              /><label class="form-check-label" for="lensSulcus">Sulcus siliaris</label>
            </div>
            <div class="form-check">
              <input
                type="checkbox"
                v-model="form.lensa_fiksasi_scleral"
                class="form-check-input"
                id="lensFiksasi"
              /><label class="form-check-label" for="lensFiksasi">Fiksasi Scleral</label>
            </div>
          </div>
        </div>

        <!-- CAIRAN VISKOELASTIK -->
        <div class="checkbox-section">
          <label class="fw-bold">Cairan Viskoelastik:</label>
          <div class="checkbox-grid">
            <div class="form-check">
              <input
                type="checkbox"
                v-model="form.visko_hpmc"
                class="form-check-input"
                id="viskoHPMC"
              /><label class="form-check-label" for="viskoHPMC">HPMC</label>
            </div>
            <div class="form-check">
              <input
                type="checkbox"
                v-model="form.visko_viscoat"
                class="form-check-input"
                id="viskoViscoat"
              /><label class="form-check-label" for="viskoViscoat">Viscoat</label>
            </div>
            <div class="form-check">
              <input
                type="checkbox"
                v-model="form.visko_hyaluronic_acid"
                class="form-check-input"
                id="viskoHyal"
              /><label class="form-check-label" for="viskoHyal">Hyaluronic acid</label>
            </div>
          </div>
        </div>

        <!-- BENANG -->
        <div class="checkbox-section">
          <label class="fw-bold">Benang:</label>
          <div class="checkbox-grid">
            <div class="form-check">
              <input
                type="checkbox"
                v-model="form.benang_tanpa_jahitan"
                class="form-check-input"
                id="benTanpa"
              /><label class="form-check-label" for="benTanpa">Tanpa jahitan</label>
            </div>
            <div class="form-check">
              <input
                type="checkbox"
                v-model="form.benang_ethylon"
                class="form-check-input"
                id="benEthylon"
              /><label class="form-check-label" for="benEthylon">Ethylon 10-0</label>
            </div>
            <div class="form-check">
              <input
                type="checkbox"
                v-model="form.benang_vicryl"
                class="form-check-input"
                id="benVicryl"
              /><label class="form-check-label" for="benVicryl">Vicryl 8-0</label>
            </div>
          </div>
        </div>

        <!-- KOMPLIKASI -->
        <div class="checkbox-section">
          <label class="fw-bold">Komplikasi:</label>
          <div class="checkbox-grid">
            <div class="form-check">
              <input
                type="checkbox"
                v-model="form.komplikasi_tidak_ada"
                class="form-check-input"
                id="kompTidak"
              /><label class="form-check-label" for="kompTidak">Tidak ada</label>
            </div>
            <div class="form-check">
              <input
                type="checkbox"
                v-model="form.komplikasi_pcr"
                class="form-check-input"
                id="kompPCR"
              /><label class="form-check-label" for="kompPCR">PCR</label>
            </div>
            <div class="form-check">
              <input
                type="checkbox"
                v-model="form.komplikasi_prolaps_vitreous"
                class="form-check-input"
                id="kompProlaps"
              /><label class="form-check-label" for="kompProlaps">Prolaps vitreous</label>
            </div>
            <div class="form-check">
              <input
                type="checkbox"
                v-model="form.komplikasi_drop_nucleus"
                class="form-check-input"
                id="kompDrop"
              /><label class="form-check-label" for="kompDrop">Drop Nucleus</label>
            </div>
            <div class="form-check">
              <input
                type="checkbox"
                v-model="form.komplikasi_perdarahan"
                class="form-check-input"
                id="kompPerdarahan"
              /><label class="form-check-label" for="kompPerdarahan">Perdarahan</label>
            </div>
            <div class="form-check">
              <input
                type="checkbox"
                v-model="form.komplikasi_corneal_burn"
                class="form-check-input"
                id="kompCorneal"
              /><label class="form-check-label" for="kompCorneal">Corneal burn</label>
            </div>
            <div class="form-check">
              <input
                type="checkbox"
                v-model="form.komplikasi_convert_ecce"
                class="form-check-input"
                id="kompECCE"
              /><label class="form-check-label" for="kompECCE">Convert to ECCE</label>
            </div>
            <div class="form-check">
              <input
                type="checkbox"
                v-model="form.komplikasi_convert_icce"
                class="form-check-input"
                id="kompICCE"
              /><label class="form-check-label" for="kompICCE">Convert to ICCE</label>
            </div>
          </div>
        </div>

        <!-- PERAWATAN PASCA OPERASI -->
        <div class="checkbox-section">
          <label class="fw-bold">Perawatan Pasca Operasi:</label>
          <div class="checkbox-grid">
            <div class="form-check">
              <input
                type="checkbox"
                v-model="form.perawatan_pulang"
                class="form-check-input"
                id="perPulang"
              /><label class="form-check-label" for="perPulang"
                >Pulang Berobat jalan</label
              >
            </div>
            <div class="form-check">
              <input
                type="checkbox"
                v-model="form.perawatan_opname"
                class="form-check-input"
                id="perOpname"
              /><label class="form-check-label" for="perOpname">Opname</label>
            </div>
          </div>
        </div>

        <!-- INSTRUKSI PASKA OPERASI -->
        <div class="checkbox-section">
          <label class="fw-bold">Instruksi Paska Operasi:</label>
          <div class="checkbox-grid">
            <div class="form-check">
              <input
                type="checkbox"
                v-model="form.instruksi_perban_2jam"
                class="form-check-input"
                id="ins2Jam"
              /><label class="form-check-label" for="ins2Jam"
                >Perban di buka 2 jam paska operasi</label
              >
            </div>
            <div class="form-check">
              <input
                type="checkbox"
                v-model="form.instruksi_obat_setelah_buka"
                class="form-check-input"
                id="insObat"
              /><label class="form-check-label" for="insObat"
                >Obat mulai di pakai setelah perban di buka</label
              >
            </div>
            <div class="form-check">
              <input
                type="checkbox"
                v-model="form.instruksi_perban_tutup_kembali"
                class="form-check-input"
                id="insTutup"
              /><label class="form-check-label" for="insTutup"
                >Perban dibuka dan ditutup kembali setelah ditetes obat</label
              >
            </div>
            <div class="form-check">
              <input
                type="checkbox"
                v-model="form.instruksi_pantangan"
                class="form-check-input"
                id="insPantangan"
              /><label class="form-check-label" for="insPantangan"
                >Pantangan sesuai dengan instruksi post operasi</label
              >
            </div>
          </div>
        </div>
      </div>

      <!-- ================= CATATAN TAMBAHAN ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Catatan Tambahan</h5>
        <textarea
          v-model="form.catatan_tambahan"
          class="form-control"
          rows="4"
          placeholder="Catatan tambahan operasi..."
        ></textarea>
      </div>

      <!-- ================= SIGNATURE AREA ================= -->
      <div class="signature-container">
        <h5 class="section-title-rme text-center mb-4">Tanda Tangan Operator</h5>

        <div class="signature-section-single">
          <div class="sign-box-center">
            <label>Operator / Dokter Bedah</label>

            <!-- Preview TTD yang sudah ada -->
            <div v-if="form.ttd_operator && !signatureCleared" class="signature-preview">
              <img :src="form.ttd_operator" alt="TTD Operator" class="img-signature" />
              <button @click="clearSignature()" class="btn-clear">
                Hapus & Tanda Tangan Ulang
              </button>
            </div>

            <!-- Signature Pad -->
            <div v-else>
              <VueSignaturePad
                ref="ttd_operator"
                :options="sigOption"
                class="signature-box-rme"
              />
              <button @click="saveSign()" class="btn-save">Simpan ✔</button>
            </div>

            <input
              v-model="form.nama_operator"
              class="input-rme mt-2"
              placeholder="Nama operator"
              readonly
            />
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- ================= BUTTON BOTTOM ================= -->
  <div class="action-footer" v-if="!disabledSubmit">
    <button class="btn-save-form" @click="submitForm" :disabled="loadingSubmit">
      <span v-if="loadingSubmit">Menyimpan...</span>
      <span v-else>{{ isEditMode ? "Update" : "Save" }}</span>
    </button>
    <button class="btn-back" @click="$emit('back')" :disabled="loadingSubmit">
      Back
    </button>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "DokumenCatatanOperasi",

  props: {
    selectedPatient: { type: Object, required: true },
    viewData: {
      type: Object,
      default: null,
    },
    editData: { type: Object, default: null },
  },

  data() {
    return {
      loadingSubmit: false,
      loadingData: false,
      isEditMode: false,
      signatureCleared: false,
      disabledSubmit: false,
      sigOption: { penColor: "black", backgroundColor: "white" },
      form: {
        uuid: "",
        uuid_pasien: "",
        no_rm: "",
        jenis_kelamin: "",
        nama: "",
        nik: "",
        nama_pasien: "",
        no_rm_pasien: "",
        nik_pasien: "",
        tanggal_lahir_display: "",

        // Info Operasi
        dokter_bedah: "",
        perawat_scrub: "",
        tanggal: "",
        operasi_mulai: "",
        operasi_selesai: "",
        dokter_anestesi: "",
        diagnosis_pra_bedah: "",
        tindakan_operasi: "",
        diagnosis_pasca_bedah: "",

        // Anesthesi (7)
        anesthesi_topikal: false,
        anesthesi_intracamelar: false,
        anesthesi_retrobulbar: false,
        anesthesi_nu: false,
        anesthesi_subconjunctival: false,
        anesthesi_xylocain: false,
        anesthesi_lidocain: false,

        // Insisi (3)
        insisi_kornea: false,
        insisi_limbus: false,
        insisi_sclera: false,

        // Wound (5)
        wound_main_port: false,
        wound_two_side_port: false,
        wound_one_side_port: false,
        wound_keratome: false,
        wound_crescen_knife: false,

        // Capsulotomi (5)
        capsulotomi_ccc: false,
        capsulotomi_xmas_tree: false,
        capsulotomi_linear: false,
        capsulotomi_can_opener: false,
        capsulotomi_tryphan_blue: false,

        // Teknik Tambahan (3)
        teknik_ctr: false,
        teknik_kapsulotomi_posterior: false,
        teknik_vitrektomi_anterior: false,

        // Cairan Irigasi (2)
        cairan_rl: false,
        cairan_bss: false,

        // Lensa (6)
        lensa_dalam_kantung: false,
        lensa_diluar_kantung: false,
        lensa_bilik_mata_depan: false,
        lensa_afakia: false,
        lensa_sulcus_siliaris: false,
        lensa_fiksasi_scleral: false,

        // Viskoelastik (3)
        visko_hpmc: false,
        visko_viscoat: false,
        visko_hyaluronic_acid: false,

        // Benang (3)
        benang_tanpa_jahitan: false,
        benang_ethylon: false,
        benang_vicryl: false,

        // Komplikasi (8)
        komplikasi_tidak_ada: false,
        komplikasi_pcr: false,
        komplikasi_prolaps_vitreous: false,
        komplikasi_drop_nucleus: false,
        komplikasi_perdarahan: false,
        komplikasi_corneal_burn: false,
        komplikasi_convert_ecce: false,
        komplikasi_convert_icce: false,

        // Perawatan (2)
        perawatan_pulang: false,
        perawatan_opname: false,

        // Instruksi (4)
        instruksi_perban_2jam: false,
        instruksi_obat_setelah_buka: false,
        instruksi_perban_tutup_kembali: false,
        instruksi_pantangan: false,

        // Catatan & TTD
        catatan_tambahan: "",
        ttd_operator: "",
        nama_operator: "",
        created_by: "",
        updated_by: "",
      },
    };
  },

  watch: {
    selectedPatient: {
      immediate: true,
      handler(newVal) {
        if (newVal && !this.isEditMode) this.setDataForm();
      },
    },
    editData: {
      immediate: true,
      handler(newVal) {
        if (newVal) this.loadEditData();
      },
    },
    "form.dokter_bedah": function (newVal) {
      this.form.nama_operator = newVal;
    },
  },

  mounted() {
    this.disabledSubmit = false;
    if (this.viewData) {
      this.disabledSubmit = true;
      this.loadEditData();
    } else if (this.editData) this.loadEditData();
    else this.setDataForm();
  },

  methods: {
    setDataForm() {
      const today = new Date();
      this.form.tanggal = this.formatDate(today);
      this.form.uuid_pasien = this.selectedPatient?.uuid || "";
      this.form.no_rm = this.selectedPatient?.rekam_medis || "";
      this.form.jenis_kelamin = this.selectedPatient?.jenis_kelamin || "";
      this.form.nama = this.selectedPatient?.nama || "";
      this.form.nik = this.selectedPatient?.nik || "";
      this.form.nama_pasien = this.selectedPatient?.nama || "";
      this.form.no_rm_pasien = this.selectedPatient?.rekam_medis || "";
      this.form.nik_pasien = this.selectedPatient?.nik || "";
      if (this.selectedPatient?.tanggal_lahir) {
        this.form.tanggal_lahir_display = this.formatTanggalIndo(
          this.selectedPatient.tanggal_lahir
        );
      }
    },

    async loadEditData() {
      this.loadingData = true;
      this.isEditMode = true;
      try {
        let data = null;
        if (typeof this.editData === "string") {
          const response = await axios.get(
            `/master/pasien/dokumen-catatan-operasi/${this.editData}`
          );
          data = response.data.data;
        } else {
          data = this.editData;
        }
        if (data) {
          Object.keys(this.form).forEach((key) => {
            if (data[key] !== undefined && data[key] !== null) {
              this.form[key] = data[key];
            }
          });
          if (data.tanggal) this.form.tanggal = this.formatDate(new Date(data.tanggal));
        }
      } catch (error) {
        console.error("Error loading edit data:", error);
        alert("Gagal memuat data untuk edit!");
        this.$emit("back");
      } finally {
        this.loadingData = false;
      }
    },

    clearSignature() {
      this.signatureCleared = true;
      this.form.ttd_operator = "";
      this.$nextTick(() => {
        const pad = this.$refs.ttd_operator;
        if (pad) pad.clearSignature();
      });
    },

    formatDate(date) {
      if (!date) return "";
      const d = new Date(date);
      return d.toISOString().split("T")[0];
    },

    formatTanggalIndo(dateStr) {
      if (!dateStr) return "";
      const months = [
        "Januari",
        "Februari",
        "Maret",
        "April",
        "Mei",
        "Juni",
        "Juli",
        "Agustus",
        "September",
        "Oktober",
        "November",
        "Desember",
      ];
      const d = new Date(dateStr);
      return `${d.getDate()} ${months[d.getMonth()]} ${d.getFullYear()}`;
    },

    saveSign() {
      const pad = this.$refs.ttd_operator;
      if (!pad) {
        console.error("REF tidak ditemukan: ttd_operator");
        return;
      }
      const { isEmpty, data } = pad.saveSignature();
      if (isEmpty) {
        alert("Tanda tangan masih kosong!");
        return;
      }
      this.form.ttd_operator = data;
    },

    async submitForm() {
      if (!this.form.dokter_bedah) {
        alert("Mohon lengkapi Dokter Bedah!");
        return;
      }
      if (!this.form.tanggal) {
        alert("Mohon lengkapi Tanggal!");
        return;
      }
      if (!this.form.ttd_operator) {
        alert("Mohon lengkapi tanda tangan operator!");
        return;
      }

      this.loadingSubmit = true;
      try {
        const fd = new FormData();
        Object.keys(this.form).forEach((key) => {
          fd.append(key, this.form[key] || "");
        });

        const response = await axios.post("/master/pasien/dokumen-catatan-operasi", fd, {
          headers: { "Content-Type": "multipart/form-data" },
        });

        const message = this.isEditMode
          ? "Catatan Operasi berhasil diupdate!"
          : "Catatan Operasi berhasil disimpan!";
        alert(message);
        this.$emit("back");
      } catch (error) {
        console.error("ERROR:", error.response?.data || error);
        alert("Gagal menyimpan data!");
      } finally {
        this.loadingSubmit = false;
      }
    },
  },
};
</script>

<style scoped>
/* ================= CONTAINER & LAYOUT ================= */
.container {
  max-width: 1000px;
  margin: 0 auto;
  padding: 20px;
}

.py-4 {
  padding-top: 1.5rem;
  padding-bottom: 1.5rem;
}

/* ================= TYPOGRAPHY ================= */
.fw-bold {
  font-weight: 700;
}

.text-uppercase {
  text-transform: uppercase;
}

.text-center {
  text-align: center;
}

.text-danger {
  color: #dc3545;
}

.text-center h2 {
  font-size: 18px;
  margin-bottom: 10px;
}

.text-center h3 {
  font-size: 16px;
  margin-top: 20px;
  margin-bottom: 20px;
}

.text-center p {
  font-size: 13px;
  margin: 0;
  line-height: 1.5;
}

hr {
  margin: 20px 0;
  border: 2px solid #000;
}

/* ================= LOGO ================= */
.logo-rs {
  display: block;
  margin: 0 auto 15px;
  max-width: 150px;
}

/* ================= BADGE ================= */
.badge {
  display: inline-block;
  padding: 6px 14px;
  border-radius: 20px;
  font-size: 13px;
  font-weight: bold;
  margin-left: 10px;
  margin-top: 10px;
}

.badge.bg-warning {
  background: #ff9800;
  color: white;
}

.badge.bg-success {
  background: #4caf50;
  color: white;
}

/* ================= BOX & SECTIONS ================= */
.box-rme {
  border: 1px solid #dcdcdc;
  padding: 20px;
  border-radius: 6px;
  background: #fafafa;
  margin-bottom: 20px;
}

.section-title-rme {
  font-weight: bold;
  margin-bottom: 15px;
  color: #2d74b7;
  font-size: 16px;
  border-bottom: 2px solid #2d74b7;
  padding-bottom: 8px;
}

/* ================= FORM ELEMENTS ================= */
label {
  display: block;
  margin-bottom: 8px;
  font-weight: 500;
  color: #555;
  font-size: 14px;
}

.input-rme {
  width: 100%;
  border: 1px solid #ccc;
  border-radius: 4px;
  padding: 10px 12px;
  background: #fff;
  font-size: 14px;
  transition: border-color 0.3s;
}

.input-rme:focus {
  outline: none;
  border-color: #2d74b7;
}

.input-rme[readonly] {
  background: #f5f5f5;
  cursor: not-allowed;
  color: #666;
}

.form-control {
  width: 100%;
  padding: 10px 12px;
  border: 1px solid #ccc;
  border-radius: 4px;
  font-size: 14px;
  transition: border-color 0.3s;
  font-family: "Arial", sans-serif;
  line-height: 1.6;
}

.form-control:focus {
  outline: none;
  border-color: #2d74b7;
}

textarea.form-control {
  resize: vertical;
  min-height: 80px;
}

/* ================= CHECKBOX STYLING ================= */
.checkbox-group {
  display: flex;
  gap: 30px;
  padding: 15px;
  background: white;
  border-radius: 4px;
  border: 1px solid #e0e0e0;
}

.form-check {
  display: flex;
  align-items: center;
  gap: 8px;
}

.form-check-inline {
  display: inline-flex;
  align-items: center;
  margin-right: 0;
}

.form-check-input {
  width: 20px;
  height: 20px;
  cursor: pointer;
  margin: 0;
}

.form-check-label {
  cursor: pointer;
  margin: 0;
  user-select: none;
  font-size: 15px;
  color: #333;
}

/* ================= ROW & COLUMNS ================= */
.row {
  display: flex;
  flex-wrap: wrap;
  margin: 0 -10px;
}

.mb-1 {
  margin-bottom: 5px;
}

.mb-2 {
  margin-bottom: 10px;
}

.mb-3 {
  margin-bottom: 15px;
}

.mb-4 {
  margin-bottom: 20px;
}

.mt-2 {
  margin-top: 10px;
}

.mt-3 {
  margin-top: 15px;
}

.mt-4 {
  margin-top: 20px;
}

.my-3 {
  margin-top: 15px;
  margin-bottom: 15px;
}

.col-md-6,
.col-md-12 {
  padding: 0 10px;
  margin-bottom: 15px;
}

.col-md-6 {
  flex: 0 0 50%;
  max-width: 50%;
}

.col-md-12 {
  flex: 0 0 100%;
  max-width: 100%;
}

/* ================= PROCEDURE STEPS ================= */
.procedure-steps {
  background: white;
  padding: 20px;
  border-radius: 6px;
  border: 1px solid #e0e0e0;
}

.step-item {
  display: flex;
  margin-bottom: 15px;
  padding: 12px 15px;
  background: #f8f9fa;
  border-radius: 4px;
  border-left: 4px solid #2d74b7;
  transition: all 0.3s;
}

.step-item:hover {
  background: #f0f4f8;
  border-left-color: #1976d2;
}

.step-item:last-child {
  margin-bottom: 0;
}

.step-item-important {
  background: #fff9e6;
  border-left: 4px solid #ff9800;
  flex-direction: column;
  padding: 15px;
}

.step-item-important:hover {
  background: #fff5d6;
  border-left-color: #f57c00;
}

.step-number {
  font-weight: bold;
  color: #2d74b7;
  min-width: 40px;
  font-size: 15px;
  flex-shrink: 0;
}

.step-text {
  flex: 1;
  line-height: 1.6;
  color: #333;
  font-size: 14px;
}

.step-content {
  flex: 1;
  display: flex;
  flex-direction: column;
}

.step-content .step-text {
  display: block;
  margin-bottom: 10px;
  font-weight: 600;
}

.step-content label {
  color: #ff9800;
  font-size: 15px;
  font-weight: 600;
  margin-top: 10px;
  margin-bottom: 8px;
}

/* ================= SIGNATURE SECTION ================= */
.signature-container {
  padding: 25px;
  background: white;
  border: 1px solid #dcdcdc;
  border-radius: 6px;
  margin-top: 30px;
}

.signature-section-single {
  display: flex;
  justify-content: center;
  align-items: flex-start;
  margin-top: 20px;
  margin-bottom: 20px;
}

.sign-box-center {
  text-align: center;
  max-width: 500px;
  width: 100%;
}

.sign-box-center label {
  font-weight: bold;
  display: block;
  margin-bottom: 15px;
  color: #333;
  font-size: 16px;
  line-height: 1.4;
}

/* ================= SIGNATURE PAD & PREVIEW ================= */
.signature-box-rme {
  width: 100%;
  height: 180px;
  border: 2px solid #999;
  margin-bottom: 10px;
  background: white;
  border-radius: 4px;
}

.signature-preview {
  width: 100%;
  border: 2px solid #999;
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

/* ================= BUTTONS ================= */
.btn-save {
  background: #1e88e5;
  color: white;
  padding: 8px 20px;
  border: none;
  border-radius: 4px;
  margin-bottom: 10px;
  cursor: pointer;
  font-weight: 500;
  font-size: 14px;
  transition: background 0.3s;
}

.btn-save:hover {
  background: #1565c0;
}

.btn-clear {
  background: #f44336;
  color: white;
  padding: 6px 12px;
  border: none;
  border-radius: 4px;
  margin-top: 10px;
  cursor: pointer;
  font-size: 12px;
  transition: background 0.3s;
}

.btn-clear:hover {
  background: #d32f2f;
}

.btn-back {
  background: #ff9800;
  color: white;
  padding: 12px 30px;
  border: none;
  border-radius: 4px;
  font-weight: bold;
  cursor: pointer;
  font-size: 16px;
  transition: background 0.3s;
}

.btn-back:hover {
  background: #f57c00;
}

.btn-back:disabled {
  background: #ffcc80;
  cursor: not-allowed;
}

.btn-save-form {
  background: #0288d1;
  color: white;
  padding: 12px 30px;
  border: none;
  border-radius: 4px;
  font-weight: bold;
  cursor: pointer;
  font-size: 16px;
  transition: background 0.3s;
}

.btn-save-form:hover {
  background: #0277bd;
}

.btn-save-form:disabled {
  background: #b0bec5;
  cursor: not-allowed;
}

/* ================= ACTION FOOTER ================= */
.action-footer {
  margin-top: 30px;
  display: flex;
  justify-content: flex-end;
  gap: 12px;
  padding: 20px 0;
  border-top: 1px solid #e0e0e0;
}

/* ================= LOADING OVERLAY ================= */
.loading-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(255, 255, 255, 0.95);
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  font-size: 18px;
  z-index: 9999;
}

.loading-overlay p {
  color: #333;
  font-weight: 500;
  margin: 0;
}

.spinner-rme {
  width: 48px;
  height: 48px;
  border: 5px solid #ddd;
  border-top-color: #1d72c9;
  border-radius: 50%;
  animation: spin-rme 0.8s linear infinite;
  margin-bottom: 15px;
}

@keyframes spin-rme {
  to {
    transform: rotate(360deg);
  }
}

/* ================= RESPONSIVE ================= */
@media (max-width: 768px) {
  .container {
    padding: 15px;
  }

  .col-md-6 {
    flex: 0 0 100%;
    max-width: 100%;
  }

  .sign-box-center {
    max-width: 100%;
  }

  .action-footer {
    flex-direction: column-reverse;
  }

  .btn-save-form,
  .btn-back {
    width: 100%;
  }

  .text-center h2 {
    font-size: 16px;
  }

  .text-center h3 {
    font-size: 15px;
  }

  .text-center p {
    font-size: 12px;
  }

  .box-rme {
    padding: 15px;
  }

  .procedure-steps {
    padding: 15px;
  }

  .step-item {
    padding: 10px 12px;
  }

  .step-item-important {
    padding: 12px;
  }

  .step-number {
    min-width: 35px;
    font-size: 14px;
  }

  .step-text {
    font-size: 13px;
  }

  .checkbox-group {
    flex-direction: column;
    gap: 15px;
  }

  .signature-box-rme {
    height: 200px;
  }

  .img-signature {
    height: 200px;
  }
}

@media (max-width: 480px) {
  .logo-rs {
    max-width: 120px;
  }

  .section-title-rme {
    font-size: 15px;
  }

  label {
    font-size: 13px;
  }
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
</style>
