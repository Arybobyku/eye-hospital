<template>
  <div class="container">
    <div>
      Kunjungan Baru: <strong>{{ data.baru }}</strong>
    </div>
    <div>
      Kunjungan Lama: <strong>{{ data.lama }}</strong>
    </div>
    <div>
      Total Kunjungan: <strong>{{ data.total }}</strong>
    </div>
  </div>
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
      data: {
        lama: null,
        baru: null,
      },
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

      axios.post('/master/rekammedis/statsjumlahpengunjung', data)
        .then((res) => {
          this.data.lama = res.data.total_kunjungan - res.data.kunjungan_baru;
          this.data.baru = res.data.kunjungan_baru;
          this.data.total = res.data.total_kunjungan;
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
</style>