<?php
session_start();
if (isset($_SESSION['sessLoginCheck']) && $_SESSION['sessUserDetails']['emailId'] != "coordinator@gmail.com") {
	include './UserHeader.php';
	include '../SQLConnection.php';

    $email = $_SESSION['sessUserDetails']['emailId'];
    $sql = "SELECT * FROM Registration WHERE emailId = '$email';";
    $result = $con->query($sql);
    $row = $result->fetch_assoc();
    
    $fn =  $row['firstName'];
    $mn =  $row['middleName'];
    $ln =  $row['lastName'];
    $mobileNo =  $row['mobileNo'];
    $emergencyContactNo =  $row['emergencyContactNo'];
    $email =  $row['emailId'];
    $un =  $row['username'];
    $pass =  $row['password'];
    $bDate =  $row['birthDate'];
    $gender =  $row['gender'];
    $perAdd =  $row['permanentAdd'];
    $tempAdd =  $row['temporaryAdd'];
    $city =  $row['city'];
    $proPic =  $row['profilePic'];
    $iProof =  $row['identityProof'];
    $theme =  $row['theme'];
    $_SESSION['sessProPic'] = $proPic;
    $_SESSION['sessIProof'] = $iProof;
?>
<html>
<head>
	<style>
		span{
			font-weight: 600;
			font-family: sans-serif;
			font-size: 13px;
			display: block;
		}
	</style>
	<?php 
	if(isset($_POST['btnSave'])){ ?>
		<script src ="../assets/js/Validation.js"></script>
	<?php } ?>
	<noscript>
		<p>Please enable javascript for better experience.</p>
	</noscript>
</head>
<body bgcolor="<?php if(isset($theme)) echo $_SESSION['sessTheme']; ?>">
<form action="" method="POST" onsubmit="return nullCheck()" enctype="multipart/form-data">
    <h1 align="center">Update Profile</h1>
    <table cellpadding="5" cellspacing="10">
        <tr>
            <td><label>First Name:* </label></td>
            <td>
                <input type="text" name="txtFn" id="fn" onkeyup="fnCheck()" onfocus="fnF()" onblur="fnB()" value="<?php echo $fn; ?>" <?php if(isset($_POST['btnUpdate'])) echo ""; else echo "disabled"; ?> />
				<span id="fnMsg"></span>
				<span id="fnV"></span>
            </td>
        </tr>
        <tr>
            <td><label>Middle Name:* </label></td>
            <td>
                <input type="text" name="txtMn" id="mn" onkeyup="mnCheck()" onfocus="mnF()" onblur="mnB()" value="<?php echo $mn; ?>" <?php if(isset($_POST['btnUpdate'])) echo ""; else echo "disabled"; ?> />
				<span id="mnMsg"></span>
				<span id="mnV"></span>
            </td>
        </tr>
        <tr>
            <td><label>Last Name:* </label></td>
            <td>
                <input type="text" name="txtLn" id="ln" onkeyup="lnCheck()" onfocus="lnF()" onblur="lnB()" value="<?php echo $ln; ?>" <?php if(isset($_POST['btnUpdate'])) echo ""; else echo "disabled"; ?> />
				<span id="lnMsg"></span>
				<span id="lnV"></span>
            </td>
        </tr>
        <tr>
            <td><label>Mobile Number:* </label></td>
            <td>
                <input type="text" name="txtMobileNo" id="mobile" onkeyup="mobileCheck()" onfocus="mobileF()" onblur="mobileB()" value="<?php echo $mobileNo; ?>" <?php if(isset($_POST['btnUpdate'])) echo ""; else echo "disabled"; ?> />
				<span id="mobileMsg"></span>
				<span id="mobileV"></span>
            </td>
        </tr>
        <tr>
            <td><label>Emergency Contact Number:* </label></td>
            <td>
                <input type="text" name="txtEmergencyContactNo" id="emergencyContact" onkeyup="emergencyContactCheck()" onfocus="emergencyContactF()" onblur="emergencyContactB()" value="<?php echo $emergencyContactNo; ?>" <?php if(isset($_POST['btnUpdate'])) echo ""; else echo "disabled"; ?> />
				<span id="emergencyContactMsg"></span>
				<span id="emergencyContactV"></span>
            </td>
        </tr>
        <tr>
            <td><label>Email Address:* </label></td>
            <td>
                <input type="text" name="txtEmail" id="email" onkeyup="emailCheck()" onfocus="emailF()" onblur="emailB()" value="<?php echo $email; ?>" <?php if(isset($_POST['btnUpdate'])) echo ""; else echo "disabled"; ?> />
				<span id="emailMsg"></span>
				<span id="emailV"></span>
            </td>
        </tr>
        <tr>
            <td><label>Username:* </label></td>
            <td>
                <input type="text" name="txtUn" id="un" onkeyup="unCheck()" onfocus="unF()" onblur="unB()" value="<?php echo $un; ?>" <?php if(isset($_POST['btnUpdate'])) echo ""; else echo "disabled"; ?> />
				<span id="unMsg"></span>
				<span id="unV"></span>
            </td>
        </tr>
        <tr>
            <td><label>Password:* </label></td>
            <td>
                <input type="text" name="txtPass" id="pass" onkeyup="passCheck()" onfocus="passF()" onblur="passB()" value="<?php echo $_SESSION["sessPasssword"]; ?>" <?php if(isset($_POST['btnUpdate'])) echo ""; else echo "disabled"; ?> />
				<span id="passMsg1"></span>
				<span id="passMsg2"></span>
				<span id="passMsg3"></span>
            </td>
        </tr>
        <tr>
            <td><label>Birthdate:* </label></td>
            <td>
                <input type="date" name="dtBDate" id="bDate" onfocus="bDateF()" min="<?php echo date('Y-m-d',strtotime('-100 years')); ?>" max="<?php echo date('Y-m-d',strtotime('-18 years')); ?>" value="<?php echo $bDate; ?>" <?php if(isset($_POST['btnUpdate'])) echo ""; else echo "disabled"; ?> />
				<span id="bDateV"></span>
            </td>
        </tr>
        <tr>
            <td><label>Gender: </label></td>
            <td>
                <input type="radio" name="rdGender" value="M" <?php if($gender == "M") echo "checked"; ?> <?php if(isset($_POST['btnUpdate'])) echo ""; else echo "disabled"; ?> /><label>Male</label>
                <input type="radio" name="rdGender" value="F" <?php if($gender == "F") echo "checked"; ?> <?php if(isset($_POST['btnUpdate'])) echo ""; else echo "disabled"; ?> /><label>Female</label>
            </td>
        </tr>
        <tr>
            <td><label>Permanent Address:* </label></td>
            <td>
                <textarea rows="5" cols="50" name="txtaPerAdd" id="perAdd" onkeyup="perAddCheck()" onfocus="perAddF()" onblur="perAddB()" <?php if(isset($_POST['btnUpdate'])) echo ""; else echo "disabled"; ?> ><?php echo $perAdd; ?></textarea>
				<span id="perAddMsg"></span>
				<span id="perAddV"></span>
            </td>
        </tr>
        <tr>
            <td><label>Temporary Address: </label></td>
            <td>
                <textarea rows="5" cols="50" name="txtaTempAdd" id="tempAdd" onkeyup="tempAddCheck()"  onfocus="tempAddF()" onblur="tempAddB()" <?php if(isset($_POST['btnUpdate'])) echo ""; else echo "disabled"; ?> ><?php echo $tempAdd; ?></textarea>
				<span id="tempAddMsg"></span>
				<span id="tempAddV"></span>
            </td>
        </tr>
        <tr>
            <td><label>City:* </label></td>
            <td>
                <input type="text" name="txtCity" id="city" onkeyup="cityCheck()" onfocus="cityF()" onblur="cityB()" value="<?php echo $city; ?>" <?php if(isset($_POST['btnUpdate'])) echo ""; else echo "disabled"; ?> />
				<span id="cityMsg"></span>
				<span id="cityV"></span>
            </td>
        </tr>
        <tr>
            <td><label>Profile Picture:* </label></td>
            <td>
                <input type="file" name="fileProPic" id="proPic" onkeyup="proPicCheck()" onfocus="proPicF()" onblur="proPicB()" value="<?php echo $proPic; ?>" <?php if(isset($_POST['btnUpdate'])) echo ""; else echo "disabled"; ?> /><span value="<?php echo $proPic; ?>"><br>
				<span id="proPicMsg"></span>
				<span id="proPicV"></span>
                <?php echo "<img src='../assets/images/ProPicImg/" . $proPic . "' width=50px height=50px>" ?><br>
                <?php echo $proPic; ?></span>
            </td>
        </tr>
        <tr>
            <td><label>Identity Proof:* </label></td>
            <td>
                <input type="file" name="fileIProof" id="iProof" onkeyup="iProofCheck()" onfocus="iProofF()" onblur="iProofB()" value="<?php echo $iProof; ?>" <?php if(isset($_POST['btnUpdate'])) echo ""; else echo "disabled"; ?> /><span value="<?php echo $iProof; ?>"><?php echo $iProof; ?></span>
				<span id="iProofMsg"></span>
				<span id="iProofV"></span>
            </td>
        </tr>
        <tr>
            <td><label>Change Theme: </label></td>
            <td>
                <label <?php if(isset($_POST['btnUpdate'])) echo ""; else echo "disabled"; ?>>
                <input type="radio" name="rdTheme" value="Orange" <?php if($_SESSION['sessTheme'] == "Orange") echo "checked "; if(isset($_POST['btnUpdate'])) echo ""; else echo "disabled"; ?>  />Orange</label>&emsp;
                <label <?php if(isset($_POST['btnUpdate'])) echo ""; else echo "disabled"; ?>>
                <input type="radio" name="rdTheme" value="Lightgreen" <?php if($_SESSION['sessTheme'] == "Lightgreen") echo "checked "; if(isset($_POST['btnUpdate'])) echo ""; else echo "disabled"; ?> />Lightgreen</label>&emsp;
                <label <?php if(isset($_POST['btnUpdate'])) echo ""; else echo "disabled"; ?>>
                <input type="radio" name="rdTheme" value="Skyblue" <?php if($_SESSION['sessTheme'] == "Skyblue") echo "checked "; if(isset($_POST['btnUpdate'])) echo ""; else echo "disabled"; ?> />Sky Blue</label>&emsp;
                <label <?php if(isset($_POST['btnUpdate'])) echo ""; else echo "disabled"; ?>>
                <input type="radio" name="rdTheme" value="White" <?php if($_SESSION['sessTheme'] == "White") echo "checked "; if(isset($_POST['btnUpdate'])) echo ""; else echo "disabled"; ?> />None</label>
            </td>
        </tr>
        <tr>
            <td><input type="submit" value="Edit" name="btnUpdate" id="update" <?php if(isset($_POST['btnUpdate'])) echo "disabled"; else echo ""; ?>/>
            <input type="submit" value="Save" name="btnSave" id="save" <?php if(isset($_POST['btnUpdate'])) echo ""; else echo "disabled"; ?>/></td>
        </tr>
    </table>
</form>
<?php
    include '../Footer.php';
}
else
    echo "Go to Login page & sign in as User.";

