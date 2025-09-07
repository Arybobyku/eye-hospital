<style>
    .filter-container {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 16px;
        flex-wrap: wrap;
    }

    .filter-container select,
    .filter-container input {
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 5px;
        width: 150px;
    }

    .filter-container .filter-group {
        display: flex;
        gap: 5px;
        align-items: center;
    }

    .filter-container button {
        background-color: #007bff;
        color: white;
        padding: 8px 12px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background 0.2s;
    }

    .filter-container button:hover {
        background-color: #0056b3;
    }
</style>
<template>
    <div class="filter-container">
        <select v-model="filterType">
            <option value="">Pilih Filter</option>
            <option value="tanggal">Filter Per Tanggal</option>
            <option value="bulan">Filter Per Bulan</option>
        </select>

        <input v-if="filterType === 'tanggal'" type="date" v-model="params1" />

        <div v-if="filterType === 'bulan'" class="filter-group">
            <select v-model="params1">
                <option value="">Pilih Bulan</option>
                <option v-for="(bulan, index) in bulanList" :key="index" :value="index + 1">
                    {{ bulan }}
                </option>
            </select>
            <input type="number" v-model="params2" placeholder="Tahun" />
        </div>


        <button @click="applyFilter">Apply Filter</button>
    </div>
    <div class="inner" ref="roottable" v-show="showDatatable">
        <div class="grid">
            <div class="col-12">
                <Datatable ref="Datatable" :module="module" @tablereload="tablereload" @tablebutton="tablebutton">
                </Datatable>
            </div>
        </div>
        <Loader ref="Loader"></Loader>
    </div>
    <FormUnit ref="FormUnit" @dialog="dialog" @parsingForm="parsingForm"></FormUnit>
</template>

