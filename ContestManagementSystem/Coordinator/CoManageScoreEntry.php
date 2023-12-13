<?php
session_start();
?>

<head>
	<script src="../Validation.js"></script>
	<script src="../jquery.js"></script>
</head>
<body>
<?php
if(isset($_POST['btnSubmitScore'])){
	include_once '../SQLConnection.php';
	$cId = $_SESSION['sessSelectedContest'];
	$pIds = mysqli_query($con,"SELECT pId FROM Participation WHERE cId = $cId;");
	$judgesScore = $_POST;
	// while($row = $pIds->fetch_assoc())
	// 	echo $row['pId'] ."<br>";
	
	// echo "<pre>"; print_r($scores); echo "</pre>";
	include_once '../CommonFunctions.php';
	addScores($pIds,$judgesScore);
}


if (isset($_SESSION['sessLoginCheck']) && $_SESSION['sessUserDetails']['emailId'] == "coordinator@gmail.com") {
	include './CoHeader.php';

	echo "<h1 align='center'>Score Entry</h1>";
	
	//select query to fetch id & names of contest
	include_once '../SQLConnection.php';
	$result = mysqli_query($con,"SELECT cId,cName,cDate FROM Contest;");
	echo "<div align='center'>
		Select Contest: 
		<select name='selContest' id='selContest'>";
	$curDate = new DateTime();
	while($row = $result->fetch_assoc()){
		// checking that contest date is passed or not
		$contestDate = new DateTime($row['cDate']);
		if($contestDate < $curDate){
			$id = $row['cId'];
			$name = $row['cName'];
			echo "<option value='$id'>$name</option>";
		}
	}
	echo "</select>
		  <input type='submit' name='btnGenerateScoreEntry' id='btnGenerateScoreEntry' value='Generate Score Entry Form'>	
		</div>";
	// if(isset($_POST['btnGenerateScoreEntry'])){
	// 	$cId = $_POST['selContest'];
	// 	$_SESSION['sessSelectedContest'] = $cId;
		
	// }

	echo "<div align='center' id='loading' style='display:none;'><img src='../FileUploadStuffs/loader.gif'></div>";
	echo "<div id='scoreEntryForm'></div>";
	include '../Footer.php';
}
else
	echo "Go to Login page & sign in as Coordinator.";
?>

<!-- sending asynchoronous request and displaying -->
	<script>
		$(document).ready(function(){
			$("#btnGenerateScoreEntry").click(function(){
				var selContest = $("#selContest").val();
				$.ajax({
					url: "CoLoadScoreEntry.php",
					type: "POST",
					data: {'selContest': selContest},
					beforeSend: function(){
						$("#loading").show();
					},
					complete: function(){
						$("#loading").hide();
					},
					success: function(data){
						// console.log("Success!");
						// console.log(data);
						$("#scoreEntryForm").html(data);
					}
				});
			});
		});
	</script>
</body>

<!-- generate only - scores are not given before -->