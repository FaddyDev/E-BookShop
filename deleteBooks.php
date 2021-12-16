
<?php
//Connect to database via another page
include_once("includes/dbconn.php");
?>

<?php
if(isset($_GET['del']))
{
$id=$_GET['del'];
$sql="DELETE FROM books WHERE id='".$id."' ";
//$result=mysqli_query($sql) or die("Could not delete".mysqli_error());
$result=$conn->query($sql);
echo ("<script language='javascript'> window.alert('Book Deleted successfully')</script>");
echo "<meta http-equiv='refresh' content='0;url=books.php'> ";
}
?>