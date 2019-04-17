<template>
	
	<div class="container">
		
		<div class="row">
			<div class="col m12">
				<div class="card">
					<div class="card-content">
						<div class="row">
							<div class="col s12">
								<h4 class="center-align">
									Profile
								</h4>
							</div>
						</div>
						<div class="row">
							<div class="col m6 s12">
								<div class="row prof-det">
									<div class="col s12">
										<div class="row">
											<div class="col s6 m5">
												<div class="circle responsive-img img-circle">
													<img src="/default.png">
												</div>
											</div>
											<div class="col s6 m6">
												<h6>{{package}}</h6>
											</div>
										</div>
									</div>
								</div>
								<br>
								<div v-if="!detailsEditMode">
									<div class="row">
										<div class="col m6 s12 prof-det">
											<div class="input-field">
									          <input disabled :value='fname+" "+mname+" "+lname' id="name" type="text" class="validate text-display-borderless" placeholder="Not available">
									          <label for="name" class="label-display active">Name</label>
									        </div>
									        
											<div class="input-field">
									          <input disabled v-model='caddress' id="caddress" type="text" class="validate text-display-borderless" placeholder="Not available">
									          <label for="caddress" class="label-display active">Address</label>
									        </div>

									        <div class="input-field">
									          <input disabled :value='email' id="email" type="text" class="validate text-display-borderless" placeholder="Not available">
									          <label for="email" class="label-display active">Email</label>
									        </div>

									        <div class="input-field">
									          <input disabled :value='company' id="company" type="text" class="validate text-display-borderless" placeholder="Not available">
									          <label for="company" class="label-display active">Company</label>
									        </div>

									        <div class="input-field">
									          <input disabled :value='preference' id="preference" type="text" class="validate text-display-borderless" placeholder="Not available">
									          <label for="preference" class="label-display active">Messaging Preference</label>
									        </div>

										</div>
										<div class="col m6 s12 prof-det">
											<div class="input-field">
									          <input disabled :value='phone' id="phone" type="text" class="validate text-display-borderless" placeholder="Not available">
									          <label for="phone" class="label-display active">Phone</label>
									        </div>
									        
											<div class="input-field">
									          <input disabled :value='ls_id' id="ls_id" type="text" class="validate text-display-borderless" placeholder="Not available">
									          <label for="ls_id" class="label-display active">LSID</label>
									        </div>

									        <div class="input-field">
									          <input disabled :value='password' id="password" type="text" class="validate text-display-borderless" placeholder="Not available">
									          <label for="password" class="label-display active">LSID Password</label>
									        </div>

									        <div class="input-field">
									          <input disabled :value='username' id="username" type="text" class="validate text-display-borderless" placeholder="Not available">
									          <label for="username" class="label-display active">Username</label>
									        </div>
										</div>
									</div>
									<div class="row">
										<div class="col s12">
											<button class="btn-navy btn right" @click="detailsEditMode = true">Edit</button>
										</div>
									</div>
								</div>

								<div v-else>
									<form @submit.prevent="saveDetails">
										<div class="row" >
											<div class="col m6 s12 prof-det">
												<div class="input-field">
										          <input id="fname" type="text" v-model="fname" class="validate" placeholder="First Name" required>
										          <label for="fname" class="active">First Name</label>
										        </div>
										        <div class="input-field">
										          <input id="mname" type="text" v-model="mname" class="validate" placeholder="Middle Name">
										          <label for="mname" class="active">Middle Name</label>
										        </div>
										        <div class="input-field">
										          <input id="lname" type="text" v-model="lname" class="validate" placeholder="Last Name" required>
										          <label for="lname"  class="active">Last Name</label>
										        </div>
												<div class="input-field">
										          <input id="eaddress" type="text" v-model="caddress" class="validate" placeholder="Address">
										          <label for="eaddress"  class="active">Address</label>
										        </div>
										        <div class="input-field">
										          <input id="eemail" type="text" v-model="email" class="validate" placeholder="Email" required>
										          <label for="eemail"  class="active">Email</label>
										        </div>
										        <div class="input-field">
										          <input id="upassword" type="password" v-model="upassword" class="validate" placeholder="Account Password">
										          <label for="upassword"  class="active">Account Password</label>
										        </div>
										        <div class="row">
											        <div class="col s12">
											          <label for="ppreference" class="active">Messaging Preference</label>
											        	<select id="ppreference" v-model="preference" class="browser-default">
													      <option value="" disabled selected required>Preference</option>
														      <option value="both">Both + History Page</option>
														      <option value="email">Email + History Page</option>
														      <option value="sms">Sms + History Page</option>
														      <option value="none">History Page Only</option>
													    </select>	
											        </div>
										        </div>


											</div>
											<div class="col m6 s12 prof-det">
												<div class="input-field">
										          <input id="ecompany" type="text" v-model="company" class="validate" placeholder="Company">
										          <label for="ecompany"  class="active">Company</label>
										        </div>
										        <div class="input-field">
										          <input id="ephone" type="text" v-model="phone" class="validate" placeholder="Phone" required>
										          <label for="ephone"  class="active">Phone</label>
										        </div>
										        <div class="input-field">
										          <input id="els_id" type="text" v-model="ls_id" class="validate" placeholder="LSID">
										          <label for="els_id"  class="active">LSID</label>
										        </div>
												<div class="input-field">
										          <input id="epassword" type="text" v-model="password" class="validate" placeholder="LSID Password">
										          <label for="epassword"  class="active">LSID Password</label>
										        </div>
										        <div class="input-field">
										          <input id="username" type="text" v-model="username" class="validate" placeholder="Username">
										          <label for="username"  class="active">Username</label>
										        </div>
										        <div class="input-field">
										          <input id="cupassword" type="password" v-model="cupassword" class="validate" placeholder="Confirm Account Password">
										          <label for="cupassword"  class="active">Confirm Account Password</label>
										        </div>
											</div>
										</div>
										<p style="color: red"><b>{{message}}</b></p>
										<div class="progress" v-show="saveDetailsLoad">
										      <div class="indeterminate"></div>
										</div>
										<div class="row">
											<div class="col s12">
												<button class="btn-submarine btn right" type="submit">Save</button>
											</div>
										</div>
									</form>
								</div>
								<br>
							</div>
							<div class="col m6 s12">
								<div class="row" v-if="!cardEditMode">
									<div class="col s12">
										<div class="prof-det">
											<h6 class="center-align">Card Details</h6>
											<br>
											<div class="row">
												<div class="col s4">
													<h6>Card #:</h6>
												</div>
												<div class="col s8">
													<h6>{{card_number_c}}</h6>
												</div>
											</div>
											<div class="row">
												<div class="col s4">
													<h6>Security #:</h6>
												</div>
												<div class="col s8">
													<h6>{{security_number_c}}</h6>
												</div>
											</div>
											<div class="row">
												<div class="col s4">
													<h6>Billing address:</h6>
												</div>
												<div class="col s8">
													<h6>{{b_add}}</h6>
												</div>
											</div>
											<div class="row">
												<div class="col s4">
													<h6>Expiration date:</h6>
												</div>
												<div class="col s8">
													<h6>{{exp_date}}</h6>
												</div>
											</div>
											<br>
											<div class="row">
												<div class="col s12">
													<button class="btn-navy btn right" @click="cardEditMode = true">
														Update
													</button>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="row" v-else>
									<div class="col s12">
										<form @submit.prevent="saveCard">
											<div class="prof-det">
												<h5 class="center-align">Card Details</h5>
												<div class="row">
													<div class="col s4">
														<h6>Card #:</h6>
													</div>
													<div class="col s8">
														<input type="text" class="form-control" placeholder="Card number..." v-model="card_number">
													</div>
												</div>
												<div class="row">
													<div class="col s4">
														<h6>Security #:</h6>
													</div>
													<div class="col s8">
														<input type="text" class="form-control" placeholder="Security number..." v-model="security_number">
													</div>
												</div>
												<div class="row">
													<div class="col s4">
														<h6>Billing address:</h6>
													</div>
													<div class="col s8">
														<input type="text" class="form-control" placeholder="Billing address..." v-model="b_add">
													</div>
												</div>
												<div class="row">
													<div class="col s4">
														<h6>Expiration date:</h6>
													</div>
													<div class="col s8">
														<div class="row">
															<div class="col s6">
																<select v-model="month" class="browser-default">
															      <option value="" disabled selected required>Month</option>
																      <option :value="index+1" v-for="(item, index) of 12">{{index+1}}</option>
															    </select>	
															</div>
															<div class="col s6">
																<select v-model="year" class="browser-default">
															      <option value="" disabled selected required>Year</option>
															      <option :value="index+2018" v-for="(item, index) of 50">{{index+2018}}</option>
															    </select>
															</div>
														</div>
													</div>
												</div>
												<div class="progress" v-show="saveCardLoad">
												      <div class="indeterminate"></div>
												</div>
												<div class="row">
													<div class="col s12">
														<button class="btn-submarine btn right" type="submit">
															Save
														</button>
													</div>
												</div>
											</div>
										</form>
									</div>
								</div>
								<br>
								<!-- <input type="checkbox" id="sms" />
				      			<label for="sms">Get sms notification</label> -->
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div id="confirmLevel2" class="modal">
		    <div class="modal-content">
		      <div class="row">
		      	<div class="col s10 offset-s1">
		      		<form @submit.prevent="sendCode2">

		      			<h4 class="center-align">Enter Code</h4>
		      			<div class="input-field">
							<input id="vcode" type="text" class="validate"  v-model="vcode" required>
							<label for="vcode">Phone verification code</label>
						</div>
						<div class="progress" v-show="sendCode2Load">
						      <div class="indeterminate"></div>
						</div>
						<div class="row" style="margin-bottom: 0px">
							<div class="col s6">
								<a class="left btn-resend" @click="resend()">Resend code</span></a>
								<div class="progress" id="resendp">
							      	<div class="indeterminate"></div>
							  	</div>
							</div>
							<div class="col s6">
								<button class="btn right btn-navy" type="submit">Submit</button>
							</div>
						</div>
		      		</form>
		      	</div>
		      </div>
		    </div>
		</div>
		
	</div>