if (isset($_POST["btnSave"])) {
    include_once '../SQLConnection.php';
    include_once '../CommonFunctions.php';

    // profile picture
    if($_FILES['fileProPic']['error'] == 4) //means there is no file upload
        $_SESSION['sessProPic'] = $proPic;
    else if(isset($_FILES['fileProPic'])){
        $fileName = $_FILES['fileProPic']['name'];
        $fileTmp = $_FILES['fileProPic']['tmp_name'];
        $fileSize = $_FILES['fileProPic']['size'];
        // 1024 Bytes = 1 KB. Therefore, 1024 Bytes * 100 KB = 102400
        $sizeLimit = 102400;
        try {
            checkFileSize($fileSize,$sizeLimit);
        }
        catch(Exception $e) {
            echo $e->getMessage();
        }
        $filePath = "../assets/images/ProPicImg/";
        if(file_exists($filePath . $fileName)){
            $fileName = renameFileName($filePath,$fileName);
        }
        $_SESSION['sessProPic'] = $fileName;
        move_uploaded_file ($fileTmp, 'C:/xampp/htdocs/ContestManagementSystem/assets/images/ProPicImg/' . $fileName);
    }

    // identity proof
    if($_FILES['fileIProof']['error'] == 4)
        $_SESSION['sessIProof'] = $iProof;
    else if(isset($_FILES['fileIProof'])){
        $fileName = $_FILES['fileIProof']['name'];
        $fileTmp = $_FILES['fileIProof']['tmp_name'];
        $fileSize = $_FILES['fileIProof']['size'];
        // 1024 Bytes = 1 KB & 1024 KB * 1 MB. Therefore, 1024 Bytes * 1024 KB * 2 MB = 2097152
        $sizeLimit = 2097152;
        try {
            checkFileSize($fileSize,$sizeLimit);
        }
        catch(Exception $e) {
            echo $e->getMessage();
        }
        $filePath = "../assets/images/IProofDoc/";
        if(file_exists($filePath . $fileName)){
            $fileName = renameFileName($filePath,$fileName);
        }
        $_SESSION['sessIProof'] = $fileName;
        move_uploaded_file ($fileTmp, 'C:/xampp/htdocs/ContestManagementSystem/assets/images/IProofDoc/' . $fileName);
    }

    $email = $_SESSION['sessUserDetails']['emailId'];
    $sql = "SELECT userId FROM Registration WHERE emailId = '$email';";
    $result = $con->query($sql);
    $row = $result->fetch_assoc();
    // print_r($row);
    $uId = $row['userId'];

    //checking that email exists or not
    $emailQuery = mysqli_query($con,"SELECT emailId FROM Registration WHERE emailId = '$email' AND userId <> '$uId';");

    //checking that username exists or not
    $un = trim($_POST['txtUn']);
    $unQuery = mysqli_query($con,"SELECT username FROM Registration WHERE username = '$un' AND userId <> '$uId';");

    //checking that mobile no exists or not
    $mobileNo = trim($_POST['txtMobileNo']);
    $mobileNoQuery = mysqli_query($con,"SELECT mobileNo FROM Registration WHERE mobileNo = '$mobileNo' AND userId <> '$uId';");

    //checking that emergency mobile no exists or not
    $emergencyContactNo = trim($_POST['txtEmergencyContactNo']);
    $emergencyContactNoQuery = mysqli_query($con,"SELECT emergencyContactNo FROM Registration WHERE emergencyContactNo = '$emergencyContactNo' AND userId <> '$uId';");

    if(mysqli_num_rows($emailQuery)>0)
        echo "<script>alert('Email already exists! Please try with another email!');window.location.replace('UserUpdateProfile.php')</script>";
    else if(mysqli_num_rows($unQuery)>0)
        echo "<script>alert('Username already exists! Please try with another username!');window.location.replace('UserUpdateProfile.php')</script>";
    else if(mysqli_num_rows($mobileNoQuery)>0)
        echo "<script>alert('Mobile No. already exists! Please try with another mobile number!');window.location.replace('UserUpdateProfile.php')</script>";
    else if(mysqli_num_rows($emergencyContactNoQuery)>0)
        echo "<script>alert('Emergency Contact No. already exists! Please try with another number!');window.location.replace('UserUpdateProfile.php')</script>";
    else{
        //insertion with prepared statement
        $query = "UPDATE Registration SET firstName=?,middleName=?,lastName=?,mobileNo=?,emergencyContactNo=?,emailId=?,username=?,password=?,birthDate=?,gender=?,permanentAdd=?,temporaryAdd=?,city=?,registrationDt=?,profilePic=?,identityProof=?,theme=? WHERE userId = $uId;";
        if($stmt = $con->prepare($query)){
            $stmt->bind_param("sssssssssssssssss",$fn,$mn,$ln,$mobileNo,$emergencyContactNo,$email,$un,$pass,$bdate,$gender,$perAdd,$tempAdd,$city,$curDate,$proPic,$iProof,$theme);
            $fn = ucfirst(trim($_POST['txtFn']));
            $mn = ucfirst(trim($_POST['txtMn']));
            $ln = ucfirst(trim($_POST['txtLn']));
            $pass = md5($_POST['txtPass']);
            $bdate = $_POST['dtBDate'];
            $gender = $_POST['rdGender'];
            $perAdd = trim($_POST['txtaPerAdd']);
            $tempAdd = trim($_POST['txtaTempAdd']);
            $city = trim($_POST['txtCity']);
            $curDate = date("Y-m-d h-i-s");
            $proPic = $_SESSION['sessProPic'];
            $iProof = $_SESSION['sessIProof'];
            $theme = $_POST['rdTheme'];
            $_SESSION['sessTheme'] = $theme;
            $stmt->execute();
            if($stmt)
                echo "<script>alert('Profile Updated Succesfully!');window.location.replace('UserHome.php');</script>";
            else
                echo "<script>alert('Profile Not Updated!');</script>";
        $stmt->close();
        }
    }
    $con->close();
}
?>
</body>
</html>