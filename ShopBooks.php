<?php
     require_once ("Includes/simplecms-config.php"); 
     require_once  ("Includes/connectDB.php");
     include("Includes/header.php");

    if (isset($_POST['SubmitBook']))
    {
        
        $bookToValidate = $_SESSION['idBook'];
        $userName= $_SESSION['username'];

        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
            or die('Error connection to DB');
        $query = "UPDATE books SET reservedBy='$userName' WHERE idBook='$bookToValidate'";
        //$query = "UPDATE books SET reservedBook='$' WHERE idBook='$bookToValidate'";
        
        mysqli_query($dbc, $query)
            or die('Error while querying');
        
        header ('Location: ShopBooks.php');
    }

?>


<form action="ShopBooks.php" method="post">

<?php
    printBookTable(ALL);
?>

  

</div> <!-- End of outer-wrapper which opens in header.php -->
<?php 
    include ("Includes/footer.php");
 ?>