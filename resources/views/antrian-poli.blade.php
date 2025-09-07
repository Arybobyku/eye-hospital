<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Antrian Poliklinik</title>
    <link rel="stylesheet" href="{{ asset('css/antrian.css') }}" type="text/css" />
</head>

<body>
<div class="wrapper" id="app">
  <div class="header">
    <img src="{{ asset('images/logopanjang.png') }}" height="60" />
    <div class="right">
      <div class="jam">
      	<span v-html="day"></span>,<br />
        <span v-html="tanggal"></span>
      </div>
      <div class="tanggals">
        <span v-html="jam"></span>
      </div>
    </div>
  </div>
  <div class="content">
    <div class="left">
      <div class="inner">
        <div class="top">
          <span>
            <h2 v-html=""></h2>
            <h3>Nomor Antrian</h3>
            <h1 v-html="display"></h1>
            <h3 v-html="displayPasien"></h3>
          </span>
        </div>
      	<div class="bottom">
        	<div class="sides">
        		<h2 v-html="poliklinik[0].label"></h2>
            <h1><span v-html="poliklinik[0].nomor"></span></h1>
            <h4><span v-html="poliklinik[0].pasien"></span></h4>
        	</div>
      		<div class="sides">
            <h2 v-on:click="bunyi()" v-html="poliklinik[1].label"></h2>
          	<h1><span v-html="poliklinik[1].nomor"></span></h1>
			<h4><span v-html="poliklinik[1].pasien"></span></h4>
          </div>
        </div>
      </div>
    </div>
    <div class="left">
      <div class="inner">
        <div class="top">
          <span>
            <h2 v-html=""></h2>
            <h3>Nomor Antrian</h3>
            <h1 v-html="displayright"></h1>
            <h3 v-html="displayPasienRight"></h3>
          </span>
        </div>
      	<div class="bottom">
        	<div class="sides">
        		<h2 v-html="poliklinik[2].label"></h2>
            <h1><span v-html="poliklinik[2].nomor"></span></h1>
            <h4><span v-html="poliklinik[2].pasien"></span></h4>
        	</div>
      		<div class="sides">
            <h2 v-html="poliklinik[3].label"></h2>
          	<h1><span v-html="poliklinik[3].nomor"></span></h1>
			<h4><span v-html="poliklinik[2].pasien"></span></h4>
          </div>
        </div>
      </div>
    </div>
	</div>
  <div class="footer">
    <marquee direction="left">
      {{ $text->content }}
    </marquee>
  </div>
</div>
<audio id="myAudio">
	<source src="{{ asset('mp3/bell.ogg') }}" type="audio/ogg">
	<source src="{{ asset('mp3/bell.mp3') }}" type="audio/mpeg">
 	Your browser does not support the audio element.
</audio>
<script src="{{ asset('js/axios.min.js') }}"></script>
<script src="{{ asset('js/vue.min.js') }}"></script>
<script src="{{ asset('js/voice.js') }}"></script>

<script src="{{ asset('js/pusher.min.js') }}"></script>
<script src="{{ asset('js/echo.min.js') }}"></script>

<script>
// TODO: PUSHER LOKAL
// window.Echo = new Echo({
// 	broadcaster: 'pusher',
// 	key: 'ABCDEFG',
// 	cluster: 'mt1',
// 	wsHost: window.location.hostname,
// 	wsPort: 6001,
// 	forceTLS: false,
// 	disableStats: true,
// });
window.Echo = new Echo({
	broadcaster: 'pusher',
	key: "{{ env('PUSHER_APP_KEY') }}",
	cluster: "{{ env('PUSHER_APP_CLUSTER', 'mt1') }}",
	forceTLS: true,
});

