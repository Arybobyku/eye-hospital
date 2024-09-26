<template>
    <div :style="terminate_detail.display" class="modal">
        <div ref="rootdetail" class="modal-content modal-besar"
            :class="terminate_detail.show ? 'modal-opened' : 'modal-closed'">
            <div class="modal-header">
                <span class="close" v-on:click="hide()">&times;</span>
                <h2>Rekam Medis Rawat Jalan</h2>
            </div>
            <div class="modal-body" style="height: 100%">
                <div class="grid">
                    <div class="col-4 form-mr">
                        <ul class="list-detail">
                            <li>
                                No Rekam Medis<span><strong>{{
                                        pasien?.rekam_medis ?? "-"
                                        }}</strong></span>
                            </li>
                            <li>
                                Nama Lengkap<span><strong>{{
                                        pasien?.nama ?? "-"
                                        }}</strong></span>
                            </li>
                            <li>
                                Tanggal Lahir<span><strong>{{
                                        pasien?.tanggal_lahir ?? "-"
                                        }}</strong></span>
                            </li>
                        </ul>

                        <table class="table embed" style="border: 0">
                            <tbody>
                                <tr v-if="listResume.length > 0" v-for="(item, index) in listResume">
                                    <td style="font-weight: bold">
                                        {{ item.name }}
                                    </td>
                                    <td style="text-align: right">
                                        <button :class="{
                                                'button-modal-page': true,
                                                'button-modal-green':
                                                    selectedIndex == index,
                                                'button-modal-red':
                                                    selectedIndex != index,
                                            }" v-on:click="look(index)">
                                            Pilih
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <br />
                        <button class="button-modal-page button-modal-green" v-on:click="lookAll">
                            Print All
                        </button>

                        <div class="col-8">
                            <Inputed v-if="form && form.lampiran" @change="onFileChange" :ref="form.lampiran.name"
                                :form="form.lampiran">
                            </Inputed>
                            <div v-if="fileUrl">
                                <template v-if="isImage">
                                    <img :src="fileUrl" alt="Selected Image" />
                                </template>
                                <template v-else-if="isPdf">
                                    <embed :src="fileUrl" type="application/pdf" width="100%" height="100px" />
                                </template>
                            </div>
                        </div>
                        <div v-if="form">
                            <div class="col-4" style="text-align: right" v-if="ishide">
                                <button class="button-modal-page button-modal-red" v-on:click="redbutton()">{{ red
                                    }}</button>
                                <button class="button-modal-page button-modal-green" v-on:click="greenbutton()">{{ green
                                    }}</button>
                            </div>
                            <div class="col-4" style="text-align: right" v-else>
                                <button class="button-modal-page button-modal-red" v-on:click="cancel()">Batalkan
                                    Kunjungan</button>
                                <button class="button-modal-page button-modal-green" v-on:click="edit()">Edit
                                    Data</button>
                            </div>
                        </div>
                    </div>

                    <div class="col-8 form-mr" v-if="linkResume" style="
                            height: 100%;
                            display: flex;
                            flex-direction: column;
                        ">
                        <iframe title="dokumen" width="100%" height="800px" style="border: 0" :src="linkResume">
                        </iframe>
                    </div>
                </div>
            </div>
            <Loader ref="Loader"></Loader>
        </div>
    </div>
</template>

<script>
var vm, body;
import { parseRawatJalan } from "./Attachment.js";
import {
    datename,
    nullAndZero,
    formatrupiah,
} from "../../../module/Manipulation.js";
import {
    defineAsyncComponent
} from 'vue';
import {
    formRekamMedisJalan
} from './FormData.js';


