<?php 
ini_set('session.cache_limiter','public');
session_cache_limiter(false);
session_start();
include("config.php");
if(!isset($_SESSION['uemail']))
{
	header("location:login.php");
}

//// code insert
//// add code

$msg="";
if(isset($_POST['add']))
{
	$pid=$_REQUEST['id'];
	
	$title=$_POST['title'];
	$content=$_POST['content'];
	$ptype=$_POST['ptype'];
	$bhk=$_POST['bhk'];
	$bed=$_POST['bed'];
	$balc=$_POST['balc'];
	$hall=$_POST['hall'];
	$stype=$_POST['stype'];
	$bath=$_POST['bath'];
	$kitc=$_POST['kitc'];
	$floor=$_POST['floor'];
	$price=$_POST['price'];
	$city=$_POST['city'];
	$asize=$_POST['asize'];
	$loc=$_POST['loc'];
	$state=$_POST['state'];
	$status=$_POST['status'];
	$uid=$_SESSION['uid'];
	$feature=$_POST['feature'];
	
	$totalfloor=$_POST['totalfl'];
	
	// Helper function to get updated image name or keep old one
	function getUpdatedImage($inputName, $currentNameField) {
		if(isset($_FILES[$inputName]) && $_FILES[$inputName]['name'] != '') {
			return $_FILES[$inputName]['name'];
		} elseif(isset($_POST[$currentNameField])) {
			return $_POST[$currentNameField];
		}
		return '';
	}

	$aimage = getUpdatedImage('aimage', 'aimage_current');
	$aimage1 = getUpdatedImage('aimage1', 'aimage1_current');
	$aimage2 = getUpdatedImage('aimage2', 'aimage2_current');
	$aimage3 = getUpdatedImage('aimage3', 'aimage3_current');
	$aimage4 = getUpdatedImage('aimage4', 'aimage4_current');
	$fimage = getUpdatedImage('fimage', 'fimage_current');
	$fimage1 = getUpdatedImage('fimage1', 'fimage1_current');
	$fimage2 = getUpdatedImage('fimage2', 'fimage2_current');

	// Move uploaded files if new file is uploaded
	if(isset($_FILES['aimage']) && $_FILES['aimage']['name'] != '') {
		move_uploaded_file($_FILES['aimage']['tmp_name'], "admin/property/$aimage");
	}
	if(isset($_FILES['aimage1']) && $_FILES['aimage1']['name'] != '') {
		move_uploaded_file($_FILES['aimage1']['tmp_name'], "admin/property/$aimage1");
	}
	if(isset($_FILES['aimage2']) && $_FILES['aimage2']['name'] != '') {
		move_uploaded_file($_FILES['aimage2']['tmp_name'], "admin/property/$aimage2");
	}
	if(isset($_FILES['aimage3']) && $_FILES['aimage3']['name'] != '') {
		move_uploaded_file($_FILES['aimage3']['tmp_name'], "admin/property/$aimage3");
	}
	if(isset($_FILES['aimage4']) && $_FILES['aimage4']['name'] != '') {
		move_uploaded_file($_FILES['aimage4']['tmp_name'], "admin/property/$aimage4");
	}
	if(isset($_FILES['fimage']) && $_FILES['fimage']['name'] != '') {
		move_uploaded_file($_FILES['fimage']['tmp_name'], "admin/property/$fimage");
	}
	if(isset($_FILES['fimage1']) && $_FILES['fimage1']['name'] != '') {
		move_uploaded_file($_FILES['fimage1']['tmp_name'], "admin/property/$fimage1");
	}
	if(isset($_FILES['fimage2']) && $_FILES['fimage2']['name'] != '') {
		move_uploaded_file($_FILES['fimage2']['tmp_name'], "admin/property/$fimage2");
	}
	
	
	$sql = "UPDATE property SET title= '{$title}', pcontent= '{$content}', type='{$ptype}', bhk='{$bhk}', stype='{$stype}',
	bedroom='{$bed}', bathroom='{$bath}', balcony='{$balc}', kitchen='{$kitc}', hall='{$hall}', floor='{$floor}', 
	size='{$asize}', price='{$price}', location='{$loc}', city='{$city}', state='{$state}', feature='{$feature}',
	pimage='{$aimage}', pimage1='{$aimage1}', pimage2='{$aimage2}', pimage3='{$aimage3}', pimage4='{$aimage4}',
	uid='{$uid}', status='{$status}', mapimage='{$fimage}', topmapimage='{$fimage1}', groundmapimage='{$fimage2}', 
	totalfloor='{$totalfloor}' WHERE pid = {$pid}";
	
	$result=mysqli_query($con,$sql);
	if($result == true)
	{
		$msg="<p class='alert alert-success'>Property Updated</p>";
		header("Location:feature.php?msg=$msg");
	}
	else{
		$msg="<p class='alert alert-warning'>Property Not Updated</p>";
		header("Location:feature.php?msg=$msg");
	}
}						
?>
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

