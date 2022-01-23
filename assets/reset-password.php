<?php

if (isset($_POST['reset-password-submit'])) {
	$selector = $_POST['selector'];
	$validator = $_POST['validator'];
	$password = $_POST['pwd'];
	$passwordRepeat = $_POST['pwd-repeat'];

	if (empty($password) || empty($passwordRepeat)) {
		header("Location: ../ceate-new-password.php?selector=".$selector."&validator=".$validator."&newpwd=empty");
		exit();
	} else if($password != $passwordRepeat) {
		header("Location: ../ceate-new-password.php?selector=".$selector."&validator=".$validator."&newpwd=pwdnotsame");
		exit()
	}

	$currentDate = date("U");

	require 'assets/db/config.php';

	$sql = "SELECT * FROM pwdReset WHERE pwdResetSelector = ? AND pwdResetExpires >= ?";
	$stmt = mysqli_stmt_init($conn);
	if (!mysqli_stmt_prepare($stmt, $sql)) {
		echo "There was an error!";
		exit();
	} else {
		mysqli_stmt_bind_param($stmt, "ss", $selector, $currentDate);
		mysqli_stmt_execute($stmt);

		$result = mysqli_stmt_get_result($stmt);
		if (!$row = mysqli_fetch_assoc($result)) {
			echo "You need to re-submit your reset request.";
			exit();
		} else {
			$tokenBin = hex2bin($validator);
			$tokenCheck = password_verify($tokenBin, $row['pwdResetToken']);

			if ($tokenCheck === false) {
				echo "You need to re-submit your reset request.";
				exit();
			} elseif ($tokenCheck === true) {
				$tokenEmail = $row['pwdResetEmail'];
				$user = null;
				if ($row['user'] == 1) {
					$user = 1;
					$sql = "SELECT * FROM teacher WHERE email = ?;";
				} elseif ($row['user'] == 0) {
					$user = 0;
					$sql = "SELECT * FROM student WHERE email = ?;";
				}
				$stmt = mysqli_stmt_init($conn);
				if (!mysqli_stmt_prepare($stmt, $sql)) {
					echo "There was an error!";
					exit();
				} else {
					mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
					mysqli_stmt_execute($stmt);
					$result = mysqli_stmt_get_result($stmt);
					if (!$row = mysqli_fetch_assoc($result)) {
						echo "There was an error!";
						exit();
					} else {
						if ($user == 1) {
							$sql = "UPDATE teacher SET Password = ? WHERE Email = ?;";
						} elseif ($user == 0) {
							$sql = "UPDATE student SET Password = ? WHERE Email = ?;";
						}
						$stmt = mysqli_stmt_init($conn);
						if (!mysqli_stmt_prepare($stmt, $sql)) {
							echo "There was an error!";
							exit();
						} else {
							$newPwdHash = password_hash($password, PASSWORD_DEFAULT);
							mysqli_stmt_bind_param($stmt, "ss", $newPwdHash, $tokenEmail);
							mysqli_stmt_execute($stmt);

							$sql = "DELETE FROM pwdReset WHERE pwdResetEmail = ?;";
							$stmt = mysqli_stmt_init($conn);
							if (!mysqli_stmt_prepare($stmt, $sql)) {
								echo "There was an error!";
								exit();
							} else {
								mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
								mysqli_stmt_execute($stmt);
								header("Location: forgot.php?newpwd=passwordupdated");
							}

						}
					}
				}
				
			}
		}
	}

} else {
	header("Location: ../index.php");
}