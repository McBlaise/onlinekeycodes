<template>
	<div>
		<!-- <div class="img-container">
			<img src="/k.jpg" class="cover">
		</div> -->
		<div class="carousel carousel-slider">
			<span class="carousel-item" href="javascript:void(0)"><img src="/assets/background/a.jpg"></span>
			<span class="carousel-item" href="javascript:void(0)"><img src="/assets/background/b.jpg"></span>
			<span class="carousel-item" href="javascript:void(0)"><img src="/assets/background/c.jpg"></span>
			<span class="carousel-item" href="javascript:void(0)"><img src="/assets/background/d.jpg"></span>
			<span class="carousel-item" href="javascript:void(0)"><img src="/assets/background/e.jpg"></span>
			<span class="carousel-item" href="javascript:void(0)"><img src="/assets/background/f.jpg"></span>
		</div>
		<div class="container">
			<div class="row">
				<div class="col m12 s12">
					<div class="card white" id="login-card">
						<div class="card-content">
							<div class="row">
								<div id="d-about" class="col m6 s12 sm-hide">
									<h4 class="center-align">About Us</h4><br>
									<p style="text-align: justify; font-size: 18px">
										<b>
	  										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"Online keycodes is a trusted provider of keycodes for all professional  locksmiths and mechanics  companies for 4 years now. Our key codes have been used all over the world.
											All make and models are available.<br>
											As a premier provider of keycodes world wide, we take pride in the security and fast reliable response time for all queries and orders. "
										</b>
									</p>
								</div>
								<div class="col m6 s12" v-if="!status">
									
									<form @submit.prevent="login" >
										<h4 class="center-align">
											Login
										</h4>
										<br>
										<div class="input-field">
											<input id="username" type="text" class="validate"  v-model="user">
      										<label for="username">Username</label>
										</div>
										<br>
										<div class="input-field">
											<input id="password" type="password" class="validate"  v-model="password">
      										<label for="password">Password</label>
										</div>
										<router-link style="color: white" :to="'/signup'">
											<b>No account yet? <span style="color: #ffbe00">Sign up now.</span></b>
										</router-link>
										<br>
										<a href="javascript:void(0)" @click="forgot" style="color: white">
											<b>Forgot password?</b>
										</a>

										<div class="row">
											<div class="col m12 l7 s12" style="color: red; font-size: 20px"><b>{{message}}</b></div>
											<div class="col m12 l5 s12">
												 <button class="btn btn-navy btn-block right" type="submit" name="action">Submit
												    <i class="material-icons right">send</i>
												  </button>
											</div>
										</div>
									</form>
								</div>
								
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row sm-show">
				<div id="m-about" class="col m12 s12">
					<div class="card">
						<div class="card-content">
							<h4 class="center-align">About Us</h4><br>
							<p style="text-align: justify; font-size: 18px">
								 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"Online keycodes is a trusted provider of keycodes for all professional  locksmiths and mechanics  companies for 4 years now. Our key codes have been used all over the world.
											All make and models are available.<br>
											As a premier provider of keycodes world wide, we take pride in the security and fast reliable response time for all queries and orders. "
							</p>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col m4 s12">
					<div class="card">
						<div class="card-content">
							<div class="" style="height: 300px">
								<h4 class="center" style="color: #808080">Silver</h4>
								<p style="text-align: justify;"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Basic keycodes for limited cars. Codes from this level are from other source and some car make are not available 24/7. By default, upon registration, the keycodes for cars under silver level are available to you.</p>
							</div>
							<br>
							<a class="btn btn-block modal-trigger btn-navy" href="#level1">View Silver Car List</a>
						</div>
					</div>
				</div><div class="col m4 s12">
					<div class="card">
						<div class="card-content">
							<div class="" style="height: 300px">
								<h4 class="center" style="color: #ffd767">Gold</h4>
								<p style="text-align: justify;"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;All keycodes are available 24/7.  For a “national automotive service task force “ members your LSID membership is required for this level. </p>
							</div>
							<br>
							<a class="btn btn-block modal-trigger btn-navy" href="#level2">View Gold Car List</a>
						</div>
					</div>
				</div>
				<div class="col m4 s12">
					<div class="card">
						<div class="card-content">
							<div class="" style="height: 315px; overflow-y: auto; overflow-x: hidden">
								<h4 class="center" style="color: #e48838">Platinum</h4>
								<p style="text-align: justify;"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Top-level keycode access without constraints. This is the most reliable choice from all ranks since we are using our own original dealer sources and all codes are available 24/7. For professional locksmiths. Online Keycodes will provide the requirements and users are prioritized.<br>
								Note that to be eligible for platinum you will have to provide additional information that will be reviewed and manually authorized by us.</p>
							</div>
							<br>
							<a class="btn btn-block modal-trigger btn-navy" href="#level3">View Platinum Car List</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<br><br>

		<!-- Modal Structure -->
		<div id="level1" class="modal">
			<div class="modal-content">
			<i class="material-icons right modal-action modal-close">close</i>
			  <h5 class="center-align">Silver</h5>
			  <table class="bordered highlight">
			  	<thead>
			  		<th class="center-align">Logo</th>
			  		<th class="center-align">Make</th>
			  		<th class="center-align">Price</th>
			  	</thead>
			  	<tbody>
			  		<tr v-for="(item, index) of carsLevel1" >
				  		<td class="center-align">
				  			<img class="carLogo" :src="'/logo/'+item.filename">
				  		</td>
				  		<td class="center-align">
				  			{{item.make}} &nbsp {{item.year}}
				  		</td>
				  		<td class="center-align">
				  			${{item.price}}
				  		</td>
				  	</tr>
			  	</tbody>
			  </table>
			</div>
			<div class="modal-footer">
			  <a href="javascript:void()" class="modal-action modal-close waves-effect waves-green btn-flat">Close</a>
			</div>
		</div>
		<div id="level2" class="modal">
			<div class="modal-content">
			  <i class="material-icons right modal-action modal-close">close</i>
			  <h5 class="center-align">Gold</h5>
			  <table class="bordered highlight">
			  	<thead>
			  		<th class="center-align">Logo</th>
			  		<th class="center-align">Make</th>
			  		<th class="center-align">Price</th>
			  	</thead>
			  	<tbody>
			  		<tr v-for="(item, index) of carsLevel2" >
				  		<td class="center-align">
				  			<img class="carLogo" :src="'/logo/'+item.filename">
				  		</td>
				  		<td class="center-align">
				  			{{item.make}} &nbsp {{item.year}}
				  		</td>
				  		<td class="center-align">
				  			${{item.price}}
				  		</td>
				  	</tr>
			  	</tbody>
			  </table>
			</div>
			<div class="modal-footer">
			  <a href="javascript:void()" class="modal-action modal-close waves-effect waves-green btn-flat">Close</a>
			</div>
		</div>
		<div id="level3" class="modal">
			<div class="modal-content">
			<i class="material-icons right modal-action modal-close">close</i>
			  <h5 class="center-align">Platinum</h5>
			  <table class="bordered highlight">
			  	<thead>
			  		<th class="center-align">Logo</th>
			  		<th class="center-align">Make</th>
			  		<th class="center-align">Price</th>
			  	</thead>
			  	<tbody>
			  		<tr v-for="(item, index) of carsLevel3" >
				  		<td class="center-align">
				  			<img class="carLogo" :src="'/logo/'+item.filename" >
				  		</td>
				  		<td class="center-align">
				  			{{item.make}} &nbsp {{item.year}}
				  		</td>
				  		<td class="center-align">
				  			${{item.price}}
				  		</td>
				  	</tr>
			  	</tbody>
			  </table>
			</div>
			<div class="modal-footer">
			  <a href="javascript:void()" class="modal-action modal-close waves-effect waves-green btn-flat">Close</a>
			</div>
		</div>
	</div>
