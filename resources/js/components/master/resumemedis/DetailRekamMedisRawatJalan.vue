<template>
    <div :style="terminate_detail.display" class="modal">
        <div
            ref="rootdetail"
            class="modal-content modal-besar"
            :class="terminate_detail.show ? 'modal-opened' : 'modal-closed'"
        >
            <div class="modal-header">
                <span class="close" v-on:click="hide()">&times;</span>
                <h2>Rekam Medis Rawat Jalan</h2>
            </div>
            <div class="modal-body" style = "height:100%;">
                <div class="grid">
					<div class="col-4 form-mr">
						<ul class="list-detail">
							<li>No Rekam Medis<span><strong>{{ linkResume }}</strong></span></li>
							<li>Nama Lengkap<span><strong>{{ detail.nama }}</strong></span></li>
							<li>Tanggal Lahir<span><strong>{{ detail.tanggal_lahir}}</strong></span></li>
						</ul>

						<table class="table embed" style ="border:0">
							<tbody>
									<tr v-if="listResume.length > 0" v-for="(item, index) in listResume">
										<td style="font-weight: bold;">{{ item.name }}</td>
										<td style="text-align:right;">
											<button class="button-modal-page button-modal-green" v-on:click="look(index)">Print</button>
										</td>
									</tr>
							</tbody>
						</table>
						<br>
						<button class="button-modal-page button-modal-green" v-on:click="look(index)">Print All</button>
					</div>
					<div class="col-8 form-mr" v-if="linkResume" style="height: 100%; display: flex; flex-direction: column;">
						<iframe title="dokumen" width="100%" height="800px" style="border: 0;" :src="linkResume">
						</iframe>
					</div>
                </div>
            </div>

            <Loader ref="Loader"></Loader>
        </div>
    </div>
</template>

<script>
var vm, body;
import {
    datename,
    nullAndZero,
    formatrupiah,
} from "../../../module/Manipulation.js";

export default {
    mounted: function () {
        vm = this;
        body = document.body;
    },
    data: function () {
        return {
            terminate_detail: { show: false, display: "display: none" },
            listdata: [],
			linkResume:"",
            listResume: [
				{
					name:"RM.1.1",
					link:"http://127.0.0.1:8000/print/rekammedis/272aef8c-6231-4241-be47-a0b945c634ba"
				},
				{
					name:"RM.1.2",
					link:"/"
				},
				{
					name:"RM.1.3",
					link:"/"
				},
				{
					name:"RM.1.4",
					link:"/"
				},
				{
					name:"RM.1.5",
					link:"/"
				},
				{
					name:"RM.1.6",
					link:"/"
				},
				{
					name:"RM.1.7",
					link:"/"
				},
			],
            detail: {
                nama: "Ary Boby Siregar",
                tanggal_lahir: "02 11 2000",
            },
        };
    },
    methods: {
        datename,
        nullAndZero,
        formatrupiah,

        empty: function (data) {
            if (!data || data == "" || data == "-" || data == "0") {
                return "-";
            } else {
                return data;
            }
        },
		look: function(index) {
				vm.linkResume = vm.listResume[index].link;
				console.log(vm.linkResume);
			},
        setdataform: function (response) {
            let data = response.data.data;
            vm.listdata = [];
            vm.listdata = data;
            vm.loaderprocess();
        },

        show: function () {
            body.style.overflowY = "hidden";
            vm.terminate_detail.display = "display: block";
            vm.terminate_detail.show = true;
        },

        hide: function () {
            vm.terminate_detail.show = false;
            setTimeout(
                function () {
                    vm.terminate_detail.display = "display: none";
                    body.style.overflowY = "auto";
                },
                250,
                this
            );
        },

        loaderprocess: function () {
            const left = this.$refs.rootdetail.getBoundingClientRect();
            vm.$refs.Loader.running(left, "modal", 0);
        },
    },
};
</script>
<style>
table.embed tr td  {
	padding: 10px;
	border-bottom: 1px solid #c0c0c0;
}

table.embed tr th  {
	padding: 10px;
	border-bottom: 1px solid #c0c0c0;
}
</style>