
<?php require_once('includes/header.php'); //include the template top ?>


<div class="container">
   <hr/>
<?php
//session_start();
include_once("includes/dbconn.php");
if(!empty($_GET["action"])) {
switch($_GET["action"]) {
	case "add":
		if(!empty($_POST["quantity"])) {
		$resultset = array();
		$sql = "SELECT * FROM books WHERE book_code='" . $_GET["book_code"] . "'";
		$result=$conn->query($sql);
       if($result->num_rows>0){
       while($row=$result->fetch_assoc()){
		$resultset[] = $row;}
		}
		
			$bookByCode = $resultset;
			$itemArray = array($bookByCode[0]["book_code"]=>array('book_code'=>$bookByCode[0]["book_code"],'category'=>$bookByCode[0]["category"], 'title'=>$bookByCode[0]["title"], 'quantity'=>$_POST["quantity"], 'price'=>$bookByCode[0]["price"]));
			
			if($_POST["quantity"]>$bookByCode[0]["quantity"]){
			echo "<script>alert('Sorry, we can only supply upto ".$bookByCode[0]["quantity"]." such books')</script>";
			}
			else{
			if(!empty($_SESSION["cart_item"])) {
				if(in_array($bookByCode[0]["book_code"],$_SESSION["cart_item"])) {
					foreach($_SESSION["cart_item"] as $k => $v) {
							if($bookByCode[0]["book_code"] == $k)
								$_SESSION["cart_item"][$k]["quantity"] = $_POST["quantity"];
					}
				} else {
					$_SESSION["cart_item"] = array_merge($_SESSION["cart_item"],$itemArray);
				}
			} else {
				$_SESSION["cart_item"] = $itemArray;
			}
		  }
		}
	break;
	case "remove":
		if(!empty($_SESSION["cart_item"])) {
			foreach($_SESSION["cart_item"] as $k => $v) {
					if($_GET["book_code"] == $k)
						unset($_SESSION["cart_item"][$k]);				
					if(empty($_SESSION["cart_item"]))
						unset($_SESSION["cart_item"]);
			}
		}
	break;
	case "empty":
		unset($_SESSION["cart_item"]);
	break;	
}
}
?>
<div id="shopping-cart">
<div class="txt-heading">Shopping Cart <a id="btnEmpty" href="buybooks.php?action=empty">Empty Cart</a></div>
<?php
if(isset($_SESSION["cart_item"])){
    $item_total = 0;
?>	
<table cellpadding="10" cellspacing="1" class="table table-striped table-bordered table-hover table-condensed table-responsive display">
<tbody>
<tr>
<th><strong>Category</strong></th>
<th><strong>Title</strong></th>
<th><strong>Quantity</strong></th>
<th><strong>Price</strong></th>
<th><strong>Action</strong></th>
</tr>	
<?php		
    foreach ($_SESSION["cart_item"] as $item){
		?>
				<tr>
				<td><strong><?php echo $item["category"]; ?></strong></td>
				<td><?php echo $item["title"]; ?></td>
				<td><?php echo $item["quantity"]; ?></td>
				<td><?php echo "KShs. ".$item["price"]; ?></td>
				<td><a href="buybooks.php?action=remove&book_code=<?php echo $item["book_code"]; ?>" class="btnRemoveAction">Remove Item</a></td>
				</tr>
				<?php
        $item_total += ($item["price"]*$item["quantity"]);
		}
		
		?>

<tr>
<td colspan="5" align=right><strong>Total:</strong> <?php echo "KShs. ".$item_total; ?></td></tr>
<tr><td colspan="2"><span class="text-primary">To purchase, send <?php echo "KShs. ".$item_total; ?> via M-Pesa to 0717246969 then submit the transaction id</span></td><tr>
<form method="post" action="buybooks.php">
<tr><td><input type="text" class="form-control add-todo" placeholder="Enter The Transaction ID Here" name="tid" required></td>
<td><input type="text" class="form-control add-todo" placeholder="Enter Your Physical Address Here" name="address" required></td>
<td><input type="text" class="form-control add-todo" placeholder="Enter Your Telephone Number Here" name="phone" onKeyPress="return numbersonly(event)" required></td>
<td><input type="submit" class="btn btn-primary" style="float: right;" value="Purchase" name="registerbtn" /> 
			</form>
</td>
</tr>
</tbody>
</table>		
  <?php
}
?>
</div>

