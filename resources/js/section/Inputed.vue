<template>
	<div class="form-self-group">
		<input 
			:id="form.for_id" 
			:type="form.type" 
			placeholder="Ketik disini" 
			v-model="form.value" 
			:disabled="form.disabled ? 'disabled' : false" />
		<label :for="form.for_id" :class="form.required">{{ form.title }}</label>
	</div>
</template>

<script>
var vm;;
export default {
	props: ['form'],
	mounted: () => {
		vm = this;
	},
	data: () => {
		return {
			//form : { title: '', for_id: '', type: '', required: '', key: '', model: '', disabled: '', show: true }
		}
	},
	methods: {
		keyop: function (name, kinds) {
			if (kinds != '') {
				vm.$emit('titletrigger', name); 
				//this.form.value = this.form.value.toLowerCase().trim();
			}
		},
	}
}
</script>