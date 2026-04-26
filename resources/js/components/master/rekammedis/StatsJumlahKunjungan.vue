<template>
  <div class="container">
    <div>
      Rawat Jalan: <strong>{{ data.rawat_jalan }}</strong>
    </div>
    <div>
      Rawat Inap: <strong>{{ data.rawat_inap }}</strong>
    </div>
    <div>
      One Day Care: <strong>{{ data.odc }}</strong>
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
        rawat_jalan: null,
        rawat_inap: null,
        odc: null,
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

      axios.post('/master/rekammedis/statsjumlahkunjungan', data)
        .then((res) => {
          this.data.rawat_jalan = res.data.rawat_jalan;
          this.data.rawat_inap = res.data.rawat_inap;
          this.data.odc = res.data.odc;
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