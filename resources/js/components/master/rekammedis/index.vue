<template>
  <div class="inner" ref="roottable">
    <div class="form-self-group">
	    <div class="tab-lines"><div class="tab"><button v-for="(item, index) in tab.button" :class="item.class" v-on:click="changesTab(item.value, index, item.class)">{{ item.label }}</button></div></div>
	    <div class="tab-content">
        <div class="content-tab-in" v-if="tab.content.riwayat">
          <Data />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
var vm;
import { defineAsyncComponent } from 'vue';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
import Swal from 'sweetalert2';

export default {
	emits: ["titletrigger", "repatch"],
	components: { toast, Swal, 
    Data: defineAsyncComponent(() => import('./Data.vue')),
  },
  created: function () {},
	mounted: function () {
		vm = this;
		setTimeout(() => { this.titletrigger(); }, 250);
	},

  data(){
    return {
      tab: {
        button: [
          { value: 'riwayat', label: 'Data Rekam Medis', class: 'tab-active' },
        ],
        content: { 
          riwayat: true,
        }
      },
    };
  },

  methods: {
    changesTab: function (values, index, classes) {
			if (classes != 'tab-active') {
				for (let i = 0; i < vm.tab.button.length; i++) { 
					vm.tab.content[vm.tab.button[i].value] = false; vm.tab.button[i].class = 'tab-no-active'; 
				}
				vm.tab.button[index].class = 'tab-active';
				vm.tab.content[values] = true;
			}
		},

    /*************************************************************************************************************************
    * Bagian fungsi yang wajib disertakan disetiap index dan tidak perlu diubah-ubah
    *************************************************************************************************************************/
    executions: function () { axios.post(vm.attach.url, vm.attach.data, { headers: { 'Content-Type': 'multipart/form-data' } }).then(function (response) { if (response.data.data == '419') { window.location.href = '/masuk'; } setTimeout(function(){ vm.berhasil(response); }, 750, this); }).catch(function (error){ setTimeout(function(){ vm.gagal(error); }, 750, this); }); },
    dialog: function (_text, _confirm, posisi) { Swal.fire({ title:"Apakah Anda Yakin?", text:_text, icon:"warning", showCancelButton:!0, confirmButtonColor:"#1c84ee", cancelButtonColor:"#fd625e", confirmButtonText: _confirm, cancelButtonText:"Tidak, batal!" }).then(function(e){ if (e.isConfirmed) { vm.runconfirm(posisi); } }); },
    notification: function (message, timer, position) { 
      if (position == 'error') { toast.error(message, { rtl: false, autoClose: timer }); } 
      else if (position == 'warning') { toast.warning(message, { rtl: false, autoClose: timer }); } 
      else { toast.success(message, { rtl: false, autoClose: timer }); }
    },
    loadPatch: function () { vm.firstloader(); },
    firstloader: function () { const left = this.$refs.roottable.getBoundingClientRect(); vm.$refs.Loader.running(left); },
    unloadPatch: function (position) { vm.firstloader(); if (position == 'success') { vm.notification('Data berhasil dipatch.', 3000, position); } else if (position == 'error') { vm.notification('Data gagal dipatch.', 3000, position); } },
    titletrigger: function () { let title = vm.$router.currentRoute._value.meta.title; vm.$emit('titletrigger', title); }
  }
}

</script>