<!DOCTYPE html>
<html>
	<head>
		
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css">
		
	</head>
	<body>
	<div class="container">
		<div class="row">
			<div class="col s12 m8">
				<div class="card">
					<div class="card-content teal lighten-2">
						<br>
						<span class="card-title center-align">Online Keycodes
						</span>
					</div>
					<div class="card-action">
						<h5 style="text-align: left">Account Upgrade</h5>
						<p>Hi {{ $locksmith->firstname }},</p>
						<p style="text-align: justify">You account upgrade request has been {{ $status }}.<br>
						<br>
						The result for the upgrade is as follows:
						</p>
						<span>
							<p>Results</p>
							<h4>{{ $remarks }}</h4>
						</span>
						<form target="_blank" action="https://onlinekeycodes.com" method="GET">
							<button class="right btn waves-effect waves-light btn-large" type="submit">Back to Onlinekeycodes
							</button>
						</form>
					</div>
				</div>
				<br>
				<br>
				<div class="card">
					<div class="card-content teal lighten-2">
						<span class="left-align">If you dont remember, pls secure your account by logging in and changing your password</span>
						<a class="right-align" href="https://onlinekeycodes.com" style='color: white'>@Onlinekeycodes</a>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>
	</body>

</html>

<style>
	body{
		font-family: monospace;
	}

	.card-title{
		font-size: 40px !important;
	}
	.verify{
		font-size: 50px !important;
	}
</style>