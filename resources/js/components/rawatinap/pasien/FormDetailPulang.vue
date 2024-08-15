<template>
    <div :style="terminate.display" class="modal">
        <div ref="rootmodal" class="modal-content modal-besar"
            :class="terminate.show ? 'modal-opened' : 'modal-closed'">
            <div class="modal-header">
                <span class="close" v-on:click="hide()">&times;</span>
                <h2>Form Pasien Pulang</h2>
            </div>
            <div class="modal-body" v-if="form">
                <div class="grid">
                    <div class="col-4 form-mr">
                        <ul class="list-detail">
                            <!-- <li>Tanggal Pendaftaran<span><strong>{{ datename(detail . tanggal) }}</strong></span></li>
                            <li>No Rekam Medis<span><strong>{{ detail . rekam_medis }}</strong></span></li>
                            <li>Nama Lengkap<span><strong>{{ detail . nama_pasien }}</strong></span></li>
                            <li>Tanggal Lahir<span><strong>{{ datename(detail . tanggal_lahir) }}</strong></span></li>
                            <li>Jenis Kelamin<span><strong>{{ detail . jenis_kelamin }}</strong></span></li> -->
                        </ul>
                    </div>
                    <div class="col-8">

                        <div class="grid">

                            <div class="col-8">
                                <Inputed :ref="form.tanggal_keluar_inap.name" :form="form.tanggal_keluar_inap">
                                </Inputed>
                            </div>
                            <div class="col-4 form-ml">
                                <!-- <Inputed :ref="form.waktuodc.name" :form="form.waktuodc"></Inputed> -->
                                <!-- <Timepicker :ref="form.waktu_keluar_inap.name" :form="form.waktu_keluar_inap">
                                </Timepicker> -->
                                <Timepicker  :ref="form.waktu_keluar_inap.name"
                                    :form="form.waktu_keluar_inap">
                                </Timepicker>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="grid" style="border-top: 1px solid #d0d0d0; padding-top: 20px;" v-if="form">
                <div class="col-8"></div>
                <div class="col-4" style="text-align: right" v-if="ishide">
                    <button class="button-modal-page button-modal-red" v-on:click="redbutton()">{{ red }}</button>
                    <button class="button-modal-page button-modal-green" v-on:click="greenbutton()">{{ green
                        }}</button>
                </div>
                <div class="col-4" style="text-align: right" v-else>
                    <button class="button-modal-page button-modal-red" v-on:click="cancel()">Batalkan
                        Kunjungan</button>
                    <button class="button-modal-page button-modal-green" v-on:click="edit()">Edit Data</button>
                </div>
            </div>

        </div>
        <Loader ref="Loader"></Loader>
    </div>

    <div style=""></div>
</template>

