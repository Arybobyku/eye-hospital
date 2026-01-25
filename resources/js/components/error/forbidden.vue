<template>
<div class="inner" ref="roottable">
	<div class="forbidden">
		<div class="lock"></div>
		<div class="message">
  		<h1>Access to this page is restricted</h1>
  		<p>Please check with the site admin if you believe this is a mistake.</p>
		</div>
		<button v-on:click="backToHome()">Back to Home</button>
	</div>
	<Loader ref="Loader"></Loader>
</div>
</template>

<script>
var vm;

import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';

export default { 
	emits: ["titletrigger", "repatch"],
	beforeUnmount:function() {},
	components: { toast },
	mounted: function () {
		vm = this;
		setTimeout(() => { this.titletrigger(); }, 250);
	},
	methods: { 
		backToHome:function() { this.$router.push('/dashboard/profile'); } ,
		loadPatch: function () { vm.firstloader(); },
		firstloader: function () { const left = this.$refs.roottable.getBoundingClientRect(); vm.$refs.Loader.running(left); },
		notification: function (message, timer, position) { 
			if (position == 'error') { toast.error(message, { rtl: false, autoClose:timer }); } 
			else { toast.success(message, { rtl: false, autoClose: timer }); } 
		},
		unloadPatch: function (position) { vm.firstloader(); if (position == 'success') { vm.notification('Data berhasil dipatch.', 3000, position); } else if (position == 'error') { vm.notification('Data gagal dipatch.', 3000, position); } },
		titletrigger: function () { let title = vm.$router.currentRoute._value.meta.title; vm.$emit('titletrigger', title); }
	}
}
</script>