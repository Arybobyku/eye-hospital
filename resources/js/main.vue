<template>
	<div class="header" v-if="!isEmbedMode">
		<div  class="left">
			<div class="nav-control" v-on:click="tabmenu()"><div class="hamburger"><span class="line"></span><span class="line"></span><span class="line"></span></div></div>
			<router-link to="/dashboard/profile"><img src="/images/logopanjang.png" /></router-link>
			<span>
				{{ title }}
				<button class="antrian" v-on:click="antrian()" v-if="showbutton">Antrian</button>
			</span>
			<div ref="rootmenu" class="menu-router-link" :class="menu.isactive ? 'slide-to-right' : ''">
				<ul>
					<li v-for="(value, key) in menu.data" class="menu-item" :class="{ 'menu-item-active': activeMenuKey === key }">
						<div class="menu-category" @click.stop="toggleMenu(key)">
							<span>{{key}}</span>
							<vue-feather type="chevron-right" class="chevron-icon"></vue-feather>
						</div>
						<ul class="submenu" :data-category="key">
							<li v-for="(item, index) in value">
								<router-link :to="item.label_link" v-on:click="closemenu()">
									<vue-feather :type="item.label_icon"></vue-feather> {{ item.label_nama }}
								</router-link>
							</li>
						</ul>
					</li>
				</ul>
				<Loader ref="Loader"></Loader>
			</div>
		</div>
		<div class="side-right">
			<HeaderRight ref="HeaderRight" :username="username" @repatch="repatch" @reloading="reloading"></HeaderRight>
		</div>
	</div>
	<div class="content" :class="isEmbedMode ? 'content-embed' : ''">
				<!-- Breadcrumb -->
		<div class="breadcrumb-bar" v-if="!isEmbedMode">
			<ul class="breadcrumb-list">
				<li>
					<router-link to="/dashboard/profile">
						<vue-feather type="home"></vue-feather>
					</router-link>
				</li>
				<li v-if="breadcrumb.category">
					<vue-feather type="chevron-right" class="bc-separator"></vue-feather>
					<span class="bc-category">{{ breadcrumb.category }}</span>
				</li>
				<li v-if="breadcrumb.page">
					<vue-feather type="chevron-right" class="bc-separator"></vue-feather>
					<span class="bc-active">{{ breadcrumb.page }}</span>
				</li>
			</ul>
		</div>
		<router-view v-slot="{ Component }"><component ref="view" :is="Component" @titletrigger="titletrigger" /></router-view>
	</div>

	<div class="footer" v-if="!isEmbedMode"></div>
</template>

<script>
var vm;
import { defineAsyncComponent } from 'vue';
import { createdb } from './module/Indexdb.js';