import {
    initindexdb,
    indexdbprocessing
} from '../../../module/Indexdb.js';
import 'vue3-toastify/dist/index.css';
import {
    toast
} from 'vue3-toastify';
import Swal from 'sweetalert2';
export default {
    emits: ["dialog", "parsingForm"],
    components: {
        toast,
        Swal,
        Inputed: defineAsyncComponent(() => import('../../../section/Inputed.vue')),
        Timepicker: defineAsyncComponent(() => import('../../../section/Timepicker.vue')),
        Selected: defineAsyncComponent(() => import('../../../section/Selected.vue')),
        Textarea: defineAsyncComponent(() => import('../../../section/Textarea.vue')),
        DigitalSignature: defineAsyncComponent(() => import('../../digital-signature/DigitalSignature.vue')),
    },
    mounted: function () {
        vm = this;
        body = document.body;
        vm.form = vm.formRekamMedisJalan();

    },
    data: function () {
        return {
            fileUrl: null,
            isImage: false,
            isPdf: false,
            terminate_detail: { show: false, display: "display: none" },
            listdata: [],
            linkResume: "",
            base_url: "",
            green: 'Save Data',
            red: 'Clear Form',
            pendings: 'Ubah Menjadi Pending',
            linkResumeAll: "/print/rekammedis/rawat-jalan/all/",
            selectedIndex: -1,
            listResume: [
                {
                    name: "RM.1.1 General Consent",
                    link: "/print/rekammedis/rawat-jalan/rm1dot1/",
                },
                {
                    name: "RM.1.2 Lembar Edukasi",
                    link: "/print/rekammedis/rawat-jalan/rm1dot2/",
                },
                {
                    name: "RM.1.3 Pengkajiann Keperawatan Mata Rawat Jalan",
                    link: "/print/rekammedis/rawat-jalan/rm1dot3/",
                },
                {
                    name: "RM.1.4 Status Oftalmologis Rawat Jalan",
                    link: "/print/rekammedis/rawat-jalan/rm1dot4/",
                },
                {
                    name: "RM.1.5 Catatan Perkembangan Pasien Terintegrasi (CPPT) Rawat Jalan",
                    link: "/print/rekammedis/rawat-jalan/rm1dot5/",
                },
                {
                    name: "RM.1.6 Resume Perawatan Pasien Rawat Jalan",
                    link: "/print/rekammedis/rawat-jalan/rm1dot6/",
                },
                {
                    name: "RM.1.7 Resume Medis Rawat Jalan",
                    link: "/print/rekammedis/rawat-jalan/rm1dot7/",
                },
            ],
            pasien: null,
        };
    },
    methods: {
        datename,
        nullAndZero,
        formatrupiah,
        parseRawatJalan,
        formRekamMedisJalan,
        onFileChange(event) {
            const file = event.target.files[0];
            if (file) {
                const fileType = file.type;
                if (fileType.startsWith("image/")) {
                    this.isImage = true;
                    vm.form.filetype = 'image';
                    this.isPdf = false;
                    this.fileUrl = URL.createObjectURL(file);
                    
                    this.convertToBase64(file);
                } else if (fileType === "application/pdf") {
                    this.isImage = false;
                    vm.form.filetype = 'pdf';
                    this.isPdf = true;
                    this.fileUrl = URL.createObjectURL(file);
                    this.convertToBase64(file);
                } else {
                    this.resetPreview();
                    alert("Please select an image or PDF file.");
                }
            }
        },
        convertToBase64(file) {
            const reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = () => {
                this.fileBase64 = reader.result.split(',')[1]; // Hanya mengambil bagian base64-nya
                vm.form.fileData = this.fileBase64;
            };
            reader.onerror = error => {
                console.error("Error: ", error);
            };
        },
        resetPreview() {
            this.fileUrl = null;
            this.fileBase64 = null;
            this.isImage = false;
            this.isPdf = false;
        },
        pendingbutton: function () {
            if (vm.form.panjar.value != '' && vm.form.panjar.value != ' ') {
                vm.form.ispending = 'yes';
                vm.action();
            }

        },

        closeform: function () {
            vm.title_racikan = '';
            vm.index_racikan = 0;
        },
        ishide: function () {
            if (vm.test) {
                vm.red = 'Cancel';
            }
            return vm.test ? false : true;
        },
        greenbutton: function () {
            if (vm.green == 'Save Data') {
                console.log(vm.form, 'dfdf')
                vm.action();
            }
        },

        redbutton: function () {
            if (vm.red == 'Clear Form') {
                vm.form = vm.formdetailpulang();
            } else if (vm.red == 'Back') {
                vm.test = vm.temporer;
            }
        },
        empty: function (data) {
            if (!data || data == "" || data == "-" || data == "0") {
                return "-";
            } else {
                return data;
            }
        },
        look: function (index) {
            vm.linkResume = `${vm.base_url}${vm.listResume[index].link}${vm.pasien.uuid}`;
            vm.selectedIndex = index;
        },
        lookAll: function () {
            vm.linkResume = `${vm.base_url}${vm.linkResumeAll}${vm.pasien.uuid}`;
        },
        parsingForm: function () {
            console.log(vm.form);
            vm.$emit("parsingForm", vm.parseRawatJalan(vm.form), "lampiran");
        },
 
        setdataform: function (data) {
            vm.pasien = data;
            vm.loaderprocess();
            console.log("SetDataForm");
            console.log(vm.pasien);
            vm.form.uuid = vm.pasien.uuid;
        },
        aturulang: function () {
            vm.form = vm.formRekamMedisJalan();
        },

        action: function () {
            let next = true;
            for (const key in vm.form) {
                if (key != 'select') {
                    if (vm.form[key].required != '') {
                        if (vm.form[key].value == '') {
                            next = false;
                        }
                    }
                } else {
                    for (const keyselect in vm.form.select) {
                        if (vm.form.select[keyselect].isrequired) {
                            if (vm.form.select[keyselect].value == '') {
                                next = false;
                            }
                        }
                    }
                }
            }

            //if (vm.listdata.length < 1 || vm.listobat.length < 1) { next = false; }
            //if (vm.listdata.length < 1) { next = false; }

            // if (next) {
            vm.parsingForm();
            vm.dialog();
            // }
        },  
        dialog: function () {
            let text = "",
                button = "";
            if (vm.form.posisi == "adddata") {
                text = "Yakin ingin menambah data pada halaman ini.";
                button = "Ya, tambah data";
            } else {
                text = "Yakin ingin memperbaharui data ini.";
                button = "Ya, perbaharui data";
            }
            vm.$emit("dialog", text, button, "rawatjalan");
        },
        show: function () {
            body.style.overflowY = "hidden";
            vm.terminate_detail.display = "display: block";
            vm.terminate_detail.show = true;
        },

        hide: function () {
            vm.terminate_detail.show = false;
            setTimeout(
                function () {
                    vm.terminate_detail.display = "display: none";
                    body.style.overflowY = "auto";
                },
                250,
                this
            );
        },

        loaderprocess: function () {
            const left = this.$refs.rootdetail.getBoundingClientRect();
            vm.$refs.Loader.running(left, "modal", 0);
        },
    },
};
</script>
<style>
table.embed tr td {
    padding: 10px;
    border-bottom: 1px solid #c0c0c0;
}

table.embed tr th {
    padding: 10px;
    border-bottom: 1px solid #c0c0c0;
}
img {
    max-width: 100%;
    height: auto;
    margin-top: 10px;
}

embed {
    margin-top: 10px;
    border: 1px solid #ccc;
}
</style>
