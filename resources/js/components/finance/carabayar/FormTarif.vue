<template>
	<div :style="terminate.display" class="modal">
		<div ref="rootmodal" class="modal-content modal-besar" :class="terminate.show ? 'modal-opened' : 'modal-closed'">
			<div class="modal-header">
				<span class="close" v-on:click="hide()">&times;</span>
				<h2 v-if="form">{{ form.title }} <strong>{{ carabayar_nama }}</strong></h2>
			</div>
			<div class="modal-body" v-if="form">
				<div class="grid">
					<div class="col-12">
						
						<div class="tab-lines"><div class="tab"><button v-for="(item, index) in tab.button" :class="item.class" v-on:click="changesTab(item.value, index, item.class)">{{ item.label }}</button></div></div>

						<div class="tab-content">

							<div class="content-tab-in" v-if="tab.content.rawatjalan">
								<div class="grid">
									<div class="col-4 form-mr">
										<Selected v-on:click="selectbox($event, form.select.tindakanrawatjalan.name, form.select.tindakanrawatjalan.statics)" 
										:ref="form.select.tindakanrawatjalan.name" @selecteditem="selecteditem" @selectclear="selectclear"
										:selection="form.select.tindakanrawatjalan" v-on:keyup="selectfilter($event, form.select.tindakanrawatjalan.name)"></Selected>
									</div>
									<div class="col-3 form-mr">
										<Selected v-on:click="selectbox($event, form.select.defaulttindakan.name, form.select.defaulttindakan.statics)" 
										:ref="form.select.defaulttindakan.name" @selecteditem="selecteditem" @selectclear="selectclear"
										:selection="form.select.defaulttindakan" v-on:keyup="selectfilter($event, form.select.defaulttindakan.name)"></Selected>
									</div>
									<div class="col-3 form-mr form-ml">	
										<Inputed :ref="form.harga.tindakanrawatjalan.name" :form="form.harga.tindakanrawatjalan"></Inputed>
									</div>
									<div class="col-2">	
										<button v-on:click="add('tindakanrawatjalan')" 
											v-if="!statusedit.tindakanrawatjalan" class="button-modal-page button-modal-green" style="margin-top: 13px;">ADD</button>
										<template v-else>
											<button v-on:click="update('tindakanrawatjalan')" class="button-modal-page button-modal-green" style="margin-top: 13px;">Update</button>
											<button v-on:click="cancel('tindakanrawatjalan')" class="button-modal-page button-modal-red" style="margin-top: 13px;">Cancel</button>
										</template>
										
									</div>
								</div>

								<table class="table">
									<thead>
										<tr>
											<th colspan="3">
												<div class="form-self-group">
												<input placeholder="Search atau Cari disini" v-on:keyup="filterpage($event, 'tindakanrawatjalan')" v-model="search['tindakanrawatjalan']" />
												</div>
											</th>
										</tr>
										<tr>
											<th>Nama Tindakan</th>
											<th>Harga Tindakan</th>
											<th>Default</th>
											<th>#</th>
										</tr>
									</thead>
									<tbody>
										<tr v-if="datatablesed.tindakanrawatjalan.length > 0" v-for="(item, index) in datatablesed.tindakanrawatjalan">
											<td>{{ item.nama_tindakan_rawat_jalan }}</td>
											<td>{{ formatrupiah(item.harga.toString()) }}</td>
											<td>{{ item.default }}</td>
											<td>
												<button class="tooltip btn-danger">
													<vue-feather type="trash-2" v-on:click="remove(item, index, 'tindakanrawatjalan')"></vue-feather> <span class="tooltiptext">Delete Data</span>
												</button>
												<button class="tooltip btn-warning">
													<vue-feather type="edit" v-on:click="edit(item, index, 'tindakanrawatjalan')"></vue-feather> <span class="tooltiptext">Edit Data</span>
												</button>
											</td>
										</tr>
										<tr  v-else>
											<td colspan="2">No Data for Result</td>
										</tr>
									</tbody>
								</table>

								<div class="pagination" v-if="totalpage.tindakanrawatjalan > 0" style="margin-top: 20px;">
									<a href="javascript:void(0)" v-on:click="prev()">&laquo;</a>
									<a href="javascript:void(0)" v-for="i in totalpage.tindakanrawatjalan" v-on:click="getpage(i, 'tindakanrawatjalan')" :class="page.tindakanrawatjalan == i ? 'active':''">{{ i }}</a>
									<a href="javascript:void(0)" v-on:click="next()">&raquo;</a>
								</div>
							</div>

							<div class="content-tab-in" v-if="tab.content.nonbedah">
								<div class="grid">
									<div class="col-4 form-mr">
										<Selected v-on:click="selectbox($event, form.select.tindakannonbedah.name, form.select.tindakannonbedah.statics)" 
										:ref="form.select.tindakannonbedah.name" @selecteditem="selecteditem" @selectclear="selectclear"
										:selection="form.select.tindakannonbedah" v-on:keyup="selectfilter($event, form.select.tindakannonbedah.name)"></Selected>
									</div>
									<div class="col-3 form-mr">
										<Inputed :ref="form.default.tindakannonbedah.name" :form="form.default.tindakannonbedah"></Inputed>
									</div>
									<div class="col-3 form-mr form-ml">	
										<Inputed :ref="form.harga.tindakannonbedah.name" :form="form.harga.tindakannonbedah"></Inputed>
									</div>
									<div class="col-2">	
										<button v-on:click="add('tindakannonbedah')" 
											v-if="!statusedit.tindakannonbedah" class="button-modal-page button-modal-green" style="margin-top: 13px;">ADD</button>
										<template v-else>
											<button v-on:click="update('tindakannonbedah')" class="button-modal-page button-modal-green" style="margin-top: 13px;">Update</button>
											<button v-on:click="cancel('tindakannonbedah')" class="button-modal-page button-modal-red" style="margin-top: 13px;">Cancel</button>
										</template>
									</div>
								</div>

								<table class="table">
									<thead>
										<tr>
											<th colspan="3">
												<div class="form-self-group">
												<input placeholder="Search atau Cari disini" v-on:keyup="filterpage($event, 'tindakannonbedah')" v-model="search['tindakannonbedah']" />
												</div>
											</th>
										</tr>
										<tr>
											<th>Nama Tindakan</th>
											<th>Harga Tindakan</th>
											<th>Default</th>
											<th>#</th>
										</tr>
									</thead>
									<tbody>
										<tr v-if="datatablesed.tindakannonbedah.length > 0" v-for="(item, index) in datatablesed.tindakannonbedah">
											<td>{{ item.nama_tindakan_non_bedah }}</td>
											<td>{{ formatrupiah(item.harga.toString()) }}</td>
											<td>{{ item.default }}</td>
											<td>
												<button class="tooltip btn-danger">
													<vue-feather type="trash-2" v-on:click="remove(item, index, 'tindakannonbedah')"></vue-feather> <span class="tooltiptext">Delete Data</span>
												</button>
												<button class="tooltip btn-warning">
													<vue-feather type="edit" v-on:click="edit(item, index, 'tindakannonbedah')"></vue-feather> <span class="tooltiptext">Edit Data</span>
												</button>
											</td>
										</tr>
										<tr  v-else>
											<td colspan="2">No Data for Result</td>
										</tr>
									</tbody>
								</table>

								<div class="pagination" v-if="totalpage.tindakannonbedah > 0" style="margin-top: 20px;">
									<a href="javascript:void(0)" v-on:click="prev()">&laquo;</a>
									<a href="javascript:void(0)" v-for="i in totalpage.tindakannonbedah" v-on:click="getpage(i, 'tindakannonbedah')" :class="page.tindakannonbedah == i ? 'active':''">{{ i }}</a>
									<a href="javascript:void(0)" v-on:click="next()">&raquo;</a>
								</div>
							</div>

							<div class="content-tab-in" v-if="tab.content.bedah">
								<div class="grid">
									<div class="col-3 form-mr">
										<Selected v-on:click="selectbox($event, form.select.jenis.name, form.select.jenis.statics)" 
										:ref="form.select.jenis.name" @selecteditem="selecteditem" @selectclear="selectclear"
										:selection="form.select.jenis"></Selected>
									</div>
									<div class="col-5 form-mr form-ml">	
										<Selected v-on:click="selectbox($event, form.select.tindakanbedah.name, form.select.tindakanbedah.statics)" 
										:ref="form.select.tindakanbedah.name" @selecteditem="selecteditem" @selectclear="selectclear"
										:selection="form.select.tindakanbedah" v-on:keyup="selectfilter($event, form.select.tindakanbedah.name)"></Selected>
									</div>
									<div class="col-2 form-mr">
										<Inputed :ref="form.default.tindakanbedah.name" :form="form.default.tindakannonbedah"></Inputed>
									</div>
									<div class="col-2 form-ml">	
										<Inputed :ref="form.vvipharga.tindakanbedah.name" :form="form.vvipharga.tindakanbedah"></Inputed>
									</div>
									<div class="col-2 form-mr">	
										<Inputed :ref="form.vipharga.tindakanbedah.name" :form="form.vipharga.tindakanbedah"></Inputed>
									</div>
									<div class="col-2 form-mr form-ml">	
										<Inputed :ref="form.kelas1harga.tindakanbedah.name" :form="form.kelas1harga.tindakanbedah"></Inputed>
									</div>
									<div class="col-3 form-mr form-ml">	
										<Inputed :ref="form.kelas2harga.tindakanbedah.name" :form="form.kelas2harga.tindakanbedah"></Inputed>
									</div>
									<div class="col-3 form-mr form-ml">	
										<Inputed :ref="form.kelas3harga.tindakanbedah.name" :form="form.kelas3harga.tindakanbedah"></Inputed>
									</div>
									<div class="col-2 form-ml">	
										<button v-on:click="add('tindakanbedah')" 
											v-if="!statusedit.tindakanbedah" class="button-modal-page button-modal-green" style="margin-top: 13px;">ADD</button>
										<template v-else>
											<button v-on:click="update('tindakanbedah')" class="button-modal-page button-modal-green" style="margin-top: 13px;">Update</button>
											<button v-on:click="cancel('tindakanbedah')" class="button-modal-page button-modal-red" style="margin-top: 13px;">Cancel</button>
										</template>
									</div>
								</div>

								<table class="table">
									<thead>
										<tr>
											<th colspan="8">
												<div class="form-self-group">
												<input placeholder="Search atau Cari disini" v-on:keyup="filterpage($event, 'tindakanbedah')" v-model="search['tindakanbedah']" />
												</div>
											</th>
										</tr>
										<tr>
											<th>Jenis Tindakan</th>
											<th>Nama Tindakan</th>
											<th>Harga VVIP</th>
											<th>Harga VIP</th>
											<th>Harga Kelas I</th>
											<th>Harga Kelas II</th>
											<th>Harga Kelas III</th>
											<th>Default</th>
											<th>#</th>
										</tr>
									</thead>
									<tbody>
										<tr v-if="datatablesed.tindakanbedah.length > 0" v-for="(item, index) in datatablesed.tindakanbedah">
											<td>{{ item.jenis_tindakan_bedah }}</td>
											<td>{{ item.nama_tindakan_bedah }}</td>
											<td>{{ formatrupiah(item.vvip_harga.toString()) }}</td>
											<td>{{ formatrupiah(item.vip_harga.toString()) }}</td>
											<td>{{ formatrupiah(item.kelas1_harga.toString()) }}</td>
											<td>{{ formatrupiah(item.kelas2_harga.toString()) }}</td>
											<td>{{ formatrupiah(item.kelas3_harga.toString()) }}</td>
											<td>{{ item.default }}</td>
											<td>
												<button class="tooltip btn-danger">
													<vue-feather type="trash-2" v-on:click="remove(item, index, 'tindakanbedah')"></vue-feather> <span class="tooltiptext">Delete Data</span>
												</button>
												<button class="tooltip btn-warning">
													<vue-feather type="edit" v-on:click="edit(item, index, 'tindakanbedah')"></vue-feather> <span class="tooltiptext">Edit Data</span>
												</button>
											</td>
										</tr>
										<tr  v-else>
											<td colspan="2">No Data for Result</td>
										</tr>
									</tbody>
								</table>

								<div class="pagination" v-if="totalpage.tindakanbedah > 0" style="margin-top: 20px;">
									<a href="javascript:void(0)" v-on:click="prev()">&laquo;</a>
									<a href="javascript:void(0)" v-for="i in totalpage.tindakanbedah" v-on:click="getpage(i, 'tindakanbedah')" :class="page.tindakanbedah == i ? 'active':''">{{ i }}</a>
									<a href="javascript:void(0)" v-on:click="next()">&raquo;</a>
								</div>
							</div>

							<div class="content-tab-in" v-if="tab.content.jeniskamar">
								<div class="grid">
									<div class="col-3 form-mr">
										<Selected v-on:click="selectbox($event, form.select.jeniskamar.name, form.select.jeniskamar.statics)" 
										:ref="form.select.jeniskamar.name" @selecteditem="selecteditem" @selectclear="selectclear"
										:selection="form.select.jeniskamar" v-on:keyup="selectfilter($event, form.select.jeniskamar.name)"></Selected>
									</div>
									<div class="col-2 form-mr">
										<Inputed :ref="form.default.tindakanbedah.name" :form="form.default.tindakannonbedah"></Inputed>
									</div>
									<div class="col-2 form-mr form-ml">	
										<Inputed :ref="form.harga.jeniskamar.name" :form="form.harga.jeniskamar"></Inputed>
									</div>
									<div class="col-3 form-mr form-ml">	
										<Inputed :ref="form.hitungan.jeniskamar.name" :form="form.hitungan.jeniskamar"></Inputed>
									</div>
									<div class="col-2">	
										<button v-on:click="add('jeniskamar')" 
											v-if="!statusedit.jeniskamar" class="button-modal-page button-modal-green" style="margin-top: 13px;">ADD</button>
										<template v-else>
											<button v-on:click="update('jeniskamar')" class="button-modal-page button-modal-green" style="margin-top: 13px;">Update</button>
											<button v-on:click="cancel('jeniskamar')" class="button-modal-page button-modal-red" style="margin-top: 13px;">Cancel</button>
										</template>
									</div>
								</div>

								<table class="table">
									<thead>
										<tr>
											<th colspan="4">
												<div class="form-self-group">
												<input placeholder="Search atau Cari disini" v-on:keyup="filterpage($event, 'jeniskamar')" v-model="search['jeniskamar']" />
												</div>
											</th>
										</tr>
										<tr>
											<th>Jenis Kamar</th>
											<th>Harga Kamar</th>
											<th>Hitungan</th>
											<th>Default</th>
											<th>#</th>
										</tr>
									</thead>
									<tbody>
										<tr v-if="datatablesed.jeniskamar.length > 0" v-for="(item, index) in datatablesed.jeniskamar">
											<td>{{ item.nama_jenis_kamar }}</td>
											<td>{{ formatrupiah(item.harga.toString()) }}</td>
											<td>{{ item.jenis }}</td>
											<td>{{ item.default }}</td>
											<td>
												<button class="tooltip btn-danger">
													<vue-feather type="trash-2" v-on:click="remove(item, index, 'jeniskamar')"></vue-feather> <span class="tooltiptext">Delete Data</span>
												</button>
												<button class="tooltip btn-warning">
													<vue-feather type="edit" v-on:click="edit(item, index, 'jeniskamar')"></vue-feather> <span class="tooltiptext">Edit Data</span>
												</button>
											</td>
										</tr>
										<tr  v-else>
											<td colspan="2">No Data for Result</td>
										</tr>
									</tbody>
								</table>

								<div class="pagination" v-if="totalpage.jeniskamar > 0" style="margin-top: 20px;">
									<a href="javascript:void(0)" v-on:click="prev()">&laquo;</a>
									<a href="javascript:void(0)" v-for="i in totalpage.jeniskamar" v-on:click="getpage(i, 'jeniskamar')" :class="page.jeniskamar == i ? 'active':''">{{ i }}</a>
									<a href="javascript:void(0)" v-on:click="next()">&raquo;</a>
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
import { formtarif } from './FormData.js';
import { parsetarif } from './Attachment.js';
import { filterselected, hideselected, itemselected, clearselected, boxselected, conditionselected } from '../../../module/SelectedFilter.js';
import { initindexdb, indexdbprocessing } from '../../../module/Indexdb.js';
import { arrdefault } from '../../../module/DataArray.js';
import { formatrupiah } from '../../../module/Manipulation.js';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
import Swal from 'sweetalert2';
var vm, body;
export default {
	emits: ["dialog", "parsingForm"],
	components: { toast, Swal, 
		Inputed: defineAsyncComponent(() => import('../../../section/Inputed.vue')),
		Selected: defineAsyncComponent(() => import('../../../section/Selected.vue')),
	},
	mounted:function() { 
		vm = this; body = document.body;
		vm.arr = vm.arrdefault();
		vm.form = vm.formtarif();
		window.onclick = function(event) { let a = event.target.className; try { if (a.split(" ")) { a = a.split(" "); if (a[0] != 'hospitals') { vm.selecthide(); } } if (event.target.className == '') { vm.selecthide(); } } catch { console.log('mistmatch'); } }
	},
	created:function() {},
	data:function() { return { 
		terminate: { show: false, display: 'display: none' }, pos: '',
		form: null, arr: null, btnlbl: '', carabayar_nama: '', carabayar_uuid: '',

		statusedit: {
			tindakanrawatjalan: false,
			tindakannonbedah: false,
			tindakanbedah: false,
			jeniskamar: false,
		},
		
		listdata: {
			tindakanrawatjalan: [],
			tindakannonbedah: [],
			tindakanbedah: [],
			jeniskamar: [],
		},

		datatablesed: {
			tindakanrawatjalan: [],
			tindakannonbedah: [],
			tindakanbedah: [],
			jeniskamar: [],
		}, 
		page : {
			tindakanrawatjalan: 1,
			tindakannonbedah: 1,
			tindakanbedah: 1,
			jeniskamar: 1,
		},
		totalpage: {
			tindakanrawatjalan: 0,
			tindakannonbedah: 0,
			tindakanbedah: 0,
			jeniskamar: 0,
		},
		filtertable: {
			tindakanrawatjalan: [],
			tindakannonbedah: [],
			tindakanbedah: [],
			jeniskamar: [],
		},
		search: {
			tindakanrawatjalan: '',
			tindakannonbedah: '',
			tindakanbedah: '',
			jeniskamar: '',
		},
		
		attach: {
			link : {
				adddata : {
					tindakanrawatjalan: '/finance/carabayar/tarif/tindakanrawatjalan/add',
					tindakannonbedah: '/finance/carabayar/tarif/tindakannonbedah/add',
					tindakanbedah: '/finance/carabayar/tarif/tindakanbedah/add',
					jeniskamar: '/finance/carabayar/tarif/jeniskamar/add',
				},
				removedata: { 
					tindakanrawatjalan: '/finance/carabayar/tarif/tindakanrawatjalan/remove',
					tindakannonbedah: '/finance/carabayar/tarif/tindakannonbedah/remove',
					tindakanbedah: '/finance/carabayar/tarif/tindakanbedah/remove',
					jeniskamar: '/finance/carabayar/tarif/jeniskamar/remove',
				},
			}, url: '', data: null
		},
		tab: {
			button: [
				{ value: 'rawatjalan', label: 'Data Tindakan', class: 'tab-active' },
				// { value: 'nonbedah', label: 'Tindakan Non Bedah', class: 'tab-no-active' },
				// { value: 'bedah', label: 'Tindakan Bedah', class: 'tab-no-active' },
				// { value: 'jeniskamar', label: 'Biaya Kamar', class: 'tab-no-active' },
			],
			content: { 
				rawatjalan: true, 
				// nonbedah: false, 
				// bedah: false, 
				// jeniskamar: false 
			}
		},
	}},
	methods: {
		formatrupiah,
		parsetarif, formtarif, initindexdb, indexdbprocessing, arrdefault,
		filterselected, hideselected, itemselected, clearselected, boxselected, conditionselected,

		selectfilter: function (event, key) { vm.form = vm.filterselected(vm.form, key); },
		selecthide:function() { vm.form = vm.hideselected(vm.form); },
		selecteditem:function(item, key) { 
			vm.form = vm.conditionselected(vm.form, item, key, 'address'); 
			vm.form = vm.itemselected(vm.form, item, key); 
			if (key == 'tindakanbedah') {
				vm.form.jenis = item.jenis;
			}
		},
		selectclear:function(key) { vm.form = vm.clearselected(vm.form, key); },
		selectbox:function(event, key, statics) {
			let result = vm.boxselected(event, vm.form, key);
			if (result._position == 'stop') { return ; }
			else if (result._position == 'nextstop') { vm.form = result._form; }
			else { vm.selecthide(); vm.getIndexDB(key, statics); vm.form.select[key].option = 'display: block'; }
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

		changesTab: function (values, index, classes) {
			if (classes != 'tab-active') {
				for (let i = 0; i < vm.tab.button.length; i++) { 
					vm.tab.content[vm.tab.button[i].value] = false; vm.tab.button[i].class = 'tab-no-active'; 
				}
				vm.tab.button[index].class = 'tab-active';
				vm.tab.content[values] = true;

				for (const key in vm.statusedit) {
					vm.statusedit[key] = false;
					vm.form.uuid = '';
				}
			}
		},

		setdataform: function (response) {
			for (let i = 0; i < vm.tab.button.length; i++) { 
				vm.tab.content[vm.tab.button[i].value] = false; vm.tab.button[i].class = 'tab-no-active'; 
			}
			vm.tab.button[0].class = 'tab-active';
			vm.tab.content.rawatjalan = true;

			vm.listdata.tindakanrawatjalan = response.data.tindakanrawatjalan;
			vm.listdata.tindakannonbedah = response.data.tindakannonbedah;
			vm.listdata.tindakanbedah = response.data.tindakanbedah;
			vm.listdata.jeniskamar = response.data.jeniskamar;

			vm.setfisrtpaging();
			vm.carabayar_nama = response.data.data.nama;
			vm.carabayar_uuid = response.data.data.uuid;
			vm.form.carabayar_uuid = response.data.data.uuid;
			vm.form.carabayar_nama = response.data.data.nama;
			vm.loaderprocess();
		},

		show:function(posisi, title, uuid){
			vm.form.title = title; vm.form.posisi = posisi; 
			vm.form.posisi = posisi; body.style.overflowY = 'hidden'; vm.terminate.display = 'display: block'; vm.terminate.show = true;
    },
		aturulang: function (key) { 
			vm.form = vm.formtarif();
			vm.form.select.defaulttindakan.value = 'Tidak';
			vm.form.select.defaulttindakan.label = 'Tidak';
			for (const key in vm.listdata) { 
				vm.listdata[key] = [];
				vm.datatablesed[key] = [];
				vm.page[key] = 1;
				vm.totalpage[key] = 0;
				vm.filtertable[key] = [];
				vm.search[key] = '';
			}
			
		},
		hide:function() { vm.terminate.show = false; setTimeout(function() { vm.terminate.display = 'display: none'; body.style.overflowY = 'auto'; }, 250, this); },
		loaderprocess:function() { const left = this.$refs.rootmodal.getBoundingClientRect(); vm.$refs.Loader.running(left, 'modal', 250); },

		/*
		*	Bagian untuk datatable filter dan pagination
		*/

		swappingvalue:function() {
			vm.form.carabayar_uuid = vm.carabayar_uuid;
			vm.form.carabayar_nama = vm.carabayar_nama;
		},
		
		update: function(keyin) {
			let next = true;
			for (const key in vm.form) { 
				if (key != 'select') { 
					if (vm.form[key][keyin]) {
						if (vm.form[key][keyin].required != '') { 
							if (vm.form[key][keyin].value == '') { next = false; } 
						} 
					}
					
				}
				else {
					for (const keyselect in vm.form.select) {
						if (keyselect == keyin) {
							if (vm.form.select[keyselect].isrequired) { if (vm.form.select[keyselect].value == '') { next = false; } }
						}	
					}
				}
			}
			if (next) { 
				vm.pos='add'; 
				vm.form.posisi = keyin; 
				vm.attach.url = vm.attach.link.adddata[keyin]; 
				vm.attach.data = vm.parsetarif(vm.form, keyin); 
				vm.dialog(keyin); 
			}
		},

		add: function(keyin) {
			let next = true;
			for (const key in vm.form) { 
				if (key != 'select') { 
					if (vm.form[key][keyin]) {
						if (vm.form[key][keyin].required != '') { 
							if (vm.form[key][keyin].value == '') { next = false; } 
						} 
					}
					
				}
				else {
					for (const keyselect in vm.form.select) {
						if (keyselect == keyin) {
							if (vm.form.select[keyselect].isrequired) { if (vm.form.select[keyselect].value == '') { next = false; } }
						}	
					}
				}
			}
			if (next) { 
				vm.pos='add'; 
				vm.form.posisi = keyin; 
				vm.attach.url = vm.attach.link.adddata[keyin]; 
				vm.attach.data = vm.parsetarif(vm.form, keyin); 
				vm.dialog(keyin); }
		},

		remove:function(item, index, key) {
			vm.pos='remove'; 
			vm.form.posisi = key;
			vm.form.uuid = item.uuid;
			vm.attach.url = vm.attach.link.removedata[key];
			vm.attach.data = vm.parsetarif(vm.form, key);
			vm.dialog(key);
		},

		edit:function(item, index, key) {
			vm.statusedit[key] = true;
			console.log(item);
			vm.form.uuid = item.uuid;
			if (key == 'tindakanrawatjalan' || key == 'tindakannonbedah') {
				vm.form.select[key].label = item.nama_tindakan_rawat_jalan;
				vm.form.select[key].value = item.tindakan_rawat_jalan_uuid;
				vm.form.harga[key].value = item.harga;
				vm.form.select.defaulttindakan.label = item.default;
				vm.form.select.defaulttindakan.value = item.default;
				//vm.form.default[key].value = item.default;
			}
			else if (key == 'tindakanbedah') {
				vm.form.select.jenis.label = item.jenis_tindakan_bedah;
				vm.form.select.jenis.value = item.jenis_tindakan_bedah;
				vm.form.select[key].label = item.nama_tindakan_rawat_jalan;
				vm.form.select[key].value = item.tindakan_rawat_jalan_uuid;
				vm.form.default[key].value = item.default;
				vm.form.vvipharga.value = item.vvipharga;
				vm.form.vipharga.value = item.vipharga;
				vm.form.kelas1harga.value = item.kelas1harga;
				vm.form.kelas2harga.value = item.kelas2harga;
				vm.form.kelas3harga.value = item.kelas3harga;
			}
			else if (key == 'jeniskamar') {
				vm.form.select.jeniskamar.label = item.nama_jenis_kamar;
				vm.form.select.jeniskamar.value = item.jenis_kamar_uuid;
				vm.form.harga.jeniskamar.value = item.harga;
				vm.form.hitungan.jeniskamar.value = item.jenis;
				vm.form.default.jeniskamar.value = item.default;
			}
			
		},

		cancel:function(key) {
			vm.statusedit[key] = false;
			vm.form.uuid = '';

			if (key == 'tindakanrawatjalan' || key == 'tindakannonbedah') {
				vm.form.select[key].label = 'Silahkan Pilih';
				vm.form.select[key].value = '';
				vm.form.harga[key].value = '';
			}
			else if (key == 'tindakanbedah') {
				vm.form.select.jenis.label = 'Silahkan Pilih';
				vm.form.select.jenis.value = '';
				vm.form.select[key].label = 'Silahkan Pilih';
				vm.form.select[key].value = '';
				vm.form.vvipharga.value = '';
				vm.form.vipharga.value = '';
				vm.form.kelas1harga.value = '';
				vm.form.kelas2harga.value = '';
				vm.form.kelas3harga.value = '';
			}
			else if (key == 'jeniskamar') {
				vm.form.select.jeniskamar.label = 'Silahkan Pilih';
				vm.form.select.jeniskamar.value = '';
				vm.form.harga.jeniskamar.value = '';
				vm.form.hitungan.jeniskamar.value = '';
			}
		},

		filterpage: function (event, key) {
			if (event.key == 'Enter') {
				vm.page[key] = 1;
				var filter = "nama";
				if (key == 'tindakanrawatjalan') { filter = 'nama_tindakan_rawat_jalan'; }
				else if (key == 'tindakannonbedah') { filter = 'nama_tindakan_non_bedah'; }
				else if (key == 'tindakanbedah') { filter = 'nama_tindakan_bedah'; }
				else if (key == 'jeniskamar') { filter = 'nama_jenis_kamar'; }
				var keyword = event.target.value;
				if (keyword.trim() != '') { keyword = keyword.toLowerCase(); }
				let temp = vm.listdata[key].filter(function(obj) { return obj[filter].toLowerCase().includes(keyword); });
				let data = [];
				for (let i = 0; i < temp.length; i++) {
					for (let j = 0; j < data.length; j++) {
						if (data[j][filter] == temp[i][filter]){ break; }
						if (j == (data.length - 1)) { data.push(temp[i]); }
					}
					if (data.length < 1) { data.push(temp[i]); }
				}
				vm.filtertable[key] = data;
				vm.setreloadpaging(key);
			}
		},

		setreloadpaging:function(key) {
			vm.datatablesed[key] = [];
			if (vm.filtertable[key].length > 0) {
				vm.totalpage[key] = parseInt(vm.filtertable[key].length / 10);
				let sisa = vm.filtertable[key].length % 10;
				if (sisa > 0) { vm.totalpage[key] += 1; }
				for (let i = 0; i < 10; i++) { if (i < vm.filtertable[key].length) { vm.datatablesed[key].push(vm.filtertable[key][i]); } }
			}
		},

		prev:function(key) {
			if (vm.page[key] != 1) {
				let item = vm.page[key] - 1;
				vm.datatablesed[key] = [];
				vm.page[key] = item;
				let mulai = 0;
				let data = vm.filtertable[key].length > 0 ? vm.filtertable[key] : vm.listdata[key];
				if (item > 1) { mulai = ((item - 1) * 10) + 1; }
				for (let i = mulai; i < (item * 10)+1; i++) { if (i < data.length){ vm.datatablesed[key].push(vm.listdata[key][i]); } }
			}
		},

		next:function(key) {
			if ((vm.page[key]+1) <= vm.totalpage[key]) {
				let item = vm.page[key] + 1;
				vm.datatablesed[key] = [];
				vm.page[key] = item;
				let mulai = 0;
				let data = vm.filtertable[key].length > 0 ? vm.filtertable[key] : vm.listdata[key];
				if (item > 1) { mulai = ((item - 1) * 10) + 1; }
				for (let i = mulai; i < (item * 10)+1; i++) { if (i < data.length){ vm.datatablesed[key].push(vm.listdata[key][i]); } }
			}
		},


		getpage:function(item, key) {
			vm.datatablesed[key] = [];
			vm.page[key] = item;
			let mulai = 0;
			let data = vm.filtertable[key].length > 0 ? vm.filtertable[key] : vm.listdata[key];
			if (item > 1) { mulai = ((item - 1) * 10) + 1; }
			for (let i = mulai; i < (item * 10)+1; i++) { if (i < data.length){ vm.datatablesed[key].push(vm.listdata[key][i]); } }
		},

		setfisrtpaging: function() {
			for (const key in vm.listdata) {
				vm.totalpage[key] = parseInt(vm.listdata[key].length / 10);
				let sisa = vm.listdata[key].length % 10;
				if (sisa > 0) { vm.totalpage[key] += 1; }
				for (let i = 0; i < 10; i++) { if (i < vm.listdata[key].length){ vm.datatablesed[key].push(vm.listdata[key][i]); } }
			}
			
		},

		/*
		*	Bagian untuk message dan after proses
		*/

		message: function (position, active) {
			if (position == 'error') {
				vm.notification('Penambahan data tindakan gagal diproses.', 3000, position);
			}
			else if (position == 'success' && active == 1) {
				vm.notification('Penambahan data tindakan berhasil diproses.', 3000, position);
			}
		},

		gagal: function (error, key) { if (vm.$debugs) { console.log(error.response); } let active = 0; vm.message('error', 1); vm.loaderprocess(); },

		berhasil: function (response, key) {
			if (vm.$debugs) { console.log(response); }
			let active = 1; vm.message('success', active); 
			vm.aturulang(key);
			vm.swappingvalue(); 
			vm.listdata[key] = response.data.item;	
			vm.setfisrtpaging(); vm.loaderprocess();
			vm.statusedit[key] = false;
		},

		runconfirm: function (posisi, key) { vm.loaderprocess(); vm.executions(key); },
		executions: function (key) { axios.post(vm.attach.url, vm.attach.data, { headers: { 'Content-Type': 'multipart/form-data' } }).then(function (response) { if (response.data.data == '419') { window.location.href = '/masuk'; } setTimeout(function(){ vm.berhasil(response, key); }, 750, this); }).catch(function (error){ setTimeout(function(){ vm.gagal(error, key); }, 750, this); }); },
		_dialog: function (_text, _confirm, posisi, key) { Swal.fire({ title:"Apakah Anda Yakin?", text:_text, icon:"warning", showCancelButton:!0, confirmButtonColor:"#1c84ee", cancelButtonColor:"#fd625e", confirmButtonText: _confirm, cancelButtonText:"Tidak, batal!" }).then(function(e){ if (e.isConfirmed) { vm.runconfirm(posisi, key); } }); },
		notification: function (message, timer, position) { if (position == 'error') { toast.error(message, { rtl: false, autoClose: timer }); } else { toast.success(message, { rtl: false, autoClose: timer }); } },

		dialog:function(key){
			let text = '', button = '';
			if (vm.form.posisi == 'tindakanrawatjalan') {
				if (vm.pos == 'add') {
					text = 'Yakin ingin menambahkan biaya tindakan rawat jalan pada metode pembayaran ini.';
					button = 'Ya, tambah data';
				}
				else {
					text = 'Yakin ingin menghapus biaya tindakan rawat jalan pada metode pembayaran ini.';
					button = 'Ya, hapus data';
				}
			}
			else if (vm.form.posisi == 'tindakannonbedah') {
				if (vm.pos == 'add') {
					text = 'Yakin ingin menambahkan biaya tindakan non bedah pada metode pembayaran ini.';
					button = 'Ya, tambah data';
				}
				else {
					text = 'Yakin ingin menghapus biaya tindakan non bedah pada metode pembayaran ini.';
					button = 'Ya, hapus data';
				}
			}
			else if (vm.form.posisi == 'tindakanbedah') {
				if (vm.pos == 'add') {
					text = 'Yakin ingin menambahkan biaya tindakan bedah pada metode pembayaran ini.';
					button = 'Ya, tambah data';
				}
				else {
					text = 'Yakin ingin menghapus biaya tindakan bedah pada metode pembayaran ini.';
					button = 'Ya, hapus data';
				}
			}
			else if (vm.form.posisi == 'jeniskamar') {
				if (vm.pos == 'add') {
					text = 'Yakin ingin menambahkan biaya jenis kamar pada metode pembayaran ini.';
					button = 'Ya, tambah data';
				}
				else {
					text = 'Yakin ingin menghapus biaya jenis kamar pada metode pembayaran ini.';
					button = 'Ya, hapus data';
				}
			}
			vm._dialog(text, button, vm.form.posisi, key)
    },
	}
}
</script>