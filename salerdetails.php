
<?php require_once('includes/header.php'); //include the template top
include_once("includes/dbconn.php"); ?>
<?php 
$unsold = 0; $sold = 0; $totcash = 0;
$sql1="SELECT SUM(quantity) FROM books where owner='".$_SESSION["username"]."'";
$result1=$conn->query($sql1);
if($result1->num_rows>0){
if($row1=$result1->fetch_assoc()){
$unsold = $row1["SUM(quantity)"];
}}


$sql1="SELECT SUM(quantity_bot),SUM(total_amout) from books,sales WHERE books.book_code=sales.book_code and books.owner='".$_SESSION["username"]."' ORDER BY sales.id"; 
$result1=$conn->query($sql1);
if($result1->num_rows>0){
if($row1=$result1->fetch_assoc()){
$sold = $row1["SUM(quantity_bot)"];
$totcash = $row1["SUM(total_amout)"];
}}

 ?>

<div class="container">
<hr>
<div class="col-md-4">
<h2>My Profile</h2>
<label>Username:</label> <label style="color:#0000FF;"> <?php echo $_SESSION["username"];?></label><br />
<label>Total books:</label> <label style="color:#0000FF;"> <?php echo $unsold+$sold;?></label><br /> 
<label>Sold:</label> <label style="color:#0000FF;"> <?php echo $sold.' (	Kshs. '.$totcash.')';?> </label><br />
<label>Unsold:</label> <label style="color:#0000FF;"> <?php echo $unsold;?> </label>
</div>
<div class="col-md-8">
<h2>Add Books</h2>
<form class="form-horizontal well" action="salerdetails.php" name="loginform" method="post" name="upload" enctype="multipart/form-data">
       <select class="form-control" name="category" required>
		  <option value="">Select Category</option>
             <option value="Poetry">Poetry</option>
			 <option value="Course Book">Course Book</option>
			 <option value="Play">Play</option>
			 <option value="Novel">Novel</option>
			 </select><br>
      <input type="text" class="form-control add-todo" placeholder="Title" name="title" required><br>
       <input type="text" class="form-control add-todo" placeholder="Author" name="author" required><br>
		   <input type="text" class="form-control add-todo" placeholder="Publisher" name="publisher" required><br>
		   <input type="text" class="form-control add-todo" placeholder="Town/City of Publication" name="town" required><br>
	   <select class="form-control" name="year" required>
		  <option value="">Select Year</option>
		  <script>
		  var date = new Date();
		  var year = date.getFullYear();
		  for(var i = 1990; i<year+1; i++){
		    document.write('<option value="'+i+'">'+i+'</option>');
		  }
		  </script>
		  </select><br>
	   <input type="text" class="form-control add-todo" placeholder="Price (KShs) " name="price" onKeyPress="return numbersonly(event)" required><br>
	   <input type="text" class="form-control add-todo" placeholder="Quantity " name="quantity" onKeyPress="return numbersonly(event)" required><br>
	   Image of Book<input type="file" id="upload" name="image" class="input-large form-control add-todo" required><br />
	   <textarea name="description" class="form-control add-todo" placeholder="Give a brief synopsis of the book" required></textarea>
            
		<input type="reset" class="btn btn-primary" style="float: left;" value="Reset All" />
        <input type="submit" class="btn btn-primary" style="float: right;" value="Submit" name="registerbtn" /> 
		</form> 
</div>
 <hr>
</div>
 
  
<?php require_once('includes/footer.php'); //include footer template ?>



<?php
if(isset($_POST['registerbtn'])){

if (!isset($_FILES['image']['tmp_name'])) {
	echo ("<script language='javascript'> window.alert('Please upload a picture of the book')</script>");
echo "<meta http-equiv='refresh' content='0;url=salerdetails.php'> ";
	}else{
	$file=$_FILES['image']['tmp_name'];
	$image= addslashes(file_get_contents($_FILES['image']['tmp_name']));
	$image_name= addslashes($_FILES['image']['name']);
	$image_size= getimagesize($_FILES['image']['tmp_name']);

	
		if ($image_size==FALSE) {
		
			echo ("<script language='javascript'> window.alert('The file uploaded is not an image format')</script>");
echo "<meta http-equiv='refresh' content='0;url=salerdetails.php'> ";
			
		}else{
			
			move_uploaded_file($_FILES["image"]["tmp_name"],"uploads/" . date('dmYhi').$_FILES["image"]["name"]);
			
			$location="uploads/" . date('dmYhi').$_FILES["image"]["name"];
			$title=$_POST['title'];
			$category=$_POST['category'];
			$author=$_POST['author'];
			$town=$_POST['town'];
			$price=$_POST['price'];
			$year=$_POST['year'];
			$description=$_POST['description'];
			$publisher=$_POST['publisher'];
			$quantity=$_POST['quantity'];
			
$location=mysqli_real_escape_string($conn,$location);
$title=mysqli_real_escape_string($conn,$title);
$category=mysqli_real_escape_string($conn,$category);
$author=mysqli_real_escape_string($conn,$author);
$town=mysqli_real_escape_string($conn,$town);
$price=mysqli_real_escape_string($conn,$price);
$year=mysqli_real_escape_string($conn,$year);
$description=mysqli_real_escape_string($conn,$description);
$publisher=mysqli_real_escape_string($conn,$publisher);
$quantity=mysqli_real_escape_string($conn,$quantity);

$owner = $_SESSION["username"];

$id = 0;
$sql1="SELECT MAX(id) FROM books ";
$result1=$conn->query($sql1);
if($result1->num_rows>0){
if($row1=$result1->fetch_assoc()){
$id = $row1["MAX(id)"];
}}

$bookcode = 'Bk'.($id+1);
$sql = "insert into books (category,title,author,town,price,year,description,publisher,image_location,owner,book_code,quantity)  values ('".$category."','".$title."','".$author."','".$town."','".$price."','".$year."','".$description."','".$publisher."','".$location."','".$owner."','".$bookcode."','".$quantity."')";

$query=mysqli_query($conn,$sql);

if(!$query) {die("Not submitted, Try again      ".mysqli_error($conn));}
else{
	echo ("<script language='javascript'> window.alert('Book Added Successfully')</script>");
echo "<meta http-equiv='refresh' content='0;url=salerdetails.php'> ";
}
			}
	}
}
?>