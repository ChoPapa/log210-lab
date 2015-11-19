<?php 
    require_once ("Includes/simplecms-config.php"); 
    require_once  ("Includes/connectDB.php");
    include("Includes/header.php"); 

    if (isset($_POST['submitBookCode']))
    {
        $notifyForThisBook = $_POST["bookCode"];
        $sellerName = $_SESSION['username'];

        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
            or die('Error connection to DB');
        $query = "INSERT INTO notify (bookCode, email) VALUES ('$notifyForThisBook', '$sellerName')";
        
        mysqli_query($dbc, $query)
            or die('Error while querying');


        header ('Location: ShopBooks.php');
    }
     
?>
<div id="main">
    <h2>Notify Me When In Stock</h2>
        <form action="NotifyMeWhenInStock.php" method="post">
            <fieldset>
            <legend>Add Page</legend>
            <ol>
                <li>
                    <label for="menulabel">Code of the Book:</label>
                    <input type="text" name="bookCode" value="" id="menulabel" />
                </li>
            </ol>
                <input type="submit" name="submitBookCode" value="Notify Me" />
            <p>
                <a href="index.php">Cancel</a>
            </p>
        </fieldset>
    </form>
</div>
</div> <!-- End of outer-wrapper which opens in header.php -->
<?php include ("Includes/footer.php"); ?>

