<template>
  <dl class="container">
    <div v-for="row in data" :key="row.kode" class="row">
      <dt><strong>{{ row.kode }}</strong></dt>
      <dd class="description">
        <div>{{ row.nama }}</div>
        <strong>{{ row.jumlah }}</strong>
      </dd>
    </div>
  </dl>
</template>

<script>
import { defineAsyncComponent } from 'vue';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
import Swal from 'sweetalert2';
import { format } from 'date-fns';

export default {
	props: {
    filters: {
      type: Object,
      default: () => ({
        date: [new Date(), new Date()],
      })
    }
  },
  data(){
    return {
      loading: false,
      data: [],
    };
  },
  watch: {
    filters: {
      handler(){
        this.readData();
      },
      immediate: true,
      deep: true,
    }
  },
  methods: {
    readData(data = new FormData()){
      this.loading = true;
      data.append('dateRange[start]', format(this.filters.date[0], 'yyyy-MM-dd'));
      data.append('dateRange[end]', format(this.filters.date[1], 'yyyy-MM-dd'));

      axios.post('/master/rekammedis/statsjumlahpasiendiagnosa', data)
        .then((res) => {
          this.data = res.data;
          this.loading = false;
        });
    },
  }
}

</script>

<style scoped>
.container{
  display: flex; 
  flex-direction: column; 
  gap: 0.5rem;
}

.row {
  display: flex;
  border-bottom: 0.5rem solid gray;
  padding: 1rem;
}

.row:not(:last-child){
  border-bottom: none;
}

.description{
  margin: 0;
  display: flex;
  justify-content: space-between;
  flex-grow: 1;
}
</style>