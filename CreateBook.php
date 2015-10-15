<?php 
    require_once ("Includes/simplecms-config.php"); 
    require_once  ("Includes/connectDB.php");
    include("Includes/header.php"); 

    if (isset($_POST['submit']))
    {
        $userId = $_SESSION['userid'];
        $userName = $_SESSION['username'];
        $password = $_SESSION['password'];

        $bookCode = $_POST['bookCode'];
        //$bookName = $_POST['bookName'];
        $bookPrice = $_POST['bookPrice'];





        //$isbn = $bookCode;
        //$isbn = isset($_POST['isbn']) ? $_POST['isbn'] : '';  
        // ou si vous préférez hardcodé  
        $isbn = '0061234001';  
  
        $request = 'https://www.googleapis.com/books/v1/volumes?q=isbn:' . $isbn;
        $response = file_get_contents($request);
        $results = json_decode($response);
  
        if($results->totalItems > 0){  
           // avec de la chance, ce sera le 1er trouvé  
           $book = $results->items[0];  
  
           $infos['isbn'] = $book->volumeInfo->industryIdentifiers[0]->identifier;  
           $infos['titre'] = $book->volumeInfo->title;  
           $infos['auteur'] = $book->volumeInfo->authors[0];  
           $infos['langue'] = $book->volumeInfo->language;  
           $infos['publication'] = $book->volumeInfo->publishedDate;  
           $infos['pages'] = $book->volumeInfo->pageCount;  
           /*
           //pour aller chercher l'image
           if( isset($book->volumeInfo->imageLinks) ){  
               $infos['image'] = str_replace('&edge=curl', '', $book->volumeInfo->imageLinks->thumbnail);
           }  
            */

            $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
                or die('Error connection to DB');
            $query = "INSERT INTO books (bookCode,bookTitle,bookWriter,bookLanguage,bookPublicationDate,bookNbPage,sellerID,sellerName) 
                VALUES ('$isbn','$infos[titre]','$infos[auteur]','$infos[langue]','$infos[publication]','$infos[pages]','$userId','$userName')";
        
            mysqli_query($dbc, $query)
                or die('Error while querying');

            // pour tester
           //print_r($infos);  
        }  
        else{  
           echo 'Livre introuvable';  
        }  



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
                    (bookCode,bookTitle,bookWriter,bookLanguage,bookPublicationDate,bookNbPage,sellerID,sellerName) 
                    <label for="menulabel">Code of the Book:</label> 
                    <input type="text" name="bookCode" value="" id="menulabel" />
                </li>
                <li>
                    <label for="menulabel">Title of the book:</label> 
                    <input type="text" name="bookTitle" value="" id="menulabel" />
                </li>
                <li>
                    <label for="menulabel">Writer of the Book:</label> 
                    <input type="text" name="bookWriter" value="" id="menulabel" />
                </li>
                <li>
                    <label for="menulabel">Language of the Book:</label> 
                    <input type="text" name="bookLanguage" value="" id="menulabel" />
                </li>
                <li>
                    <label for="menulabel">Price of the Book:</label> 
                    <input type="text" name="bookPrice" value="" id="menulabel" />
                </li>
                <li>
                    <label for="menulabel">Price of the Book:</label> 
                    <input type="text" name="bookPrice" value="" id="menulabel" />
                </li>
                <li>
                    <label for="menulabel">Price of the Book:</label> 
                    <input type="text" name="bookPrice" value="" id="menulabel" />
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