</template>
<script>
	
	import swal from 'sweetalert2';

	export default{

		mounted(){
			console.log('profile mounted');
			$('#resendp').hide();
			this.getCurrentUser();

			axios.get('/check')
		    .then((response)=>{

		    	if(response.data.msg == "false"){

		    		this.$router.push('/');

		    	}

		    })
		    .catch(()=>{

		    })

		    this.getPhoneStatus();


		},
		data(){

			return{

				fname: "",
				mname: "",
				lname: "",
				company: "",
				caddress: "",
				email: "",
				package: "",
				preference: "",
				card_number: "",
				card_number_c: "",
				security_number: "",
				security_number_c: "",
				cardEditMode: false,
				detailsEditMode: false,
				package: "",
				phone:  "",
				password: "",
				ls_id: "",
				b_add: "",
				exp_date: "",
				month: "",
				year: "",
				saveDetailsLoad: false,
				saveCardLoad: false,
				upassword: "",
				cupassword: "",
				username:"",
				message: "",
				vcode: "",
				phone_status: "",
				sendCode2Load: false

			}

		},
		props:['isLoggedin'],
		methods:{

			getPhoneStatus(){

				$('#confirmLevel2').modal({
			      dismissible: true
			    });
				axios.get('/locksmith/level')
				.then((response)=>{

					this.phone_status = response.data.phone;
					if(response.data.phone == 'unverified'){

						$('#confirmLevel2').modal('open');

					}
					
					console.log(response);
				})
				.catch(()=>{



				})	

			},
			sendCode2(){

				this.sendCode2Load = true;
				axios.post('/sms/verify', {vcode: this.vcode})
				.then((response)=>{
					this.sendCode2Load = false;
					var res = response.data.msg;
					if(res == 'success'){

						swal({
						  type: 'success',
						  title: 'Success!',
						});
						$('#confirmLevel2').modal('close');
						this.checkStatus();
						location.reload();
					}
					else if(res == 'wrong code'){

						swal({
						  type: 'error',
						  title: 'Verification code is incorrect.',
						  text: 'Please check the code again'
						});

					}

				})
				.catch(()=>{
					this.sendCode2Load = false;
					swal({
					  type: 'success',
					  title: 'Phone Number Verified.'
					});
					location.reload();
				})

			},
			getCurrentUser(){

				axios.get('/currentUser')
				.then((response)=>{

					var pDetails 	= response.data.p_details;
					var credentials	= response.data.credentials;
					var cards 		= response.data.cards;

					if(pDetails.package == 1){
						this.package = "Silver";
					}else if(pDetails.package == 2){
						this.package = "Gold";
					}else{
						this.package = "Platinum";
					}

					this.fname 	= pDetails.firstname;
					this.mname 	= pDetails.middlename;
					this.lname 	= pDetails.lastname;
					this.company 	= pDetails.company;
					this.caddress 	= pDetails.company_add;
					this.email 	= pDetails.email;
					this.username 	= credentials.user;
					this.phone = pDetails.phone;
					this.password = pDetails.password;
					this.preference = pDetails.preference;


					if(pDetails.ls_id != 0){

						this.ls_id = pDetails.ls_id;

					}

					this.card_number 		= cards.card_num;
					this.security_number 	= cards.serial_num;

					if(cards.card_num > 0){
						this.card_number_c	= "**********"+cards.card_num.substring(10);
					}

					if(cards.serial_num.length > 0){
						this.security_number_c	= "**"+cards.serial_num.substring(2);
					}

					this.b_add 				= cards.b_add;
					this.month 				= cards.exp_date.split('-')[1];
					this.year 				= cards.exp_date.split('-')[0];
					this.exp_date 			= cards.exp_date;

				})
				.catch(()=>{

					console.log('error currentUser');

				})

			},
			saveCard(){

				this.saveCardLoad = true;
				axios.post('/card/edit',{card_num: this.card_number, serial_num: this.security_number, b_add: this.b_add, exp_date: this.year+"-"+this.month})
				.then((response)=>{

					this.saveCardLoad = false;
					this.getCurrentUser();
					this.cardEditMode = false;

				})
				.catch(()=>{

					this.saveCardLoad = false;
					console.log('card edit error');

				})

			},
			saveDetails(){
				this.getPhoneStatus();

				this.saveDetailsLoad = true;
				if(this.preference != "email"){
					if(this.phone_status != "verified"){
						return alert("Please verify your phone number!");
						this.saveDetailsLoad = false;
						
					}
				}

				if(this.upassword != "" || this.cupassword != ""){

					if(this.upassword == this.cupassword){

						var data = {

							firstname 	: this.fname,
							middlename 	: this.mname,
							lastname 	: this.lname,
							email 		: this.email,
							company 	: this.company,
							company_add : this.caddress,
							user 		: this.username,
							sms			: "",
							phone 		: this.phone,
							ls_id 		: this.ls_id,
							password 	: this.password,
							upassword   : this.upassword,
							preference   : this.preference

						}

						axios.post('/update', data)
						.then((response)=>{

							this.getPhoneStatus();
							this.saveDetailsLoad = false;
							this.detailsEditMode = false;
							console.log(response);
							this.message="";


						})
						.catch(()=>{

							this.saveDetailsLoad = false;
							console.log('error /update');

						})
						
					}
					else{

						this.message="Account password doesn't match";

					}

				}
				else{

					var data = {

						firstname 	: this.fname,
						middlename 	: this.mname,
						lastname 	: this.lname,
						email 		: this.email,
						company 	: this.company,
						company_add : this.caddress,
						user 		: this.username,
						sms			: "",
						phone 		: this.phone,
						ls_id 		: this.ls_id,
						password 	: this.password,
						preference 	: this.preference,
						upassword 	: "none"

					}
					$('#resendp').hide();
					axios.post('/update', data)
					.then((response)=>{
						this.message="";
						this.saveDetailsLoad = false;
						this.detailsEditMode = false;
						console.log(response);
						this.getPhoneStatus();

					})
					.catch(()=>{

						this.saveDetailsLoad = false;
						console.log('error /update');

					})

				}

			},
			resend(){
				$('#resendp').show();
				axios.get('/resend')
					.then((response)=>{
						$('#resendp').hide();
						$('.btn-resend').text("Resent!");
					})
					.catch(()=>{
						$('#resendp').hide();
						$('.btn-resend').text("try again later!");
						console.log('error resending');
					})
			}
			

		},
		watch: {

			'card_number': function(){
				
				if(this.card_number == 0){

					this.card_number = "";

				}

			}

		}

	}

</script>
<style scoped>
	
	.img-circle{

		width: 150px;
		height: 150px;
		overflow: hidden;
		border: 1px solid #ddd;

	}
	.img-circle>img{

		min-height: 100%;
		width: 100%;

	}
	.prof-det .row, .prof-det{

		margin-bottom: 0px;

	}
	h6{

		font-size: 20px;

	}
	a{
		cursor: pointer;
	}

</style>