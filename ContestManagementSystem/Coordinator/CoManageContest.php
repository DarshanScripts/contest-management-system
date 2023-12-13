<?php
session_start();

if (isset($_SESSION['sessLoginCheck']) && $_SESSION['sessUserDetails']['emailId'] == "coordinator@gmail.com") {

	//E refers to error 
	$cNameE = $cDateE = $cDurE = $cDescE = $cBannerE = '';

	if (isset($_POST['btnContestSubmit'])) {

		//V refers to value
		$cNameV = $_POST["txtName"];
		$cDateV = $_POST["dtContest"];
		$cDurV = $_POST["txtDuration"];
		$cDescV = $_POST["txtaDesc"];
		$cBannerV = $_FILES["fileBanner"];

		//server-side validation
		$valid = true;

		// checking javascript is on or off
		if ($_POST["javaScriptValid"] == 0) {
			// contest name
			if (empty($cNameV)) {
				$cNameE = "<span>Please enter contest name</span>";
				$valid = false;
			} else if (!preg_match("/^[A-Za-z\s]{2,40}$/", $cNameV)) {
				$cNameE = "<span>Contest name should be of 2 or more characters and does not contain any number or special symbol</span>";
				$valid = false;
			}

			// contest date
			if (empty($cDateV)) {
				$cDateE = "<span>Please enter contest date</span>";
				$valid = false;
			}

			// contest duration
			if (empty($cDurV)) {
				$cDurE = "<span>Please enter contest duration</span>";
				$valid = false;
			} else if (!preg_match("/^[1-9][0-9]{0,4}$/", $cDurV)) {
				$cDurE = "<span>Only digits are allowed</span>";
				$valid = false;
			}

			// contest description
			if (empty($cDescV)) {
				$cDescE = "<span>Please enter contest description</span>";
				$valid = false;
			} else if (!preg_match("/^[a-zA-Z0-9\s,.'-\/]{3,255}$/", $cDescV)) {
				$cDescE = "<span>Address contains alphabets, numbers, comma(,), periods(.), single quote('), hyphen(-) and forward slash(/)</span>";
				$valid = false;
			}

			// contest banner
			if ($cBannerV['error'] == 4) { //means there is no file upload
				$cBannerE = "<span>Please upload contest banner</span>";
				$valid = false;
			}
			else{
				$fileName = $_FILES['fileBanner']['name'];
				$fileExt = @strtolower(end(explode('.', $fileName)));
				$ext = array("jpeg","jpg","png");
				if(in_array($fileExt, $ext) === false){
					$cBannerE = "Extension not allowed, please choose JPEG, JPG or PNG file";
					$valid = false;
				}
			}
		}
		// if no false occur then ...
		if ($valid) {
			// contest banner upload
			if (isset($cBannerV) && $cBannerE == "") {
				$fileName = $_FILES['fileBanner']['name'];
				$fileTmp = $_FILES['fileBanner']['tmp_name'];
				$fileType = $_FILES['fileBanner']['type'];
				// 1024 Bytes = 1 KB. Therefore, 1024 Bytes * 100 KB = 102400
				$sizeLimit = 102400;
				include_once "../CommonFunctions.php";
				try {
					checkFileSize($fileSize,$sizeLimit);
				}
				catch(Exception $e) {
					echo $e->getMessage();
				}
				$filePath = "../assets/images/BannerImg/";
				// $filePath = "/var/www/html/bca2021/bca2021104/uploads/";
				if(file_exists($filePath . $fileName)){
					$fileName = renameFileName($filePath,$fileName);
				}
				$_SESSION['sessBanner'] = $fileName;
				move_uploaded_file ($fileTmp, 'C:/xampp/htdocs/ContestManagementSystem/Images/BannerImg/' . $fileName);
				// move_uploaded_file ($fileTmp, '/var/www/html/bca2021/bca2021104/uploads/' . $fileName);
			}
		}
		include_once '../CommonFunctions.php';
		$name = trim($_POST['txtName']);
		$level = $_POST['selLevel'];
		$date = $_POST['dtContest'];
		$duration = trim($_POST['txtDuration']);
		$description = trim($_POST['txtaDesc']);
		$fileName = $_FILES['fileBanner']['name'];
		addContest($name,$level,$date,$duration,$description,$fileName);
	}
?>

	<!DOCTYPE html>
	<html lang="en">

	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Manage Contest</title>
		<style>
			span {
				font-weight: 600;
				font-family: sans-serif;
				font-size: 13px;
				display: block;
			}
		</style>
		<script src="../Validation.js"></script>
		<noscript>
			<p>Please enable javascript for better experience.</p>
		</noscript>
	</head>

	<body>
		<?php
		include './CoHeader.php';
		?>
		<form action="" method="POST" enctype="multipart/form-data" onsubmit=" return contestNullCheck()">
			<h1 align="center">Add Contest</h1>
			<table cellpadding="5" cellspacing="10">
				<tr>
					<td><label>Name:</label></td>
					<td>
						<input type="text" name="txtName" id="cName" onkeyup="cNameCheck()" onfocus="cNameF()" onblur="cNameB()" value="<?php if (isset($_POST["txtName"])) echo $_POST["txtName"]; ?>" /><br>
						<span id="cNameMsg"></span>
						<span id="cNameV"></span>
						<?php echo $cNameE; ?>
					</td>
				</tr>
				<tr>
					<td><label>Contest Level:</label></td>
					<td>
						<select name="selLevel">
							<option value="1">Local</option>
							<option value="2">State</option>
							<option value="3">National</option>
							<option value="4">International</option>
						</select>
					</td>
				</tr>
				<tr>
					<td><label>Date:</label></td>
					<td>
						<input type="date" name="dtContest" id="cDate" min="<?php echo date('Y-m-d'); ?>" onkeyup="cDateCheck()" onfocus="cDateF()" onblur="cDateB()" value="<?php if (isset($_POST["dtContest"])) echo $_POST["dtContest"]; ?>" /><br>
						<span id="cDateMsg"></span>
						<span id="cDateV"></span>
						<?php echo $cDateE; ?>
					</td>
				</tr>
				<tr>
					<td><label>Duration(in minutes):</label></td>
					<td>
						<input type="text" name="txtDuration" id="cDur" onkeyup="cDurCheck()" onfocus="cDurF()" onblur="cDurB()" value="<?php if (isset($_POST["txtDuration"])) echo $_POST["txtDuration"]; ?>" /><br>
						<span id="cDurMsg"></span>
						<span id="cDurV"></span>
						<?php echo $cDurE; ?>
					</td>
				</tr>
				<tr>
					<td><label>About Contest:</label></td>
					<td>
						<textarea cols="100" rows="10" name="txtaDesc" id="cDesc" onkeyup="cDescCheck()" onfocus="cDescF()" onblur="cDescB()"></textarea><br>
						<span id="cDescMsg"></span>
						<span id="cDescV"></span>
						<?php echo $cDescE; ?>
					</td>
				</tr>
				<tr>
					<td><label>Upload Contest Banner:</label></td>
					<td>
						<input type="file" name="fileBanner" id="cBanner" onfocus="cBannerF()" onblur="cBannerB()" /><br>
						<span id="cBannerMsg"></span>
						<span id="cBannerV"></span>
						<?php echo $cBannerE; ?>
					</td>
				</tr>
				<!-- hidden field for checking javascript is on or off -->
				<input type="hidden" name="javaScriptValid" id="jsValid" value="0" />
				<tr>
					<td><input type="submit" value="Submit" name="btnContestSubmit" id="submit" /></td>
					<td><input type="reset" value="Clear" name="btnClear" id="clear" /></td>
				</tr>
			</table>
		</form>
		<?php
		include '../Footer.php';
		?>
		<script>
			//if js is on then the value will be set to one
			document.getElementById("jsValid").value = "1";
		</script>
	</body>

	</html>
<?php
} else
	echo "Go to Login page & sign in as Coordinator.";
?>