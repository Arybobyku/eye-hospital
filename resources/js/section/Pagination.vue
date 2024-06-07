<script>
export default {
  props: {
    total: {
      type: Number,
      default: 0,
    },
    perPage: {
      type: Number,
      default: 1,
    },
    currentPage: {
      type: Number,
      default: 1,
    },
    disabled: {
      type: Boolean,
      default: false,
    }
  },
  emits: ['changePage'],
  computed: {
    lastPage(){
      return Math.ceil(this.total / this.perPage);
    }
  }
}
</script>

<template>
  <div class="pagination-container" v-if="lastPage > 1">
    <a href="javascript:void(0)" v-if="lastPage > 0" @click="!disabled && $emit('changePage', 1)">
      1
    </a>
    <a href="javascript:void(0)" v-if="lastPage > 1" @click="!disabled && $emit('changePage', currentPage - 1)">
      <vue-feather type="chevron-left" size="14" /> 
    </a>
    <input type="number" :value="currentPage" min="1" :max="lastPage" :disabled="disabled" />
    <a href="javascript:void(0)" v-if="lastPage > 2" @click="!disabled && $emit('changePage', currentPage + 1)">
      <vue-feather type="chevron-right" size="14" /> 
    </a>
    <a href="javascript:void(0)" v-if="lastPage > 3" @click="!disabled && $emit('changePage', lastPage)">
      {{ lastPage }}
    </a>
  </div>
</template>

<style lang="css" scoped>
.pagination-container{
  display: flex;
  align-items: stretch;
}

.pagination-container a {
  color: black;
  padding: 8px 16px;
  text-decoration: none;
}

.pagination-container a.active {
  background-color: #4CAF50;
  border: 1px solid #207323;
  color: white;
	border-radius: 4px;
}

.pagination-container a:hover:not(.active) { 
	background-color: #ddd;
	border: 1px solid #c0c0c0;
	border-radius: 4px;
}

input {
  padding: 4px 8px;
  width: 4rem;
  font-size: 1.2rem;
  text-align: center;
}

/* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
input[type=number] {
  -moz-appearance: textfield;
}
</style>