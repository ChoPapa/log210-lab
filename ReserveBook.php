<?php 
    require_once ("Includes/simplecms-config.php"); 
    require_once  ("Includes/connectDB.php");
    include("Includes/header.php"); 
    
    if (isset($_POST['submitReserveBook']))
    {
        $bookToReserve = $_SESSION['idBook'];
        $userName= $_SESSION['username'];

        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
            or die('Error connection to DB');
        $query = "UPDATE books SET reservedBy='$userName' WHERE idBook='$bookToReserve'";
        //$query = "UPDATE books SET (reservedBy='$userName',reservedSince=NOW()) WHERE idBook='$bookToReserve'";
        
        mysqli_query($dbc, $query)
            or die('Error while querying');

        header ('Location: ShopBooks.php');
    }
    elseif (isset($_POST['submitCancelReservation']))
    {
        header ('Location: ShopBooks.php');
    }

    if($_SESSION['bookState'] == "0"){
        $bookState = "New";
    }
    elseif($_SESSION['bookState'] == "1"){
        $bookState = "Almost New";
    }
    elseif($_SESSION['bookState'] == "2"){
        $bookState = "Used";
    }
    elseif($_SESSION['bookState'] == "3"){
        $bookState = "Very Used";
    }

?>
<div id="main">
    <h2>Validate book number <?php echo $_SESSION['idBook'] ?> </h2>
        <form action="ReserveBook.php" method="post">
            <fieldset>
            <legend>Add Page</legend>
            <ol>
                <li>
                    <label for="menulabel">Code of the Book: <?php echo $_SESSION['bookCode'] ?></label> 
                </li>
                <li>
                    <label for="menulabel">Title: <?php echo $_SESSION['bookTitle'] ?></label> 
                </li>
                <li>
                    <label for="menulabel">Writer: <?php echo $_SESSION['bookWriter'] ?></label> 
                </li>
                <li>
                    <label for="menulabel">Language: <?php echo $_SESSION['bookLanguage'] ?></label> 
                </li>
                <li>
                    <label for="menulabel">Publication Date: <?php echo $_SESSION['bookPublicationDate'] ?></label> 
                </li>
                <li>
                    <label for="menulabel">Number of Pages: <?php echo $_SESSION['bookNbPage'] ?></label> 
                </li>
                <li>
                    <label for="state">State: <?php echo $bookState ?></label>
                </li>
                <li>
                    <label for="menulabel">Book Price: <?php echo $_SESSION['bookPrice'] ?></label>
                </li>

            </ol>
                <input type="submit" name="submitReserveBook" value="Reserve" />
                <input type="submit" name="submitCancelReservation" value="Cancel" />
        </fieldset>
    </form>
</div>
</div> <!-- End of outer-wrapper which opens in header.php -->
<?php include ("Includes/footer.php"); ?>