<script>
    var vm;
    import {
        defineAsyncComponent
    } from 'vue';
    import {
        nullAndZero,
        datename
    } from '../../../module/Manipulation.js';
    import {
        toast
    } from 'vue3-toastify';
    import 'vue3-toastify/dist/index.css';
    import Swal from 'sweetalert2';
    export default {
        emits: ["titletrigger", "repatch"],
        beforeUnmount: function() {},
        components: {
            toast,
            Swal,
            FormUnit: defineAsyncComponent(() => import('./FormUnit.vue')),
            Datatable: defineAsyncComponent(() => import('../../../section/Datatable.vue')),
        },
        created: function() {},
        mounted: function() {
            // vm = this;
            // setTimeout(() => {
            //     this.titletrigger();
            // }, 250);
            // vm.loadmain();
			vm = this;
			setTimeout(() => {
				this.titletrigger();
			}, 250);
        },
        data: function() {
            return {
                filterType: "",
                showDatatable: false, // Awalnya tersembunyi
                params1: "",
                params2: "",
                paramsWaktu: "",
                bulanList: [
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
                ],
                uri: 'unit',
                position: '',
                attach: {
                    link: {
                        list: '',
                        add: '/administration/runningimage/add',
                        block: '/administration/runningimage/block',
                    },
                    url: '',
                    data: null
                },
                column: [{
                        value: 'kdppk',
                        label: 'Kode PPK',
                        type: 'text',
                        search: false,
                        close: false,
                        button: false
                    },
                    {
                        value: 'nmppk',
                        label: 'Nama PPK',
                        type: 'text',
                        search: false,
                        close: false,
                        button: false
                    },
                    {
                        value: 'namapoli',
                        label: 'Nama Poli',
                        type: 'text',
                        search: false,
                        close: false,
                        button: false
                    },
                    {
                        value: 'waktu_task1',
                        label: 'Waktu Task 1',
                        type: 'text',
                        search: false,
                        close: false,
                        button: false
                    },
                    {
                        value: 'avg_waktu_task1',
                        label: 'Rata-Rata Waktu Task 1',
                        type: 'text',
                        search: false,
                        close: false,
                        button: false
                    },
                    {
                        value: 'waktu_task2',
                        label: 'Waktu Task 2',
                        type: 'text',
                        search: false,
                        close: false,
                        button: false
                    },
                    {
                        value: 'avg_waktu_task2',
                        label: 'Rata-Rata Waktu Task 2',
                        type: 'text',
                        search: false,
                        close: false,
                        button: false
                    },
                    {
                        value: 'waktu_task3',
                        label: 'Waktu Task 3',
                        type: 'text',
                        search: false,
                        close: false,
                        button: false
                    },
                    {
                        value: 'avg_waktu_task3',
                        label: 'Rata-Rata Waktu Task 3',
                        type: 'text',
                        search: false,
                        close: false,
                        button: false
                    },
                    {
                        value: 'waktu_task4',
                        label: 'Waktu Task 4',
                        type: 'text',
                        search: false,
                        close: false,
                        button: false
                    },
                    {
                        value: 'avg_waktu_task4',
                        label: 'Rata-Rata Waktu Task 4',
                        type: 'text',
                        search: false,
                        close: false,
                        button: false
                    },
                    {
                        value: 'waktu_task5',
                        label: 'Waktu Task 5',
                        type: 'text',
                        search: false,
                        close: false,
                        button: false
                    },
                    {
                        value: 'avg_waktu_task5',
                        label: 'Rata-Rata Waktu Task 5',
                        type: 'text',
                        search: false,
                        close: false,
                        button: false
                    },
                    {
                        value: 'waktu_task6',
                        label: 'Waktu Task 6',
                        type: 'text',
                        search: false,
                        close: false,
                        button: false
                    },
                    {
                        value: 'avg_waktu_task6',
                        label: 'Rata-Rata Waktu Task 6',
                        type: 'text',
                        search: false,
                        close: false,
                        button: false
                    },
                    {
                        value: 'tanggal',
                        label: 'Tanggal',
                        type: 'text',
                        search: false,
                        close: false,
                        button: false
                    },
                    // { value: 'status', label: 'Status', type: 'text', search: true, close: false, button: false },
                    // {
                    //     value: 'btnhtml',
                    //     label: '',
                    //     type: 'text',
                    //     search: false,
                    //     close: false,
                    //     button: true
                    // }
                ],
                module: {
                    data: [],
                    column: [],
                    total: 0,
                    ispaging: true
                },
            }
        },
        methods: {
            nullAndZero,
            datename,

            /*************************************************************************************************************************
             * Bagian fungsi untuk pemrosesan table
             *************************************************************************************************************************/
			async applyFilter() {
				if (!this.filterType) {
					alert("Silakan pilih jenis filter terlebih dahulu");
					return;
				}

				let url = '';
				if (this.filterType === "tanggal") {
					if (!this.params1) {
						alert("Silakan pilih tanggal");
						return;
					}
                    url = `/api/bpjs//antrol-bpjs/dashboard/waktutunggu/tanggal/${this.params1}?ts=${Date.now()}`;
				} else if (this.filterType === "bulan") {
					if (!this.params1 || !this.params2) {
						alert("Silakan pilih bulan dan tahun");
						return;
					}
                    url = `/api/bpjs//antrol-bpjs/dashboard/waktutunggu/bulan/${this.params1}/tahun/${this.params2}?ts=${Date.now()}`;
				}

				try {
					this.showDatatable = false;
					// this.firstloader();

					const response = await axios.get(url);

					// Cek jika response null atau data kosong
                    if (!response.data || !response.data.response || response.data.response.length === 0) {
						this.notification('Data tidak ditemukan untuk filter yang dipilih', 3000, 'error');
						this.showDatatable = false; // Pastikan tabel tetap tersembunyi
						return;
					}

					// Proses data response ke datatable
                    const processedData = this.setDatatable(response.data.response, response.data.response.length);
					this.module.data = processedData;
					this.module.total = response.data.data.length;

                    this.$refs.Datatable.update(this.column, processedData, response.data.response.length);
					this.$refs.Datatable.paging();

					this.showDatatable = true;
				} catch (error) {
					console.error("Gagal mengambil data", error);
					if (error.response && error.response.status === 404) {
						this.notification('Data tidak ditemukan', 3000, 'error');
					} else {
						this.notification('Gagal memuat data', 3000, 'error');
					}
				} finally {
					this.$refs.Loader.close();
				}
			},
            btnhtml: function(_item, _index) {
                let str = [{
                    icon: 'x-circle',
                    color: 'btn-danger',
                    posisi: 'block',
                    tooltip: 'Delete Gambar',
                    item: _item,
                    index: _index,
                    show: true
                }, ]
                return str;
            },

            contents: function(data) {
                return '<img src="/' + data.content + '" width="150" height="125">';
            },

            converter: function(data, index, column, identity) {
                let _tmp = '';
                if (identity == 'btnhtml') {
                    _tmp = {
                        value: vm.btnhtml(data, index),
                        ishtml: 'button',
                        show: false,
                        style: 'width: 40px; text-align: center'
                    }
                } else if (identity == 'created_at') {
                    _tmp = {
                        value: vm.datename(column, true),
                        ishtml: 'html',
                        style: ''
                    };
                } else if (identity == 'content') {
                    _tmp = {
                        value: vm.contents(data),
                        ishtml: 'html',
                        style: ''
                    };
                } else {
                    _tmp = {
                        value: column,
                        ishtml: 'text',
                        style: ''
                    }
                }
                return _tmp != '' ? _tmp : 'empty';
            },

            tablebutton: function(posisi, data, index) {
                if (posisi == 'add') {
                    vm.$refs.FormUnit.aturulang();
                    vm.position = "adddata";
                    vm.$refs.FormUnit.show('adddata', 'Tambah Data', '');
                }
                else if (posisi == 'block') {
                    vm.position = "blockdata";
                    vm.attach.data = new FormData();
                    vm.attach.data.append('uuid', data.uuid);
                    vm.attach.url = vm.attach.link.block;
                    vm.dialog('Yakin ingin menghapus data yang terpilih dihalaman ini.', 'Ya, hapus data',
                        'blockdata');
                }
            },

            loadingModal: function(position) {
                if (position == 'formunit') {
                    vm.$refs.FormUnit.loaderprocess();
                }
            },

            parsingForm: function(data, key) {
                vm.attach.data = data;
                if (key == 'unit') {
                    if (vm.position == 'adddata') {
                        vm.attach.url = vm.attach.link.add;
                    } else if (vm.position == 'updatedata') {
                        vm.attach.url = vm.attach.link.update;
                    }
                }
            },

            setDatatable: function(data, total) {
                let temporer = [],
                    col = [];
                for (let i = 0; i < data.length; i++) {
                    col = [];
                    for (let j = 0; j < vm.column.length; j++) {
                        col.push(vm.converter(data[i], i, data[i][vm.column[j].value] ? data[i][vm.column[j]
                            .value] : vm.column[j].value, vm.column[j].value));
                    }
                    temporer.push(col);
                }
                vm.module.data = temporer;
                vm.module.total = total;
                return temporer;
            },
            tableload: function() {
                vm.attach.url = vm.attach.link.list;
                vm.attach.data = new FormData();
                vm.attach.data.append('search', '');
                vm.attach.data.append('column', '');
                vm.attach.data.append('page', 1);
                vm.executions();
            },
            tablereload: function(data = new FormData(), pos = 'main') {
                if (pos == 'outer') {
                    vm.$refs.Datatable.skeleton();
                }
                vm.attach.url = vm.attach.link.list;
                vm.attach.data = data;
                vm.position = 'externaltable';
                vm.executions();
            },

            /*************************************************************************************************************************
             * Bagian fungsi untuk pemrosesan message, fungsi untuk error dan success
             *************************************************************************************************************************/

            loadmain: () => {
                vm.position = 'loadmain';
                vm.firstloader();
                vm.tableload();
            },

            gagal: function(error) {
                if (vm.$debugs) {
                    console.log(error.response);
                }
                let active = 0;
                vm.message('error', 1);
                if (vm.position == 'loadmain') {
                    vm.firstloader();
                    active = 1;
                } else if (vm.position == 'externaltable') {
                    vm.$refs.Datatable.skeleton();
                    vm.$refs.Datatable.backpage();
                } else if (vm.position == 'adddata') {
                    vm.loadingModal('formunit');
                } else if (vm.position == 'editdata') {
                    vm.loadingModal('formunit');
                    vm.$refs.FormUnit.hide();
                } else if (vm.position == 'updatedata') {
                    vm.loadingModal('formunit');
                } else if (vm.position == 'blockdata') {
                    vm.$refs.Datatable.skeleton();
                } else if (vm.position == 'activedata') {
                    vm.$refs.Datatable.skeleton();
                }

                /* Bagian ini tidak perlu diubah */
                if (active == 1) {
                    setTimeout(function() {
                        vm.$router.push({
                            name: 'Error',
                            params: {
                                link: vm.name_vue
                            }
                        })
                    }, 250, this);
                }
            },

            berhasil: function(response) {
                if (vm.$debugs) {
                    console.log(response.data);
                }
                let active = 1;
                if (response.data.data == '403') {
                    vm.$router.push('/dashboard/forbidden');
                }

                if (vm.position == 'loadmain') {
                    vm.firstloader();
                    vm.$refs.Datatable.update(vm.column, vm.setDatatable(response.data.data, response.data.total),
                        response.data.total);
                    vm.$refs.Datatable.paging();
                    active = 0;
                } else if (vm.position == 'externaltable') {
                    vm.$refs.Datatable.update('', vm.setDatatable(response.data.data, response.data.total), response
                        .data.total);
                    vm.$refs.Datatable.skeleton();
                    vm.$refs.Datatable.paging();
                    active = 0;
                } else if (vm.position == 'adddata') {
                    vm.loadingModal('formunit');
                    vm.$refs.FormUnit.hide();
                    setTimeout(() => {
                        vm.$refs.Datatable.skeleton();
                        vm.tablereload();
                    }, 500, this);
                } else if (vm.position == 'editdata') {
                    vm.$refs.FormUnit.setdataform(response);
                    vm.position = "updatedata";
                    active = 0;
                } else if (vm.position == 'updatedata') {
                    vm.loadingModal('formunit');
                    vm.$refs.FormUnit.hide();
                    setTimeout(() => {
                        vm.$refs.Datatable.skeleton();
                        vm.tablereload();
                    }, 500, this);
                } else if (vm.position == 'blockdata') {
                    setTimeout(() => {
                        vm.tablereload();
                    }, 125, this);
                } else if (vm.position == 'activedata') {
                    setTimeout(() => {
                        vm.tablereload();
                    }, 125, this);
                }
                vm.message('success', active);
            },

            message: function(position, active) {
                if (position == 'error') {
                    if (vm.position == 'loadmain') {
                        vm.notification('Data gagal dimuat.', 3000, position);
                    } else if (vm.position == 'externaltable') {
                        vm.notification('Datalist tabel gagal dimuat.', 3000, position);
                    } else if (vm.position == 'adddata') {
                        vm.notification('Penambahan data gagal diproses.', 3000, position);
                    } else if (vm.position == 'editdata') {
                        vm.notification('Proses pengambilan data gagal dilakukan.', 3000, position);
                    } else if (vm.position == 'updatedata') {
                        vm.notification('Pembaharuan data gagal diproses.', 3000, position);
                    } else if (vm.position == 'blockdata') {
                        vm.notification('Penghapusan data gagal diproses.', 3000, position);
                    } else if (vm.position == 'activedata') {
                        vm.notification('Pengaktifan data gagal diproses.', 3000, position);
                    }
                } else if (position == 'success' && active == 1) {
                    if (vm.position == 'adddata') {
                        vm.notification('Penambahan data berhasil diproses.', 3000, position);
                    } else if (vm.position == 'updatedata') {
                        vm.notification('Pembaharuan data berhasil diproses.', 3000, position);
                    } else if (vm.position == 'blockdata') {
                        vm.notification('Penghapusan data berhasil diproses.', 3000, position);
                    } else if (vm.position == 'activedata') {
                        vm.notification('Pengaktifan data berhasil diproses.', 3000, position);
                    }
                }
            },

            runconfirm: function(posisi) {
                if (posisi == 'formunit') {
                    vm.loadingModal('formunit');
                } else if (posisi == 'blockdata') {
                    vm.$refs.Datatable.skeleton();
                } else if (posisi == 'activedata') {
                    vm.$refs.Datatable.skeleton();
                }
                vm.executions();
            },

            /*************************************************************************************************************************
             * Bagian fungsi yang wajib disertakan disetiap index dan tidak perlu diubah-ubah
             *************************************************************************************************************************/
            executions: function() {
                axios.post(vm.attach.url, vm.attach.data, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }).then(function(response) {
                    if (response.data.data == '419') {
                        window.location.href = '/masuk';
                    }
                    setTimeout(function() {
                        vm.berhasil(response);
                    }, 750, this);
                }).catch(function(error) {
                    setTimeout(function() {
                        vm.gagal(error);
                    }, 750, this);  
                });
            },
            dialog: function(_text, _confirm, posisi) {
                Swal.fire({
                    title: "Apakah Anda Yakin?",
                    text: _text,
                    icon: "warning",
                    showCancelButton: !0,
                    confirmButtonColor: "#1c84ee",
                    cancelButtonColor: "#fd625e",
                    confirmButtonText: _confirm,
                    cancelButtonText: "Tidak, batal!"
                }).then(function(e) {
                    if (e.isConfirmed) {
                        vm.runconfirm(posisi);
                    }
                });
            },
            notification: function(message, timer, position) {
                if (position == 'error') {
                    toast.error(message, {
                        rtl: false,
                        autoClose: timer
                    });
                } else {
                    toast.success(message, {
                        rtl: false,
                        autoClose: timer
                    });
                }
            },
            loadPatch: function() {
                vm.firstloader();
            },
            firstloader: function() {
                const left = this.$refs.roottable.getBoundingClientRect();
                vm.$refs.Loader.running(left);
            },
            unloadPatch: function(position) {
                vm.firstloader();
                if (position == 'success') {
                    vm.notification('Data berhasil dipatch.', 3000, position);
                } else if (position == 'error') {
                    vm.notification('Data gagal dipatch.', 3000, position);
                }
            },
            titletrigger: function() {
                let title = vm.$router.currentRoute._value.meta.title;
                vm.$emit('titletrigger', title);
            }
        }
    }
</script>
