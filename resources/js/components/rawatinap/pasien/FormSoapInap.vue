<template>
    <!-- MODAL OVERLAY -->
    <div v-if="show" class="modal-overlay-soap" @click.self="hide">
        <div class="modal-box-soap">

            <!-- HEADER -->
            <div class="modal-header-soap">
                <span class="modal-title-soap">CPPT &amp; SOAP — {{ patientData.nama_pasien }}</span>
                <span class="modal-close-soap" @click="hide">&times;</span>
            </div>

            <!-- BODY -->
            <div class="modal-body-soap">
                <div class="grid">

                    <!-- KIRI: Riwayat SOAP -->
                    <div class="col-5" style="overflow-y: auto; max-height: 600px; border-right: 1px solid #e0e0e0; padding-right: 12px;">
                        <RmeSoap v-if="patientData.pasien_uuid" :selectedPatient="{ uuid: patientData.pasien_uuid }" :key="refreshKey"></RmeSoap>
                    </div>

                    <!-- KANAN: Form Input SOAP -->
                    <div class="col-7" style="padding-left: 16px;">
                        <div v-if="saving" class="soap-saving-overlay">Menyimpan...</div>

                        <label class="soap-label">SUBJECT</label>
                        <ckeditor v-model="form.subject" :editor="editor"></ckeditor>
                        <br />

                        <label class="soap-label">OBJECT</label>
                        <ckeditor v-model="form.object" :editor="editor"></ckeditor>
                        <br />

                        <label class="soap-label">ASSESSMENT</label>
                        <ckeditor v-model="form.assessment" :editor="editor"></ckeditor>
                        <br />

                        <label class="soap-label">PLANNING</label>
                        <ckeditor v-model="form.plan" :editor="editor"></ckeditor>
                        <br />

                        <!-- TANDA TANGAN -->
                        <label class="soap-label">Tanda Tangan</label>
                        <div v-if="form.ttd" style="margin-bottom: 8px;">
                            <img :src="form.ttd" alt="TTD" height="80" width="300" style="border: 1px solid #ccc; border-radius: 4px;" />
                        </div>
                        <button v-if="!form.ttd" class="button-modal-page button-modal-green" @click="showSignature = true">
                            Tanda Tangan
                        </button>
                        <button v-if="form.ttd" class="button-modal-page button-modal-red" style="margin-left:8px" @click="form.ttd = ''">
                            Hapus TTD
                        </button>

                        <!-- MODAL TTD -->
                        <div v-if="showSignature" class="sig-overlay" @click.self="showSignature = false">
                            <div class="sig-box">
                                <h4>Tanda Tangan Digital</h4>
                                <VueSignaturePad ref="signaturePad" width="400px" height="200px" style="border: 1px solid #ccc; border-radius: 4px;" />
                                <div style="margin-top: 10px; display: flex; gap: 8px;">
                                    <button class="button-modal-page button-modal-green" @click="saveSignature">Simpan TTD</button>
                                    <button class="button-modal-page button-modal-red" @click="clearSignature">Bersihkan</button>
                                    <button class="button-modal-page" @click="showSignature = false">Batal</button>
                                </div>
                            </div>
                        </div>

                        <!-- TOMBOL SIMPAN -->
                        <div style="margin-top: 20px; text-align: right;">
                            <button class="button-modal-page button-modal-green" @click="submitSoap" :disabled="saving">
                                {{ saving ? 'Menyimpan...' : 'Simpan SOAP' }}
                            </button>
                            <button class="button-modal-page button-modal-red" style="margin-left: 8px;" @click="hide">
                                Tutup
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
import { defineAsyncComponent } from 'vue';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import CKEditor from '@ckeditor/ckeditor5-vue';
import axios from 'axios';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';

