<?php
@session_start();

date_default_timezone_set('Asia/Kolkata');

//function to rename file name because the uploaded file by user already exists
function renameFileName($filePath, $fileName)
{
	$fileName2 = $fileName;
	$increment = 1;
	while (file_exists($filePath . $fileName2)) {
		list($name, $ext) = explode('.', $fileName);
		$fileName2 = $name . "(" . $increment . ').' . $ext;
		$increment++;
	}
	return $fileName2;
}


//function to check the file size i.e. uploaded by user
function checkFileSize($fileSize, $sizeLimit)
{
	if ($sizeLimit == 102400) {
		if ($fileSize > $sizeLimit) {
			echo "<script>alert('Image size must be less than or equal to 100 KB.');window.location.replace('Registration.php')</script>";
			exit();
		}
	} else if ($sizeLimit == 2097152) {
		if ($fileSize > $sizeLimit) {
			echo "<script>alert('Document size must be less than or equal to 2 MB.');window.location.replace('Registration.php')</script>";
			exit();
		}
	}
}


// function to add the registration details of user in Registraation table
function addUser($fn, $mn, $ln, $mobileNo, $emergencyContactNo, $email, $un, $pass, $bdate, $gender, $perAdd, $tempAdd, $city, $curDate, $proPic, $iProof)
{
	include_once './SQLConnection.php';

	//checking that email, username, mobile no., emergency mobile no. exists or not
	$emailQuery = mysqli_query($con, "SELECT emailId FROM Registration WHERE emailId = '$email'");
	$unQuery = mysqli_query($con, "SELECT username FROM Registration WHERE username = '$un'");
	$mobileNoQuery = mysqli_query($con, "SELECT mobileNo FROM Registration WHERE mobileNo = '$mobileNo'");
	$emergencyContactNoQuery = mysqli_query($con, "SELECT emergencyContactNo FROM Registration WHERE emergencyContactNo = '$emergencyContactNo'");

	if (mysqli_num_rows($emailQuery) > 0) {
		echo "<script>alert('Email already exists! Please try with another email!');window.location.replace('Registration.php')</script>";
		exit();
	} else if (mysqli_num_rows($unQuery) > 0) {
		echo "<script>alert('Username already exists! Please try with another username!');window.location.replace('Registration.php')</script>";
		exit();
	} else if (mysqli_num_rows($mobileNoQuery) > 0) {
		echo "<script>alert('Mobile No. already exists! Please try with another mobile number!');window.location.replace('Registration.php')</script>";
		exit();
	} else if (mysqli_num_rows($emergencyContactNoQuery) > 0) {
		echo "<script>alert('Emergency Contact No. already exists! Please try with another number!');window.location.replace('Registration.php')</script>";
		exit();
	} else {
		// insertion with prepared statement
		$query = "INSERT INTO Registration(firstName,middleName,lastName,mobileNo,emergencyContactNo,emailId,username,password,birthDate,gender,permanentAdd,temporaryAdd,city,registrationDt,profilePic,identityProof) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
		if ($stmt = $con->prepare($query)) {
			$stmt->bind_param("ssssssssssssssss", $fn, $mn, $ln, $mobileNo, $emergencyContactNo, $email, $un, $pass, $bdate, $gender, $perAdd, $tempAdd, $city, $curDate, $proPic, $iProof);
			$stmt->execute();
			if ($stmt) {
				// echo "<script>alert('Registered Succesfully!');</script>";
				echo "<script>alert('Registered Succesfully!');window.location.replace('Login.php');</script>";
			} else
				echo "<script>alert('Not Registered!');</script>";
			$stmt->close();
		}
	}
	$con->close();
}


// function updateUser($fn,$mn,$ln,$mobileNo,$emergencyContactNo,$email,$un,$pass,$bdate,$gender,$perAdd,$tempAdd,$city,$curDate,$proPic,$iProof,$theme){
// 	include_once './SQLConnection.php';

