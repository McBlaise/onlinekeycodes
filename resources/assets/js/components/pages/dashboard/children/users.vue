<template>
	<div>
		<div class="row">
			<div class="col s12">
				<div class="card">
					<div class="card-content">
						<h5 class="center-align">Registered Users</h5>
						<br>
						<table class="bordered highlight">
							<thead>
								<th class="center-align">Name</th>
								<th class="center-align">Package</th>
								<th class="center-align">Email address</th>
								<th class="center-align">Action</th>
							</thead>
							<tbody>
								<tr v-for="(item, index) in userList" >
									<td class="center-align" v-if="item.middlename != undefined">{{item.firstname+" "+item.middlename.charAt(0)+" "+item.lastname}}</td>
									<td class="center-align" v-else>{{item.firstname+" "+item.lastname}}</td>
									<td class="center-align">{{item.package}}</td>
									<td class="center-align">{{item.email}}</td>
									<td class="center-align">
										<a class="btn btn-navy" v-on:click="viewItem(index)"><i class="material-icons left">edit</i>View</a>
									</td>	
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div id="viewUserModalAdmin" class="modal">
		    <div class="modal-content">
		    	<i class="material-icons right modal-action modal-close">close</i>
		      <h5 class="center-align"><b>User Information</b></h5>
		      <div class="row">
		      	<div class="col m6">
		      		<form @submit.prevent="save">
		      			<div class="input-field">
				          <input disabled v-model="name" id="name" type="text" class="validate text-display" placeholder="Not available">
				          <label for="name" class="label-display active">Name</label>
				          <small v-show="!edit" class="right" style="color: white; background-color: green; padding-left: 5px; padding-right: 5px; cursor: pointer" @click="editMode"><b>EDIT</b></small>
				          <small v-show="edit" class="right" style="color: white; background-color: orange; padding-left: 5px; padding-right: 5px; cursor: pointer" @click="save"><b>SAVE</b></small>	
				          <input type="submit" class="hide">
				        </div>
				        <div class="input-field">
				          
				          <input disabled v-model="email" id="email" type="text" class="validate text-display" placeholder="Not available">
				          <label for="email" class="label-display active">Email</label>
				          
				        </div>
		      		</form>
			        <div class="input-field">
			          <input disabled v-model="company" id="company" type="text" class="validate text-display" placeholder="Not available">
			          <label for="company" class="label-display active">Company</label>
			        </div>
			        <div class="input-field">
			          <input disabled v-model="ccompany" id="ccompany" type="text" class="validate text-display" placeholder="Not available">
			          <label for="ccompany" class="label-display active">Address</label>
			        </div>
		      	</div>
		      	<div class="col m6">
		      		<div class="input-field">
			          <input disabled v-model="level" id="level" type="text" class="validate text-display" placeholder="Not available">
			          <label for="level" class="label-display active">Package</label>
			        </div>
			        <div class="input-field">
			          <input disabled v-model="ls_id" id="ls_id" type="text" class="validate text-display" placeholder="Not available">
			          <label for="ls_id" class="label-display active">LSID</label>
			        </div>
			        <div class="input-field">
			          <input disabled v-model="password" id="password" type="text" class="validate text-display" placeholder="Not available">
			          <label for="password" class="label-display active">Password</label>
			        </div>
			        <div class="input-field">
			          <input disabled v-model="phone" id="phone" type="text" class="validate text-display" placeholder="Not available">
			          <label for="phone" class="label-display active">Phone</label>
			        </div>
		      	</div>
		      </div>
		      <h5 class="center-align"><b>Card Details</b></h5>
		      <div class="row">
		      	<div class="col m6">
		      		<div class="input-field">
			          <input disabled v-model="card_num" id="cnum" type="text" class="validate text-display" placeholder="Not available">
			          <label for="cnum" class="label-display active">Card Number</label>
			        </div>
			        <div class="input-field">
			          <input disabled v-model="exp_date" id="xdate" type="text" class="validate text-display" placeholder="Not available">
			          <label for="xdate" class="label-display active">Expiration Date</label>
			        </div>
		      	</div>
		      	<div class="col m6">
		      		<div class="input-field">
			          <input disabled v-model="serial_num" id="snum" type="text" class="validate text-display" placeholder="Not available">
			          <label for="snum" class="label-display active">Serial Number</label>
			        </div>
			        <div class="input-field">
			          <input disabled v-model="b_add" id="snum" type="text" class="validate text-display" placeholder="Not available">
			          <label for="snum" class="label-display active">Billing Address</label>
			        </div>
		      	</div>
		      </div>
		    </div>
		    <div class="modal-footer">
		      <a class="btn  btn-navy " @click="closeView">Close</a>
		    </div>
		</div>
	</div>
</template>
<script>
	
	import axios from 'axios';
	import swal from 'sweetalert2';

	export default{

		mounted(){

			console.log('users mounted');
			this.getAllUsers();
			$('#viewUserModalAdmin').modal({
		      dismissible: true
		    });

		},
		data(){

			return {

				userList: [],
				name: "",
				email: "",
				company: "",
				ccompany: "",
				phone: "",
				level: "",
				ls_id: "",
				password: "",
				card_num: "",
				serial_num: "",
				exp_date: "",
				b_add: "",
				edit: false,
				id: ""

			}

		},
		methods:{

			getAllUsers(){

				axios.get('/users')
				.then((response)=>{
					var users;
					this.userList = response.data.data;
					console.log(this.userList);
					this.userList.forEach(function(data){

						if(data.package == 1){
							data.package = "Silver";
						}
						else if(data.package == 2){
							data.package = "Gold";
						}
						else{
							data.package = "Platinum";
						}

					});

				})
				.catch(()=>{

					console.log('error users');

				})

			},
			editMode(){

				this.edit = true;
				$("#email").prop('disabled', false);
				$("#email").focus();

			},
			save(){

				axios.post('/edit/'+this.id, {email: this.email})
				.then((response)=>{

					if(response.data.msg == 'Email already taken'){

						swal({
						  type: 'error',
						  title: 'Error...',
						  text: 'Email already taken',
						  allowOutsideClick: true
						});

					}
					else{

						this.edit = false;
						$("#email").prop('disabled', true);
						$("#email").focusout();
						swal({
						  type: 'success',
						  title: 'Success...',
						  text: 'Email successfully updated',
						  allowOutsideClick: true
						});

					}

				})
				.catch(()=>{

					console.log('error edit email');

				})

			},
			viewItem(index){

				if(this.userList[index].middlename != undefined || this.userList[index].middlename != null){
					this.name = this.userList[index].firstname+" "+this.userList[index].middlename.charAt(0)+" "+this.userList[index].lastname;
				}
				else{
					this.name = this.userList[index].firstname+" "+this.userList[index].lastname;
				}
				this.id = this.userList[index].id;
				this.email = this.userList[index].email;
				this.company = this.userList[index].company;
				this.ccompany = this.userList[index].company_add;
				this.phone = this.userList[index].phone;
				this.level = this.userList[index].package;
				this.ls_id = this.userList[index].ls_id;
				this.card_num = this.userList[index].card.card_num;
				this.serial_num = this.userList[index].card.serial_num;
				this.b_add = this.userList[index].card.b_add;
				this.exp_date = this.userList[index].card.exp_date;
				// this.password = this.userList[index].password;
				
				$('#viewUserModalAdmin').modal('open');

			},
			closeView(){

				$('#viewUserModalAdmin').modal('close');

			},

		}

	}

</script>