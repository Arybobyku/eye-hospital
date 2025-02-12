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
                        <button class="bpjs" v-on:click="onChangeState('ambil-umum')">Customer Service</button>
                        <button class="umum" v-on:click="">Obat Bebas</button>
                        <button class="check-in" v-on:click="onChangeState('mbjkn')">Check In</button>
                    </div>
                </div>
                {{-- Ambil Antrian BPJS --}}
                <div class="ambil-antrian-inner" ref="rootmodal" v-if="shouldShow('peserta-lama')"
                    style="margin-left: 10px">
                    <div class="button">
                        <button class="bpjs" v-on:click="onChangeState('bpjs')">BPJS</button>
                        <button class="umum" v-on:click="onChangeState('ambil-umum')">Non BPJS</button>
                        <button class="check-in" v-on:click="onChangeState('mbjkn')">Check In</button>
                    </div>

                    <h3 class="back" v-on:click="onChangeState('first')">Kembali</h3>
                </div>
                {{-- Ambil Antrian MBJKN --}}
                <div class="ambil-antrian-inner" v-if="shouldShow('mbjkn')">
                    <h2>CHECK IN</h2>
                    <p>* Masukkan Kode Booking.</p>

                    <!-- Input Kode Booking -->
                    <div class="input-container" style="padding: 0px 100px">
                        <input type="text" v-model="kodeBooking" class="kode-input" placeholder="KODE BOOKING" />
                        <button class="keyboard-btn">
                            Keyboard
                        </button>
                    </div>

                    <!-- Numpad -->
                    <div class="numpad" style="padding: 0px 100px">
                        <button v-for="num in numbers" :key="num" class="numpad-btn"
                            @click="appendToBooking(num)">
                            {% num %}
                        </button>
                        <button class="delete-btn" @click="deleteLast">Del</button>
                        <button class="numpad-btn" @click="appendToBooking(0)">0</button>
                        <button class="ok-btn" @click="confirmBooking">OK</button>
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
                        <button class="umum" v-on:click="add('Umum')">UMUM</button>
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
                {{-- BPJS --}}
                <div class="ambil-antrian-inner" v-if="shouldShow('bpjs')">
                    <center>

                        <h2>PESERTA BPJS</h2>

                        <!-- Radio Buttons -->
                        <div class="radio-group" style="margin-left: 100px">
                            <label>
                                <input type="radio" v-model="pesertaType" value="nik" /> NIK
                            </label>
                            <label>
                                <input type="radio" v-model="pesertaType" value="bpjs" /> NO KARTU BPJS
                            </label>
                        </div>

                        <!-- Input Field with Icons -->
                        <div class="input-container">
                            <input type="text" v-model="kodeBooking" class="kode-input" placeholder="NIK" />
                            <button class="keyboard-btn">
                                Keyboard
                            </button>
                            <button class="search-btn">
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
                        <!-- Dropdown for Doctor Selection -->
                        <label for="selectedDoctor" style="margin-top:10px">-- PILIH DOKTER --</label>
                        <select id="selectedDoctor" v-model="selectedDoctor" class="custom-select">
                            <option disabled value="">Pilih Dokter</option>
                            <option v-for="doctor in doctors" :key="doctor.nik" :value="doctor.kodedokter">
                                {% doctor . nik %} - {% doctor . namadokter %}
                            </option>
                        </select>

                        <!-- Validation Messages -->
                        <div class="validation">
                            <p>* NIK harus 16 digit. <br>* NO PESERTA harus 13 digit.</p>
                        </div>

                        <h3 class="back" v-on:click="onChangeState('peserta-lama')">Kembali</h3>
                    </center>
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
                            addbebas: '/apotek/bebas/antrian',
                            listDokter: '/bpjs/antrol-bpjs/ref/dokter',
                        },
                        url: '',
                        data: null
                    },
                    state: "first",
                    number: 0,
                    numberbebas: 0,
                    position: 'firstload',
                    // STATE DATA TERBARU
                    kodeBooking: '',
                    numbers: [1, 2, 3, 4, 5, 6, 7, 8, 9], // Pastikan array ini ada
                    selectedDoctor: "",
                    doctors: [],
                    pesertaType: "nik",
                }
            },
            methods: {
                onChangeState: function(state) {
                    this.state = state;

                    if (this.state == 'bpjs') {
                        this.getListDokter();
                    }
                },
                shouldShow: function(state) {
                    return state == this.state;
                },
                appendToBooking: function(num) {
                    console.log("Menambahkan angka:", num); // Debugging
                    this.kodeBooking += num;
                },
                deleteLast: function() {
                    console.log("Menghapus angka terakhir");
                    this.kodeBooking = this.kodeBooking.slice(0, -1);
                },
                confirmBooking: function() {
                    alert(`Kode Booking: ${this.kodeBooking}`);
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

                addbebas: function(posisi) {
                    vm.attach.url = vm.attach.link.addbebas;
                    vm.attach.data = new FormData();
                    vm.attach.data.append('jenis', posisi);
                    vm.attach.data.append('number', vm.numberbebas);
                    vm.position = 'adddatabebas';
                    vm.loaders();
                    vm.executions();
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
                                    vm.loaders();
                                } else if (vm.position == 'adddata') {
                                    vm.printout();
                                    vm.loads();
                                } else if (vm.position == 'adddatabebas') {
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
