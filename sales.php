
<?php require_once('includes/header.php'); //include the template top
include_once("includes/dbconn.php"); ?>


<div class="container">
<div class="col-md-4">
<input style="float:right;" type="text" id="searchTerm" class="search_box form-control add-todo" placeholder="Type to search..." onkeyup="doSearch()" />
</div>
<hr>
<table id="dataTable" class="table table-striped table-bordered table-hover table-condensed table-responsive display">
<tbody>
<tr><th>Image</th><th>Category</th><th>Title</th><th>Author</th><th>Quantity</th><th>Total Amount(KShs)</th><th>Buyer's Address</th></tr>
<?php 
$sql="SELECT * from books,sales WHERE books.book_code=sales.book_code and books.owner='".$_SESSION["username"]."' ORDER BY sales.id"; 
$result=$conn->query($sql);
if($result->num_rows>0){
while($row=$result->fetch_assoc()){
echo "<tr> 
<td> <img src=".$row["image_location"]." height='70' width='70'></td> 
<td> ".$row["category"]." </td>
<td> ".$row["title"]." </td> 
<td> ".$row["author"]."</td> 
<td> ".$row["quantity_bot"]." </td>
<td> ".$row["total_amout"]." </td> 
<td> ".$row["address"]."</td>
</tr>";}
echo "</tbody></table>";
}
else{
//When table is empty
echo ("<script language='javascript'> window.alert('There are no bought books')</script>"); 
echo "<meta http-equiv='refresh' content='0;url=books.php'> ";

}
?>
 <hr>
</div>
 
  
<?php require_once('includes/footer.php'); //include footer template ?>
