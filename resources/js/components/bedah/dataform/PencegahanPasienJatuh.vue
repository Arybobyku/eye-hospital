<template>
    <div class="grid" v-if="form && activetab">
        <div class="col-12 form-ml">
            <Inputed :ref="form.tanggal_pelaksanaan.name" :form="form.tanggal_pelaksanaan"></Inputed>
        </div>
        <div class="col-12 form-ml">
            <h4>Resiko Jatuh Rendah</h4>
            <table class="table">
                <tbody>
                    <tr>
                        <td>Benda-benda pribadi dalam jangkauan (telepon genggam, bel pasien, air
                            minum,kacamata, dll)</td>
                        <td><input class="checkbox" type="checkbox" :checked="rjr1" value="rjr1"
                                style="cursor: pointer;"> </td>
                    </tr>
                    <tr>
                        <td>Roda tempat tidur dalam posisi terkunci</td>
                        <td><input class="checkbox" type="checkbox" :checked="rjr2" value="rjr2"
                                style="cursor: pointer;"> </td>
                    </tr>
                    <tr>
                        <td>Posisikan tempat tidur pada posi rendah</td>
                        <td><input class="checkbox" type="checkbox" :checked="rjr3" value="rjr3"
                                style="cursor: pointer;"> </td>
                    </tr>
                    <tr>
                        <td>Pagar pengaman tempat tidur dinaikkan</td>
                        <td><input class="checkbox" type="checkbox" :checked="rjr4" value="rjr4"
                                style="cursor: pointer;"> </td>
                    </tr>
                    <tr>
                        <td>Monitor kebutuhan pasien secara berkala, kunjungi pasien minimal 2 kali dalam 1 shift</td>
                        <td><input class="checkbox" type="checkbox" :checked="rjr5" value="rjr5"
                                style="cursor: pointer;"> </td>
                    </tr>
                    <tr>
                        <td>Berikan edukasi untuk menjegah jatuh kepada pasien dan keluarga. Berikan brosur mencegah
                            jatuh
                            jika ada</td>
                        <td><input class="checkbox" type="checkbox" :checked="rjr6" value="rjr6"
                                style="cursor: pointer;"> </td>
                    </tr>
                    <tr>
                        <td>Biarkan pintu terbuka, gunakan lampu pada malam hari</td>
                        <td><input class="checkbox" type="checkbox" :checked="rjr7" value="rjr7"
                                style="cursor: pointer;"> </td>
                    </tr>
                    <tr>
                        <td>Gunakan alat bantu jalan (walker,handrail)</td>
                        <td><input class="checkbox" type="checkbox" :checked="rjr8" value="rjr8"
                                style="cursor: pointer;"> </td>
                    </tr>
                    <tr>
                        <td>Anjurkan pasien mengggunakan kaus kaki atau sandal/ sepatu yang tidak licin</td>
                        <td><input class="checkbox" type="checkbox" :checked="rjr9" value="rjr9"
                                style="cursor: pointer;"> </td>
                    </tr>
                </tbody>
            </table>
            <br>
            <h4>Resiko Jatuh Tinggi</h4>
            <table class="table">
                <tbody>
                    <tr>
                        <td>Lakukan semua intervensi jatuh standar</td>
                        <td><input class="checkbox" type="checkbox" :checked="rjt1" value="rjt1"
                                style="cursor: pointer;"> </td>
                    </tr>
                    <tr>
                        <td>Pasangkan gelang khusus (warna kuning) sebagai tanda risiko pasien jatuh</td>
                        <td><input class="checkbox" type="checkbox" :checked="rjt2" value="rjt2"
                                style="cursor: pointer;"> </td>
                    </tr>
                    <tr>
                        <td>Berikan tanda risiko pasien jatuh pada pintu kamar pasien atau pada bed pasien</td>
                        <td><input class="checkbox" type="checkbox" :checked="rjt3" value="rjt3"
                                style="cursor: pointer;"> </td>
                    </tr>
                    <tr>
                        <td>Pasien ditempatkan dekat nurse station</td>
                        <td><input class="checkbox" type="checkbox" :checked="rjt4" value="rjt4"
                                style="cursor: pointer;"> </td>
                    </tr>
                    <tr>
                        <td>Kunjungi dan monitor pasien setiap 1 jam</td>
                        <td><input class="checkbox" type="checkbox" :checked="rjt5" value="rjt5"
                                style="cursor: pointer;"> </td>
                    </tr>
                    <tr>
                        <td>Edukasi pasien tentang efek samping obat yang diberikan</td>
                        <td><input class="checkbox" type="checkbox" :checked="rjt6" value="rjt6"
                                style="cursor: pointer;"> </td>
                    </tr>
                    <tr>
                        <td>Dampingi pasien ke kamar mandi dan tidak meninggalkan pasien di kamar mandi</td>
                        <td><input class="checkbox" type="checkbox" :checked="rjt7" value="rjt7"
                                style="cursor: pointer;"> </td>
                    </tr>
                    <tr>
                        <td>Anjurkan menggunakan tempat duduk di kamar mandi saat pasien mandi</td>
                        <td><input class="checkbox" type="checkbox" :checked="rjt8" value="rjt8"
                                style="cursor: pointer;"> </td>
                    </tr>
                    <tr>
                        <td>Informasikan cara menggunakan bel di toilet untuk memanggil perawat, pintu kamar mandi
                            jangan
                            dikunci</td>
                        <td><input class="checkbox" type="checkbox" :checked="rjt9" value="rjt9"
                                style="cursor: pointer;"> </td>
                    </tr>
                    <tr>
                        <td>Komunikasikan risiko pasien jatuh pada saat laporan antara shift</td>
                        <td><input class="checkbox" type="checkbox" :checked="rjt10" value="rjt10"
                                style="cursor: pointer;"> </td>
                    </tr>
                </tbody>
            </table>


        </div>











    </div>

    <div class="grid" style="border-top: 1px solid #d0d0d0; padding-top: 20px;" v-if="form && activetab">
        <div class="col-8"></div>
        <div class="col-4" style="text-align: right">
            <button class="button-modal-page button-modal-blue" v-on:click="cancel()">Print Data</button>
            <button class="button-modal-page button-modal-green" v-on:click="action()">Add or Update</button>
        </div>
    </div>
