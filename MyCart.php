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
<div id="main">
    <h2>My Cart</h2>
        <form action="ShopBooks.php" method="post">
            <fieldset>

            <p>
                <a href="index.php">Cancel</a>
            </p>
        </fieldset>
    </form>
</div>
</div> <!-- End of outer-wrapper which opens in header.php -->
<?php include ("Includes/footer.php"); ?>