<div id="product-grid">
	<div class="txt-heading">Books</div>
	<?php
	$sql = "SELECT * FROM books WHERE quantity!='0'";
		$result=$conn->query($sql);
       if($result->num_rows>0){
       while($row=$result->fetch_assoc()){
		$resultset[] = $row;}
		}
	$product_array = $resultset;
	if (!empty($product_array)) { 
		foreach($product_array as $key=>$value){
	?>
		<div class="product-item">
			<form method="post" action="buybooks.php?action=add&book_code=<?php echo $product_array[$key]["book_code"]; ?>">
			<div class="product-image"><img height="100" width="100" src="<?php echo $product_array[$key]["image_location"]; ?>"></div>
			<div><strong>Book Code: <?php echo $product_array[$key]["book_code"]; ?></strong></div>
			<div><strong>Category: <?php echo $product_array[$key]["category"]; ?></strong></div>
			<div><strong><?php echo "Title: ".$product_array[$key]["title"]; ?></strong></div>
			<div class="product-price"><?php echo "	KShs. ".$product_array[$key]["price"]; ?></div>
			<div><input type="text" name="quantity" value="1" size="2" onKeyPress="return numbersonly(event)" />
			<input type="submit" value="Add to cart" class="btnAddAction" /></div>
			</form>
		</div>
	<?php
			}
	}
	?>
</div>

 <hr>

</div>
 
  
<?php require_once('includes/footer.php'); //include footer template ?>

<?php
if(isset($_POST['registerbtn'])){
$sql="SELECT COUNT(*) FROM payment WHERE transaction_id='".$_POST['tid']."' ";
$query=mysqli_query($conn,$sql);
$result=mysqli_fetch_array($query);

if($result[0]<=0){
?>
<script>
alert('Payment not received or incorrect transaction id\nKindly make corrections then try again');
</script>
<?php
}
else{
$tid=mysqli_real_escape_string($conn,$_POST['tid']);
$address=mysqli_real_escape_string($conn,$_POST['address']);
$phone=mysqli_real_escape_string($conn,$_POST['phone']);

$total = 0;
foreach ($_SESSION["cart_item"] as $item){
        $item_total = ($item["price"]*$item["quantity"]);
		$total += $item["quantity"];
//Fetch quantity and update it
$remquant = 0; $newquant = 0;		
$sql1="SELECT * FROM books where book_code='".$item["book_code"]."'";
$result1=$conn->query($sql1);
if($result1->num_rows>0){
if($row1=$result1->fetch_assoc()){
$remquant = $row1["quantity"];
}}
$newquant = $remquant-$item["quantity"];
$sql = "update books set quantity='".$newquant."' where book_code='".$item["book_code"]."' ";
$query=mysqli_query($conn,$sql);
if(!$query) {die("Not updated, Try again      ".mysqli_error($conn));}

//Insert sale		
$sql = "insert into sales (book_code,quantity_bot,total_amout,transaction_code,address,phone)  values ('".$item["book_code"]."','".$item["quantity"]."','".$item_total."','".$tid."','".$address."','".$phone."')";	
$query=mysqli_query($conn,$sql);
if(!$query) {die("Not submitted, Try again      ".mysqli_error($conn));}
}//End of foreach , saves each item separately


// Be sure to include the file you've just downloaded
require_once('includes/AfricasTalkingGateway.php');
// Specify your login credentials
$username   = "Milly";
$apikey     = "9a145d7b131b70c872594b55f04fdd5947d8f8b5557e6e459cf8bf8d8340e948";
// Specify the numbers that you want to send to in a comma-separated list
// Please ensure you include the country code (+254 for Kenya in this case)
$recipients = "+254".$phone;
// And of course we want our recipients to know what we really do
$message    = "E-BookShop Notification: You have purchased books worth Ksh. '".$total."'. Kindly await delivery.";
// Create a new instance of our awesome gateway class
$gateway    = new AfricasTalkingGateway($username, $apikey);
// Any gateway error will be captured by our custom Exception class below, 
// so wrap the call in a try-catch block
try 
{ 
  // Thats it, hit send and we'll take care of the rest. 
  $results = $gateway->sendMessage($recipients, $message);
            
  foreach($results as $result) {
    // status is either "Success" or "error message"
   // echo " Number: " .$result->number;
    //echo " Status: " .$result->status;
    //echo " MessageId: " .$result->messageId;
    //echo " Cost: "   .$result->cost."\n";
  }
}
catch ( AfricasTalkingGatewayException $e )
{
  echo "Encountered an error while sending: ".$e->getMessage();
}

?>
<script>
alert('Purchase made successfully. Kindly await delivery.');
</script>
<?php
unset($_SESSION["cart_item"]);
echo "<meta http-equiv='refresh' content='0;url=buybooks.php'> ";
}
}
?>