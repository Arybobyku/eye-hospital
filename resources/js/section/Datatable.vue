<template>
	<div class="table-responsive">
		<table class="table">
			<thead>
				<tr class="table-header">
					<th v-for="(item, index) in header" :rowspan="rowspan(item)" :style="item.button ? 'text-align: center' : 'text-align: left'">
						{{ item.label }}
						<button v-if="!item.search && item.button" class="tooltip btn-success" style="padding-top: 5px;" v-on:click="tablebutton('add', '', '')">
							<vue-feather type="plus-circle"></vue-feather>
						</button>
					</th>
				</tr>
				<tr class="table-header">
					<template v-for="(item, index) in header">
						<th v-if="item.search && !item.button">
							<input :id="'table_'+item.value" 
								autocomplete="off"
								v-if="item.search" :type="item.type" 
								class="input-search" placeholder="Cari disini" 
								v-on:keyup="searching($event, item, index)" :ref="item.value" 
								v-on:change="change($event, item, index)" />
							<span v-if="item.search && item.close && item.type != 'date'" 
							v-on:click="clear(item, index)" class="closed">&times;</span>
						</th>
					</template>
				</tr>
			</thead>
			<tbody v-if="isskeleton">
				<tr v-for="i in pagination.row">
					<td v-for="i in header.length">
						<div class="skeleton skeleton-table"></div>
					</td>
				</tr>
			</tbody>
			<tbody v-if="body.length > 0 && !isskeleton">
				<tr v-for="(row, index) in body">
					<td v-for="(col, indexin) in row" :style="col.style">
						<span v-if="col.ishtml == 'button'" style="position: relative;">
							<button class="tooltip btn-menutable" style="padding-top: 4px;" v-on:click="getbutton($event, index, indexin)">
								<vue-feather type="cpu"></vue-feather>
							</button>
							<ul class="hidden-menu" v-if="col.show">
								<template v-for="btn in col.value">
									<li v-if="btn.show">
										<a href="javascript:void(0)" v-on:click="tablebutton(btn.posisi, btn.item, index)">
											<vue-feather type="chevrons-right"></vue-feather> {{ btn.tooltip }}
										</a>
									</li>
								</template>
							</ul>
						</span>

						<span v-else-if="col.ishtml == 'html'" v-html="col.value"></span>

						<div v-else>{{ col.value }}</div>
					</td>
				</tr>
			</tbody>
			<tbody v-else-if="body.length <= 0 && !isskeleton">
				<tr>
					<td :colspan="header.length">Sorry, No Data Available</td>
				</tr>
			</tbody>
		</table>
	</div>
	<div style="display: flex; gap: 2rem; align-items: center; margin: 1rem 0rem;">
		<strong style="margin-left: auto; font-size: 1.25rem; padding: 0;">Total: {{ pagination.total }}</strong>
		<div class="pagination" style="margin-bottom: 0;" v-if="body.length > 0 && pagination.ispaging">
			<a href="javascript:void(0)" v-on:click="prev()">&laquo;</a>
			<a href="javascript:void(0)" v-for="item in pagination.data" v-on:click="page(item)" :class="item == pagination.page ? 'active' : ''">{{ item }}</a>
			<a href="javascript:void(0)" v-on:click="next()">&raquo;</a>
		</div>
	</div>
</template>

