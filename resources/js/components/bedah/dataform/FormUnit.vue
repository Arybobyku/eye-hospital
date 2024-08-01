<template>
	<div :style="terminate.display" class="modal">
		<div ref="rootmodal" class="modal-content modal-besar" :class="terminate.show ? 'modal-opened' : 'modal-closed'">
			<div class="modal-header">
				<span class="close" v-on:click="hide()">&times;</span>
				<h2>Form Bedah Pasien</h2>
			</div>
			<div class="modal-body">
				<div class="grid">
					<div class="col-12">
						<div class="tab-lines"><div class="tab" style="width: 100%;"><button v-for="(item, index) in tab.button" :class="item.class" v-on:click="changesTab(item.value, index, item.class)">{{ item.label }}</button></div></div>

						<div class="tab-content">
							<div class="content-tab-in" :style="tab.content.laporanpembedahan ? 'padding: 20px 5px' : 'padding: 0 0'">
								<LaporanPembedahan ref="LaporanPembedahan" :activetab="tab.content.laporanpembedahan" @dialog="dialog" @parsingForm="parsingForm"></LaporanPembedahan>
							</div>
							<div class="content-tab-in" :style="tab.content.checklistkesiapanbedah ? 'padding: 20px 5px' : 'padding: 0 0'">
								<ChecklistKesiapanBedah :activetab="tab.content.checklistkesiapanbedah" ref="ChecklistKesiapanBedah" @dialog="dialog" @parsingForm="parsingForm"></ChecklistKesiapanBedah>
							</div>
							<div class="content-tab-in" :style="tab.content.perawatanperioperative ? 'padding: 20px 5px' : 'padding: 0 0'">
								<PerawatanPeriOperative :activetab="tab.content.perawatanperioperative" ref="PerawatanPeriOperative" @dialog="dialog" @parsingForm="parsingForm"></PerawatanPeriOperative>
							</div>
							<div class="content-tab-in" :style="tab.content.catatanoperasikatarak ? 'padding: 20px 5px' : 'padding: 0 0'">
								<CatatanOperasiKatarak :activetab="tab.content.catatanoperasikatarak" ref="CatatanOperasiKatarak" @dialog="dialog" @parsingForm="parsingForm"></CatatanOperasiKatarak>
							</div>
							<div class="content-tab-in" :style="tab.content.persetujuantindakankedokteran ? 'padding: 20px 5px' : 'padding: 0 0'">
								<PersetujuanTindakanKedokteran :activetab="tab.content.persetujuantindakankedokteran" ref="PersetujuanTindakanKedokteran" @dialog="dialog" @parsingForm="parsingForm"></PersetujuanTindakanKedokteran>
							</div>
							<div class="content-tab-in" :style="tab.content.checklistkeselamatanbedah ? 'padding: 20px 5px' : 'padding: 0 0'">
								<KeselamatanBedah :activetab="tab.content.checklistkeselamatanbedah" ref="KeselamatanBedah" @dialog="dialog" @parsingForm="parsingForm"></KeselamatanBedah>
							</div>
							<div class="content-tab-in" :style="tab.content.laporaninjeksiantivega ? 'padding: 20px 5px' : 'padding: 0 0'">
								<LaporanInjeksiAntiVega :activetab="tab.content.laporaninjeksiantivega" ref="LaporanInjeksiAntiVega" @dialog="dialog" @parsingForm="parsingForm"></LaporanInjeksiAntiVega>
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


