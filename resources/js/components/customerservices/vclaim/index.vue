<template>
    <div ref="roottable" class="container">
        <div class="card-container">
            <div v-for="(item, index) in vclaim" :key="index" class="card">
                <h3 class="card-title">
                    {{ item.title }}
                </h3>
                <button @click="onClickSEP(item.link)" class="card-button">
                    Klik
                </button>
            </div>
        </div>
        <Loader ref="Loader"></Loader>
    </div>
    <FormEmbedded ref="FormEmbedded"></FormEmbedded>
</template>

<script>
import { defineAsyncComponent } from "vue";
var vm;
var hostVclaim = import.meta.env.VITE_VCLAIM_HOST;
export default {
    beforeUnmount: function () {},
    components: {
        FormEmbedded: defineAsyncComponent(() => import("./FormEmbedded.vue")),
    },
    created: function () {},
    mounted: function () {
        vm = this;
    },
    data() {
        return {
            vclaim: [
                { title: "Pembuatan SEP", link: `${hostVclaim}/` },
                {
                    title: "Persetujuan SEP",
                    link: `${hostVclaim}/sep/persetujuan`,
                },
                {
                    title: "Update Pulang SEP",
                    link: `${hostVclaim}/sep/updatepulang`,
                },
                { title: "Form Rujukan", link: `${hostVclaim}/rujukan` },
                { title: "Kunjungan kontrol/inap", link: `${hostVclaim}/skdp` },
                { title: "Laporan", link: `${hostVclaim}/` },
            ],
        };
    },
    methods: {
        onClickSEP: function (link) {
            vm.$refs.FormEmbedded.setLinkIframe(link);
        },
    },
};
</script>

<style scoped>
/* General container styling */
.container {
    padding: 16px;
    max-width: 1200px;
    margin: 0 auto;
}

/* Card container grid */
.card-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 16px;
}

/* Individual card styling */
.card {
    background: #ffffff;
    border: 1px solid #ddd;
    border-radius: 12px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 16px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
}

/* Card hover effect */
.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
}

/* Card title */
.card-title {
    font-size: 1.25rem;
    font-weight: bold;
    color: #333333;
    margin-bottom: 16px;
}

/* Button styling */
.card-button {
    display: inline-block;
    background: #007bff;
    color: #ffffff;
    text-align: center;
    text-decoration: none;
    padding: 10px 16px;
    font-size: 1rem;
    font-weight: 500;
    border-radius: 8px;
    transition: background 0.2s ease-in-out;
}

.card-button:hover {
    background: #0056b3;
}

/* Responsive design adjustments */
@media (max-width: 768px) {
    .card-container {
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    }
}
</style>
