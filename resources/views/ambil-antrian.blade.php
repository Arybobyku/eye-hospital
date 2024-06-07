<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Ambil Antrian</title>
  <link rel="stylesheet" href="{{ asset('css/antrian.css') }}" type="text/css" />
  <link rel="stylesheet" href="https://printjs-4de6.kxcdn.com/print.min.css" type="text/css" />
</head>

<body>

<div id="app">
  <div class="ambil-antrian-wrap">
    <div class="ambil-antrian-middle" >
      <p align="center" style="margin-top: -10px; margin-bottom: 20px"><img src="{{ asset('images/aset.png') }}" height="120" alt="" /></p>
      <div class="ambil-antrian-inner" ref="rootmodal">
        <h2>No. Antrian : A - <span v-html="checknumber()"></span></h2>
        <p>Silahkan anda pilih tombol dibawah ini</p>
        <div class="button">
					<button class="umum" v-on:click="add('Umum')">AMBIL ANTRIAN</button>
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
						<h3>Please Wait ...</h3>
					</div>
				</div>
      </div>
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
			loading: { display: 'display: none' },
			attach: {
				link : {
					load: '/antrian/tiketing/load',
					add: '/antrian/tiketing/add'
				}, url: '', data: null
			},
			number: 0,
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
		add:function(posisi) {
			vm.attach.url = vm.attach.link.add;
			vm.attach.data = new FormData();
			vm.attach.data.append('jenis', posisi);
			vm.attach.data.append('number', vm.number);
			vm.position = 'adddata';
			vm.loaders(); vm.executions();
		},
		loaders:function() {
			const left = this.$refs.rootmodal.getBoundingClientRect();
			vm.loading.display = vm.loading.display == 'display: none' ? 'display:block;width:'+(left.width)+'px;height:'+(left.height)+'px; left: 0; top: 130px' : 'display: none';
		},
		printout() {
      const vm = this;
      printJS({
      	printable: '/storage/antrian/number.pdf',
      	type: 'pdf',
      	showModal: false
      });
    },
		executions: function() {
      axios.post(vm.attach.url, vm.attach.data, { headers: { 'Content-Type': 'multipart/form-data' } })
      .then(function(response) {
        setTimeout(function() {
					console.log(response);
					if (vm.position == 'loaddata') { vm.number = response.data.number; vm.loaders(); }
					else if (vm.position == 'adddata') { 
						vm.printout();
						vm.loads(); 
					}
        }, 500, this);
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
