<?php
include("config.php");
session_start(); // Démarrer la session pour la connexion automatique
$error = "";
$msg = "";

if (isset($_REQUEST['reg'])) {
	$name = $_REQUEST['name'];
	$email = $_REQUEST['email'];
	$phone = $_REQUEST['phone'];
	$pass = $_REQUEST['pass'];
	$utype = $_REQUEST['utype'];

	// Vérifier si une image est téléchargée, sinon définir une image par défaut
	$uimage = $_FILES['uimage']['name'];
	$temp_name1 = $_FILES['uimage']['tmp_name'];

	if (empty($uimage)) {
		$uimage = 'admin/user/user-profile-min.png'; // Nom de l'image par défaut
	}

	// Hachage du mot de passe
	$pass_hashed = sha1($pass);

	// Utiliser une déclaration préparée pour éviter les injections SQL
	$query = "SELECT * FROM user WHERE uemail = ?";
	$stmt = $con->prepare($query);
	$stmt->bind_param("s", $email);
	$stmt->execute();
	$res = $stmt->get_result();
	$num = $res->num_rows;

	if ($num == 1) {
		$error = "<p class='alert alert-warning'>Email Id already Exist</p>";
	} else {
		if (!empty($name) && !empty($email) && !empty($phone) && !empty($pass)) {
			// Insertion de l'utilisateur dans la base de données
			$sql = "INSERT INTO user (uname, uemail, uphone, upass, utype, uimage) VALUES (?, ?, ?, ?, ?, ?)";
			$stmt = $con->prepare($sql);
			$stmt->bind_param("ssssss", $name, $email, $phone, $pass_hashed, $utype, $uimage);

			if ($stmt->execute()) {
				// Déplacer le fichier téléchargé ou utiliser l'image par défaut
				if (!empty($_FILES['uimage']['name'])) {
					move_uploaded_file($temp_name1, "admin/user/$uimage");
				}
				
				// CONNEXION AUTOMATIQUE APRÈS INSCRIPTION
				// Récupérer l'ID de l'utilisateur nouvellement créé
				$user_id = $con->insert_id;
				
				// Créer les variables de session pour connecter automatiquement l'utilisateur
				$_SESSION['uid'] = $user_id;
				$_SESSION['uemail'] = $email;
				$_SESSION['uname'] = $name;
				$_SESSION['utype'] = $utype;
				$_SESSION['uimage'] = $uimage;
				
				// Message de succès avec redirection automatique
				$msg = "<p class='alert alert-success'>Registration Successful! You are now logged in. Redirecting...</p>";
				
				// Redirection automatique après 2 secondes
				echo "<script>
					setTimeout(function() {
						";
				
				// Rediriger selon le type d'utilisateur
				if ($utype == 'admin') {
					echo "window.location.href = 'admin/index.php';";
				} elseif ($utype == 'agent') {
					echo "window.location.href = 'index.php';";
				} else {
					echo "window.location.href = 'index.php';"; // Pour les utilisateurs normaux
				}
				
				echo "
					}, 2000);
				</script>";
				
			} else {
				$error = "<p class='alert alert-warning'>Register Not Successfully</p>";
			}
		} else {
			$error = "<p class='alert alert-warning'>Please Fill all the fields</p>";
		}
	}
}
?>
<style>
	 @media (max-width: 576px) {
    .form-control, .btn {
        font-size: 14px;
    }
    /* Force l'affichage et le style */
button[name="reg"] {
  display: block !important;
  background-color: #28a745 !important;
  color: white !important;
  padding: 0.5rem 1rem !important;
  border: none !important;
  border-radius: 0.25rem !important;
 
}
}
</style>


<!DOCTYPE html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Meta Tags -->
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="shortcut icon" href="images/favicon.ico">

	<!--	Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Muli:400,400i,500,600,700&amp;display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Comfortaa:400,700" rel="stylesheet">

	<!--	Css Link -->
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap-slider.css">
	<link rel="stylesheet" type="text/css" href="css/jquery-ui.css">
	<link rel="stylesheet" type="text/css" href="css/layerslider.css">
	<link rel="stylesheet" type="text/css" href="css/color.css">
	<link rel="stylesheet" type="text/css" href="css/owl.carousel.min.css">
	<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="fonts/flaticon/flaticon.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/login.css">
	<link rel="stylesheet" type="text/css" href="css/styledarkmode.css">
	<script type="text/javascript" src="dark.js" defer></script>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

	<!--	Title -->
	<title>Real Estate PHP</title>
