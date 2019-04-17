<template>
	<div class="row">
		<div class="col m12">
			<div class="card">
				<div class="card-content">
					<div class="row">
						<div class="col m6 s12" style="border-right: 1px solid rgba(0,0,0,0.5)">
							<h5 class="center-align">Change Login Details</h5>
							<div class="row">
								<div class="col m10 offset-m1  s12">
									<form @submit.prevent="checkDetails">
										<div class="input-field">
								          <input placeholder="Username" id="username" type="text" class="validate" v-model="username" required>
								          <label for="username" class="active">Username</label>
								        </div>
								        <div class="input-field">
								          <input id="password" type="password" class="validate" v-model="password" required>
								          <label for="password">New password</label>
								        </div>
								        <div class="input-field">
								          <input id="cpassword" type="password" class="validate" v-model="cpassword" required>
								          <label for="cpassword">Confirm password</label>
								        </div>
								        <p><b style="color: red">{{message}}</b></p>
								        <div class="progress" v-show="checkDetailsLoad">
										    <div class="indeterminate"></div>
										</div>
								        <button class="btn btn-navy right">Submit</button>
									</form>
								</div>
							</div>
						</div>
						<div class="col m6 s12">
							<h5 class="center-align">System Settings</h5>
							<br>
							<form @submit.prevent="editSetting">
								<div class="row">
									<!-- <input type="hidden" name=""> -->
									<div class="col m10 offset-m1  s12">
										<div class="input-field">
								          <input placeholder="remarks" id="signupRemarks" disabled type="text" class="validate" v-model="signupRemarks">
								          <label for="signupRemarks" class="active">System Message</label>
								        </div>
									</div>
								</div>
								<div class="row">
									<!-- <input type="hidden" name=""> -->
									<div class="col m10 offset-m1  s12">
										<div class="input-field">
								          <input placeholder="0.00" id="signupPrice" disabled type="number" class="validate" v-model="signupPrice">
								          <label for="signupPrice" class="active">Amount charged for signup (USD)</label>
								        </div>
									</div>
								</div>
								<div class="row">
									<div class="col m10 offset-m1  s12">
										<input type="checkbox" v-model="chargeSignup" id="chargeSignup" disabled />
					      				<label for="chargeSignup"><a href="javascript:void(0)" style="color: black">Charge Customer for Signup</a></label>
					      				<div class="progress" v-show="editSettingsLoad">
										    <div class="indeterminate"></div>
										</div>
										<br>
										<button class="right btn-navy btn" id="editSettingBtn" type="submit" >Edit</button>
									</div>
								</div>
								
								
							</form>
						</div>
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

			console.log('settings mounted');
			this.getAdmin();
			this.getSignupSettings();

		},
		data(){

			return{

				cpassword: "",
				password: "",
				username:"",
				message: "",
				checkDetailsLoad: false,
				chargeSignup: false,
				signupPrice: "",
				signupRemarks: "",
				editSettingsLoad: false

			}

		},
		methods:{

			checkDetails(){

				if(this.password == this.cpassword){

					this.updateDetails();

				}
				else{

					this.message = "Password doesn't match";

				}

			},

			updateDetails(){

				this.checkDetailsLoad = true;

				axios.post('/admin/update', {user: this.username, password: this.password})
				.then((response)=>{

					this.checkDetailsLoad = false;

					this.message = "";
					swal({
					  type: 'success',
					  title: 'Success...',
					  text: 'Account details successfully updated'
					});

				})
				.catch(()=>{



				})

			},
			getAdmin(){

				axios.get('/user/admin')
				.then((response)=>{

					this.username = response.data.admin[0].user;

				})
				.catch(()=>{



				})

			},
			editSetting(){

				if($('#editSettingBtn').html() == "Edit"){

					$('#signupPrice').attr('disabled', false);
					$('#signupRemarks').attr('disabled', false);
					$('#chargeSignup').attr('disabled', false);
					$('#editSettingBtn').html('Save');
					$('#editSettingBtn').removeClass('btn-navy');
					$('#editSettingBtn').addClass('btn-submarine');

				}
				else{

					$('#signupPrice').attr('disabled', true);
					$('#signupRemarks').attr('disabled', true);
					$('#chargeSignup').attr('disabled', true);
					$('#editSettingBtn').html('Edit');
					$('#editSettingBtn').addClass('btn-navy');
					$('#editSettingBtn').removeClass('btn-submarine');
					console.log(this.chargeSignup);

					if(this.chargeSignup){

						swal({
						  title: 'Confirm',
						  text: "Customers will be charged $"+this.signupPrice+" when signing up",
						  type: 'info',
						  showCancelButton: true,
						  confirmButtonColor: '#3085d6',
						  cancelButtonColor: '#d33',
						  confirmButtonText: 'Yes'
						}).then((result) => {
						  if (result.value) {
						    this.editSettingsLoad = true;

							axios.post('/settings/signupCharge', {price: this.signupPrice, isActivated: this.chargeSignup, remarks: this.signupRemarks})
							.then((response)=>{
								// console.log(response);
								this.editSettingsLoad = false;
								this.getSignupSettings();

							})
							.catch(()=>{

								this.editSettingsLoad = false;
								console.log('error /settings/signupCharge');

							})
						  }
						})

					}
					else{
						swal({
						  title: 'Confirm',
						  text: "Registration will be free of charge!",
						  type: 'info',
						  showCancelButton: true,
						  confirmButtonColor: '#3085d6',
						  cancelButtonColor: '#d33',
						  confirmButtonText: 'Yes'
						}).then((result) => {
						  if (result.value) {
						    this.editSettingsLoad = true;

							axios.post('/settings/signupCharge', {price: this.signupPrice, isActivated: this.chargeSignup, remarks: this.signupRemarks})
							.then((response)=>{

								this.editSettingsLoad = false;
								this.getSignupSettings();

							})
							.catch(()=>{

								this.editSettingsLoad = false;
								console.log('error /settings/signupCharge');

							})
						  }
						})
					}
					

				}

			},
			getSignupSettings(){

				axios.get('/settings/signupChargeDetails')
				.then((response)=>{

					if(response.data.settings != null){
						// console.log("fuck");
						// console.log(response.data.settings);

						if(response.data.settings.is_active == "false"){

							this.chargeSignup = false;

						}
						else{

							this.chargeSignup = true;

						}
						
						this.signupPrice  = response.data.settings.amount;
						this.signupRemarks = response.data.settings.remarks;

					}

				})
				.catch(()=>{

					console.log('error getting signup settings');

				})

			}

		},
		watch: {

			chargeSignup: function(){

				if(this.chargeSignup){

					$('#signupPrice').attr('required', 'required');

				}
				else{

					$('#signupPrice').removeAttr('required');

				}

			}

		}

	}
</script>