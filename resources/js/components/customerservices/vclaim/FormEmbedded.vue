<template>
    <div :style="terminate.display" class="modal">
        <div
            ref="rootmodal"
            class="modal-content"
            :class="terminate.show ? 'modal-opened' : 'modal-closed'"
        >
            <div class="modal-header">
                <span class="close" v-on:click="hide()">&times;</span>
            </div>
            <div class="modal-body">
                <iframe
                    title="CPPT"
                    width="100%"
                    height="100%"
                    style="border: 0"
                    :src="linkR"
                >
                </iframe>
            </div>
            <Loader ref="Loader"></Loader>
        </div>
    </div>
</template>

<script>
import { defineAsyncComponent } from "vue";
import { formunit } from "./FormData.js";
import { parseunit, parsedelete } from "./Attachment.js";
import {
    filterselected,
    hideselected,
    itemselected,
    clearselected,
    boxselected,
    conditionselected,
} from "../../../module/SelectedFilter.js";
import { initindexdb, indexdbprocessing } from "../../../module/Indexdb.js";
import { formatrupiah } from "../../../module/Manipulation.js";

var vm, body;
export default {
    emits: ["dialog", "parsingForm"],
    components: {
        Inputed: defineAsyncComponent(() =>
            import("../../../section/Inputed.vue")
        ),
        Selected: defineAsyncComponent(() =>
            import("../../../section/Selected.vue")
        ),
    },
    mounted: function () {
        vm = this;
		body = document.body;
    },
    created: function () {},
    data: function () {
        return {
            terminate: { show: false, display: "display: none" },
            linkR: null,
        };
    },
    methods: {
        setLinkIframe: function (link) {
            vm.linkR = link;
			console.log("LINK", link);
            vm.show();
        },

        show: function () {
            body.style.overflowY = "hidden";
            vm.terminate.display = "display: block";
            vm.terminate.show = true;
        },

        loaderprocess: function () {
            const left = this.$refs.rootmodal.getBoundingClientRect();
            vm.$refs.Loader.running(left, "modal", 1000);
        },

        hide: function () {
            vm.terminate.show = false;
            setTimeout(
                function () {
                    vm.terminate.display = "display: none";
                    body.style.overflowY = "auto";
                },
                250,
                this
            );
        },
    },
};
</script>
<style scoped>

.modal-content {
    width: 90%;
    height: 90%;
    background-color: #fff;
    border-radius: 10px;
    overflow: hidden;
    position: relative;
    box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);
    animation: fadeIn 0.25s ease-in-out;
}


.modal-body {
    padding: 10px;
    height: calc(100% - 40px); /* Adjust for header height */
}

.modal-opened {
    opacity: 1;
    transform: scale(1);
    transition: opacity 0.25s ease, transform 0.25s ease;
}

.modal-closed {
    opacity: 0;
    transform: scale(0.9);
    transition: opacity 0.25s ease, transform 0.25s ease;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: scale(0.9);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}
</style>