export default {
	components: {
		HeaderRight: defineAsyncComponent(() => import('./section/HeaderRight.vue')),

	},
	mounted: function () {
		vm = this;
		let str = vm.username.charAt(0).toUpperCase() + vm.username.slice(1);
		vm.username = str;
		setTimeout(() => {
			vm.title = vm.$router.currentRoute._value.meta.title;
			if (vm.title == 'Customer Service') { vm.showbutton = true; }
			else { vm.showbutton = false; }
		}, 750, this);
		window.addEventListener("click", function(event) {
			let a = event.target.className;

			try {
				if (a.split(" ")) {
					a = a.split(" ");
					console.log(a);
					if (a[0] != 'line' && a[0] != 'nav-control' && a[0] != 'hamburger') {
						vm.navhide();
					}
				}
				if (event.target.className == '') {
					vm.navhide();
				}
			}
			catch { console.log('mistmatch'); } });
	},
	data: function () {
		return {
			attach: { url: '', data: null },
			title: '',
			count: 0,
			showbutton: false,
			username: document.querySelector('meta[name="usernametitle"]').content,
			menu : { data: null, isactive: false, loading: 'display: none' },
			activeMenuKey: null,
			showbutton: false,
			keys: '',
			breadcrumb: { category: '', page: '' },
			isEmbedMode: window.location.search.includes('embed=1'),
		}
	},
	methods: {
		createdb,
		navhide: function () {
			vm.menu.isactive = false;
			vm.activeMenuKey = null;
		},
		repatch: function (url, data, key) {
			vm.keys = key;
			vm.attach.url = url;
			vm.attach.data = data;
			vm.$refs.view.loadPatch();
			vm.count = 1;
			setTimeout(() => { vm.executions('patch'); }, 350, this);
		},

		reloading: function () {
			if (vm.$refs.view.tablereload) {
				vm.$refs.view.tablereload(new FormData, 'outer');
			}

		},

		closemenu:function() {
			vm.menu.isactive = false;
			vm.activeMenuKey = null;
			// vm.menu.data = null;
			setTimeout(() => { vm.setBreadcrumb(); }, 300, this);
		},

		toggleMenu: function(key) {
			vm.activeMenuKey = vm.activeMenuKey === key ? null : key;
		},

		removeIndexDB:function(response) {

			if (vm.keys == 'all') {
				window.localStorage.setItem("version", 1);
				var req = window.indexedDB.deleteDatabase(vm.$dbNameIndexDb);
				req.onsuccess = function () { setTimeout(() => { vm.createdIndexDb(response); }, 350, this); };
				req.onerror = function () {
					if (vm.count < 3) { setTimeout(() => { vm.removeIndexDB(response); }, 350, this); vm.count += 1; }
					else { vm.ispatch = false; vm.$refs.view.unloadPatch('error'); }
				};
				req.onblocked = function () {
					if (vm.count < 3) { setTimeout(() => { vm.removeIndexDB(response); }, 350, this); vm.count += 1; }
					else { vm.ispatch = false; vm.$refs.view.unloadPatch('error'); }
				};
			}
			else {

				vm.setlocalstorage();

				const open = window.indexedDB.open(vm.$dbNameIndexDb, window.localStorage.getItem("version"));
				open.onupgradeneeded = (event) => {
					let db = open.result;
					if( db.objectStoreNames.contains(vm.keys) ){
						db.deleteObjectStore(vm.keys);
					}
				}
				open.onsuccess = function () { open.result.close(); setTimeout(() => { vm.createdIndexDb(response); }, 350, this); };
				open.onerror = function () {
					open.result.close();
					if (vm.count < 3) { setTimeout(() => { vm.removeIndexDB(response); }, 350, this); vm.count += 1; }
					else { vm.ispatch = false; vm.$refs.view.unloadPatch('error'); }
				};
				open.onblocked = function () {
					open.result.close();
					if (vm.count < 3) { setTimeout(() => { vm.removeIndexDB(response); }, 350, this); vm.count += 1; }
					else { vm.ispatch = false; vm.$refs.view.unloadPatch('error'); }
				};
			}

		},

		setlocalstorage: function () {
			if (window.localStorage.getItem("version") === null) { window.localStorage.setItem("version", 1); }
			else { let tmp = window.localStorage.getItem("version"); window.localStorage.setItem("version", (parseInt(tmp)+1)); }
		},

		createdIndexDb: function (data) {

			vm.setlocalstorage();

			vm.createdb(vm.$dbNameIndexDb, window.localStorage.getItem("version"), data)
				.then(function(response){
					if (response == 'berhasil') {
						setTimeout(() => { vm.$refs.HeaderRight.resetispatch(); vm.$refs.view.unloadPatch('success'); }, 250, this);
					}
				})
				.catch(function(error){
					setTimeout(() => { vm.$refs.HeaderRight.resetispatch(); vm.$refs.view.unloadPatch('error'); }, 250, this);
					console.log(error);
				});
		},

		titletrigger: function (_title){ vm.title = _title; vm.setBreadcrumb();},

		tabmenu: function () {
			if (!vm.menu.isactive) {
				vm.menu.isactive = true;
				// vm.menu.data = [];

				// Jika data menu sudah ada, langsung tampilkan tanpa fetch API
				if (vm.menu.data && Object.keys(vm.menu.data).length > 0) {
					return;
				}

				vm.loaderrun();
				setTimeout(() => {
					vm.attach.url = '/allapi/menu';
					vm.attach.data = new FormData();
					vm.attach.data.append('', '');
					vm.executions('menu');
				}, 750, this);
			} else { vm.menu.isactive = false; vm.menu.isactive = null; }
		},

		loaderrun: function () {
			const left = this.$refs.rootmenu.getBoundingClientRect(); let minus = 20;
			vm.$refs.Loader.running(left, 'menu', 250, minus);
		},

		gagal: function (error, posisi) {
			console.log(error.response)
			setTimeout(() => {
				if (posisi == 'patch') {  vm.$refs.view.unloadPatch('error'); }
				else if (posisi == 'menu') { vm.loaderrun(); }
			}, 250, this);
		},

		berhasil: function (response, posisi) {
			console.log(response)
			if (posisi == 'patch') { vm.removeIndexDB(response); }
			else if (posisi == 'menu') {
				vm.loaderrun();
				let temp = response.data.label;
				temp.sort((a,b) => (a.label_based > b.label_based) ? 1 : ((b.label_based > a.label_based) ? -1 : 0));

				vm.menu.data = temp.reduce(function (r, a) {
					r[a.label_based] = r[a.label_based] || [];
					r[a.label_based].push(a);
					return r;
				}, Object.create(null));

				vm.setBreadcrumb();
			}
		},
		setBreadcrumb: function () {
			const currentPath = vm.$router.currentRoute._value.path;
			const currentTitle = vm.$router.currentRoute._value.meta.title || '';

			if (vm.menu.data) {
				for (const [category, items] of Object.entries(vm.menu.data)) {
					const found = items.find(item => item.label_link === currentPath);
					if (found) {
						vm.breadcrumb.category = category;
						vm.breadcrumb.page = found.label_nama;
						return;
					}
				}
			}
			// fallback pakai meta title jika tidak ketemu di menu
			vm.breadcrumb.category = '';
			vm.breadcrumb.page = currentTitle;
		},
		executions: function (position) {
			const vm = this;
			axios.post(vm.attach.url, vm.attach.data, { headers: { 'Content-Type': 'multipart/form-data' } })
			.then(function (response) { if (response.data.data == '419') { window.location.href = '/masuk'; } vm.berhasil(response, position); })
			.catch(function (error){ vm.gagal(error, position); });
		},
	}
};
</script>


