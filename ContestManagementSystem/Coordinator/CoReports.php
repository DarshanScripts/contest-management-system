<?php
session_start();
?>
<head>
	<script src="../Validation.js"></script>
	<script>	
		function onLoadHideDate(){
			document.getElementById("dateAddBlock").style.display = "none";
		}

		// temporary add hide/show
		function showDateBlock(){
			var date = document.getElementById("checkDate").checked;
			if(date)
				document.getElementById("dateAddBlock").style.display = "table-row";
			else
				document.getElementById("dateAddBlock").style.display = "none";
		}
	</script>
</head>
<body onload="onLoadHideDate()">

<?php
if (isset($_SESSION['sessLoginCheck']) && $_SESSION['sessUserDetails']['emailId'] == "coordinator@gmail.com") {
	include './CoHeader.php';
	?>
	<h1 align=center>Reports</h1>
	<form method="POST">
		<table align=center>
			<tr>
				<td>
					<fieldset style="width: 800px;">
						<legend>Choose anyone Report</legend>
						<input type="radio" name="rdReports" value="1" onclick="showDateBlock()">Top two participant details who have secure maximum winner count.<br>
						<input type="radio" name="rdReports" value="2" onclick="showDateBlock()">List of top five areas (city), from where maximum participant have participated in various contest.<br>
						<input type="radio" name="rdReports" value="3" onclick="showDateBlock()">List top three contest which have maximum participation.<br>
						<input type="radio" name="rdReports" value="4" onclick="showDateBlock()" id="checkDate">Generate to date to from date contest organized report.<br>
						<input type="radio" name="rdReports" value="5" onclick="showDateBlock()">View contest wise winner and runner up detail report.<br><br>
						<button type="submit" name="btnGenerateReport">Generate Report</button>
					</fieldset>
				</td>
			</tr>
		</table>
		<br><br>
		<table cellpadding="5" cellspacing="10" align="center">
			<tr id="dateAddBlock">
				<td><label>From: </label></td>
				<td>
					<input type="date" name="dtFrom" id="dtFrom" min="<?php echo date('Y-m-d'); ?>" value="<?php echo date('Y-m-d'); ?>"/>
				</td>
				<td><label>To: </label></td>
				<td>
					<input type="date" name="dtTo" id="dtTo" min="<?php echo date('Y-m-d'); ?>" value="2024-01-01"/>
				</td>
			</tr>
		</table>
	</form>
	
	<?php
	if(isset($_POST['btnGenerateReport'])){
		// echo "Hi";
		// print_r($_POST);
		include_once "../SQLConnection.php";
		echo "<table cellpadding='10' cellspacing='0' border='1' align='center'><tr>";
		if($_POST['rdReports'] == 1){
			echo "<h3 align='center'>Top two participant details who have secure maximum winner count</h3>";
			echo "<th>Name</th><th>Mobile No.</th><th>Email</th><th>Winner Count</th></tr>";
			$sql = "SELECT userId,firstName,middleName,lastName,mobileNo,emailId,winnerCount FROM Registration
					ORDER BY winnerCount DESC
					LIMIT 2;";
			$result = mysqli_query($con, $sql);
			while($row = $result->fetch_assoc()){
				echo "<tr><td>".$row['firstName']." ".$row['middleName']." ".$row['lastName']."</td><td>".$row['mobileNo']."</td><td>".$row['emailId']."</td><td>".$row['winnerCount']."</td>";
			}
		}
		else if($_POST['rdReports'] == 2){
			echo "<h3 align='center'>Top five cities, from where maximum participant have participated in various contest</h3>";
			echo "<th>City</th><th>No. of Users</th></tr>";
			$sql = "SELECT city, COUNT(*) AS numOfUsers FROM Registration
					GROUP BY city
					ORDER BY numOfUsers DESC
					LIMIT 5;";
			$result = mysqli_query($con, $sql);
			while($row = $result->fetch_assoc()){
				echo "<tr><td>".$row['city']."</td><td>".$row['numOfUsers']."</td>";
			}
		}
		else if($_POST['rdReports'] == 3){
			echo "<h3 align='center'>Top three contest which have maximum participation</h3>";
			echo "<th>Contest Name</th><th>No. of Participant</th></tr>";
			$sql = "SELECT C.cName, COUNT(P.pId) AS participantCount
					FROM Contest C, Participation P 
					WHERE C.cId = P.cId
					GROUP BY C.cId
					ORDER BY participantCount DESC
					LIMIT 3";
			$result = mysqli_query($con, $sql);
			while($row = $result->fetch_assoc()){
				echo "<tr><td>".$row['cName']."</td><td>".$row['participantCount']."</td>";
			}
		}
		else if($_POST['rdReports'] == 4){
			echo "<h3 align='center'>To date to from date contest organized report</h3>";
			$fromDate = $_POST['dtFrom'];
			$toDate = $_POST['dtTo'];
			echo "<th>Contest Name</th><th>Contest Level</th><th>Date</th></tr>";
			$sql = "SELECT C.cId, C.cName, C.cType, C.cDate, C.CDuration, C.cDescription, CL.cLevel
					FROM Contest C, ContestLevel CL
					WHERE  C.cType = CL.clId AND C.cDate BETWEEN '$fromDate' AND '$toDate';";
			$result = mysqli_query($con, $sql);
			while($row = $result->fetch_assoc()){
				echo "<tr><td>".$row['cName']."</td><td>".$row['cLevel']."</td><td>".$row['cDate']."</td>";
			}
		}
		else if($_POST['rdReports'] == 5){
			echo "<h3 align='center'>Contest wise winner and runner up detail report</h3>";
			echo "<th>Participant Name</th><th>Contest Name</th><th>Contest Level</th><th>Date</th></tr>";
			$sql = "SELECT C.cName, CL.cLevel, R1.firstName, R1.lastName, R2.firstName, R2.lastName, CR.timeTaken, CR.scoreEntryDate
					FROM Contest C, ContestLevel CL, ContestResult CR, Participation P1, Participation P2, Registration R1, Registration R2
					WHERE C.cId = CR.cId 
					AND C.cId = CL.clId
					AND CR.winnerPid = P1.pId 
					AND P1.userId = R1.userId 
					AND CR.runnerupPid = P2.pId 
					AND P2.userId = R2.userId;";
			$result = mysqli_query($con, $sql);
			while($row = $result->fetch_assoc()){
				echo "<tr><td>".$row['firstName']." ".$row['lastName']."</td><td>".$row['cName']."</td><td>".$row['cLevel']."</td><td>".$row['scoreEntryDate']."</td>";
			}
		}
		else
			echo "Please select an option.";
		echo "</tr></table>";
	}
	?>
	<?php

	include '../Footer.php';
}
else
	echo "Go to Login page & sign in as Coordinator.";
?>

</body>
