<?php
	$server = "localhost";
	$username = "root";
	$password = "";
	$database = "access_assets";

	//CONNECTING TO THE DATABASE
	$conn = mysqli_connect($server, $username , $password, $database);
	if (!$conn) {
		# what to do if the connection isnt successful
		echo "Error Creating Connection to the database";
	}