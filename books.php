
<?php require_once('includes/header.php'); //include the template top
include_once("includes/dbconn.php"); ?>


<div class="container">
<div class="col-md-4">
<input style="float:right;" type="text" id="searchTerm" class="search_box form-control add-todo" placeholder="Type to search..." onkeyup="doSearch()" />
</div>
<hr>
<table id="dataTable" class="table table-striped table-bordered table-hover table-condensed table-responsive display">
<tbody>
<tr><th>Image</th><th>Category</th><th>Title</th><th>Author</th><th>Publisher</th><th>Town/City</th><th>Year</th><th>Price (KShs.)</th><th>Synopsis</th><th>Quantity</th>
<?php if(isset($_SESSION["loggedin"])){?><th colspan="2">Action</th><?php }?></tr>
<?php 
$sql = '';
if(isset($_SESSION["loggedin"])){ $sql="SELECT * FROM books where owner='".$_SESSION["username"]."' ORDER BY category"; }
else{$sql="SELECT * FROM books ORDER BY category";}
$result=$conn->query($sql);
if($result->num_rows>0){
while($row=$result->fetch_assoc()){
echo "<tr> 
<td> <img src=".$row["image_location"]." height='70' width='70'></td> 
<td> ".$row["category"]." </td>
<td> ".$row["title"]." </td> 
<td> ".$row["author"]."</td> 
<td> ".$row["publisher"]." </td>
<td> ".$row["town"]." </td> 
<td> ".$row["year"]."</td> 
<td> ".$row["price"]." </td>
<td> ".$row["description"]." </td>
<td> ".$row["quantity"]." </td>";

if(isset($_SESSION["loggedin"])){
echo "<td>  <a href='editBooks.php?edit=$row[id]'>Edit</a></td>
<td>  <a href='javascript:confirmDeleteBook($row[id])'>Delete</a></td>"; }
echo "</tr>";}
echo "</tbody></table> ";

}
else{
//When table is empty
echo ("<script language='javascript'> window.alert('There are no unsold books now')</script>"); 
	if(!(isset($_SESSION["loggedin"]))){ echo "<meta http-equiv='refresh' content='0;url=index.php'> ";}
else{echo "<meta http-equiv='refresh' content='0;url=salerdetails.php'> ";}

}
?>
 <hr>
</div>
 
  
<?php require_once('includes/footer.php'); //include footer template ?>