var vm, body;
export default {
	emits: ["dialog", "parsingForm"],
	components: {
		LaporanPembedahan: defineAsyncComponent(() => import('./LaporanPembedahan.vue')),
		ChecklistKesiapanBedah: defineAsyncComponent(() => import('./ChecklistKesiapanBedah.vue')),
		PerawatanPeriOperative: defineAsyncComponent(() => import('./PerawatanPeriOperative.vue')),
		CatatanOperasiKatarak: defineAsyncComponent(() => import('./CatatanOperasiKatarak.vue')),
		PersetujuanTindakanKedokteran: defineAsyncComponent(() => import('./PersetujuanTindakanKedokteran.vue')),
		KeselamatanBedah: defineAsyncComponent(() => import('./KeselamatanBedah.vue')),
		LaporanInjeksiAntiVega: defineAsyncComponent(() => import('./LaporanInjeksiAntiVega.vue')),
	},
	mounted:function() { 
		vm = this; body = document.body;
	},
	created:function() {},
	data:function() { return { 
		terminate: { show: false, display: 'display: none' },
		tab: {
			button: [
				{ value: 'laporanpembedahan', label: 'Laporan Pembedahan', class: 'tab-active' },
				{ value: 'checklistkesiapanbedah', label: 'Checklist Kesiapan Bedah', class: 'tab-no-active' },
				{ value: 'perawatanperioperative', label: 'Proses Perawatan Peri-Operative', class: 'tab-no-active' },
				{ value: 'catatanoperasikatarak', label: 'Catatan Operasi Katarak', class: 'tab-no-active' },
				{ value: 'persetujuantindakankedokteran', label: 'Persetujuan Tindakan Kedokteran', class: 'tab-no-active' },
				{ value: 'checklistkeselamatanbedah', label: 'Checklist Keselamatan Bedah', class: 'tab-no-active' },
				{ value: 'laporaninjeksiantivega', label: 'Laporan Injeksi Anti Vega', class: 'tab-no-active' },
			],
			content: { 
				laporanpembedahan: true, 
				checklistkesiapanbedah: false, 
				perawatanperioperative: false, 
				catatanoperasikatarak: false, 
				persetujuantindakankedokteran: false, 
				checklistkeselamatanbedah: false, 
				laporaninjeksiantivega: false, 
			}
		},
		namebutton: 'laporanpembedahan',
		datarow: null,
	}},
	methods: {

		changesTab: function (values, index, classes) {
			if (classes != 'tab-active') {
				for (let i = 0; i < vm.tab.button.length; i++) { 
					vm.tab.content[vm.tab.button[i].value] = false; vm.tab.button[i].class = 'tab-no-active'; 
				}
				vm.tab.button[index].class = 'tab-active';
				vm.tab.content[values] = true;
				vm.namebutton = values;
			}
		},

		show:function(posisi, title, data){ 
			body.style.overflowY = 'hidden'; 
			vm.terminate.display = 'display: block'; 
			vm.terminate.show = true;
			vm.datarow = data;
			for (let i = 0; i < vm.tab.button.length; i++) { 
				vm.tab.content[vm.tab.button[i].value] = false; vm.tab.button[i].class = 'tab-no-active'; 
			}
			vm.tab.button[0].class = 'tab-active';
			vm.tab.content['laporanpembedahan'] = true;
			vm.namebutton = 'laporanpembedahan';
    },
		aturulang: function () { 
			vm.$refs.LaporanPembedahan.aturulang();
			vm.$refs.ChecklistKesiapanBedah.aturulang();
			vm.$refs.PerawatanPeriOperative.aturulang();
			vm.$refs.CatatanOperasiKatarak.aturulang();
			vm.$refs.PersetujuanTindakanKedokteran.aturulang();
			vm.$refs.KeselamatanBedah.aturulang();
			vm.$refs.LaporanInjeksiAntiVega.aturulang();
		},
		hide:function() { vm.terminate.show = false; setTimeout(function() { vm.terminate.display = 'display: none'; body.style.overflowY = 'auto'; }, 250, this); },
		
		parsingForm:function(data, key) { 
			vm.$emit('parsingForm', data, key); 
		},

		loaderprocess:function() { const left = this.$refs.rootmodal.getBoundingClientRect(); vm.$refs.Loader.running(left, 'modal', 250); },

		setdataform: function (response) {
			vm.$refs.LaporanPembedahan.setdataform(response.data.laporanpembedahan, vm.datarow);
			vm.$refs.ChecklistKesiapanBedah.setdataform(response.data.checklistkesiapanbedah, vm.datarow);
			vm.$refs.PerawatanPeriOperative.setdataform(response.data.perawatanperioperative, vm.datarow);
			vm.$refs.CatatanOperasiKatarak.setdataform(response.data.catatanOperasikatarak, vm.datarow);
			vm.$refs.PersetujuanTindakanKedokteran.setdataform(response.data.persetujuantindakankedokteran, vm.datarow);
			vm.$refs.KeselamatanBedah.setdataform(response.data.keselamatanbedah, vm.datarow);
			vm.$refs.LaporanInjeksiAntiVega.setdataform(response.data.laporaninjeksiantivega, response.data.listtindakan, vm.datarow);
			vm.loaderprocess();
		},

		dialog:function(text, button, key) {
			vm.$emit('dialog', text, button, 'loadinternal');
		}
	}
}
</script>