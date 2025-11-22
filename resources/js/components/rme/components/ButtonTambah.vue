<template>
    <div class="text-right mb-3">
      <button 
        class="btn btn-danger btn-lg custom-padding"
        @click="$emit('click')"
      >
        <i class="fa fa-plus"></i> Tambah
      </button>
    </div>
    <br>
  </template>
  
  <script>
  export default {
    name: "ButtonTambah"
  }
  </script>
  
  <style scoped>
  .custom-padding {
    padding: 7px 14px !important;   /* Tinggi & lebar tombol */
  }
  </style>
  