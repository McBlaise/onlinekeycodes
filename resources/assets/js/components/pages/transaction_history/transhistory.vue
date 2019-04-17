<template>
	<div>
		<div class="row">
			<div class="col s12">
				<div class="card">
					<div class="card-content">
						<h5 class="center-align">Process History</h5>
						<br>
						<table class="bordered highlight">
							<thead>
								<th class="center-align">Name</th>
								<th class="center-align">Process Type</th>
								<th class="center-align">Price</th>
								<th class="center-align">Rank</th>
								<th class="center-align">Date-time</th>
								<th class="center-align">Action</th>
							</thead>
							<tbody>
								<tr v-for="(item, index) in historyList" v-if="item.p_details != null">
									<td class="center-align" v-if="item.p_details.middlename != null">{{item.p_details.firstname+" "+item.p_details.middlename.charAt(0)+" "+item.p_details.lastname}}</td>
									<td class="center-align" v-else>{{item.p_details.firstname+" "+item.p_details.lastname}}</td>
									<td class="center-align">
										<span v-if="item.type == 'Order'">
											Request for keycode.
										</span>
										<span v-else-if="item.type == 'maxlevel'">
											User upgrade request to Level 3.
										</span>
									</td>
									<td class="center-align">
										<span v-if="item.t_details == ''">
											N/A
										</span>
										<span v-else>
											${{item.t_details.price}}
										</span>
									</td>
									<td class="center-align">
									<span v-if="item.type == 'Order'">
										{{ item.t_details.level }}
									</span>
									<span v-else>
										{{item.p_details.package}}
									</span>

									</td>
									<td class="center-align">{{item.created_at}}</td>
									<td class="center-align">
										<a class="btn btn-navy" v-on:click="viewProcess(index)"><i class="material-icons left">edit</i>View</a>
									</td>	
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div id="viewProcessModalTrans" class="modal">
		    <div class="modal-content">
		    	<i class="material-icons right modal-action modal-close">close</i>
		      <h5 class="center-align">
		      	<span v-if="details.type == 'Order'">
					<b>Request for keycode.</b>
				</span>
				<span v-else-if="details.type == 'maxlevel'">
					<b>User upgrade request to Level 3.</b>
				</span>
		      </h5>
		      <br>
		      <div class="row">
		      	<div class="col s6">
		      		<div v-if="details.type == 'Order'">
				      	<div class="row">
				      		<div class="col s12">
				      			<table class="bordered">
				      				<thead>
				      					<tr>
					      					<th v-if="details.p_details.middlename != null">Name: {{details.p_details.firstname+" "+details.p_details.middlename.charAt(0)+" "+details.p_details.lastname}}</th>
					      					<th v-else>Name: {{details.p_details.firstname+" "+details.p_details.lastname}}</th>
					      				</tr>
				      				</thead>
				      				<tbody>
				      					<tr>
				      						<td>VIN: {{details.t_details.vin}}</td>
				      					</tr>
				      					<tr>
				      						<td>Make: {{details.t_details.make}}</td>
				      					</tr>
				      					<tr>
				      						<td>Price: {{details.t_details.price}}</td>
				      					</tr>
					      				<tr>
					      					<td>Card #: {{details.t_details.card_num}}</td>
					      				</tr>
					      				<tr>
					      					<td>Serial #: {{details.t_details.serial_num}}</td>
					      				</tr>
					      				<tr>
				      						<td>Billing address: {{details.t_details.bill_add}}</td>
				      					</tr>
				      					<tr>
				      						<td>Expiration date: {{details.t_details.exp_date}}</td>
				      					</tr>
				      				</tbody>
				      			</table>
				      		</div>
				      	</div>
				      </div>
				      <div v-else-if="details.type == 'maxlevel'">
				      	<div class="row">
				      		<div class="col s12">
				      			<table class="bordered">
				      				<thead>
				      					<tr>
					      					<th>Name: {{details.p_details.firstname+" "+details.p_details.middlename.charAt(0)+" "+details.p_details.lastname}}</th>
					      				</tr>
				      				</thead>
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
		      					<textarea id="textarea11" class="materialize-textarea" disabled v-model="details.remarks"></textarea>
			          			<label id="lblIssue" class="active" for="textarea11" >Results</label>
		      				</div>
		      				<div class="row" style="margin-bottom: 0px">
		      					<div class="col s12 m12">
		      						<button class="btn btn-submarine right" id="remarkBtn" @click="editRemark">Edit</button>
		      					</div>
		      				</div>
		      			</div>
		      		</div>
		      	</div>
		      </div>
		      <div class="row" v-if="details.type == 'maxlevel'">
		      	
		      	<div class="col sm12">
		      		<hr>
		      		<div v-for="(item, index) of details.files">
		      			<img :src="'/storage/files/'+item.filename+'.'+item.extension">
		      		</div>
		      	</div>

		      </div>
		    </div>
		    <div class="modal-footer">

		    	<a class="btn btn-navy" @click="closeView">Close</a>
		      
		    </div>
		</div>
	</div>
</template>
<script>

	import swal from 'sweetalert2';
	
	export default{

		mounted(){

			console.log('transaction history mounted');
			
		    this.getHistory();

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

				historyList: [],
				details: {} ,

			}

		},
		methods:{

			viewProcess(index){

				$('#lblIssue').addClass('active');
				$('#viewProcessModalTrans').modal({
			      dismissible: true
			    });
				this.details = this.historyList[index];
				$('#viewProcessModalTrans').modal('open');

			},
			closeView(){

				$('#viewProcessModalTrans').modal('close');

			},
			getHistory(){

				axios.get('/processes')
				.then((response)=>{

					this.historyList = response.data.processes;
					console.log(this.historyList);

				})
				.catch(()=>{

					console.log('error get transaction history');

				})

			},
			editRemark(){

				if($('#remarkBtn').html() == 'Edit'){

					$('#textarea11').attr('disabled', false);
					$('#remarkBtn').html('Save');
					$('#remarkBtn').removeClass('btn-submarine');
					$('#remarkBtn').addClass('btn-navy');

				}
				else{

					$('#textarea11').attr('disabled', true);
					$('#remarkBtn').html('Edit');
					$('#remarkBtn').removeClass('btn-navy');
					$('#remarkBtn').addClass('btn-submarine');

					axios.post('/process/'+this.details.id+'/update', {remarks: this.details.remarks})
					.then((response)=>{

						swal({
						  type: 'success',
						  title: 'Success...',
						  text: 'Result successfully updated',
						  allowOutsideClick: true
						});

					})
					.catch(()=>{

						console.log('error /process/remarkId/update');

					})

				}				

			}

		}


	}
</script>