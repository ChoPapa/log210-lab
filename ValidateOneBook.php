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


    }  
    elseif (isset($_POST['submitValidateOneBook']))
    {
        $bookToValidate = $_SESSION['idBook'];

        //si le livre n'a pas ete modifier par le gestionnaire
        if($_SESSION['bookCode'] == $_POST['bookCode']
            && $_SESSION['bookTitle'] == $_POST['bookTitle']
            && $_SESSION['bookWriter'] == $_POST['bookWriter']
            && $_SESSION['bookLanguage'] == $_POST['bookLanguage']
            && $_SESSION['bookPublicationDate'] == $_POST['bookPublicationDate']
            && $_SESSION['bookNbPage'] == $_POST['bookNbPage']
            && $_SESSION['bookState'] == $_POST['state']
            )
        {
            $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
                or die('Error connection to DB');
            $query = "UPDATE books SET valid='Yes' WHERE idBook='$bookToValidate'";
        
            mysqli_query($dbc, $query)
                or die('Error while querying');
            //ENVOYER UN EMAIL A L ETUDIAT POUR CONFIRMER L ETAT DU LIVRE
            //email = $_SESSION['sellerName']
        }
        else{
            
            $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
                or die('Error connection to DB');
            $query = "UPDATE books SET valid='To Confirme' WHERE idBook='$bookToValidate'";
        
            mysqli_query($dbc, $query)
                or die('Error while querying');

            //ENVOYER UN EMAIL COMME QUOI LE LIVRE A ETE MODIFIER
            //email = $_SESSION['sellerName']

        }
        header ('Location: ValidationBook.php');
    }

?>
<div id="main">
    <h2>Validate book number <?php echo $bookToValidate ?> </h2>
        <form action="ValidateOneBook.php" method="post">
            <fieldset>
            <legend>Add Page</legend>
            <ol>
                <li>
                    <label for="menulabel">Code of the Book:</label> 
                    <input type="text" name="bookCode" value="<?php echo $bookCode ?>" id="menulabel" />
                </li>
                <li>
                    <label for="menulabel">Title:</label> 
                    <input type="text" name="bookTitle" value="<?php echo $bookTitle ?>" id="menulabel" />
                </li>
                <li>
                    <label for="menulabel">Writer:</label> 
                    <input type="text" name="bookWriter" value="<?php echo $bookWriter ?>" id="menulabel" />
                </li>
                <li>
                    <label for="menulabel">Language:</label> 
                    <input type="text" name="bookLanguage" value="<?php echo $bookLanguage ?>" id="menulabel" />
                </li>
                <li>
                    <label for="menulabel">Publication Date:</label> 
                    <input type="text" name="bookPublicationDate" value="<?php echo $bookPublicationDate ?>" id="menulabel" />
                </li>
                <li>
                    <label for="menulabel">Number of Pages:</label> 
                    <input type="text" name="bookNbPage" value="<?php echo $bookNbPage ?>" id="menulabel" />
                </li>
                <li>

                    <FORM name ="form1" method ="post" action ="radioButton.php">

                    <label for="state">State:</label>

                    <Input type = 'Radio' Name ='state' value= '0' <?php echo ($bookState=='0') ? 'checked="checked"' : ''; ?>>New
                    <Input type = 'Radio' Name ='state' value= '1' <?php echo ($bookState=='1') ? 'checked="checked"' : ''; ?>>Almost New
                    <Input type = 'Radio' Name ='state' value= '2' <?php echo ($bookState=='2') ? 'checked="checked"' : ''; ?>>Used
                    <Input type = 'Radio' Name ='state' value= '3' <?php echo ($bookState=='3') ? 'checked="checked"' : ''; ?>>Very used

                    </FORM>


                    <input type="text" name="bookPrice" value="<?php echo $bookPrice ?>" id="menulabel" />
                </li>

            </ol>
                <input type="submit" name="submitValidateOneBook" value="Submit" />
            <p>
                <a href="index.php">Cancel</a>
            </p>
        </fieldset>
    </form>
</div>
</div> <!-- End of outer-wrapper which opens in header.php -->
<?php include ("Includes/footer.php"); ?>

