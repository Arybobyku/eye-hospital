<template>
	<div :style="terminate.display" class="modal">
		<div ref="roothakakses" class="modal-content modal-besar" :class="terminate.show ? 'modal-opened' : 'modal-closed'">
			<div class="modal-header">
				<button v-on:click="action()">Add or Update</button>
				<span class="close" v-on:click="hide()">&times;</span>
				<h2>Hak Akses Pengguna</h2>
			</div>
			<div class="modal-body">
				<div class="grid" v-if="hakakses.length > 0">

					<div class="col-6 form-mr">
						<table class="table">
							<thead>
								<tr><th colspan="3">Daftar Data Akses Sistem</th></tr>
								<tr class="table-header">
									<th>Group</th>
									<th>Nama Halaman</th>
									<th>#</th>
								</tr>
							</thead>
							<tbody>
								<tr v-for="(item, index) in hakakses">
									<td>{{ item.based }}</td>
									<td>{{ item.nama }}</td>
									<td>
										<button class="tooltip btn-success" style="cursor: pointer;" v-if="item.status == 'active'">
											<vue-feather type="plus-square" v-on:click="add(item, index)"></vue-feather> <span class="tooltiptext">Add Akses</span>
										</button>
										<span v-else>-</span>
									</td>
								</tr>
							</tbody>
						</table>
					</div>

					<div class="col-6 form-ml">
						<table class="table">
							<thead>
								<tr><th colspan="3">Daftar Data Akses User</th></tr>
								<tr class="table-header">
									<th>No.</th>
									<th>Group</th>
									<th>Nama Halaman</th>
									<th>#</th>
								</tr>
							</thead>
							<tbody>
								<tr v-for="(item, index) in userakses" v-if="userakses.length > 0">
									<td>{{ index + 1 }}</td>
									<td>{{ item.based }}</td>
									<td>{{ item.nama }}</td>
									<td>
										<button class="tooltip btn-danger" style="cursor: pointer;" v-on:click="minus(item, index)">
											<vue-feather type="minus-square"></vue-feather> <span class="tooltiptext">Hapus Akses</span>
										</button>
									</td>
								</tr>
								<tr v-else><td colspan="3">No data for result</td></tr>
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
export default {
	emits: ["dialog", "parsingForm"],
	mounted:function() { vm = this; body = document.body; },
	created:function() { this.item = this.modal },
	data:function() { return { 
		terminate: { show: false, display: 'display: none' },
		hakakses: [], userakses: [], pengguna: null,
		tmp : { hakakses: [], userakses: [], pengguna: null }
	}},
	methods: {

		add:function(item, index) {
			vm.hakakses[index].status = 'no';
			vm.userakses.push(item);
		},
		
		minus:function(item, index) {
			let data = vm.hakakses;
			for (let i = 0; i < data.length; i++){
				if (data[i].uuid == item.uuid) { data[i].status = 'active'; }
			}
			vm.hakakses = data;
			vm.userakses.splice(index, 1);
		},

		setdataform: function (response) {
			vm.hakakses = [];
			vm.userakses = [];
			let data = response.data;
			vm.hakakses = data.hakakses;
			vm.userakses = data.userakses;
			console.log(vm.userakses)
			let tmp = [];
			if (vm.userakses.length > 0) {
				for (let i = 0; i < vm.hakakses.length; i++) {
					for (let j = 0; j < vm.userakses.length; j++) {
						if (vm.hakakses[i].uuid == vm.userakses[j].label_uuid) {
							vm.hakakses[i].status = 'no';
							tmp.push(vm.hakakses[i]);
						}
					}
				}
				vm.userakses = tmp;
			}
			
			vm.pengguna = data.pengguna;
			vm.loaderprocess();
		},

		check:function(event) {
			console.log(event.target.value)
		},
		
		show:function(){ 
			body.style.overflowY = 'hidden';
			vm.terminate.display = 'display: block';
			vm.terminate.show = true;
    },

		hide:function() {
			vm.terminate.show = false;
			setTimeout(function() {
				vm.terminate.display = 'display: none';
				body.style.overflowY = 'auto';
			}, 250, this);
		},

		action:function() { if (vm.userakses.length > 0) { vm.parsingForm(); vm.dialog(); } },

		aturulang: function () { vm.hakakses = []; vm.userakses = []; vm.pengguna = null },

		parsingForm:function() {
			let data = new FormData();
			data.append('pengguna_uuid', vm.pengguna.pengguna_uuid);
			data.append('nama_pengguna', vm.pengguna.nama_pengguna);
			data.append('username_pengguna', vm.pengguna.username_pengguna);
			data.append('hakakses', JSON.stringify(vm.userakses));
			vm.tmp.hakakses = vm.hakakses;
			vm.tmp.userakses = vm.userakses;
			vm.tmp.pengguna = vm.pengguna;
			vm.$emit('parsingForm', data, 'aksesdata');
		},

		loaderprocess:function(procces = 'no') {
			if (procces == 'yes') { 
				vm.hakakses = []; vm.userakses = []; vm.pengguna = null; 
				setTimeout(() => {
					const left = this.$refs.roothakakses.getBoundingClientRect(); vm.$refs.Loader.running(left, 'modal', 450);
				}, 125);
			} 
			else if (procces == 'back') { 
				vm.hakakses = vm.tmp.hakakses; vm.userakses = vm.tmp.userakses; vm.pengguna = vm.tmp.pengguna; 
				const left = this.$refs.roothakakses.getBoundingClientRect(); vm.$refs.Loader.running(left, 'modal', 450);
			} 
			else {
				const left = this.$refs.roothakakses.getBoundingClientRect(); vm.$refs.Loader.running(left, 'modal', 450);
			}
			
		 },

		dialog:function(){
			let text = '', button = '';
			text = 'Yakin ingin memperbaharui data hak akses pengguna ini.';
			button = 'Ya, perbaharui data';
      vm.$emit('dialog', text, button, 'aksesdata');
    },
	},
}
</script>
<style>.vue-feather { overflow:unset; }</style>