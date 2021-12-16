 <h2>Login Here</h2>
 <script>
 function validate_login_form(){
	 var cat = document.loginform.cat.value;
	 var name = document.loginform.name.value;
	 var pass = document.loginform.pass.value;
	 
	 if(cat==""){
		 alert('Please Select Category');
		 return false;
		 }
	if(name==""){
		 alert('Please Enter Your Username');
		 return false;
		 }
		 
	 if(pass == ""){
			 alert('Please Enter Your Password');
			 return false;
			 }
	 
	 return true;
	 }
	 
function showSignUp(){	 
	 var div = document.getElementById("signup");
if(div.style.display!=='none')
{div.style.display='none';}
else{div.style.display='block';}
}
  </script>
        <form name="loginform" method="post" action="includes/login_form.php" onsubnmit="return validate_login_form();"> 
           <span class="text-danger">Logging form for book salers</span>
      <input type="text" class="form-control add-todo" placeholder="Username" name="username" required><br>
	         <input type="password" class="form-control add-todo" placeholder="Password" name="password" required><br>
            
        <input type="submit" class="btn btn-primary" style="float: right;" value="Login" name="loginbtn" /> 
	
        </form>
		
        <div style="clear:both"></div>            
    <hr>   
    New book saler? <button id="button" onClick="showSignUp()">SignUp Here</button>
	<div id="signup" style="display:none;">
	<?php require_once('register_form.php'); ?>
	</div>
	
	
	<?php
//Connect to database via another page
include_once("dbconn.php");

?>
<?php
if(isset($_POST['loginbtn'])){
if($_POST['loginbtn']='Login'){
$username=$_POST['username'];
$pass=$_POST['password'];

$sql="SELECT COUNT(*) FROM users WHERE username='".$username."' AND password='".$pass."' ";
$query=mysqli_query($conn,$sql);
$result=mysqli_fetch_array($query);

if($result[0]>0){

session_start();
//session will stay alive for 180 seconds (3 mins)  if user stays idle
//$duration=180;
//$_SESSION['duration']=$duration;
//$_SESSION['startTime']=time();  //Get the current time
$_SESSION['username']=$username;
$_SESSION['loggedin']=TRUE;

header('Location:../salerdetails.php');

}
else{
echo ("<script language='javascript'> window.alert('Login failed, check username and password then try again')</script>");
echo "<meta http-equiv='refresh' content='0;url=../index.php'> ";
}
}}
?>