//     $sql = "SELECT userId FROM Registration WHERE emailId = '$email';";
//     $result = $con->query($sql);
//     $row = $result->fetch_assoc();

//     $uId = $row['userId'];

//     //checking that email exists or not
//     $emailQuery = mysqli_query($con,"SELECT emailId FROM Registration WHERE emailId = '$email' AND userId <> '$uId';");

//     //checking that username exists or not
//     $unQuery = mysqli_query($con,"SELECT username FROM Registration WHERE username = '$un' AND userId <> '$uId';");

//     //checking that mobile no exists or not
//     $mobileNoQuery = mysqli_query($con,"SELECT mobileNo FROM Registration WHERE mobileNo = '$mobileNo' AND userId <> '$uId';");

//     //checking that emergency mobile no exists or not
//     $emergencyContactNoQuery = mysqli_query($con,"SELECT emergencyContactNo FROM Registration WHERE emergencyContactNo = '$emergencyContactNo' AND userId <> '$uId';");

//     if(mysqli_num_rows($emailQuery)>0)
//         echo "<script>alert('Email already exists! Please try with another email!');window.location.replace('UserUpdateProfile.php')</script>";
//     else if(mysqli_num_rows($unQuery)>0)
//         echo "<script>alert('Username already exists! Please try with another username!');window.location.replace('UserUpdateProfile.php')</script>";
//     else if(mysqli_num_rows($mobileNoQuery)>0)
//         echo "<script>alert('Mobile No. already exists! Please try with another mobile number!');window.location.replace('UserUpdateProfile.php')</script>";
//     else if(mysqli_num_rows($emergencyContactNoQuery)>0)
//         echo "<script>alert('Emergency Contact No. already exists! Please try with another number!');window.location.replace('UserUpdateProfile.php')</script>";
//     else{
//         //insertion with prepared statement
//         $query = "UPDATE Registration SET firstName=?,middleName=?,lastName=?,mobileNo=?,emergencyContactNo=?,emailId=?,username=?,password=?,birthDate=?,gender=?,permanentAdd=?,temporaryAdd=?,city=?,registrationDt=?,profilePic=?,identityProof=?,theme=? WHERE userId = $uId;";
//         if($stmt = $con->prepare($query)){
//             $stmt->bind_param("sssssssssssssssss",$fn,$mn,$ln,$mobileNo,$emergencyContactNo,$email,$un,$pass,$bdate,$gender,$perAdd,$tempAdd,$city,$curDate,$proPic,$iProof,$theme);
//             $_SESSION['sessTheme'] = $theme;
//             $stmt->execute();
//             if($stmt)
//                 echo "<script>alert('Profile Updated Succesfully!');window.location.replace('UserHome.php');</script>";
//             else
//                 echo "<script>alert('Profile Not Updated!');</script>";
//         $stmt->close();
//         }
//     }
//     $con->close();
// }

//function to get access into the system
function doLogin($email, $pass, $remember)
{
	include_once './SQLConnection.php';
	// global $con;
	$stmt = $con->prepare("SELECT * FROM Registration WHERE emailId=? AND password=? LIMIT 1");
	$stmt->bind_param("ss", $email, md5($pass));
	$stmt->execute();
	$result = $stmt->get_result();
	$row = $result->fetch_assoc();

	$_SESSION['sessUserDetails'] = $row;

	$userId =  $row['userId'];
	$theme =  $row['theme'];
	$_SESSION['sessTheme'] = $theme;

	if ($row && $email == "coordinator@gmail.com" && md5($pass) == "e42629fa1b1ef187a2b1ef7ac5d31ca2") { // md5("pass@co1");
		if ($remember == "on") {
			//setting cookie for 5 years
			setcookie("ckEmail", $email, time() + 60 * 60 * 24 * 30 * 12 * 5);
			setcookie("ckPass", $pass, time() + 60 * 60 * 24 * 30 * 12 * 5);
		}
		onlineUser($userId);
		header("location: Coordinator/CoDashboard.php");
	} else if ($row) {
		if ($remember == "on") {
			//setting cookie for 5 years
			setcookie("ckEmail", $email, time() + 60 * 60 * 24 * 30 * 12 * 5);
			setcookie("ckPass", $pass, time() + 60 * 60 * 24 * 30 * 12 * 5);
			setcookie("ckLoginTime", date('Y-m-d h:i:s'), time() + 60 * 60 * 24 * 30); //30 days
		}
		if ($row['status'] == 'a') {
			onlineUser($userId);
			header("location: User/UserHome.php");
		} else
			echo "<script>alert('Your account is deactivated by admin!');window.location.replace('Login.php');</script>";
		exit();
	} else
		echo "<script>alert('Invalid Username or Password!');window.location.replace('Login.php');</script>";
	exit();
}


