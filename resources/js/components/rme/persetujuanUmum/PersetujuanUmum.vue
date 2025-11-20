<template>
  <div class="history">
    <h2>Persetujuan Umum</h2>

    <div class="item" v-for="item in dataHistory" :key="item.id">
      <div>
        <strong>{{ item.date }}</strong>
        <div>{{ item.description }}</div>
      </div>

      <span class="status" :class="item.status.toLowerCase()">
        {{ item.status }}
      </span>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      dataHistory: [
        { id: 1, date: "2025-01-10", description: "Pemeriksaan Umum", status: "Selesai" },
        { id: 2, date: "2025-01-18", description: "Kontrol Luka", status: "Selesai" },
        { id: 3, date: "2025-02-05", description: "Laboratorium", status: "Proses" },
      ],
    };
  },
};
</script>

<style scoped>
.item {
  display: flex;
  justify-content: space-between;
  padding: 12px;
  border: 1px solid #ddd;
  background: #fff;
  border-radius: 6px;
  margin-top: 10px;
}

.status {
  padding: 4px 10px;
  border-radius: 5px;
  font-size: 12px;
}

.status.selesai {
  background: #e6ffe6;
  color: #2f8c2f;
}

.status.proses {
  background: #fff6dd;
  color: #c98e00;
}
</style>
