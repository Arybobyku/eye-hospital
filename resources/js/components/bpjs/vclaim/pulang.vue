<template>
    <div class="inner" ref="roottable">
        <iframe
            title="bridging"
            width="100%"
            height="100%"
            style="border: 0; height: 100vh;"
            :src="vclaimUrl"
        ></iframe>
        <Loader ref="Loader"></Loader>
    </div>
</template>

<script>
export default {
    data() {
        return {
            vclaimUrl: import.meta.env.VITE_VCLAIM_PULANG,
        };
    },
};
</script>

<style scoped>
/* Make sure the html, body, and main div take full height */
html, body {
    height: 100%;
    margin: 0;
    padding: 0;
    overflow: hidden; /* Prevent scrolling */
}

.inner {
    height: 100vh; /* 100% of the viewport height */
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}
</style>
