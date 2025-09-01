<template>
	<div class="reload" v-on:click="reloading()">
		<vue-feather type="refresh-cw"></vue-feather>
	</div>
	<div class="patch" v-on:click="showMenuPatch()">
		<span class="text-patch" v-html="ispatch? 'Wait...' : 'Patch'"></span>
	</div>
	<div class="menu-patch dropdown__window_patch hidden" :style="stylepatch">
		<ul>
			<li v-for="item in listpatch">
				<a href="javascript:void(0)" v-on:click="repatch(item.value)">
					<vue-feather :type="item.icon"></vue-feather> {{ item.label }}
				</a>
			</li>
		</ul>
	</div>
	<div ref="righttop" class="right-top dropdown" v-on:click="showMenuProfile()">
		<img class="click-img" src="/images/no-image.png" />
		<span class="click">Hi, {{ username }}</span>
	</div>
	<div class="menu-top dropdown__window hidden">
		<ul>
			<li><router-link to="/dashboard/profile"><vue-feather type="users"></vue-feather> Biodata</router-link></li>
			<li><router-link to="/dashboard/profile"><vue-feather type="key"></vue-feather> Ganti Password</router-link></li>
			<li><a href="/keluar"><vue-feather type="log-out"></vue-feather> Keluar</a></li>
		</ul>
	</div>
</template>

