<?php
session_start();
	require_once 'conn.php';
	
	//CREATING NEW USER TO THE SYSTEM

	//checking if the register user button has been clicked or not
	if (isset($_POST['register-user'])) {
		//what to do if the button has been clicked
			//getting values from the new user creastion from using the POST message
				$name = mysqli_real_escape_string($conn , $_POST['name']);
				$surname = mysqli_real_escape_string($conn , $_POST['surname']);
				$email = mysqli_real_escape_string($conn , $_POST['email']);
				$department = mysqli_real_escape_string($conn , $_POST['department']);
				$role = mysqli_real_escape_string($conn , $_POST['role']);
				$pwd = mysqli_real_escape_string($conn , $_POST['password']);
				$recovery = mysqli_real_escape_string($conn , $_POST['recovery']);
				$phone = mysqli_real_escape_string($conn , $_POST['phone']);

				//encrypting password
				$password = password_hash($pwd, PASSWORD_DEFAULT);

				//SQL QUERY TO INSERT USER INFORMATION INTO THE USERS TABLE
				$user_reg_query = "INSERT INTO users (name , surname , email, phone , department , role , password , recovery_password  )
									VALUES ('$name' , '$surname' , '$email' , '$phone' , '$department' , '$role' , '$password' , '$recovery')
				";
				//executing the query using the connection string
				$result = mysqli_query($conn , $user_reg_query);
				if ($result) {
					# what to do if the operation was successful
					header("Location: ../view/users.php");
				}	
	}

	//CODE FOR LOGGING IN TO THE SYSTEM

	//checking if the the login button is 
	if (isset($_POST['login-button'])) {
			# code...
			$email = mysqli_real_escape_string($conn , $_POST['email']);
			$password = mysqli_real_escape_string($conn , $_POST['password']);

			$sql = "SELECT * FROM users WHERE email = '$email'";

			$result = mysqli_query($conn , $sql);

			$email_count = mysqli_num_rows($result);

			if ($email_count != 1) {
				# what to do if there is a login error
				$_SESSION['message'] = "Email or Password is incorrect";
				//$message="Email/Password is incorrect";
				header("Location: ../index.php");
				// header("Location: ../index.php?message=$message");
				exit($message);
			}
			else{
				while ($details = mysqli_fetch_assoc($result)) {
					# getting hashed password from the database
					$hashed = $details['password'];
					$comparison = password_verify($password, $hashed);
					if ($comparison == true) {
						# code...
						session_start();
						$_SESSION['UserID'] = $details['UserID'];
						$_SESSION['name'] = $details['name'];
						$_SESSION['surname'] = $details['surname'];
						$_SESSION['role'] = $details['role'];
						header("Location: ../view/home.php?");
					}

				}
				
			}
		}


	//DELETE USER SCRIPT
	#testing to see if any user has been selected for deletion
	if (isset($_GET['DeleteUser'])) {
		# what to do if the user is actually selected for deletion
		$UserID = $_GET['DeleteUser'];
		$name = $_GET['name'];
		$surname = $_GET['surname']; 

		#delete user sql script
		$sql = "DELETE FROM users WHERE UserID='$UserID'";
		$result = mysqli_query($conn , $sql);
		if ($result) {
			#what to do if the user has been successfully deleted
			$_SESSION['message'] ="Account has been deleted successfully";

			header("Location: ../view/users.php?");
		}

	}

	//SCRIPT FOR LOGGING OUT ANY USER
	#testing if the logout link has been clicked
	if (isset($_GET['LogoutAction'])) {
		# what to do when it's actually clicked

		session_start();
		session_unset();
		session_destroy();
		$_SESSION['message'] ="You have been logged out successfully";
		header("Location: ../index.php");
	}

	//UPDATING USER DETAILS

	if (isset($_GET['update-profile'])) {
		# code...
		$UserID = mysqli_real_escape_string($conn ,$_GET['ProfileID']);
		$name = mysqli_real_escape_string($conn ,$_GET['name']);
		$surname = mysqli_real_escape_string($conn ,$_GET['surname']);
		$phone = mysqli_real_escape_string($conn ,$_GET['phone']);

		//echo $UserID.$surname.$phone.$name;

		$sql = "UPDATE users SET name = '$name', surname = '$surname' , phone = '$phone' WHERE UserID = '$UserID' ";
		$result = mysqli_query($conn , $sql);
		if ($result) {
			# code...
			header("Location: ../view/users.php?message=User Details Updated successfully");
		}
	}
	