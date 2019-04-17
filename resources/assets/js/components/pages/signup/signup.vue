<template>
	<div class="container">

		<br>
		<div class="row">
			<div class="col m8 offset-m2">
				<div class="card">
					<div class="card-content">
						<h4 class="center-align">Signup</h4>
						<form @submit.prevent="checkDetails">
							<div class="row">
								<div class="col m12">
									<h5 class="">Personal Details</h5>
								</div>
							</div>
							<div class="row">
								<div class="col m6 s12">
									<div class="row">
										<div class="col m12 s12">
											<div class="input-field">
												<input id="usernamee" type="text" class="validate"  v-model="username" required>
		  										<label for="usernamee">Username</label>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col m12 s12">
											<div class="input-field">
												<input id="passwordd" type="password" class="validate"  v-model="password" required>
		  										<label for="passwordd">Password</label>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col m12 s12">
											<div class="input-field">
												<input id="cpasswordd" type="password" class="validate"  v-model="cpassword" required>
		  										<label for="cpasswordd">Confirm Password</label>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col m12 s12">
											<div class="input-field">
												<input id="email" type="email" class="validate"  v-model="email" required>
		  										<label for="email">Email</label>
											</div>
										</div>
									</div>
									
								</div>

								<div class="col m6 s12">

									<div class="row">
										<div class="col m12 s12">
											<div class="input-field">
												<input id="fname" type="text" class="validate"  v-model="fname" required>
		  										<label for="fname">First name</label>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col m12 s12">
											<div class="input-field">
												<input id="mname" type="text" class="validate"  v-model="mname">
		  										<label for="mname">Middle name</label>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col m12 s12">
											<div class="input-field">
												<input id="lname" type="text" class="validate"  v-model="lname" required>
		  										<label for="lname">Last name</label>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col m12 s12">
											<div class="input-field">
												<input id="company" type="text" class="validate"  v-model="company">
		  										<label for="company">Company</label>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col m12 s12">
											<div class="input-field">
												<input id="caddress" type="text" class="validate"  v-model="caddress">
		  										<label for="caddress">Address</label>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col m12">
									<h4 class="">Card Details</h4>
									<p style="color: #d62c2c">{{notice}}</p>
								</div>
							</div>
							<br>
							<div class="row">
								<div class="col m6 s12">
									<div class="input-field">
										<input id="cnumber" type="text" class="validate"  v-model="cnumber">
										<label for="cnumber">Card Number</label>
									</div>
								</div>
								<div class="col m6 s12">
									<div class="input-field">
										<input id="snumber" type="text" class="validate"  v-model="snumber">
										<label for="snumber">Security Number</label>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col m3 s6">
									<div class="">
										<select v-model="month" id="mnt" class="browser-default">
									      <option value="" disabled selected>Month</option>
										      <option :value="index+1" v-for="(item, index) of 12">{{index+1}}</option>
									    </select>	
									    <label>Expiration Date</label>
									
									</div>
								</div>
								<div class="col m3 s6 ">
									<select v-model="year" id="yr" class="browser-default">
								      <option value="" disabled selected>Year</option>
								      <option :value="index+2018" v-for="(item, index) of 50">{{index+2018}}</option>
								    </select>
									
								</div>
								<div class="col m6 s12">
									<div class="input-field">
										<input id="baddress" type="text" class="validate"  v-model="baddress">
										<label for="baddress">Billing address</label>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col s12 m12">
									<input type="checkbox" required id="terms" />
				      				<label for="terms"><a href="javascript:void(0)" @click="openTerms">Terms and conditions</a></label>
								</div>
							</div>
							<div class="progress" v-show="signupLoad">
							      <div class="indeterminate"></div>
							</div>
							<div class="row">
								<div class="col m8 s12">
									<p style="color: red"><b>{{message}}</b></p>
								</div>
								<div class="col m4 s12">
									<button class="btn btn-navy right" type="submit" name="action">Submit
									    <i class="material-icons right">send</i>
									  </button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div id="termsModal" class="modal">
		    <div class="modal-content">
		    	<i class="material-icons right modal-action modal-close x">close</i>
		      <div class="row">
		      	<div class="col m10 offset-m1 s12">
		      		<form @submit.prevent="sendCode2" class="test">

		      			<h4 class="center-align">Terms and Conditions</h4>

						<div class="row">
							<div class="col s12 m12">
								<p style="text-align: justify">
Please read these Terms of Service carefully before accessing or using our website. By accessing or using any part of the site, you agree to be bound by these Terms of Service. If you do not agree to all the terms and conditions of this agreement, then you may not access the website or use any services. If these Terms of Service are considered an offer, acceptance is expressly limited to these Terms of Service.<br><br>

By visiting our site and/or purchasing something from us, you engage in our “Service” and agree to be bound by the following terms and conditions. These Terms of Service apply to all users of the site, including without limitation users who are browsers, vendors, customers, merchants, and/ or contributors of content. Any new features or tools which are added to the current store shall also be subject to the Terms of Service. <br><br>

You may not use our website for any illegal or unauthorized purpose nor may you, in the use of the Service, violate any laws in your jurisdiction (including but not limited to copyright laws).<br><br>
We reserve the right to refuse service to anyone for any reason at any time. <br><br>

Prices for our products are subject to change without notice.
We reserve the right at any time to modify or discontinue the Service (or any part or content thereof) without notice at any time. We shall not be liable to you or to any third-party for any modification, price change, suspension or discontinuance of the Service. We do not warrant that the quality of any services, information, or other purchased or obtained by you will meet your expectations, or that any errors in the Service will be corrected.<br><br>

You agree to provide current, complete account information for all key code purchases made in our website. You agree to promptly update your account and other information, including your email address and credit card numbers and expiration dates, so that we can complete your transactions and contact you as needed.<br><br>

