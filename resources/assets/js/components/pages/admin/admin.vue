<template>
	<div>
		<div class="container">
			<div class="row">
				<div class="col s12">
					<div class="card">
						<div class="card-content">
							<h5 class="center-align">Process Queue</h5>
							<button class="btn btn-submarine right" @click="refreshProcess"><i class="material-icons left" >refresh</i>
							Refresh</button>
							<div class="row">
							    <div id="orders" class="col s12">
							    	<table class="bordered striped highlight">
										<thead>
											<!-- <th class="center-align">Waiting Time</th> -->
											<th class="center-align">Name</th>
											<th class="center-align">Process Type</th>
											<th class="center-align">Date-time</th>
											<th class="center-align">Action</th>
										</thead>
										<tbody>
											<tr v-for="(item, index) in list">
												<!-- <td class="center-align">{{item.time}}</td> -->
												<td class="center-align" v-if="item.middlename != null">{{item.firstname+" "+item.middlename.charAt(0)+" "+item.lastname}}</td>
												<td class="center-align" v-else>{{item.firstname+" "+item.lastname}}</td>
												<td class="center-align">{{item.type}}</td>
												<td class="center-align">{{item.created_at}}</td>
												<td class="center-align">
													<span v-if="!item.processing">
														<a class=" btn  green accent-4 center" @click="viewProcess('order', index)" v-if="item.type=='Request for key code'"><i class="material-icons left">edit</i>View</a>
														<a class=" btn  green accent-4 center" @click="viewProcess('user', index)" v-else><i class="material-icons left">edit</i>View</a>
													</span>
													<span v-else>
														Processing...
													</span>
												</td>	
											</tr>
										</tbody>
									</table>

							    </div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div id="viewProcessModal" class="modal">
		    <div class="modal-content">
		    <i class="material-icons right modal-action modal-close">close</i>
		      <h5 class="center-align">
		      	<b>{{processType}}</b>
		      </h5>
		      <br>
		      <div class="row">
		      	<div class="col s6">
		      		<div v-if="modalType == 'order'">
				      	<div class="row">
				      		<div class="col s12">
				      			<table class="bordered">
				      				<thead>
				      					<tr>
					      					<th v-if="middlename != null">Name: {{firstname+" "+middlename.charAt(0)+" "+lastname}}</th>
					      					<th v-else>Name: {{firstname+" "+lastname}}</th>
					      				</tr>
				      				</thead>
				      				<tbody>
				      					<tr>
				      						<td>VIN: {{vin}}</td>
				      					</tr>
				      					<tr>
				      						<td>Make: {{make}}</td>
				      					</tr>
				      					<tr>
				      						<td>Price: {{price}}</td>
				      					</tr>
					      				<tr>
					      					<td>Card #: {{cardNumber}}</td>
					      				</tr>
					      				<tr>
					      					<td>Serial #: {{serialNumber}}</td>
					      				</tr>
					      				<tr>
					      					<td>Billing address: {{bill_add}}</td>
					      				</tr>
					      				<tr>
					      					<td>Expiration date: {{exp_date}}</td>
					      				</tr>
				      				</tbody>
				      			</table>
				      		</div>
				      	</div>
				      </div>
				      <div v-else-if="modalType == 'user'">
				      	<div class="row">
				      		<div class="col s12">
				      			<table class="bordered">
				      				<thead>
				      					<tr>
					      					<th v-if="middlename != null">Name: {{firstname+" "+middlename.charAt(0)+" "+lastname}}</th>
					      					<th v-else>Name: {{firstname+" "+lastname}}</th>
					      				</tr>
				      				</thead>
				      				<tbody>
				      					
					      				<tr>
					      					<td>Card #: {{cardNumber}}</td>
					      				</tr>
					      				<tr>
					      					<td>Serial #: {{serialNumber}}</td>
					      				</tr>
					      				<tr>
					      					<td>Billing address: {{bill_add}}</td>
					      				</tr>
					      				<tr>
					      					<td>Expiration date: {{exp_date}}</td>
					      				</tr>
					      				<tr>
					      					<td>EIN or SSN: {{vcode}}</td>
					      				</tr>
				      				</tbody>
				      			</table>
				      			
				      		</div>
				      	</div>
				      	
				      </div>
				      <div v-else>
				      	<h6 class="center-align">Loading...</h6>
				      </div>
		      	</div>
		      	<div class="col s6">
		      		<div class="card">
		      			<div class="card-content">
		      				<div class="input-field">
		      					<textarea id="textarea1" class="materialize-textarea" v-model="remarks"></textarea>
			          			<label for="textarea1">Result</label>
		      				</div>
		      			</div>
		      		</div>		      		
		      	</div>
		      </div>
		      <div class="row" v-if="modalType == 'user'">
		      	<div class="col m12">
		      		<hr>
		      		<i class="material-icons right modal-action modal-close">close</i>
		      		<div class="carousel">
		      			<a class="carousel-item" v-for="(item, index) of files">
			      			<img :src="'/storage/files/'+item.filename+'.'+item.extension">
			      		</a>
					</div>
		      	</div>

		      </div>
		      <div class="row" v-else>
		      	<div class="col m12">
		      		<hr>
		      		<div v-if="tfiles.length != 0" class="carousel">
		      			<a class="carousel-item" v-for="(item, index) of tfiles">
			      			<img :src="'/storage/files/'+item.filename+'.'+item.extension">
			      		</a>
					</div>
	      		</div>
		      </div>
		      <div class="progress" v-show="processLoad">
			      <div class="indeterminate"></div>
			  </div>
		    </div>
		    
		    <div class="modal-footer">

		    	<a class="btn  green accent-4 " @click="agree(ls_id, t_id)">Approve</a>
		    	<a class="btn  red darken-1 " @click="decline(ls_id, t_id)">Decline</a>
		      
		    </div>
		</div>
		<audio id="noti" class="hide">
		  <source src="/assets/sound/sound.mpeg" type="audio/mpeg">
		  Your browser does not support the audio element.
		</audio>
	</div>
