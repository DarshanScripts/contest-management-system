<?php
session_start();

//declaring variables for error msgs, E refers to error 
$fnE = $mnE = $lnE = $mobileNoE = $emergencyContactNoE = $emailE = $unE = $passE = $rePassE = $bDateE = $perAddE = $tempAddE = $cityE = $proPicE = $iProofE = $captchaE = $subscribeE = '';

if (isset($_POST["btnSignUp"])) {
	include_once './CommonFunctions.php';

	//fetching values, V refers to value
	$fnV = $_POST["txtFn"];
	$mnV = $_POST["txtMn"];
	$lnV = $_POST["txtLn"];
	$mobileNoV = $_POST["txtMobileNo"];
	$emergencyContactV = $_POST["txtEmergencyContactNo"];
	$emailV = $_POST["txtEmail"];
	$unV = $_POST["txtUn"];
	$passV = $_POST["txtPass"];
	$rePassV = $_POST["txtRePass"];
	$genderV = $_POST["rdGender"];
	$bDateV = $_POST["dtBDate"];
	$perAddV = $_POST["txtaPerAdd"];
	$tempAddV = $_POST["txtaTempAdd"];
	$cityV = $_POST["txtCity"];
	$proPicV = $_FILES["fileProPic"];
	$iProofV = $_FILES["fileIProof"];
	$captchaV = $_POST["txtCaptcha"];

	//server-side validation
	$valid = true;

	// checking javascript is on or off
	if ($_POST["javaScriptValid"] == 0) {

		// first name
		if (empty($fnV)) {
			$fnE = "<span>Please enter firstname</span>";
			$valid = false;
		} else if (!preg_match("/^[A-Za-z]{2,15}$/", $fnV)) {
			$fnE = "<span>Name should be of 2 or more characters and does not contain any number or special symbol</span>";
			$valid = false;
		}

		// middle name
		if (empty($mnV)) {
			$mnE = "<span>Please enter middlename</span>";
			$valid = false;
		} else if (!preg_match("/^[A-Za-z]{2,15}$/", $mnV)) {
			$mnE = "<span>Name should be of 2 or more characters and does not contain any number or special symbol</span>";
			$valid = false;
		}

		// last name
		if (empty($lnV)) {
			$lnE = "<span>Please enter lastname</span>";
			$valid = false;
		} else if (!preg_match("/^[A-Za-z]{2,15}$/", $lnV)) {
			$lnE = "<span>Name should be of 2 or more characters and does not contain any number or special symbol</span>";
			$valid = false;
		}

		// mobileno.
		if (empty($mobileNoV)) {
			$mobileNoE = "<span>Please enter mobile number</span>";
			$valid = false;
		} else if (!preg_match("/[6-9][0-9]{9}/", $mobileNoV)) {
			$mobileNoE = "<span>Mobile number contains only 10 digits</span>";
			$valid = false;
		}

		// emergency contact no.
		if (empty($emergencyContactV)) {
			$emergencyContactNoE = "<span>Please enter an emergency mobile number</span>";
			$valid = false;
		} else if (!preg_match("/[6-9][0-9]{9}/", $emergencyContactV)) {
			$emergencyContactNoE = "<span>Mobile number contains only 10 digits</span>";
			$valid = false;
			if ($mobileNoV != $emergencyContactV) {
				$emergencyContactNoE = "<span>Emergency No. must be different from Mobile No.</span>";
				$valid = false;
			}
		}

		// email
		if (empty($emailV)) {
			$emailE = "<span>Please enter email address</span>";
			$valid = false;
		} else if (!filter_var($emailV, FILTER_VALIDATE_EMAIL)) {
			$emailE = "<span>Email should be valid email address</span>";
			$valid = false;
		}

		// username
		if (empty($unV)) {
			$unE = "<span>Please enter username</span>";
			$valid = false;
		} else if (!preg_match("/[a-z][a-z0-9._]{2,19}/", $unV)) {
			$unE = "<span>Username contain small letters, numbers, periods & underscore</span>";
			$valid = false;
		}

		// password
		if (empty($passV)) {
			$passE = "<span>Please enter your password</span>";
			$valid = false;
		} else {
			if (strlen($passV) < 8) {
				$passE = "<span>Password length must contain atleast 8 characters</span>";
				$valid = false;
			}
			if (!preg_match("/[0-9]/", $passV)) {
				$passE = "<span>Password contain atleast one number</span>";
				$valid = false;
			}
			if (!preg_match("/[`!@#$%^&*()_\-+={}\[\];':\"\\|,.<>\/?~]+/", $passV)) {
				$passE = "<span>Password contain atleast one special character</span>";
				$valid = false;
			}
		}

		// confirm password
		if (empty($rePassV)) {
			$rePassE = "<span>Please enter your password again</span>";
			$valid = false;
		} else if ($passV != $rePassV) {
			$rePassE = "<span>Password and retype password must be matched</span>";
			$valid = false;
		}

		// birth date
		if (empty($bDateV)) {
			$bDateE = "<span>Please enter birth date</span>";
			$valid = false;
		}

		// permanent address
		if (empty($perAddV)) {
			$perAddE = "<span>Please enter your permanent address</span>";
			$valid = false;
		} else if (!preg_match("/^[a-zA-Z0-9\s,.'-\/]{3,80}$/", $perAddV)) {
			$perAddE = "<span>Address contains alphabets, numbers, comma(,), periods(.), single quote('), hyphen(-) and forward slash(/)</span>";
			$valid = false;
		}

		// temporary address
		if (isset($_POST['checkTemp'])) {
			if (!preg_match("/^[a-zA-Z0-9\s,.'-\/]{3,80}$/", $tempAddV)) {
				$tempAddE = "<span>Address contains alphabets, numbers, comma(,), periods(.), single quote('), hyphen(-) and forward slash(/)</span>";
				$valid = false;
			}
		}

		// city
		if (empty($cityV)) {
			$cityE = "<span>Please enter your city</span>";
			$valid = false;
		} else if (!preg_match("/^[A-Za-z]{2,15}$/", $cityV)) {
			$cityE = "<span>City should not contain any number or special symbol</span>";
			$valid = false;
		}

		//profile picture
		if ($proPicV['error'] == 4) { //means there is no file upload
			$proPicE = "<span>Please Upload your profile picture</span>";
			$valid = false;
		} else {
			$fileName = $_FILES['fileProPic']['name'];
			$fileExt = @strtolower(end(explode('.', $fileName)));
			$ext = array("jpeg", "jpg", "png");
			if (in_array($fileExt, $ext) === false) {
				$proPicE = "Extension not allowed, please choose JPEG, JPG or PNG file";
				$valid = false;
			}
		}

		//identity proof
		if ($iProofV['error'] == 4) {
			$iProofE = "<span>Please Upload your identity proof document</span>";
			$valid = false;
		} else {
			$fileName = $_FILES['fileIProof']['name'];
			$fileExt = @strtolower(end(explode('.', $fileName)));
			$ext = array("pdf");
			if (in_array($fileExt, $ext) === false) {
				$iProofE = "Extension not allowed, please choose PDF file";
				$valid = false;
			}
		}

		// captcha
		if (empty($captchaV)) {
			$captchaE = "<span>Please enter your captcha</span>";
			$valid = false;
		}

		//subscribe
		if (isset($_POST["subscribe"])) {
			if (!isset($_POST["emailNotif"]) || !isset($_POST["mobileSMS"])) {
				$subscribeE = "<span>Please select atleast one subscribe mode</span>";
				$valid = false;
			}
		}
	}
	// if no false occur then ...
	if ($valid) {
		// profile picture upload to server
		if (isset($proPicV) && $proPicE == "") {
			$fileName = $_FILES['fileProPic']['name'];
			$fileTmp = $_FILES['fileProPic']['tmp_name'];
			$fileSize = $_FILES['fileProPic']['size'];
			// 1024 Bytes = 1 KB. Therefore, 1024 Bytes * 100 KB = 102400
			$sizeLimit = 102400;
			include_once "./CommonFunctions.php";
			try {
				checkFileSize($fileSize, $sizeLimit);
			} catch (Exception $e) {
				echo $e->getMessage();
			}
			$filePath = "./assets/images/ProPicImg/";
			if (file_exists($filePath . $fileName)) {
				$fileName = renameFileName($filePath, $fileName);
			}
			$_SESSION['sessProPic'] = $fileName;
			move_uploaded_file($fileTmp, 'C:/xampp/htdocs/ContestManagementSystem/assets/images/ProPicImg/' . $fileName);
		}

		// identity proof upload to server
		if (isset($iProofV) && $iProofE == "") {
			$fileName = $_FILES['fileIProof']['name'];
			$fileTmp = $_FILES['fileIProof']['tmp_name'];
			$fileSize = $_FILES['fileIProof']['size'];
			// 1024 Bytes = 1 KB & 1024 KB * 1 MB. Therefore, 1024 Bytes * 1024 KB * 2 MB = 2097152
			$sizeLimit = 2097152;
			include_once "./CommonFunctions.php";
			try {
				checkFileSize($fileSize, $sizeLimit);
			} catch (Exception $e) {
				echo $e->getMessage();
			}
			$filePath = "./assets/images/IProofDoc/";
			if (file_exists($filePath . $fileName)) {
				$fileName = renameFileName($filePath, $fileName);
			}
			$_SESSION['sessIProof'] = $fileName;
			move_uploaded_file($fileTmp, 'C:/xampp/htdocs/ContestManagementSystem/assets/images/IProofDoc/' . $fileName);
		}

		//subscribe
		if (isset($_POST['subscribe'])) {
			//reading from file that email or mobile already exists or not
			if (file_exists("./ContestNotification.csv")) {
				$file = fopen("./ContestNotification.csv", 'r');
				$email = trim($_POST['txtEmail']);
				$mobileNo = trim($_POST['txtMobileNo']);
				while (!feof($file)) {
					$csvArray = fgetcsv($file);
					// echo "<pre>"; print_r($csvArray); echo "</pre>";
					if (!empty($csvArray)) {
						if (isset($_POST['emailNotif']) || isset($_POST['mobileSMS'])) {
							if ($email == $csvArray[1]) {
								echo "<script>alert('Email already exists!');window.location.replace('Registration');</script>";
								exit();
							} else if ($mobileNo == $csvArray[2]) {
								echo "<script>alert('Mobile No. already exists!');window.location.replace('Registration');</script>";
								exit();
							}
						}
					}
				}
				fclose($file);

				//printing in csv file
				$file = fopen("./ContestNotification.csv", 'a');
				$name = ucfirst(trim($_POST["txtFn"])) . " " . ucfirst(trim($_POST["txtMn"])) . " " . ucfirst(trim($_POST["txtLn"]));
				$email = strtolower(trim($_POST["txtEmail"]));
				$mobileNo = $_POST["txtMobileNo"];
				$notificationType = "";
				if (isset($_POST['emailNotif']))
					$notificationType = "EmailNotif";
				if (isset($_POST['mobileSMS']))
					$notificationType = "MobileSMS";
				if (isset($_POST['emailNotif']) && isset($_POST['mobileSMS']))
					$notificationType = "Both";
				$putData = array($name, $email, $mobileNo, $notificationType);
				fputcsv($file, $putData);
				fclose($file);
				// echo "<script>alert('Details added successfully in CSV file!');window.location.replace('P3.php');</script>";
			} else
				echo "File doesn't exists! Please Create a ContestNotification.csv file first.";
		}

		//checking that submit button is clicked or not
		if (isset($_POST['btnSignUp'])) {
			$fn = ucfirst(trim($_POST['txtFn']));
			$mn = ucfirst(trim($_POST['txtMn']));
			$ln = ucfirst(trim($_POST['txtLn']));
			$mobileNo = trim($_POST['txtMobileNo']);
			$emergencyContactNo = trim($_POST['txtEmergencyContactNo']);
			$email = strtolower(trim($_POST['txtEmail']));
			$un = trim($_POST['txtUn']);
			$pass = md5($_POST['txtPass']);
			$bdate = $_POST['dtBDate'];
			$gender = $_POST['rdGender'];
			$perAdd = trim($_POST['txtaPerAdd']);
			$tempAdd = trim($_POST['txtaTempAdd']);
			$city = trim($_POST['txtCity']);
			$curDate = date("Y-m-d h-i-s");
			$proPic = trim($_SESSION['sessProPic']);
			$iProof = trim($_SESSION['sessIProof']);
			addUser($fn, $mn, $ln, $mobileNo, $emergencyContactNo, $email, $un, $pass, $bdate, $gender, $perAdd, $tempAdd, $city, $curDate, $proPic, $iProof);
		} else
			echo "Go to previous page & press the submit button.";
	}
}
?>

