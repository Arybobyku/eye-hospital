<template>
    <div :style="terminate_detail.display" class="modal">
        <div
            ref="rootdetail"
            class="modal-content modal-besar"
            :class="terminate_detail.show ? 'modal-opened' : 'modal-closed'"
        >
            <div class="modal-header">
                <span class="close" v-on:click="hide()">&times;</span>
                <h2>Rekam Medis Bedah</h2>
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
            base_url: "http://127.0.0.1:8000",
            linkResumeAll: "/print/rekammedis/bedah/all_bedah/",
            selectedIndex: -1,
            listResume: [
                {
                    name: "RM.1.8 Persetujuan Tindakan Kedokteran",
                    link: "/print/rekammedis/bedah/rm1dot8/",
                },
                {
                    name: "RM.1.9 Site Marking",
                    link: "/print/rekammedis/bedah/rm1dot9/",
                },
                {
                    name: "RM.1.10 Proses Perawatan Peri Operative",
                    link: "/print/rekammedis/bedah/rm1dot10/",
                },
                {
                    name: "RM.2.0 Checklist Kesiapan Bedah",
                    link: "/print/rekammedis/bedah/rm2dot0/",
                },
                {
                    name: "RM.2.2 Laporan Pembedahan",
                    link: "/print/rekammedis/bedah/rm2dot2/",
                },
                {
                    name: "RM.2.3 Catatan Operasi",
                    link: "/print/rekammedis/bedah/rm2dot3/",
                },
                {
                    name: "RM.2.9 Pelaksanaan Pencegahan Pasien Jatuh",
                    link: "/print/rekammedis/bedah/rm2dot9/",
                },
                {
                    name: "RM.4.9 Checklist Keselamatan Pasien Operasi",
                    link: "/print/rekammedis/bedah/rm4dot9/",
                },
                {
                    name: "Rekam Medis Tindakan",
                    link: "/print/rekammedis/bedah/rm8dot7/",
                },
                // {
                //     name: "RM.8.8 Laporan Injeksi Anti Vega",
                //     link: "/print/rekammedis/bedah/rm8dot8/",
                // },
                // {
                //     name: "RM.8.9 Form Tindakan Laser PRP Capsulotomy",
                //     link: "/print/rekammedis/bedah/rm8dot9/",
                // },
                // {

                //     name: "RM.8.10 Laporan Operasi Trabekulektomi",
                //     link: "/print/rekammedis/bedah/rm8dot10/",
                // },
                // {
                //     name: "RM.9.0 Laporan Operasi Pterygium",
                //     link: "/print/rekammedis/bedah/rm9dot0/",
                // },
                // {
                //     name: "RM.9.1 Laporan Insisi Chalazion",
                //     link: "/print/rekammedis/bedah/rm9dot1/",
                // },
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
