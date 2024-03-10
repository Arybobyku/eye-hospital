<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Status Kamar</title>
    <link rel="stylesheet" href="{{ asset('css/antrian.css') }}" type="text/css" />
		<style>
			.item1 { grid-area: vvip; }
			.item2 { grid-area: vip; }
			.item3 { grid-area: kelas1; }
			.item4 { grid-area: kelas2; }
			.item5 { grid-area: kelas3; }
			.item6 { grid-area: kelas4; 
				border-radius: 25px; }

			.grid-container {
				display: grid;
				grid-template-areas:
					'vvip vvip vip vip kelas1 kelas1'
					'kelas2 kelas2 kelas3 kelas3 kelas4 kelas4';
				gap: 10px;
				padding: 10px;
				height: 95%;
				border-radius: 25px;
			}

			.grid-container > div {
				background-color: rgba(255, 255, 255, 0.8);
				text-align: center;
				font-size: 30px;
				border-radius: 25px;
			}
			.headers {
				width: 100%; height: 30%; background: #c42727; border-radius: 25px 25px 0 0; float: left; text-align: center
			}
			.nomor {
				width: 100%; 
				height: 70%; 
				background-image: linear-gradient(to right, #2c3f94 , #3d5bde); 
				box-shadow: 0 0 3px #353535; 
				float: left;
				border-radius: 0 0 24px 24px;
				position: relative;
			}
			.titleheader {
				font-size: 30px; font-weight: bold; color: #fff; position: relative; top: 16px
			}
			.numbers {
				text-align: center;
				position: absolute;
				width: auto;
				top: 50%;
				left: 50%;
				transform: translate(-50%, -50%);
				color: #fff;
			}
			.angkas {
				font-size: 30px;
				font-weight: bold
			}
			.labels {
				font-size: 28px;
				font-weight: bold
			}
		</style>
</head>

<body>
<div class="wrapper" id="app">
  <div class="header">
    <img src="{{ asset('images/logo_antrian.png') }}" height="60" />
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
    
		<div class="grid-container">
			<div class="item1">
				<div class="headers">
					<span class="titleheader">Kamar HCU</span>
				</div>
				<div class="nomor">
					<div class="numbers">
						<span class="angkas" style="position: relative; left: -100px">1</span><br />
						<span class="labels" style="position: relative; left: -100px">Jumlah</span>
					</div>
					<div class="numbers">
						<span class="angkas">0</span><br />
						<span class="labels">Dipakai</span>
					</div>
					<div class="numbers">
						<span class="angkas" style="position: relative; right: -100px">1</span><br />
						<span class="labels" style="position: relative; right: -100px">Sisa</span>
					</div>
				</div>
			</div>
			<div class="item2">
				<div class="headers">
					<span class="titleheader">Kamar VIP</span>
				</div>
				<div class="nomor">
					<div class="numbers">
						<span class="angkas" style="position: relative; left: -100px">1</span><br />
						<span class="labels" style="position: relative; left: -100px">Jumlah</span>
					</div>
					<div class="numbers">
						<span class="angkas">0</span><br />
						<span class="labels">Dipakai</span>
					</div>
					<div class="numbers">
						<span class="angkas" style="position: relative; right: -100px">1</span><br />
						<span class="labels" style="position: relative; right: -100px">Sisa</span>
					</div>
				</div>
			</div>
			<div class="item3">
				<div class="headers">
					<span class="titleheader">Kamar Kelas I</span>
				</div>
				<div class="nomor">
					<div class="numbers">
						<span class="angkas" style="position: relative; left: -100px">1</span><br />
						<span class="labels" style="position: relative; left: -100px">Jumlah</span>
					</div>
					<div class="numbers">
						<span class="angkas">0</span><br />
						<span class="labels">Dipakai</span>
					</div>
					<div class="numbers">
						<span class="angkas" style="position: relative; right: -100px">1</span><br />
						<span class="labels" style="position: relative; right: -100px">Sisa</span>
					</div>
				</div>
			</div>  
			<div class="item4">
				<div class="headers">
					<span class="titleheader">Kamar Kelas II</span>
				</div>
				<div class="nomor">
					<div class="numbers">
						<span class="angkas" style="position: relative; left: -100px">2</span><br />
						<span class="labels" style="position: relative; left: -100px">Jumlah</span>
					</div>
					<div class="numbers">
						<span class="angkas">0</span><br />
						<span class="labels">Dipakai</span>
					</div>
					<div class="numbers">
						<span class="angkas" style="position: relative; right: -100px">2</span><br />
						<span class="labels" style="position: relative; right: -100px">Sisa</span>
					</div>
				</div>
			</div>
			<div class="item5">
				<div class="headers">
					<span class="titleheader">Kamar Kelas III</span>
				</div>
				<div class="nomor">
					<div class="numbers">
						<span class="angkas" style="position: relative; left: -100px">11</span><br />
						<span class="labels" style="position: relative; left: -100px">Jumlah</span>
					</div>
					<div class="numbers">
						<span class="angkas">0</span><br />
						<span class="labels">Dipakai</span>
					</div>
					<div class="numbers">
						<span class="angkas" style="position: relative; right: -100px">11</span><br />
						<span class="labels" style="position: relative; right: -100px">Sisa</span>
					</div>
				</div>
			</div>
			{{-- <div class="item6">
				<div class="headers">
					<span class="titleheader">Kamar Kelas IV</span>
				</div>
				<div class="nomor">
					<div class="numbers">
						<span class="angkas" style="position: relative; left: -100px">0</span><br />
						<span class="labels" style="position: relative; left: -100px">Jumlah</span>
					</div>
					<div class="numbers">
						<span class="angkas">0</span><br />
						<span class="labels">Dipakai</span>
					</div>
					<div class="numbers">
						<span class="angkas" style="position: relative; right: -100px">0</span><br />
						<span class="labels" style="position: relative; right: -100px">Sisa</span>
					</div>
				</div>
			</div> --}}
		</div>
    
	</div>
  <div class="footer">
    <marquee direction="left">
      {{ $text->content }}
    </marquee>
  </div>
</div>
<script src="{{ asset('js/axios.min.js') }}"></script>
<script src="{{ asset('js/vue.min.js') }}"></script>

<script>
new Vue({
  el: "#app",
  delimiters: ['{%', '%}'],
  mounted:function() {
    const vm = this;
    vm.firtsload();
    //vm.showSlides();
    vm.get_data();
		setInterval(() => { vm.firtsload(); }, 1000);
  },
  computed:{},
  created:function() { },
  data:function() { return {
		ngulang: 0,
		hitung: 0,
		display: [
			{ jumlah: '0' },
			{ jumlah: '0' },
			{ jumlah: '0' },
			{ jumlah: '0' },
			{ jumlah: '0' },
			{ jumlah: '0' },
		],
		angka: 1,
    currentDateTime: null,
		titik: ':',
    jam: '',
    tanggal: '',
    day: '',
		timetime: null,
  }},
  methods: {
		
			
    get_data:function() {
      const vm = this;
      let form_data = new FormData();
      form_data.append('a', 'a');
      axios.post('/rooms/load', form_data, { headers: { 'Content-Type': 'multipart/form-data' } })
			.then(function (response) {
				for (let i = 0; i < response.data.data.length; i++) {
					if (response.data.data[i].nama_jenis_kamar == 'Kamar VVIP') { 
						if (response.data.data[i].jumlah > 0) {
							vm.display[0].jumlah = response.data.data[i].jumlah;
						}
						else {
							vm.display[0].jumlah = 'Full';
						}
					}
					else if (response.data.data[i].nama_jenis_kamar == 'Kamar VIP') { 
						if (response.data.data[i].jumlah > 0) {
							vm.display[1].jumlah = response.data.data[i].jumlah;
						}
						else {
							vm.display[1].jumlah = 'Full';
						}
					}
					else if (response.data.data[i].nama_jenis_kamar == 'Kamar Kelas I') { 
						if (response.data.data[i].jumlah > 0) {
							vm.display[2].jumlah = response.data.data[i].jumlah;
						}
						else {
							vm.display[2].jumlah = 'Full';
						}
					}
					else if (response.data.data[i].nama_jenis_kamar == 'Kamar Kelas II') { 
						if (response.data.data[i].jumlah > 0) {
							vm.display[3].jumlah = response.data.data[i].jumlah;
						}
						else {
							vm.display[3].jumlah = 'Full';
						}
					}
					else if (response.data.data[i].nama_jenis_kamar == 'Kamar Kelas III') { 
						if (response.data.data[i].jumlah > 0) {
							vm.display[4].jumlah = response.data.data[i].jumlah;
						}
						else {
							vm.display[4].jumlah = 'Full';
						}
					}
					else if (response.data.data[i].nama_jenis_kamar == 'Kamar Bedah') { 
						if (response.data.data[i].jumlah > 0) {
							vm.display[5].jumlah = response.data.data[i].jumlah;
						}
						else {
							vm.display[5].jumlah = 'Full';
						}
					}
				}
				console.log(response)
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

			if (vm.ngulang == 15) { vm.get_data(); vm.ngulang = 0; }
			vm.ngulang += 1;
    },
  }
});
</script>
</body>
</html>