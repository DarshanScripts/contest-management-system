<?php
session_start();

if(isset($_POST['btnCodeSubmit'])){
	if($_SESSION['sessCode'] == $_POST['txtCode']){
		include_once '../CommonFunctions.php';
		addParticipant();
	}
	else
		echo "<script>alert('Invalid Code! Please try again.');window.location.replace('UserContest.php');</script>";
}

?>
<body bgcolor="<?php if(isset($_SESSION['sessTheme'])) echo $_SESSION['sessTheme']; ?>">
<?php
if (isset($_SESSION['sessLoginCheck']) && $_SESSION['sessUserDetails']['emailId'] != "coordinator@gmail.com") {
	include './UserHeader.php';

	$code = rand(1000,9999);
	$_SESSION['sessCode'] = $code;
 	echo "Your code to participate in third contest: <b>" . $code . "</b>";
	?>
	<form action="" method="POST">
		<br><input type="text" name="txtCode" autofocus>
		<input type="submit" name="btnCodeSubmit" value="Check Code">
	</form>
	<p><b>Note: </b>Code is valid for one minute! If not used then you can't register in this contest.</p>
	<?php
	

	header("Refresh:60; url=UserContest.php");
	include '../Footer.php';
}
else
	echo "Go to Login page & sign in as User.";
?>
</body>
<!-- show dynamic 1 minute using ajax-->