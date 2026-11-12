<?php
session_start();
require("config.php");
////code
 
if(!isset($_SESSION['auser']))
{
	header("location:index.php");
}

$error="";
$msg="";
if(isset($_POST['add']))
{
	$title=$_POST['title'];
	$content=$_POST['content'];
	$ptype=$_POST['ptype'];
	$stype=$_POST['stype'];
	$bed=$_POST['bed'];
	$price=$_POST['price'];
	$city=$_POST['city'];
	$asize=$_POST['asize'];
	$loc=$_POST['loc'];
	$state=$_POST['state'];
	$status=$_POST['status'];
	$uid=$_POST['uid'];
	$isFeatured=$_POST['isFeatured'];

	$aimage='';
	if(isset($_FILES['aimage']) && $_FILES['aimage']['error']==UPLOAD_ERR_OK && !empty($_FILES['aimage']['name']))
	{
		$aimage=basename($_FILES['aimage']['name']);
		$aimage=preg_replace('/[^A-Za-z0-9._-]/','_',$aimage);
		$aimage=uniqid().'_'.$aimage;

		$uploadDir=__DIR__.'/property/';
		if(!is_dir($uploadDir))
		{
			mkdir($uploadDir,0777,true);
		}

		if(!move_uploaded_file($_FILES['aimage']['tmp_name'],$uploadDir.$aimage))
		{
			$error="<p class='alert alert-warning'>Image upload failed. Please check that the admin/property folder is writable and try again.</p>";
		}
	}
	else
	{
		$error="<p class='alert alert-warning'>Please select a valid image to upload.</p>";
	}

	if($error=="")
	{
		$sql="INSERT INTO property (title,pcontent,type,bhk,stype,bedroom,bathroom,balcony,kitchen,hall,floor,size,price,location,city,state,feature,pimage,pimage1,pimage2,pimage3,pimage4,uid,status,mapimage,topmapimage,groundmapimage,totalfloor,isFeatured)
		VALUES('$title','$content','$ptype','','$stype','$bed','0','0','0','0','','$asize','$price',
		'$loc','$city','$state','','$aimage','','','','','$uid','$status','','','','','$isFeatured')";
		$result=mysqli_query($con,$sql);
		if($result)
		{
			$msg="<p class='alert alert-success'>Property Inserted Successfully</p>";
		}
		else
		{
			$error="<p class='alert alert-warning'>Something went wrong. Please try again</p>";
		}
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <title>LM HOMES | Property</title>
		
		<!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">
		
		<!-- Bootstrap CSS -->
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
		
		<!-- Fontawesome CSS -->
        <link rel="stylesheet" href="assets/css/font-awesome.min.css">
		
		<!-- Feathericon CSS -->
        <link rel="stylesheet" href="assets/css/feathericon.min.css">
		
		<!-- Main CSS -->
        <link rel="stylesheet" href="assets/css/style.css">
		
		<!--[if lt IE 9]>
			<script src="assets/js/html5shiv.min.js"></script>
			<script src="assets/js/respond.min.js"></script>
		<![endif]-->
    </head>
    <body>

		
			<!-- Header -->
			<?php include("header.php"); ?>
			<!-- /Sidebar -->
			
			<!-- Page Wrapper -->
            <div class="page-wrapper">
                <div class="content container-fluid">
				
					<!-- Page Header -->
					<div class="page-header">
						<div class="row">
							<div class="col">
								<h3 class="page-title">Property</h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
									<li class="breadcrumb-item active">Property</li>
								</ul>
							</div>
						</div>
					</div>
					<!-- /Page Header -->
					
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<h4 class="card-title">Add Property</h4>
								</div>
								<form method="post" enctype="multipart/form-data">
								<div class="card-body">
									<?php echo $error; ?>
									<?php echo $msg; ?>

									<div class="row">
										<div class="col-xl-12">
											<div class="form-group row">
												<label class="col-lg-2 col-form-label">Title</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" name="title" required placeholder="Enter Title">
												</div>
											</div>
											<div class="form-group row">
												<label class="col-lg-2 col-form-label">Description</label>
												<div class="col-lg-9">
													<textarea class="tinymce form-control" name="content" rows="6" cols="30"></textarea>
												</div>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-xl-6">
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Property Type</label>
												<div class="col-lg-9">
													<select class="form-control" required name="ptype">
														<option value="">Select Type</option>
														<option value="apartment">Apartment</option>
														<option value="flat">Flat</option>
														<option value="building">Building</option>
														<option value="house">House</option>
														<option value="villa">Villa</option>
														<option value="office">Office</option>
													</select>
												</div>
											</div>
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Selling Type</label>
												<div class="col-lg-9">
													<select class="form-control" required name="stype">
														<option value="">Select Status</option>
														<option value="rent">Rent</option>
														<option value="sale">Sale</option>
													</select>
												</div>
											</div>
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Bedrooms</label>
												<div class="col-lg-9">
													<input type="number" min="0" class="form-control" name="bed" required placeholder="e.g. 3">
												</div>
											</div>
										</div>
										<div class="col-xl-6">
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Price</label>
												<div class="col-lg-9">
													<input type="number" min="0" class="form-control" name="price" required placeholder="Enter Price">
												</div>
											</div>
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Area Size</label>
												<div class="col-lg-9">
													<input type="number" min="0" class="form-control" name="asize" required placeholder="Enter Area Size (in sqft)">
												</div>
											</div>
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">City</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" name="city" required placeholder="Enter City">
												</div>
											</div>
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">State</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" name="state" required placeholder="Enter State">
												</div>
											</div>
										</div>
									</div>

									<div class="form-group row">
										<label class="col-lg-2 col-form-label">Address</label>
										<div class="col-lg-9">
											<input type="text" class="form-control" name="loc" required placeholder="Enter Address">
										</div>
									</div>

									<hr>
									<h5 class="card-title">Image, Status & Owner</h5>

									<div class="row">
										<div class="col-xl-6">
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Main Image</label>
												<div class="col-lg-9">
													<input class="form-control" name="aimage" type="file" accept="image/*" required>
												</div>
											</div>
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Status</label>
												<div class="col-lg-9">
													<select class="form-control" required name="status">
														<option value="">Select Status</option>
														<option value="available">Available</option>
														<option value="sold out">Sold Out</option>
													</select>
												</div>
											</div>
										</div>
										<div class="col-xl-6">
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Owner</label>
												<div class="col-lg-9">
													<select class="form-control" required name="uid">
														<option value="">Select Owner</option>
														<?php
														$users=mysqli_query($con,"SELECT uid, uname, utype FROM user ORDER BY uname");
														while($u=mysqli_fetch_assoc($users))
														{
														?>
														<option value="<?php echo $u['uid']; ?>"><?php echo $u['uname']; ?> (<?php echo $u['utype']; ?>)</option>
														<?php } ?>
													</select>
												</div>
											</div>
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Is Featured?</label>
												<div class="col-lg-9">
													<select class="form-control" required name="isFeatured">
														<option value="0">No</option>
														<option value="1">Yes</option>
													</select>
												</div>
											</div>
										</div>
									</div>

									<input type="submit" value="Submit" class="btn btn-primary mt-3" name="add">

								</div>
								</form>
							</div>
						</div>
					</div>
				
				</div>			
			</div>
			<!-- /Main Wrapper -->

		
		<!-- jQuery -->
        <script src="assets/js/jquery-3.2.1.min.js"></script>
		<script src="assets/plugins/tinymce/tinymce.min.js"></script>
		<script src="assets/plugins/tinymce/init-tinymce.min.js"></script>
		<!-- Bootstrap Core JS -->
        <script src="assets/js/popper.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
		
		<!-- Slimscroll JS -->
		<script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
		
		<!-- Custom JS -->
		<script  src="assets/js/script.js"></script>
		
    </body>

</html>
