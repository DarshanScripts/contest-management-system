<?php
session_start();
?>

<head>
	<script src="../assets/js/jquery.js"></script>
</head>

<body bgcolor="<?php if (isset($_SESSION['sessTheme'])) echo $_SESSION['sessTheme']; ?>">
	<?php
	set_error_handler('warningHandler');
	function warningHandler($errno, $error, $file, $line)
	{
		$msg = '[ERROR][$errno][$error][$file:$line]';
		error_log($msg);
	}
	if (isset($_SESSION['sessLoginCheck']) && $_SESSION['sessUserDetails']['emailId'] != "coordinator@gmail.com") {
	?>
		<!DOCTYPE html>
		<html lang="en">

		<head>
			<meta charset="UTF-8">
			<meta http-equiv="X-UA-Compatible" content="IE=edge">
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<title>Home</title>
		</head>

		<body>
			<?php
			include './UserHeader.php';
			$row = $_SESSION['sessUserDetails'];
			// echo "<pre>"; print_r($row); echo "</pre>";

			?>
			<h2 align=center>Welcome
				<?php
				if ($row['gender'] == "M")
					echo "Mr. ";
				else
					echo "Ms. ";
				echo strtolower($row['firstName']) . " " . ucfirst(strtolower($row['middleName'])) . " " . ucfirst(strtolower($row['lastName']));
				?>
			</h2>
			<table cellpadding="5" cellspacing="10">
				<tr>
					<td><b>Email Address:</b></td>
					<td><?php echo strtolower($row['emailId']); ?></td>
				</tr>
				<tr>
					<td><b>Mobile Number:</b></td>
					<td><?php echo "+91 " . $row['mobileNo']; ?></td>
				</tr>
				<tr>
					<td><b>Address:</b></td>
					<td><?php echo $row['permanentAdd']; ?></td>
				</tr>
			</table>
			<?php
			echo "<br><br>Click on the contest name to see the registered user";
			include_once '../SQLConnection.php';

			$sql = "SELECT c.cName AS ContestTitle,COUNT(p.userId) AS ParticipantCount
					FROM Contest c, Participation p
					WHERE c.cId = p.cId 
					AND YEAR(c.cDate) = 2023
					GROUP BY c.cName
					ORDER BY ParticipantCount DESC
					LIMIT 2;";

			$result = mysqli_query($con, $sql);
			echo "<ul>";
			while ($row = $result->fetch_assoc()) {
				// print_r($row);
				$cName = $row['ContestTitle'];
				$ParticipantCount = $row['ParticipantCount'];
				echo "<li class='contest-title'>$cName</li>";
			}
			echo "</ul>";
			echo "<div id='contest-details'></div>";

			include './Footer';
			?>

			<script>
				$(document).ready(function() {
					$('.contest-title').click(function() {
						var contestTitle = $(this).text();
						$.ajax({
							url: 'getContestDetails.php',
							type: 'POST',
							data: {
								contestTitle: contestTitle
							},
							success: function(response) {
								$('#contest-details').html(response).toggle();
							}
						});
					});
				});
			</script>
		</body>

		</html>
	<?php
	} else
		echo "Go to Login page & sign in as User.";
	?>