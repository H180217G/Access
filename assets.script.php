<?php
	require_once 'conn.php';
	#add new asset into the system
	if (isset($_POST['add-asset'])) {
		# getting new asset values from the new asset form
		$asset_name = mysqli_real_escape_string($conn , $_POST['asset_name']);
		$description = mysqli_real_escape_string($conn , $_POST['description']);
		$location = mysqli_real_escape_string($conn , $_POST['location']);
		$warranty = mysqli_real_escape_string($conn , $_POST['warranty']);
		$supplier = mysqli_real_escape_string($conn , $_POST['supplier']);
		$date = mysqli_real_escape_string($conn , $_POST['date']);
		$cost = mysqli_real_escape_string($conn , $_POST['cost']);
		$state = mysqli_real_escape_string($conn , $_POST['state']);
		$serial_number = mysqli_real_escape_string($conn , $_POST['serial_number']);
		$asset_user = mysqli_real_escape_string($conn , $_POST['asset_user']);
		
		//echo $name.$description.$location.$warranty.$supplier.$date.$cost.$state;
		$add_asset = "INSERT INTO assets (asset_name , description , location , warranty , supplier, date , cost , state, serial_number, asset_user) VALUES
							('$asset_name', '$description', '$location', '$warranty' , '$supplier' , '$date', '$cost', '$state','$serial_number','$asset_user')";
			$result = mysqli_query($conn , $add_asset);
		if ($result) {
			# code...
			header("Location: ../view/assets.php?message=Asset Added Successfully");
		}
	}

	#DELETTING ASSETS
	if (isset($_GET['DeleteAsset'])) {
		# code...
		$AssetID = mysqli_real_escape_string($conn , $_GET['DeleteAsset']);

		$sql = "DELETE FROM assets WHERE AssetID= '$AssetID'";
		$result = mysqli_query($conn , $sql);

		if ($result) {
			# code...
			header("Location: ../view/assets.php?message=Asset Deleted Successfully");
		}else{
			header("Location: ../view/assets.php?message=Error Deleting Asset");
		}
		
	}