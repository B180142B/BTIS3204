<?php
if (isset($_POST["reset-request-submit"])) {
	
	$selector = bin2hex(random_bytes(8));
	$token = random_bytes(32);

	$url = "localhost/FYP/Project/create-new-password.php?selector=".$selector."&validator=".bin2hex($token);

	$expires = date("u") + 1800;

	require 'db/config.php';

	$userEmail = $_POST['email'];
	echo $_POST['user'];
	$user = null;

	if ($_POST['user'] == "Teacher") {
		$user = 1;
	} else {
		$user = 0;
	}

	if ($user = 1) {
		$sql = "SELECT * FROM teacher where Email = ?";
	} else {
		$sql = "SELECT * FROM student where Email = ?";
	}
	$stmt = mysqli_stmt_init($conn);
	if (!mysqli_stmt_prepare($stmt, $sql)) {
		echo "There was an error!";
		exit();
	} else {
		mysqli_stmt_bind_param($stmt, "s", $userEmail);
		$result = mysqli_stmt_execute($stmt);
		$row = mysqli_fetch_row($result);
		if ($row == 0) {
			echo "There was an error!";
			header("Location: ../forgot.php?reset=fail");
		} else {
			echo "There was an error!";
			header("Location: ../forgot.php?reset=fail");
	}

	$sql = "DELETE FROM pwdreset WHERE pwdResetEmail = ?";
	$stmt = mysqli_stmt_init($conn);
	if (!mysqli_stmt_prepare($stmt, $sql)) {
		echo "There was an error!";
		exit();
	} else {
		mysqli_stmt_bind_param($stmt, "s", $userEmail);
		mysqli_stmt_execute($stmt);
	}

	$sql = "INSERT INTO pwdreset (pwdResetEmail, pwdResetSelector, pwdResetToken, pwdResetExpires, user) VALUES (?, ?, ?, ?, ?);";
	$stmt = mysqli_stmt_init($conn);
	if (!mysqli_stmt_prepare($stmt, $sql)) {
		echo "There was an error!";
		exit();
	} else {
		$hashedToken = password_hash($token, PASSWORD_DEFAULT);
		mysqli_stmt_bind_param($stmt, "sssss", $userEmail, $selector, $hashedToken, $expires, $user);
		mysqli_stmt_execute($stmt);
	}

	mysqli_stmt_close($stmt);
	mysqli_close($conn);

	$to = $userEmail;

	$subject = 'Reset your password for Asas Sains Komputer';
	$message = '<p>We received a password reset request. The link to reset your password is below. If you did not make this request, you can ignore this email</p>';
	$message .= '<p>Here is your password reset link: <br>';
	$message .= '<a href="' .$url. '">' .$url. '</a></p>';

	$headers = "From: Asas Sains Komputer <asas.sains.komputer@gmail.com>\r\n";
	$headers .= "Reply-To: asas.sains.komputer@gmail.com\r\n";
	$headers .= "Content-type: text/html\r\n";

	mail($to, $subject, $message, $headers);

	header("Location: ../forgot.php?reset=success");
		}


} else {
	header("Location: ../index.php");
}