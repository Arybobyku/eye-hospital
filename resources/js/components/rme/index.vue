<template>
	<div class="search-container">	
		<!-- INPUT -->
		<input 
			type="text"
			v-model="searchQuery"
			@input="searchPatient"
			placeholder="Cari pasien..."
			class="border p-2 rounded w-full"
		/>

		<!-- DROPDOWN HASIL -->
		<div 
			v-if="showDropdown && patientResults.length > 0"
			class="dropdown-result"
		>
			<div 
			class="item"
			v-for="(item, i) in patientResults"
			:key="i"
			@click="selectPatient(item)"
			>
			<strong>{{ item.name }}</strong> ({{ item.rm }}) <br>
			<span class="address">{{ item.address }}</span>
			</div>
		</div>

		<!-- DETAIL PASIEN -->
		<div 
			v-if="selectedPatient"
			class="detail-box"
		>
			<h3>{{ selectedPatient.name }}</h3>
			<p><b>Nomor RM:</b> {{ selectedPatient.rm }}</p>
			<p><b>Alamat:</b> {{ selectedPatient.address }}</p>
		</div>
	</div>

<div class="layout-container">

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="sidebar-title">Data Pasien</div>

        <ul class="sidebar-menu">
            <li class="active">
                <i class="icon">&#128100;</i> History Kunjungan
            </li>
            <li><i class="icon">&#9881;</i> Pengkajian Data Umum</li>
            <li><i class="icon">&#128221;</i> Persetujuan Umum</li>
            <li><i class="icon">&#9888;</i> Pengkajian Risiko Jatuh</li>
            <li><i class="icon">&#9993;</i> Informed Consent</li>
            <li><i class="icon">&#128200;</i> Tanda-Tanda Umum</li>
            <li><i class="icon">&#9997;</i> Tindakan</li>
            <li><i class="icon">&#128196;</i> SOAP</li>
            <li><i class="icon">&#128462;</i> CPPT</li>
            <li><i class="icon">&#128101;</i> Status Pasien</li>
            <li><i class="icon">&#128300;</i> Pengkajian Prabedah</li>
            <li><i class="icon">&#128295;</i> Surgical Safety Checklist</li>
            <li><i class="icon">&#128137;</i> Penunjang Medis</li>
            <li><i class="icon">&#128657;</i> MCU</li>
            <li><i class="icon">&#128138;</i> Resep dan Obat</li>
            <li><i class="icon">&#128179;</i> Bill Pembayaran</li>
        </ul>
    </aside>

    <!-- CONTENT -->
    <main class="content">

        <div class="panel">
            <h2>Ringkasan Klinik</h2>
            <div class="panel-body">
                <div class="row">
                    <div class="col">
                        <p><strong>Dokter Saat Ini</strong> : dr Nisa</p>
                        <p><strong>Konsul dokter terakhir</strong> : dr Nisa</p>
                        <p><strong>Diagnosis</strong> : Acne</p>
                    </div>
                    <div class="col">
                        <p><strong>Konsumsi Obat</strong> :</p>
                        <p>1. CREAM ACNE, 1×1 Oleskan</p>
                        <p>2. CREAM MALAM, 3×1 Oleskan</p>
                        <p><strong>Alergi</strong> : Aclidinium, ACARBOSE</p>
                    </div>
                </div>
            </div>
        </div>

        <br>

        <div class="panel">
            <h2>History Kunjungan</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Registrasi</th>
                        <th>Tanggal</th>
                        <th>Jam</th>
                        <th>Layanan</th>
                        <th>Dokter</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td><td>006969</td><td>06-11-2025</td><td>16:27</td><td>AESTHETIC</td><td>dr Nisa</td>
                    </tr>
                    <tr>
                        <td>2</td><td>006889</td><td>10-10-2025</td><td>20:32</td><td>POLI PSIKOLOGI</td><td>dr Yoga</td>
                    </tr>
                </tbody>
            </table>
        </div>

    </main>

</div>

</template>

<script>

