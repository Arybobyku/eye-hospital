<template>
	<div class="form-self-group" :key="selection.key">
		<div class="hospitals select-box">
			<div class="hospitals selected" :id="selection.key" :style="selection.disabled ? 'cursor: no-drop' : ''">
				<span class="click-title"
					:class="selection.label != 'Silahkan Pilih' ? 'select-title' : ''">
					{{ selection.label }}
				</span>
				<span class="select-close" :class="'select-close-' + selection.class" v-on:click="selectclear(selection.key)"
					 v-if="selection.label != 'Silahkan Pilih'">&times;</span>
			</div>
			<div class="hospitals options-container" :style="selection.option">
				<input :id="'form_'+selection.key" :name="'form_'+selection.key" class="hospitals select-search"
					v-model="selection.search" type="text" placeholder="Ketik min 3 karakter" v-if="selection.issearch" />
				<ul :style="selection.issearch ? '' : 'margin: 16px 0 0 0'">
					<template v-if="!selection.dosearch">
						<li v-if="selection.filter.length > 0" v-for="(item, index) in selection.filter"
						:key="item.value" v-on:click="selecteditem(item, index, selection.key)">{{ item.label }}</li>
						<li v-else>No data for result</li>
					</template>
					<template v-else>
						<li>Mohon Tunggu.....</li>
					</template>
				</ul>
			</div>
		</div>
		<label :for="'form_'+selection.key" :class="selection.isrequired ? 'required' : ''">{{ selection.html }}</label>
	</div>
</template>

<script>
var vm;
export default {
	mounted:function() { vm = this; },
	emits: ["selecteditem", "selectclear"],
	props: {
		selection: { type: Object },
		getbounding: { type: Function }
	},
	data: () => { return { } },
	methods: {

		selectclear:function(key) {
			if (vm.selection.disabled) { return ; }
			this.$emit('selectclear', key);
		},

		selecteditem:function(item, index, posisi) {
			this.$emit('selecteditem', item, posisi);
		},
	}
}
</script>