</head>

<body>

	<div class="row">
		<!--	Header start  -->
		<?php include("include/header.php"); ?>
		<!--	Header end  -->

		<div class="page-wrappers login-body full-row ">
			<div class="login-wrapper">
				<div class="container">
					<div class="loginbox">
						<div class="login-right">
							<div class="login-right-wrap">
								<h1 class="text-success ">Register</h1>
								<p class="account-subtitle">Access to our dashboard</p>
								<?php echo $error; ?>
								<?php echo $msg; ?>
								
								<!-- Form -->
								<form method="post" enctype="multipart/form-data">
									<div class="form-group">
										<input type="text" name="name" class="form-control"
											placeholder="Your Name*" required>
									</div>
									<div class="form-group">
										<input type="email" name="email" class="form-control"
											placeholder="Your Email*" required>
									</div>
									<div class="form-group">
										<input type="text" name="phone" class="form-control"
											placeholder="Your Phone*" maxlength="10" required>
									</div>
									<div class="form-group">
										<input type="password" name="pass" class="form-control"
											placeholder="Your Password*" required>
									</div>

									<div class="form-check-inline">
										<label class="form-check-label text-success">
											<input type="radio" class="form-check-input " name="utype" value="user"
												checked>User
										</label>
									</div>
									<div class="form-check-inline">
										<label class="form-check-label text-success">
											<input type="radio" class="form-check-input  " name="utype"
												value="agent">Agent
										</label>
									</div>

									<div class="form-group">
										<label class="col-form-label text-dark"><b>User Image</b></label>
										<input class="form-control" name="uimage" type="file" accept="image/*">
									</div>
									
									<div class="d-flex justify-content-center"  style="overflow: visible;">
										<button    class="btn btn-success w-100 py-2" name="reg" value="Register" type="submit" 
         
            style="background-color: #28a745; color: white;">Register</button>
									</div>
								</form>

								<div class="login-or">
									<span class="or-line"></span>
									<span class="span-or">or</span>
								</div>

								<div class="text-center dont-have">Already have an account? <a
										href="login.php">Login</a></div>

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Loading overlay pour la redirection -->
	<div id="loadingOverlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999;">
		<div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: white; text-align: center;">
			<div class="spinner-border text-success" role="status">
				<span class="sr-only">Loading...</span>
			</div>
			<p class="mt-3">Redirecting to dashboard...</p>
		</div>
	</div>

	<script>
		// Afficher l'overlay de chargement lors de la redirection
		document.addEventListener('DOMContentLoaded', function() {
			<?php if(!empty($msg) && strpos($msg, 'Redirecting') !== false): ?>
				document.getElementById('loadingOverlay').style.display = 'block';
			<?php endif; ?>
		});
	</script>

</body>
</html>


			<!--	Footer   start-->
			<?php include("include/footer.php"); ?>
			<!--	Footer   start-->

			<!-- Scroll to top -->
			<a href="#" class="bg-secondary text-white hover-text-secondary" id="scroll"><i
					class="fas fa-angle-up"></i></a>
			<!-- End Scroll To top -->
		</div>
	</div>
	<!-- Wrapper End -->
	
	<!--	Js Link
============================================================-->
	<script src="js/jquery.min.js"></script>
	<!--jQuery Layer Slider -->
	<script src="js/greensock.js"></script>
	<script src="js/layerslider.transitions.js"></script>
	<script src="js/layerslider.kreaturamedia.jquery.js"></script>
	<!--jQuery Layer Slider -->
	<script src="js/popper.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/owl.carousel.min.js"></script>
	<script src="js/tmpl.js"></script>
	<script src="js/jquery.dependClass-0.1.js"></script>
	<script src="js/draggable-0.1.js"></script>
	<script src="js/jquery.slider.js"></script>
	<script src="js/wow.js"></script>
	<script src="js/custom.js"></script>
</body>

</html>