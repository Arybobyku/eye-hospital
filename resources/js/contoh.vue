<template>	
	<div class="inner" ref="roottable">
		<div class="grid">
			<div class="col-2">
				<div class="foto-profile">
					<img src="/images/no-image.png" />
				</div>
			</div>
		</div>
	</div>
	</template>
		
	<script>
	var vm;
	import { defineAsyncComponent } from 'vue';
	import { nullAndZero } from '../../module/Manipulation.js';
	import { toast } from 'vue3-toastify';
	import 'vue3-toastify/dist/index.css';
	import Swal from 'sweetalert2';
		
	export default {
		emits: ["titletrigger"],
		components: { toast, Swal, 
			// PenggunaForm: defineAsyncComponent(() => import('../modal/PenggunaForm.vue')),
		},
		created:function() {},
		mounted:function() { vm = this; vm.setdatacomponent(); },
		data:function() { return {
			datacomponent: null,
		}},
		methods: {
			setdatacomponent:function() { 
				vm.datacomponent = { pengguna: null };
				vm.datacomponent.pengguna = {} 
			},
			nullAndZero,
	
	
			/*************************************************************************************************************************
			* Bagian fungsi yang wajib disertakan disetiap index dan tidak perlu diubah-ubah
			*************************************************************************************************************************/
			executions:function() { axios.post(vm.attach.url, vm.attach.data, { headers: { 'Content-Type': 'multipart/form-data' } }).then(function (response) { setTimeout(function(){ vm.berhasil(response); }, 750, this); }).catch(function (error){ setTimeout(function(){ vm.gagal(error); }, 750, this); }); },
			dialog:function(_text, _confirm, posisi) { Swal.fire({ title:"Apakah Anda Yakin?", text:_text, icon:"warning", showCancelButton:!0, confirmButtonColor:"#1c84ee", cancelButtonColor:"#fd625e", confirmButtonText: _confirm, cancelButtonText:"Tidak, batal!" }).then(function(e){ if (e.isConfirmed) { vm.runconfirm(posisi); } }); },
			notification:function(message, timer, position) { if (position == 'error') { toast.error(message, { rtl: false, autoClose: timer }); } else { toast.success(message, { rtl: false, autoClose: timer }); } },
			loadPatch() { vm.firstloader(); },
			firstloader:function() { const left = this.$refs.roottable.getBoundingClientRect(); vm.$refs.MyLoader.running(left); },
			unloadPatch(position) { vm.firstloader(); if (position == 'success') { vm.notification('Data berhasil dipatch.', 3000, position); } else if (position == 'error') { vm.notification('Data gagal dipatch.', 3000, position); } },
			titletrigger:function() { let title = vm.$router.currentRoute._value.meta.title; vm.$emit('titletrigger', title); }
		}
	}
	</script>