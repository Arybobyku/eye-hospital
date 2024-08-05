<template>
    <div :style="terminate_detail.display" class="modal">
        <div
            ref="rootdetail"
            class="modal-content modal-besar"
            :class="terminate_detail.show ? 'modal-opened' : 'modal-closed'"
        >
            <div class="modal-header">
                <span class="close" v-on:click="hide()">&times;</span>
                <h2>CPPT</h2>
            </div>
            <div class="modal-body" style="height: 100%">
                <div class="grid">
                    <div class="col-4 form-mr">
                        <ul class="list-detail">
                            <li>
                                No Rekam Medis<span
                                    ><strong>{{
                                        pasien?.rekam_medis ?? "-"
                                    }}</strong></span
                                >
                            </li>
                            <li>
                                Nama Lengkap<span
                                    ><strong>{{
                                        pasien?.nama ?? "-"
                                    }}</strong></span
                                >
                            </li>
                            <li>
                                Tanggal Lahir<span
                                    ><strong>{{
                                        pasien?.tanggal_lahir ?? "-"
                                    }}</strong></span
                                >
                            </li>
                        </ul>

                        <div class="col-6 form-ml">
                            <label for=""> SUBJECT </label>
                            <ckeditor v-model="form.subject" :editor="editor">
                            </ckeditor>
                            <br />

                            <label for=""> OBJECT </label>
                            <ckeditor v-model="form.object" :editor="editor">
                            </ckeditor>
                            <br />

                            <label for=""> ASSESSMENT </label>
                            <ckeditor
                                v-model="form.assessment"
                                :editor="editor"
                            >
                            </ckeditor>
                            <br />

                            <label for=""> PLANNING </label>
                            <ckeditor v-model="form.planning" :editor="editor">
                            </ckeditor>

                            <br />
                            <button
                                :class="{
                                    'button-modal-page': true,
                                    'button-modal-green': true
                                }"
                            >
                                Tambah
                            </button>
                        </div>
                    </div>

                    <div
                        class="col-8 form-mr"
                        v-if="linkResume"
                        style="
                            height: 100%;
                            display: flex;
                            flex-direction: column;
                        "
                    >
                        <iframe
                            title="dokumen"
                            width="100%"
                            height="800px"
                            style="border: 0"
                            :src="linkResume"
                        >
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
import { parsepasien } from "./Attachment.js";
import CKEditor from "@ckeditor/ckeditor5-vue";
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
import {
    datename,
    nullAndZero,
    formatrupiah,
} from "../../../module/Manipulation.js";

export default {
    components: {
        ckeditor: CKEditor.component,
    },
    mounted: function () {
        vm = this;
        body = document.body;
    },
    data: function () {
        return {
            terminate_detail: { show: false, display: "display: none" },
            listdata: [],
            editor: ClassicEditor,
            linkResume: "",
            form: {
                subject: "",
                object: "",
                assessment: "",
                planning: "",
            },
            base_url: "http://127.0.0.1:8000",
            linkResumeAll: "/print/rekammedis/rawat-jalan/all/",
            listResume: [
                {
                    name: "RM.1.1",
                    link: "/print/rekammedis/rawat-jalan/rm1dot1/",
                },
                {
                    name: "RM.1.2",
                    link: "/print/rekammedis/rawat-jalan/rm1dot2/",
                },
                {
                    name: "RM.1.3",
                    link: "/print/rekammedis/rawat-jalan/rm1dot3/",
                },
                {
                    name: "RM.1.4",
                    link: "/print/rekammedis/rawat-jalan/rm1dot4/",
                },
                {
                    name: "RM.1.5",
                    link: "/print/rekammedis/rawat-jalan/rm1dot5/",
                },
                {
                    name: "RM.1.6",
                    link: "/print/rekammedis/rawat-jalan/rm1dot6/",
                },
                {
                    name: "RM.1.7",
                    link: "/print/rekammedis/rawat-jalan/rm1dot7/",
                },
                {
                    name: "RM.1.8",
                    link: "/print/rekammedis/rawat-jalan/rm1dot8/",
                },
            ],
            pasien: null,
        };
    },
    methods: {
        datename,
        nullAndZero,
        formatrupiah,
        parsepasien,
        empty: function (data) {
            if (!data || data == "" || data == "-" || data == "0") {
                return "-";
            } else {
                return data;
            }
        },
        look: function () {
            vm.linkResume = `${vm.base_url}/print/rekammedis/rawat-jalan/rm1dot5/${vm.pasien.uuid}`;
        },
        parsingForm: function () {
            vm.$emit("parsingForm", vm.parsepasien(vm.form), "pasien");
        },
        setdataform: function (data) {
            vm.pasien = data;

            vm.look();
            vm.loaderprocess();
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
</style>
