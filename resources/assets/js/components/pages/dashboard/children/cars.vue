<template>
	<div>
		<div class="row">
			<div class="col s12">
				<div class="card">
					<div class="card-content">
						<h5 class="center-align">Car make list</h5>
						<div class="row">
							<div class="col s12">
								<a class=" btn  green accent-4 left" @click="openAddCarModal()"><i class="material-icons right">add</i>Add</a>
							</div>
						</div>
						<table class="bordered highlight">
							<thead >
								<th class="center-align">Logo</th>
								<th class="center-align">Make</th>
								<th class="center-align">Level</th>
								<th class="center-align">Year</th>
								<th class="center-align">Time</th>
								<th class="center-align">Docs</th>
								<th class="center-align">Price</th>
								<th class="center-align">Action</th>
							</thead>
							<tbody>
								<tr v-for="(item, index) in carList" >
									<td class="center-align"><img style="max-width: 50px" :src="'/logo/'+item.filename"></td>	
									<td class="center-align">{{item.make}}</td>
									<td class="center-align">{{item.level}}</td>
									<td class="center-align">{{item.year}}</td>
									<td class="center-align">{{item.time}}</td>
									<td class="center-align">{{item.docs}}</td>
									<td class="center-align">${{item.price}}</td>
									<td class="center-align">
										<a class="btn btn-navy" v-on:click="viewItem(index)">Edit</a>
									</td>	
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div id="viewCarModalAdmin" class="modal">
			<form @submit.prevent>
		    <div class="modal-content">
		    	<i class="material-icons right modal-action modal-close">close</i>
		      <h4 class="center-align">Make Information</h4>
		      <div class="row">
		      	<div class="col m12">
		      		
	      			<div class="row">
	      				<div class="col m6 s12">
	      					<div class="input-field">
					          <input id="make" type="text" class="validate" v-model="make" placeholder="Make" required>
					          <label for="make" class="active">Make</label>
					        </div>
	      				</div>
	      				<div class="col m6 s12">
	      					<div>
	      					  <label>Level</label>
					          <select class="browser-default" v-model="level" required>
					          	<option value="" disabled selected>Level</option>
					          	<option value="1">Level 1</option>
					          	<option value="2">Level 2</option>
					          	<option value="3">Level 3</option>
					          </select>
					        </div>
	      				</div>
	      			</div>
	      			<div class="row">
	      				<div class="col m6 s12">
	      					<div class="input-field">
					          <input id="price" type="number" class="validate" v-model="price" placeholder="Price" required>
					          <label for="price" class="active">Price</label>
					        </div>
	      				</div>
	      				<div class="col m6 s12">
	      					<div class="file-field input-field">
						      <div class="btn btn-navy">
						        <span>Select Logo</span>
						        <input type="file" id="logoFile">
						      </div>
						      <div class="file-path-wrapper">
						        <input class="file-path validate" type="text" value ="Upload new logo">
						      </div>
						    </div>
	      				</div>
	      			</div>
	      			<div class="row">
	      				<div class="col m4 s12">
	      					<div class="input-field">
					          <input id="Year" type="text" class="validate" v-model="year" placeholder="Model Year">
					          <label for="Year">Year</label>
					        </div>
	      				</div>
	      				<div class="col m4 s12">
	      					<div class="input-field">
					          <input id="time" type="text" class="validate" v-model="time" placeholder="Request Time">
					          <label for="time">Time</label>
					        </div>
	      				</div>
	      				<div class="col m4 s12">
	      					<div class="input-field">
					          <input id="docs" type="text" class="validate" v-model="docs" placeholder="Docs: Separated by comma">
					          <label for="docs">Requirements</label>
					        </div>
	      				</div>
	      			</div>
	      			<div class="row">
	      				<div class="col m12">
	      					<div class="input-field">
					            <textarea id="remarks" class="materialize-textarea" v-model="remarks" placeholder="Remarks"></textarea>
					            <label for="remarks" class="active">Remarks</label>
					        </div>
	      				</div>
	      			</div>
	      			<p class="text-soviet"><b>{{message}}</b></p>
		      		
		      	</div>
		      </div>
		      <div class="row">
		      	<div class="col s12">
		      	   <a class="btn  btn-soviet left" @click="deleteCar">Delete</a>
   				   <button class="btn  btn-navy right" type="" @click="updateCar">Submit</button>
		      	</div>
		      </div>
		      <div class="row" style="margin-bottom: 0px">
			      	<div class="col s12">
			      		<div :style="'height: 5px; width: '+uploadBar+'%; background-color: green'"></div>
			      	</div>
			   </div>
		    </div>
		    
		    </form>
		</div>

		<div id="addCarModalAdmin" class="modal">
			<form @submit.prevent>
		    <div class="modal-content">
		    	<i class="material-icons right modal-action modal-close">close</i>
		      <h4 class="center-align">Make Information</h4>
		      <div class="row">
		      	<div class="col m12">
		      		
	      			<div class="row">
	      				<div class="col m6 s12">
	      					<div class="input-field">
					          <input id="make" type="text" class="validate" v-model="make" placeholder="Make" required>
					          <label for="make">Make</label>
					        </div>
	      				</div>
	      				<div class="col m6 s12">
	      					<div>
	      					  <label>Level</label>
					          <select class="browser-default" v-model="level" required>
					          	<option value="" disabled selected>Level</option>
					          	<option value="1">Level 1</option>
					          	<option value="2">Level 2</option>
					          	<option value="3">Level 3</option>
					          </select>
					        </div>
	      				</div>
	      			</div>
	      			<div class="row">
	      				<div class="col m6 s12">
	      					<div class="input-field">
					          <input id="price" type="number" class="validate" v-model="price" placeholder="Price" required>
					          <label for="price">Price</label>
					        </div>
	      				</div>
	      				<div class="col m6 s12">
	      					<div class="file-field input-field">
						      <div class="btn btn-navy">
						        <span>Select Logo</span>
						        <input type="file" id="logoFileAdd">
						      </div>
						      <div class="file-path-wrapper">
						        <input class="file-path validate" type="text" value ="Upload new logo">
						      </div>
						    </div>
	      				</div>
	      			</div>
	      			<div class="row">
	      				<div class="col m4 s12">
	      					<div class="input-field">
					          <input id="Year" type="text" class="validate" v-model="year" placeholder="Model Year">
					          <label for="Year">Year</label>
					        </div>
	      				</div>
	      				<div class="col m4 s12">
	      					<div class="input-field">
					          <input id="time" type="text" class="validate" v-model="time" placeholder="Request Time" >
					          <label for="time">Time</label>
					        </div>
	      				</div>
	      				<div class="col m4 s12">
	      					<div class="input-field">
					          <input id="docs" type="text" class="validate" v-model="docs" placeholder="Docs: separated by comma">
					          <label for="docs">Requirements</label>
					        </div>
	      				</div>
	      			</div>
	      			<div class="row">
	      				<div class="col m12">
	      					<div class="input-field">
					            <textarea id="remarks" class="materialize-textarea" v-model="remarks" placeholder="Remarks"></textarea>
					            <label for="remarks">Remarks</label>
					        </div>
	      				</div>
	      			</div>
	      			<p class="text-soviet"><b>{{message}}</b></p>
		      		
		      	</div>
		      </div>
		      <div class="row">
		      	<div class="col s12">
   				   <button class="btn  btn-navy right" type="submit" @click="addCar">Submit</button>
		      	</div>
		      </div>
		      <div class="row" style="margin-bottom: 0px">
			      	<div class="col s12">
			      		<div :style="'height: 5px; width: '+uploadBar+'%; background-color: green'"></div>
			      	</div>
			   </div>
		    </div>

		    </form>
		</div>
	</div>
