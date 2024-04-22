<template>
	<div :style="terminate.display" class="modal">
		<div ref="rootmodal" class="modal-content modal-besar" :class="terminate.show ? 'modal-opened' : 'modal-closed'">
			<div class="modal-header">
				<span class="close" v-on:click="hide()">&times;</span>
				<h2 v-if="form">Detail List {{ form.nama_paket_bedah }}</h2>
			</div>
			<div class="modal-body" v-if="form">
				<div class="grid">
					<div class="col-6">
						<Inputed :ref="form.label.name" :form="form.label"></Inputed>
					</div>
					<div class="col-6 form-ml">
						<Inputed :ref="form.sublabel.name" :form="form.sublabel"></Inputed>
					</div>
					<div class="col-5">
						<Inputed :ref="form.nama.name" :form="form.nama"></Inputed>
					</div>
					<div class="col-3 form-ml">
						<Inputed :ref="form.quantity.name" :form="form.quantity"></Inputed>
					</div>
					<div class="col-2 form-ml">
						<Inputed :ref="form.harga.name" :form="form.harga"></Inputed>
					</div>
					<div class="col-1 form-ml">
						<button v-on:click="additem()" 
							v-if="!statusedit" class="button-modal-page button-modal-green" style="margin-top: 13px;">ADD</button>
						<template v-else>
							<button v-on:click="additem()" class="button-modal-page button-modal-green" style="margin-top: 13px;">Update</button>
							<button v-on:click="cancelitem()" class="button-modal-page button-modal-red" style="margin-top: 13px;">Cancel</button>
						</template>
					</div>
				</div>
				<div class="grid">
					<div class="col-12">
						<table class="table">
							<thead>
								<tr>
									<th>Label</th>
									<th>Sub Label</th>
									<th>Nama</th>
									<th>Quantity</th>
									<th>Harga</th>
									<th>#</th>
								</tr>
							</thead>
							<tbody>
								<tr v-for="item in maindata" v-if="maindata.length > 0">
									<td>{{ item.label }}</td>
									<td>{{ item.sub_label }}</td>
									<td>{{ item.nama }}</td>
									<td>{{ item.quantity }}</td>
									<td>{{ formatrupiah(item.harga.toString()) }}</td>
									<td>
										<button class="tooltip btn-danger" v-on:click="removeitem(item)">
											<vue-feather type="trash"></vue-feather> 
											<span class="tooltiptext">Hapus Item</span>
										</button>
										<button class="tooltip btn-warning">
											<vue-feather type="edit" v-on:click="edititem(item)"></vue-feather> <span class="tooltiptext">Edit Data</span>
										</button>
									</td>
								</tr>
								<tr v-else>
									<td colspan="5">No Data For Result</td>
								</tr>
								<tr v-if="maindata.length > 0">
									<td colspan="4">Grand Total</td>
									<td>{{ formatrupiah(totalfull.toString()) }}</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<Loader ref="Loader"></Loader>
		</div>
	</div>
</template>

