<?php 
    require_once ("Includes/simplecms-config.php"); 
    require_once  ("Includes/connectDB.php");
    include("Includes/header.php"); 

    if (isset($_POST['submit']))
    {
        $userId = $_SESSION['userid'];
        $userName = $_SESSION['username'];
        $password = $_SESSION['password'];

        header ('Location: ShopBooks.php');
    }
     
?>
<form action="MyCart.php" method="post">

<?php
    printBookTable($userName);
?>

  

</div> <!-- End of outer-wrapper which opens in header.php -->
<?php include ("Includes/footer.php"); ?>