</template>
<script>
	
	import swal from 'sweetalert2';
	
	export default{

		mounted(){

			console.log('home mounted');
			this.$emit('current-page', 'home');

			if(this.getParameterByName('msg') == 'success'){

				swal({
				  type: 'success',
				  title: 'Success...',
				  text: 'Email successfully verified',
				  allowOutsideClick: false,
				  onClose: ()=>{
				  	window.location.replace('/');
				  }
				});

				

			}
			else if(this.getParameterByName('msg') == 'successP'){

				swal({
				  type: 'success',
				  title: 'Success...',
				  text: 'Payment successful and email successfully verified',
				  allowOutsideClick: false
				});

			}
			else if(this.getParameterByName('msg') == 'failedP'){

				swal({
				  type: 'error',
				  title: 'Subcription payment failed...',
				  text: 'Please sign up again and check your card details',
				  allowOutsideClick: false
				});

			}
			else if(this.getParameterByName('msg') == 'invalidP'){

				swal({
				  type: 'error',
				  title: 'Subcription payment failed...',
				  text: 'Please sign up again and check your card details',
				  allowOutsideClick: false
				});

			}
			this.getAllCars();
			$('#level1').modal({
		      dismissible: true
		    });
			$('#level2').modal({
		      dismissible: true
		    });
			$('#level3').modal({
		      dismissible: true
		    });
		    $(document).ready(function(){

		    	$('.carousel.carousel-slider').carousel({
			    	fullWidth: true
			  	})
			  	autoplay();   
				function autoplay() {

				    $('.carousel').carousel('next');
				    setTimeout(autoplay, 4500);
				}

		  	});
		    
		    axios.get('/check')
		    .then((response)=>{

		    	if(response.data.msg == "true"){

		    		this.status = true;
		    		$('#d-about').removeClass('m6');
		    		$('#d-about').addClass('m12');
		    		$('#d-about').removeClass('sm-hide');

		    		$('#m-about').removeClass('sm-show');
		    		$('#m-about').addClass('sm-hide');

		    	}
		    	else{

		    		this.status = false;
		    		$('#d-about').addClass('m6');
		    		$('#d-about').removeClass('m12');
		    		$('#d-about').addClass('sm-hide');

		    		$('#m-about').addClass('sm-show');
		    		$('#m-about').removeClass('sm-hide');

		    	}

		    })
		    .catch(()=>{

		    	// console.log()

		    })

		},
		data(){

			return{

				password: "",
				user: "",
				message: "",
				sample: "ssssssss",
				carsLevel1: [],
				carsLevel2: [],
				carsLevel3: [],
				col: 'm6',
				status: false

			}

		},
		methods:{

			login(){

				axios.post('/login', {user: this.user, password: this.password})
				.then((response)=>{


					if(response.data.status == 'success'){

						if(response.data.type == 'admin'){

							this.$emit('status', 'in');
							this.$router.push('/admin');

						}
						else{

							this.$emit('status', 'in');
							this.$router.push('/purchase');

						}
						
						// window.location.reload();

					}
					else if(response.data.status == 'error'){

						this.message = response.data.msg;

					}

				})

			},
			getParameterByName(name, url) {
			    if (!url) url = window.location.href;
			    name = name.replace(/[\[\]]/g, "\\$&");
			    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
			        results = regex.exec(url);
			    if (!results) return null;
			    if (!results[2]) return '';
			    return decodeURIComponent(results[2].replace(/\+/g, " "));
			},
			forgot(){

				swal({
				  title: 'Enter email',
				  input: 'email',
				  type: 'info',
				  showCancelButton: true,
				  confirmButtonText: 'Submit',
				  buttonsStyling: true,
				  showLoaderOnConfirm: true,
				  preConfirm: (email) => {
				    return new Promise((resolve) => {
				      
				    	axios.post('/resetPass', {email: email})
				    	.then((response)=>{

				    		// console.log(response.data.msg);
				    		if(response.data.msg == "invalid email"){

				    			swal({
							      type: 'warning',
							      title: 'Email doesn\'t exist',
							      text: 'Please make sure your email is correct.',
							      onClose: ()=>{

							      	this.forgot();

							      }
							    })


				    		}
				    		else{


					    		swal({
							      type: 'success',
							      title: 'Success',
							      text: 'Please check your email for your new password.'
							    })

							    resolve();

				    		}

				    		

				    	})

				    })
				  },
				  allowOutsideClick: () => !swal.isLoading()
				})

			},
			getAllCars(){

				axios.get('/cars')
				.then((response)=>{

					var allCars = response.data.cars;
					
					for(var i = 0; i < allCars.length; i++){

						if(allCars[i].level == 1){

							this.carsLevel1.push(allCars[i]);

						}
						if(allCars[i].level == 2){

							this.carsLevel2.push(allCars[i]);

						}
						if(allCars[i].level == 3){

							this.carsLevel3.push(allCars[i]);

						}

					}

					// console.log(this.carsLevel1);
					// console.log(this.carsLevel2);
					// console.log(this.carsLevel3);

				})
				.catch(()=>{

					console.log('error get cars');

				})

			},

		}
		
	}

