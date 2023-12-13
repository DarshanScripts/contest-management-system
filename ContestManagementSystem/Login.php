<?php
session_start();

//declaring variables for error msgs, E refers to error 
$emailE = $passE = '';

if (isset($_POST["btnSignIn"])) {
    //fetching values
	$email = strtolower(trim($_POST['txtEmail']));
	$pass = trim($_POST['txtPass']);
	
	$valid = true;

	// checking javascript is on or off
	if ($_POST["javaScriptValid"] == 0) {

		// email
		if(empty($email)){
			$valid = false;
			$emailE = "Enter a valid email";
		}
		else if(!preg_match("/^[a-z][a-z0-9]+@(gmail|outlook|hotmail|yahoo|icloud)[.](com|in)$/", $email)){
			$valid = false;
			$emailE = "Enter a valid email";
		}

		// password
		if(empty($pass)){
			$valid = false;
			$passE = "Enter a valid password";
		}
		else{
			if(strlen($pass)<8 && strlen($pass>15) && (!preg_match("/[0-9]/", $pass)) && (!preg_match("/[`!@#$%^&*()_\-+={}\[\];':\"\\|,.<>\/?~]+/", $pass))){
				$valid = false;
				$passE = "Enter a valid password";
			}
		}
	}
	if($valid){
		$_SESSION["sessPasssword"] = $_POST['txtPass'];
		$_SESSION["sessLoginCheck"] = $_POST['btnSignIn'];
        include_once './CommonFunctions.php';
        $email = $_POST['txtEmail'];
		$pass = $_POST['txtPass'];
		@$remember = $_POST['rememberMe'];
        doLogin($email,$pass,$remember);
	}
}
?>
<html>
    <head>
        <title>Login</title>
        <style>
            span{
                font-weight: 600;
                font-family: sans-serif;
                font-size: 13px;
                display: block;
            }
        </style>
        <script src="./assets/js/Validation.js"></script>

        <noscript>
            <p>Please enable javascript for better experience</p>
        </noscript>
    </head>
    <body>
    <h3><a href="Registration.php" style="float:right;">Registration</a></h3>
        <form action="" method="POST" onsubmit="return loginNullCheck()">
            <h1 align="center">Login</h1><hr>
            <table cellpadding="5" cellspacing="10">
                <tr>
                    <td><label>Email Id: </label></td>
                    <td>
                        <input type="text" name="txtEmail" id="email" value="<?php if(isset($_COOKIE['ckEmail'])) echo $_COOKIE['ckEmail']; ?>" onfocus="loginEmailF()"/><br>
                        <span id="emailMsg"></span>
                        <span id="emailV"></span>
                        <?php echo $emailE; ?>
                    </td>
                </tr>
                <tr>
                    <td><label>Password: </label></td>  
                    <td>
                        <input type="password" name="txtPass" id="pass" value="<?php if(isset($_COOKIE['ckPass'])) echo $_COOKIE['ckPass']; ?>" onfocus="loginPassF()"/><br>
                        <span id="passMsg"></span>
                        <span id="passV"></span>
                        <?php echo $passE; ?>
                    </td>
                </tr>
                <!-- hidden field for checking javascript is on or off -->
				<input type="hidden" name="javaScriptValid" id="jsValid" value="0" />
                <tr>
                    <td colspan="2"><input type="checkbox" name="rememberMe"/><label>Remember Me</label></td>
                </tr>
                <tr>
                    <td><input type="submit" value="Sign In" name="btnSignIn" id="signup" /></td>
                </tr>
            </table>
        </form>
        <?php
	    include './Footer.php';
        ?>
        <script>
			//if js is on then the value will be set to one
			document.getElementById("jsValid").value = "1";
		</script>
    </body>
</html>