</template>
<script>

	import axios from 'axios';
	import Vue from 'vue';

	
	export default{

		mounted(){

			this.noti = document.getElementById("noti"); 

			

		    $('ul.tabs').tabs();

		    this.getTransactionRequests();

		    setInterval(()=>{

		    	this.getTransactionRequests();

		    }, 2000);

		    axios.get('/check')
		    .then((response)=>{

		    	if(response.data.msg == "false"){

		    		this.$router.push('/');

		    	}

		    })
		    .catch(()=>{

		    })

		    console.log('admin mounted');

		    setInterval(()=>{
		    	// console.log(this.list.length);
		    	if(this.list.length > 0){

		    		this.noti.play();

		    	}

		    }, 120000);
		},
		data(){

			return{

				locksmiths: [],
				transactions: [],
				modalType: "",
				firstname: "",
				lastname: "",
				middlename: "",
				cardNumber: "",
				serialNumber: "",
				id:"",
				processType: "",
				vin: "",
				price:"",
				ls_id: "",
				remarks: "",
				files: "",
				tfiles: "",
				noti: "",
				prevLength: 0,
				list: "",
				wTime: [],
				make: "",
				exp_date: "",
				bill_add: "",
				vcode: "",
				processLoad: false

			}

		},
		methods:{

			viewProcess(type, index){
				this.noti.pause();
				$('#viewProcessModal').modal({
			      dismissible: true,
			      complete:()=>{
			      	
			      	axios.post('/process/cancel', {ls_id: this.ls_id, t_id: this.t_id})
			      	.then((response)=>{

			      		// console.log(response.data);

			      	})
			      	.catch(()=>{

			      	});

			      }
			    });

			    $(document).ready(function(){
				    $('.carousel').carousel();
				});
				

				var data = {};

				if(type == 'order'){
					this.tfiles = null;
					var order =  this.list[index];
					// console.log(order);
					data.t_id = order.id;
					data.ls_id = "";
					this.firstname = order.firstname;
					this.lastname = order.lastname;
					this.middlename = order.middlename;
					this.serialNumber = order.serial_num;
					this.cardNumber = order.card_num;
					this.price = order.price;
					this.vin = order.vin;
					this.ls_id = "";
					this.t_id = order.id;
					this.bill_add = order.bill_add;
					this.exp_date = order.exp_date;
					this.make = order.make;
					this.tfiles = order.files;

					this.processType = 'Keycode request';

					this.modalType = 'order';

				}
				else{

					var lock = this.list[index];
					
					data.t_id = "";
					data.ls_id = lock.id;
					// console.log(lock);
					this.firstname = lock.firstname;
					this.lastname = lock.lastname;
					this.middlename = lock.middlename;
					this.cardNumber = lock.card.card_num;
					this.serialNumber = lock.card.serial_num;
					this.bill_add = lock.card.b_add;
					this.exp_date = lock.card.exp_date;
					this.ls_id = lock.id;
					this.t_id = "";
					this.files = lock.files;
					this.vcode = lock.vcode;

					if(lock.status == 'pending'){

						this.processType = "New Account";

					}
					else{

						this.processType = "Upgrade Account";

					}

					this.modalType = 'user';

				}

				axios.post('/processing', data)
				.then((response)=>{

					// console.log(response);

				})
				.catch(()=>{

					console.log('processing error');

				});
				$('#viewProcessModal').modal('open');
			},
			getTransactionRequests(){

				axios.get('/transaction/request')
				.then((response)=>{
					// console.log(response.data);
					//uncomment if mind changes
					// var length = response.data.transactions.length;
					// length = parseInt(length);
					// length+=response.data.locksmiths.length;

					// this.transactions = response.data.transactions;
					// this.locksmiths = response.data.locksmiths;

					var length = response.data.list.length;
					length = parseInt(length);
					// console.log("current length: "+length);
					// console.log("previous length: "+this.prevLength);
					this.list = response.data.list;

					if(length>this.prevLength){
						console.log("playing");
						this.noti.play();

					}

					this.prevLength = length;
					// console.log(response.data.list);
						
					

				})
				.catch(()=>{

					console.log('error /transactions');

				});


			},
			agree(ls_id, t_id){
				
				this.processLoad = true;
				axios.post('/request/approval', {ls_id: ls_id, t_id: t_id, remarks: this.remarks})
				.then((response)=>{

					this.processLoad = false;
					this.remarks = "";
					$('#viewProcessModal').modal('close');
					// console.log(response.data);

				})
				.catch(()=>{

					this.processLoad = false;
					console.log('errror level.approve');

				})

			},
			decline(ls_id, t_id){

				this.processLoad = true;
				axios.post('/request/rejection', {ls_id: ls_id, t_id: t_id, remarks: this.remarks})
				.then((response)=>{

					this.processLoad = false;
					this.remarks = "";
					$('#viewProcessModal').modal('close');

				})
				.catch(()=>{

					this.processLoad = false;
					console.log('error rejection');

				})

			},

			refreshProcess(){
				
				axios.post('/process/refresh')
				.then((response)=>{

					location.reload();

				})
				.catch(()=>{

					console.log('error process refresh');

				})

			}


		},
		deactivated(){

			alert();

		}


	}

</script>
<style scoped>
	.tabs .indicator {
	    color: #03a9f4 ;
	}
	 #viewProcessModal .row{

		margin: 0px;

	}
</style>