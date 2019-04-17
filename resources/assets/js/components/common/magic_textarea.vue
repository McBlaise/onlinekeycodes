<template>
	<div>
		<textarea 
			
			:placeholder="placeholder" 
			@keydown="textAction"
			@keyup="prevKey = ''" 
			v-model="text" 
			class="form-control magicText">
		
			{{content}}	
		</textarea>
	</div>
</template>
<script>
	export default{

		data(){

			return{

				prevKey	: "",
				text 	: "",
				content	: "" 

			}

		},
		props:["placeholder", "value"],
		methods:{

			textAction(event){

				var local = this;

				if(event.key == "Enter"){

					if(this.prevKey != "Shift"){

						$('.magicText').blur();
						this.content = "";
						this.$emit("output", this.text);

					}

				}

				this.prevKey = event.key;

			},

		},
		watch:{

			'value':function(){

				this.content = this.value;

			}

		}

	}
</script>