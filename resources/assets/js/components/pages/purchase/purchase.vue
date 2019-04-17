<template>
	<div class="container">
		<div class="row sm-hide">
			<div class="col m6 s12">
				<div class="card">
					<div class="card-content">
						<div class="row">
							<div class="col m12">
								<h4 class="center-align">
									Make
								</h4>
								<select class="browser-default dropdwn" v-model="lvl" required>
							      <option value="" disabled selected>Select rank</option>
							      <option value="1">Silver</option>
							      <option value="2">Gold</option>
							      <option value="3">Platinum</option>
							    </select>
							</div>
						</div>
						<div class="row">
							<div class="col m12">
								<div v-for="(row, indexA) of allCars">
									<div class="row" style="display: -webkit-box; display: -webkit-flex; display: -ms-flexbox;display: flex;">
										<div v-for="(item, indexB) of row" style="width:100%">
											<div class="col m3 s6" style="width: 100%; height: 100%">
												<div v-if="item.level <= level" style="height: 100%">
													<div style="border: 1px solid #ddd; height: 100%; cursor: pointer;" @click="car_id = item.id" >
														<img :src="'/logo/'+item.filename" style="width: 99%;">
													</div>
													<div style="height: 5px; background-color: #8fea8f"></div>
												</div>
												<div style="height: 100%" v-else>
													<div style="border: 1px solid #ddd; height: 100%; cursor: pointer;" @click="showError(item.level)" >
														<img :src="'/logo/'+item.filename" style="width: 99%; ">
													</div>
													<div style="height: 5px; background-color: #ddd"></div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							
							<!-- <div class="col m6 s12">
								<div class="card">
									<div class="card-content">
										<h5>Price <span class="right-align">s{{price}}</span></h5>
										<hr>
									</div>
								</div>
							</div> -->
						</div>
					</div>
				</div>
			</div>
			<div class="col m6 s12">
				<div class="card card-purchase">
					<div class="card-content">
						<div class="row">
							<div class="col m12">
								<h4 class="center-align">
									Order Details
								</h4>
								<h5 class="center-align">{{package}}</h5>
							</div>
						</div>
						<div class="row">
							<div class="col m12">
								<div class="row">
									<div class="col m12">
										<form @submit.prevent="checkPurchase">
											<div class="row">
												<div class="col s12">
													<div class="input-field">
														<input id="vin" type="text" class="validate"  v-model="vin" maxlength="17" required>
			      										<label for="vin">VIN</label>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col s12">
													<label>Make</label>
													<select class="browser-default"  v-model="car_id" required>
													  <option value="" disabled selected>Select Make</option>
													  <option :value="item.id" v-for="(item, index) of carList">{{item.make+" - $"+item.price}}</option>
													</select>
													            
												</div>
											</div>
											<div class="progress" v-show="checkOutLoad">
											      <div class="indeterminate"></div>
											</div>
											<div class="row">
												<div class="col s4 offset-s8">
													<button class="btn right btn-navy" type="submit">Checkout</button>
												</div>
											</div>	
										</form>
										<br>
										<div class="row">
											<div class="col s12">
												<h6 v-if="level < 3" style="font-size: 20px">
													Can't find what you're looking for? &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
													<br> Upgrade to 
													<a class="bn btnGold" href="javascript:void(0)" @click="upgrade(2)" v-if="level == 1">Gold</a>
													<span v-if="level == 1">or</span>
													<a class="bn btnPlatinum" href="javascript:void(0)" @click="upgrade(3)" v-if="level < 3">Platinum</a>
												</h6>
												<h6 v-else>
													&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
												</h6>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- mobile version -->
		<div class="row sm-show">
			<div class="col m6 s12">
				<div class="card">
					<div class="card-content">
						<div class="row">
							<div class="col m12 s12">
								<h4 class="center-align">
									Order Details
								</h4>
								<h5 class="center-align">{{package}}</h5>
							</div>
						</div>
						<div class="row">
							<div class="col m12 s12">
								<div class="row">
									<div class="col m12 s12">
										<form @submit.prevent="checkPurchase">
											<div class="row">
												<div class="col s12">
													<div class="input-field">
														<input id="mvin" type="text" class="validate"  v-model="vin" required>
			      										<label for="mvin">VIN</label>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col s12">
													<label>Make</label>
													<select class="browser-default"  v-model="car_id" required>
													  <option value="" disabled selected>Select Make</option>
													  <option :value="item.id" v-for="(item, index) of carList">{{item.make+" - $"+item.price}}</option>
													</select>
													            
												</div>
											</div>
											<div class="row">
												<div class="col s4 offset-s8">
													<button class="btn right btn-navy" type="submit">Checkout</button>
												</div>
											</div>	
										</form>
										<br>
										<div class="row">
											<div class="col s12">
												<h6 v-if="level < 3" style="font-size: 20px">
													Can't find what you're looking for? &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
													<br> Upgrade to 
													<a class="bn btnGold" href="javascript:void(0)" @click="upgrade(2)" v-if="level == 1">Gold</a>
													<span v-if="level == 1">or</span>
													<a class="bn btnPlatinum" href="javascript:void(0)" @click="upgrade(3)" v-if="level < 3">Platinum</a>
												</h6>
												<h6 v-else>
													&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
												</h6>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col m6 s12">
				<div class="card">
					<div class="card-content">
						<div class="row">
							<div class="col m12 s12">
								<h4 class="center-align">
									Make
								</h4>
								<select class="browser-default dropdwn" v-model="lvl" required>
							      <option value="" disabled selected>Select rank</option>
							      <option value="1">Silver</option>
							      <option value="2">Gold</option>
							      <option value="3">Platinum</option>
							    </select>
							</div>
						</div>
						<div class="row">
							<div class="col m12 s12">
								<div v-for="(row, indexA) of allCars">
									<div class="row" style="display: -webkit-box; display: -webkit-flex; display: -ms-flexbox;display: flex;">
										<div v-for="(item, indexB) of row" style="width:100%">
											<div class="col m3 s6" style="width: 100%; height: 100%">
												<div v-if="item.level <= level" style="height: 100%">
													<div style="border: 1px solid #ddd; height: 100%; cursor: pointer;" @click="car_id = item.id" >
														<img :src="'/logo/'+item.filename" style="width: 99%;">
													</div>
													<div style="height: 5px; background-color: #8fea8f"></div>
												</div>
												<div style="height: 100%" v-else>
													<div style="border: 1px solid #ddd; height: 100%; cursor: pointer;" @click="showError()" >
														<img :src="'/logo/'+item.filename" style="width: 99%; ">
													</div>
													<div style="height: 5px; background-color: #ddd"></div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div id="messageModel" class="modal">
		    <div class="modal-content">
		    <div><i class="material-icons right modal-action modal-close">close</i></div>
		      <h5>Please wait for a few minutes while your request is being processed...</h5>
		    </div>
		</div>
		<div id="toLevel2" class="modal">
		    <div class="modal-content">
		    	<div><i class="material-icons right modal-action modal-close">close</i></div>
		    	<h5 class="center-align">Required Details.</h5>
		      <div class="row">
		      	<div class="col s10 offset-s1">
		      		<form @submit.prevent="levelUpTwo">
		      			<div class="input-field">
							<input id="lsId" type="text" class="validate"  v-model="lsId" required>
							<label for="lsId">LSID</label>
						</div>
						
						<div class="row">
							<div class="col m4 s12">
								<div class="input-field">
									<input id="lsPassword" :type="type" class="validate"  v-model="lsPassword" required>
									<label for="lsPassword">Password</label>
									<span class="helper-text ht" data-error="wrong" data-success="right" @mouseover="type = 'text'"
									@mouseleave="type='password'">View password</span>
								</div>
							</div>
							<div class="col m8 s12">
								<div class="input-field col s12">
									<input id="sms" type="text" class="validate" v-model="phoneNumber" required>
									<label for="sms">Phone number (ex. 541 754 3010)</label>
									<span class="helper-text ht" data-error="wrong" data-success="right">Note: Only US numbers are currently allowed.</span>
								</div>
							</div>
						</div>
						<div class="progress" v-show="levelUpTwoLoad">
						      <div class="indeterminate"></div>
						</div>
						<p style="color: red">{{message}}</p>
						<div class="row">
							
							<div class="col s12">
								<button class="btn right btn-navy" type="submit">Submit</button>
							</div>
						</div>
		      		</form>
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
								<a class="left btn-resend" @click="resend()">Resend code</a>
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
		<div id="toLevel3" class="modal">
		    <div class="modal-content">
		    	<div><i class="material-icons right modal-action modal-close">close</i></div>
		    	  <h5 class="center-align">Required Details.</h5>
			      <form @submit.prevent="levelUpThree">
			      	  <div class="row">
				      	<div class="col m10 offset-m1 s12">
				      		<div>

				      			<label>State</label>
								<select class="browser-default" v-model="state" required>
							      <option value="" disabled selected>States</option>
							      <option :value="item.state" v-for="(item, index) of stateList">{{item.state}}</option>
							    </select>
							    
							</div>
				      	</div>
				      </div>
				      <div class="row" v-if="state != ''">
				      	<div class="col m10 offset-m1 s12">
				      		<p>Please upload a photo of these documents:<br>
				      		-Driver's License <br>
							-Business License <br>
							-EIN or SSN number <br>
							<span v-if="withLicense">-Locksmith license</span>  <br>
							</p>	
				      	</div>
				      </div>
				      <div v-if="state != ''">
				      	<div class="row" style="margin-bottom: 0px">
					      	<div class="col m5 s12 offset-m1">
					      		<div class="file-field input-field">
							      <div class="btn btn-submarine">
							        <span><i class="material-icons">file_upload</i></span>
							        <input type="file" id="idUpload" required multiple>
							      </div>
							      <div class="file-path-wrapper">
							        <input class="file-path validate" type="text" placeholder="Driver's License">
							      </div>
							    </div>
					      	</div>
					      	<div class="col m5 s12">
					      		<div class="file-field input-field">
							      <div class="btn btn-submarine">
							        <span><i class="material-icons">file_upload</i></span>
							        <input type="file" id="bUpload" required multiple>
							      </div>
							      <div class="file-path-wrapper">
							        <input class="file-path validate" type="text" placeholder="Business License">
							      </div>
							    </div>
					      	</div>
					      </div>
					      <div class="row" style="margin-bottom: 0px">
					      	<div class="col m5 s12 offset-m1">
						      <div class="input-field">
						        <input v-model="einssn" class="validate" type="text" placeholder="EIN or SSN number">
						      </div>
					      	</div>
					      	<div class="col m5 s12" v-if="withLicense">
					      		<div class="file-field input-field">
							      <div class="btn btn-submarine">
							        <span><i class="material-icons">file_upload</i></span>
							        <input type="file" id="lUpload" required multiple>
							      </div>
							      <div class="file-path-wrapper">
							        <input class="file-path validate" type="text" v-model="uploadText" placeholder="Locksmith license">
							      </div>
							    </div>
					      	</div>
					      </div>
				      </div>
			      	  
				      <div class="row">
				      	<div class="col m10 s12 offset-m1">
				      		<button class="btn right btn-navy" type="submit">Submit</button><br>
				      	</div>
				      </div>
				      
				      <div class="row">
				      	<div class="col s10 offset-s1">
				      		<div :style="'height: 5px; width: '+uploadBar+'%; background-color: green'"></div>
				      	</div>
				      </div>
			      </form>
		    </div>
		</div>
		<div id="documents" class="modal">
		    <div class="modal-content">
		    	<div><i class="material-icons right modal-action modal-close">close</i></div>
		    	  <h5 class="center-align">Required Documents</h5>
			      <form @submit.prevent="documents">
				      <div class="row">
				      	<div class="col m12 s12">
				      		<p>Please provide the necessary details and documents:<br>
				      			<li v-for="requirement in requirements">
				      				{{ requirement }}
				      			</li>
							</p>	
				      	</div>
				      </div>

				      <div class="row" style="margin-bottom: 0px">
				      	<div class="input-field col m6 s12">
				          <input id="details" v-model="detailz" type="text" class="validate">
				          <label for="details">Details</label>
				        </div>
				      	<div class="col m6 s12">
				      		<div class="file-field input-field">
						      <div class="btn btn-submarine">
						        <span><i class="material-icons">file_upload</i></span>
						        <input type="file" id="documentz" required multiple>
						      </div>
						      <div class="file-path-wrapper">
						        <input class="file-path validate" type="text" placeholder="Documents">
						      </div>
						    </div>
				      	</div>
				      </div>
			      	  
				      <div class="row">
				      	<div class="col m10 s12 offset-m1">
				      		<button class="btn right btn-navy" type="submit">Submit</button><br>
				      	</div>
				      </div>
				      
				      <div class="row">
				      	<div class="col s10 offset-s1">
				      		<div :style="'height: 5px; width: '+uploadBar+'%; background-color: green'"></div>
				      	</div>
				      </div>
			      </form>
		    </div>
		</div>
	</div>
