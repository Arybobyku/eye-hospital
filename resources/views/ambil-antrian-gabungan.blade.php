<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ambil Antrian</title>
    <link rel="stylesheet" href="{{ asset('css/antriangabungan.css') }}" type="text/css" />
    <link rel="stylesheet" href="https://printjs-4de6.kxcdn.com/print.min.css" type="text/css" />
                          
    <style>
        .container {
          max-width: 500px;
          margin: 20px auto;
          padding: 25px;
          font-family: Arial, sans-serif;
        }
        h1 {
          text-align: center;
          color: #2c3e50;
          margin-bottom: 25px;
          font-size: 22px;
        }
        
        .form-group {
          margin-bottom: 20px;
        }
        
        label {
          display: block;
          margin-bottom: 8px;
          font-weight: bold;
          color: #34495e;
        }
        
        select, input {
          width: 100%;
          padding: 12px;
          border: 1px solid #ddd;
          border-radius: 5px;
          font-size: 16px;
          background-color: white;
        }
        
        select:focus, input:focus {
          outline: none;
          border-color: #3498db;
          box-shadow: 0 0 5px rgba(52, 152, 219, 0.5);
        }
        
        .error-message {
          color: #e74c3c;
          font-size: 14px;
          margin-top: 5px;
          display: none;
        }
        
        input:invalid:not(:placeholder-shown) + .error-message {
          display: block;
        }
        
        .submit-btn {
          width: 100%;
          padding: 14px;
          background-color: #3498db;
          color: white;
          border: none;
          border-radius: 5px;
          font-size: 16px;
          font-weight: bold;
          cursor: pointer;
          transition: background-color 0.3s;
        }
        
        .submit-btn:hover {
          background-color: #2980b9;
        }
        </style>
</head>