//funtion to add the contest details
function addContest($name, $level, $date, $duration, $description, $fileName)
{
	include_once '../SQLConnection.php';

	//checking that contest name exists or not
	$nameQuery = mysqli_query($con, "SELECT cName FROM Contest WHERE cName = '$name'");
	if (mysqli_num_rows($nameQuery) > 0)
		echo "<script>alert('Contest name already exists! Please try with another name!');window.location.replace('CoManageContest.php')</script>";
	else {
		//insertion with prepared statement
		$query = "INSERT INTO Contest(cName,cType,cDate,cDuration,cDescription,cBanner) VALUES(?,?,?,?,?,?)";
		if ($stmt = $con->prepare($query)) {
			$stmt->bind_param("sisiss", $name, $level, $date, $duration, $description, $fileName);
			$stmt->execute();
			if ($stmt) {
				echo "<script>alert('Contest Added Succesfully!');window.location.replace('CoManageContest.php');</script>";
			} else
				echo "<script>alert('Invalid Details! Please try again.');</script>";
			$stmt->close();
		}
	}
	$con->close();
}


//function to add participant in the contest
function addParticipant()
{
	// include_once '../SQLConnection.php';
	// global $con;
	$con = new mysqli("localhost", "root", "", "ContestManagementSystem");
	$userId = $_SESSION['sessUserDetails']['userId'];
	$cId = $_SESSION['sesscId'];

	$curDate = date("Y-m-d");

	$sql = "SELECT cName, cDate FROM Contest WHERE cId = $cId;";
	$result = $con->query($sql);
	$row = $result->fetch_assoc();

	// $sql = "DROP PROCEDURE IF EXISTS insertParticipationInfo;";
	// $sql2 = "CREATE PROCEDURE insertParticipationInfo(cId INT, userId INT, participantRegistrationDate DATE)
	// 		INSERT INTO Participation(cId,userId,participantRegistrationDate) VALUES(cId,userId,participantRegistrationDate);";
	// $con->query($sql);
	// $con->query($sql2);
	$query = "CALL insertParticipationInfo(?,?,?)";
	// $query = "INSERT INTO Participation(cId, userId, participantRegistrationDate) VALUES(?,?,?)";
	if ($stmt = $con->prepare($query)) {
		$stmt->bind_param("iis", $cId, $userId, $curDate);
		$pName = $_SESSION['sessUserDetails']['firstName'] . " " . $_SESSION['sessUserDetails']['middleName'] . " " . $_SESSION['sessUserDetails']['lastName'];
		$cName = $row['cName'];
		$cDate = $row['cDate'];
		$date1 = date_create($curDate);
		$date2 = date_create($cDate);
		$diff = date_diff($date1, $date2);
		$cRemainDays = $diff->format('%m month %d days');
		$stmt->execute();
		if ($stmt) {
			echo "<script>alert('Registered Succesfully!    Participant Name: $pName    Participant Date: $curDate    Contest Name: $cName    Contest Date: $cDate    Remaining Days: $cRemainDays');</script>";
		} else {
			echo "<script>alert('Not Registered!');</script>";
		}
		echo "<script>window.location.replace('UserContest.php');</script>";
		exit();
		$stmt->close();
	} else
		die("Query Failed!");
}