var vm;
import { defineAsyncComponent } from 'vue';
import { formpermintaan } from './FormData.js';
import { nullAndZero, datename } from '../../module/Manipulation.js';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
import { filterselected, hideselected, itemselected, clearselected, boxselected, conditionselected } from '../../module/SelectedFilter.js';
import { initindexdb, indexdbprocessing } from '../../module/Indexdb.js';
export default {
	emits: ["titletrigger", "repatch"],
	beforeUnmount:function() {},
	components: { 
		toast, 
		Datatable: defineAsyncComponent(() => import('../../section/Datatable.vue')) ,
		Inputed: defineAsyncComponent(() => import('../../section/Inputed.vue')),
		Selected: defineAsyncComponent(() => import('../../section/Selected.vue')),
	},
	created: function () {},
	mounted: function () {
		vm = this;
		setTimeout(() => { this.titletrigger(); }, 250);
		setTimeout(() => {
			vm.form = vm.formpermintaan();
		}, 1250);
		window.onclick = function(event) { 
			let a = event.target.className; 
			
			try { 
				if (a.split(" ")) { 
					a = a.split(" "); 
					
					if (a[0] != 'hospitals' && a[0] != 'click-title') { 
						vm.selecthide(); 
					} 
				} 
				if (event.target.className == '') { 
					vm.selecthide(); 
				} 
			} 
			catch { console.log('mistmatch'); } }
	},
	data: function () { return {
		uri: 'histori',
		position: '',
		form: null,

		// 👇 Tambahan untuk fitur search pasien
		searchQuery: "",
		patientResults: [],
		selectedPatient: null,
		showDropdown: false,
		typingTimer: null,
	}},
	methods: {
		formpermintaan,
		
		filterselected, hideselected, itemselected, clearselected, boxselected, conditionselected, initindexdb, indexdbprocessing,

		selectfilter: function (event, key) { vm.form = vm.filterselected(vm.form, key); },
		selecthide:function() { vm.form = vm.hideselected(vm.form); },
		selecteditem:function(item, key) { 
			vm.form = vm.itemselected(vm.form, item, key);
		},
		selectclear:function(key) { 
			vm.form = vm.clearselected(vm.form, key);
		},
		selectbox:function(event, key, statics) {

			if (!vm.form.select[key].disabled) {
				let result = vm.boxselected(event, vm.form, key);
				if (result._position == 'stop') { return ; }
				else if (result._position == 'nextstop') { vm.form = result._form; }
				else { vm.selecthide(); vm.getIndexDB(key, statics); vm.form.select[key].option = 'display: block'; }
			}
		},

		getIndexDB:function(key, statics) {
			vm.form.select[key].data = []; vm.form.select[key].filter = [];
			if (statics) { vm.form.select[key].data = this.arr[key]; vm.form.select[key].filter = this.arr[key]; }
			else {
				vm.initindexdb(vm.$dbNameIndexDb, key)
					.then(function(response){ 
						vm.form = vm.indexdbprocessing(response, vm.form, key);
					})
					.catch(function(error){ console.log(error); });
			}
		},

		// -------------------------------------
		// 👇 FITUR REALTIME SEARCH PASIEN
		// -------------------------------------

		searchPatient() {
			clearTimeout(this.typingTimer);

			// debounce 300ms
			this.typingTimer = setTimeout(() => {
			if (this.searchQuery.trim() === "") {
				this.patientResults = [];
				this.showDropdown = false;
				return;
			}

			// TODO: Ganti dengan API kamu
			this.patientResults = this.fakePatientAPI(this.searchQuery);
			this.showDropdown = true;
			}, 300);
		},

		// Mock API — kamu ganti sendiri dengan axios / fetch
		fakePatientAPI(keyword) {
			const data = [
			{ name: "Budi Santoso", rm: "RM001", address: "Jl. Mangga" },
			{ name: "Siti Aminah", rm: "RM002", address: "Jl. Rambutan" },
			{ name: "Andi Wijaya", rm: "RM003", address: "Jl. Nangka" },
			{ name: "Rina Lestari", rm: "RM004", address: "Jl. Durian" },
			{ name: "Doni Saputra", rm: "RM005", address: "Jl. Melon" },
			{ name: "Dini Saputra", rm: "RM005", address: "Jl. Melon" },
			{ name: "Dulu Saputra", rm: "RM005", address: "Jl. Melon" },
			];
			return data
			.filter(x => x.name.toLowerCase().includes(keyword.toLowerCase()))
			.slice(0, 5);
		},

		selectPatient(patient) {
			this.selectedPatient = patient;
			this.searchQuery = patient.name;
			this.showDropdown = false;
		},
		

		/*************************************************************************************************************************
		* Bagian fungsi yang opsional untuk manipulasi data dan string
		*************************************************************************************************************************/
		nullAndZero, datename,

		/*************************************************************************************************************************
		* Bagian fungsi yang wajib disertakan disetiap index dan tidak perlu diubah-ubah
		*************************************************************************************************************************/
		executions: function () { 
			axios.post(vm.attach.url, vm.attach.data, {
				 headers: { 
					'Content-Type': 'multipart/form-data',
				 } 
				}).then(function (response) { if (response.data.data == '419') { window.location.href = '/masuk'; } setTimeout(function(){ vm.berhasil(response); }, 750, this); }).catch(function (error){ setTimeout(function(){ vm.gagal(error); }, 750, this); }); },
		dialog: function (_text, _confirm, posisi) { Swal.fire({ title:"Apakah Anda Yakin?", text:_text, icon:"warning", showCancelButton:!0, confirmButtonColor:"#1c84ee", cancelButtonColor:"#fd625e", confirmButtonText: _confirm, cancelButtonText:"Tidak, batal!" }).then(function(e){ if (e.isConfirmed) { vm.runconfirm(posisi); } }); },
		notification: function (message, timer, position) { if (position == 'error') { toast.error(message, { rtl: false, autoClose: timer }); } else { toast.success(message, { rtl: false, autoClose: timer }); } },
		loadPatch: function () { vm.firstloader(); },
		firstloader: function () { const left = this.$refs.roottable.getBoundingClientRect(); vm.$refs.Loader.running(left); },
		unloadPatch: function (position) { vm.firstloader(); if (position == 'success') { vm.notification('Data berhasil dipatch.', 3000, position); } else if (position == 'error') { vm.notification('Data gagal dipatch.', 3000, position); } },
		titletrigger: function () { let title = vm.$router.currentRoute._value.meta.title; vm.$emit('titletrigger', title); }
	}
	
}

