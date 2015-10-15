<?php 
    require_once ("Includes/simplecms-config.php"); 
    require_once  ("Includes/connectDB.php");
    include("Includes/header.php"); 

    if (isset($_POST['submitAddBook']))
    {
        $submitBookToAdd = $_POST["bookCode"];
        header ('Location: CreateBook.php');
    }
     
?>
<div id="main">
    <h2>Find a book</h2>
        <form action="CreateBook.php" method="post">
            <fieldset>
            <legend>Add Page</legend>
            <ol>
                <li>
                    <label for="menulabel">Code of the Book:</label>
                    <input type="text" name="bookCode" value="0061234001" id="menulabel" />
                    <!--<input type="text" name="bookCode" value="2511033976" id="menulabel" />
                    -->
                </li>
            </ol>
                <input type="submit" name="submitAddBook" value="Add Book" />
            <p>
                <a href="index.php">Cancel</a>
            </p>
        </fieldset>
    </form>
</div>
</div> <!-- End of outer-wrapper which opens in header.php -->
<?php include ("Includes/footer.php"); ?>