<script>
var vm;
export default {
	emits: ["tablereload", "tablebutton", 'ready'],
	props: { module: { type: Object } },
	mounted:function() { 
		vm = this; 
		vm.header = vm.module.column;
		vm.body = vm.module.data;
		vm.pagination.total = vm.module.total;
		vm.pagination.ispaging = vm.module.ispaging;
		vm.paging();
		window.addEventListener("click", function(event) { 
			let a = event.target.className; 
			try { 
				if (event.target.className == '') { vm.hidemenuothers(0); }
			} 
			catch { console.log('mistmatch'); } });

		this.$nextTick(() => this.$emit('ready'));
	},
	data:() => {
		return {
			body: [],
			header: [],
			search: { text: '', column: '' },
			pagination: { ispaging: false, data: [], page: 1, temp_page: 0, max: 10, total: 0, row: 15, count_page: 0, begin: 1 },
			isskeleton: false,
			searchTimeout: null
		}
	},
	methods: {

		getbutton:function(event, index, indexin) {
			let temp = vm.body[index][indexin].show;
			vm.hidemenuothers(indexin);
			vm.body[index][indexin].show = !temp;
		},

		hidemenuothers:function(indexin) {
			if (vm.body.length > 0) {
				
				if (indexin == 0) {
					
					for (let index = 0; index < vm.body.length; index++) {
						let tmp = vm.body[index].length - 1;
						vm.body[index][tmp].show = false;
					}
				}
				else {
					for (let index = 0; index < vm.body.length; index++) {
						vm.body[index][indexin].show = false;
					}
				}
			}
		},

		rowspan:function(item) {
			if (!item.search && (item.button || !item.button)) { return '2'; }
			else { return ''; }
		},
		nullnol:function(data) { if (data) { if (data != '0') { return data; }  } return '-'; },

		/*************************************************************************************************************************
		* Bagian Data Table
		* Maximal pagination yang ditampilkan adalah 10 item pagination
		* Jumlah baris data yang ditampikan sebanyak 10 baris
		*************************************************************************************************************************/

		tablebutton:function(posisi, data, index) {
			this.$emit('tablebutton', posisi, data, index);
		},

		reset:function(skip = false) {
			vm.search.text = ''; 
			vm.search.column = '';
			vm.pagination.count_page = 0;
			vm.pagination.begin = 1;
			vm.pagination.page = 1;
			vm.pagination.temp_page = 1;
			if (!skip) { vm.skeleton(); } 
			vm.tablereload();
		},

		tablereload:function() { this.$emit('tablereload', vm.berkas()); },

		berkas:function() {
			let data = new FormData();
			data.append('search', vm.search.text);
			data.append('column', vm.search.column);
			data.append('page', vm.pagination.page);
			return data;
		},

		update:function(column, body, total) {
			if (column != ''){ vm.header = column; }
			vm.body = body;
			vm.pagination.total = total;
		},

		backpage:function() {
			vm.pagination.page = vm.pagination.temp_page; 
		},

		skeleton:function() { vm.isskeleton = vm.isskeleton ? false : true; },

		// searching:function(event, item, index) { //remark by yudha
		// 	let value = event.target.value;
		// 	for (let i = 0; i < vm.header.length; i++) {
		// 		if (vm.header[i].value != '#' && vm.header[i].value != item.value) {
		// 			if (vm.header[i].search) {
		// 				vm.$refs[vm.header[i].value][0].value = '';
		// 				vm.header[i].close = false;
		// 			}
		// 		}
		// 	}
		// 	if (value != '') { vm.header[index].close = true; }
		// 	else { vm.header[index].close = false; }

		// 	if (event.key == 'Enter') { 
		// 		vm.search.text = value; vm.search.column = item.value; vm.pagination.count_page = 0;
		// 		vm.pagination.begin = 1; vm.pagination.page = 1; vm.pagination.temp_page = 1;
		// 		vm.skeleton(); vm.tablereload(); 
		// 	}
		// 	if (value == '') { 
		// 		vm.search.text = ''; vm.search.column = '';  vm.pagination.count_page = 0;
		// 		vm.pagination.begin = 1; vm.pagination.page = 1; vm.pagination.temp_page = 1;
		// 		vm.skeleton(); vm.tablereload();
		// 	}
		// },
		
		searching(event, item, index) {
			const value = event.target.value.trim();

			if (value === this.search.text) return;
			
			if (value.length > 0 && value.length < 2) return;

			// Reset kolom lain
			// for (let i = 0; i < this.header.length; i++) {
			// 	if (this.header[i].value !== '#' && this.header[i].value !== item.value) {
			// 		if (this.header[i].search) {
			// 			const ref = this.$refs[this.header[i].value];
			// 			if (ref && ref[0]) ref[0].value = '';
			// 			this.header[i].close = false;
			// 		}
			// 	}
			// }

			// Update close button visibility
			this.header[index].close = value !== '';

			// Debounce search
			clearTimeout(this.searchTimeout);
			this.searchTimeout = setTimeout(() => {
				this.search.text = value;
				this.search.column = value ? item.value : '';
				this.pagination.count_page = 0;
				this.pagination.begin = 1;
				this.pagination.page = 1;
				this.pagination.temp_page = 1;
				this.skeleton();
				this.tablereload();
			}, 400);
		},
		/* Fungsi untuk membersihkan field input pencarian yang ada diheader */
		clear:function(item, index) {
			vm.header[index].close = false; 
			vm.$refs[item.value][0].value = '';
			vm.search.text = ''; 
			vm.search.column = '';
			vm.pagination.count_page = 0;
			vm.pagination.begin = 1;
			vm.pagination.page = 1;
			vm.pagination.temp_page = 1;
			vm.skeleton();
			vm.tablereload();
		},

		/* Fungsi untuk membersihkan field input bertipe date pencarian yang ada diheader */
		change:function(event, item, index) {

			if (item.type == 'date') {
				let value = event.target.value;

				for (let i = 0; i < vm.header.length; i++) {
					if (vm.header[i].value != '#' && vm.header[i].value != item.value) {
						if (vm.header[i].search) {
							vm.$refs[vm.header[i].value][0].value = '';
							vm.header[i].close = false;
						}
					}
				}

				// Clear Date
				if (value == '') { vm.header[index].close = false; vm.search.text = ''; vm.search.column = '';  }
				else { vm.search.text = value; vm.search.column = item.value;  }
				
				vm.pagination.count_page = 0;
				vm.pagination.begin = 1; vm.pagination.page = 1; vm.pagination.temp_page = 1;
				vm.skeleton(); vm.tablereload();
			}
		},
		
		/* Fungsi untuk mengatur urutan page angka yang akan ditampilkan */
		paging:function() {
			vm.pagination.data = [];
			vm.pagination.count_page = vm.pagination.total / vm.pagination.row;
			let sisa_page = vm.pagination.total % vm.pagination.row;
			if (sisa_page > 0) { vm.pagination.count_page += 1; }
			if (vm.pagination.count_page < 1) { vm.pagination.count_page = 1; }
			for (let i = vm.pagination.begin; i <= vm.pagination.max && i <= vm.pagination.count_page; i++) {
				vm.pagination.data.push(i);
			}
		},

		next:function() {
			let hitung = vm.pagination.page + 1;
			if (vm.pagination.count_page >= hitung) {
				vm.pagination.page += 1;
				if (vm.pagination.page * 1 > vm.pagination.max) { 
					vm.pagination.max += 10;
					vm.pagination.begin += 10;
				}
				vm.pagination.temp_page = vm.pagination.page;
				vm.skeleton();
				vm.tablereload();
			}
		},
		prev:function() {
			let hitung = vm.pagination.page - 1;
			if (0 < hitung) {
				vm.pagination.page -= 1;
				if (vm.pagination.page * 1 <= vm.pagination.max - 10) { 
					vm.pagination.max -= 10; 
					vm.pagination.begin -= 10; 
				}
				vm.pagination.temp_page = vm.pagination.page;
				vm.skeleton();
				vm.tablereload();
			}
		},
		
		/* Fungsi untuk mengambil nilai page dan memprosesnya */
		page:function(item) { 
			if (item != vm.pagination.page) {
				vm.pagination.page = item; vm.pagination.temp_page = vm.pagination.page;
				vm.skeleton(); 
				vm.tablereload();
			}
		},
	},
}
</script>
<style>.vue-feather { overflow:unset; }
.hidden-menu {
	width: 260px;
  padding: 10px 15px;
	text-align: left;
  height: auto;
  position: absolute;
  right: 50px;
  top: -40px;
  list-style: none;
  z-index: 98;
  background: #2b80b6;
  box-shadow: 0 2px 4px #1c608b;
	border-radius: 10px;
}

.hidden-menu:after {
	content: "";
  width: 0; 
	position: absolute;
  height: 0; 
	top: 21px;
	left: 260px;
  border-top: 5px solid transparent;
  border-bottom: 5px solid transparent;
	border-left: 5px solid #2b80b6;
}

.hidden-menu li {
	padding: 5px 0;
}

.hidden-menu li a {
	color: #FFFFFF;
}

.hidden-menu li a:hover {
	color: #fbe894;
}

.hidden-menu li a i {
	width: 16px;
  position: relative;
  top: 2px;
}
</style>