</script>
<style>
.search-container {
  position: relative;
  max-width: 480px;
  margin: 0 auto;
  font-family: "Inter", "Segoe UI", sans-serif;
}

/* INPUT SEARCH */
.search-container input {
  width: 100%;
  padding: 12px 14px;
  font-size: 15px;
  border: 1px solid #cfd6dd;
  border-radius: 10px;
  background: #ffffff;
  transition: all 0.25s ease;
  box-shadow: 0 0 0 rgba(0, 0, 0, 0);
}

.search-container input:focus {
  border-color: #3b82f6; /* biru elegan */
  box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
  outline: none;
}

/* DROPDOWN LIST */
.dropdown-result {
  position: absolute;
  top: 110%;
  width: 100%;
  background: #ffffff;
  border: 1px solid #d7dde4;
  border-radius: 12px;
  margin-top: 4px;
  box-shadow: 0 12px 28px rgba(0,0,0,0.08);
  overflow: hidden;
  animation: fadeDown 0.2s ease-out;
  z-index: 50;
}

/* ITEM DALAM DROPDOWN */
.dropdown-result .item {
  padding: 12px 14px;
  cursor: pointer;
  transition: background 0.15s ease;
  border-bottom: 1px solid #f1f3f5;
}

.dropdown-result .item:last-child {
  border-bottom: none;
}

.dropdown-result .item:hover {
  background: #f7faff; /* biru sangat muda */
}

.dropdown-result .item strong {
  font-size: 15px;
  color: #1f2937;
}

.dropdown-result .item .address {
  font-size: 13px;
  color: #6b7280;
}

/* DETAIL BOX */
.detail-box {
  margin-top: 16px;
  padding: 16px;
  border-radius: 12px;
  background: linear-gradient(145deg, #ffffff, #f4f4f4);
  border: 1px solid #e2e8f0;
  box-shadow: 0 8px 20px rgba(0,0,0,0.05);
  animation: fadeIn 0.25s ease;
}

.detail-box h3 {
  margin-bottom: 6px;
  font-size: 17px;
  color: #1f2937;
}

/* ======== LAYOUT ======== */
.layout-container {
    display: flex;
    min-height: 100vh;
    background: #f4f6f9;
    font-family: "Segoe UI", sans-serif;
}

/* ======== SIDEBAR ======== */
.sidebar {
    width: 240px;
    background: #8b0022;          /* Merah maroon */
    color: white;
    padding-top: 20px;
    flex-shrink: 0;
    position: sticky;
    top: 0;
    height: 100vh;
    overflow-y: auto;
    box-shadow: 3px 0 6px rgba(0,0,0,0.2);
}

.sidebar-title {
    font-size: 20px;
    font-weight: 600;
    padding: 15px 20px;
    border-bottom: 1px solid rgba(255,255,255,0.2);
}

.sidebar-menu {
    list-style: none;
    padding: 0;
    margin: 0;
}

.sidebar-menu li {
    padding: 12px 20px;
    font-size: 14px;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 10px;
    transition: 0.25s;
}

.sidebar-menu li:hover {
    background: rgba(255,255,255,0.15);
}

.sidebar-menu li.active {
    background: #9acd32;       /* Hijau active seperti screenshot */
    color: #000;
    font-weight: 600;
}

.icon {
    width: 18px;
}

/* ======== CONTENT ======== */
.content {
    flex-grow: 1;
    padding: 25px 35px;
}

/* ======== PANEL ======== */
.panel {
    background: white;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.panel h2 {
    margin-bottom: 15px;
    font-size: 18px;
    color: #004c92;
}

/* ======== GRID ======== */
.row {
    display: flex;
    gap: 50px;
}

.col {
    flex: 1;
}

/* ======== TABLE ======== */
.table {
    width: 100%;
    border-collapse: collapse;
}

.table thead {
    background: #004c92;
    color: white;
}

.table th, .table td {
    padding: 10px;
    border: 1px solid #d0d0d0;
    font-size: 14px;
}

.table tbody tr:nth-child(even) {
    background: #eef4ff;
}


/* ANIMASI */
@keyframes fadeDown {
  from {
    opacity: 0;
    transform: translateY(-6px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(8px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

</style>