var vm;
export default {
    emits: ['saved'],
    components: {
        ckeditor: CKEditor.component,
        RmeSoap: defineAsyncComponent(() => import('../../rme/soap/Soap.vue')),
    },
    data() {
        return {
            show: false,
            saving: false,
            showSignature: false,
            refreshKey: 0,
            editor: ClassicEditor,
            patientData: {
                registrasi_uuid: '',
                pasien_uuid: '',
                nama_pasien: '',
                nama_dokter: '',
                rekam_medis: '',
            },
            form: {
                subject: '',
                object: '',
                assessment: '',
                plan: '',
                ttd: '',
            },
        };
    },
    methods: {
        showModal(data) {
            vm = this;
            vm.patientData = {
                registrasi_uuid: data.uuid,
                pasien_uuid: data.pasien_uuid,
                nama_pasien: data.nama_pasien,
                nama_dokter: data.nama_dokter,
                rekam_medis: data.rekam_medis,
            };
            vm.form = { subject: '', object: '', assessment: '', plan: '', ttd: '' };
            vm.refreshKey += 1;
            vm.show = true;
        },
        hide() {
            vm = this;
            vm.show = false;
            vm.showSignature = false;
        },
        saveSignature() {
            vm = this;
            const { isEmpty, data } = vm.$refs.signaturePad.saveSignature();
            if (!isEmpty) {
                vm.form.ttd = data;
                vm.showSignature = false;
            }
        },
        clearSignature() {
            this.$refs.signaturePad.clearSignature();
        },
        async submitSoap() {
            vm = this;
            if (!vm.form.subject && !vm.form.object && !vm.form.assessment && !vm.form.plan) {
                toast.warning('Mohon isi minimal satu field SOAP.');
                return;
            }
            vm.saving = true;
            try {
                const fd = new FormData();
                fd.append('registrasi_uuid', vm.patientData.registrasi_uuid);
                fd.append('pasien_uuid',     vm.patientData.pasien_uuid);
                fd.append('nama_pasien',     vm.patientData.nama_pasien);
                fd.append('nama_dokter',     vm.patientData.nama_dokter);
                fd.append('rekam_medis',     vm.patientData.rekam_medis);
                fd.append('subject',         vm.form.subject);
                fd.append('object',          vm.form.object);
                fd.append('assessment',      vm.form.assessment);
                fd.append('plan',            vm.form.plan);
                fd.append('ttd',             vm.form.ttd);

                const res = await axios.post('/rawatinap/pasien/save-cppt', fd, {
                    headers: { 'Content-Type': 'multipart/form-data' },
                });

                if (res.data?.data === 'berhasil') {
                    toast.success('SOAP berhasil disimpan.');
                    vm.form = { subject: '', object: '', assessment: '', plan: '', ttd: '' };
                    vm.refreshKey += 1; // refresh history list
                    vm.$emit('saved');
                } else {
                    toast.error('Gagal menyimpan SOAP.');
                }
            } catch (err) {
                console.error(err);
                toast.error('Terjadi kesalahan saat menyimpan.');
            } finally {
                vm.saving = false;
            }
        },
    },
};
</script>

<style scoped>
.modal-overlay-soap {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.55);
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
}
.modal-box-soap {
    background: #fff;
    border-radius: 10px;
    width: 92vw;
    max-width: 1300px;
    max-height: 90vh;
    display: flex;
    flex-direction: column;
    box-shadow: 0 8px 32px rgba(0,0,0,0.22);
    overflow: hidden;
}
.modal-header-soap {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 14px 20px;
    background: #2d6a9f;
    color: #fff;
}
.modal-title-soap {
    font-size: 16px;
    font-weight: 600;
}
.modal-close-soap {
    font-size: 24px;
    cursor: pointer;
    line-height: 1;
}
.modal-close-soap:hover { opacity: 0.75; }
.modal-body-soap {
    flex: 1;
    overflow-y: auto;
    padding: 16px 20px;
}
.soap-label {
    font-weight: 600;
    font-size: 12px;
    color: #555;
    display: block;
    margin-bottom: 4px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
.soap-saving-overlay {
    text-align: center;
    padding: 8px;
    background: #f0f7ff;
    border-radius: 4px;
    margin-bottom: 10px;
    color: #2d6a9f;
    font-weight: 600;
}
.sig-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.5);
    z-index: 10000;
    display: flex;
    align-items: center;
    justify-content: center;
}
.sig-box {
    background: #fff;
    padding: 24px;
    border-radius: 8px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.2);
}
</style>
