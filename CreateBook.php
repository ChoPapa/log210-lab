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


        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
            or die('Error connection to DB');
        $query = "INSERT INTO books (bookCode,bookTitle,bookWriter,bookLanguage,bookPublicationDate,bookNbPage,bookPrice,sellerID,sellerName) 
            VALUES ('$bookCode','$bookTitle','$bookWriter','$bookLanguage','$bookPublicationDate','$bookNbPage','$bookPrice','$userId','$userName')";
        
        mysqli_query($dbc, $query)
            or die('Error while querying');

        // pour tester
        //print_r($infos);  

        header ('Location: ShopBooks.php');
    }  
    elseif (isset($_POST['submitAddBook']))
    {
        $bookCode = $_POST['bookCode'];

        $isbn = $bookCode;
        //$isbn = isset($_POST['isbn']) ? $_POST['isbn'] : '';  
        // ou si vous préférez hardcodé  
        //$isbn = '0061234001';  
  
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
            $bookPrice = $book->saleInfo->listPrice->amount;;

            /*
            //pour aller chercher l'image
            if( isset($book->volumeInfo->imageLinks) ){  
                $infos['image'] = str_replace('&edge=curl', '', $book->volumeInfo->imageLinks->thumbnail);
            }  
            */


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
                    <label for="menulabel">Price:</label> 
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

