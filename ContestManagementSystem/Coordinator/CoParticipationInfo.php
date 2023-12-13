<?php
session_start();

if (isset($_SESSION['sessLoginCheck']) && $_SESSION['sessUserDetails']['emailId'] == "coordinator@gmail.com") {
	include './CoHeader.php';
	include_once '../SQLConnection.php';
	$sql = "SELECT Registration.userId, firstName, middleName, lastName, emailId, cName, participantRegistrationDate FROM Registration, Contest, Participation WHERE Registration.userId = Participation.userId AND Contest.cId = Participation.cId";
	$result = $con->query($sql);

	if ($result->num_rows > 0) {
		echo "<h1 align='center'>List of Participants</h1>
			<table cellpadding=10 cellspacing=0 border=1 align='center'><tr>
			<th>Name</th>
			<th>Contest Name</th>
			<th>Participant Registration Date</th></tr>";
		// output data of each row
		while($row = $result->fetch_assoc()) {
			if($row['emailId'] != "coordinator@gmail.com"){
				$id = $row['userId'];
				echo "<tr><td>" . $row['firstName'] . " " . $row['middleName'] . " "  . $row['lastName'] . "</td>
					<td>" . $row['cName'] . "</td>
					<td>" . $row['participantRegistrationDate'] . "</td></tr>";
			}
		}
		echo "</table>";
	}
	else
		echo "Participant is 0!";

	$con->close();
	include '../Footer.php';
}
else
	echo "Go to Login page & sign in as Coordinator.";
?>