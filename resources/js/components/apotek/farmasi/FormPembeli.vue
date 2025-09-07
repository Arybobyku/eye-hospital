<template>
    <div :style="terminate.display" class="modal">
        <div ref="rootmodal" class="modal-content modal-sedang"
            :class="terminate.show ? 'modal-opened' : 'modal-closed'">
            <div class="modal-header">
                <button v-on:click="action()">{{ btnlbl }}</button>
                <span class="close" v-on:click="hide()">&times;</span>
                <h2 v-if="form">{{ form . title }}</h2>
            </div>
            <div class="modal-body" v-if="form">
                <div class="grid">
                    <div class="col-12">
                        <Inputed :ref="form.nama.name" :form="form.nama"></Inputed>
                    </div>
                    <div class="col-12">
                        <Inputed :ref="form.nama.no_antrian" :form="form.no_antrian"></Inputed>
                    </div>
                    <div class="col-12">
                        <Selected v-on:click="
                        selectbox(
                            $event,
                            form.select.jenisracikan
                                .name,
                            form.select.jenisracikan
                                .statics
                        )
                        " :ref="form.select.jenisracikan.name" @selecteditem="selecteditem" @selectclear="selectclear"
                            :selection="form.select.jenisracikan">
                        </Selected>
                    </div>
                </div>
            </div>
            <Loader ref="Loader"></Loader>
        </div>
    </div>
</template>

<script>
    import {
        defineAsyncComponent
    } from 'vue';
    import {
        formpembeli
    } from './FormData.js';
    import {
        parsepembeli
    } from './Attachment.js';
    import {
        initindexdb,
        indexdbprocessing
    } from "../../../module/Indexdb.js";
    import {
        filterselected,
        hideselected,
        itemselected,
        clearselected,
        boxselected,
        conditionselected,
    } from "../../../module/SelectedFilter.js";
    import {
        arrfarmasibebas
    } from "../../../module/DataArray.js";
    var vm, body;
    export default {
        emits: ["dialog", "parsingForm"],
        components: {
            Inputed: defineAsyncComponent(() => import('../../../section/Inputed.vue')),
            Selected: defineAsyncComponent(() =>
                import("../../../section/Selected.vue")
            ),
        },
        mounted: function() {
            vm = this;
            body = document.body;
            vm.form = vm.formpembeli();
            vm.arr = vm.arrfarmasibebas();
            console.log(vm.arr)
            window.addEventListener("click", function(event) {
                let a = event.target.className;
                try {
                    if (a.split(" ")) {
                        a = a.split(" ");
                        if (a[0] != "hospitals") {
                            vm.selecthide();
                        }
                    }
                    if (event.target.className == "") {
                        vm.selecthide();
                    }
                } catch {
                    console.log("mistmatch");
                }
            });
        },
        created: function() {},

        data: function() {
            return {
                terminate: {
                    show: false,
                    display: 'display: none'
                },
                form: null,
                btnlbl: '',
                arr: {

                }
            }
        },
        methods: {

            formpembeli,
            parsepembeli,
            arrfarmasibebas,
            filterselected,
            hideselected,
            initindexdb,

            itemselected,
            clearselected,
            boxselected,
            conditionselected,

            // keyinput: function(event) { console.log(event.target.value); },

            action: function() {
                let next = true;
                for (const key in vm.form) {
                    if (key != 'select') {
                        if (vm.form[key].required != '') {
                            if (vm.form[key].value == '') {
                                next = false;
                            }
                        }
                    }
                }

                if (next) {
                    vm.parsingForm();
                    vm.dialog();
                }
            },
            selectbox: function(event, key, statics) {
                console.log(event)
                console.log(key)
                console.log(statics)
                if (!vm.form.select[key].disabled) {
                    let result = vm.boxselected(event, vm.form, key);
                    if (result._position == 'stop') {
                        return;
                    } else if (result._position == 'nextstop') {
                        vm.form = result._form;
                    } else {
                        vm.selecthide();
                        vm.getIndexDB(key, statics);
                        vm.form.select[key].option = 'display: block';
                    }
                }
            },
            selecthide: function() {
                vm.form = vm.hideselected(vm.form);
            },
            selecteditem: function(item, key) {
                vm.form = vm.conditionselected(vm.form, item, key, "address");
                vm.form = vm.itemselected(vm.form, item, key);

            },

            show: function(posisi, title, uuid) {
                vm.btnlbl = posisi == 'adddata' ? 'Save Data' : 'Update Data';
                vm.form.uuid = uuid;
                vm.form.title = title;
                vm.form.posisi = posisi;
                vm.form.posisi = posisi;
                body.style.overflowY = 'hidden';
                vm.terminate.display = 'display: block';
                vm.terminate.show = true;
            },
            getIndexDB: function(key, statics) {
                vm.form.select[key].data = [];
                vm.form.select[key].filter = [];
                console.log(statics);
                console.log(key);
                if (statics) {
                    vm.form.select[key].data = this.arr[key];
                    vm.form.select[key].filter = this.arr[key];
                }
            },

            aturulang: function() {
                vm.form = vm.formpembeli();
            },
            hide: function() {
                vm.terminate.show = false;
                setTimeout(function() {
                    vm.terminate.display = 'display: none';
                    body.style.overflowY = 'auto';
                }, 250, this);
            },
            parsingForm: function() {
                vm.$emit('parsingForm', vm.parsepembeli(vm.form), 'pembeli');
            },

            loaderprocess: function() {
                const left = this.$refs.rootmodal.getBoundingClientRect();
                vm.$refs.Loader.running(left, 'modal', 250);
            },

            setdataform: function(response) {
                vm.form.uuid = response.data.data.uuid;
                vm.form.nama.value = response.data.data.nama;
                vm.loaderprocess();
            },

            dialog: function() {
                let text = '',
                    button = '';
                if (vm.form.posisi == 'adddata') {
                    text = 'Yakin ingin menambah data pada halaman ini.';
                    button = 'Ya, tambah data';
                } else {
                    text = 'Yakin ingin memperbaharui data ini.';
                    button = 'Ya, perbaharui data';
                }
                vm.$emit('dialog', text, button, 'formpembeli');
            },
        }
    }
</script>
