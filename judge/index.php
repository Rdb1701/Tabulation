<!DOCTYPE html>
<html lang="en">

<head>

	<title>Tabulation System</title>

	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="icon" type="image/png" href="assets/images/sfxc.png" />

	<link rel="stylesheet" type="text/css" href="assets/vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="assets/css/util.css">
	<link rel="stylesheet" type="text/css" href="assets/css/main.css">
	<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"> -->
	<link rel="stylesheet" href="../admin/assets/fontawesome/css/all.min.css" />

</head>

<body>

	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100 p-l-40 p-r-40 p-t-45 p-b-45">
				<form id="form" class="login100-form validate-form flex-sb flex-w">
				<!-- <img src="assets/images/asscat.jpeg" alt="" width="100%"> -->
					<span class="login100-form-title p-b-32 text-center">
						Tabulation System
					</span>
					<span id="error1" style="color: red;"></span>
					<div class="wrap-input100 validate-input m-b-20" data-validate="Username is required">
						<input class="input100" type="text" name="username" id="username" placeholder="Username">
						<span class="focus-input100"></span>
					</div>
					
					
					<div class="wrap-input100 validate-input m-b-32" data-validate="Password is required">
						<span class="btn-show-pass">
							<i class="fa fa-eye" aria-hidden="true" id="eye" onclick="showpass()"></i>
						</span>
						
						<input class="input100" type="password" name="password" id="password" autocomplete="off" placeholder="Password">
						<span class="focus-input100"></span>
					</div>

					<div class="container-login100-form-btn">
						<button type="submit" class="login100-form-btn w-100" id="signinbtn">Login</button>
					</div>

				</form>
			</div>
		</div>
	</div>


	<script src="assets/vendor/jquery/jquery-3.2.1.min.js"></script>

	<script>
		let state = false;
		function showpass(){
			
			if(state){
				document.getElementById('password').type="text";
				document.getElementById('eye').style.color="blue";
			 state = false;
			}else{
				document.getElementById('password').type="password";
				document.getElementById('eye').style.color="green";
				state = true;
			}
		
		}

		$(document).ready(function() {

			// SIGN IN AJAX REQUEST
			$('#signinbtn').on("click", function (e) {
				e.preventDefault();


				$.ajax({
						type: "POST",
						url: "includes/judge_signin",
						dataType: 'JSON',
						data: $('#form').serialize(),
					})

					.done(function (response) {

						if (response.res_success == 1) {

							window.location = 'modules/dashboard';
							
						} else {
							console.log(response.res_message);
							$('#error1').text(response.res_message[0]);

						}
					})


			});
		})


		// function authenticate() 
		// {

		// 	let username = $('#username').val();
		// 	let password = $('#password').val();

		// 	if (username == '') {
		// 		alert('Enter Username!');
		// 	} else if (password == '') {
		// 		alert('Enter Password!');
		// 	} else {
		// 		$.ajax({
		// 			url 				: 'includes/login.php',
		// 			type 				: 'POST',
		// 			data 				: {
		// 				username 	: username, 
		// 				password 	: password
		// 			},
		// 			dataType 		: 'JSON',
		// 			beforeSend 	: function() {

		// 			}
		// 		}).done(function(res) {
		// 			console.log(res);

		// 			if (res.res_success == 1) {
		// 				window.location.href = 'modules/dashboard/list.php';
		// 			} else {
		// 				alert(res.res_message)
		// 			}

		// 		}).fail(function() {
		// 			console.log('Fail!');
		// 		});
		// 	}

		// }

		// $(document).ready(function() {

		// 	// auto run
		// 	$('#username').focus();

		// 	// form submit
		// 	$('#form').submit(function(e) {
		// 		e.preventDefault();
		// 		authenticate()
		// 	});

		// });
	</script>

</body>

</html>