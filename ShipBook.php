<?php
     require_once ("Includes/simplecms-config.php"); 
     require_once  ("Includes/connectDB.php");
     include("Includes/header.php");
     $_SESSION['url'] = "ShipBook";

    if (isset($_POST['SubmitBook']))
    {
        
        $_SESSION['idBook'] = $_POST["SubmitBook"];
        $idBook = $_SESSION['idBook'];
        
        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
            or die('Error connection to DB');
        $query = "UPDATE books SET valid='Shipping to Coop',reservedSince=NOW() WHERE idBook='$idBook'";
        mysqli_query($dbc, $query)
            or die('Error while querying');


        $query2 = "SELECT * FROM books WHERE idBook='$idBook'";
        $result = mysqli_query($dbc,$query2);
        while ($row = mysqli_fetch_array($result))
        {
            $sendEmailTo = $row['reservedBy'];
            $subject = "Book received";
            $message = "The book " . $row['bookCode'] . " is now received at your coop.";
            sendEmail($sendEmailTo,$subject,$message);
        }

        header ('Location: ShipBook.php');
    }
?>

<h2>Ship Book</h2>
<form action="ShipBook.php" method="post">

<?php
    printBookTable(ALL);
?>

  

</div> <!-- End of outer-wrapper which opens in header.php -->
<?php 
    include ("Includes/footer.php");
 ?>