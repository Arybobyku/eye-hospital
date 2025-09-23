<template>
	<div :style="terminate.display" class="modal">
		<div ref="rootmodal" class="modal-content modal-besar"
			:class="terminate.show ? 'modal-opened' : 'modal-closed'">
			<div class="modal-header">
				<button v-on:click="action()" v-if="pembayaran!='Sudah Bayar'">Add or Update</button>
				<span class="close" v-on:click="hide()">&times;</span>
				<h2 v-if="form">{{ form.title }}</h2>
			</div>
			<div class="modal-body" v-if="form">
				<div class="grid">
                    <div class="col-6 form-mr">
                        <ul class="list-detail">
                            <li>
                                Tanggal Pendaftaran<span><strong>{{ datename(detail.tanggal) }}</strong></span>
                            </li>
                            <li>
                                No Rekam Medis<span><strong>{{ detail.rekam_medis }}</strong></span>
                            </li>
                            <li>
                                Nama Lengkap<span><strong>{{ detail.nama_pasien }}</strong></span>
                            </li>
                        </ul>
                    </div>
                    <div class="col-6 form-mr">
                        <ul class="list-detail">
                            <li>
                                Tanggal Lahir<span><strong>{{ datename(detail.tanggal_lahir) }}</strong></span>
                            </li>
                            <li>
                                Jenis Kelamin<span><strong>{{ detail.jenis_kelamin }}</strong></span>
                            </li>
                        </ul>
                    </div>


                </div>
				<div class="grid">
					<div class="col-12">
						<div class="tab-content">
							<div style="position: relative;" class="content-tab-in">
								<div class="grid" >
                                    <div class="col-5 form">
                                    <Selected v-on:click="
                                            selectbox(
                                                $event,
                                                form.select
                                                    .carabayartindakanrawatjalan
                                                    .name,
                                                form.select
                                                    .carabayartindakanrawatjalan
                                                    .statics
                                            )
                                            " :ref="form.select
                                                .carabayartindakanrawatjalan
                                                .name" @selecteditem="selecteditem" @selectclear="selectclear"
                                            :selection="form.select
                                                .carabayartindakanrawatjalan" v-on:keyup="
                                                    selectfilter(
                                                        $event,
                                                        form.select
                                                            .carabayartindakanrawatjalan
                                                            .name
                                                    )
                                                    ">
                                        </Selected>
									</div>

								</div>
								<div class="grid">
									<div class="col-12">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Nama Tindakan</th>
                                                    <th>Biaya</th>
                                                    <th>#</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(
                                                        item, index
                                                    ) in listdata" v-if="listdata.length > 0">
                                                    <td>
                                                        {{ item.nama_tindakan_rawat_jalan }}
                                                    </td>
                                                    <td style="display: none">
                                                        {{ item.is_paket_bedah }}
                                                    </td>
                                                    <td>
                                                        {{ formatrupiah(item.harga.toString()) }}
                                                    </td>
                                                    <td>
                                                        <button v-if="item.default != 'Ya'" class="tooltip btn-danger"
                                                            v-on:click="removetindakan(index)">
                                                            <vue-feather type="trash"></vue-feather>
                                                            <span class="tooltiptext">Hapus
                                                                Tindakan</span>
                                                        </button>
                                                    </td>
                                                </tr>
                                                <tr v-else>
                                                    <td colspan="3">
                                                        No Data for Result
                                                    </td>
                                                </tr>
                                                <tr v-if="listdata.length > 0">
                                                    <td>Total</td>
                                                    <td colspan="2">
                                                        {{ formatrupiah(totalbiaya.toString()) }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
									</div>
								</div>
						</div>
                    </div>
					</div>
				</div>

			</div>
			<Loader ref="Loader"></Loader>
		</div>
    </div>
</template>

<script>
import { defineAsyncComponent } from 'vue';
import { formdetail } from './FormData.js';
import { parsedetail } from './Attachment.js';
import { filterselected, hideselected, itemselected, clearselected, boxselected, conditionselected } from '../../../module/SelectedFilter.js';
import { initindexdb, indexdbprocessing } from '../../../module/Indexdb.js';
import { datename, formatrupiah } from '../../../module/Manipulation.js';
import { arrpemeriksaan } from "../../../module/DataArray.js";

var vm, body;
export default {
	emits: ["dialog", "parsingForm"],
	components: {
		Inputed: defineAsyncComponent(() => import('../../../section/Inputed.vue')),
		Selected: defineAsyncComponent(() => import('../../../section/Selected.vue')),
	},
	mounted:function() { 
		vm = this; body = document.body;
		vm.arr = vm.arrpemeriksaan();
		vm.form = vm.formdetail();

		window.addEventListener("click", function(event) { let a = event.target.className; try { if (a.split(" ")) { a = a.split(" "); if (a[0] != 'hospitals') { vm.selecthide(); } } if (event.target.className == '') { vm.selecthide(); } } catch { console.log('mistmatch'); } })
	},
	created:function() {},
	data:function() { return { 
		title_racikan: '',
		index_racikan: 0,
		quantity_racikan: 0,
		terminate: { show: false, display: 'display: none' },
		form: null, btnlbl: '',
		arr: {
		},
		listdata: [], tempobat: null,  detail: null, pembayaran: '',
		tab: {
			button: [
					{ value: 'nonracikan', label: 'Obat Non Racikan', class: 'tab-active' },
					{ value: 'racikan', label: 'Obat Racikan', class: 'tab-no-active' },
			],
			// racikan: false,
			content: { nonracikan: true, racikan: false }
		},
	}},
	computed: {
        totalbiaya: function () {
            let temp = 0;
            for (let i = 0; i < vm.listdata.length; i++) {
                temp += parseInt(vm.listdata[i].harga);
            }
            let ab = parseInt(temp);
            return ab;
        },

	},
	methods: {

		changesTab: function (values, index, classes) {
			if (classes != 'tab-active') {
				for (let i = 0; i < vm.tab.button.length; i++) { 
					vm.tab.content[vm.tab.button[i].value] = false; vm.tab.button[i].class = 'tab-no-active'; 
				}
				vm.tab.button[index].class = 'tab-active';
				vm.tab.content[values] = true;
			}
		},
        removetindakan: function (index) {
            vm.listdata.splice(index, 1);
        },
	
		showobatracikan:function(item, index) {
			vm.title_racikan = item.label;
			vm.index_racikan = index;
		},

		closeform:function() {
			vm.title_racikan = '';
			vm.index_racikan = 0;
		},

	

		parsedetail, formdetail, formatrupiah, datename,
		initindexdb, indexdbprocessing,
		filterselected, hideselected, itemselected, clearselected, boxselected, conditionselected, arrpemeriksaan,

		selectfilter: function (event, key) { vm.form = vm.filterselected(vm.form, key); },
		selecthide:function() { vm.form = vm.hideselected(vm.form); },
        selecteditem: function (item, key) {
            vm.form = vm.conditionselected(vm.form, item, key, "address");
            vm.form = vm.itemselected(vm.form, item, key);


            if (key == "carabayartindakanrawatjalan") {
                let _item = {
                    nama_tindakan_rawat_jalan: item.nama_tindakan_rawat_jalan,
                    is_paket_bedah: 0,
                    tindakan_rawat_jalan_uuid: item.tindakan_rawat_jalan_uuid,
                    default: item.default,
                    harga: parseInt(item.harga),
                };

                vm.listdata.push(_item);

                vm.form.select.carabayartindakanrawatjalan.value = "";
                vm.form.select.carabayartindakanrawatjalan.label =
                    "Silahkan Pilih";
            }


        },


		selectclear:function(key) { vm.form = vm.clearselected(vm.form, key)
			if(key == "posisimata") {
				vm.tempobat.posisimata = null;
			}; },
		selectbox: function (event, key, statics) {
			let msg = "select-close select-close-" + key;
			if (event.target.className != msg) {
				if (!vm.form.select[key].disabled) {
					let result = vm.boxselected(event, vm.form, key);
					if (result._position == "stop") {
						return;
					} else if (result._position == "nextstop") {
						vm.form = result._form;
					} else {
						vm.selecthide();
						vm.getIndexDB(key, statics);
						vm.form.select[key].option = "display: block";
					}
				}
			}
		},

		getIndexDB:function(key, statics) {
			vm.form.select[key].data = []; vm.form.select[key].filter = [];
			if (statics) { vm.form.select[key].data = this.arr[key]; vm.form.select[key].filter = this.arr[key]; }
			else {
				vm.initindexdb(vm.$dbNameIndexDb, key)
					.then(function(response){ vm.form = vm.indexdbprocessing(response, vm.form, key); })
					.catch(function(error){ console.log(error); });
			}
		},

		removeobat:function(index) {
			vm.listobat.splice(index, 1);
		},

	

		action:function() {
			if (vm.listdata.length > 0) { vm.parsingForm(); vm.dialog(); }
		},

		show:function(posisi, title, uuid, detail){ 
			vm.btnlbl = posisi == 'adddata' ? 'Save Data' : 'Update Data'; 
			vm.form.registrasi_uuid = detail.uuid;
			vm.form.carabayar_nama = detail.carabayar_nama;
			vm.form.carabayar_uuid = detail.carabayar_uuid;
			// vm.pembayaran = pembayaran;
			vm.form.title = title; vm.form.posisi = posisi; 
			vm.form.posisi = posisi; body.style.overflowY = 'hidden'; vm.terminate.display = 'display: block'; vm.terminate.show = true;
    },
		aturulang: function () { 
			vm.form = vm.formdetail(); 
			vm.listdata = [];
			
		},
		hide:function() { vm.terminate.show = false; setTimeout(function() { vm.terminate.display = 'display: none'; body.style.overflowY = 'auto'; }, 250, this); },
		parsingForm:function() { 
			console.log('sss', vm.listdata);
			vm.$emit('parsingForm', vm.parsedetail(vm.form, vm.listdata), 'update'); 
		},

		loaderprocess:function() { const left = this.$refs.rootmodal.getBoundingClientRect(); vm.$refs.Loader.running(left, 'modal', 250); },

		setdataform: function (response) {
			vm.detail = response.data.data;
			vm.form.uuid = response.data.data.uuid;
			console.log('response');
			console.log(response)
			vm.listdata = [];
            for (let i = 0; i < response.data.layanan.length; i++) {
                let _item = {
                    nama_tindakan_rawat_jalan: response.data.layanan[i].nama_layanan,
                    tindakan_rawat_jalan_uuid: response.data.layanan[i].layanan_uuid,
                    is_paket_bedah: response.data.layanan[i].is_paket_bedah,
                    default: response.data.layanan[i].default,
                    harga: parseInt(response.data.layanan[i].tarif),
                };

                vm.listdata.push(_item);
            }
		
			vm.loaderprocess();
		},

		dialog:function(){
			let text = '', button = '';
			text = 'Yakin ingin menambah Layanan halaman ini.';
			button = 'Ya, tambah data';
      vm.$emit('dialog', text, button, 'formdetail');
    },
	}
}
</script>
<style>
.obatracikanclose {
	position: absolute; top: -11px; right: 20px; padding: 0 10px; background: #fff; cursor: pointer; color: #000; font-weight: bold;
}
</style>