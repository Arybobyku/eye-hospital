<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Antrian Customer Service</title>
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
                    </span>
                </div>
                <div class="bottom">
                    <div class="sides">
                        <h2 v-html="customer[0].label"></h2>
                        <h1><span v-html="customer[0].nomor"></span></h1>
                    </div>
                    <div class="sides">
                        <h2 v-html="customer[1].label"></h2>
                        <h1><span v-html="customer[1].nomor"></span></h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="right">
            <div class="slideshow-container">
                <div class="mySlides" v-for="(item, index) in dataslide">
                    {{-- <img src="{{ url('/storage/sliderfile/81b85988-2452-4e8a-8607-5c5652e8e7ce_files.jpg') }}" /> --}}
										<img :src="'/'+item.content" />
                    {{-- <div class="text">Lelah memakai kacamata atau lensa kontak? Bedah laser LASIK mungkin bisa menjadi pilihan Anda. Apa risiko, komplikasi, dan hasil akhir yang diperoleh dari bedah ini? Panduan biaya bedah LASIK kami, mencakup biaya LASIK dan perawatan selanjutnya.</div> --}}
                </div>
								{{-- <div class="mySlides">
									<img src="{{ asset('images/IMG_2.jpg') }}" />
							</div> --}}
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
window.Echo = new Echo({
	broadcaster: 'pusher',
	key: 'ABCDEFG',
	cluster: 'mt1',
	wsHost: window.location.hostname,
	wsPort: 6001,
	forceTLS: false,
	disableStats: true,
});
new Vue({
  el: "#app",
  delimiters: ['{%', '%}'],
  mounted:function() {
    const vm = this;
    vm.firtsload();
    vm.showSlides();
    vm.get_data();
    vm.get_slider();
		setInterval(() => { vm.firtsload(); }, 1000);
		Echo.channel('trades').listen('NewTrade', (e) => { vm.triggercall(e.trade); });
  },
  computed:{},
  created:function() { },
  data:function() { return {
		ngulang: 0,
		hitung: 0,
		dataslide: [],
		display: 'CS-000',
		customer: [
			{ nomor: 'CS-000', label: 'Customer Service 1' },
			{ nomor: 'CS-000', label: 'Customer Service 2' },
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
      console.log("CHECK DATA", data);
			const vm = this, myArray = data.split("=");
			let cs = myArray[0].split(" ");
      console.log("CS", data);
			let number = vm.calculate(parseInt(myArray[1]));
			if (cs[2] == '1') {
				vm.customer[0].nomor = number;
				vm.display = number;
			}
			else {
				vm.customer[1].nomor = number;
				vm.display = number;
			}
			vm.bunyi(number, cs[2]);		
		},	
		bunyi:function(nomor, posisi) {
			const vm = this;
			vm.hitung += 1;
			var x = document.getElementById("myAudio"); 
			x.play();

			if (vm.timetime) { window.clearTimeout(vm.timetime); }
				
			vm.timetime = window.setTimeout(function() {
				let  tmp = nomor.split("");
        console.log("TEMP",tmp)
							
				let msg = 'Nomor antrian, '+ tmp[0] + tmp[1] +', ';
				let angka = tmp[3]+''+tmp[4]+''+tmp[5];
				if (parseInt(angka) > 0 && parseInt(angka) < 10) { msg = msg + '0, 0, ' + parseInt(angka) + ', '; }
				else if (parseInt(angka) > 9 && parseInt(angka) < 100) { msg = msg + '0, ' + parseInt(angka) + ', '; }
				else if (parseInt(angka) > 99 && parseInt(angka) < 1000) { msg = msg + ' ' + parseInt(angka) + ', '; }
				msg = msg + 'ke Kastemer Service, '+ posisi ?? "";

				const parameters = {
					pitch: 1, rate: 0.97, volume: 1,
					onstart: vm.voiceStartCallback(),
					onEnd: vm.voiceEndCallback()
				}
				responsiveVoice.speak(msg, "Indonesian Female", parameters);

				window.clearTimeout(vm.timetime);
			}, 2000, this);
							
		},
		voiceStartCallback: function (){},
		voiceEndCallback: function (){},
    showSlides() {
			if (this.dataslide.length > 0) {
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
			}
      
    },
		calculate:function(data) {
			let msg = 'CS-';
			if (parseInt(data) > 0 && parseInt(data) < 10) { msg += '00' + data; }
			else if (parseInt(data) > 9 && parseInt(data) < 100) { msg += '0' + data; }
			else if (parseInt(data) > 99 && parseInt(data) < 1000) { msg += data; }
			return msg;
		},
    get_data:function() {
      const vm = this;
      let form_data = new FormData();
      form_data.append('a', 'a');
      axios.post('/antrian/display/cs', form_data, { headers: { 'Content-Type': 'multipart/form-data' } })
			.then(function (response) {
				if (response.data.hasil.length > 0) {
					for (let i = 0; i < response.data.hasil.length; i++) {
						let temp = response.data.hasil[i];
									
						if (temp.pemanggil == 'Customer Service 1') {
							let number = vm.calculate(temp.number);
							vm.customer[0].nomor = number;
							vm.display = number;
						}
						else if (temp.pemanggil == 'Customer Service 2') {
							let number = vm.calculate(temp.number);
							vm.customer[1].nomor = number;
							vm.display = number;
						}
					}				
				}
      }).catch(function (error) { /* setTimeout(function() {}, 2500, this); */ })
    },
		get_slider:function() {
      const vm = this;
      let form_data = new FormData();
      form_data.append('a', 'a');
      axios.post('/antrian/slider', form_data, { headers: { 'Content-Type': 'multipart/form-data' } })
			.then(function (response) {
				if (response.data.slider.length > 0) {
					vm.dataslide = response.data.slider;
				}
				else {
					vm.dataslide = [];
				}
				console.log(response.data.slider)
      }).catch(function (error) { /* setTimeout(function() {}, 2500, this); */ })
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
			if (vm.ngulang == 8) {
				vm.showSlides();
				vm.ngulang = 0;
			}

			vm.ngulang += 1;
    },
  }
});
</script>


</body>
</html>