//function to count current online users
// function onlineUsers(){
// 	// include_once './SQLConnection.php';

// 	$con = new mysqli("localhost","root","","ContestManagementSystem");
// 	// global $con;
// 	$sessionId = session_id();
// 	$time = time();
// 	$timeCheck = $time - 60;

// 	$sql = "SELECT * FROM OnlineUsers WHERE sessionId = '$sessionId';";
// 	$result = mysqli_query($con,$sql);
// 	$count = mysqli_num_rows($result);

// 	if($count == NULL)
// 		mysqli_query($con, "INSERT INTO OnlineUsers(sessionId,ouTime) VALUES('$sessionId',$time);");
// 	else
// 		mysqli_query($con, "UPDATE OnlineUsers SET ouTime = $time WHERE sessionId = '$sessionId';");

// 	//counting total users
// 	$result = mysqli_query($con,"SELECT * FROM OnlineUsers");
// 	$countOnlineUsers = mysqli_num_rows($result);
// 	echo "Users Online: ".$countOnlineUsers;

// 	// after 30 seconds, session will be deleted
// 	$sql = "DELETE FROM OnlineUsers WHERE ouTime < $timeCheck";
// 	$result = mysqli_query($con, $sql);

// 	$con->close();
// }



//function to count current online users
function onlineUser($userId)
{
	$con = new mysqli("localhost", "root", "", "ContestManagementSystem");
	// include_once './SQLConnection.php';
	$_SESSION['sessUserId'] = $userId;
	mysqli_query($con, "INSERT INTO OnlineUsers VALUES($userId);");
}

// function to delete online users when logout
function offlineUser($userId)
{
	include_once "./SQLConnection.php";
	mysqli_query($con, "DELETE FROM OnlineUsers WHERE userId = $userId;");
}

// function to display to total online users
function displayOnlineUsers()
{
	//counting total users
	include_once '../SQLConnection.php';
	$result = mysqli_query($con, "SELECT * FROM OnlineUsers");
	$countOnlineUsers = mysqli_num_rows($result);
	echo "Users Online: " . $countOnlineUsers;
}


// function to add scores of participant
function addScores($pIds, $judgesScore)
{
	// include_once '../SQLConnection.php';
	$con = new mysqli("localhost", "root", "", "ContestManagementSystem");
	// echo "<pre>"; print_r($pIds); echo "</pre>";
	// echo "<pre>"; print_r($judgesScore); echo "</pre>";

	$i = 1;
	$scoreSum = array();
	while ($row = $pIds->fetch_assoc()) {
		$pId = $row['pId'];
		// inserting the scores in Result relation
		$query = "INSERT INTO Result VALUES(?,?,?,?,?,?);";
		if ($stmt = $con->prepare($query)) {
			$stmt->bind_param('iiiiis', $pId, $j1Score, $j2Score, $j3Score, $timeTaken, $curDate);
			//fetching all judges score & time for a particular participant
			$j1Score = $judgesScore["j1Score$i"];
			$j2Score = $judgesScore["j2Score$i"];
			$j3Score = $judgesScore["j3Score$i"];
			$totalScore = $j1Score + $j2Score + $j3Score;
			$scoreSum[$pId] = $totalScore;
			$timeTaken = $judgesScore["timeTaken$i"];
			$curDate = date('Y-m-d');
			$stmt->execute();
			$stmt->close();
			$i++;
		} else
			die("Query Failed!");
	}
	// finding max score
	$maxScore = max($scoreSum);
	$maxKey = array_search($maxScore, $scoreSum);
	echo "<pre>";
	print_r($scoreSum);
	echo "</pre>";

	echo $maxKey . "<br>";
	echo $maxScore . "<br>";

	echo "<script>alert('Scores added successfully!');window.location.replace('CoContestResult.php');</script>";
	exit();
}