</script>

<style scoped>
	.cover{

		min-width: 100%;

	}
	.img-container{

		height: 400px;
		overflow: hidden;
		width: 100%;
		margin-top: -20px;

	}
	#login-card{

		margin-top: -450px;
		background-color: rgba(0,0,0,0) !important;
		box-shadow: 0 0px 0px;

	}
	.carousel{

		margin-top: -20px;
		height: 500px !important;
		overflow: hidden;

		background: rgba(255,255,255,1);
background: -moz-linear-gradient(left, rgba(255,255,255,1) 0%, rgba(255,255,255,1) 0%, rgba(255,255,255,1) 0%, rgba(223,58,104,1) 0%, rgba(64,182,206,1) 90%, rgba(64,182,206,1) 100%);
background: -webkit-gradient(left top, right top, color-stop(0%, rgba(255,255,255,1)), color-stop(0%, rgba(255,255,255,1)), color-stop(0%, rgba(255,255,255,1)), color-stop(0%, rgba(223,58,104,1)), color-stop(90%, rgba(64,182,206,1)), color-stop(100%, rgba(64,182,206,1)));
background: -webkit-linear-gradient(left, rgba(255,255,255,1) 0%, rgba(255,255,255,1) 0%, rgba(255,255,255,1) 0%, rgba(223,58,104,1) 0%, rgba(64,182,206,1) 90%, rgba(64,182,206,1) 100%);
background: -o-linear-gradient(left, rgba(255,255,255,1) 0%, rgba(255,255,255,1) 0%, rgba(255,255,255,1) 0%, rgba(223,58,104,1) 0%, rgba(64,182,206,1) 90%, rgba(64,182,206,1) 100%);
background: -ms-linear-gradient(left, rgba(255,255,255,1) 0%, rgba(255,255,255,1) 0%, rgba(255,255,255,1) 0%, rgba(223,58,104,1) 0%, rgba(64,182,206,1) 90%, rgba(64,182,206,1) 100%);
background: linear-gradient(to right, rgba(255,255,255,1) 0%, rgba(255,255,255,1) 0%, rgba(255,255,255,1) 0%, rgba(223,58,104,1) 0%, rgba(64,182,206,1) 90%, rgba(64,182,206,1) 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff', endColorstr='#40b6ce', GradientType=1 );
		/*background: rgba(242,101,83,1);
background: -moz-linear-gradient(left, rgba(242,101,83,1) 0%, rgba(255,255,255,1) 0%, rgba(240,47,23,1) 82%, rgba(220,40,41,1) 100%);
background: -webkit-gradient(left top, right top, color-stop(0%, rgba(242,101,83,1)), color-stop(0%, rgba(255,255,255,1)), color-stop(82%, rgba(240,47,23,1)), color-stop(100%, rgba(220,40,41,1)));
background: -webkit-linear-gradient(left, rgba(242,101,83,1) 0%, rgba(255,255,255,1) 0%, rgba(240,47,23,1) 82%, rgba(220,40,41,1) 100%);
background: -o-linear-gradient(left, rgba(242,101,83,1) 0%, rgba(255,255,255,1) 0%, rgba(240,47,23,1) 82%, rgba(220,40,41,1) 100%);
background: -ms-linear-gradient(left, rgba(242,101,83,1) 0%, rgba(255,255,255,1) 0%, rgba(240,47,23,1) 82%, rgba(220,40,41,1) 100%);
background: linear-gradient(to right, rgba(242,101,83,1) 0%, rgba(255,255,255,1) 0%, rgba(240,47,23,1) 82%, rgba(220,40,41,1) 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f26553', endColorstr='#dc2829', GradientType=1 );*/

	}
	.carousel-item img{

		opacity: 0.1;
		min-width: 100%;
		min-height: 100%;
		width: auto;

	}
	#login-card h4, #login-card p, #login-card input, #login-card label{

		color: white !important;

	}
	 /* label focus color */
   .input-field input[type=text]:focus + label {
     color: white;
	}
