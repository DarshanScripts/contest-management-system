<?php
session_start();
?>

<body bgcolor="<?php if (isset($_SESSION['sessTheme'])) echo $_SESSION['sessTheme']; ?>">
	<?php
	if (isset($_SESSION['sessLoginCheck']) && $_SESSION['sessUserDetails']['emailId'] != "coordinator@gmail.com") {
		include './UserHeader.php';
		include_once '../SQLConnection.php';

		$row = $_SESSION['sessUserDetails'];
		$userId = $row['userId'];

		$participationHistoryQuery = "SELECT cName, cLevel, participantRegistrationDate FROM Contest,ContestLevel,Participation WHERE Contest.cId = Participation.cId AND cType = clId AND userId = $userId AND participantRegistrationDate > DATE_SUB(CURDATE(),INTERVAL 1 YEAR);";
		$result = $con->query($participationHistoryQuery);

		// print_r($result);
		echo "<h1 align='center'>Participant History</h1>";
		if ($result->num_rows > 0) {
			echo "<table cellpadding='10' cellspacing='0' border='1' align='center'><tr><th>Contest Name</th><th>Contest Level</th><th>Contest Registration Date</th></tr>";
			while ($row = $result->fetch_assoc())
				// print_r($row);
				echo "<tr><td>" . $row['cName'] . "</td><td>" . $row['cLevel'] . "</td><td>" . $row['participantRegistrationDate'] . "</td></tr>";
			echo "</table>";
		} else
			echo "<h3 align='center'>You are not registered in any contest in the current year.</h3>";

		include '../Footer.php';
	} else
		echo "Go to Login page & sign in as User.";
	?>
</body>