<script>
var vm, body;
import { defineAsyncComponent } from 'vue';
import { nullAndZero, datename, formatrupiah } from '../../../module/Manipulation.js';
import { listpaket } from './FormData.js';
import { parseunit } from './Attachment.js';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
import Swal from 'sweetalert2';
export default {
	beforeUnmount:function() {},
	components: {
		Inputed: defineAsyncComponent(() => import('../../../section/Inputed.vue')),
	},
	created: function () {},
	mounted:function() { 
		vm = this; body = document.body;
		vm.form = vm.listpaket();
	},
	computed: {
		totalfull:function() {
			let tmp = 0;
			for (let i = 0; i < vm.maindata.length; i++) {
				tmp += vm.maindata[i].harga;
			}
			return tmp;
		}
	},
	data: function () { return {
		statusedit: false,
		terminate: { show: false, display: 'display: none' },
		btnlbl: '',
		form: null,
		maindata: [],
		position: '',
		attach: {
			link : {
				add: '/finance/listpaketbedah/add',
				remove: '/finance/listpaketbedah/remove',
				list: '/finance/listpaketbedah/list',
			}, url: '', data: null
		},
	}},
	methods: {
		listpaket, parseunit, formatrupiah,
		show:function(posisi, title, uuid, nama){ 
			vm.btnlbl = posisi == 'adddata' ? 'Save Data' : 'Update Data'; 
			vm.form.nama_paket_bedah = nama;
			vm.form.paket_bedah_uuid = uuid;
			vm.form.title = title; 
			vm.form.posisi = posisi;
			body.style.overflowY = 'hidden'; 
			vm.terminate.display = 'display: block'; 
			vm.terminate.show = true;
			vm.maindata = [];
			vm.form.label.value = '';
			vm.form.sublabel.value = '';
			vm.form.nama.value = '';
			vm.form.quantity.value = '';
			vm.form.harga.value = '';
			setTimeout(() => {
				vm.loaderprocess();
				vm.firstload();
			}, 500);
			
    },
		firstload:function() {
			vm.position = 'firstload';
			vm.attach.data = new FormData();
			vm.attach.data.append('paket_bedah_uuid', vm.form.paket_bedah_uuid);
			vm.attach.url = vm.attach.link.list;
			vm.executions();
		},
		hide:function() { vm.terminate.show = false; setTimeout(function() { vm.terminate.display = 'display: none'; body.style.overflowY = 'auto'; }, 250, this); },
		loaderprocess:function() { 
			const left = this.$refs.rootmodal.getBoundingClientRect(); 
			vm.$refs.Loader.running(left, 'modal', 250); 
		},
		aturulang: function () { vm.form = vm.listpaket(); },
		additem:function() {
			let next = true;
			for (const key in vm.form) {
				if (key != 'select') { if (vm.form[key].required != '') { if (vm.form[key].value == '') { next = false; } } }
			}
			
			if (next) {
				vm.attach.data = new FormData();
				vm.attach.data.append('uuid', vm.form.uuid);
				vm.attach.data.append('nama_paket_bedah', vm.form.nama_paket_bedah);
				vm.attach.data.append('paket_bedah_uuid', vm.form.paket_bedah_uuid);
				vm.attach.data.append('label', vm.form.label.value);
				vm.attach.data.append('sub_label', vm.form.sublabel.value);
				vm.attach.data.append('nama', vm.form.nama.value);
				vm.attach.data.append('quantity', vm.form.quantity.value);
				vm.attach.data.append('harga', vm.form.harga.value);
				vm.attach.url = vm.attach.link.add;

				vm.position = "adddata";
				vm.dialog('Yakin ingin menambahkan data paket bedah.', 'Ya, Tambahkan data', 'adddata');
			}
			
		},

		cancelitem:function() {
			vm.form.uuid = '';
			vm.statusedit = false;
			vm.form.label.value = '';
			vm.form.sublabel.value = '';
			vm.form.nama.value = '';
			vm.form.quantity.value = '';
			vm.form.harga.value = '';
		},

		removeitem:function(item) {
			vm.attach.data = new FormData();
			vm.attach.data.append('uuid', item.uuid);
			vm.attach.url = vm.attach.link.remove;

			vm.position = "removedata";
			vm.dialog('Yakin ingin menghapus data paket bedah.', 'Ya, Hapus data', 'removedata');
		},

		edititem:function(item) {
			console.log(item);
			vm.form.uuid = item.uuid;
			vm.statusedit = true;
			vm.form.label.value = item.label;
			vm.form.sublabel.value = item.sub_label;
			vm.form.nama.value = item.nama;
			vm.form.quantity.value = item.quantity;
			vm.form.harga.value = item.harga;
		},

		gagal: function (error) {
			if (vm.$debugs) { console.log(error.response); } let active = 0;
			vm.message('error', 1);
			if (vm.position == 'firstload') { vm.loaderprocess(); active = 1; }
			else if (vm.position == 'adddata') { vm.loaderprocess(); }
			else if (vm.position == 'removedata') { vm.loaderprocess(); }
			
			/* Bagian ini tidak perlu diubah */
			if (active == 1) { setTimeout(function(){ vm.$router.push({ name: 'Error', params: { link: vm.name_vue } }) }, 250, this); }
		},
		berhasil: function (response) {
			if (vm.$debugs) { console.log(response.data); } let active = 1;
			if (response.data.data == '403') { vm.$router.push('/dashboard/forbidden'); }
	
			if (vm.position == 'firstload') {
				vm.loaderprocess();
				vm.maindata = response.data.data;
				// vm.form.label.value = '';
				// vm.form.sublabel.value = '';
				vm.form.nama.value = '';
				vm.form.quantity.value = '1';
				vm.form.harga.value = '';
			}
			else if (vm.position == 'adddata') {
				vm.firstload();
			}
			else if (vm.position == 'removedata') { 
				vm.firstload();
			}
			vm.message('success', active);
		},
		message: function (position, active) {
			if (position == 'error') {
				if (vm.position == 'firstload') { vm.notification('Pengambilan data gagal diproses.', 3000, position); }
				else if (vm.position == 'adddata') { vm.notification('Penambahan data gagal diproses.', 3000, position); }
				else if (vm.position == 'removedata') { vm.notification('Penghapusan data gagal diproses.', 3000, position); }
			}
			else if (position == 'success' && active == 1) {
				if (vm.position == 'adddata') { vm.notification('Penambahan data berhasil diproses.', 3000, position); }
				else if (vm.position == 'removedata') { vm.notification('Penghapusan data berhasil diproses.', 3000, position); }
			}
		},

		runconfirm: function (posisi) {
			if (posisi == 'adddata') { vm.loaderprocess(); }
			else if (posisi == 'removedata') { vm.loaderprocess(); }
			vm.executions();
		},
		executions: function () { axios.post(vm.attach.url, vm.attach.data, { headers: { 'Content-Type': 'multipart/form-data' } }).then(function (response) { if (response.data.data == '419') { window.location.href = '/masuk'; } setTimeout(function(){ vm.berhasil(response); }, 750, this); }).catch(function (error){ setTimeout(function(){ vm.gagal(error); }, 750, this); }); },
		dialog: function (_text, _confirm, posisi) { Swal.fire({ title:"Apakah Anda Yakin?", text:_text, icon:"warning", showCancelButton:!0, confirmButtonColor:"#1c84ee", cancelButtonColor:"#fd625e", confirmButtonText: _confirm, cancelButtonText:"Tidak, batal!" }).then(function(e){ if (e.isConfirmed) { vm.runconfirm(posisi); } }); },
		notification: function (message, timer, position) { if (position == 'error') { toast.error(message, { rtl: false, autoClose: timer }); } else { toast.success(message, { rtl: false, autoClose: timer }); } },
	}
}
</script>