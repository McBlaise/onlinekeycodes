<template>
	<div>
		<div style="position: relative" v-if="show">
			<div class="card" style="margin:0px; position: absolute; background-color: white; z-index: 1; width: 100%">
				
				<div class="item" style="padding: 10px; border-bottom: 1px solid #ddd" v-for="(item, index) in itemList" @click="clicked(index)">
					<div class="row" style="margin-bottom: 0px">
						<div class="col s9">
							{{item.make}}
						</div>
						<div class="col s3">
							$ {{item.price}}
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
</template>
<script>
	
	export default{

		mounted(){

			console.log('typeahead mounted');


		},
		data(){

			return{

				show: false,
				index: -1

			}

		},
		methods:{

			down(){

				var item = document.getElementsByClassName('item');

				if(this.index < this.itemList.length-1){

					this.index++;

				}

				for(var i = 0; i < item.length; i++){

					item[i].classList.remove('active');

				}
				item[this.index].classList.add('active');

				

			},

			up(){

				var item = document.getElementsByClassName('item');

				if(this.index > 0){

					this.index--;

				}

				for(var i = 0; i < item.length; i++){

					item[i].classList.remove('active');

				}
				item[this.index].classList.add('active');

			},
			enter(){

				if(this.index>=0){

					this.$emit('selected', this.itemList[this.index]);
					this.show = false;

				}

			},
			clicked(index){

				this.index = index;
				this.enter();

			},
			hide(){

				this.show = false;

			}

		},
		props: ['make', 'list'],
		watch:{

			'make': function(){

				if(this.make == ""){

					this.show = false;

				}
				else{

					this.show = true;

				}

			}

		},
		computed: {
			itemList() {
				this.index = -1;
			  return this.list.filter(item => {
			     return item.make.toLowerCase().indexOf(this.make.toLowerCase()) > -1
			  })
			}
		}

	}

</script>
<style scoped>
	
	.active{

		background-color: #448aff ;
		color: white;

	}

</style>