<template>
    <div class="inner" ref="roottable">
        <iframe
            title="bridging"
            width="100%"
            height="100%"
            style="border: 0; height: 100vh"
            :src="vclaimUrl"
        ></iframe>
        <Loader ref="Loader"></Loader>
    </div>
</template>

<script>
var vm;
import { defineAsyncComponent } from "vue";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";
import Swal from "sweetalert2";
export default {
    emits: ["titletrigger", "repatch"],
    created: function () {},
    mounted: function () {
        vm = this;
        setTimeout(() => {
            this.titletrigger();
        }, 250);
    },
    data() {
        return {
            vclaimUrl: import.meta.env.VITE_VCLAIM_PULANG,
        };
    },
    methods:{
		/*************************************************************************************************************************
		* Bagian fungsi yang wajib disertakan disetiap index dan tidak perlu diubah-ubah
		*************************************************************************************************************************/
		executions: function () { axios.post(vm.attach.url, vm.attach.data, { headers: { 'Content-Type': 'multipart/form-data' } }).then(function (response) { if (response.data.data == '419') { window.location.href = '/masuk'; } setTimeout(function(){ vm.berhasil(response); }, 750, this); }).catch(function (error){ setTimeout(function(){ vm.gagal(error); }, 750, this); }); },
		dialog: function (_text, _confirm, posisi) { Swal.fire({ title:"Apakah Anda Yakin?", text:_text, icon:"warning", showCancelButton:!0, confirmButtonColor:"#1c84ee", cancelButtonColor:"#fd625e", confirmButtonText: _confirm, cancelButtonText:"Tidak, batal!" }).then(function(e){ if (e.isConfirmed) { vm.runconfirm(posisi); } }); },
		notification: function (message, timer, position) { if (position == 'error') { toast.error(message, { rtl: false, autoClose: timer }); } else { toast.success(message, { rtl: false, autoClose: timer }); } },
		loadPatch: function () { vm.firstloader(); },
		firstloader: function () { const left = this.$refs.roottable.getBoundingClientRect(); vm.$refs.Loader.running(left); },
		unloadPatch: function (position) { vm.firstloader(); if (position == 'success') { vm.notification('Data berhasil dipatch.', 3000, position); } else if (position == 'error') { vm.notification('Data gagal dipatch.', 3000, position); } },
		titletrigger: function () { let title = vm.$router.currentRoute._value.meta.title; vm.$emit('titletrigger', title); }
    }
};
</script>

<style scoped>
/* Make sure the html, body, and main div take full height */
html,
body {
    height: 100%;
    margin: 0;
    padding: 0;
    overflow: hidden; /* Prevent scrolling */
}

.inner {
    height: 100vh; /* 100% of the viewport height */
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}
</style>
