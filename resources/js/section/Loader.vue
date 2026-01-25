<template>
	<div :style="loading.main" class="wrap-loading-main">
		<div class="loading-main">
			<div class="boxes">
				<div class="box"><div></div><div></div><div></div><div></div></div>
				<div class="box"><div></div><div></div><div></div><div></div></div>
				<div class="box"><div></div><div></div><div></div><div></div></div>
				<div class="box"><div></div><div></div><div></div><div></div></div>
			</div>
			<h3>Please Wait ...</h3>
		</div>
	</div>
	</template>
	
	<script>
	export default {
		data:() => {
			return { loading: { main: 'display: none' } }
		},
		methods: {
			running: function(left, posisi = 'main', height = 0, minus = 0) {
				if (posisi == 'modal') {
					this.loading.main = this.loading.main == 
					'display: none' ? 'display:block;width:'+(left.width-2)+'px;height:'+(left.height+height)+'px; left: 0; top: 0' : 'display: none';
				}
				else {
					this.loading.main = this.loading.main == 
					'display: none' ? 'display:block;width:'+(left.width-minus)+'px;height:'+left.height+'px;' : 'display: none';
				}
			}
		}
	}
	</script>