function onLoadHide(){
	document.getElementById("tempAddBlock").style.display = "none";
	document.getElementById("subscribeBlock").style.display = "none";
}

// temporary add hide/show
function showTempBlock(){
	checkbox = document.getElementById("checkTemp").checked;
	if(checkbox)
		document.getElementById("tempAddBlock").style.display = "table-row";
	else
		document.getElementById("tempAddBlock").style.display = "none";
}

// subscribe hide/show
function showSubscribeBlock(){
	checkbox = document.getElementById("checkSubscribe").checked;
	if(checkbox)
		document.getElementById("subscribeBlock").style.display = "table-row";
	else
		document.getElementById("subscribeBlock").style.display = "none";
}

// registration form validation
// first name
function fnF() {
	document.getElementById("fnV").innerHTML = "";
	document.getElementById("fn").style.boxShadow = "";
	document.getElementById("fnMsg").innerHTML="Name should be of 2 or more characters and does not contain any number or special symbol";
}
function fnB() {
	document.getElementById("fnMsg").innerHTML="";
}
function fnCheck() {
	var fnVal = document.getElementById("fn").value;
	if (/^[A-Za-z]{2,15}$/.test(fnVal)){
		document.getElementById("fnMsg").style.color = "green";
		return true;
	}
	else{
		document.getElementById("fnMsg").style.color = "red";
		return false;
	}
}
function fn2() {
	var fnVal = document.getElementById("fn").value;
	if (fnVal != "" && fnCheck())
		return true;
	else{
		document.getElementById("fnV").innerHTML = "Enter a valid first name";
		document.getElementById("fn").style.boxShadow = "0px 0px 1px 2px red";
		return false;
	}
}

// middle name
function mnF() {
	document.getElementById("mnV").innerHTML = "";
	document.getElementById("mn").style.boxShadow = "";
	document.getElementById("mnMsg").innerHTML="Name should be of 2 or more characters and does not contain any number or special symbol";
}
function mnB() {
	document.getElementById("mnMsg").innerHTML="";
}
function mnCheck() {
	var mnVal = document.getElementById("mn").value;
	if (/^[A-Za-z]{2,15}$/.test(mnVal)){
		document.getElementById("mnMsg").style.color = "green";
		return true;
	}
	else{
		document.getElementById("mnMsg").style.color = "red";
		return false;
	}
}
function mn2() {
	var mnVal = document.getElementById("mn").value;
	if (mnVal != "" && mnCheck())
		return true;
	else{
		document.getElementById("mnV").innerHTML = "Enter a valid middle name";
		document.getElementById("mn").style.boxShadow = "0px 0px 1px 2px red";
		return false;
	}
}

// last name
function lnF() {
	document.getElementById("lnV").innerHTML = "";
	document.getElementById("ln").style.boxShadow = "";
	document.getElementById("lnMsg").innerHTML="Name should be of 2 or more characters and does not contain any number or special symbol";
}
function lnB() {
	document.getElementById("lnMsg").innerHTML="";
}
function lnCheck() {
	var lnVal = document.getElementById("ln").value;
	if (/^[A-Za-z]{2,15}$/.test(lnVal)){
		document.getElementById("lnMsg").style.color = "green";
		return true;
	}
	else{
		document.getElementById("lnMsg").style.color = "red";
		return false;
	}
}
function ln2() {
	var lnVal = document.getElementById("ln").value;
	if (lnVal != "" && lnCheck())
		return true;
	else{
		document.getElementById("lnV").innerHTML = "Enter a valid last name";
		document.getElementById("ln").style.boxShadow = "0px 0px 1px 2px red";
		return false;
	}
}

// mobile no.
function mobileF() {
	document.getElementById("mobileV").innerHTML = "";
	document.getElementById("mobile").style.boxShadow = "";
	document.getElementById("mobileMsg").innerHTML="Mobile number contains only 10 digits";
}
function mobileB() {
	document.getElementById("mobileMsg").innerHTML="";
}
function mobileCheck() {
	var mobileVal = document.getElementById("mobile").value;
	if (/^[6-9][0-9]{9}$/.test(mobileVal)){
		document.getElementById("mobileMsg").style.color = "green";
		return true;
	}
	else{
		document.getElementById("mobileMsg").style.color = "red";
		return false;
	}
}
function mobile2(){
	var mobileVal = document.getElementById("mobile").value;
	if (mobileVal != "" && mobileCheck())
		return true;
	else{
		document.getElementById("mobileV").innerHTML = "Enter a valid mobile number";
		document.getElementById("mobile").style.boxShadow = "0px 0px 1px 2px red";
		return false;
	}
}