/* label underline focus color */
   .input-field input[type=text], .input-field input[type=password] {
     border-bottom: 1px solid white;
     box-shadow: 0 1px 0 0 white;
   }
   input.valid:not([type]), input.valid:not([type]):focus, input[type=text].valid:not(.browser-default), input[type=text].valid:not(.browser-default):focus, input[type=password].valid:not(.browser-default), input[type=password].valid:not(.browser-default):focus, input[type=email].valid:not(.browser-default), input[type=email].valid:not(.browser-default):focus, input[type=url].valid:not(.browser-default), input[type=url].valid:not(.browser-default):focus, input[type=time].valid:not(.browser-default), input[type=time].valid:not(.browser-default):focus, input[type=date].valid:not(.browser-default), input[type=date].valid:not(.browser-default):focus, input[type=datetime].valid:not(.browser-default), input[type=datetime].valid:not(.browser-default):focus, input[type=datetime-local].valid:not(.browser-default), input[type=datetime-local].valid:not(.browser-default):focus, input[type=tel].valid:not(.browser-default), input[type=tel].valid:not(.browser-default):focus, input[type=number].valid:not(.browser-default), input[type=number].valid:not(.browser-default):focus, input[type=search].valid:not(.browser-default), input[type=search].valid:not(.browser-default):focus, textarea.materialize-textarea.valid, textarea.materialize-textarea.valid:focus, .select-wrapper.valid>input.select-dropdown, input:not([type]):focus:not([readonly]), input[type=text]:not(.browser-default):focus:not([readonly]), input[type=password]:not(.browser-default):focus:not([readonly]), input[type=email]:not(.browser-default):focus:not([readonly]), input[type=url]:not(.browser-default):focus:not([readonly]), input[type=time]:not(.browser-default):focus:not([readonly]), input[type=date]:not(.browser-default):focus:not([readonly]), input[type=datetime]:not(.browser-default):focus:not([readonly]), input[type=datetime-local]:not(.browser-default):focus:not([readonly]), input[type=tel]:not(.browser-default):focus:not([readonly]), input[type=number]:not(.browser-default):focus:not([readonly]), input[type=search]:not(.browser-default):focus:not([readonly]), textarea.materialize-textarea:focus:not([readonly]){
   	border-bottom: 1px solid white;
   	box-shadow: 0 1px 0 0 white;
   }

   .carLogo{
   		max-height: 50px;
   }

   @media only screen and (max-width: 600px) {
    	.carLogo{
	   		max-height: 40px;
	   }
	}




</style>