</template>
<script>
	
	import swal from 'sweetalert2';

	export default{

		mounted(){
			
			console.log('purchase mounted');
			this.type = 'password';
			$('#resendp').hide();
			$('#messageModel').modal({
		      dismissible: false
		    });
		    $('#toLevel2').modal({
		      dismissible: true
		    });
		    $('#toLevel3').modal({
		      dismissible: true
		    });
		    $('#confirmLevel2').modal({
		    	dismissible: true
		    });
		    $('#documents').modal({
		    	dismissible: true
		    });

			this.checkStatus();
			$('select').material_select();

			axios.get('/check')
		    .then((response)=>{

		    	if(response.data.msg == "false"){

		    		this.$router.push('/');

		    	}

		    })
		    .catch(()=>{

		    })

		},
		data(){

			return{

				vin: "",
				cstatus: "",
				level: "",
				lvl: "",
				package: "",
				ls_id: "",
				ls_password: "",
				email: "",
				detailz: "",
				sms: "",
				carList: [],
				requirements: [],
				allowSubmit: true,
				car_id: "",
				lsId: "",
				lsPassword: "",
				uploadBar: 0,
				uploadText: "",
				state: "",
				allCars: "",
				phoneNumber: "",
				withLicense: false,
				vcode: "",
				checkOutLoad: false,
				levelUpTwoLoad: false,
				sendCode2Load: false,
				message: "",
				pverified: "",
				t_id: "",
				einssn: "",
				type: "",
				stateList: [
				{
				"state" : "Alabama",
				"foo" : true
				},
				{
				"state" : "Alaska",
				"foo" : false
				},
				{
				"state" : "Arizona",
				"foo" : false
				},
				{
				"state" : "Arkansas",
				"foo" : false
				},
				{
				"state" : "Calinfornia",
				"foo" : true
				},
				{
				"state" : "Colorado",
				"foo" : false
				},
				{
				"state" : "Colorado",
				"foo" : false
				},
				{
				"state" : "Connecticut",
				"foo" : true
				},
				{
				"state" : "Delaware",
				"foo" : false
				},
				{
				"state" : "Florida",
				"foo" : false
				},
				{
				"state" : "Georgia",
				"foo" : false
				},
				{
				"state" : "Hawaii",
				"foo" : false
				},
				{
				"state" : "Idaho",
				"foo" : false
				},
				{
				"state" : "Illinois",
				"foo" : true
				},
				{
				"state" : "Indiana",
				"foo" : false
				},
				{
				"state" : "Iowa",
				"foo" : false
				},
				{
				"state" : "Kansas",
				"foo" : false
				},
				{
				"state" : "Kentucky",
				"foo" : false
				},
				{
				"state" : "Louisiana",
				"foo" : true
				},
				{
				"state" : "Maine",
				"foo" : false
				},
				{
				"state" : "Maryland",
				"foo" : false
				},
				{
				"state" : "Massachusetts",
				"foo" : false
				},
				{
				"state" : "Michigan",
				"foo" : false
				},
				{
				"state" : "Minnesota",
				"foo" : false
				},
				{
				"state" : "Mississippi",
				"foo" : false
				},
				{
				"state" : "Missouri",
				"foo" : false
				},
				{
				"state" : "Montana",
				"foo" : false
				},
				{
				"state" : "Nebraska",
				"foo" : true
				},
				{
				"state" : "Nevada",
				"foo" : true
				},
				{
				"state" : "New Hampshire",
				"foo" : false
				},
				{
				"state" : "New Jersey",
				"foo" : true
				},
				{
				"state" : "New Mexico",
				"foo" : false
				},
				{
				"state" : "New York",
				"foo" : false
				},
				{
				"state" : "North Carolina",
				"foo" : true
				},
				{
				"state" : "North Dakota",
				"foo" : false
				},
				{
				"state" : "Ohio",
				"foo" : false
				},
				{
				"state" : "Oklahoma",
				"foo" : true
				},
				{
				"state" : "Oregon",
				"foo" : true
				},
				{
				"state" : "Pennsylvania",
				"foo" : false
				},
				{
				"state" : "Rhode Island",
				"foo" : false
				},
				{
				"state" : "South Carolina",
				"foo" : false
				},
				{
				"state" : "South Dakota",
				"foo" : false
				},
				{
				"state" : "Tennessee",
				"foo" : true
				},
				{
				"state" : "Texas",
				"foo" : true
				},
				{
				"state" : "Utah",
				"foo" : false
				},
				{
				"state" : "Vermont",
				"foo" : false
				},
				{
				"state" : "Virginia",
				"foo" : false
				},
				{
				"state" : "Washington",
				"foo" : true
				},
				{
				"state" : "West Virginia",
				"foo" : false
				},
				{
				"state" : "Wisconsin",
				"foo" : false
				},
				{
				"state" : "Wyoming",
				"foo" : false
				}
				],
				withLsid: false

			}

		},
		methods:{
			checkStatus(){

			    $('#confirmLevel2').modal({
			    	dismissible: true
			    });

				axios.get('/locksmith/level')
				.then((response)=>{
					// console.log(response.data);
					this.level = response.data.level;
					if(response.data.level == 1){
						this.package = "Silver";
					}else if(response.data.level == 2){
						this.package = "Gold";
					}else{
						this.package = "Platinum";
					}
					this.withLsid = response.data.shit;
					this.getAllCars();
					this.getCarList(); 
					this.cstatus = response.data.status;
					this.pverified = response.data.phone;
					if(response.data.status == 'maxlevel'){

						swal({
						  type: 'info',
						  title: 'Account upgrade in process.',
						  text: 'Your Details are being Verified, Please wait up to 24 hrs.  You can still use your previous rank until you will receive a notification approval',
						});

					}
					else if(response.data.status == 'levelup'){

						$('#confirmLevel2').modal('open');

					}

				})
				.catch(()=>{

					console.log('error /locksmith/level');

				})

			},
			upgrade(lvl){

				$('#confirmLevel2').modal({
			    	dismissible: true
			    });

			    $('#toLevel2').modal({
			      dismissible: true
			    });
			    $('#toLevel3').modal({
			      dismissible: true
			    });
			    $('#confirmLevel2').modal({
			    	dismissible: true
			    });

				if(lvl == '2'){

					if(this.cstatus == 'levelup'){

						swal({
						  type: 'info',
						  title: 'Notice',
						  text: 'Please verify your phone number to proceed',
						  allowOutsideClick: false,
						  onClose: ()=>{

						  	this.checkStatus();

						  }
						});

					}
					else{

						$('#toLevel2').modal('open');

					}

				}
				else if(lvl == '3'){

					if(this.pverified != "verified"){
						swal({
						  type: 'info',
						  title: 'Notice',
						  text: 'Please verify your phone number to proceed',
						  allowOutsideClick: false,
						  onClose: ()=>{

						  	this.checkStatus();

						  }
						});

					}
					else if(this.cstatus == "maxlevel"){

						if(this.pverified == 'unverified'){

							swal({
							  type: 'info',
							  title: 'Notice',
							  text: 'Please verify your phone number to proceed',
							  allowOutsideClick: false,
							  onClose: ()=>{

							  	$('#confirmLevel2').modal('open');

							  }
							});

						}
						else if(this.pverified == 'none'){

							swal({
							  type: 'info',
							  title: 'Notice',
							  text: 'Please provide a phone number in your account',
							  allowOutsideClick: false,
							  onClose: ()=>{

							  	this.$router.push('/profile');

							  }
							});

						}

					}
					else{

						$('#toLevel3').modal('open');

					}
					

				}
				// axios.post('/locksmith/levelup')
				// .then((response)=>{

				// 	swal({
				// 	  type: 'info',
				// 	  title: 'Account pgrade in process.',
				// 	  text: 'Please wait for a moment while your account is being verified.',
				// 	});

				// })
				// .catch(()=>{

				// 	console.log('error /locksmith/level');

				// })

			},
			sendCode2(){

				$('#confirmLevel2').modal({
			    	dismissible: true
			    });
		   

				this.sendCode2Load = true;
				axios.post('/sms/verify', {vcode: this.vcode})
				.then((response)=>{
					this.sendCode2Load = false;
					var res = response.data.msg;
					if(res == 'success'){

						swal({
						  type: 'success',
						  title: 'Account upgraded successfully.',
						});
						$('#confirmLevel2').modal('close');
						this.checkStatus();

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
					console.log('/error sms verify');

				})

			},
			hideTypeahead(){
				setTimeout(()=>{

					this.$refs.typeahead.hide();

				}, 500);
			},
			checkPurchase(){
				var approval = false;
				var carLevel = "";
				for(var i = 0; i < this.carList.length; i++){

					if(this.carList[i].id == this.car_id){

						carLevel = this.carList[i].level;
						
					}

				}
				if(carLevel == 2 && !this.withLsid){

					swal({
					  type: 'info',
					  title: 'Please provide LSID and Password...',
					  text: 'Please update your account information',
					  onClose: ()=>{

					  	this.$router.push('/profile');

					  }
					});	

				}
				else{

					this.purchase();

				}

			},
			purchase(){
				
				var data = {

					vin: this.vin,
					car_id: this.car_id,
					email: true,
					sms: false

				}

				var carMake = "";
				var carPrice = "";
				var remarks = "";
				var year = "";
				var time = "";
				var docs = "";
				var details = "";
				for(var i = 0; i < this.carList.length; i++){

					if(this.carList[i].id == this.car_id){
						carMake = this.carList[i].make;
						carPrice = this.carList[i].price;
						remarks = this.carList[i].remarks;
						year = this.carList[i].year;
						time = this.carList[i].time;
						docs = this.carList[i].docs;

					}

				}

				swal({
				  title: 'Purchase details.',
				  text: " ",
				  type: 'warning',
				  showCancelButton: true,
				  confirmButtonColor: '#3085d6',
				  cancelButtonColor: '#d33',
				  confirmButtonText: 'Confirm',
				  cancelButtonText: 'Cancel',
				  confirmButtonClass: 'swal2-confirm swal2-styled',
				  cancelButtonClass: 'swal2-danger swal2-styled',
				  buttonsStyling: true,
				  showLoaderOnConfirm: true,
				  preConfirm: ()=>{

				  	return new Promise((resolve) => {

				  		this.checkOutLoad = true;
						$('.btn').attr('disabled', true);
						axios.post('/purchase', data)
						.then((response)=>{
							$('.btn').attr('disabled', false);
							this.checkOutLoad = false;
							this.vin = "";
							this.car_id = "";
							// console.log(response.data);
							if(response.data.msg == "success"){

								if(docs != null && docs != 'N/A' && docs != 'none'){

									let str = response.data.car.docs;
									this.requirements = str.split(",");
									this.t_id = response.data.t_id;

									swal({
									  type: 'info',
									  title: '',
									  text: 'Please enter the necessary documents.',
									  onClose: ()=>{

									  		$('#documents').modal('open');

								  		}
									});	

									
								}
								else{

									swal({
									  type: 'success',
									  title: 'Success...',
									  text: 'Please keep posted while we process your purchase.',
									});	
									
								}

							}
							else if(response.data.msg == "invalid"){

								swal({
								  type: 'warning',
								  title: 'Card number is invalid...',
								  text: 'Please check your card details.',
								});	

							}
							else if(response.data.msg == "no card"){

								swal({
								  type: 'warning',
								  title: 'No card details.',
								  text: 'Please check set your card details in your profile.',
								  onClose: ()=>{

								  	this.$router.push('/profile');

								  }
								});	

							}
							else{

								swal({
								  type: 'warning',
								  title: 'Payment failed...',
								  text: 'Please check your card details.',
								});	

							}		

						})
						.catch(()=>{

							this.checkOutLoad = false;
							console.log('errror purchase');

						})

				  	});
				  	

				  }
				}).then((result) => {
				  // if (result.value) {
				  //    swal({
				  //     type: 'success',
				  //     title: 'Ajax request finished!',
				  //     html: 'Submitted email: ' + result.value
				  //   })
				  // }
				})

				setTimeout(()=>{

					if(year != "N/A" && year != null){
						details += year;
					}

					if(time != "N/A" && time != null){
						details += time;
					}

					if(docs != "N/A" && time != null){
						details += " w/documents"
					}

					if(details == ""){
						details = "none";
					}

					if(remarks == null || remarks == "null" || remarks == "N/A"){
						remarks = "none";
					}

					$('#swal2-content').html("Make: "+carMake+"<br>Price: $"+carPrice+"<br>Details: "+details+"<br>"+remarks);

				}, 500);


			},
			getCarList(){

				axios.get('/car/'+this.level)
				.then((response)=>{

					this.carList = response.data.cars;

				})
				.catch(()=>{

					console.log('error get cars');

				})

			},
			getAllCars(lvl){

				axios.get('/cars')
				.then((response)=>{

					if(lvl == "" || lvl == null){
						lvl = this.level;
					}

					var cars = response.data.cars;
					
					var cars = cars.filter(car => car.level == lvl);

					var rowCount = parseInt(cars.length/4);
					var carAll = [];
					var carIndex = 0;

					for(var i = 0; i < rowCount; i++){

						carAll[i] = [];

						for(var x = 0; x < 4; x++){

							if(cars[carIndex] != undefined){
								if(cars[carIndex].level == lvl){
									carAll[i].push(cars[carIndex]);
								}
							}

							carIndex++;
						}

					}
					this.allCars = carAll;
				})
				.catch(()=>{

					console.log('error get cars');

				})

			},
			getCarId(str, callback){

				for(var i = 0; i < this.carList.length; i++){

					if(this.carList[i].make.trim() == str.trim()){

						callback(this.carList[i].id);

					}

				}

			},
			showError(level){
				if(level == 2){
					level = "Gold";
				}else{
					level = "Platinum"
				}
				swal({
				  type: 'warning',
				  title: 'Notice!',
				  text: 'You\'ll need to uprade to your account into '+level+' to request a keycode for this make',
				});

			},
			levelUpTwo(){

				$('#toLevel2').modal({
			      dismissible: true
			    });
				this.levelUpTwoLoad = true;
				axios.post('/locksmith/levelup', {ls_id: this.lsId, password: this.lsPassword, phone: this.phoneNumber})
				.then((response)=>{
					this.levelUpTwoLoad = false;
					$('#toLevel2').modal('close');
					
					this.message = "";
					swal({
					  type: 'success',
					  title: 'Successfully sent to '+this.phoneNumber,
					  text: 'Please enter the code sent to you throush SMS',
					  allowOutsideClick: false,
					  onClose: ()=>{

					  	this.checkStatus();

					  }
					});

				})
				.catch((error)=>{
					this.message = "Phone number is invalid.";
					this.levelUpTwoLoad = false;
					console.log('error locksmith/levelup');

				})

			},
			levelUpThree(){

			    $('#toLevel3').modal({
			      dismissible: true
			    });

				
			    var formData 	= new FormData();

			    formData.append('state', this.state);

			    var file 		= document.getElementById('idUpload');
				for(var i = 0; i < file.files.length; i++){

					formData.append('fileD['+i+']', file.files[i]);
				
				}

				var file 		= document.getElementById('bUpload');
				for(var i = 0; i < file.files.length; i++){

					formData.append('fileB['+i+']', file.files[i]);
				
				}

				formData.append('einssn', this.einssn);

				if(this.withLicense){

					var file 		= document.getElementById('lUpload');
					for(var i = 0; i < file.files.length; i++){

						formData.append('fileL['+i+']', file.files[i]);
					
					}

				}
				
			    
		  		axios.post('/locksmith/maxlevel', formData, {onUploadProgress: (event)=>{

		  			var percent = Math.round( (event.loaded * 100) / event.total );
		  			this.uploadBar = percent;

		  		}})
		  		.then((response)=>{
		  			$('#resendp').hide();
		  			$('.file-path').val('');
		  			this.uploadBar = 0;
		  			this.uploadText = "";
		  			this.state = "";
		  			
		  			document.getElementById('idUpload').value = "";
		  			swal({
					  type: 'success',
					  title: 'Success...',
					  text: 'Your Details are being Verified, Please wait up to 24 hrs.  You can still use your Silver rank until you will receive a notification approval',
					});
					$('#toLevel3').modal('close');

		  		})
		  		.catch(()=>{

		  			console.log('error /locksmith/maxlevel');

		  		})

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
			},
			documents(){
				console.log("fuck");
			    $('#documents').modal({
			      dismissible: true
			    });

			    var formData = new FormData();

			    formData.append('detailz', this.detailz);
			    formData.append('t_id', this.t_id);

			    var file = document.getElementById('documentz');
				for(var i = 0; i < file.files.length; i++){

					formData.append('filez['+i+']', file.files[i]);
				
				}

		  		axios.post('/requirements', formData, {onUploadProgress: (event)=>{

		  			var percent = Math.round( (event.loaded * 100) / event.total );
		  			this.uploadBar = percent;

		  		}})
		  		.then((response)=>{

		  			$('.file-path').val('');
		  			this.detailz = "";
		  			this.uploadBar = 0;
		  			document.getElementById('documentz').value = "";
					swal({
					  type: 'success',
					  title: 'Success...',
					  text: 'Please keep posted while we process your purchase.',
					});	
					$('#documents').modal('close');

		  		})
		  		.catch(()=>{

		  			console.log('error /requirements');

		  		})

			}

		},
		watch:{

			'state': function(){

				for(var i = 0; i < this.stateList.length; i++){

					if(this.stateList[i].state == this.state){

						if(this.stateList[i].foo){
							
							this.withLicense = true;

						}
						else{

							this.withLicense = false;
						
						}

					}

				}

			},

			'lvl': function(){

				this.getAllCars(this.lvl);

			}

		}

	}

</script>
<style scoped>
	@media only screen and (max-width: 600px) {

		.card-purchase{

			position: static;

		}

	}
	@media only screen and (min-width: 601px) {

		.card-purchase{

			position: fixed;

		}

	}

	.btnGold{
		color: #ffd767;
		background-color: #2d3b48;
	}

	.btnPlatinum{
		color: #e48838;
		background-color: #2d3b48;
	}

	.bn{
		padding: 1px 10px;
		border-radius: 5px;
	}

	.btnGold:hover{
		color: #2d3b48;
		background-color: #ffd767;
	}	

	.btnPlatinum:hover{
		color: #2d3b48;
		background-color: #e48838;
	}

	.ht{
		color: #979797;
	}

	a{
		cursor: pointer;
	}

	.dropdwn{
		border: #004d8e 3px solid;
	}

</style>