// emergency contact no.
function emergencyContactF() {
	document.getElementById("emergencyContactV").innerHTML = "";
	document.getElementById("emergencyContact").style.boxShadow = "";
	document.getElementById("emergencyContactMsg").innerHTML="Emergency No. must be different from Mobile No. and of 10 digits";
}
function emergencyContactB() {
	document.getElementById("emergencyContactMsg").innerHTML="";
}
function emergencyContactCheck() {
	var mobileVal = document.getElementById("mobile").value;
	var emergencyContactVal = document.getElementById("emergencyContact").value;
	if (/^[6-9][0-9]{9}$/.test(emergencyContactVal) && mobileVal != emergencyContactVal){
		document.getElementById("emergencyContactMsg").style.color = "green";
		return true;
	}
	else{
		document.getElementById("emergencyContactMsg").style.color = "red";
		return false;
	}
}
function emergencyContact2(){
	var emergencyContactVal = document.getElementById("emergencyContact").value;
	if (emergencyContactVal != "" && emergencyContactCheck())
		return true;
	else{
		document.getElementById("emergencyContactV").innerHTML = "Enter a valid emergency contact number";
		document.getElementById("emergencyContact").style.boxShadow = "0px 0px 1px 2px red";
		return false;
	}
}

// email
function emailF() {
	document.getElementById("emailV").innerHTML = "";
	document.getElementById("email").style.boxShadow = "";
	document.getElementById("emailMsg").innerHTML="Email should be valid email address";
}
function emailB() {
	document.getElementById("emailMsg").innerHTML="";
}
function emailCheck() {
	var emailVal = document.getElementById("email").value;
	if (/^[a-z][a-z0-9]{2,18}@(gmail|outlook|hotmail|yahoo|icloud)[.](com|in)$/.test(emailVal)){
		document.getElementById("emailMsg").style.color = "green";
		return true;
	}
	else{
		document.getElementById("emailMsg").style.color = "red";
		return false;
	}
}
function email2(){
	var emailVal = document.getElementById("email").value;
	if (emailVal != "" && emailCheck())
		return true;
	else{
		document.getElementById("emailV").innerHTML = "Enter a valid email";
		document.getElementById("email").style.boxShadow = "0px 0px 1px 2px red";
		return false;
	}
}

// username
function unF() {
	document.getElementById("unV").innerHTML = "";
	document.getElementById("un").style.boxShadow = "";
	document.getElementById("unMsg").innerHTML="Username contain small letters, numbers, periods & underscore";
}
function unB() {
	document.getElementById("unMsg").innerHTML="";
}
function unCheck() {
	var unVal = document.getElementById("un").value;
	if (/^[a-z][a-z0-9._]{2,14}$/.test(unVal)){
		document.getElementById("unMsg").style.color = "green";
		return true;
	}
	else{
		document.getElementById("unMsg").style.color = "red";
		return false;
	}
}
function un2(){
	var unVal = document.getElementById("un").value;
	if (unVal != "" && unCheck())
		return true;
	else{
		document.getElementById("unV").innerHTML = "Enter a valid username";
		document.getElementById("un").style.boxShadow = "0px 0px 1px 2px red";
		return false;
	}
}

// password
function passF() {
	document.getElementById("passV").innerHTML = "";
	document.getElementById("pass").style.boxShadow = "";
	document.getElementById("passMsg1").innerHTML="Password length must contain atleast 8 characters";
	document.getElementById("passMsg2").innerHTML="Password contain atleast one number";
	document.getElementById("passMsg3").innerHTML="Password contain atleast one special character";
}
function passB() {
	document.getElementById("passMsg1").innerHTML="";
	document.getElementById("passMsg2").innerHTML="";
	document.getElementById("passMsg3").innerHTML="";
}
function pass1() {
	var passVal = document.getElementById("pass").value;
	if (passVal.length < 8){
		document.getElementById("passMsg1").style.color = "red";
		return false;
	}
	else{
		document.getElementById("passMsg1").style.color = "green";
		return true;
	}
}