<script>
    import {
        defineAsyncComponent
    } from 'vue';
    import {
        formdetailpulang
    } from './FormData.js';
    import {
        parsedetailpulang
    } from './Attachment.js';
    import {
        filterselected,
        hideselected,
        itemselected,
        clearselected,
        boxselected,
        conditionselected
    } from '../../../module/SelectedFilter.js';
    import {
        initindexdb,
        indexdbprocessing
    } from '../../../module/Indexdb.js';
    import 'vue3-toastify/dist/index.css';
    import {
        toast
    } from 'vue3-toastify';
    import Swal from 'sweetalert2';
    import {
        arrpemeriksaan
    } from '../../../module/DataArray.js';
    import {
        datename,
        formatrupiah
    } from '../../../module/Manipulation.js';



    var vm, body;
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
        computed: {
            htgquantity: function() {
                console.log(vm.tempobatracikan)
                if (vm.tempobatracikan) {
                    let hasil = (vm.form.dosisdiperlukan.value * vm.listobatracikan[vm.index_racikan].jumlah) / vm
                        .form.komposisi.value;
                    let m = Math.ceil(hasil);
                    vm.quantity_racikan = m;
                    if (m == hasil) {
                        return "Quantity obat yang digunakan sebanyak " + hasil + " " + vm.tempobatracikan
                            .nama_satuan_kecil;
                    }
                    return "Quantity obat yang digunakan sebanyak " + hasil + " dibulatkan menjadi " + m + " " + vm
                        .tempobatracikan.nama_satuan_kecil;
                }
                return '-';
            },
            ishide: function() {
                if (vm.test) {
                    vm.red = 'Cancel';
                }
                return vm.test ? false : true;
            },
            totalbiaya: function() {
                let temp = 0;
                for (let i = 0; i < vm.listdata.length; i++) {
                    temp += parseInt(vm.listdata[i].harga);
                }
                let ab = parseInt(temp);
                return ab;
            },
            totalbiayajalan: function() {
                let temp = 0;
                for (let i = 0; i < vm.listdatajalan.length; i++) {
                    temp += parseInt(vm.listdatajalan[i].harga);
                }
                let ab = parseInt(temp);
                return ab;
            },
            totalobat: function() {
                let temp = 0;
                for (let i = 0; i < vm.listobat.length; i++) {
                    temp += parseInt(vm.listobat[i].total);
                }
                let ab = parseInt(temp);
                return ab;
            },
        },
        mounted: function() {
            vm = this;
            body = document.body;
            vm.form = vm.formdetailpulang();
            vm.arr = vm.arrpemeriksaan();
            window.addEventListener("click", function(event) {
                let a = event.target.className;
                try {
                    if (a.split(" ")) {
                        a = a.split(" ");
                        if (a[0] != 'hospitals') {
                            vm.selecthide();
                        }
                    }
                    if (event.target.className == '') {
                        vm.selecthide();
                    }
                } catch {
                    console.log('mistmatch');
                }
            });
        },
        created: function() {},
        data: function() {
            return {
            
                terminate: {
                    show: false,
                    display: 'display: none'
                },
                form: null,
                btnlbl: '',
                arr: {
                    // pilihanplan: [
                    //     { value: 'Rawat Inap Operasi', label: 'Rawat Inap + Operasi' },
                    //     { value: 'Rawat Inap', label: 'Rawat Inap' },
                    //     { value: 'Operasi', label: 'Operasi' }
                    // ]
                },
                green: 'Save Data',
                red: 'Clear Form',
                pendings: 'Ubah Menjadi Pending',
                typingTimer: null,
                doneTypingInterval: 5000,
            }
        },
        methods: {
            formatrupiah,



            pendingbutton: function() {
                if (vm.form.panjar.value != '' && vm.form.panjar.value != ' ') {
                    vm.form.ispending = 'yes';
                    vm.action();
                }

            },



            closeform: function() {
                vm.title_racikan = '';
                vm.index_racikan = 0;
            },



            greenbutton: function() {
                if (vm.green == 'Save Data') {
                    console.log(vm.form, 'dfdf')
                    vm.action();
                }
            },

            redbutton: function() {
                if (vm.red == 'Clear Form') {
                    vm.form = vm.formdetailpulang();
                } else if (vm.red == 'Back') {
                    vm.test = vm.temporer;
                }
            },

           

            parsedetailpulang,
            formdetailpulang,
            initindexdb,
            indexdbprocessing,
            arrpemeriksaan,
            datename,
            filterselected,
            hideselected,

            boxselected,
            conditionselected,

            selectfilter: function(event, key) {
                vm.form = vm.filterselected(vm.form, key);
            },

            selectfilter: function(event, jambu, key) {

                vm.form = vm.filterselected(vm.form, jambu);
                // let nilai = event.target.value;
                // vm.form.select[jambu].dosearch = true;
                // 	if (this.typingTimer) {
                // 		clearTimeout(this.typingTimer);
                // 		this.typingTimer = null;
                // 	}
                // 	this.typingTimer = setTimeout(() => {
                // 		vm.doneTyping(nilai, key, jambu)
                // 	}, 1500);
            },
            // doneTyping:function(nilai, key, jambu) {
            // 	console.log(vm.detail.carabayar_nama, ' ', vm.detail.carabayar_uuid)

            // 	let formdata = new FormData();
            // 	formdata.append('search', nilai);
            // 	formdata.append('key', key);
            // 	formdata.append('carabayar_uuid', vm.detail.carabayar_uuid);
            // 	axios.post('/searchion/searching', formdata, 
            // 		{ headers: { 'Content-Type': 'multipart/form-data' } }
            // 	).then(function (response) { 
            // 		setTimeout(function(){ 
            // 			vm.form.select[jambu].dosearch = false; 
            // 			vm.form.select[jambu].filter = response.data;
            // 		}, 150, this); 
            // 	}).catch(function (error) { 
            // 		setTimeout(function(){ vm.form.select[jambu].dosearch = false; console.log(error); }, 150, this); 
            // 	});
            // },
            selecthide: function() {
                vm.form = vm.hideselected(vm.form);
            },
            selecteditem: function(item, key) {
                vm.form = vm.conditionselected(vm.form, item, key, 'address');
                vm.form = vm.itemselected(vm.form, item, key);

      
            },

            getIndexDB: function(key, statics) {
                vm.form.select[key].data = [];
                vm.form.select[key].filter = [];
                if (statics) {
                    vm.form.select[key].data = this.arr[key];
                    vm.form.select[key].filter = this.arr[key];
                }

                if (statics) {
                    vm.form.select[key].data = this.arr[key];
                    vm.form.select[key].filter = this.arr[key];
                } else {
                    vm.initindexdb(vm.$dbNameIndexDb, key)
                        .then(function(response) {
                            vm.form = vm.indexdbprocessing(response, vm.form, key);

                        })
                        .catch(function(error) {
                            console.log(error);
                        });
                }
            },

            action: function() {
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

            nullcheck: function(data) {
                if (!data || data == '-' || data == ' ' || data == '0' || data == '') {
                    return '';
                }
                return data;
            },

            show: function(posisi, title, uuid) {
                vm.btnlbl = posisi == 'inapdata' ? 'Save Data' : 'Update Data';
                console.log("btnvl");
                console.log(posisi);
                console.log(vm.btnlbl);
                vm.form.uuid = uuid;
                vm.form.title = title;
                vm.form.posisi = posisi;
                vm.form.posisi = posisi;
                body.style.overflowY = 'hidden';
                vm.terminate.display = 'display: block';
                vm.terminate.show = true;
            },
            aturulang: function() {
                vm.form = vm.formdetailpulang();
            },
            hide: function() {
                vm.terminate.show = false;
                setTimeout(function() {
                    vm.terminate.display = 'display: none';
                    body.style.overflowY = 'auto';
                }, 250, this);
            },
            parsingForm: function() {
                // for (let i = 0; i < vm.listdata.length; i++) {
                // 	vm.listdata[i].harga = vm.listdata[i].harga.replace(/\D/g, "");
                // }

                // for (let i = 0; i < vm.listdatajalan.length; i++) {
                // 	vm.listdatajalan[i].harga = vm.listdatajalan[i].harga.replace(/\D/g, "");
                // }

                // for (let i = 0; i < vm.listobat.length; i++) {
                // 	vm.listobat[i].hja_resep = vm.listobat[i].hja_resep.replace(/\D/g, "");
                // 	vm.listobat[i].total = vm.listobat[i].total.replace(/\D/g, "");
                // }

                
                console.log('WAKTU KELUAR INAP', `${vm.form.waktu_keluar_inap.value.HH}:${vm.form.waktu_keluar_inap.value.mm}`)
                vm.$emit('parsingForm', vm.parsedetailpulang(vm.form), 'pulang');
            },

            loaderprocess: function() {
                const left = this.$refs.rootmodal.getBoundingClientRect();
                vm.$refs.Loader.running(left, 'modal', 250);
            },

            setdataform: function(response) {
                let waktu = response.data.data.waktu_keluar_inap;
                let tgl = response.data.data.tanggal_keluar_inap;

                // let keys = ['kamar_inap']
                // console.log("keys");
                // console.log(keys);
                /* Setting index DB */
                // vm.updatedblocal(keys, response);


  
                // vm.form.carabayar_nama = vm.detail.carabayar_nama;



                //vm.listdata = response.data.layanan;
                console.log("tanggal_keluar_inap");
                console.log(tgl);
                console.log(waktu);
                
                if (tgl > '2000-01-01'){
                    vm.form.tanggal_keluar_inap.value = tgl;
                } else {
                    vm.form.tanggal_keluar_inap.value = '';   
                }

                if (waktu != "" ) {
                    vm.form.waktu_keluar_inap.value = waktu;
                } else {
                    vm.form.waktu_keluar_inap.value = '';
                }




                // vm.form.tanggal_keluar_inap.value = '';
                // vm.form.waktu_keluar_inap.value = '';
                console.log('UUID');
                console.log(response.data.data.uuid);
                vm.form.uuid = response.data.data.uuid;
             

                

                vm.loaderprocess();
            },

            dialog: function() {
                let text = '',
                    button = '';
                console.log("kontol");
                console.log(vm.form.posisi);
                if (vm.form.posisi == 'inapdata') {
                    text = 'Yakin ingin menambah data pada halaman ini.';
                    button = 'Ya, tambah data';
                } else {
                    text = 'Yakin ingin memperbaharui data ini.';
                    button = 'Ya, perbaharui data';
                }
                vm.$emit('dialog', text, button, 'inapdata');
            },

            setlocalstorage: function() {
                if (window.localStorage.getItem("version") === null) {
                    window.localStorage.setItem("version", 1);
                } else {
                    let tmp = window.localStorage.getItem("version");
                    window.localStorage.setItem("version", (parseInt(tmp) + 1));
                }
            },

            updatedblocal: function(keys, response) {
                vm.setlocalstorage();

                const open = window.indexedDB.open(vm.$dbNameIndexDb, window.localStorage.getItem("version"));
                open.onupgradeneeded = (event) => {
                    let db = open.result;
                    for (let i = 0; i < keys.length; i++) {
                        if (db.objectStoreNames.contains(keys[i])) {
                            db.deleteObjectStore(keys[i]);
                        }
                    }
                }
                open.onsuccess = function() {
                    open.result.close();
                    setTimeout(() => {
                        vm.createdIndexDb(response);
                    }, 350, this);
                };
                open.onerror = function() {
                    open.result.close();
                    alert('dfs');
                    if (vm.count < 3) {
                        setTimeout(() => {
                            vm.updatedblocal(response);
                        }, 350, this);
                        vm.count += 1;
                    }
                };
                open.onblocked = function() {
                    open.result.close();
                    alert('bl');
                    if (vm.count < 3) {
                        setTimeout(() => {
                            vm.updatedblocal(response);
                        }, 350, this);
                        vm.count += 1;
                    }
                };
            },

            createdIndexDb: function(data) {

                vm.setlocalstorage();


            },
        }
    }
</script>
<style>
    /* @import 'vue3-timepicker/dist/VueTimepicker.css'; */
    .obatracikanclose {
        position: absolute;
        top: -11px;
        right: 20px;
        padding: 0 10px;
        background: #fff;
        cursor: pointer;
        color: #000;
        font-weight: bold;
    }
</style>
