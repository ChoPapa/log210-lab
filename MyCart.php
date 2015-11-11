<?php 
    require_once ("Includes/simplecms-config.php"); 
    require_once  ("Includes/connectDB.php");
    include("Includes/header.php");
    $_SESSION['url'] = "MyCart";

    if (isset($_POST['submit']))
    {
        $userId = $_SESSION['userid'];
        $userName = $_SESSION['username'];
        $password = $_SESSION['password'];

        header ('Location: ShopBooks.php');
    }
     
?>
<h2>My Cart</h2>
<form action="MyCart.php" method="post">

<?php
    printBookTable($userName);
?>

  

</div> <!-- End of outer-wrapper which opens in header.php -->
<?php include ("Includes/footer.php"); ?>