<script>
var vm, dropdownWindow, dropdownWindow_patch;
export default {
	emits: ["repatch", "reloading"],
	props: ['username'],
	mounted: function () {
		vm = this;
		dropdownWindow = document.querySelector('.dropdown__window');
		dropdownWindow_patch = document.querySelector('.dropdown__window_patch');
	},
	created: function () {
		window.addEventListener("click", function(event) {
			let eventClick = event.target.className;
			try { 
				if (event.target.className) {
					if (eventClick.toString() != 'click' && eventClick != 'click-img' && eventClick.toString() != 'patch' && eventClick.toString() != 'text-patch') { 
						if (dropdownWindow.classList.contains('active')){
							dropdownWindow.classList.remove('active');
							dropdownWindow.classList.toggle('hidden');
						}
						if (dropdownWindow_patch.classList.contains('active')){
							dropdownWindow_patch.classList.remove('active');
							dropdownWindow_patch.classList.toggle('hidden');
						}
					}
				}
				else {
					if (eventClick.toString() != 'click' && eventClick != 'click-img' && eventClick.toString() != 'patch' && eventClick.toString() != 'text-patch') { 
						if (dropdownWindow.classList.contains('active')){
							dropdownWindow.classList.remove('active');
							dropdownWindow.classList.toggle('hidden');
						}

						if (dropdownWindow_patch.classList.contains('active')){
							dropdownWindow_patch.classList.remove('active');
							dropdownWindow_patch.classList.toggle('hidden');
						}
					}
				}
				
			} catch { console.clear(); } 
		});
	},
	data: function () {
		return {
			stylepatch: 'right: 0px',
			ispatch: false,
			listpatch: [
				{ icon: 'aperture', value: 'all', label: 'All Data' },
				{ icon: 'arrow-right', value: 'carabayartindakanrawatjalan', label: 'Biaya Tindakan Rawat Jalan' },
				{ icon: 'arrow-right', value: 'carabayartindakannonbedah', label: 'Biaya Tindakan Non Bedah' },
				{ icon: 'arrow-right', value: 'carabayartindakanbedah', label: 'Biaya Tindakan Bedah' },
				{ icon: 'arrow-right', value: 'tindakanrawatjalan', label: 'Tindakan Rawat Jalan' },
				{ icon: 'arrow-right', value: 'tindakannonbedah', label: 'Tindakan Non Bedah' },
				{ icon: 'arrow-right', value: 'tindakanbedah', label: 'Tindakan Bedah' },
				{ icon: 'arrow-right', value: 'jeniskamar', label: 'Jenis Kamar' },
				{ icon: 'arrow-right', value: 'kamarinap', label: 'Kamar Rawat Inap' },
				{ icon: 'arrow-right', value: 'alltindakan', label: 'Master Data Tindakan' },
				{ icon: 'arrow-right', value: 'provinsi', label: 'Data Provinsi' },
				{ icon: 'arrow-right', value: 'kabkota', label: 'Data Kab/Kota' },
				{ icon: 'arrow-right', value: 'kecamatan', label: 'Data Kecamatan' },
				{ icon: 'arrow-right', value: 'kelurahan', label: 'Data Kelurahan' },
				{ icon: 'arrow-right', value: 'supplier', label: 'Data Supplier' },
				{ icon: 'arrow-right', value: 'obat', label: 'Master Obat' },
				{ icon: 'arrow-right', value: 'obat2', label: 'Master Obat' },
				{ icon: 'arrow-right', value: 'obat3', label: 'Master Obat' },
				{ icon: 'arrow-right', value: 'obatgudang', label: 'Obat Gudang Farmasi' },
				{ icon: 'arrow-right', value: 'satuan', label: 'Satuan Obat' },
				{ icon: 'arrow-right', value: 'apotek', label: 'Obat Apotek' },
				{ icon: 'arrow-right', value: 'apotekracikan', label: 'Obat Racikan' },
				{ icon: 'arrow-right', value: 'paketbedah', label: 'Paket Bedah' },
				{ icon: 'arrow-right', value: 'icd9', label: 'Data ICD 9' },
				{ icon: 'arrow-right', value: 'icd10', label: 'Data ICD 10' },
				{ icon: 'arrow-right', value: 'ruangans', label: 'Master Ruangan' },
				{ icon: 'arrow-right', value: 'carabayar', label: 'Metode Pembayaran' },
				{ icon: 'arrow-right', value: 'asuransi', label: 'Data Asuransi' },
				{ icon: 'arrow-right', value: 'layanan', label: 'Master Tindakan' },
				{ icon: 'arrow-right', value: 'tarif', label: 'Tarif Layanan' },
				{ icon: 'arrow-right', value: 'dokter', label: 'Data Dokter Spesialis' },
				{ icon: 'arrow-right', value: 'dokterumum', label: 'Data Dokter Umum' },
				{ icon: 'arrow-right', value: 'paketbedah', label: 'Data Paket Bedah' },
			]
		}
	},
	methods: {
		showMenuProfile: function () {
			if (dropdownWindow.classList.contains('hidden')){
				dropdownWindow.classList.remove('hidden');
				dropdownWindow.classList.toggle('active');
			}
			else {
				dropdownWindow.classList.remove('active');
				dropdownWindow.classList.toggle('hidden');
			}

			if (dropdownWindow_patch.classList.contains('active')){
				dropdownWindow_patch.classList.remove('active');
				dropdownWindow_patch.classList.toggle('hidden');
			}
		},

		showMenuPatch: function () {
			const bounding = vm.$refs.righttop.getBoundingClientRect();
			let right = bounding.width + 10;
			vm.stylepatch = 'right: ' + right + 'px';
			console.log(right)	
			
			if (dropdownWindow_patch.classList.contains('hidden')){
				dropdownWindow_patch.classList.remove('hidden');
				dropdownWindow_patch.classList.toggle('active');
			}
			else {
				dropdownWindow_patch.classList.remove('active');
				dropdownWindow_patch.classList.toggle('hidden');
			}

			if (dropdownWindow.classList.contains('active')){
				dropdownWindow.classList.remove('active');
				dropdownWindow.classList.toggle('hidden');
			}
		},

		resetispatch: function () { vm.ispatch = false; },

		reloading: function () { vm.$emit('reloading'); },

		repatch: function (value) {
			if (!vm.ispatch) {
				vm.ispatch = true;
				let url = '/allapi/patch';
				let data = new FormData();
				data.append('position', value);
				vm.$emit('repatch', url, data, value);
			}
		},
	},
}

</script>