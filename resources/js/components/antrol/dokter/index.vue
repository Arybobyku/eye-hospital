<template>
    <div class="inner" ref="roottable">
        <div class="grid">
            <div class="col-12">
                <Datatable
                    ref="Datatable"
                    :module="module"
                    @tablereload="tablereload"
                    @tablebutton="tablebutton"
                ></Datatable>
            </div>
        </div>
        <Loader ref="Loader"></Loader>
    </div>
</template>

<script>
var vm;
import { defineAsyncComponent } from "vue";
import {
    nullAndZero,
    datename,
    formatrupiah,
} from "../../../module/Manipulation.js";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";
import Swal from "sweetalert2";
export default {
    emits: ["titletrigger", "repatch"],
    beforeUnmount: function () {},
    components: {
        toast,
        Swal,
        Datatable: defineAsyncComponent(() =>
            import("../../../section/Datatable.vue")
        ),
    },
    created: function () {},
    mounted: function () {
        vm = this;
        setTimeout(() => {
            this.titletrigger();
        }, 250);
        vm.loadmain();
    },
    data: function () {
        return {
            uri: "unit",
            position: "",
            attach: {
                link: {
                    list: "/customerservices/onedaycare/list",
                    add: "/customerservices/onedaycare/add",
                    edit: "/customerservices/onedaycare/edit",
                    update: "/customerservices/onedaycare/update",
                    approve: "/customerservices/onedaycare/approve",
                    diterima: "/customerservices/onedaycare/diterima",
                    dikirim: "/customerservices/onedaycare/dikirim",
                    detail: "/customerservices/onedaycare/detail",
                },
                url: "",
                data: null,
            },
            column: [
                {
                    value: "tanggal",
                    label: "Tanggal Operasi",
                    type: "text",
                    search: true,
                    close: false,
                    button: false,
                },
                {
                    value: "waktu",
                    label: "Waktu Operasi",
                    type: "text",
                    search: true,
                    close: false,
                    button: false,
                },
                {
                    value: "rekam_medis",
                    label: "Rekam Medis",
                    type: "text",
                    search: true,
                    close: false,
                    button: false,
                },
                {
                    value: "carabayar_nama",
                    label: "Pembayaran",
                    type: "text",
                    search: true,
                    close: false,
                    button: false,
                },
                {
                    value: "nama_pasien",
                    label: "Nama Pasien",
                    type: "text",
                    search: true,
                    close: false,
                    button: false,
                },
                {
                    value: "nama_dokter",
                    label: "Dokter yang menangani",
                    type: "text",
                    search: true,
                    close: false,
                    button: false,
                },
                {
                    value: "jenis",
                    label: "Jenis Bedah",
                    type: "text",
                    search: true,
                    close: false,
                    button: false,
                },
                {
                    value: "nama_layanan",
                    label: "Paket Bedah",
                    type: "text",
                    search: true,
                    close: false,
                    button: false,
                },
                {
                    value: "tarif",
                    label: "Harga Paket",
                    type: "text",
                    search: false,
                    close: false,
                    button: false,
                },
                {
                    value: "btnhtml",
                    label: "",
                    type: "text",
                    search: false,
                    close: false,
                    button: false,
                },
            ],
            module: { data: [], column: [], total: 0, ispaging: true },
        };
    },
    methods: {
        /*************************************************************************************************************************
         * Bagian fungsi yang opsional untuk manipulasi data dan string
         *************************************************************************************************************************/
        nullAndZero,
        datename,
        formatrupiah,

        /*************************************************************************************************************************
         * Bagian fungsi untuk pemrosesan table
         *************************************************************************************************************************/

        btnhtml: function (_item, _index) {
            let str = [
                {
                    icon: "send",
                    color: "btn-info",
                    posisi: "kirim",
                    tooltip: "Kirim Data ke Asuransi",
                    item: _item,
                    index: _index,
                    show: _item.posisi == "Permintaan" ? true : false,
                },
                {
                    icon: "check-circle",
                    color: "btn-info",
                    posisi: "proses",
                    tooltip: "Asuransi Disetujui",
                    item: _item,
                    index: _index,
                    show: _item.posisi == "Dikirim" ? true : false,
                },
                {
                    icon: "book",
                    color: "btn-info",
                    posisi: "selesai",
                    tooltip: "Registrasi Pasien",
                    item: _item,
                    index: _index,
                    show: _item.posisi == "Disetujui" ? true : false,
                },
                {
                    icon: "arrow-up",
                    color: "btn-warning",
                    posisi: "detail",
                    tooltip: "Detail Paket Bedah",
                    item: _item,
                    index: _index,
                    show: true,
                },
            ];
            return str;
        },

        tarifs: function (data) {
            return formatrupiah(data.tarif.toString());
        },

        converter: function (data, index, column, identity) {
            let _tmp = "";
            if (identity == "btnhtml") {
                _tmp = {
                    value: vm.btnhtml(data, index),
                    ishtml: "button",
                    show: false,
                    style: "width: 40px; text-align: center",
                };
            } else if (identity == "created_at") {
                _tmp = {
                    value: vm.datename(column, true),
                    ishtml: "html",
                    style: "",
                };
            } else if (identity == "tarif") {
                _tmp = { value: vm.tarifs(data), ishtml: "html", style: "" };
            } else {
                _tmp = { value: column, ishtml: "text", style: "" };
            }
            return _tmp != "" ? _tmp : "empty";
        },

        tablebutton: function (posisi, data, index) {
            if (posisi == "proses") {
                vm.position = "prosesdata";
                vm.attach.data = new FormData();
                vm.attach.data.append("uuid", data.uuid);
                vm.attach.url = vm.attach.link.approve;
                vm.dialog(
                    "Yakin ingin memproses dan melakukan pembedahan pada pasien ini.",
                    "Ya, proses pembedahan",
                    "prosesdata"
                );
            } else if (posisi == "kirim") {
                vm.position = "kirimdata";
                vm.attach.data = new FormData();
                vm.attach.data.append("uuid", data.uuid);
                vm.attach.url = vm.attach.link.dikirim;
                vm.dialog(
                    "Yakin ingin merubah status data menjadi dikirim.",
                    "Ya, ubah status",
                    "kirimdata"
                );
            } else if (posisi == "selesai") {
                vm.position = "selesaidata";
                vm.attach.data = new FormData();
                vm.attach.data.append("uuid", data.uuid);
                vm.attach.url = vm.attach.link.diterima;
                vm.dialog(
                    "Apakah anda yakin ingin meregistrasi operasi pasien ini.",
                    "Ya, registrasi pasien",
                    "selesaidata"
                );
            } else if (posisi == "detail") {
                vm.position = "detaildata";
                vm.$refs.FormDetail.show(
                    "detaildata",
                    "Detail Paket Data",
                    data.uuid
                );
                setTimeout(
                    () => {
                        vm.loadingModal("detaildata");
                    },
                    250,
                    this
                );
                vm.attach.data = new FormData();
                vm.attach.data.append("uuid", data.uuid);
                vm.attach.url = vm.attach.link.detail;
                vm.executions();
            }
        },

        loadingModal: function (position) {
            if (position == "formunit") {
                vm.$refs.FormUnit.loaderprocess();
            } else if (position == "detaildata") {
                vm.$refs.FormDetail.loaderprocess();
            }
        },

        parsingForm: function (data, key) {
            vm.attach.data = data;
            if (key == "unit") {
                if (vm.position == "adddata") {
                    vm.attach.url = vm.attach.link.add;
                } else if (vm.position == "updatedata") {
                    vm.attach.url = vm.attach.link.update;
                }
            }
        },

        setDatatable: function (data, total) {
            let temporer = [],
                col = [];
            for (let i = 0; i < data.length; i++) {
                col = [];
                for (let j = 0; j < vm.column.length; j++) {
                    col.push(
                        vm.converter(
                            data[i],
                            i,
                            data[i][vm.column[j].value]
                                ? data[i][vm.column[j].value]
                                : vm.column[j].value,
                            vm.column[j].value
                        )
                    );
                }
                temporer.push(col);
            }
            vm.module.data = temporer;
            vm.module.total = total;
            return temporer;
        },
        tableload: function () {
            vm.attach.url = vm.attach.link.list;
            vm.attach.data = new FormData();
            vm.attach.data.append("search", "");
            vm.attach.data.append("column", "");
            vm.attach.data.append("page", 1);
            vm.executions();
        },
        tablereload: function (data = new FormData(), pos = "main") {
            if (pos == "outer") {
                vm.$refs.Datatable.skeleton();
            }
            vm.attach.url = vm.attach.link.list;
            vm.attach.data = data;
            vm.position = "externaltable";
            vm.executions();
        },

        /*************************************************************************************************************************
         * Bagian fungsi untuk pemrosesan message, fungsi untuk error dan success
         *************************************************************************************************************************/

        loadmain: () => {
            vm.position = "loadmain";
            vm.firstloader();
            vm.tableload();
        },

        gagal: function (error) {
            if (vm.$debugs) {
                console.log(error.response);
            }
            let active = 0;
            vm.message("error", 1);
            if (vm.position == "loadmain") {
                vm.firstloader();
                active = 1;
            } else if (vm.position == "externaltable") {
                vm.$refs.Datatable.skeleton();
                vm.$refs.Datatable.backpage();
            } else if (vm.position == "adddata") {
                vm.loadingModal("formunit");
            } else if (vm.position == "editdata") {
                vm.loadingModal("formunit");
                vm.$refs.FormUnit.hide();
            } else if (vm.position == "updatedata") {
                vm.loadingModal("formunit");
            } else if (vm.position == "prosesdata") {
                vm.$refs.Datatable.skeleton();
            } else if (vm.position == "selesaidata") {
                vm.$refs.Datatable.skeleton();
            } else if (vm.position == "kirimdata") {
                vm.$refs.Datatable.skeleton();
            }

            /* Bagian ini tidak perlu diubah */
            if (active == 1) {
                setTimeout(
                    function () {
                        vm.$router.push({
                            name: "Error",
                            params: { link: vm.name_vue },
                        });
                    },
                    250,
                    this
                );
            }
        },

        berhasil: function (response) {
            if (vm.$debugs) {
                console.log(response.data);
            }
            let active = 1;
            if (response.data.data == "403") {
                vm.$router.push("/dashboard/forbidden");
            }

            if (vm.position == "loadmain") {
                vm.firstloader();
                vm.$refs.Datatable.update(
                    vm.column,
                    vm.setDatatable(response.data.data, response.data.total),
                    response.data.total
                );
                vm.$refs.Datatable.paging();
                active = 0;
            } else if (vm.position == "externaltable") {
                vm.$refs.Datatable.update(
                    "",
                    vm.setDatatable(response.data.data, response.data.total),
                    response.data.total
                );
                vm.$refs.Datatable.skeleton();
                vm.$refs.Datatable.paging();
                active = 0;
            } else if (vm.position == "adddata") {
                vm.loadingModal("formunit");
                vm.$refs.FormUnit.hide();
                setTimeout(
                    () => {
                        vm.$refs.Datatable.skeleton();
                        vm.tablereload();
                    },
                    500,
                    this
                );
            } else if (vm.position == "editdata") {
                vm.$refs.FormUnit.setdataform(response);
                vm.position = "updatedata";
                active = 0;
            } else if (vm.position == "detaildata") {
                vm.$refs.FormDetail.setdataform(response);
                vm.position = "detaildata";
                active = 0;
            } else if (vm.position == "updatedata") {
                vm.loadingModal("formunit");
                vm.$refs.FormUnit.hide();
                setTimeout(
                    () => {
                        vm.$refs.Datatable.skeleton();
                        vm.tablereload();
                    },
                    500,
                    this
                );
            } else if (vm.position == "prosesdata") {
                setTimeout(
                    () => {
                        vm.tablereload();
                    },
                    125,
                    this
                );
            } else if (vm.position == "selesaidata") {
                setTimeout(
                    () => {
                        vm.tablereload();
                    },
                    125,
                    this
                );
            } else if (vm.position == "kirimdata") {
                setTimeout(
                    () => {
                        vm.tablereload();
                    },
                    125,
                    this
                );
            }
            vm.message("success", active);
        },

        message: function (position, active) {
            if (position == "error") {
                if (vm.position == "loadmain") {
                    vm.notification("Data gagal dimuat.", 3000, position);
                } else if (vm.position == "externaltable") {
                    vm.notification(
                        "Datalist tabel gagal dimuat.",
                        3000,
                        position
                    );
                } else if (vm.position == "adddata") {
                    vm.notification(
                        "Penambahan data gagal diproses.",
                        3000,
                        position
                    );
                } else if (vm.position == "editdata") {
                    vm.notification(
                        "Proses pengambilan data gagal dilakukan.",
                        3000,
                        position
                    );
                } else if (vm.position == "updatedata") {
                    vm.notification(
                        "Pembaharuan data gagal diproses.",
                        3000,
                        position
                    );
                } else if (vm.position == "prosesdata") {
                    vm.notification(
                        "Proses perubahan data gagal diproses.",
                        3000,
                        position
                    );
                } else if (vm.position == "selesaidata") {
                    vm.notification(
                        "Proses perubahan data gagal diproses.",
                        3000,
                        position
                    );
                } else if (vm.position == "kirimdata") {
                    vm.notification(
                        "Proses perubahan data gagal diproses.",
                        3000,
                        position
                    );
                }
            } else if (position == "success" && active == 1) {
                if (vm.position == "adddata") {
                    vm.notification(
                        "Penambahan data berhasil diproses.",
                        3000,
                        position
                    );
                } else if (vm.position == "updatedata") {
                    vm.notification(
                        "Pembaharuan data berhasil diproses.",
                        3000,
                        position
                    );
                } else if (vm.position == "prosesdata") {
                    vm.notification(
                        "Perusahan perubahan data berhasil diproses.",
                        3000,
                        position
                    );
                } else if (vm.position == "selesaidata") {
                    vm.notification(
                        "Perusahan perubahan data berhasil diproses.",
                        3000,
                        position
                    );
                } else if (vm.position == "kirimdata") {
                    vm.notification(
                        "Perusahan perubahan data berhasil diproses.",
                        3000,
                        position
                    );
                }
            }
        },

        runconfirm: function (posisi) {
            if (posisi == "formunit") {
                vm.loadingModal("formunit");
            } else if (posisi == "prosesdata") {
                vm.$refs.Datatable.skeleton();
            } else if (posisi == "selesaidata") {
                vm.$refs.Datatable.skeleton();
            } else if (posisi == "kirimdata") {
                vm.$refs.Datatable.skeleton();
            }
            vm.executions();
        },

        /*************************************************************************************************************************
         * Bagian fungsi yang wajib disertakan disetiap index dan tidak perlu diubah-ubah
         *************************************************************************************************************************/
        executions: function () {
            axios
                .post(vm.attach.url, vm.attach.data, {
                    headers: { "Content-Type": "multipart/form-data" },
                })
                .then(function (response) {
                    if (response.data.data == "419") {
                        window.location.href = "/masuk";
                    }
                    setTimeout(
                        function () {
                            vm.berhasil(response);
                        },
                        750,
                        this
                    );
                })
                .catch(function (error) {
                    setTimeout(
                        function () {
                            vm.gagal(error);
                        },
                        750,
                        this
                    );
                });
        },
        dialog: function (_text, _confirm, posisi) {
            Swal.fire({
                title: "Apakah Anda Yakin?",
                text: _text,
                icon: "warning",
                showCancelButton: !0,
                confirmButtonColor: "#1c84ee",
                cancelButtonColor: "#fd625e",
                confirmButtonText: _confirm,
                cancelButtonText: "Tidak, batal!",
            }).then(function (e) {
                if (e.isConfirmed) {
                    vm.runconfirm(posisi);
                }
            });
        },
        notification: function (message, timer, position) {
            if (position == "error") {
                toast.error(message, { rtl: false, autoClose: timer });
            } else {
                toast.success(message, { rtl: false, autoClose: timer });
            }
        },
        loadPatch: function () {
            vm.firstloader();
        },
        firstloader: function () {
            const left = this.$refs.roottable.getBoundingClientRect();
            vm.$refs.Loader.running(left);
        },
        unloadPatch: function (position) {
            vm.firstloader();
            if (position == "success") {
                vm.notification("Data berhasil dipatch.", 3000, position);
            } else if (position == "error") {
                vm.notification("Data gagal dipatch.", 3000, position);
            }
        },
        titletrigger: function () {
            let title = vm.$router.currentRoute._value.meta.title;
            vm.$emit("titletrigger", title);
        },
    },
};
</script>
