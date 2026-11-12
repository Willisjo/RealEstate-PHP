<?php
session_start();
require("config.php");
////code
 
if(!isset($_SESSION['auser']))
{
	header("location:index.php");
}

$pid=$_REQUEST['id'];
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
			$aimage='';
			$error="<p class='alert alert-warning'>Image upload failed. Please check that the admin/property folder is writable and try again.</p>";
		}
	}
	elseif(isset($_FILES['aimage']) && $_FILES['aimage']['error']!=UPLOAD_ERR_NO_FILE)
	{
		$error="<p class='alert alert-warning'>Image upload failed. Please try a smaller image.</p>";
	}

	if($error=="")
	{
		$sql = "UPDATE property SET title= '{$title}', pcontent= '{$content}', type='{$ptype}', stype='{$stype}',
		bedroom='{$bed}', size='{$asize}', price='{$price}', location='{$loc}', city='{$city}',
		state='{$state}', uid='{$uid}', status='{$status}', isFeatured='{$isFeatured}'";

		if(!empty($aimage))
		{
			$sql .= ", pimage='{$aimage}'";
		}

		$sql .= " WHERE pid = {$pid}";
		
		$result=mysqli_query($con,$sql);
		if($result == true)
		{
			$msg="<p class='alert alert-success'>Property Updated</p>";
			header("Location:propertyview.php?msg=$msg");
		}
		else{
			$msg="<p class='alert alert-warning'>Property Not Updated</p>";
			header("Location:propertyview.php?msg=$msg");
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
									<h4 class="card-title">Update Property</h4>
									<?php echo $error; ?>
									<?php echo $msg; ?>
								</div>
								<form method="post" enctype="multipart/form-data">
								
								<?php
									$query=mysqli_query($con,"select * from property where pid='$pid'");
									while($row=mysqli_fetch_assoc($query))
									{
								?>
												
								<div class="card-body">
									<div class="row">
										<div class="col-xl-12">
											<div class="form-group row">
												<label class="col-lg-2 col-form-label">Title</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" name="title" required value="<?php echo $row['title']; ?>">
												</div>
											</div>
											<div class="form-group row">
												<label class="col-lg-2 col-form-label">Description</label>
												<div class="col-lg-9">
													<textarea class="tinymce form-control" name="content" rows="6" cols="30"><?php echo $row['pcontent']; ?></textarea>
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
														<option value="apartment" <?php if($row['type']=='apartment') echo 'selected'; ?>>Apartment</option>
														<option value="flat" <?php if($row['type']=='flat') echo 'selected'; ?>>Flat</option>
														<option value="building" <?php if($row['type']=='building') echo 'selected'; ?>>Building</option>
														<option value="house" <?php if($row['type']=='house') echo 'selected'; ?>>House</option>
														<option value="villa" <?php if($row['type']=='villa') echo 'selected'; ?>>Villa</option>
														<option value="office" <?php if($row['type']=='office') echo 'selected'; ?>>Office</option>
													</select>
												</div>
											</div>
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Selling Type</label>
												<div class="col-lg-9">
													<select class="form-control" required name="stype">
														<option value="">Select Status</option>
														<option value="rent" <?php if($row['stype']=='rent') echo 'selected'; ?>>Rent</option>
														<option value="sale" <?php if($row['stype']=='sale') echo 'selected'; ?>>Sale</option>
													</select>
												</div>
											</div>
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Bedrooms</label>
												<div class="col-lg-9">
													<input type="number" min="0" class="form-control" name="bed" required value="<?php echo $row['bedroom']; ?>">
												</div>
											</div>
										</div>
										<div class="col-xl-6">
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Price</label>
												<div class="col-lg-9">
													<input type="number" min="0" class="form-control" name="price" required value="<?php echo $row['price']; ?>">
												</div>
											</div>
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Area Size</label>
												<div class="col-lg-9">
													<input type="number" min="0" class="form-control" name="asize" required value="<?php echo $row['size']; ?>">
												</div>
											</div>
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">City</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" name="city" required value="<?php echo $row['city']; ?>">
												</div>
											</div>
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">State</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" name="state" required value="<?php echo $row['state']; ?>">
												</div>
											</div>
										</div>
									</div>

									<div class="form-group row">
										<label class="col-lg-2 col-form-label">Address</label>
										<div class="col-lg-9">
											<input type="text" class="form-control" name="loc" required value="<?php echo $row['location']; ?>">
										</div>
									</div>

									<hr>
									<h5 class="card-title">Image, Status & Owner</h5>

									<div class="row">
										<div class="col-xl-6">
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Main Image</label>
												<div class="col-lg-9">
													<input class="form-control" name="aimage" type="file" accept="image/*">
													<img src="property/<?php echo $row['pimage'];?>" alt="property image" height="120" width="160" class="mt-2 rounded">
													<small class="form-text text-muted">Leave empty to keep the current image.</small>
												</div>
											</div>
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Status</label>
												<div class="col-lg-9">
													<select class="form-control" required name="status">
														<option value="">Select Status</option>
														<option value="available" <?php if($row['status']=='available') echo 'selected'; ?>>Available</option>
														<option value="sold out" <?php if($row['status']=='sold out') echo 'selected'; ?>>Sold Out</option>
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
														<option value="<?php echo $u['uid']; ?>" <?php if($row['uid']==$u['uid']) echo 'selected'; ?>><?php echo $u['uname']; ?> (<?php echo $u['utype']; ?>)</option>
														<?php } ?>
													</select>
												</div>
											</div>
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Is Featured?</label>
												<div class="col-lg-9">
													<select class="form-control" required name="isFeatured">
														<option value="0" <?php if($row['isFeatured']==0) echo 'selected'; ?>>No</option>
														<option value="1" <?php if($row['isFeatured']==1) echo 'selected'; ?>>Yes</option>
													</select>
												</div>
											</div>
										</div>
									</div>

									<input type="submit" value="Submit" class="btn btn-primary mt-3" name="add">

								</div>
								</form>
								
								<?php
									} 
								?>
												
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
