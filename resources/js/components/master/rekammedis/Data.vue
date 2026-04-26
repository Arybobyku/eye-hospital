<template>
  <div>
    <div style="margin-bottom: 1rem;">
      <div style="margin-bottom: 1rem;">
        <label>
          Rentang Waktu
        </label>
        <PeriodSelector v-model="filters.date" />
      </div>
      
      <templte v-if="tab.content.table">
        <hr class="border-slate-100/50 my-5" style="margin-bottom: 0.75rem;" />

        <Selected v-on:click="selectbox($event, form.select.carabayar.name, form.select.carabayar.statics)" 
          :ref="form.select.carabayar.name" @selecteditem="selecteditem" @selectclear="selectclear"
          :selection="form.select.carabayar" v-on:keyup="selectfilter($event, form.select.carabayar.name)"></Selected>

        <Selected v-on:click="selectbox($event, form.select.asuransi.name, form.select.asuransi.statics)" 
          :ref="form.select.asuransi.name" @selecteditem="selecteditem" @selectclear="selectclear"
          :selection="form.select.asuransi" v-on:keyup="selectfilter($event, form.select.asuransi.name)"></Selected>
          
        <hr class="border-slate-100/50 my-5" />
        <div class="my-3">
          <label class="inline-flex items-center gap-3">
            <input type="checkbox" id="is_surgery" v-model="filters.is_surgery" />
            <strong>Pasien Operasi</strong>
          </label>
        </div>
        <div>
          <Selected v-on:click="selectbox($event, form.select.icd10.name, form.select.icd10.statics)"
            :ref="form.select.icd10.name" @selecteditem="selecteditem" @selectclear="selectclear"
            :selection="form.select.icd10" v-on:keyup="selectfilter($event, form.select.icd10.name)"
          />
        </div>
        <div>
          <label>
            Jenis Kelamin
            <select class="ml-3" v-model="filters.jenis_kelamin">
              <option :value="null">-</option>
              <option value="Laki-Laki">Laki-Laki</option>
              <option value="Perempuan">Perempuan</option>
            </select>
          </label>
        </div>
      </templte>
    </div>
    <div class="inner" ref="roottable">
      <div class="form-self-group">
        <div class="tab-lines"><div class="tab"><button v-for="(item, index) in tab.button" :class="item.class" v-on:click="changesTab(item.value, index, item.class)">{{ item.label }}</button></div></div>
        <div class="tab-content">
          <div class="content-tab-in" v-show="tab.content.table">
            <div style="display: flex; justify-content: end; align-items: center; gap: 1rem; margin-bottom: 0.75rem;">
              <a :href="excelDownloadLink">
                <button class="tooltip btn-success">
                  <vue-feather type="printer"></vue-feather>
                  <span class="tooltiptext">Cetak ke Excel</span>
                </button>
              </a>
            </div>
            <Datatable ref="Datatable" :module="module" @tablereload="tablereload" @tablebutton="tablebutton" @ready="handleReady"></Datatable>
          </div>
          <div class="content-tab-in" v-show="tab.content.stats">
            <div class="grid">
              <div class="col-4 card">
                <h2 class="m-0 mb-3">Diagnosa Terbanyak</h2>
                <StatsPenyakitTerbanyak :filters="filters" />
              </div>
              <div class="col-4 card">
                <h2 class="m-0 mb-3">Jumlah Kunjungan</h2>
                <StatsJumlahPengunjung :filters="filters" />
              </div>
              <div class="col-4 card">
                <h2 class="m-0 mb-3">Jumlah Perawatan</h2>
                <StatsJumlahKunjungan :filters="filters" />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { defineAsyncComponent } from 'vue';
import { toast } from 'vue3-toastify';
import qs from 'qs';
import 'vue3-toastify/dist/index.css';
import Swal from 'sweetalert2';
import { format } from 'date-fns';
import { filterselected, hideselected, itemselected, clearselected, boxselected, conditionselected } from '../../../module/SelectedFilter.js';
import { initindexdb, indexdbprocessing } from '../../../module/Indexdb.js';

