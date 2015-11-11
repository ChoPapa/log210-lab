<?php
    require_once ("Includes/simplecms-config.php"); 
    require_once  ("Includes/connectDB.php");
    include("Includes/header.php");

if (isset($_POST['SubmitBook']))
{
    
    $bookToValidate = $_POST["SubmitBook"];
    $_SESSION['idBook'] = $bookToValidate;

    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
        or die('Error connection to DB');


    $query = "SELECT * FROM books WHERE idBook = '$bookToValidate'";
    $result = mysqli_query($dbc,$query);
    if ($result && mysqli_num_rows($result) > 0)
    {
        while($row = $result->fetch_assoc())
        {
            $bookCode = $row["bookCode"];
            $_SESSION['bookCode'] = $bookCode;
            $bookTitle = $row["bookTitle"];
            $_SESSION['bookTitle'] = $bookTitle;
            $bookWriter = $row["bookWriter"];
            $_SESSION['bookWriter'] = $bookWriter;
            $bookLanguage = $row["bookLanguage"];
            $_SESSION['bookLanguage'] = $bookLanguage;
            $bookPublicationDate = $row["bookPublicationDate"];
            $_SESSION['bookPublicationDate'] = $bookPublicationDate;
            $bookNbPage = $row["bookNbPage"];
            $_SESSION['bookNbPage'] = $bookNbPage;
            $bookState = $row["state"];
            $_SESSION['bookState'] = $bookState;
            $bookPrice = $row["bookPrice"];
            $_SESSION['bookPrice'] = $bookPrice;
            $_SESSION['sellerName'] = $row["sellerName"];
        }
                 
    } 
    
    header ('Location: ValidateOneBook.php');
}
?>

<h2>Validate Book</h2>
<form action="ValidationBook.php" method="post">


<!--<form action="ValidateOneBook.php" method="post">
-->



<?php
/*
if($_GET["p"] == "ValidationBook"){
    echo 'detecte la bonne page';
}   
*/

    printBookTable(ALL);
?>

  

</div> <!-- End of outer-wrapper which opens in header.php -->
<?php 
    include ("Includes/footer.php");
 ?>