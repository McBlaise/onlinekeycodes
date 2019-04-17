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
						<span class="card-title center-align">Welcome to Online Keycodes</span>
					</div>
					<div class="card-action">
						<p>Hi {{ $locksmith->firstname }},</p>
						<p style="text-align: justify">Thank You fo choosing online keycodes,
						You will be able to access your account by clicking the verify button bellow. Feel free to send us an email if you have any questions.
						Click button to verify!</p>
						<form target="_blank" action="https://onlinekeycodes.com/verify" method="GET">
							<input type="hidden" name="id" value="{{ $locksmith->id }}">
							<input type="hidden" name="vcode" value="{{ $locksmith->vcode }}">
							<button class="right btn waves-effect waves-light btn-large" type="submit">Verify Email
							</button>
						</form>
					</div>
				</div>
				<br>
				<br>
				<div class="card">
					<div class="card-content teal lighten-2">
						<span class="left-align">If this is not yours, pls ignore this email!</span>
						<a class="right-align" href="" style='color: white'>@Onlinekeycodes</a>
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