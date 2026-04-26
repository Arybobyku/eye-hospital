<template>
  <div class="flex items-center gap-2" style="display: flex; align-items: center; gap: 1rem">
    <select v-model="grouping_">
      <option value="daily">Per Hari</option>
      <option value="weekly">Per Minggu</option>
      <option value="monthly">Per Bulan</option>
      <option value="yearly">Per Tahun</option>
    </select>
    <div style="flex-grow: 1;">
      <VueDatePicker 
        v-model="value_"
        :week-picker="grouping_ === 'weekly'" 
        :year-picker="grouping_ === 'yearly'" 
        :month-picker="grouping_ === 'monthly'" 
      />
    </div>
  </div>
</template>

<script>
import { startOfDay, startOfWeek, startOfMonth, startOfYear, endOfDay, endOfWeek, endOfMonth, endOfYear } from 'date-fns';

export default {
  props: {
    modelValue: {
      type: Array,
      default: () => [],
    }
  },
  emits: ['update:modelValue'],
  data(){
    return {
      grouping_: 'daily',
      value_: new Date(),
    }
  },
  watch: {
    value_: {
      handler(){
        // Konversi model input datepicker menjadi array dengan panjang 2
        switch (this.grouping_) {
          case 'daily':
            this.$emit('update:modelValue', [startOfDay(this.value_), endOfDay(this.value_)]);
            break;
          case 'weekly':
            this.$emit('update:modelValue', [startOfWeek(this.value_[0]), endOfWeek(this.value_[1])]);
            break;
          case 'monthly':
            this.$emit('update:modelValue', [startOfMonth(new Date(this.value_.year, this.value_.month)), endOfMonth(new Date(this.value_.year, this.value_.month))]);
            break;
        
          default:
            this.$emit('update:modelValue', [startOfYear(new Date(this.value_, 0)), endOfYear(new Date(this.value_, 11))]);
            break;
        }
      },
      deep: true,
    },
    grouping_: {
      handler(){
        // Memastikan model data date picker selalu konsisten per jenis pengelompokkan
        switch (this.grouping_) {
          case 'daily':
            this.value_ = this.modelValue[0];
            break;
          case 'weekly':
            this.value_ = [startOfWeek(this.modelValue[0]), endOfWeek(this.modelValue[1])];
            break;
          case 'monthly':
            this.value_ = {
              month: this.modelValue[0].getMonth(),
              year: this.modelValue[0].getFullYear(),
            };
            break;
        
          default:
            this.value_ = this.modelValue[0].getFullYear();
            break;
        }
      },
    },
  }
}
</script>