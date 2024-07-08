<template>
	<div class="form-self-group">
		<timepicker :id="form.for_id" v-model="form.value" :format="'HH:mm'" :type=" form.type"
			:hour-range="[0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22, 23]" :minute-interval="1"
			:disabled="form.disabled ? 'disabled' : false" :manual-input=" true">
		</timepicker>
		<label :for="form.for_id" :class="form.required">{{ form.title }}</label>
	</div>
</template>

<script>
import Timepicker from 'vue3-timepicker';
import 'vue3-timepicker/dist/VueTimepicker.css';
var vm;;
export default {
	components: {
		Timepicker},

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
<style>


.form-self-group .vue__time-picker input {
	width: 75%;
		height: 52px;
		padding: 18px 12px 15px 19px;
		background: #ffffff;
		border: 1px solid #c5c5c5;
		border-radius: 8px;
		outline: none;
		box-sizing: border-box;
		font-size: 15px;
}

.form-self-group .vue__time-picker .dropdown {

}

.form-self-group .vue__time-picker .dropdown ul {
	list-style: none;
	padding: 0;
	margin: 0;
	max-height: 200px;
	overflow-y: auto;
}

.form-self-group .vue__time-picker .dropdown li {
	padding: 10px;
	cursor: pointer;
}

.form-self-group .vue__time-picker .dropdown li:hover {
	background: #f0f0f0;
}

.form-self-group .vue__time-picker .dropdown li.selected {
	background: #e0e0e0;
}

</style>