</template>

<script>
import { defineAsyncComponent } from 'vue';
import { formpencegahanpasienjatuh } from './FormData.js';
import { parsepencegahanpasienjatuh } from './Attachment.js';
var vm;
export default {
    emits: ["dialog", "parsingForm"],
    props: ['activetab'],
    components: {
        Inputed: defineAsyncComponent(() => import('../../../section/Inputed.vue')),
        Inputed2: defineAsyncComponent(() => import('../../../section/Inputed2.vue')),
    },
    mounted: function () {
        vm = this;
        vm.form = vm.formpencegahanpasienjatuh();
    },
    created: function () { },
    data: function () {
        return {
            form: null, keyform: 'pencegahanpasienjatuh',
            rjr1: false,
            rjr2: false,
            rjr3: false,
            rjr4: false,
            rjr5: false,
            rjr6: false,
            rjr7: false,
            rjr8: false,
            rjr9: false,
            rjt1: false,
            rjt2: false,
            rjt3: false,
            rjt4: false,
            rjt5: false,
            rjt6: false,
            rjt7: false,
            rjt8: false,
            rjt9: false,
            rjt10: false,

        }
    },
    methods: {
        parsepencegahanpasienjatuh, formpencegahanpasienjatuh,

        action: function () {
            let next = true;
            for (const key in vm.form) {
                if (key != 'select') { if (vm.form[key].required != '') { if (vm.form[key].value == '') { next = false; } } }
            }

            if (next) { vm.parsingForm(); vm.dialog(); }
        },

        aturulang: function () {
            vm.form = vm.formpencegahanpasienjatuh();
            vm.rjr1 = false;
            vm.rjr2 = false;
            vm.rjr3 = false;
            vm.rjr4 = false;
            vm.rjr5 = false;
            vm.rjr6 = false;
            vm.rjr7 = false;
            vm.rjr8 = false;
            vm.rjr9 = false;
            vm.rjt1 = false;
            vm.rjt2 = false;
            vm.rjt3 = false;
            vm.rjt4 = false;
            vm.rjt5 = false;
            vm.rjt6 = false;
            vm.rjt7 = false;
            vm.rjt8 = false;
            vm.rjt9 = false;
            vm.rjt10 = false;

        },

        setdataform: function (data, row) {
            vm.form.bedah_uuid = row.uuid;
            vm.form.uuid = '';
            if (data) {
                vm.form.uuid = data.uuid;
                vm.form.tanggal_pelaksanaan.value = data.tanggal_pelaksanaan;

                if (data.rjr1 == 'Ya') { vm.rjr1 = true; }
                if (data.rjr2 == 'Ya') { vm.rjr2 = true; }
                if (data.rjr3 == 'Ya') { vm.rjr3 = true; }
                if (data.rjr4 == 'Ya') { vm.rjr4 = true; }
                if (data.rjr5 == 'Ya') { vm.rjr5 = true; }
                if (data.rjr6 == 'Ya') { vm.rjr6 = true; }
                if (data.rjr7 == 'Ya') { vm.rjr7 = true; }
                if (data.rjr8 == 'Ya') { vm.rjr8 = true; }
                if (data.rjr9 == 'Ya') { vm.rjr9 = true; }
                if (data.rjt1 == 'Ya') { vm.rjt1 = true; }
                if (data.rjt2 == 'Ya') { vm.rjt2 = true; }
                if (data.rjt3 == 'Ya') { vm.rjt3 = true; }
                if (data.rjt4 == 'Ya') { vm.rjt4 = true; }
                if (data.rjt5 == 'Ya') { vm.rjt5 = true; }
                if (data.rjt6 == 'Ya') { vm.rjt6 = true; }
                if (data.rjt7 == 'Ya') { vm.rjt7 = true; }
                if (data.rjt8 == 'Ya') { vm.rjt8 = true; }
                if (data.rjt9 == 'Ya') { vm.rjt9 = true; }
                if (data.rjt10 == 'Ya') { vm.rjt10 = true; }


            }

            console.log(data);
        },

        dialog: function () {
            let text = '', button = '';
            text = 'Yakin ingin menambah/perbaharui data pada halaman ini.';
            button = 'Ya, tambah data';
            vm.$emit('dialog', text, button, vm.keyform);
        },

        parsingForm: function () {
            var input = document.querySelectorAll('.checkbox');
            for (var i = 0; i < input.length; i++) {
                if (input[i].checked) {

                    if (input[i].value == 'rjr1') { vm.form.rjr1 = 'Ya'; }
                    else if (input[i].value == 'rjr2') { vm.form.rjr2 = 'Ya'; }
                    else if (input[i].value == 'rjr3') { vm.form.rjr3 = 'Ya'; }
                    else if (input[i].value == 'rjr4') { vm.form.rjr4 = 'Ya'; }
                    else if (input[i].value == 'rjr5') { vm.form.rjr5 = 'Ya'; }
                    else if (input[i].value == 'rjr6') { vm.form.rjr6 = 'Ya'; }
                    else if (input[i].value == 'rjr7') { vm.form.rjr7 = 'Ya'; }
                    else if (input[i].value == 'rjr8') { vm.form.rjr8 = 'Ya'; }
                    else if (input[i].value == 'rjr9') { vm.form.rjr9 = 'Ya'; }
                    else if (input[i].value == 'rjt1') { vm.form.rjt1 = 'Ya'; }
                    else if (input[i].value == 'rjt2') { vm.form.rjt2 = 'Ya'; }
                    else if (input[i].value == 'rjt3') { vm.form.rjt3 = 'Ya'; }
                    else if (input[i].value == 'rjt4') { vm.form.rjt4 = 'Ya'; }
                    else if (input[i].value == 'rjt5') { vm.form.rjt5 = 'Ya'; }
                    else if (input[i].value == 'rjt6') { vm.form.rjt6 = 'Ya'; }
                    else if (input[i].value == 'rjt7') { vm.form.rjt7 = 'Ya'; }
                    else if (input[i].value == 'rjt8') { vm.form.rjt8 = 'Ya'; }
                    else if (input[i].value == 'rjt9') { vm.form.rjt9 = 'Ya'; }
                    else if (input[i].value == 'rjt10') { vm.form.rjt10 = 'Ya'; }



                }
                else {

                    if (input[i].value == 'rjr1') { vm.form.rjr1 = 'Tidak'; }
                    else if (input[i].value == 'rjr2') { vm.form.rjr2 = 'Tidak'; }
                    else if (input[i].value == 'rjr3') { vm.form.rjr3 = 'Tidak'; }
                    else if (input[i].value == 'rjr4') { vm.form.rjr4 = 'Tidak'; }
                    else if (input[i].value == 'rjr5') { vm.form.rjr5 = 'Tidak'; }
                    else if (input[i].value == 'rjr6') { vm.form.rjr6 = 'Tidak'; }
                    else if (input[i].value == 'rjr7') { vm.form.rjr7 = 'Tidak'; }
                    else if (input[i].value == 'rjr8') { vm.form.rjr8 = 'Tidak'; }
                    else if (input[i].value == 'rjr9') { vm.form.rjr9 = 'Tidak'; }
                    else if (input[i].value == 'rjt1') { vm.form.rjt1 = 'Tidak'; }
                    else if (input[i].value == 'rjt2') { vm.form.rjt2 = 'Tidak'; }
                    else if (input[i].value == 'rjt3') { vm.form.rjt3 = 'Tidak'; }
                    else if (input[i].value == 'rjt4') { vm.form.rjt4 = 'Tidak'; }
                    else if (input[i].value == 'rjt5') { vm.form.rjt5 = 'Tidak'; }
                    else if (input[i].value == 'rjt6') { vm.form.rjt6 = 'Tidak'; }
                    else if (input[i].value == 'rjt7') { vm.form.rjt7 = 'Tidak'; }
                    else if (input[i].value == 'rjt8') { vm.form.rjt8 = 'Tidak'; }
                    else if (input[i].value == 'rjt9') { vm.form.rjt9 = 'Tidak'; }
                    else if (input[i].value == 'rjt10') { vm.form.rjt10 = 'Tidak'; }


                }
            }
            vm.$emit('parsingForm', vm.parsepencegahanpasienjatuh(vm.form), vm.keyform);
        },
    }
}
</script>