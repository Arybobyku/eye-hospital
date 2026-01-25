<template>
    <div :style="terminate_detail.display" class="modal">
        <div
            ref="rootdetail"
            class="modal-content modal-besar"
            :class="terminate_detail.show ? 'modal-opened' : 'modal-closed'"
        >
            <div class="modal-header">
                <span class="close" v-on:click="hide()">&times;</span>
                <h2>Rekam Medis Rawat Jalan</h2>
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

                        <table class="table embed" style="border: 0">
                            <tbody>
                                <tr
                                    v-if="listResume.length > 0"
                                    v-for="(item, index) in listResume"
                                >
                                    <td style="font-weight: bold">
                                        {{ item.name }}
                                    </td>
                                    <td style="text-align: right">
                                        <button
                                            :class="{
                                                'button-modal-page': true,
                                                'button-modal-green':
                                                    selectedIndex == index,
                                                'button-modal-red':
                                                    selectedIndex != index,
                                            }"
                                            v-on:click="look(index)"
                                        >
                                            Pilih
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <br />
                        <button
                            class="button-modal-page button-modal-green"
                            v-on:click="lookAll"
                        >
                            Print All
                        </button>
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
import {
    datename,
    nullAndZero,
    formatrupiah,
} from "../../../module/Manipulation.js";

export default {
    mounted: function () {
        vm = this;
        body = document.body;
    },
    data: function () {
        return {
            terminate_detail: { show: false, display: "display: none" },
            listdata: [],
            linkResume: "",
            base_url: "",
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
                    link: "/print/rekammedis/rawat-jalan/cpptpoli/",
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
        parsepasien,
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
            vm.$emit("parsingForm", vm.parsepasien(vm.form), "pasien");
        },
        setdataform: function (data) {
            vm.pasien = data;
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