<html>

<head>
	<title>Registration</title>
	<style>
		span {
			font-weight: 600;
			font-family: sans-serif;
			font-size: 13px;
			display: block;
		}
	</style>
	<script src="./assets/js/jquery.js"></script>
	<script src="./assets/js/Validation.js"></script>
	<noscript>
		<!-- if javascript is off then this msg is displayed on screen -->
		<p>Please enable javascript for better experience.</p>
	</noscript>
</head>

<body onload="onLoadHide()">
	<h3><a href="Login.php" style="float:right;">Login</a></h3>
	<!-- ENCTYPE i.e. EncryptionType is mandatory because we need upload files -->
	<form action="" method="POST" onsubmit="return nullCheck()" enctype="multipart/form-data">
		<h1 align="center">User Registration</h1>
		<hr>
		<table cellpadding="5" cellspacing="10">
			<tr>
				<td><label>First Name:* </label></td>
				<td>
					<input type="text" name="txtFn" id="fn" onkeyup="fnCheck()" onfocus="fnF()" onblur="fnB()" placeholder="Darshan" />
					<span id="fnMsg"></span>
					<span id="fnV"></span>
					<?php echo $fnE; ?>
				</td>
			</tr>
			<tr>
				<td><label>Middle Name:* </label></td>
				<td>
					<input type="text" name="txtMn" id="mn" onkeyup="mnCheck()" onfocus="mnF()" onblur="mnB()" placeholder="Dineshbhai" />
					<span id="mnMsg"></span>
					<span id="mnV"></span>
					<?php echo $mnE; ?>
				</td>
			</tr>
			<tr>
				<td><label>Last Name:* </label></td>
				<td>
					<input type="text" name="txtLn" id="ln" onkeyup="lnCheck()" onfocus="lnF()" onblur="lnB()" placeholder="Shah" />
					<span id="lnMsg"></span>
					<span id="lnV"></span>
					<?php echo $lnE; ?>
				</td>
			</tr>
			<tr>
				<td><label>Mobile Number:* </label></td>
				<td>
					<input type="text" name="txtMobileNo" id="mobile" onkeyup="mobileCheck()" onfocus="mobileF()" onblur="mobileB()" placeholder="85828655" maxlength="10" />
					<span id="mobileMsg"></span>
					<span id="mobileV"></span>
					<?php echo $mobileNoE; ?>
				</td>
			</tr>
			<tr>
				<td><label>Emergency Contact Number:* </label></td>
				<td>
					<input type="text" name="txtEmergencyContactNo" id="emergencyContact" onkeyup="emergencyContactCheck()" onfocus="emergencyContactF()" onblur="emergencyContactB()" placeholder="85756457" maxlength="10" />
					<span id="emergencyContactMsg"></span>
					<span id="emergencyContactV"></span>
					<?php echo $emergencyContactNoE; ?>
				</td>
			</tr>
			<tr>
				<td><label>Email Address:* </label></td>
				<td>
					<input type="text" name="txtEmail" id="email" onkeyup="emailCheck()" onfocus="emailF()" onblur="emailB()" placeholder="darshan@gmail.com" />
					<span id="emailMsg"></span>
					<span id="emailV"></span>
					<?php echo $emailE; ?>
				</td>
			</tr>
			<tr>
				<td><label>Username:* </label></td>
				<td>
					<input type="text" name="txtUn" id="un" onkeyup="unCheck()" onfocus="unF()" onblur="unB()" placeholder="darshan" />
					<span id="unMsg"></span>
					<span id="unV"></span>
					<?php echo $unE; ?>
				</td>
			</tr>
			<tr>
				<td><label>Password:* </label></td>
				<td>
					<input type="password" name="txtPass" id="pass" onkeyup="passCheck()" onfocus="passF()" onblur="passB()" /><span id="passV"></span>
					<span id="passMsg1"></span>
					<span id="passMsg2"></span>
					<span id="passMsg3"></span>
					<?php echo $passE; ?>
				</td>
			</tr>
			<tr>
				<td><label>Retype Password:* </label></td>
				<td>
					<input type="password" name="txtRePass" id="conPass" onkeyup="conPassCheck()" onfocus="conPassF()" onblur="conPassB()" />
					<span id="conPassMsg"></span>
					<span id="conPassV"></span>
					<?php echo $rePassE; ?>
				</td>
			</tr>
			<tr>
				<td><label>Birthdate:* </label></td>
				<td>
					<input type="date" name="dtBDate" id="bDate" min="<?php echo date('Y-m-d', strtotime('-100 years')); ?>" max="<?php echo date('Y-m-d', strtotime('-18 years')); ?>" placeholder="<?php if (isset($_POST["dtBDate"])) echo $_POST["dtBDate"]; ?>" onfocus="bDateF()" />
					<span id="bDateV"></span>
				</td>
			</tr>
			<tr>
				<td><label>Gender: </label></td>
				<td>
					<input type="radio" name="rdGender" value="M" checked /><label>Male</label>
					<input type="radio" name="rdGender" value="F" /><label>Female</label>
				</td>
			</tr>
			<tr>
				<td><label>Permanent Address:* </label></td>
				<td>
					<textarea rows="5" cols="50" name="txtaPerAdd" id="perAdd" onkeyup="perAddCheck()" onfocus="perAddF()" onblur="perAddB()"></textarea>
					<span id="perAddMsg"></span>
					<span id="perAddV"></span>
					<?php echo $perAddE; ?>
					<input type="checkbox" id="checkTemp" name="checkTemp" onclick="showTempBlock()" />
					<label>Temporary Address is different from Permanent Address</label>
				</td>
			</tr>
			<tr id="tempAddBlock">
				<td><label>Temporary Address: </label></td>
				<td>
					<textarea rows="5" cols="50" name="txtaTempAdd" id="tempAdd" onkeyup="tempAddCheck()" onfocus="tempAddF()" onblur="tempAddB()"></textarea>
					<span id="tempAddMsg"></span>
					<span id="tempAddV"></span>
					<?php echo $tempAddE; ?>
				</td>
			</tr>
			<tr>
				<td><label>City:* </label></td>
				<td>
					<input type="text" name="txtCity" id="city" onkeyup="cityCheck()" onfocus="cityF()" onblur="cityB()" placeholder="Surat" />
					<span id="cityMsg"></span>
					<span id="cityV"></span>
					<?php echo $cityE; ?>
				</td>
			</tr>
			<tr>
				<td><label>Profile Picture:* </label></td>
				<td>
					<input type="file" name="fileProPic" id="proPic" onfocus="proPicF()" onblur="proPicB()" />
					<span id="proPicMsg"></span>
					<span id="proPicV"></span>
					<?php echo $proPicE; ?>
				</td>
			</tr>
			<tr>
				<td><label>Identity Proof:* </label></td>
				<td>
					<input type="file" name="fileIProof" id="iProof" onfocus="iProofF()" onblur="iProofB()" />
					<span id="iProofMsg"></span>
					<span id="iProofV"></span>
					<?php echo $iProofE; ?>
				</td>
			</tr>
			<tr>
				<?php
				$randomAlpha = md5(rand());
				$captchaCode = substr($randomAlpha, 0, 6);
				$_SESSION['sessCaptcha'] = $captchaCode;
				?>
				<td><label>Captcha Code:*</label>&emsp;<label id="captchaLabel" style="background-color: grey;padding:8px;"><?php echo $captchaCode; ?></label></td>
				<td>
					<input type="text" name="txtCaptcha" id="captcha" onfocus="captchaF()" />
					<span id="captchaV"></span>
					<?php echo $captchaE; ?>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<input type="checkbox" name="subscribe" id="checkSubscribe" onclick="showSubscribeBlock()" />
					<label>Subscribe with us to receive upcoming contest notification</label>
				</td>
			</tr>
			<tr id="subscribeBlock">
				<td colspan="2">
					<label><b>Upcoming Contest Notification</b></label><br>
					<input type="checkbox" name="emailNotif" id="checkEmail" onclick="subscribeCheck()" /><label>Email Notification</label><br>
					<input type="checkbox" name="mobileSMS" id="checkMobileSMS" onclick="subscribeCheck()" /><label>Mobile SMS</label>
					<span id="subscribeV"></span>
					<?php echo $subscribeE; ?>
				</td>
			</tr>
			<!-- hidden field for checking javascript is on or off -->
			<input type="hidden" name="javaScriptValid" id="jsValid" value="0" />
			<tr>
				<td><input type="submit" value="Signup" name="btnSignUp" id="signup" /></td>
				<td><input type="reset" value="Clear" name="btnClear" id="clear" /></td>
			</tr>
		</table>
	</form>
	<script>
		//if js is on then the value will be set to one
		document.getElementById("jsValid").value = "1";

		$(document).ready(function() {
			$("#captcha").blur(function() {
				var captcha = $("#captcha").val();
				// console.log(captcha);

				$.ajax({
					url: "Captcha.php",
					method: "POST",
					data: {
						captcha: captcha
					},
					success: function(data) {
						// console.log("Success");
						$("#captchaV").html(data);
						if (data == 'success') {
							$('form').submit();
						}
						// else{
						// 	alert("Captcha Failed!");
						// }
					}
				});
			});
		});
	</script>
	<?php
	include './Footer.php';
	?>
</body>

</html>