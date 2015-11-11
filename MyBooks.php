<?php
     require_once ("Includes/simplecms-config.php"); 
     require_once  ("Includes/connectDB.php");
     include("Includes/header.php");
     $_SESSION['url'] = "MyBooks";

    if (isset($_POST['SubmitBook']))
    {
        /*
        $bookToValidate = $_SESSION['idBook'];
        $userName= $_SESSION['username'];

        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
            or die('Error connection to DB');
        $query = "UPDATE books SET reservedBy='$userName' WHERE idBook='$bookToValidate'";
        //$query = "UPDATE books SET reservedBook='$' WHERE idBook='$bookToValidate'";
        
        mysqli_query($dbc, $query)
            or die('Error while querying');
        */

        $_SESSION['idBook'] = $_POST["SubmitBook"];
        $IdBook = $_SESSION['idBook'];
        
        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
            or die('Error connection to DB');


        $query = "SELECT * FROM books WHERE idBook = '$IdBook'";
        $result = mysqli_query($dbc,$query);
        if ($result && mysqli_num_rows($result) > 0)
        {
            while($row = $result->fetch_assoc())
            {
                
                $_SESSION['bookCode'] = $row["bookCode"];
                //$_SESSION['bookCode'] = $bookCode;
                $_SESSION['bookTitle'] = $row["bookTitle"];
                //$_SESSION['bookTitle'] = $bookTitle;
                $_SESSION['bookWriter'] = $row["bookWriter"];
                //$_SESSION['bookWriter'] = $bookWriter;
                $_SESSION['bookLanguage'] = $row["bookLanguage"];
                //$_SESSION['bookLanguage'] = $bookLanguage;
                $_SESSION['bookPublicationDate'] = $row["bookPublicationDate"];
                //$_SESSION['bookPublicationDate'] = $bookPublicationDate;
                $_SESSION['bookNbPage'] = $row["bookNbPage"];
                //$_SESSION['bookNbPage'] = $bookNbPage;
                $_SESSION['bookState'] = $row["state"];
                //$_SESSION['bookState'] = $bookState;
                $_SESSION['bookPrice'] = $row["bookPrice"];
                //$_SESSION['bookPrice'] = $bookPrice;
                //$_SESSION['sellerName'] = $row["sellerName"];
                
            }   
        } 

        header ('Location: MyBookToValidate.php');
    }

?>

<h2>My Books</h2>
<form action="MyBooks.php" method="post">

<?php
    printBookTable($_SESSION['username']);
?>

  

</div> <!-- End of outer-wrapper which opens in header.php -->
<?php 
    include ("Includes/footer.php");
 ?>