<body>

    <div id="app">
        <div>

        </div>
        <div class="ambil-antrian-wrap">


            <div class="ambil-antrian-middle">
                <p align="center" style="margin-top: -10px; margin-bottom: 30px">
                    <img src="{{ asset('images/aset.png') }}" height="170" alt="" />
                </p>



                {{-- First Information --}}
                <div class="ambil-antrian-inner" ref="rootmodal" v-if="shouldShow('first')" style="margin-left: 10px">
                    <div class="button">
                        <button class="baru" v-on:click="onChangeState('ambil-umum')">Pasien Baru</button>
                        <button class="lama" v-on:click="onChangeState('peserta-lama')">Pasien Lama</button>
                        <button class="obatbebas" v-on:click="onChangeState('ambil-obat')">Obat Bebas</button>
                        {{-- <button class="check-in" v-on:click="onChangeState('mbjkn')">Check In</button> --}}
                    </div>
                </div>
                {{-- Ambil Antrian BPJS --}}
                <div class="ambil-antrian-inner" ref="rootmodal" v-if="shouldShow('peserta-lama')"
                    style="margin-left: 10px">
                    <div class="button">
                        <button class="bpjs" v-on:click="onChangeState('bpjs')">BPJS</button>
                        <button class="nonbpjs" v-on:click="onChangeState('non-bpjs')">Non BPJS</button>
                        <button class="obatbebas" v-on:click="onChangeState('mbjkn')">Check In</button>
                    </div>

                    <h3 class="back" v-on:click="onChangeState('first')">Kembali</h3>
                </div>

                {{-- Daftar Non BPJS --}}
                <div class="ambil-antrian-inner" ref="rootmodal" v-if="shouldShow('non-bpjs')"
                    style="margin-left: 10px">

                    <div class="container">
                        <div class="form-group">
                            <label for="nik">NIK</label>
                            <input type="text" id="nik" name="nik" v-model="nik"  placeholder="Masukkan NIK" required>
                            <div class="error-message">* NIK harus 16 digit.</div>
                                                    <!-- Numeric Keypad -->
                        <div class="numpad">
                            <button v-for="num in numbers" :key="num" class="numpad-btn"
                                @click="appendToNik(num)">
                                {% num %}
                            </button>
                            <button class="delete-btn" @click="deleteLastNik">del</button>
                            <button class="numpad-btn" @click="appendToNik(0)">0</button>
                            <button class="ok-btn" @click="confirmNik">OK</button>
                        </div>
                          </div>
                            
                          <div class="form-group">
                            <label for="kode_poli_bpjs">PILIH POLI</label>
                            <select id="kode_poli_bpjs" @change="fetchJadwalDokter"  name="kode_poli_bpjs" v-model="selectedPoli" required>
                                <option value="" disabled selected>-- Pilih Poli --</option>
                                <option v-for="item in poliBpjs" :value="item.kdpoli" v-text="`${item.nmpoli} - ${item.nmsubspesialis || ''}`"></option>
                            </select>
                          </div>
                        
                        <div class="form-group">
                          <label for="kode_dokter_bpjs">PILIH DOKTER</label>
                          <select id="kode_dokter_bpjs" name="kode_dokter_bpjs" v-model="selectedDokter" required>
                            <option value="" disabled selected>-- Pilih Dokter --</option>
                            <option v-for="item in jadwalDokter" :value="item.kodedokter" v-text="`${item.namadokter}`"></option>
                        </select>
                        </div>
                        <button  v-on:click="addlamanonbpjs(selectedPoli, selectedDokter)" class="submit-btn">Ambil Nomor Antrian</button>
                      </div>
                      <script>
                      </script>
                    <h3 class="back" v-on:click="onChangeState('first')">Kembali</h3>
                </div>
                {{-- Ambil Antrian MBJKN --}}
                <div class="ambil-antrian-inner" ref="rootmodal"  v-if="shouldShow('mbjkn')">
                    <h2>CHECK IN</h2>
                    <p>* Masukkan Kode Booking.</p>

                    <!-- Input Kode Booking -->
                    <div class="input-container" style="padding: 0px 100px">
                        <input type="text" v-model="kodeBooking" class="kode-input" placeholder="KODE BOOKING" />
                        {{-- <button class="keyboard-btn">
                            Keyboard
                        </button> --}}
                    </div>

                    <!-- Numpad -->
                    <div class="numpad" style="padding: 0px 100px">
                        <button v-for="num in numbers" :key="num" class="numpad-btn"
                            @click="appendToBooking(num)">
                            {% num %}
                        </button>
                        <button class="delete-btn" @click="deleteLast">Del</button>
                        <button class="numpad-btn" @click="appendToBooking(0)">0</button>
                        <button class="ok-btn" v-on:click="addcheckin()">OK</button>
                    </div>

                    <!-- Tombol Peserta -->
                    <h3 class="back" v-on:click="onChangeState('first')">Kembali</h3>
                </div>
                {{-- Ambil Antrian Umum --}}
                <div class="ambil-antrian-inner" ref="rootmodal" v-if="shouldShow('ambil-umum')"
                    style="margin-right: 0px">
                    <h2>No. Antrian : CS - <span v-html="checknumber()"></span></h2>
                    <p>Antrian Kunjungan Pasien ke Poli Mata</p>
                    <div class="button">
                        <button class="umum" v-on:click="addcheckin()">AMBIL ANTRIAN</button>
                        {{-- <button class="umum" v-on:click="add('UMUM')">UMUM</button> --}}
                        {{-- <button class="asuransi" v-on:click="add('ASURANSI')">ASURANSI</button> --}}
                    </div>


                    <h3 class="back" v-on:click="onChangeState('first')">Kembali</h3>
                    <div :style="loading.display" class="wrap-loading-main">
                        <div class="loading-main">
                            <div class="boxes">
                                <div class="box">
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                </div>
                                <div class="box">
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                </div>
                                <div class="box">
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                </div>
                                <div class="box">
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- PASIEN LAMA BPJS start --}}
                <div class="ambil-antrian-inner" ref="rootmodal"  v-if="shouldShow('bpjs')">
                    <center>
                        
                        <h2>PESERTA BPJS</h2>
                        
                        <!-- Radio Buttons -->
                        <div class="radio-group" style="margin-left: 100px">
                            <label>
                                <input type="radio" v-model="pesertaType" value="nik_sect" /> NIK
                            </label>
                            <label>
                                <input type="radio" v-model="pesertaType" value="bpjs_sect" /> NO KARTU BPJS
                            </label>
                        </div>
                        
                        <div class="input-container">
                            <!-- Input NIK (ditampilkan ketika pesertaType = 'nik') -->
                            <input v-if="pesertaType === 'nik_sect'" 
                                   type="text" 
                                   v-model="nikSect" 
                                   class="kode-input" 
                                   placeholder="Masukkan NIK (16 digit)" 
                                   maxlength="16" />
                            
                            <!-- Input No BPJS (ditampilkan ketika pesertaType = 'bpjs') -->
                            <input v-else
                                   type="text" 
                                   v-model="bpjsSect" 
                                   class="kode-input" 
                                   placeholder="Masukkan No Kartu BPJS (13 digit)" 
                                   maxlength="13" />
  
                            
                            {{-- <button class="keyboard-btn">
                                Keyboard
                            </button> --}}
                            <button class="search-btn" @click="searchPeserta">
                                Cari
                            </button>
                        </div>
                        
                        
                        <!-- Numeric Keypad -->
                        <div class="numpad">
                            <button v-for="num in numbers" :key="num" class="numpad-btn"
                            @click="appendToBooking(num)">
                            {% num %}
                        </button>
                        
                        <button class="delete-btn" @click="deleteLast">del</button>
                        <button class="numpad-btn" @click="appendToBooking(0)">0</button>
                        <button class="ok-btn" @click="confirmBooking">OK</button>
                    </div>
                        <div class="container">
                            <div class="form-group">
                                <label for="no_rujukan">Rujukan</label>
                                <input 
                                id ="no_rujukan"
                                type="text" 
                                readonly
                                v-model="noRujukan" 
                                placeholder="Nomor Rujukan" />
                                <label for="kode_dokter_bpjs2">PILIH DOKTER</label>
                                <select id="kode_dokter_bpjs2" name="kode_dokter_bpjs2" v-model="selectedDokter2" required>
                                    <option value="" disabled selected>-- Pilih Dokter --</option>
                                    <option v-for="item in jadwalDokter2" :value="item.kodedokter" v-text="`${item.namadokter}`"></option>
                                </select>
                            </div>
                            <button  v-on:click="addlamabpjs(selectedDokter)" class="submit-btn">Ambil Nomor Antrian</button>
                        </div>
                        
                        <!-- Validation Messages -->
                        <div class="validation">
                            <p>* NIK harus 16 digit. <br>* NO PESERTA harus 13 digit.</p>
                        </div>
                        
                        <h3 class="back" v-on:click="onChangeState('peserta-lama')">Kembali</h3>
                    </center>
                </div>
                {{-- PASIEN LAMA BPJS end --}}
                {{-- Ambil Antrian Farmasi --}}
                <div class="ambil-antrian-inner" ref="rootmodal" v-if="shouldShow('ambil-obat')">
                    <h2>No. Antrian : F - <span v-html="checknumberbebas()"></span></h2>
                    <p>Antrian Kunjungan Pasien ke Farmasi</p>
                    
                    <!-- Radio Button BPJS & Non BPJS (Sejajar Horizontal) -->
                    <div style="display: flex; justify-content: center; gap: 40px; margin-bottom: 20px;">
                        <div style="display: flex; align-items: center; gap: 10px; font-size: 20px; font-weight: bold;">
                            <input type="radio" v-model="jenisPembayaran" value="1" 
                            style="width: 24px; height: 24px; cursor: pointer;">
                        <label style="cursor: pointer; color: green;">BPJS</label>
                    </div>

                    <div style="display: flex; align-items: center; gap: 10px; font-size: 20px; font-weight: bold;">
                        <input type="radio" v-model="jenisPembayaran" value="0" 
                        style="width: 24px; height: 24px; cursor: pointer;">
                        <label style="cursor: pointer; color: blue;">Non BPJS</label>
                    </div>
                    </div>

                    <!-- Tombol Pilihan Racikan atau Non Racikan -->
                    <div class="button">
                        <button class="umum" v-on:click="addbebas('racikan')">Racikan</button>
                        <button class="umum" v-on:click="addbebas('non racikan')">Non Racikan</button>
                    </div>

                    <h3 class="back" v-on:click="onChangeState('first')">Kembali</h3>
                    <div :style="loading.display" class="wrap-loading-main">
                        <div class="loading-main">
                            <div class="boxes">
                                <div class="box">
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                </div>
                                <div class="box">
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                </div>
                                <div class="box">
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                </div>
                                <div class="box">
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                </div>
                            </div>
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
            mounted: function() {
                vm = this;
                vm.firstloads();
                this.fetchPoli();
            },
            data: () => {
                return {
                    loading: {
                        display: 'display: none',
                        displayright: 'display: none',
                    },
                    attach: {
                        link: {
                            load: '/antrian/tiketing/load',
                            add: '/antrian/tiketing/add',
                            addlamabpjs: '/antrian/tiketing/addlamabpjs',
                            addlamanonbpjs: '/antrian/tiketing/addlamanonbpjs',
                            addcheckin: '/antrian/tiketing/addcheckin',
                            addbebas: '/antrian/tiketing/addbebas',
                            farmasi: '/antrian/tiketing/add',
                            listDokter: '/bpjs/antrol-bpjs/ref/dokter',
                            searchNik: '/antrian/tiketing/searchnik',
                        },
                        url: '',
                        data: null
                    },
                    state: "first",
                    number: 0,
                    numberRo: 0,
                    numberbebas: 0,
                    position: 'firstload',
                    // STATE DATA TERBARU
                    kodeBooking: '',
                    nik: '',
                    numbers: [1, 2, 3, 4, 5, 6, 7, 8, 9], // Pastikan array ini ada
                    selectedDoctor: "",
                    doctors: [],
                    pesertaType: "nik_sect",
                    jenisPembayaran: 1, // Default value
		            poliBpjs: [], // Data poli_bpjs dari API
		            jadwalDokter: [], // Buat Non BPJS Pasien LAma
		            jadwalDokter2: [], // Buat BPJS pasien LAma
                    selectedPoli: "",
                    selectedDokter: "",
                    selectedDokter2: "",
                    nikSect: '', // Untuk NIK
                    bpjsSect: '', // Untuk No Kartu BPJS
                    noRujukan: '', // Untuk No Kartu BPJS

                }
            },
            methods: {
                onChangeState: function(state) {
                    this.state = state;

                    if (this.state == 'bpjs') {
                        // this.getListDokter();
                        this.fetchJadwalDokter2();

                    }
                    this.fetchPoli();
                },
                async fetchPoli() {
                    try {
                    // Pastikan URL API benar
                    const poliUrl = '/api/bpjs/antrol-bpjs/ref/poli'; // Ganti dengan URL yang benar
                    const dokterUrl = '/api/bpjs/antrol-bpjs/ref/dokter'; // Ganti dengan URL yang benar
                    
                    const response = await axios.get(poliUrl);
                    const responseDokter = await axios.get(dokterUrl);
                    
                    // Pastikan struktur response sesuai dengan yang diharapkan
                    console.log('Response Poli:', response.data.response);
                    console.log('Response Dokter:', responseDokter.data);
                    
                    // Simpan data ke variabel sesuai struktur data Anda
                    this.poliBpjs = response.data?.response || [];
                    this.poliBpjs = response.data?.response?.filter(poli => poli.kdpoli === "MAT") || [];
                    this.doctors = responseDokter.data?.response || [];
                    
                    } catch (error) {
                    console.error("Gagal mengambil data:", error.response ? error.response.data : error.message);
                    }
                },
                async fetchJadwalDokter() {
                    const today = "2025-03-03"; // Format: YYYY-MM-DD

                    try {
                        const responseJadwal = await axios.get(`/api/bpjs/antrol-bpjs/jadwaldokter/kodepoli/${this.selectedPoli}/tanggal/${today}`);

                        this.jadwalDokter = responseJadwal.data.response || [];

                    } catch (error) {
                        console.error("Gagal mengambil jadwal dokter:", error.response ? error.response.data : error.message);
                    }
                },
                async fetchJadwalDokter2() {
                   const today = "2025-03-03"; // Format: YYYY-MM-DD

                    try {
                        const responseJadwal = await axios.get(`/api/bpjs/antrol-bpjs/jadwaldokter/kodepoli/MAT/tanggal/${today}`);

                        this.jadwalDokter2 = responseJadwal.data.response || [];

                    } catch (error) {
                        console.error("Gagal mengambil jadwal dokter:", error.response ? error.response.data : error.message);
                    }
                },
                    updateJadwalDokter() {
                    if (!this.jadwalDokter || this.jadwalDokter.length === 0) {
                        console.warn("Jadwal dokter belum tersedia.");
                        this.dokterTerpilih = null;
                        return;
                    }

                    this.dokterTerpilih = this.jadwalDokter.find(jadwal => jadwal.kodedokter === this.selectedDokter) || null;
                    console.log("Dokter Terpilih:", this.dokterTerpilih);
                    },

                shouldShow: function(state) {
                    return state == this.state;
                },
                appendToBooking: function(num) {
                    console.log("Menambahkan angka:", num); // Debugging
                    this.kodeBooking += num;
                },
                appendToNik: function(num) {
                    console.log("Menambahkan angka:", num); // Debugging
                    this.nik += num;
                },
                deleteLast: function() {
                    console.log("Menghapus angka terakhir");
                    this.kodeBooking = this.kodeBooking.slice(0, -1);
                },
                deleteLastNik: function() {
                    console.log("Menghapus angka terakhir");
                    this.nik = this.nik.slice(0, -1);
                },
                confirmBooking: function() {
                    alert(`Kode Booking: ${this.kodeBooking}`);
                },
                confirmNik: function() {
                    alert(`Kode Nik: ${this.nik}`);
                },
                getListDokter: function() {
                    axios.get(vm.attach.link.listDokter)
                        .then(function(response) {
                            setTimeout(function() {
                                console.log(response);
                                vm.doctors = response?.data?.response;

                            }, 250, this);
                        })
                        .catch(function(error) {
                            console.log(error.response);
                            alert('gagal');
                        });
                },
                firstloads: function() {
                    vm.attach.url = vm.attach.link.load;
                    vm.attach.data = new FormData();
                    vm.attach.data.append('kosong', '');
                    vm.position = 'loaddata';
                    setTimeout(() => {
                        vm.loaders();
                        vm.executions();
                    }, 250);
                },
                loads: function() {
                    vm.attach.url = vm.attach.link.load;
                    vm.attach.data = new FormData();
                    vm.attach.data.append('kosong', '');
                    vm.position = 'loaddata';
                    vm.executions();
                },
                test: function() {
                    return false;
                },
                checknumber: function() {
                    let msg = '';
                    if (this.number < 10) {
                        msg = '00' + this.number;
                    } else if (this.number > 9 && this.number < 100) {
                        msg = '0' + this.number;
                    } else if (this.number > 99 && this.number < 1000) {
                        msg = this.number;
                    }
                    return msg;
                },
                checknumberRo: function() {
                    let msg = '';
                    if (this.numberRo < 10) {
                        msg = '00' + this.numberRo;
                    } else if (this.numberRo > 9 && this.numberRo < 100) {
                        msg = '0' + this.numberRo;
                    } else if (this.numberRo > 99 && this.numberRo < 1000) {
                        msg = this.numberRo;
                    }
                    return msg;
                },
                checknumberbebas: function() {
                    let msg = '';
                    if (this.numberbebas < 10) {
                        msg = '00' + this.numberbebas;
                    } else if (this.numberbebas > 9 && this.numberbebas < 100) {
                        msg = '0' + this.numberbebas;
                    } else if (this.numberbebas > 99 && this.numberbebas < 1000) {
                        msg = this.numberbebas;
                    }
                    return msg;
                },
                add: function(posisi) {
                    vm.attach.url = vm.attach.link.add;
                    vm.attach.data = new FormData();
                    vm.attach.data.append('jenis', posisi);
                    vm.attach.data.append('number', vm.number);
                    vm.position = 'adddata';
                    vm.loaders();
                    vm.executions();
                },
                addlamanonbpjs: function(selectedPoli, selectedDokter) {
                    const selectedPoliObj = vm.poliBpjs.find(poli => poli.kdpoli === selectedPoli);
                    const namaPoli = selectedPoliObj ? selectedPoliObj.nmpoli : '';
                    const selectedDokterObj = vm.jadwalDokter.find(dokter => dokter.kodedokter === selectedDokter);
                    const namaDokter = selectedDokterObj ? selectedDokterObj.namadokter : '';
                    const jamDokter = selectedDokterObj ? selectedDokterObj.jadwal : '';
                    const nik = document.getElementById('nik').value;

                    vm.attach.url = vm.attach.link.addlamanonbpjs;
                    vm.attach.data = new FormData();
                    console.log(selectedDokterObj);
                    console.log(namaDokter);
                    vm.attach.data.append('nik', nik);
                    vm.attach.data.append('kode_dokter_bpjs', selectedDokter);
                    vm.attach.data.append('kode_poli_bpjs', selectedPoli);
                    vm.attach.data.append('nama_poli_bpjs', namaPoli); // Tambahkan nama poli
                    vm.attach.data.append('nama_dokter_bpjs', namaDokter); // Tambahkan nama poli
                    vm.attach.data.append('jadwal_dokter_bpjs', jamDokter);
                    vm.attach.data.append('jenis', 'Umum'); 
                    vm.attach.data.append('number', vm.numberRo);
                    vm.position = 'addlamanonbpjs';
                    vm.loaders();
                    vm.executions();
                    this.resetFormLamaNonBpjs();
                    // window.location.reload();
                },
                addlamabpjs: function(selectedDokter) {
                    const selectedPoliObj = vm.poliBpjs.find(poli => poli.kdpoli === selectedPoli);
                    const namaPoli = selectedPoliObj ? selectedPoliObj.nmpoli : '';
                    const selectedDokterObj = vm.jadwalDokter.find(dokter => dokter.kodedokter === selectedDokter);
                    const namaDokter = selectedDokterObj ? selectedDokterObj.namadokter : '';
                    const jamDokter = selectedDokterObj ? selectedDokterObj.jadwal : '';
                    const nik = document.getElementById('nik').value;

                    vm.attach.url = vm.attach.link.addlamanonbpjs;
                    vm.attach.data = new FormData();
                    console.log(selectedDokterObj);
                    console.log(namaDokter);
                    vm.attach.data.append('nik', nik);
                    vm.attach.data.append('kode_dokter_bpjs', selectedDokter);
                    vm.attach.data.append('kode_poli_bpjs', 'MAT');
                    vm.attach.data.append('nama_poli_bpjs', 'MATA'); // Tambahkan nama poli
                    vm.attach.data.append('nama_dokter_bpjs', namaDokter); // Tambahkan nama poli
                    vm.attach.data.append('jadwal_dokter_bpjs', jamDokter);
                    vm.attach.data.append('no_rujukan', vm.noRujukan);
                    vm.attach.data.append('jenis', 'Umum'); 
                    vm.attach.data.append('number', vm.numberRo);
                    vm.position = 'addlamabpjs';
                    vm.loaders();
                    vm.executions();
                    this.resetFormLamaNonBpjs();
                    // window.location.reload();
                },
                addcheckin: function() {
                    console.log("Add")
                    vm.attach.url = vm.attach.link.addcheckin;
                    vm.attach.data = new FormData();
                    vm.attach.data.append('kode_booking', vm.kodeBooking);
                    vm.position = 'addcheckin';
                    vm.loaders();
                    vm.executions();
                    // this.resetFormLamaNonBpjs();
                    // window.location.reload();
                },

                addbebas: function(posisi) {
                    const pembayaran = this.jenisPembayaran;
                    vm.attach.url = vm.attach.link.addbebas;
                    vm.attach.data = new FormData();
                    vm.attach.data.append('jenis', posisi);
                    vm.attach.data.append('is_bpjs', pembayaran);
                    // TODO Check BPJS or NOT
                    // vm.attach.data.append('isbpjs', false);

                    vm.attach.data.append('number', vm.numberbebas);
                    vm.position = 'addbebas';
                    vm.loaders();
                    vm.executions();
                },
                searchPeserta: function() {
                    if (this.pesertaType === 'nik_sect') {
                        if (this.nikSect.length !== 16) {
                            alert('NIK harus 16 digit!');
                            return;
                        }
                        this.bpjsSect = '';
                        vm.attach.url = vm.attach.link.searchNik;
                        vm.attach.data = new FormData();
                        vm.attach.data.append('nik', this.nikSect);
                        vm.attach.data.append('noKa', this.bpjsSect);
                        vm.attach.data.append('section', this.pesertaType);
                        vm.position = 'searchnik';
                        vm.loaders();
                        vm.executions();
                     
                        console.log('Cari peserta dengan NIK:', this.nikSect);

                    } else {
                        if (this.bpjsSect.length !== 13) {
                            alert('No Kartu BPJS harus 13 digit!');
                            return;
                        }
                        vm.attach.url = vm.attach.link.searchNik;
                        vm.attach.data = new FormData();
                        vm.attach.data.append('nik', this.nikSect);
                        vm.attach.data.append('noKa', this.bpjsSect);
                        vm.attach.data.append('section', this.pesertaType);
                        vm.position = 'searchnik';
                        vm.loaders();
                        vm.executions();
                        // Panggil API untuk cari peserta berdasarkan No BPJS
                        console.log('Cari peserta dengan No BPJS:', this.bpjsSect);
                    }
                },
                
                loaders: function() {
                    const left = this.$refs.rootmodal.getBoundingClientRect();
                    //const leftright = this.$refs.rootmodalright.getBoundingClientRect();
                    vm.loading.display = vm.loading.display == 'display: none' ? 'display:block;width:' + (left
                        .width) + 'px;height:' + (left.height) + 'px; left: 0; top: 195px' : 'display: none';
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
                printoutRo() {
                    const vm = this;
                    printJS({
                        printable: '/storage/antrian/numberRo.pdf',
                        type: 'pdf',
                        showModal: false
                    });
                },
                executions: function() {
                    axios.post(vm.attach.url, vm.attach.data, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    })
                    .then(function(response) {
                        setTimeout(function() {
                            console.log(response);
                            if (vm.position == 'loaddata') {
                                vm.number = response.data.number;
                                vm.numberbebas = response.data.numberbebas;
                                vm.numberRo = response.data.numberRo;
                                vm.loaders();
                                
                            } else if (vm.position == 'adddata') {
                                vm.printout();
                                vm.loads();
                                window.location.reload();

                            } else if (vm.position == 'addbebas') {
                                vm.printoutbebas();
                                vm.loads();
                                window.location.reload();

                            } else if (vm.position == 'addlamanonbpjs') {
                                vm.printoutRo();
                                vm.loads();
                                window.location.reload();
                             } else if (vm.position == 'addcheckin') {
                               vm.printoutRo();
                                vm.loads();
                                window.location.reload();

                            } else if (vm.position == 'searchnik') {
                                vm.noRujukan = response.response.data;
                            }
                        }, 250, this);
                    })
                    .catch(function(error) {
                        console.log(error.response);
                        vm.loaders();
                        
                        // Parsing error message dari response
                        if (error.response && error.response.data) {
                            // Jika response memiliki structure {hasil: 'gagal', data: 'message'}
                            if (error.response.data.data) {
                                alert(error.response.data.data);
                            window.location.reload();

                            } 

                            // Jika response langsung string message
                            else if (typeof error.response.data === 'string') {
                                alert(error.response.data);
                            window.location.reload();

                            }
                            // Fallback ke default message
                            else {
                                alert('Terjadi kesalahan. Silahkan coba lagi.');
                                window.location.reload();
                            }
                        } else {
                            alert('Terjadi kesalahan. Silahkan coba lagi.');
                            window.location.reload();
                        }
                        
                    });
                },

                // Tambahkan method resetForm
                    resetFormLamaNonBpjs: function() {
                        document.getElementById('nik').value = '';
                        document.getElementById('kode_poli_bpjs').selectedIndex = 0;
                        document.getElementById('kode_dokter_bpjs').selectedIndex = 0;
                        if (typeof vm !== 'undefined') {
                            vm.nik = '';
                            vm.selectedPoli = '';
                            vm.selectedDokter = '';
                        }
                    },
            },
            computed: {
                filteredDokters() {
                    if (!this.selectedPoli) return this.doctors;
                    // Sesuaikan dengan struktur data dokter Anda
                    return this.doctors.filter(dokter => dokter.kdpoli === this.selectedPoli);
                }
                },
        });
    </script>
</body>

</html>
