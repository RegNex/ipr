<?php
/*
* To change this license header, choose License Headers in Project Properties.
* To change this template file, choose Tools | Templates
* and open the template in the editor.
*/
ob_start();
session_start();
if (isset($_SESSION['users']) != "") {
header("Location: index.php");
}
include_once 'dbConfig.php';
if (null !== (filter_input(INPUT_POST, 'signup'))) {
$v1 = rand(1111, 9999);
$v2 = rand(1111, 9999);

$v3 = $v1.$v2;
$v3= md5($v3);

$fnm = $_FILES["image"]["name"];
$dst = "./profile_images/".$v3.$fnm;
$dst1 = "profile_images/".$v3.$fnm;
move_uploaded_file($_FILES["image"]["tmp_name"], $dst);

$uname = filter_input(INPUT_POST, 'name');
$email = filter_input(INPUT_POST, 'email');
$upass = filter_input(INPUT_POST, 'pass');
$contact = filter_input(INPUT_POST, 'contact');
$dob = filter_input(INPUT_POST, 'dob');
$address = filter_input(INPUT_POST, 'address');
$work = filter_input(INPUT_POST, 'work');


// hash password with SHA256;
$password = hash('sha256', $upass);
// check email exist or not
$stmt = $conn->prepare("SELECT email FROM applicants WHERE email=?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();
$count = $result->num_rows;
if ($count == 0) { // if email is not found add user


$stmts = $conn->prepare("INSERT INTO applicants(pic,full_name,email,password,contact,dob,address,work) VALUES(?, ?, ?, ?, ?, ?, ?, ?)");
$stmts->bind_param("ssssisss",$dst1,$uname, $email,$password,$contact,$dob,$address,$work);
$res = $stmts->execute();//get result
$stmts->close();
$user_id = mysqli_insert_id($conn);

if ($user_id > 0) {
$_SESSION['users'] = $user_id; // set session and redirect to index page
if (isset($_SESSION['users'])) {
print_r($_SESSION);
header("Location: index.php");
exit;
}
} else {
$errTyp = "danger";
$errMSG = "Something went wrong, try again";
}
} else {
$errTyp = "warning";
$errMSG = "Email is already used";
}
}
?>
<!DOCTYPE html>
<html>
	<title>IPRA | Signup</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-blue-grey.css">
	<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Open+Sans'>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link class="jsbin" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />
	<script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
	<script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/jquery-ui.min.js"></script>
	<style>
	html,body,h1,h2,h3,h4,h5 {font-family: "Open Sans", sans-serif}
	</style>
	<body class="w3-theme-l5">
		<!-- Page Container -->
		<div class="w3-container w3-content" style="width:500px;margin-top:80px" align="center">
			<!-- The Grid -->
			<div class="w3-row w3-center" align="center">
				<!-- Left Column -->
				<!-- Profile -->
				
				
				<!-- Middle Column -->
				<div class="w3-col w3-center" >
					<div class="w3-card-2 w3-round w3-white">
						<div class="w3-container">
							<h4 class="w3-center">Registration</h4>
							
							<hr>
							
							
							<form method="post" enctype="multipart/form-data" autocomplete="off">
								<div class="w3-display-container">
									<p class="w3-center"><img id="blah" src="img/avatar3.png" class="w3-circle" style="height:100px;width:100px" alt="Avatar"></p>
									<input name="image" type="file" accept="image/jpg"  onchange="readURL(this);">
								</div>
								
								
								<div class="w3-row w3-section">
									<div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-users"></i></div>
									<div class="w3-rest">
										<input class="w3-input w3-border" name="name" type="text" placeholder="John Doe" required="true">
									</div>
								</div>
								
								<div class="w3-row w3-section">
									<div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-envelope-o"></i></div>
									<div class="w3-rest">
										<input class="w3-input w3-border" name="email" type="email" placeholder="example@domain.com" autocomplete="off" required="true">
									</div>
								</div>
								
								
								<div class="w3-row w3-section">
									<div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-lock"></i></div>
									<div class="w3-rest">
										<input class="w3-input w3-border" name="pass" type="text" placeholder="*********" required="true">
									</div>
								</div>
								
								<div class="w3-row w3-section">
									<div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-bars"></i></div>
									<div class="w3-rest">
										<input class="w3-input w3-border" name="contact" type="tel" placeholder="024xxxxxxx">
									</div>
								</div>
                                                            <div class="w3-row w3-section">
									<div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-birthday-cake"></i></div>
									<div class="w3-rest">
                                                                            <input class="w3-input w3-border" name="dob" type="date" placeholder="date">
									</div>
								</div>
								<div class="w3-row w3-section">
									<div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-home"></i></div>
									<div class="w3-rest">
										<input class="w3-input w3-border" name="address" type="text" placeholder="--Address--" required="true">
									</div>
								</div>
								
								<div class="w3-row w3-section">
									<div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-pencil"></i></div>
									<div class="w3-rest">
										<input class="w3-input w3-border" name="work" type="text" placeholder="--Work--" required="true">
									</div>
								</div>
								
								
								
								<?php
								if (isset($errMSG)) {
								?>
								<div class="w3-row w3-section">
									<div class="w3-panel w3-red w3-round-medium">
										<span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
									</div>
								</div>
								<?php
								}
								?>
								
								
								<button type="submit" class="w3-button w3-block w3-section w3-blue w3-ripple w3-padding" name="signup" id="reg">Register</button>
								
								<input class="w3-button w3-block w3-section w3-green w3-ripple w3-padding" type="button" onclick="location.href='login.php';" value="Already has an Account!" />
							</form>
						</div>
					</div>
					<br>
					
					
					<br>
					
					
					
					<script>
					//display image
					function readURL(input) {
					if (input.files && input.files[0]) {
					var reader = new FileReader();
					reader.onload = function (e) {
					$('#blah')
					.attr('src', e.target.result)
					.width(100)
					.height(100);
					};
					reader.readAsDataURL(input.files[0]);
					}
					}
					
                                        
                                   
					// Accordion
					function myFunction(id) {
					var x = document.getElementById(id);
					if (x.className.indexOf("w3-show") == -1) {
					x.className += " w3-show";
					x.previousElementSibling.className += " w3-theme-d1";
					} else {
					x.className = x.className.replace("w3-show", "");
					x.previousElementSibling.className =
					x.previousElementSibling.className.replace(" w3-theme-d1", "");
					}
					}
					// Used to toggle the menu on smaller screens when clicking on the menu button
					function openNav() {
					var x = document.getElementById("navDemo");
					if (x.className.indexOf("w3-show") == -1) {
					x.className += " w3-show";
					} else {
					x.className = x.className.replace(" w3-show", "");
					}
					}
					</script>
				</body>
			</html>