<?php 
    require_once ("Includes/simplecms-config.php"); 
    require_once  ("Includes/connectDB.php");
    include("Includes/header.php"); 


    if (isset($_POST['submitCreateBook']))
    {
        $userId = $_SESSION['userid'];
        $userName = $_SESSION['username'];
        $password = $_SESSION['password'];

        $bookCode = $_POST['bookCode'];
        $bookTitle = $_POST['bookTitle'];
        $bookWriter = $_POST['bookWriter'];
        $bookLanguage = $_POST['bookLanguage'];
        $bookPublicationDate = $_POST['bookPublicationDate'];
        $bookNbPage = $_POST['bookNbPage'];
        $state = $_POST['priceCut'];
        $bookPrice = $_POST['bookPrice'];

        //add a book to the database
        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
            or die('Error connection to DB');
        $query1 = "INSERT INTO books (bookCode,bookTitle,bookWriter,bookLanguage,bookPublicationDate,bookNbPage,state,bookPrice,sellerID,sellerName) 
            VALUES ('$bookCode','$bookTitle','$bookWriter','$bookLanguage','$bookPublicationDate','$bookNbPage','$state','$bookPrice','$userId','$userName')";
        
        mysqli_query($dbc, $query1)
            or die('Error while querying');
            
        //get the waiting list of student to get notify and send emails
        $query2 = "SELECT * FROM notify WHERE bookCode = '$bookCode'";
        $listToNotify = mysqli_query($dbc,$query2);
        while ($row = mysqli_fetch_array($listToNotify))
        {
            $sendEmailTo = $row['email'];
            $subject = "Book in stock";
            $message = "The book " . $row['bookCode'] . " is now in stock.";
            sendEmail($sendEmailTo,$subject,$message);
        }
        
        header ('Location: ShopBooks.php');
    }  
    elseif (isset($_POST['submitAddBook']))
    {
        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
            or die('Error connection to DB');
        $bookCode = $_POST['bookCode'];


        $isbn = $bookCode;
        $query = "SELECT * FROM books WHERE bookCode = '$isbn'";
        $result = mysqli_query($dbc,$query);
        if ($result && mysqli_num_rows($result) > 0)
            {
                system.print('Book Found in Database');
                while($row = $result->fetch_assoc()) {

                    //$infos['titre'] = $book->volumeInfo->title;
                    $bookTitle = $row["bookTitle"];
                    //$infos['auteur'] = $book->volumeInfo->authors[0];
                    $bookWriter = $row["bookWriter"];
                    //$infos['langue'] = $book->volumeInfo->language;
                    $bookLanguage = $row["bookLanguage"]; 
                    //$infos['publication'] = $book->volumeInfo->publishedDate;
                    $bookPublicationDate = $row["bookPublicationDate"]; 
                    //$infos['pages'] = $book->volumeInfo->pageCount;
                    $bookNbPage = $row["bookNbPage"];
                    //$infos['price'] = $book->saleInfo->listPrice->amount;
                    $bookPrice = $row["bookPrice"];
                }
                 
            }
        else
            {
                system.print('Book NOT Found in database, try on google API');
                $request = 'https://www.googleapis.com/books/v1/volumes?q=isbn:' . $isbn;
                $response = file_get_contents($request);
                $results = json_decode($response);
  
                if($results->totalItems > 0){  
                    // avec de la chance, ce sera le 1er trouvé  
                    $book = $results->items[0];  
  
                    $infos['isbn'] = $book->volumeInfo->industryIdentifiers[0]->identifier;  
                    //$infos['titre'] = $book->volumeInfo->title;
                    $bookTitle = $book->volumeInfo->title;  
                    //$infos['auteur'] = $book->volumeInfo->authors[0];
                    $bookWriter = $book->volumeInfo->authors[0];
                    //$infos['langue'] = $book->volumeInfo->language;
                    $bookLanguage = $book->volumeInfo->language; 
                    //$infos['publication'] = $book->volumeInfo->publishedDate;
                    $bookPublicationDate = $book->volumeInfo->publishedDate; 
                    //$infos['pages'] = $book->volumeInfo->pageCount;
                    $bookNbPage = $book->volumeInfo->pageCount;
                    //$infos['price'] = $book->saleInfo->listPrice->amount;
                    $bookPrice = $book->saleInfo->listPrice->amount;
                    //$bookPrice = 50;
                    //echo $bookPrice;
                    /*
                    //pour aller chercher l'image
                    if( isset($book->volumeInfo->imageLinks) ){  
                        $infos['image'] = str_replace('&edge=curl', '', $book->volumeInfo->imageLinks->thumbnail);
                    }  
                    */
                    }
                //$isbn = isset($_POST['isbn']) ? $_POST['isbn'] : '';  
                // ou si vous préférez hardcodé  
                //$isbn = '0061234001';  
  
        


        }    
        
    }

?>
<div id="main">
    <h2>Create a book</h2>
        <form action="CreateBook.php" method="post">
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
                    <!--<label for="menulabel">Price:</label> -->


                    <FORM name ="form1" method ="post" action ="radioButton.php">

                    <label for="priceCut">Price:</label>

                    <Input type = 'Radio' Name ='priceCut' value= '0'
                    >New (100% - <?PHP print $bookPrice; ?>$)

                    <Input type = 'Radio' Name ='priceCut' value= '1' 
                    >Almost New (75% - <?PHP print ($bookPrice*0.75); ?>$)

                    <Input type = 'Radio' Name ='priceCut' value= '2'
                    >Used (50% - <?PHP print ($bookPrice*0.5); ?>$)

                    <Input type = 'Radio' Name ='priceCut' value= '3' 
                    <?PHP print $student_status; ?>
                    >Very used (25% - <?PHP print ($bookPrice*0.25); ?>$)

                    </FORM>


                    <input type="text" name="bookPrice" value="<?php echo $bookPrice ?>" id="menulabel" />
                </li>

            </ol>
                <input type="submit" name="submitCreateBook" value="Submit" />
            <p>
                <a href="index.php">Cancel</a>
            </p>
        </fieldset>
    </form>
</div>
</div> <!-- End of outer-wrapper which opens in header.php -->
<?php include ("Includes/footer.php"); ?>

