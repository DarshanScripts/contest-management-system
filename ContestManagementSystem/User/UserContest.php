<?php
session_start();
?>
<head>
	<style>
		img{
			transition: width 0.5s ease-in-out, height 0.5s ease-in-out;	
		}
		img:hover{
			width: 220px;
			height: 150px;
		}
		button{
			transition: background-color 0.2s ease-in-out;	
		}
		button:hover{
			background-color:aquamarine;
		}
	</style>
</head>

<body bgcolor="<?php if(isset($_SESSION['sessTheme'])) echo $_SESSION['sessTheme']; ?>">
<?php
if(isset($_POST['btnContestRegister'])){
	include_once '../CommonFunctions.php';
	include_once '../SQLConnection.php';

	$_SESSION['sesscId'] = $_POST['btnContestRegister'];
	$cId = $_SESSION['sesscId'];
	$userId = $_SESSION['sessUserDetails']['userId'];
	$curDate = date("Y-m-d");

	$sql = "SELECT cName, cDate FROM Contest WHERE cId = $cId;";
	$result = $con->query($sql);
	$row = $result->fetch_assoc();

	// check if user is already registered 
	// $contestQuery = mysqli_query($con,"SELECT cId FROM Participation WHERE cId = $cId AND userId = $userId;");

	// checking that user has registered in how many contests, if more than 2 then dont allow to register
	$contestQuery2 = mysqli_query($con,"SELECT pId FROM Participation WHERE userId = $userId AND MONTH(participantRegistrationDate) = MONTH(NOW()) AND YEAR(participantRegistrationDate) = YEAR(NOW());");
	
	// checking that user has registered in how many contests, if more than 2 then dont allow to register
	$participationHistoryQuery = mysqli_query($con,"SELECT pId FROM Contest,ContestLevel,Participation WHERE Contest.cId = Participation.cId AND cType = clId AND userId = $userId AND participantRegistrationDate > DATE_SUB(CURDATE(),INTERVAL 3 MONTH);");
	
	// if(mysqli_num_rows($contestQuery)>0){
	// 	echo "<script>alert('Already registered in this contest!');window.location.replace('UserContest.php')</script>";
	// 	exit();
	// }
	if(mysqli_num_rows($contestQuery2)>=2 && mysqli_num_rows($participationHistoryQuery)>0){
			header("location: ThirdContest.php");
		
		// echo "<script>alert('You cannot register in this contest because you have already registered in 2 contests this month!');window.location.replace('UserContest.php');</script>";
		// exit();
	}
	else if(mysqli_num_rows($contestQuery2)>=3 && mysqli_num_rows($participationHistoryQuery)>0){
		echo "<script>alert('You cannot register in this contest because you have already registered in 3 contests this month!');window.location.replace('UserContest.php');</script>";
		exit();
	}
	else
		addParticipant();
}

if (isset($_SESSION['sessLoginCheck']) && $_SESSION['sessUserDetails']['emailId'] != "coordinator@gmail.com") {
	include './UserHeader.php';

	include_once '../SQLConnection.php';
	$sql = "SELECT cId, cName, cLevel, cDate, cBanner FROM Contest,ContestLevel WHERE cType = clId ORDER BY cId;";
	$result = $con->query($sql);

	if ($result->num_rows > 0) {
		echo "<h1 align='center'>Available Contests</h1>
			<table cellpadding=20 cellspacing=0 align='center'><tr>";
		$i=1;
		while($row = $result->fetch_assoc()) {
			$contestDate = $row['cDate'];
			$date1=date_create(date('Y-m-d'));
			$date2=date_create($contestDate);
			$diff=date_diff($date1,$date2);

			$userId = $_SESSION['sessUserDetails']['userId'];
			$contestQuery = mysqli_query($con,"SELECT cId FROM Participation WHERE cId = $i AND userId = $userId;");
			if(mysqli_num_rows($contestQuery)>0)
				$checkRegUser = " disabled";
			else 
				$checkRegUser = "";
			
			if(($diff->format('%m') > 0 && $diff->format('%d') >= 0) || ($diff->format('%m') == 0 && $diff->format('%d') >= 2)){
				include_once '../CommonFunctions.php';
				$filePath = "<img src='../assets/images/BannerImg/" . $row["cBanner"] ."' width='200px' height='140px'>";
				echo "<th>Contest-" . $row['cId'] . "<br>" . $row['cName'] . " - " . $row['cLevel'] . "<br>" . $row['cDate'] . "<br>" . $filePath . "<br><form action='' method='POST'><br><button type='submit' name='btnContestRegister' value='" . $row['cId'] . "' $checkRegUser >Click here to Register</button></th>";
			}
			if($i%2==0)
				echo "</tr><tr>";
			$i++;
		}
		echo "</table>";
	}
	else
		echo "No contest available!";

	$con->close();
	include '../Footer.php';
}
else
	echo "Go to Login page & sign in as User.";

?>
</body>