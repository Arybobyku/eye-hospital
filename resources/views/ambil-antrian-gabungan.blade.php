<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Ambil Antrian</title>
  <link rel="stylesheet" href="{{ asset('css/antriangabungan.css') }}" type="text/css" />
  <link rel="stylesheet" href="https://printjs-4de6.kxcdn.com/print.min.css" type="text/css" />
</head>

<body>

<div id="app">
  <div class="ambil-antrian-wrap">
    <div class="ambil-antrian-middle" >
      <p align="center" style="margin-top: -10px; margin-bottom: 30px"><img src="{{ asset('images/aset.png') }}" height="170" alt="" /></p>
      <div class="ambil-antrian-inner" ref="rootmodal" style="margin-right: 0px">
        <h2>No. Antrian : A - <span v-html="checknumber()"></span></h2>
        <p>Antrian Kunjungan Pasien ke Poli Mata</p>
        <div class="button">
					<button class="umum" v-on:click="add('Umum')">UMUM</button>
          {{-- <button class="umum" v-on:click="add('UMUM')">UMUM</button> --}}
					{{-- <button class="asuransi" v-on:click="add('ASURANSI')">ASURANSI</button> --}}
        </div>

				<div :style="loading.display" class="wrap-loading-main">
					<div class="loading-main">
						<div class="boxes">
							<div class="box"><div></div><div></div><div></div><div></div></div>
							<div class="box"><div></div><div></div><div></div><div></div></div>
							<div class="box"><div></div><div></div><div></div><div></div></div>
							<div class="box"><div></div><div></div><div></div><div></div></div>
						</div>
					</div>
				</div>
      </div>

			{{-- <div class="ambil-antrian-inner" ref="rootmodalright" style="margin-left: 10px">
        <h2>No. Antrian : K - <span v-html="checknumberbebas()"></span></h2>
        <p>Antrian Kunjungan Pasien ke Pelayanan Apotek</p>
        <div class="button">
					<button class="umum" v-on:click="addbebas('-')">Racikan</button>
          <button class="umum" style=" margin-right: 0" v-on:click="addbebas('nonracikan')">Non Racikan</button>
        </div>

				<div :style="loading.displayright" class="wrap-loading-main">
					<div class="loading-main">
						<div class="boxes">
							<div class="box"><div></div><div></div><div></div><div></div></div>
							<div class="box"><div></div><div></div><div></div><div></div></div>
							<div class="box"><div></div><div></div><div></div><div></div></div>
							<div class="box"><div></div><div></div><div></div><div></div></div>
						</div>
					</div>
				</div>
      </div> --}}
    </div>
  </div>
</div>

<script src="{{ asset('js/axios.min.js') }}"></script>
<script src="{{ asset('js/vue.min.js') }}"></script>
<script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>

<script>
var vm;
new Vue({
  el: "#app",
  delimiters: ['{%', '%}'],
  mounted: function() { vm = this; vm.firstloads(); },
	data: () => {
		return {
			loading: { display: 'display: none',  displayright: 'display: none', },
			attach: {
				link : {
					load: '/antrian/tiketing/load',
					add: '/antrian/tiketing/add',
					addbebas: '/apotek/bebas/antrian'
				}, url: '', data: null
			},
			number: 0,
			numberbebas: 0,
			position: 'firstload',
		}
	},
	methods: {
		firstloads:function() {
			vm.attach.url = vm.attach.link.load;
			vm.attach.data = new FormData();
			vm.attach.data.append('kosong', '');
			vm.position = 'loaddata';
			setTimeout(() => { vm.loaders(); vm.executions(); }, 250);
		},
		loads:function() {
			vm.attach.url = vm.attach.link.load;
			vm.attach.data = new FormData();
			vm.attach.data.append('kosong', '');
			vm.position = 'loaddata';
			vm.executions();
		},
		checknumber:function() {
			let msg = '';
    	if (this.number < 10) { msg = '00' + this.number; } 
			else if (this.number > 9 && this.number < 100) { msg = '0' + this.number; } 
			else if (this.number > 99 && this.number < 1000) { msg = this.number; }
    	return msg;
		},
		checknumberbebas:function() {
			let msg = '';
    	if (this.numberbebas < 10) { msg = '00' + this.numberbebas; } 
			else if (this.numberbebas > 9 && this.numberbebas < 100) { msg = '0' + this.numberbebas; } 
			else if (this.numberbebas > 99 && this.numberbebas < 1000) { msg = this.numberbebas; }
    	return msg;
		},
		add:function(posisi) {
			vm.attach.url = vm.attach.link.add;
			vm.attach.data = new FormData();
			vm.attach.data.append('jenis', posisi);
			vm.attach.data.append('number', vm.number);
			vm.position = 'adddata';
			vm.loaders(); vm.executions();
		},

		addbebas:function(posisi) {
			vm.attach.url = vm.attach.link.addbebas;
			vm.attach.data = new FormData();
			vm.attach.data.append('jenis', posisi);
			vm.attach.data.append('number', vm.numberbebas);
			vm.position = 'adddatabebas';
			vm.loaders(); vm.executions();
		},
		loaders:function() {
			const left = this.$refs.rootmodal.getBoundingClientRect();
			//const leftright = this.$refs.rootmodalright.getBoundingClientRect();
			vm.loading.display = vm.loading.display == 'display: none' ? 'display:block;width:'+(left.width)+'px;height:'+(left.height)+'px; left: 0; top: 195px' : 'display: none';
			//vm.loading.displayright = vm.loading.displayright == 'display: none' ? 'display:block;width:'+(leftright.width)+'px;height:'+(leftright.height)+'px; left: '+(left.width+20)+'px; top: 195px' : 'display: none';
		},
		printout() {
      const vm = this;
      printJS({
      	printable: '/storage/antrian/number.pdf',
      	type: 'pdf',
      	showModal: false
      });
    },
		printoutbebas() {
      const vm = this;
      printJS({
      	printable: '/storage/antrian/numberbebas.pdf',
      	type: 'pdf',
      	showModal: false
      });
    },
		executions: function() {
      axios.post(vm.attach.url, vm.attach.data, { headers: { 'Content-Type': 'multipart/form-data' } })
      .then(function(response) {
        setTimeout(function() {
					console.log(response);
					if (vm.position == 'loaddata') { vm.number = response.data.number; vm.numberbebas = response.data.numberbebas; vm.loaders(); }
					else if (vm.position == 'adddata') { 
						vm.printout();
						vm.loads(); 
					}
					else if (vm.position == 'adddatabebas') { 
						vm.printoutbebas();
						vm.loads(); 
					}
        }, 250, this);
      })
      .catch(function(error) {
				console.log(error.response);
				vm.loaders();
        alert('gagal');
      });
    },
	},
});
</script>
</body>

</html>