<!--	Fonts
	========================================================-->
<link href="https://fonts.googleapis.com/css?family=Muli:400,400i,500,600,700&amp;display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Comfortaa:400,700" rel="stylesheet">

<!--	Css Link
	========================================================-->
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

<!--	Title
	=========================================================-->
<title>Real Estate PHP</title>
</head>
<body>

<!--	Page Loader
=============================================================
<div class="page-loader position-fixed z-index-9999 w-100 bg-white vh-100">
	<div class="d-flex justify-content-center y-middle position-relative">
	  <div class="spinner-border" role="status">
		<span class="sr-only">Loading...</span>
	  </div>
	</div>
</div>
--> 



    <div class="row"> 
        <!--	Header start  -->
		<?php include("include/header.php");?>
        <!--	Header end  -->
        
        <!--	Banner   --->
        <!-- <div class="banner-full-row page-banner" style="background-image:url('images/breadcromb.jpg');">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <h2 class="page-name float-left text-white text-uppercase mt-1 mb-0"><b>Update Property</b></h2>
                    </div>
                    <div class="col-md-6">
                        <nav aria-label="breadcrumb" class="float-left float-md-right">
                            <ol class="breadcrumb bg-transparent m-0 p-0">
                                <li class="breadcrumb-item text-white"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Update Property</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div> -->
         <!--	Banner   --->
		 
		 
		<!--	Submit property   -->
        <div class="full-row">
            <div class="container">
                    <div class="row">
						<div class="col-lg-12">
							<h2 class="text-secondary double-down-line text-center">Update Property</h2>
                        </div>
					</div>
                    <div class="row p-5">
                        <form method="post" enctype="multipart/form-data">
								
								<?php
									
									$pid=$_REQUEST['id'];
									$query=mysqli_query($con,"select * from property where pid='$pid'");
									while($row=mysqli_fetch_row($query))
									{
								?>
												
								<div class="description">
									<h5 class="text-secondary">Basic Information</h5><hr>
										<div class="row">
											<div class="col-xl-12">
												<div class="form-group row">
													<label class="col-lg-2 col-form-label">Title</label>
													<div class="col-lg-9">
														<input type="text" class="form-control" name="title" required value="<?php echo $row['1']; ?>">
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-2 col-form-label">Content</label>
													<div class="col-lg-9">
														<textarea class="tinymce form-control" name="content" rows="10" cols="30"><?php echo strip_tags(htmlspecialchars_decode($row['2']));?></textarea>
													</div>
												</div>
												
											</div>
											<div class="col-xl-6">
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Property Type</label>
													<div class="col-lg-9">
														<select class="form-control" required name="ptype" >
															<option value="">Select Type</option>
															<option value="apartment" <?php if($row['3']=='apartment') echo 'selected'; ?>>Apartment</option>
															<option value="flat" <?php if($row['3']=='flat') echo 'selected'; ?>>Flat</option>
															<option value="building" <?php if($row['3']=='building') echo 'selected'; ?>>Building</option>
															<option value="house" <?php if($row['3']=='house') echo 'selected'; ?>>House</option>
															<option value="villa" <?php if($row['3']=='villa') echo 'selected'; ?>>Villa</option>
															<option value="office" <?php if($row['3']=='office') echo 'selected'; ?>>Office</option>
														</select>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Selling Type</label>
													<div class="col-lg-9">
														<select class="form-control" required name="stype">
															<option value="">Select Status</option>
															<option value="rent" <?php if($row['5']=='rent') echo 'selected'; ?>>Rent</option>
															<option value="sale" <?php if($row['5']=='sale') echo 'selected'; ?>>Sale</option>
														</select>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Bathroom</label>
													<div class="col-lg-9">
														<input type="text" class="form-control" name="bath" required value="<?php echo $row['7']; ?>">
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Kitchen</label>
													<div class="col-lg-9">
														<input type="text" class="form-control" name="kitc" required value="<?php echo $row['9']; ?>">
													</div>
												</div>
												
											</div>   
											<div class="col-xl-6">
												<div class="form-group row mb-3">
													<label class="col-lg-3 col-form-label">BHK</label>
													<div class="col-lg-9">
														<select class="form-control" required name="bhk">
															<option value="">Select BHK</option>
															<option value="1 BHK" <?php if($row['4']=='1 BHK') echo 'selected'; ?>>1 BHK</option>
															<option value="2 BHK" <?php if($row['4']=='2 BHK') echo 'selected'; ?>>2 BHK</option>
															<option value="3 BHK" <?php if($row['4']=='3 BHK') echo 'selected'; ?>>3 BHK</option>
															<option value="4 BHK" <?php if($row['4']=='4 BHK') echo 'selected'; ?>>4 BHK</option>
															<option value="5 BHK" <?php if($row['4']=='5 BHK') echo 'selected'; ?>>5 BHK</option>
															<option value="1,2 BHK" <?php if($row['4']=='1,2 BHK') echo 'selected'; ?>>1,2 BHK</option>
															<option value="2,3 BHK" <?php if($row['4']=='2,3 BHK') echo 'selected'; ?>>2,3 BHK</option>
															<option value="2,3,4 BHK" <?php if($row['4']=='2,3,4 BHK') echo 'selected'; ?>>2,3,4 BHK</option>
														</select>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Bedroom</label>
													<div class="col-lg-9">
														<input type="text" class="form-control" name="bed" required value="<?php echo $row['6']; ?>">
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Balcony</label>
													<div class="col-lg-9">
														<input type="text" class="form-control" name="balc" required value="<?php echo $row['8']; ?>">
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Hall</label>
													<div class="col-lg-9">
														<input type="text" class="form-control" name="hall" required value="<?php echo $row['10']; ?>">
													</div>
												</div>
												
											</div>
										</div>
										<h5 class="text-secondary">Price & Location</h5><hr>
										<div class="row">
											<div class="col-xl-6">
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Floor</label>
													<div class="col-lg-9">
														<select class="form-control" required name="floor">
															<option value="">Select Floor</option>
															<option value="1st Floor" <?php if($row['11']=='1st Floor') echo 'selected'; ?>>1st Floor</option>
															<option value="2nd Floor" <?php if($row['11']=='2nd Floor') echo 'selected'; ?>>2nd Floor</option>
															<option value="3rd Floor" <?php if($row['11']=='3rd Floor') echo 'selected'; ?>>3rd Floor</option>
															<option value="4th Floor" <?php if($row['11']=='4th Floor') echo 'selected'; ?>>4th Floor</option>
															<option value="5th Floor" <?php if($row['11']=='5th Floor') echo 'selected'; ?>>5th Floor</option>
														</select>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Price</label>
													<div class="col-lg-9">
														<input type="text" class="form-control" name="price" required value="<?php echo $row['13']; ?>">
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">City</label>
													<div class="col-lg-9">
														<input type="text" class="form-control" name="city" required value="<?php echo $row['15']; ?>">
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">State</label>
													<div class="col-lg-9">
														<input type="text" class="form-control" name="state" required value="<?php echo $row['16']; ?>">
													</div>
												</div>
											</div>
											<div class="col-xl-6">
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Total Floor</label>
													<div class="col-lg-9">
														<select class="form-control" required name="totalfl">
															<option value="">Select Floor</option>
															<option value="1 Floor" <?php if($row['28']=='1 Floor') echo 'selected'; ?>>1 Floor</option>
															<option value="2 Floor" <?php if($row['28']=='2 Floor') echo 'selected'; ?>>2 Floor</option>
															<option value="3 Floor" <?php if($row['28']=='3 Floor') echo 'selected'; ?>>3 Floor</option>
															<option value="4 Floor" <?php if($row['28']=='4 Floor') echo 'selected'; ?>>4 Floor</option>
															<option value="5 Floor" <?php if($row['28']=='5 Floor') echo 'selected'; ?>>5 Floor</option>
															<option value="6 Floor" <?php if($row['28']=='6 Floor') echo 'selected'; ?>>6 Floor</option>
															<option value="7 Floor" <?php if($row['28']=='7 Floor') echo 'selected'; ?>>7 Floor</option>
															<option value="8 Floor" <?php if($row['28']=='8 Floor') echo 'selected'; ?>>8 Floor</option>
															<option value="9 Floor" <?php if($row['28']=='9 Floor') echo 'selected'; ?>>9 Floor</option>
															<option value="10 Floor" <?php if($row['28']=='10 Floor') echo 'selected'; ?>>10 Floor</option>
															<option value="11 Floor" <?php if($row['28']=='11 Floor') echo 'selected'; ?>>11 Floor</option>
															<option value="12 Floor" <?php if($row['28']=='12 Floor') echo 'selected'; ?>>12 Floor</option>
															<option value="13 Floor" <?php if($row['28']=='13 Floor') echo 'selected'; ?>>13 Floor</option>
															<option value="14 Floor" <?php if($row['28']=='14 Floor') echo 'selected'; ?>>14 Floor</option>
															<option value="15 Floor" <?php if($row['28']=='15 Floor') echo 'selected'; ?>>15 Floor</option>
														</select>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Area Size</label>
													<div class="col-lg-9">
														<input type="text" class="form-control" name="asize" required value="<?php echo $row['12']; ?>">
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Address</label>
													<div class="col-lg-9">
														<input type="text" class="form-control" name="loc" required value="<?php echo $row['14']; ?>">
													</div>
												</div>
												
											</div>
										</div>
										
										<?php

?>

<div class="form-group row">
    <label class="col-lg-2 col-form-label">Fonctionnalité (texte brut)</label>
    <div class="col-lg-9">
       
        <div class="form-control" style="height:auto; white-space:pre-line;">
		<textarea class="tinymce form-control" name="content" rows="10" cols="30"><?php echo strip_tags(htmlspecialchars_decode($row['17'])); ?></textarea>
        </div>
    </div>
</div>



<h5 class="text-secondary">Image & Status</h5>
<hr>
<div class="row">
    <div class="col-xl-6">
        <div class="form-group row">
            <label class="col-lg-3 col-form-label">Image</label>
            <div class="col-lg-9">
                <input class="form-control" name="aimage" type="file">
                <input type="hidden" name="aimage_current" value="<?php echo $row['18']; ?>">
                <img src="admin/property/<?php echo $row['18']; ?>" alt="Image" height="150" width="180">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-lg-3 col-form-label">Image 2</label>
            <div class="col-lg-9">
                <input class="form-control" name="aimage2" type="file">
                <input type="hidden" name="aimage2_current" value="<?php echo $row['20']; ?>">
                <img src="admin/property/<?php echo $row['20']; ?>" alt="Image 2" height="150" width="180">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-lg-3 col-form-label">Image 4</label>
            <div class="col-lg-9">
                <input class="form-control" name="aimage4" type="file">
                <input type="hidden" name="aimage4_current" value="<?php echo $row['22']; ?>">
                <img src="admin/property/<?php echo $row['22']; ?>" alt="Image 4" height="150" width="180">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-lg-3 col-form-label">Status</label>
            <div class="col-lg-9">
                <select class="form-control" required name="status">
                    <option value="">Select Status</option>
                    <option value="available" <?php if($row[24] == 'available') echo 'selected'; ?>>Available</option>
                    <option value="sold out" <?php if($row[24] == 'sold out') echo 'selected'; ?>>Sold Out</option>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-lg-3 col-form-label">Basement Floor Plan Image</label>
            <div class="col-lg-9">
                <input class="form-control" name="fimage1" type="file">
                <input type="hidden" name="fimage1_current" value="<?php echo $row['26']; ?>">
                <img src="admin/property/<?php echo $row['26']; ?>" alt="Basement Plan" height="150" width="180">
            </div>
        </div>
    </div>

    <div class="col-xl-6">
        <div class="form-group row">
            <label class="col-lg-3 col-form-label">Image 1</label>
            <div class="col-lg-9">
                <input class="form-control" name="aimage1" type="file">
                <input type="hidden" name="aimage1_current" value="<?php echo $row['19']; ?>">
                <img src="admin/property/<?php echo $row['19']; ?>" alt="Image 1" height="150" width="180">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-lg-3 col-form-label">Image 3</label>
            <div class="col-lg-9">
                <input class="form-control" name="aimage3" type="file">
                <input type="hidden" name="aimage3_current" value="<?php echo $row['21']; ?>">
                <img src="admin/property/<?php echo $row['21']; ?>" alt="Image 3" height="150" width="180">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-lg-3 col-form-label">Floor Plan Image</label>
            <div class="col-lg-9">
                <input class="form-control" name="fimage" type="file">
                <input type="hidden" name="fimage_current" value="<?php echo $row['25']; ?>">
                <img src="admin/property/<?php echo $row['25']; ?>" alt="Floor Plan" height="150" width="180">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-lg-3 col-form-label">Ground Floor Plan Image</label>
            <div class="col-lg-9">
                <input class="form-control" name="fimage2" type="file">
                <input type="hidden" name="fimage2_current" value="<?php echo $row['27']; ?>">
                <img src="admin/property/<?php echo $row['27']; ?>" alt="Ground Floor Plan" height="150" width="180">
            </div>
        </div>
    </div>
</div>


										
											<input type="submit" value="Submit" class="btn btn-success"name="add" style="margin-left:200px;">
										
									</div>
								</form>
								
							<?php
								} 
							?>
                    </div>            
            </div>
        </div>
	<!--	Submit property   -->
        
     
        <!--	Footer   start-->
		<?php include("include/footer.php");?>
		<!--	Footer   start-->
        
        <!-- Scroll to top --> 
        <a href="#" class="bg-secondary text-white hover-text-secondary" id="scroll"><i class="fas fa-angle-up"></i></a> 
        <!-- End Scroll To top --> 
    </div>
</div>
<!-- Wrapper End --> 

<!--	Js Link
============================================================--> 
<script src="js/jquery.min.js"></script> 
<script src="js/tinymce/tinymce.min.js"></script>
<script src="js/tinymce/init-tinymce.min.js"></script>
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