<?php 
    require_once ("Includes/simplecms-config.php"); 
    require_once  ("Includes/connectDB.php");
    include("Includes/header.php"); 

    if (isset($_POST['submit']))
    {
        $userId = $_SESSION['userid'];
        $userName = $_SESSION['username'];
        $password = $_SESSION['password'];

        $bookName = $_POST['bookName'];
        $bookPrice = $_POST['bookPrice'];


        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
            or die('Error connection to DB');
        $query = "INSERT INTO books (bookName,bookPrice,sellerID,sellerName) VALUES ('$bookName','$bookPrice','$userId','$userName')";
        mysqli_query($dbc, $query)
            or die('Error while querying');


        header ('Location: ShopBooks.php');
    }
     
?>
<div id="main">
    <h2>Add a book</h2>
        <form action="AddBook.php" method="post">
            <fieldset>
            <legend>Add Page</legend>
            <ol>
                <li>
                    <label for="menulabel">Name of the book:</label> 
                    <input type="text" name="bookName" value="" id="menulabel" />
                </li>
                <li>
                    <label for="menulabel">Price of the Book:</label> 
                    <input type="text" name="bookPrice" value="" id="menulabel" />
                </li>
            </ol>
                <input type="submit" name="submit" value="Submit" />
            <p>
                <a href="index.php">Cancel</a>
            </p>
        </fieldset>
    </form>
</div>
</div> <!-- End of outer-wrapper which opens in header.php -->
<?php include ("Includes/footer.php"); ?>

