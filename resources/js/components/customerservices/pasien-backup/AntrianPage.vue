<template>
	<div :style="terminate.display" class="modal">
		<div ref="rootmodalantrian" class="modal-content modal-besar" :class="terminate.show ? 'modal-opened' : 'modal-closed'">
			<div class="modal-header">
				<span class="close" v-on:click="hide()">&times;</span>
				<h2>Daftar Antrian</h2>
			</div>
			<div class="modal-body">
				<div class="grid">

					<div class="col-12">
						<table class="table">
							<thead>
								<tr>
									<th>No Antrian Pasien</th>
									<th>Metode Pembayaran</th>
									<th>Customer Service</th>
									<th>#</th>
								</tr>
							</thead>
							<tbody>
								<tr v-for="(item, index) in items" v-if="items.length > 0">
									<td>{{ item.kode }}-{{ checknumber(item.number) }}</td>
									<td>{{ item.jenis }}</td>
									<td>{{ item.pemanggil }}</td>
									<td>
										<div class="btn-group">
											<button class="tooltip btn-danger" v-on:click="call(item)">
												<vue-feather type="bell" ></vue-feather> 
												<span class="tooltiptext">Panggil Pasien</span>
											</button>
											<button class="tooltip btn-success" v-on:click="finish(item)">
												<vue-feather type="check-square" ></vue-feather> 
												<span class="tooltiptext">Selesai</span>
											</button>
										</div>
									</td>
								</tr>
								<tr>
									<td colspan="4">No data for result</td>
								</tr>
							</tbody>
						</table>
					</div>
					
				</div>
			</div>

			<MyLoader ref="MyLoader"></MyLoader>

		</div>
		
	</div>
</template>

<script>
var vm, body;
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
import Swal from 'sweetalert2';
export default {
	props : { modal : { type : Object} },
	mounted:function() { vm = this; body = document.body; },
	created:function() { },
	data:function() { return { 
		terminate: { show: false, display: 'display: none' },
		loading: { display: 'display: none' },
		btnlbl: '',
		minheight: '',
		items: [],
		attach: {
			/***********************************************************************************************************************
			 * Bagian yang perlu diubah (LINK)
			 ************************************************************************************************************************/
			link : {
				antrian: '/customerservice/antrian/list',
				call: '/customerservice/antrian/call',
				finish: '/customerservice/antrian/finish'
			}, url: '', data: null
		},
		position: '',
	}},
	methods: {

		checknumber:function(number) {
			let msg = '';
    	if (number < 10) { msg = '00' + number; } 
			else if (number > 9 && number < 100) { msg = '0' + number; } 
			else if (number > 99 && number < 1000) { msg = number; }
    	return msg;
		},
		
		show:function(){
			body.style.overflowY = 'hidden';
			vm.terminate.display = 'display: block';
			vm.terminate.show = true;
			setTimeout(() => {
				vm.loaderprocess();
				vm.attach.url = vm.attach.link.antrian;
				vm.attach.data = new FormData();
				vm.attach.data.append('list', '');			
				vm.executions();
			}, 500);
			
    },

		reloadtable:function() {
			vm.attach.url = vm.attach.link.antrian;
			vm.attach.data = new FormData();
			vm.attach.data.append('list', '');			
			vm.executions();
		},

		hide:function() {
			vm.terminate.show = false;
			setTimeout(function() {
				vm.terminate.display = 'display: none';
				body.style.overflowY = 'auto';
			}, 250, this);
		},

		action:function() {
			vm.dialog();
		},

		parsingForm:function() {
			vm.$emit('parsingForm', vm.modal.form);
		},

		loaderprocess:function() { 
			const left = this.$refs.rootmodalantrian.getBoundingClientRect(); 
			vm.$refs.MyLoader.running(left, 'modal', 250); 
		},

		berhasil:function(response) {
			if (vm.position == 'call') { 
				vm.position = 'list';
				toast.success('Proses pemanggilan antrian berhasil dilakukan', { rtl: false, autoClose: 3000 });
				vm.reloadtable();
			}
			else if (vm.position == 'finish') {}
			else {
				vm.loaderprocess();
				vm.items = response.data.data;
			}
			console.log(response);
		},

		gagal:function(error) {
			if (vm.position == 'call') {
				toast.error('Proses pemanggilan antrian gagal dilakukan', { rtl: false, autoClose: 3000 });
			}
			else if (vm.position == 'finish') {}
			console.log(error.response);
			vm.loaderprocess();
		},

		runconfirm:function(posisi) {
			vm.loaderprocess();
			vm.executions();
		},

		call:function(item){
			vm.position = 'call';
      vm.attach.url = vm.attach.link.call;
			vm.attach.data = new FormData();
			vm.attach.data.append('antrian_uuid', item.uuid);
			vm.attach.data.append('kode', item.kode);
			vm.attach.data.append('number', item.number);
			vm.attach.data.append('jenis', item.jenis);
			vm.dialog('Yakin ingin memanggil nomor antrian pasien ini.', 'Ya, panggil', 'call');
    },
		finish:function(){
      vm.dialog('Anda yakin proses pendaftaran pasien sudah selesai dan ingin menutupnya.', 'Ya, lanjutkan', 'finish');
    },
		executions:function() { axios.post(vm.attach.url, vm.attach.data, { headers: { 'Content-Type': 'multipart/form-data' } }).then(function (response) { setTimeout(function(){ vm.berhasil(response); }, 250, this); }).catch(function (error){ setTimeout(function(){ vm.gagal(error); }, 250, this); }); },

		dialog:function(_text, _confirm, posisi) { Swal.fire({ title:"Apakah Anda Yakin?", text:_text, icon:"warning", showCancelButton:!0, confirmButtonColor:"#1c84ee", cancelButtonColor:"#fd625e", confirmButtonText: _confirm, cancelButtonText:"Tidak, batal!" }).then(function(e){ if (e.isConfirmed) { vm.runconfirm(posisi); } }); },
	}
}
</script>