We are not responsible if information made available on this site is not accurate, complete or current. 
We provide key codes that is on file and we get it directly from the dealer. We do not warrant or make any representations concerning the accuracy, likely results, or reliability of the key codes we provide. <br><br>

You expressly agree that your use of, or inability to use, the service is at your sole risk. The service and all products and services delivered to you through the service are (except as expressly stated by us) provided 'as is' and 'as available' for your use, without any representation, warranties or conditions of any kind, either express or implied, including all implied and non-infringement.
We will not warrant any refund, nor you, will dispute any charges accumulated on a particular key code request. You will have a fine of $25 for each transaction.<br><br>

In addition to other prohibitions as set forth in the Terms of Service, you are prohibited from using the site or its content: (a) for any unlawful purpose; (b) to solicit others to perform or participate in any unlawful acts (requesting for stolen cars); (c) to violate any international, federal, provincial or state regulations, rules, laws, or local ordinances; (d) to infringe upon or violate our intellectual property rights or the intellectual property rights of others; (e) to submit false or misleading information; (f) to upload or transmit viruses or any other type of malicious code that will or may be used in any way that will affect the functionality or operation of the Service or of any related website, other websites, or the Internet; (g) to collect or track the personal information of others; (h) to spam, phish, pharm, pretext, spider, crawl, or scrape; (i) for any obscene or immoral purpose; or (j) to interfere with or circumvent the security features of the Service or any related website, other websites, or the Internet. We reserve the right to terminate your use of the Service or any related website for violating any of the prohibited uses.<br><br>


You can review the most current version of the Terms of Service at any time on this page. We reserve the right to update, change or replace any part of these Terms of Service by posting updates and/or changes to our website. It is your responsibility to check this page periodically for changes. Your continued use of or access to the website following the posting of any changes constitutes <br>acceptance of those changes.</p>		
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

	import axios from 'axios';
	import swal from 'sweetalert2';

	export default{

		mounted(){

			console.log('signup mounted');
			this.getSignupSettings();
			this.$emit('current-page', 'signup');
			$('.datepicker').pickadate({
				selectMonths: true, // Creates a dropdown to control month
				selectYears: 15, // Creates a dropdown of 15 years to control year,
				today: 'Today',
				clear: 'Clear',
				close: 'Ok',
				closeOnSelect: false,
				onClose: ()=>{

					// callback when selected

				}
			});
			if(this.getParameterByName('error') != null){

				swal({
				  title: 'Verification Failed',
				  text: 'Please make sure to provide the correct Card Details',
				  type: 'warning',
				})

			}
			$('select').material_select();

			setInterval(()=>{

				this.getSignupSettings();

			}, 3000);

		},
		methods:{

			checkDetails(){
				
				var isBlank = false;

				if(	this.fname != "" &&
					this.lname != "" &&
					this.username != "" &&
					this.email != "" &&
					this.password != ""){

					var data = {

						firstname: this.fname,
						middlename: this.mname,
						lastname: this.lname,
						company: this.company,
						user: this.username,
						email: this.email,
						password: this.password,
						card_num: this.cnumber,
						serial_num: this.snumber,
						company_add: this.caddress,
						exp_date: this.year+"-"+this.month,
						b_add: this.baddress

					}

					if(this.cpassword == this.password){

						this.submitForm(data);

					}
					else{

						this.message = "Password doesn't match";

					}

				}
				else{

					this.message = "Please fill in all fields";

				}

			},
			openTerms(){

				$('#termsModal').modal({
			    	dismissible: true
			    });
			    $('#termsModal').modal('open');

			},
			getSignupSettings(){

				axios.get('/settings/signupChargeDetails')
				.then((response)=>{
					// console.log(response);
					if(response.data.settings != null){
						

						if(response.data.settings.is_active == "false"){

							$('#cnumber').removeAttr('required');
							$('#snumber').removeAttr('required');
							$('#mnt').removeAttr('required');
							$('#yr').removeAttr('required');
							$('#baddress').removeAttr('required');

							this.notice = response.data.settings.remarks;

						}
						else{

							$('#cnumber').attr('required', 'required');
							$('#snumber').attr('required', 'required');
							$('#mnt').attr('required', 'required');
							$('#yr').attr('required', 'required');
							$('#baddress').attr('required', 'required');

							this.notice = response.data.settings.remarks;

						}
						

					}
					else{

						this.notice = "*Online keycodes is free within 2 months: fields below are optional.";

					}

				})
				.catch(()=>{

					console.log('error getting signup settings');

				})

			},
			submitForm(data){
				
				this.signupLoad = true;
				var local = this;
				console.log(data);
				axios.post('/signup', data)
				.then((response)=>{

						this.signupLoad = false;
						if(response.data.msg == "Email already exists"){

								local.message = "Email address already exists";

						}
						else if(response.data.msg == "Username already exists"){

								local.message = "Username already exists";

						}
						else if(response.data.msg == "success"){

							
							swal({
							  type: 'success',
							  title: 'Success...',
							  text: 'Please check your email for verification',
							  allowOutsideClick: false,
							  onClose: ()=>{

							  	this.$router.push('/');

							  }
							});

						}
						else{

								local.message = "Something went wrong";

						}

				})
				.catch(()=>{

					this.signupLoad = false;
					console.log('error api/signup');

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
			}

		},
		data(){

			return{

				fname: "",
				mname: "",
				lname: "",
				company: "",
				username: "",
				email: "",
				password: "",
				caddress: "",
				message: "",
				cnumber: "",
				snumber: "",
				exp_date: "",
				month: "",
				year: "",
				phone: "",
				baddress: "",
				cpassword: "",
				signupLoad: false,
				notice: ""

			}

		},
	}
</script>

<style scoped>


</style>