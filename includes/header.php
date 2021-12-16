<?php if(session_status()==PHP_SESSION_NONE){
session_start();} ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>E-BookShop</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/sticky-footer.css">
  <link rel="stylesheet" href="css/custom.css">
  <link rel="stylesheet" href="css/jquery.dataTables.css">
  <link rel="stylesheet" href="css/jquery.dataTables.min.css">
 <link rel="stylesheet" href="css/jquery.dataTables_themeroller.css">
 <link rel="stylesheet" href="css/style.css">
  
  <script src="js/jquery.min.js"></script>
  <script src="js/datetime.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/moment-with-locales.js"></script>
  <script src="js/bootstrap-datetimepicker.js"></script>
  <script src="js/jquery.dataTables.js"></script>
  <script src="js/jquery.dataTables.min.js"></script>
  <script src="js/jquery.js"></script>
  <script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="js/jssor.slider.mini.js"></script>
  <link href="css/bootstrap-datetimepicker.css" rel="stylesheet">
  
       <!--print script -->
     <script language="javascript" type="text/javascript">
        function printDiv(divID) {
            //Get the HTML of div
            var divElements = document.getElementById(divID).innerHTML;
            //Get the HTML of whole page
            var oldPage = document.body.innerHTML;

            //Reset the pages HTML with divs HTML only
            document.body.innerHTML = 
              "<html><head><title></title></head><body>" + 
              divElements + "</body>";

            //Print Page
            window.print();

            //Restore orignal HTML
            document.body.innerHTML = oldPage;

          
        }
		
		 function numbersonly(e){
    var unicode=e.charCode? e.charCode : e.keyCode
    if (unicode!=8 & unicode!=46 & unicode!=37 & unicode!=39 ){ //if the key isn't the backspace,delete,left and right arrow keys (which we should allow)
        if (unicode<48||unicode>57) //if not a number
            return false //disable key press
    }
	}
	
	function confirmDeleteBook(id)
{
 if(confirm('This record will be deleted parmanently.\n Are you sure you want to continue?'))
 {
  window.location.href='deleteBooks.php?del='+id;
 }
 else{window.location.href='books.php';}
}	



 function doSearch() {
            var searchText = document.getElementById('searchTerm').value;
            var targetTable = document.getElementById('dataTable');
            var targetTableColCount;

            //Loop through table rows
            for (var rowIndex = 0; rowIndex < targetTable.rows.length; rowIndex++) {
                var rowData = '';

                //Get column count from header row
                if (rowIndex == 0) {
                    targetTableColCount = targetTable.rows.item(rowIndex).cells.length;
                    continue; //do not execute further code for header row.
                }

                //Process data rows. (rowIndex >= 1)
                for (var colIndex = 0; colIndex < targetTableColCount; colIndex++) {
                    var cellText = '';

                    if (navigator.appName == 'Microsoft Internet Explorer')
                        cellText = targetTable.rows.item(rowIndex).cells.item(colIndex).innerText;
                    else
                        cellText = targetTable.rows.item(rowIndex).cells.item(colIndex).textContent;

                    rowData += cellText;
                }

                // Make search case insensitive.
                rowData = rowData.toLowerCase();
                searchText = searchText.toLowerCase();

                //If search term is not found in row data
                //then hide the row, else show
                if (rowData.indexOf(searchText) == -1)
                    targetTable.rows.item(rowIndex).style.display = 'none';
                else
                    targetTable.rows.item(rowIndex).style.display = 'table-row';
            }
        }
 </script>
	
	<style type="text/css">
	#nv{
	vbackground-color:#999999;
	border:none;
	}
	#nv li a{
	ccolor:#000000;
	}
	#nv li a hover{
	color:#00FF00;
	}
	.navbar-brand hover{
	color:#666666;	}
	.lbll{
	padding-top:10px;
	text-decoration:blink;
	color:#990000;
	font-family:"Times New Roman", Times, serif;
	}
	</style>
  
  
</head>

<body onload=display_ct(); oncontextmenu="return false">


<!-- header -->
<header>

<div class="container" style="padding:0px;">
 <div class="page-header">
  <h1 align="center" class="logo-img"><img src="img/e-bs.png" alt="E-BookShop"/></h1> 
  <ul class="nav sign-nav">
    <li class="welcome-guest">
	<?php 
	if(!(isset($_SESSION["loggedin"]))){?>
    Welcome Customer
    <?php } else {
     echo 'Welcome '.$_SESSION["username"];
	}
   ?>
   </li>
    <li class="date-time"><span id='ct' ></span></li>
  </ul>


<nav class="navbar navbar-inverse" id="nv">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="#">E-BookShop</a>
	 <!--<label class="lbl">SSDSS</label>-->
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <?php if(!isset($_SESSION["loggedin"])){?>
		<li><a href="index.php">HOME</a></li>
    <?php } else { ?>
	     <li><a href="salerdetails.php">HOME</a></li>
        <li><a href="sales.php">SALES</a></li> <?php  } ?> 
		<li><a href="books.php">BOOKS' DETAILS</a></li>
		<li><a href="buybooks.php">PURCHASE</a></li>
 	<li><a href="contact.php">Contact us</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
	<?php if(isset($_SESSION["loggedin"])){?>
		<li style="float:right;"><a href="logout.php">Logout</a></li>
    <?php } ?>  
      </ul>
    </div>
  </div>
</nav>

  </div>

 </div>
</header>
<!-- header --> 