function pass2() {
	var passVal = document.getElementById("pass").value;
	if (/[0-9]/.test(passVal)){
		document.getElementById("passMsg2").style.color = "green";
		return true;
	}
	else{
		document.getElementById("passMsg2").style.color = "red";
		return false;
	}
}
function pass3() {
	var passVal = document.getElementById("pass").value;
	if (/[`!@#$%^&*()_\-+={}\[\];':\"\\|,.<>\/?~]+/.test(passVal)){
		document.getElementById("passMsg3").style.color = "green";
		return true;
	}
	else{
		document.getElementById("passMsg3").style.color = "red";
		return false;
	}
}
function pass4(){
	var passVal = document.getElementById("pass").value;
	if (passVal != "" && pass1() && pass2() && pass3())
		return true;
	else{
		document.getElementById("passV").innerHTML = "Enter a valid password";
		document.getElementById("pass").style.boxShadow = "0px 0px 1px 2px red";
		return false;
	}
}
function passCheck(){
	const passArray = [pass1(),pass2(),pass3()];
	for(var i=0;i<3;i++)
		passArray[i];
}

// confirm password
function conPassF() {
	document.getElementById("conPassV").innerHTML = "";
	document.getElementById("conPass").style.boxShadow = "";
	document.getElementById("conPassMsg").innerHTML="Password and retype password must be matched";
}
function conPassB() {
	document.getElementById("conPassMsg").innerHTML="";
}
function conPassCheck() {
	var passVal = document.getElementById("pass").value;
	var conPassVal = document.getElementById("conPass").value;
	if (passVal == conPassVal){
		document.getElementById("conPassMsg").style.color = "green";
		return true;
	}
	else{
		document.getElementById("conPassMsg").style.color = "red";
		return false;
	}
}
function conPass2(){
	var conPassVal = document.getElementById("conPass").value;
	if (conPassVal != "" && conPassCheck())
		return true;
	else{
		document.getElementById("conPassV").innerHTML = "Enter a valid password";
		document.getElementById("conPass").style.boxShadow = "0px 0px 1px 2px red";
		return false;
	}
}

// birth date
function bDateF() {
	document.getElementById("bDateV").innerHTML = "";
	document.getElementById("bDate").style.boxShadow = "";
}
function bDateCheck(){
	var bDateVal = document.getElementById("bDate").value;
	if (bDateVal == "") {
		document.getElementById("bDateV").innerHTML = "Enter a valid birth date";
		document.getElementById("bDate").style.boxShadow = "0px 0px 1px 2px red";
		return false;
	}
	else
		return true;
}

// permanent add
function perAddF() {
	document.getElementById("perAddV").innerHTML = "";
	document.getElementById("perAdd").style.boxShadow = "";
	document.getElementById("perAddMsg").innerHTML="Address contains alphabets, numbers, comma(,), periods(.), single quote('), hyphen(-) and forward slash(/)";
}
function perAddB() {
	document.getElementById("perAddMsg").innerHTML="";
}
function perAddCheck() {
	var perAddVal = document.getElementById("perAdd").value;
	if (/^[a-zA-Z0-9\s,.'-\/]{3,80}$/.test(perAddVal)){
		document.getElementById("perAddMsg").style.color = "green";
		return true;
	}
	else{
		document.getElementById("perAddMsg").style.color = "red";
		return false;
	}
}
function perAdd2(){
	var perAddVal = document.getElementById("perAdd").value;
	if (perAddVal != "" && perAddCheck())
		return true;
	else{
		document.getElementById("perAddV").innerHTML = "Enter a valid permanent address";
		document.getElementById("perAdd").style.boxShadow = "0px 0px 1px 2px red";
		return false;
	}
}

// temp add
function tempAddF() {
	document.getElementById("tempAddMsg").innerHTML="Address contains alphabets, numbers, comma(,), periods(.), single quote('), hyphen(-) and forward slash(/)";
}
function tempAddB() {
	document.getElementById("tempAddMsg").innerHTML="";
}
function tempAddCheck() {
	if(document.getElementById("checkTemp").checked){
		var tempAddVal = document.getElementById("tempAdd").value;
		if (/^[a-zA-Z0-9\s,.'-\/]{3,80}$/.test(tempAddVal)){
			document.getElementById("tempAddMsg").style.color = "green";
			return true;
		}
		else{
			document.getElementById("tempAddMsg").style.color = "red";
			return false;
		}
	}
	return true;
}
function tempAdd2(){
	if(document.getElementById("checkTemp").checked){
		var tempAddVal = document.getElementById("tempAdd").value;
		if (tempAddVal != "" && tempAddCheck()) {
			document.getElementById("tempAddV").innerHTML = "";
			document.getElementById("tempAdd").style.boxShadow = "";
			return true;
		}
		else{
			document.getElementById("tempAddV").innerHTML = "Enter a valid temporary address";
			document.getElementById("tempAdd").style.boxShadow = "0px 0px 1px 2px red";
			return false;
		}
	}
	return true;
}

// city
function cityF() {
	document.getElementById("cityV").innerHTML = "";
	document.getElementById("city").style.boxShadow = "";
	document.getElementById("cityMsg").innerHTML="City should not contain any number or special symbol";
}
function cityB() {
	document.getElementById("cityMsg").innerHTML="";
}
function cityCheck() {
	var cityVal = document.getElementById("city").value;
	if (/^[A-Za-z]{2,28}$/.test(cityVal)){
		document.getElementById("cityMsg").style.color = "green";
		return true;
	}
	else{
		document.getElementById("cityMsg").style.color = "red";
		return false;
	}
}
function city2() {
	var cityVal = document.getElementById("city").value;
	if (cityVal !="" && cityCheck())
		return true;
	else{
		document.getElementById("cityV").innerHTML = "Enter a valid city name";
		document.getElementById("city").style.boxShadow = "0px 0px 1px 2px red";
		return false;
	}
}

// profile picture
function proPicF() {
	document.getElementById("proPicV").innerHTML = "";
	document.getElementById("proPic").style.boxShadow = "";
	document.getElementById("proPicMsg").innerHTML="Profile picture should be maximum 100 KB and only support the file format such as JPEG, JPG and PNG";
	
}
function proPicB() {
	document.getElementById("proPicMsg").innerHTML="";
}
function proPicCheck() {
	var proPicLen = document.getElementById("proPic").files.length;
	var fileName = document.getElementById("proPic").value;
	var supportedExtensions = /(\.jpeg|\.jpg|\.png)$/;
	if (proPicLen == 1 && supportedExtensions.exec(fileName))
		return true;
	else{
		document.getElementById("proPicV").innerHTML = "Please upload valid profile picture";
		document.getElementById("proPic").style.boxShadow = "0px 0px 1px 2px red";
		return false;
	}
}

// identity proof
function iProofF() {
	document.getElementById("iProofV").innerHTML = "";
	document.getElementById("iProof").style.boxShadow = "";
	document.getElementById("iProofMsg").innerHTML="Identity proof document can be Aadhar card or Election card & must be in PDF only and it is of maximum 2 MB";
}
function iProofB() {
	document.getElementById("iProofMsg").innerHTML="";
}
function iProofCheck() {
	var iProofLen = document.getElementById("iProof").files.length;
	var fileName = document.getElementById("iProof").value;
	var supportedExtensions = /(\.pdf)$/;
	if (iProofLen == 1 && supportedExtensions.exec(fileName))
		return true;
	else{
		document.getElementById("iProofV").innerHTML = "Please upload valid identity proof document";
		document.getElementById("iProof").style.boxShadow = "0px 0px 1px 2px red";
		return false;
	}
}

// captcha
function captchaF(){
	document.getElementById("captchaV").innerHTML = "";
	document.getElementById("captcha").style.boxShadow = "";
}
function captcha2(){
	var captchaVal = document.getElementById("captcha").value;
	if (captchaVal != "")
		return true;
	else{
		document.getElementById("captchaV").innerHTML = "Enter a valid Captcha Code";
		document.getElementById("captcha").style.boxShadow = "0px 0px 1px 2px red";
		return false;
	}
}


// subscribe check
function subscribeCheck(){
	checkbox1 = document.getElementById("checkSubscribe").checked;
	checkbox2 = document.getElementById("checkEmail").checked;
	checkbox3 = document.getElementById("checkMobileSMS").checked;
	if(checkbox1){
		if(checkbox2 || checkbox3){
			document.getElementById("subscribeV").innerHTML = "";
			return true;
		}
		else{
			document.getElementById("subscribeV").innerHTML = "Please select atleast one subscribe mode";
			return false;
		}
	}
	else
		return true;
}

//checking the values are null or not
function nullCheck() {
	var fn = fn2();
	var mn = mn2();
	var ln = ln2();
	var mobile = mobile2();
	var emergencyContact = emergencyContact2();
	var email = email2();
	var un = un2();
	var pass = pass4();
	var conPass = conPass2();
	var bDate = bDateCheck();
	var perAdd = perAdd2();
	var tempAdd = tempAdd2();
	var city = city2();
	var proPic = proPicCheck();
	var iProof = iProofCheck();
	var captcha = captcha2();
	var subscribe = subscribeCheck();

	if (fn && mn && ln && mobile && emergencyContact && email && un && pass && conPass && bDate && perAdd && tempAdd && city && proPic && iProof && captcha && subscribe)
		return true;
	else
		return false;
}

// login validations

// email validation
function loginEmailF() {
	document.getElementById("emailV").innerHTML = "";
	document.getElementById("email").style.boxShadow = "";
}

function loginEmailCheck() {
	var emailVal = document.getElementById("email").value;
	if (emailVal == "" || !/^[a-z][a-z0-9]+@(gmail|outlook|hotmail|yahoo|icloud)[.](com|in)$/.test(emailVal)) {
		document.getElementById("emailV").innerHTML = "Enter a valid email";
		document.getElementById("email").style.boxShadow = "0px 0px 1px 2px red";
		return false;
	}
	else {
		return true;
	}
}

// password validation
function loginPassF() {
	document.getElementById("passV").innerHTML = "";
	document.getElementById("pass").style.boxShadow = "";
}

function loginPassCheck() {
	var passVal = document.getElementById("pass").value;
	if (passVal == "" || passVal.length < 8 || passVal.length > 15 || !/[0-9]/.test(passVal) || !/[`!@#$%^&*()_\-+={}\[\];':\"\\|,.<>\/?~]+/.test(passVal)) {
		document.getElementById("passV").innerHTML = "Enter a valid password containing atleast 8 letters, a number & a special symbol";
		document.getElementById("pass").style.boxShadow = "0px 0px 1px 2px red";
		return false;
	}
	else {
		return true;
	}
}

//checking the values are null or not
function loginNullCheck() {
	var email = loginEmailCheck();
	var pass = loginPassCheck();
	if (email && pass)
		return true;
	else
		return false;
}

// contest validations

// contest name
function cNameF() {
	document.getElementById("cNameV").innerHTML = "";
	document.getElementById("cName").style.boxShadow = "";
	document.getElementById("cNameMsg").innerHTML = "Contest Name should be of 2 or more characters and does not contain any number or special symbol";
}

function cNameB() {
	document.getElementById("cNameMsg").innerHTML = "";
}

function cNameCheck() {
	var cNameVal = document.getElementById("cName").value;
	if (/^[A-Za-z\s]{2,40}$/.test(cNameVal)) {
		document.getElementById("cNameMsg").style.color = "green";
		return true;
	} else {
		document.getElementById("cNameMsg").style.color = "red";
		return false;
	}
}

function cName2() {
	var cNameVal = document.getElementById("cName").value;
	if (cNameVal != "" && cNameCheck())
		return true;
	else {
		document.getElementById("cNameV").innerHTML = "Enter a valid contest name";
		document.getElementById("cName").style.boxShadow = "0px 0px 1px 2px red";
		return false;
	}
}

// contest date
function cDateF() {
	document.getElementById("cDateV").innerHTML = "";
	document.getElementById("cDate").style.boxShadow = "";
}

function cDateCheck() {
	var cDateVal = document.getElementById("cDate").value;
	if (cDateVal == "") {
		document.getElementById("cDateV").innerHTML = "Enter a valid contest date";
		document.getElementById("cDate").style.boxShadow = "0px 0px 1px 2px red";
		return false;
	} else {
		return true;
	}
}

// contest duration
function cDurF() {
	document.getElementById("cDurV").innerHTML = "";
	document.getElementById("cDur").style.boxShadow = "";
	document.getElementById("cDurMsg").innerHTML = "Only digits are allowed";
}

function cDurB() {
	document.getElementById("cDurMsg").innerHTML = "";
}

function cDurCheck() {
	var cDurVal = document.getElementById("cDur").value;
	if (/^[1-9][0-9]{0,4}$/.test(cDurVal)) {
		document.getElementById("cDurMsg").style.color = "green";
		return true;
	} else {
		document.getElementById("cDurMsg").style.color = "red";
		return false;
	}
}

function cDur2() {
	var cDurVal = document.getElementById("cDur").value;
	if (cDurVal != "" && cDurCheck())
		return true;
	else {
		document.getElementById("cDurV").innerHTML = "Enter a valid contest duration";
		document.getElementById("cDur").style.boxShadow = "0px 0px 1px 2px red";
		return false;
	}
}

// contest description
function cDescF() {
	document.getElementById("cDescV").innerHTML = "";
	document.getElementById("cDesc").style.boxShadow = "";
	document.getElementById("cDescMsg").innerHTML = "Description contains alphabets, numbers, comma(,), periods(.), single quote('), hyphen(-) and forward slash(/)";
}

function cDescB() {
	document.getElementById("cDescMsg").innerHTML = "";
}

function cDescCheck() {
	var cDescVal = document.getElementById("cDesc").value;
	if (/^[a-zA-Z0-9\s,.'-\/]{3,255}$/.test(cDescVal)) {
		document.getElementById("cDescMsg").style.color = "green";
		return true;
	} else {
		document.getElementById("cDescMsg").style.color = "red";
		return false;
	}
}

function cDesc2() {
	var cDescVal = document.getElementById("cDesc").value;
	if (cDescVal != "" && cDescCheck())
		return true;
	else {
		document.getElementById("cDescV").innerHTML = "Enter a valid description";
		document.getElementById("cDesc").style.boxShadow = "0px 0px 1px 2px red";
		return false;
	}
}

// contest banner
function cBannerF() {
	document.getElementById("cBannerV").innerHTML = "";
	document.getElementById("cBanner").style.boxShadow = "";
	document.getElementById("cBannerMsg").innerHTML = "Contest banner should be maximum 100 KB and only support the file format such as JPEG, JPG and PNG";
}

function cBannerB() {
	document.getElementById("cBannerMsg").innerHTML = "";
}

function cBannerCheck() {
	var cBannerLen = document.getElementById("cBanner").files.length;
	var fileName = document.getElementById("cBanner").value;
	var supportedExtensions = /(\.jpeg|\.jpg|\.png)$/;
	if (cBannerLen == 1  && supportedExtensions.exec(fileName))
		return true; 
	else {
		document.getElementById("cBannerV").innerHTML = "Please upload valid contest banner";
		document.getElementById("cBanner").style.boxShadow = "0px 0px 1px 2px red";
		return false;
	}
}

//checking the values are null or not
function contestNullCheck() {
	var cName = cName2();
	var cDate = cDateCheck();
	var cDur = cDur2();
	var cDesc = cDesc2();
	var cBanner = cBannerCheck();

	if (cName && cDate && cDur && cDesc && cBanner)
		return true;
	else
		return false;
}

// function scoreNullCheck(){
// 	score1 = document.getElementById("j1Score").value;
// 	score2 = document.getElementById("j2Score").value;
// 	score3 = document.getElementById("j3Score").value;

// 	if(score1 == "" || score2 == "" || score3 == ""){
// 		alert("Please fill all the fields!");
// 	}
// 	else if()
// }