</template>
<script>
	
	import axios from 'axios';
	import swal from 'sweetalert2';

	export default{

		mounted(){

			console.log('users mounted');
			this.getAllCars();
			$('#viewCarModalAdmin').modal({
		      dismissible: true
		    });
		    $('#addCarModalAdmin').modal({
		      dismissible: true
		    });

		},
		data(){

			return {

				carList: [],
				message: "",
				remarks: "",
				price: "",
				make: "",
				level: "",
				year: "",
				time: "",
				docs: "",
				carId: "",
				uploadBar: 0

			}

		},
		methods:{

			getAllCars(){

				axios.get('/cars')
				.then((response)=>{

					this.carList = response.data.cars;
					this.carList.forEach(function(car){

						if(car.year == null || car.year == "" || car.year == "null"){
							car.year = "N/A";
						}

						if(car.time == null || car.time == "" || car.year == "null"){
							car.time = "N/A";
						}

						if(car.docs == null || car.docs == "" || car.year == "null"){
							car.docs = "N/A";
						}
					});
					// console.log(this.carList);
				})
				.catch(()=>{

					console.log('error users');

				})

			},
			viewItem(index){

				this.remarks = this.carList[index].remarks;
				this.price = this.carList[index].price;
				this.make = this.carList[index].make;
				this.level = this.carList[index].level;
				this.year = this.carList[index].year;
				this.time = this.carList[index].time;
				this.docs = this.carList[index].docs;
				this.carId = this.carList[index].id;


				$('#viewCarModalAdmin').modal('open');

			},
			closeView(){

				$('#viewCarModalAdmin').modal('close');

			},
			updateCar(){

				if(this.price == "" || this.make == "" || this.level == ""){

					this.message = "Please fill in all necessary details";

				}
				else{

					var file 	 = document.getElementById('logoFile');
			    	var formData = new FormData();
			    	// console.log(file.files[0]);
			    	formData.append('file[0]', file.files[0]);
			    	formData.append('make', this.make);
			    	formData.append('level', this.level);
			    	formData.append('price', this.price);
		    		formData.append('year', this.year);	
		    		formData.append('time', this.time);	
		    		formData.append('docs', this.docs);	
			    	if(this.remarks != ""){

			    		formData.append('remarks', this.remarks);

			    	}
			    	else{

			    		formData.append('remarks', "");

			    	}

			    	axios.post('/editCar/'+this.carId, formData, {onUploadProgress: (event)=>{

			  			var percent = Math.round( (event.loaded * 100) / event.total );
			  			this.uploadBar = percent;
			  			console.log('update');

			  		}})
			    	.then((response)=>{
			    		
			    		this.uploadBar = 0;
			    		this.remarks = "";
						this.price = "";
						this.year = "";
						this.time = "";
						this.docs = "";
						this.make = "";
						this.level = "";
						this.carId = "";
			    		swal({
						  type: 'success',
						  title: 'Success...',
						  text: 'Make details successfully updated',
						});
			    		$('#logoFile').val("");
						$('#viewCarModalAdmin').modal('close');
						$('.file-path.validate').val("Upload new logo");
			    		this.getAllCars();

			    	})
			    	.catch(()=>{



			    	})

				}

			},
			addCar(){

				if(this.price == "" || this.make == "" || this.level == ""){

					this.message = "Please fill in all necessary details";

				}
				else{

					var file 	 = document.getElementById('logoFileAdd');
			    	var formData = new FormData();
			    	// console.log(file.files[0]);
			    	formData.append('file[0]', file.files[0]);
			    	formData.append('make', this.make);
			    	formData.append('level', this.level);
			    	formData.append('price', this.price);
			    	formData.append('year', this.year);	
		    		formData.append('time', this.time);	
		    		formData.append('docs', this.docs);	
			    	if(this.remarks != ""){

			    		formData.append('remarks', this.remarks);	

			    	}
			    	else{

			    		formData.append('remarks', "");

			    	}
			    	

			    	axios.post('/car/create', formData, {onUploadProgress: (event)=>{

			  			var percent = Math.round( (event.loaded * 100) / event.total );
			  			this.uploadBar = percent;
			  			console.log("added");

			  		}})
			    	.then((response)=>{
			    		// alert(response.data.status);
			    		this.uploadBar = 0;
			    		if(response.data.msg == 'error'){
			    			console.log(response.data.status);
				    		swal({
							  type: 'warning',
							  title: 'Failed!',
							  text: response.data.status,
							});
				    		
			    		}else{
			    			swal({
							  type: 'success',
							  title: 'Success...',
							  text: 'Make details successfully updated',
							});
			    		}
			    		$('#logoFile').val("");
						$('#addCarModalAdmin').modal('close');
						$('.file-path.validate').val("Upload new logo");
			    		this.getAllCars();

			    	})
			    	.catch(()=>{



			    	})

				}

			},
			deleteCar(){

				swal({
				  title: 'Are you sure you want to delete this item?',
				  text: "You won't be able to revert this!",
				  type: 'warning',
				  showCancelButton: true,
				  confirmButtonColor: '#3085d6',
				  cancelButtonColor: '#d33',
				  confirmButtonText: 'Yes'
				}).then((result) => {
				  if (result.value) {
				    axios.post('/deleteCar/'+this.carId)
					.then((response)=>{

						this.getAllCars();
						swal({
						  type: 'success',
						  title: 'Success...',
						  text: 'Make successfully deleted',
						});

						$('#viewCarModalAdmin').modal('close');

					})
					.catch(()=>{

						console.log('error delete car');

					})
				  }
				})

			},
			openAddCarModal(){

				this.uploadBar = 0;
	    		this.remarks = "";
				this.price = "";
				this.time = "";
				this.year = "";
				this.docs = "";
				this.make = "";
				this.level = "";
				this.carId = "";
		    	$('#logoFileAdd').val("");
				$('.file-path.validate').val("Upload new logo");
				$('#addCarModalAdmin').modal('open');

			}

		}

	}

</script>