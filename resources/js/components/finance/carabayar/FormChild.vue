<template>
	<div :style="terminate.display" class="modal">
		<div ref="rootmodal" class="modal-content modal-semi-besar" :class="terminate.show ? 'modal-opened' : 'modal-closed'">
			<div class="modal-header">
				<span class="close" v-on:click="hide()">&times;</span>
				<h2 v-if="form">{{ form.title }} <strong>{{ carabayar_nama }}</strong></h2>
			</div>
			<div class="modal-body" v-if="form">
				<div class="grid">
					<div class="col-12">
						<Inputed :ref="form.nama.name" :form="form.nama" v-on:keyup="add($event, 'child')"></Inputed>
					</div>
					<div class="col-12">
						<table class="table">
							<thead>
								<tr>
									<th colspan="2">
										<div class="form-self-group">
										<input placeholder="Search atau Cari disini" v-on:keyup="filterpage($event)" v-model="search" />
										</div>
									</th>
								</tr>
								<tr>
									<th>Nama Child</th>
									<th>#</th>
								</tr>
							</thead>
							<tbody>
								<tr v-if="datatablesed.length > 0" v-for="(item, index) in datatablesed">
									<td>{{ item.nama }}</td>
									<td>
										<button class="tooltip btn-danger">
											<vue-feather type="trash-2" v-on:click="remove(item, index, 'child')"></vue-feather> <span class="tooltiptext">Delete Data</span>
										</button>
									</td>
								</tr>
								<tr  v-else>
									<td colspan="2">No Data for Result</td>
								</tr>
							</tbody>
						</table>

						<div class="pagination" v-if="totalpage > 0" style="margin-top: 20px;">
							<a href="javascript:void(0)" v-on:click="prev()">&laquo;</a>
							<a href="javascript:void(0)" v-for="i in totalpage" v-on:click="getpage(i)" :class="page == i ? 'active':''">{{ i }}</a>
							<a href="javascript:void(0)" v-on:click="next()">&raquo;</a>
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
import { formchild } from './FormData.js';
import { parsechild } from './Attachment.js';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
import Swal from 'sweetalert2';
var vm, body;
export default {
	emits: ["dialog", "parsingForm"],
	components: { toast, Swal, 
		Inputed: defineAsyncComponent(() => import('../../../section/Inputed.vue')),
		Datatable: defineAsyncComponent(() => import('../../../section/Datatable.vue')),
	},
	mounted:function() { 
		vm = this; body = document.body;
		vm.form = vm.formchild();
	},
	created:function() {},
	data:function() { return { 
		terminate: { show: false, display: 'display: none' },
		form: null, btnlbl: '', listdata: [], carabayar_nama: '', carabayar_uuid: '',
		datatablesed: [], page: 1, totalpage: 0, filtertable: [], search: '',
		attach: {
			link : {
				adddata : {
					child: '/finance/carabayar/child/add'
				},
				removedata: { 
					child: '/finance/carabayar/child/remove'
				},
			}, url: '', data: null
		},
	}},
	methods: {

		parsechild, formchild,

		setdataform: function (response) {
			vm.listdata = response.data.child;
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
		aturulang: function () { vm.form = vm.formchild(); vm.datatablesed= [], vm.page= 1, vm.totalpage= 0, vm.filtertable= [], vm.search = '' },
		hide:function() { vm.terminate.show = false; setTimeout(function() { vm.terminate.display = 'display: none'; body.style.overflowY = 'auto'; }, 250, this); },
		loaderprocess:function() { const left = this.$refs.rootmodal.getBoundingClientRect(); vm.$refs.Loader.running(left, 'modal', 250); },

		/*
		*	Bagian untuk datatable filter dan pagination
		*/

		swappingvalue:function() {
			vm.form.carabayar_uuid = vm.carabayar_uuid;
			vm.form.carabayar_nama = vm.carabayar_nama;
		},

		add: function(event, key) {
			if (event.key == 'Enter') {
				let next = true;
				for (const key in vm.form) { if (key != 'select') { if (vm.form[key].required != '') { if (vm.form[key].value == '') { next = false; } } } }
				if (next) { vm.form.posisi = 'adddata'; vm.attach.url = vm.attach.link.adddata[key]; vm.attach.data = vm.parsechild(vm.form); vm.dialog(); }
			}
		},

		remove:function(item, index, key) {
			vm.form.posisi = 'removedata';
			vm.form.uuid = item.uuid;
			vm.attach.url = vm.attach.link.removedata[key];
			vm.attach.data = vm.parsechild(vm.form);
			vm.dialog();
		},

		filterpage: function (event) {
			if (event.key == 'Enter') {
				vm.page = 1;
				var filter = "nama";
				var keyword = event.target.value;
				if (keyword.trim() != '') { keyword = keyword.toLowerCase(); }
				let temp = vm.listdata.filter(function(obj) { return obj[filter].toLowerCase().includes(keyword); });
				let data = [];
				for (let i = 0; i < temp.length; i++) {
					for (let j = 0; j < data.length; j++) {
						if (data[j].nama == temp[i].nama){ break; }
						if (j == (data.length - 1)) { data.push(temp[i]); }
					}
					if (data.length < 1) { data.push(temp[i]); }
				}
				vm.filtertable = data;
				vm.setreloadpaging();
			}
		},

		setreloadpaging:function() {
			vm.datatablesed = [];
			if (vm.filtertable.length > 0) {
				console.log('dfs')
				vm.totalpage = parseInt(vm.filtertable.length / 10);
				let sisa = vm.filtertable.length % 10;
				if (sisa > 0) { vm.totalpage += 1; }
				for (let i = 0; i < 10; i++) { if (i < vm.filtertable.length) { vm.datatablesed.push(vm.filtertable[i]); } }
			}
		},

		prev:function() {
			if (vm.page != 1) {
				let item = vm.page - 1;
				vm.datatablesed = [];
				vm.page = item;
				let mulai = 0;
				let data = vm.filtertable.length > 0 ? vm.filtertable : vm.listdata;
				if (item > 1) { mulai = ((item - 1) * 10) + 1; }
				for (let i = mulai; i < (item * 10)+1; i++) { if (i < data.length){ vm.datatablesed.push(vm.listdata[i]); } }
			}
		},

		next:function() {
			if ((vm.page+1) <= vm.totalpage) {
				let item = vm.page + 1;
				vm.datatablesed = [];
				vm.page = item;
				let mulai = 0;
				let data = vm.filtertable.length > 0 ? vm.filtertable : vm.listdata;
				if (item > 1) { mulai = ((item - 1) * 10) + 1; }
				for (let i = mulai; i < (item * 10)+1; i++) { if (i < data.length){ vm.datatablesed.push(vm.listdata[i]); } }
			}
		},


		getpage:function(item) {
			vm.datatablesed = [];
			vm.page = item;
			let mulai = 0;
			let data = vm.filtertable.length > 0 ? vm.filtertable : vm.listdata;
			if (item > 1) { mulai = ((item - 1) * 10) + 1; }
			for (let i = mulai; i < (item * 10)+1; i++) { if (i < data.length){ vm.datatablesed.push(vm.listdata[i]); } }
		},

		setfisrtpaging: function() {
			vm.totalpage = parseInt(vm.listdata.length / 10);
			let sisa = vm.listdata.length % 10;
			if (sisa > 0) { vm.totalpage += 1; }
			for (let i = 0; i < 10; i++) { if (i < vm.listdata.length){ vm.datatablesed.push(vm.listdata[i]); } }
		},

		/*
		*	Bagian untuk message dan after proses
		*/

		message: function (position, active) {
			if (position == 'error') {
				if (vm.form.posisi == 'adddata') { vm.notification('Penambahan data asuransi gagal diproses.', 3000, position); }
				else if (vm.form.posisi == 'removedata') { vm.notification('Penghapusan data gagal diproses.', 3000, position); }
			}
			else if (position == 'success' && active == 1) {
				if (vm.form.posisi == 'adddata') { vm.notification('Penambahan data berhasil diproses.', 3000, position); }
				else if (vm.form.posisi == 'removedata') { vm.notification('Penghapusan data berhasil diproses.', 3000, position); }
			}
		},

		gagal: function (error) { if (vm.$debugs) { console.log(error.response); } let active = 0; vm.message('error', 1); vm.loaderprocess(); },

		berhasil: function (response) {
			if (vm.$debugs) { console.log(response); }
			let active = 1; vm.message('success', active); vm.aturulang();
			vm.swappingvalue(); vm.listdata = response.data.item;	vm.setfisrtpaging(); vm.loaderprocess();
		},

		runconfirm: function (posisi) { vm.loaderprocess(); vm.executions(); },
		executions: function () { axios.post(vm.attach.url, vm.attach.data, { headers: { 'Content-Type': 'multipart/form-data' } }).then(function (response) { if (response.data.data == '419') { window.location.href = '/masuk'; } setTimeout(function(){ vm.berhasil(response); }, 750, this); }).catch(function (error){ setTimeout(function(){ vm.gagal(error); }, 750, this); }); },
		_dialog: function (_text, _confirm, posisi) { Swal.fire({ title:"Apakah Anda Yakin?", text:_text, icon:"warning", showCancelButton:!0, confirmButtonColor:"#1c84ee", cancelButtonColor:"#fd625e", confirmButtonText: _confirm, cancelButtonText:"Tidak, batal!" }).then(function(e){ if (e.isConfirmed) { vm.runconfirm(posisi); } }); },
		notification: function (message, timer, position) { if (position == 'error') { toast.error(message, { rtl: false, autoClose: timer }); } else { toast.success(message, { rtl: false, autoClose: timer }); } },

		dialog:function(){
			let text = '', button = '';
			if (vm.form.posisi == 'adddata') {
				text = 'Yakin ingin menambah nama asuransi ini.';
				button = 'Ya, tambah data';
			}
			else {
				text = 'Yakin ingin menghapus data asuransi ini.';
				button = 'Ya, hapus data';
			}
			vm._dialog(text, button, vm.form.posisi)
    },
	}
}
</script>