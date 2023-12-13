<?php
session_start();
date_default_timezone_set('Asia/Kolkata');
include './CoHeader.php';
include_once '../SQLConnection.php';
$cId = $_SESSION['sessSelectedContest'];
$result = mysqli_query($con, "SELECT cName,cDate,cLevel FROM Contest, ContestLevel WHERE cId = $cId && cType = clId;");
$row = $result->fetch_assoc();

echo "<h2 align='center'>" . $row['cName'] . "</h2>";
echo "<h2 align='center'>" . $row['cDate'] . "&emsp;" . $row['cLevel'] . "</h2>";

// winner
if ($result->num_rows > 0) {
	echo "<br><h3 style='padding-left: 30%;'>Winner:</h3>";
	echo "<table cellpadding=20 cellspacing=0 align='center' border=1>
		<tr>
			<th>Name</th>
			<th>Total Score</th>
			<th>Average Score</th>
			<th>Time Taken(in minutes)</th>
		</tr>";

	// $sql = "SELECT R1.firstName, R1.lastName, R2.firstName, R2.lastName, scoreByJudge1, scoreByJudge2, scoreByJudge3, CR.timeTaken
	// 		FROM ContestResult CR, Participation P1, Participation P2, Registration R1, Registration R2
	// 		WHERE C.cId = CR.cId 
	// 		AND CR.winnerPid = P1.pId 
	// 		AND P1.userId = R1.userId 
	// 		AND CR.runnerupPid = P2.pId 
	// 		AND P2.userId = R2.userId;";

	$sql = "SELECT Result.pId,timeTaken,(scoreByJudge1+scoreByJudge2+scoreByJudge3) AS sum,scoreEntryDate FROM Result,Participation WHERE Result.pId = Participation.pId AND Participation.cId = $cId ORDER BY sum DESC, timeTaken ASC LIMIT 2";
	$result = mysqli_query($con, $sql);
	$row = $result->fetch_assoc();
	// echo "<pre>"; print_r($row); echo "</pre>";

	//fetching pId to fetch uId
	$pId = $row['pId'];
	$scoreDate = $row['scoreEntryDate'];
	//fetching userId
	$sql2 = "SELECT userId FROM Participation WHERE pId = $pId";
	$result2 = mysqli_query($con, $sql2);
	$row2 = $result2->fetch_assoc();
	// echo "<pre>"; print_r($row2); echo "</pre>";
	$userId = $row2['userId'];

	$sql3 = "SELECT firstName,middleName,lastName,profilePic FROM Registration WHERE userId = $userId";
	$result3 = mysqli_query($con, $sql3);
	$row3 = $result3->fetch_assoc();
	// echo "<pre>"; print_r($row3); echo "</pre>";


	// $totalScore = $row['scoreByJudge1'] + $row['scoreByJudge2'] + $row['scoreByJudge3'];
	$avgScore = $row['sum'] / 3;
	echo "<tr align=center>
		<td>" . $row3['firstName'] . " " . $row3['lastName'] . "<br><img src='../assets/images/ProPicImg/" . $row3['profilePic'] . "' width=50px height=50px>" . "</td>
		<td>" . $row['sum'] . "</td>
		<td>" . $avgScore . "</td>
		<td>" . $row['timeTaken'] . "</td>";

	echo "</table>";
}
$row = $result->fetch_assoc();
// echo "<pre>"; print_r($row); echo "</pre>";


if ($result->num_rows > 1) {
	// runner up
	echo "<br><h3 style='padding-left: 30%;'>Runner Up:</h3>";
	echo "<table cellpadding=20 cellspacing=0 align='center' border=1>
		<tr>
			<th>Name</th>
			<th>Total Score</th>
			<th>Average Score</th>
			<th>Time Taken(in minutes)</th>
		</tr>";

	//fetching pId to fetch uId
	$pId2 = $row['pId'];

	//fetching userId
	$sql2 = "SELECT userId FROM Participation WHERE pId = $pId2";
	$result2 = mysqli_query($con, $sql2);
	$row2 = $result2->fetch_assoc();
	// echo "<pre>"; print_r($row2); echo "</pre>";
	$userId = $row2['userId'];

	$sql3 = "SELECT firstName,middleName,lastName,profilePic FROM Registration WHERE userId = $userId";
	$result3 = mysqli_query($con, $sql3);
	$row3 = $result3->fetch_assoc();
	// echo "<pre>"; print_r($row3); echo "</pre>";


	// $totalScore = $row['scoreByJudge1'] + $row['scoreByJudge2'] + $row['scoreByJudge3'];
	$avgScore = $row['sum'] / 3;
	echo "<tr align=center>
		<td>" . $row3['firstName'] . " " . $row3['lastName'] . "<br><img src='../assets/images/ProPicImg/" . $row3['profilePic'] . "' width=50px height=50px>" . "</td>
		<td>" . $row['sum'] . "</td>
		<td>" . $avgScore . "</td>
		<td>" . $row['timeTaken'] . "</td>";

	echo "</table>";

	//date and time
	echo "<h3 style='padding-left: 30%;'>" . date("d-m-Y h:i:s") . "</h3>";

	$query = "INSERT INTO ContestResult(cId,winnerPid,runnerupPid,timeTaken,scoreEntryDate) VALUES(?,?,?,?,?)";
	if ($stmt = $con->prepare($query)) {
		$stmt->bind_param("iiiis", $cId, $pId, $pId2, $row['timeTaken'], $scoreDate);
		$stmt->execute();
		if ($stmt) {
			// echo "<script>alert('Registered Succesfully!');</script>";
			echo "<script>alert('Contest Result Added Succesfully!');</script>";
		} else
			echo "<script>alert('Not Added!');</script>";
		$stmt->close();
	}
}
include '../Footer.php';