new Vue({
  el: "#app",
  delimiters: ['{%', '%}'],
  mounted:function() {
    const vm = this;
    vm.firtsload();
    //vm.showSlides();
    vm.get_data();
		setInterval(() => { vm.firtsload(); }, 1000);
		//this.$nextTick(() => {
   	 Echo.channel('tradespoli').listen('NewTradePoli', (e) => { vm.triggercall(e.trade); });
  	//})
		
  },
  computed:{},
  created:function() { },
  data:function() { return {
		ngulang: 0,
		hitung: 0,
		display: 'P-000',
		displayright: 'P-000',
		displayPasien:'',
		displayPasienRight:'',
		poliklinik: [
			{ nomor: 'R-000', label: 'Refraksi Optisi', pasien:'' },
			{ nomor: 'P-000', label: 'Poli 1', pasien:'' },
			{ nomor: 'P-000', label: 'Poli 2', pasien:'' },
			{ nomor: 'P-000', label: 'Poli 3', pasien:''},
		],
		angka: 1,
    currentDateTime: null,
		titik: ':',
    jam: '',
    tanggal: '',
    day: '',
    slideIndex: 1,
    counter: { satu: '000', dua: '000', active: '000', nomor: '' },
		timetime: null,
  }},
  methods: {
		triggercall:function(data) {
		console.log("TEST",data);
			const vm = this, myArray = data.split("=");
			let tmp = myArray[0].split(" ");
			let jenis = tmp[0] == 'Poliklinik' ? "P" : "R";
			let number = vm.calculate(jenis, parseInt(myArray[1]));
			let pasienName = myArray[2];
			if (tmp[0] == 'Poliklinik') {
				if (tmp[1] == '1') {
					let number = vm.calculate("P1", parseInt(myArray[1]));
					vm.poliklinik[1].nomor = number;
					vm.poliklinik[1].pasien = pasienName;
					vm.display = number;
					vm.displayPasien = pasienName;
					vm.bunyi(number, tmp[1], 'poli');
				}
				else if (tmp[1] == '2') {
					let number = vm.calculate("P2", parseInt(myArray[1]));
					vm.poliklinik[2].nomor = number;
					vm.poliklinik[2].pasien = pasienName;
					vm.displayright = number;
					vm.displayPasienRight = pasienName;
					vm.bunyi(number, tmp[1], 'poli');
				}
				else if (tmp[1] == '3') {
					let number = vm.calculate("P3", parseInt(myArray[1]));
					vm.poliklinik[3].nomor = number;
					vm.poliklinik[2].pasien = pasienName;
					vm.displayright = number;
					vm.displayPasienRight = pasienName;
					vm.bunyi(number, tmp[1], 'poli');
				}
			}
			else if (tmp[0] == 'Refraksi') {
				vm.poliklinik[0].nomor = number;
				vm.poliklinik[0].pasien = pasienName;
				vm.display = number;
				vm.displayPasien = pasienName;
				vm.bunyi(number, tmp[1], 'refraksi optisi');
			}
		},
			
		bunyi:function(nomor, posisi, jenis) {
			const vm = this;
			vm.hitung += 1;
			var x = document.getElementById("myAudio"); 
			x.play();

			if (vm.timetime) { window.clearTimeout(vm.timetime); }
				
			vm.timetime = window.setTimeout(function() {
				let tmp = nomor.split("");
				let msg = 'Nomor antrian, ';

				let angka = '';
				if(jenis == 'poli'){
					msg = msg + tmp[0] + ', ' + tmp[1] +', ';
					angka = tmp[3]+''+tmp[4]+''+tmp[5]
				}else{
					msg = msg + tmp[0] +', ';
					angka = tmp[2]+''+tmp[3]+''+tmp[4];
				}
				if (parseInt(angka) > 0 && parseInt(angka) < 10) { msg = msg + '0, 0, ' + parseInt(angka) + ', '; }
				else if (parseInt(angka) > 9 && parseInt(angka) < 100) { msg = msg + '0, ' + parseInt(angka) + ', '; }
				else if (parseInt(angka) > 99 && parseInt(angka) < 1000) { msg = msg + ' ' + parseInt(angka) + ', '; }

				if (jenis == 'poli') {
					msg = msg + 'ke Poli, '+ posisi;
				 }
				else { msg = msg + 'ke ruangan ' + jenis; }

				const parameters = {
					pitch: 1, rate: 0.97, volume: 1,
					onstart: vm.voiceStartCallback(),
					onEnd: vm.voiceEndCallback()
				}
				responsiveVoice.speak(msg, "Indonesian Female", parameters);

				window.clearTimeout(vm.timetime);
			}, 2000, this);				
		},
			
		voiceStartCallback: function (){ console.log('callback') },
		voiceEndCallback: function (){ console.log('callback') },
    showSlides() {
      var i;
      var n = this.slideIndex;
      var slides = document.getElementsByClassName("mySlides");
      if (n > slides.length) {this.slideIndex = 1}
      if (n < 1) {this.slideIndex = slides.length}
      for (i = 0; i < slides.length; i++) { slides[i].style.display = "none"; }
      // for (i = 0; i < dots.length; i++) { dots[i].className = dots[i].className.replace(" active", ""); }
      slides[this.slideIndex-1].style.display = "block";
      //dots[this.slideIndex-1].className += " active";
      this.slideIndex++;
    },
		calculate:function(jenis, data) {
			let msg = jenis+'-';
			if (parseInt(data) > 0 && parseInt(data) < 10) { msg += '00' + data; }
			else if (parseInt(data) > 9 && parseInt(data) < 100) { msg += '0' + data; }
			else if (parseInt(data) > 99 && parseInt(data) < 1000) { msg += data; }
			return msg;
		},
    get_data:function() {
      const vm = this;
      let form_data = new FormData();
      form_data.append('a', 'a');
      axios.post('/antrian/display/poliklinik', form_data, { headers: { 'Content-Type': 'multipart/form-data' } })
			.then(function (response) {
				if (response.data.hasil.length > 0) {

					// POLI
					for (let i = 0; i < response.data.hasil.length; i++) {
						let temp = response.data.hasil[i];
						if (temp.pemanggil == '1') {
							let number = vm.calculate("P",temp.number);
							vm.poliklinik[1].nomor = number;
							vm.display = number;
						}
						else if (temp.pemanggil == '2') {
							let number = vm.calculate("P",temp.number);
							vm.poliklinik[2].nomor = number;
							vm.displayright = number;
						}
						else if (temp.pemanggil == '3') {
							let number = vm.calculate("P",temp.number);
							vm.poliklinik[3].nomor = number;
							vm.displayright = number;
						}
					}			
				}
				
				// RO
				if (response.data.ro.length > 0) {
					for (let i = 0; i < response.data.ro.length; i++) {
						let temp = response.data.ro[i];
						let number = vm.calculate("R",temp.number);
						vm.poliklinik[0].nomor = number;
						vm.display = number;
					}
				}
      }).catch(function (error) { /* setTimeout(function() {}, 2500, this); */ });
    },
    firtsload:function() {
      const vm = this;
      let currentDateTime = new Date();
      currentDateTime = currentDateTime.toString();
      currentDateTime = currentDateTime.split(" ");

      let tmp = currentDateTime[4];
      tmp = tmp.split(":");
			if (vm.titik == ":") { vm.titik = '.'; }
			else { vm.titik = ":"; }
      vm.jam = tmp[0] + vm.titik + tmp[1];

      let hari = currentDateTime[0],
        bln = currentDateTime[1],
        tgl = currentDateTime[2],
        thn = currentDateTime[3];

      if (hari == 'Sat') { hari = 'Sabtu'; }
      else if (hari == 'Sun') { hari = 'Minggu'; }
      else if (hari == 'Mon') { hari = 'Senin'; }
      else if (hari == 'Tue') { hari = 'Selasa'; }
      else if (hari == 'Thu') { hari = 'Kamis'; }
      else if (hari == 'Fri') { hari = 'Jumat'; }

      vm.day = hari;

      if (bln == 'Jan') { bln = 'Januari'; }
      else if (bln == 'Feb') { bln = 'Februari'; }
      else if (bln == 'Mar') { bln = 'Maret'; }
      else if (bln == 'Apr') { bln = 'April'; }
      else if (bln == 'May') { bln = 'Mei'; }
      else if (bln == 'Jun') { bln = 'Juni'; }
      else if (bln == 'Jul') { bln = 'Juli'; }
      else if (bln == 'Aug') { bln = 'Agustus'; }
      else if (bln == 'Sep') { bln = 'September'; }
      else if (bln == 'Oct') { bln = 'Oktober'; }
      else if (bln == 'Nov') { bln = 'November'; }
      else if (bln == 'Dec') { bln = 'Desember'; }

      vm.tanggal = tgl + " " + bln + " " + thn;

			// if (vm.ngulang == 5) { vm.showSlides(); vm.ngulang = 0; }
			// vm.ngulang += 1;
    },
  }
});
</script>
</body>
</html>