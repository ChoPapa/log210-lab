<?php 
    require_once ("Includes/simplecms-config.php"); 
    require_once  ("Includes/connectDB.php");
    require_once ("Includes/class.phpmailer.php");
    include("Includes/header.php"); 

    
    
    if (isset($_POST['submitDelivery']))
    {

        $bookToDelete = $_SESSION['idBook'];


        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
            or die('Error connection to DB');
        $query = "DELETE FROM books WHERE idBook='$bookToDelete'";
        
        mysqli_query($dbc, $query)
            or die('Error while querying');
        
      header ('Location: DeliverBook.php');        
     }
    

?>
<div id="main">
    <h2>Confirme Book Delivery <?php echo $bookToDelete ?> </h2>
        <form action="FinalizeDeliver.php" method="post">
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

                <input type="submit" name="submitDelivery" value="Submit" />
            <p>
                <a href="index.php">Cancel</a>
            </p>
        </fieldset>
    </form>
</div>
</div> <!-- End of outer-wrapper which opens in header.php -->
<?php include ("Includes/footer.php"); ?>

