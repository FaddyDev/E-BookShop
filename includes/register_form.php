 <h2>Sign Up</h2>
 <script>
 function confirm_pass(){
	 var pass = document.loginform.password.value;
	 var pass2 = document.loginform.password2.value;
	 
	 if(pass!=pass2){
		 alert('Passwords do not match');
		 return false;
		 }
	
	 return true;
	 }
  </script>
  
		<form class="form-horizontal well" action="includes/register_form.php" name="loginform" onsubmit="return confirm_pass();" method="post" name="upload" enctype="multipart/form-data">
      <input type="text" class="form-control add-todo" placeholder="Username" name="username" required><br>
       <input type="password" class="form-control add-todo" placeholder="Password" name="password" required><br>
	   <input type="password" class="form-control add-todo" placeholder="Confirm Password" name="password2" required><br>
            
        <input type="submit" class="btn btn-primary" style="float: right;" value="Sign Up" name="registerbtn" /> 
		</form> 
		
        <div style="clear:both"></div>            
   
   	<?php
//Connect to database via another page
include_once("dbconn.php");

?>
<?php
if(isset($_POST['registerbtn'])){
if($_POST['registerbtn']='Sign Up'){

if(($_POST['password'])!= ($_POST['password2']))
{
echo ("<script language='javascript'> window.alert('Passwords do not match')</script>");
echo "<meta http-equiv='refresh' content='0;url=../index.php'> ";
	}	
else{

$username = $_POST['username'];
$pass = $_POST['password2'];

$sql="SELECT COUNT(*) FROM users WHERE username='".$username."' ";
$query=mysqli_query($conn,$sql);
$result=mysqli_fetch_array($query);

if($result[0]>0){
echo ("<script language='javascript'> window.alert('Username exits, kindly choose another')</script>");
echo "<meta http-equiv='refresh' content='0;url=../index.php'> ";
}
else{
$username=mysqli_real_escape_string($conn,$username);
$pass=mysqli_real_escape_string($conn,$pass);

$sql = "insert into users (username,password)  values ('".$username."','".$pass."')";

$query=mysqli_query($conn,$sql);

if(!$query) {die("Not submitted, Try again      ".mysqli_error($conn));}
else{
echo ("<script language='javascript'> window.alert('Sign Up Successful, you can now Log in and continue...')</script>");
echo "<meta http-equiv='refresh' content='0;url=../index.php'> ";
}
}
}
}}
?>