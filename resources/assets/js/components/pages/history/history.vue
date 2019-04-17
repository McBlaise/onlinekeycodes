<template>
	<div class="container">
		<div class="row">
			<div class="col m12 s12">
				<div class="card">
					<div class="card-content">
						<div class="row">
							<div class="col s8 m6">
								<!-- <button class="btn btn-submarine left" @click="change">Upgrade History</button> -->
							</div>
							<div class="col s4 m6">
								<button class="btn btn-submarine right" @click="refreshHistory">Refresh</button>
							</div>
						</div>
						<div class="row">
							<div class="col s12">
								<h4 class="center-align">
									Transaction History
								</h4>
							</div>
						</div>
						<!-- <div class="row">
							<div class="col m4 s12 offset-m4">
								<input type="text" class="datepicker" placeholder="Transaction Date">
							</div>
						</div> -->
						<div class="row" >
							<div class="col m10 offset-m1 s12">
								<div class="row">
									<div class="col s12">
										<table class="bordered">
											<thead>
												<th>Date</th>
												<th>Make</th>
												<th>VIN</th>
												<th >Remarks</th>
											</thead>
											<tbody>
												<tr v-for="(item, index) of historyList">
													
													<td>{{item.created_at}}</td>
													<td>{{item.make}}</td>
													<td>{{item.vin}}</td>
													<td style="max-width: 250px">{{item.remarks}}</td>
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
		</div>
	</div>
</template>
<script>

	import axios from 'axios';
	
	export default{

		mounted(){

			console.log('history mounted');
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

			this.getHistory();
			setInterval(()=>{
				this.getHistory();
			}, 3000);

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

				historyList: []

			}

		},
		methods:{

			getHistory(){

				axios.get('/locksmith/history')
				.then((response)=>{

					console.log(response.data.history);
					this.historyList = response.data.history;

				})
				.catch(()=>{

					console.log('error history');

				});

			},
			getUpgradeHistory(){

				axios.get('/')
				.then((response)=>{

				})
				.catch(()=>{
					
				});

			},
			refreshHistory(){
				
				console.log("refreshed...");
				this.getHistory();

			},
			change(){

			}

		}

	}

</script>
<style scoped>
	date-picker{

		width: 100%;

	}
</style>