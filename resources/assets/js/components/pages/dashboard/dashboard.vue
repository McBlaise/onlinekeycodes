<template>
	<div>
		<div class="container">
			<br>
        	<div class="row">
        		<div class="col m12">
        			<nav>
						<div class="nav-wrapper ">
						  <ul id="nav-mobile" class="right hide-on-med-and-down">
						  	<li><router-link class="grey-text text-darken-4" to="/dashboard/history">History</router-link></li>
						    <li><router-link class="grey-text text-darken-4" to="/dashboard/users">Users</router-link></li>
						    <li><router-link class="grey-text text-darken-4" to="/dashboard/cars">Cars</router-link></li>
						    <li><router-link class="grey-text text-darken-4" to="/dashboard/settings">Settings</router-link></li>
						  </ul>
						</div>
					</nav>
        		</div>
        	</div>
        	<div class="row">
        		<div class="col m12">
        			<transition name="fade">
        				<router-view></router-view>
        			</transition>
        		</div>
        	</div>

		</div>
	</div>
</template>
<script>
	
	import axios from 'axios';
	
	export default{

		mounted(){

			console.log('dashboard mounted');

			axios.get('/check')
		    .then((response)=>{

		    	if(response.data.msg == "false"){

		    		this.$router.push('/');

		    	}

		    })
		    .catch(()=>{

		    })

		}

	}

</script>
<style scoped>
	.nav-wrapper{

		background-color: white;

	}

	.router-link-active, nav ul a:hover{

		border-bottom: 4px solid  #3385c6;
		height: 64px;
		background-color: white;

	}
</style>