export default {
  components: {
		Datatable: defineAsyncComponent(() => import('../../../section/Datatable.vue')),
		Selected: defineAsyncComponent(() => import('../../../section/Selected.vue')),
    PeriodSelector: defineAsyncComponent(() => import('../../../section/PeriodSelector.vue')),
    StatsJumlahPengunjung: defineAsyncComponent(() => import('./StatsJumlahPengunjung.vue')),
    StatsJumlahKunjungan: defineAsyncComponent(() => import('./StatsJumlahKunjungan.vue')),
    StatsPenyakitTerbanyak: defineAsyncComponent(() => import('./StatsPenyakitTerbanyak.vue')),
  },
  data(){
    return {
      tab: {
        button: [
          { value: 'table', label: 'Data Tabel', class: 'tab-active' },
          { value: 'stats', label: 'Statistik', class: 'tab-no-active' },
        ],
        content: { 
          table: true,
          stats: false,
        }
      },

      module: { data: [], column: [], total: 0, ispaging: true },
      // Nilai date picker.
      date: new Date(),
      // Ini diperlukan karena legacy code menggunakan teknik sendiri dalam memproses form.
      // Teknik ini masih belum dipahami dan sangat direkomendasikan untuk diganti.
      form: {
        select: {
          icd10: {
            key : 'icd10', for_id: 'form_'+'icd10', name: 'icd10', uuid:'', value: '', label: 'Silahkan Pilih', 
            filter: [], data: [], search: '', option: 'display: none', statics: false,
            class: 'icd10', isrequired: false, html: 'Data ICD 10', issearch: true, disabled: false,
          },
          carabayar: { 
            key : 'carabayar', for_id: 'form_'+'carabayar', name: 'carabayar', uuid:'', value: '', label: 'Silahkan Pilih', 
            filter: [], data: [], search: '', option: 'display: none', statics: false,
            class: 'carabayar', isrequired: false, html: 'Metode Pembayaran', issearch: false, disabled: false,
          },
          asuransi: { 
            key : 'asuransi', for_id: 'form_'+'asuransi', name: 'asuransi', uuid:'', value: '', label: 'Silahkan Pilih', 
            filter: [], data: [], search: '', option: 'display: none', statics: false,
            class: 'asuransi', isrequired: false, html: 'Nama Asuransi', issearch: true, disabled: true,
          },	
        },
      },
      filters: {
        // Nilai filter tanggal yang seharusnya.
        date: [new Date(), new Date()],
        jenis_kelamin: null,
        is_surgery: false,
      },
      column: [
        // registrasi
        { value: 'tanggal', label: 'Waktu Pendaftaran', type: 'text', search: false, close: false, button: false },
        // registrasi
        { value: 'no_pendaftaran', label: 'No Pendaftaran', type: 'text', search: false, close: false, button: false },
        // registrasi
        { value: 'rekam_medis', label: 'Rekam Medis', type: 'text', search: false, close: false, button: false },
        // registrasi
        { value: 'nama_pasien', label: 'Nama Pasien', type: 'text', search: false, close: false, button: false },
        // pemeriksaan_dokter
        { value: 'pemeriksaan_diagnosa', label: 'Diagnosa', type: 'text', search: false, close: false, button: false },
        // registrasi
        { value: 'jenis_kelamin', label: 'Jenis Kelamin', type: 'text', search: false, close: false, button: false },
        // pasien
        { value: 'kelompok_umur_nama', label: 'Golongan Umur', type: 'text', search: false, close: false, button: false },
        // registrasi
        { value: 'agama', label: 'Agama', type: 'text', search: false, close: false, button: false },
        // pasien
        { value: 'status_pernikahan', label: 'Status Perkawinan', type: 'text', search: false, close: false, button: false },
        // pasien
        { value: 'pekerjaan', label: 'Pekerjaan', type: 'text', search: false, close: false, button: false },
        // pasien
        { value: 'alamat', label: 'Alamat Lengkap', type: 'text', search: false, close: false, button: false },
        // pasien
        { value: 'nama_kecamatan', label: 'Kecamatan', type: 'text', search: false, close: false, button: false },
        // pasien
        { value: 'nama_kab_kota', label: 'Kab / Kota', type: 'text', search: false, close: false, button: false },
        // registrasi
        { value: 'cara_masuk', label: 'Cara Masuk', type: 'text', search: false, close: false, button: false },
        // registrasi
        { value: 'jalur_masuk', label: 'Kunjungan', type: 'text', search: false, close: false, button: false },
        // penanggung_jawab
        { value: 'nama_pj', label: 'Penanggung Jawab', type: 'text', search: false, close: false, button: false },
        // registrasi 
        { value: 'rujukan', label: 'Nama Perujuk', type: 'text', search: false, close: false, button: false },
        // pemeriksaan_ro
        { value: 'kasus_urgent', label: 'Jenis Kasus', type: 'text', search: false, close: false, button: false },
        // registrasi
        { value: 'carabayar_nama', label: 'Cara Bayar', type: 'text', search: false, close: false, button: false },
        // registrasi
        { value: 'ruang_poliklinik', label: 'Nama Ruangan', type: 'text', search: false, close: false, button: false },
        // registrasi
        { value: 'nama_dokter', label: 'Nama Dokter', type: 'text', search: false, close: false, button: false },
        // registrasi
        { value: 'tanggal_bayar', label: 'Pulang', type: 'text', search: false, close: false, button: false },
        // registrasi
        { value: 'status', label: 'Status Periksa', type: 'text', search: false, close: false, button: false },
      ],
    };
  },
  watch: {
    'form.select.icd10.value': {
      handler(){
        this.$refs.Datatable.skeleton();
        this.readData();
      },
    },
    'form.select.carabayar.value': {
      handler(){
        this.$refs.Datatable.skeleton();
        this.readData();
      },
    },
    'form.select.asuransi.value': {
      handler(){
        this.$refs.Datatable.skeleton();
        this.readData();
      },
    },
    'filters': {
      handler(){
        this.$refs.Datatable.skeleton();
        this.readData();
      },
      deep: true,
    },
  },
  computed: {
    excelDownloadLink(){
      return '/master/rekammedis/listexcel?' + qs.stringify({
        dateRange: {
          start: format(this.filters.date[0], 'yyyy-MM-dd'),
          end: format(this.filters.date[1], 'yyyy-MM-dd'),
        },
        jenis_kelamin: this.filters.jenis_kelamin || null,
        icd10: this.form.select.icd10.value || null,
        carabayar: this.form.select.carabayar.value || null,
        asuransi: this.form.select.asuransi.value || null,
        is_surgery: this.filters.is_surgery || null,
      }, {
        arrayFormat: 'brackets',
        format: 'RFC3986',
        encodeValuesOnly: true,
        skipNulls: true,
      });
    }
  },
  methods: {
    filterselected, hideselected, itemselected, clearselected, boxselected, conditionselected,
    initindexdb, indexdbprocessing,

		selecthide:function() { this.form = this.hideselected(this.form); },
    getIndexDB:function(key, statics) {
			this.form.select[key].data = []; this.form.select[key].filter = [];
			if (statics) { this.form.select[key].data = this.arr[key]; this.form.select[key].filter = this.arr[key]; }
			else {
				this.initindexdb(this.$dbNameIndexDb, key)
					.then((response) => { 
						this.form = this.indexdbprocessing(response, this.form, key);

            if (this.form.select.asuransi.data.length < 1) {
							this.form.select.asuransi.disabled = true;
							this.form.select.asuransi.value = '';
							this.form.select.asuransi.label = 'Silahkan Pilih';
							this.form.select.asuransi.isrequired = false;
						}
						else if (this.form.select.asuransi.data.length > 0) {
							this.form.select.asuransi.disabled = false;
							this.form.select.asuransi.isrequired = true;
						}
					})
					.catch(function(error){ console.log(error); });
			}
		},

    selecteditem:function(item, key) { 
			this.form = this.conditionselected(this.form, item, key, 'address'); 
			this.form = this.itemselected(this.form, item, key);

      if (key === 'carabayar'){
				this.getIndexDB('asuransi', false);
      }
		},

		selectclear:function(key) { 
			this.form = this.clearselected(this.form, key);
		},

    selectbox:function(event, key, statics) {
			let msg = 'select-close select-close-'+key;
			if (event.target.className != msg) {
				if (!this.form.select[key].disabled) {
					let result = this.boxselected(event, this.form, key);
					if (result._position == 'stop') { return ; }
					else if (result._position == 'nextstop') { this.form = result._form; }
					else { this.selecthide(); this.getIndexDB(key, statics); this.form.select[key].option = 'display: block'; }
				}
			}
			
		},

    selectfilter: function (event, key) { 
			this.form = this.filterselected(this.form, key); 
		},

    changesTab: function (values, index, classes) {
			if (classes != 'tab-active') {
				for (let i = 0; i < this.tab.button.length; i++) { 
					this.tab.content[this.tab.button[i].value] = false; this.tab.button[i].class = 'tab-no-active'; 
				}
				this.tab.button[index].class = 'tab-active';
				this.tab.content[values] = true;
			}
		},

    converter: function (data, index, column, identity) {
			let _tmp = '';
			if (identity == 'btnhtml') { _tmp = { value: this.btnhtml(data, index), ishtml: 'button', show: false, style: 'width: 40px; text-align: center' } }
			// else if (identity == 'created_at') { _tmp = { value: this.datename(column, true), ishtml: 'html', style: '' }; }
			else { _tmp = { value: column, ishtml: 'text', style: '' } }
			return _tmp != '' ? _tmp : 'empty';
		},

    setDatatable: function (data, total) { let temporer = [], col = []; for (let i = 0; i < data.length; i++) { col = []; for (let j = 0; j < this.column.length; j++) { col.push(this.converter(data[i], i, data[i][this.column[j].value] ? data[i][this.column[j].value] : '-', this.column[j].value)); } temporer.push(col); } this.module.data = temporer; this.module.total = total; return temporer; },

    handleReady(){
      this.$refs.Datatable.skeleton();
      this.readData();
    },
    readData(data = new FormData()){
      data.append('dateRange[start]', format(this.filters.date[0], 'yyyy-MM-dd'));
      data.append('dateRange[end]', format(this.filters.date[1], 'yyyy-MM-dd'));

      if (this.filters.is_surgery){
        data.append('is_surgery', 1);
      }

      if (this.filters.jenis_kelamin){
        data.append('jenis_kelamin', this.filters.jenis_kelamin);
      }
      
      if (this.form.select.icd10.value){
        data.append('icd10', this.form.select.icd10.value);
      }

      if (this.form.select.carabayar.value){
        data.append('carabayar', this.form.select.carabayar.value);
      }

      if (this.form.select.asuransi.value){
        data.append('asuransi', this.form.select.asuransi.value);
      }

      axios.post('/master/rekammedis/list', data)
        .then((res) => {
          this.$nextTick(() => {
            this.$refs.Datatable.update(this.column, this.setDatatable(res.data.data, res.data.total), res.data.total);
				    this.$refs.Datatable.paging(); 
            this.$refs.Datatable.skeleton(); 
          });
        });
    },
    tablereload(data = new FormData(), pos = 'main'){
      this.readData(data);
    },
  }
}
</script>

<style scoped>
/* border-2 border-solid border-gray-300 rounded-xl p-3 */
.card{
  border: 0.2rem solid gray;
  border-radius: 2rem;
  padding: 1rem;
}
</style>