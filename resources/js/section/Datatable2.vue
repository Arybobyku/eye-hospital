<template>
    <div>
      <!-- Button untuk menambah data secara otomatis -->
       <div class="col-12">
      <button class="add-button" @click="addLoket('pendaftaran')">Tambah Pendaftaran</button>
      <br>
      <button class="add-button" @click="addLoket('farmasi')">Tambah Farmasi</button>
      </div>

  
      <!-- Tabel Data Loket -->
      <table class="table">
        <thead>
          <tr>
            <th>No</th>
            <th>Nama Loket</th>
            <th>Tipe Loket</th>
            <th>Status</th>
            <th>#</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(loket, index) in lokets" :key="index">
            <td>{{ index + 1 }}</td>
            <td>{{ loket.nama }}</td>
            <td>{{ loket.tipe }}</td>
            <td>
              <!-- iOS Switch Button untuk status -->
              <label class="ios-switch">
                <input type="checkbox" v-model="loket.status" />
                <span class="ios-slider"></span>
              </label>
              <span>{{ loket.status ? ' Aktif' : ' Tidak Aktif' }}</span>
            </td>
            <td>
              <button @click="editLoket(loket)" class="edit-button">Edit</button>
              <button @click="deleteLoket(index)" class="delete-button">Delete</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </template>
  
  <script>
  export default {
    name: "datatable2",
    data() {
      return {
        lokets: [
        ],
        nextLoketNumber: 1, // Nomor berikutnya untuk nama loket
      };
    },
    methods: {
      // Fungsi untuk menambah data secara otomatis
      addLoket(tipe) {
        const newLoket = {
          nama: `Loket ${this.nextLoketNumber}`,
          tipe: tipe.charAt(0).toUpperCase() + tipe.slice(1), // Kapitalisasi tipe
          status: true // Status default aktif
        };
        this.lokets.push(newLoket);
        this.nextLoketNumber++; // Meningkatkan nomor loket berikutnya
      },
      
      editLoket(loket) {
        alert(`Mengedit ${loket.nama}`);
      },
      
      deleteLoket(index) {
        this.lokets.splice(index, 1);
        alert('Loket dihapus!');
      }
    }
  };
  </script>
  
  <style scoped>
  /* Gaya untuk tombol save */
  .save-button {
    width: 100px;
    height: 50px;
    background-color: #28a745;
    color: white;
    border: none;
    border-radius: 25px;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
    transition: background-color 0.3s ease;
  }
  
  .save-button:hover {
    background-color: #218838;
  }
  
  /* Gaya untuk tabel */
  .table {
    width: 100%;
    border-collapse: collapse;
  }
  
  .table th, .table td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
  }
  
  .table th {
    background-color: #f2f2f2;
    font-weight: bold;
  }
  
  .edit-button {
    background-color: #4CAF50; /* Hijau */
    color: white;
    border: none;
    padding: 5px 10px;
    cursor: pointer;
    margin-right: 5px;
    border-radius: 10px;
  }
  
  .delete-button {
    background-color: #f44336; /* Merah */
    color: white;
    border: none;
    padding: 5px 10px;
    cursor: pointer;
    border-radius: 10px;
  }
  
  .edit-button:hover {
    background-color: #45a049;
  }
  
  .delete-button:hover {
    background-color: #d32f2f;
  }
  
  /* Gaya untuk tombol tambah data */
  .add-button {
    margin-bottom: 10px;
    padding: 10px 20px;
    background-color: #007BFF;
    color: white;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
  }
  
  .add-button:hover {
    background-color: #0056b3;
  }
  
  /* Gaya untuk iOS switch */
  .ios-switch {
    position: relative;
    display: inline-block;
    width: 50px;
    height: 28px;
  }
  
  .ios-switch input {
    opacity: 0;
    width: 0;
    height: 0;
  }
  
  .ios-slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    transition: 0.4s;
    border-radius: 28px;
  }
  
  .ios-slider:before {
    position: absolute;
    content: "";
    height: 22px;
    width: 22px;
    left: 4px;
    bottom: 3px;
    background-color: white;
    transition: 0.4s;
    border-radius: 50%;
  }
  
  /* Warna switch saat aktif */
  input:checked + .ios-slider {
    background-color: #4cd964;
  }
  
  input:checked + .ios-slider:before {
    transform: translateX(22px);
  }
  </style>
  