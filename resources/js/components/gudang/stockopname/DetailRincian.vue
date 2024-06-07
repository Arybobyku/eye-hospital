<template>
	<div :style="terminate.display" class="modal">
		<div ref="rootmodal" class="modal-content modal-semi-besar" :class="terminate.show ? 'modal-opened' : 'modal-closed'">
			<div class="modal-header">
				<span class="close" v-on:click="hide()">&times;</span>
				<h2>{{ title }}</h2>
			</div>
			<div class="modal-body" style="min-height: 10rem;">
				<template v-if="table">
					<div class="table-responsive">
						<table class="table">
							<thead>
								<tr class="table-header">
									<th>Domain</th>
									<th>Keluar/Masuk</th>
									<th>Jumlah Kecil</th>
									<th>Jumlah Besar</th>
									<th>Waktu</th>
								</tr>
							</thead>
							<tbody>
								<tr v-for="row in table.data" :key="row.created_at">
									<td>{{ row.domain }}</td>
									<td style="text-transform: uppercase; font-weight: bold;">{{ row.jenis }}</td>
									<td>{{ (+row.jumlah_kecil).toFixed(2) }}</td>
									<td>{{ (+row.jumlah_besar).toFixed(2) }}</td>
									<td>{{ row.tanggal }} {{ row.waktu }}</td>
								</tr>
							</tbody>
						</table>
					</div>
					<Pagination 
						:total="table.total" :per-page="table.per_page" :disabled="loading"
						:current-page="table.current_page" @change-page="readData" 
					/>
				</template>
			</div>
			<Loader ref="Loader"></Loader>
		</div>
	</div>
</template>

<script>
import { defineAsyncComponent } from 'vue';
var vm, body;
export default {
	emits: ["dialog", "parsingForm"],
	components: {
		Inputed: defineAsyncComponent(() => import('../../../section/Inputed.vue')),
		Pagination: defineAsyncComponent(() => import('../../../section/Pagination.vue')),
	},
	mounted:function() { 
		vm = this; body = document.body;
	},
	created:function() {},
	data:function() { return { 
		terminate: { show: false, display: 'display: none' },
		title: '', stock: null, table: {
			data: [],
			per_page: 1,
			current_page: 1,
			total: 0,
		},
		loading: false,
	}},
	methods: {
		// keyinput: function(event) { console.log(event.target.value); },
		readData(page){
			this.loading = true;
			axios.post('/gudang/stockopname/rincian', { 
				obat_uuid: this.stock.obat_uuid,
				page: page ?? 1, 
			}).then((res) => {
				this.table = res.data;
			}).finally(() => {
				this.loading = false;
			});
		},

		action:function() {
			let next = true;
			for (const key in vm.form) {
				if (key != 'select') { if (vm.form[key].required != '') { if (vm.form[key].value == '') { next = false; } } }
			}
			
			if (next) { vm.parsingForm(); vm.dialog(); }
		},

		show:function(posisi, title, uuid, data){
			vm.title = title;
			vm.stock = data;
			body.style.overflowY = 'hidden'; vm.terminate.display = 'display: block'; vm.terminate.show = true;

			this.data = null;
			this.readData();
    },
		hide:function() { vm.terminate.show = false; setTimeout(function() { vm.terminate.display = 'display: none'; body.style.overflowY = 'auto'; }, 250, this); },

		loaderprocess:function() { const left = this.$refs.rootmodal.getBoundingClientRect(); vm.$refs.Loader.running(left, 'modal', 250); },
	}
}
</script>