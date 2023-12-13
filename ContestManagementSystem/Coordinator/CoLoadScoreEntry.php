<?php
session_start();
include_once '../SQLConnection.php';

$cId = $_POST['selContest'];
$_SESSION['sessSelectedContest'] = $cId;

$sql = "SELECT firstName,lastName,profilePic,cId,Participation.userId FROM Registration, Participation WHERE Registration.userId = Participation.userId && cId = $cId;";
$result = mysqli_query($con,$sql);
$totalParticipants = $result->num_rows;

$output = "<form action='' method='POST' align='center'>
	<table cellpadding=20 cellspacing=0 align='center'>
		<tr>
			<th>Profile</th>
			<th>Judge-1 Score<br>(out of 100)</th>
			<th>Judge-2 Score<br>(out of 100)</th>
			<th>Judge-3 Score<br>(out of 100)</th>
			<th>Time Taken<br>(in minutes)</th>
		</tr>";
$i = 1;
while($row = $result->fetch_assoc()){
	$output .= "<tr>
			<td align='center'>
				<img src='../assets/images/ProPicImg/" . $row['profilePic'] . "' width=50px height=50px><br>".$row['firstName']." ".$row['lastName']."
			</td>
			<td><input type='number' name='j1Score$i' placeholder='Enter Score'></td>
			<td><input type='number' name='j2Score$i' placeholder='Enter Score'></td>
			<td><input type='number' name='j3Score$i' placeholder='Enter Score'></td>
			<td><input type='number' name='timeTaken$i' placeholder='Enter Time'></td>
		</tr>";
	$i++;
}
$output .= "<tr><td colspan='5' align='center'><button type='submit' name='btnSubmitScore'>Submit</button></td></tr></table></form>";

echo $output;
?>