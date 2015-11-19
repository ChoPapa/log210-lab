<?php require_once ("Includes/session.php"); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Bibliotheque LOG210</title>
        <link href="/Styles/Site.css" rel="stylesheet" type="text/css" />
        <meta name="viewport" content="width=device-width, initial-scale=1"> 


    </head>
    <body>
        <div class="outer-wrapper">
        <header>
            <div class="content-wrapper">
                <div class="float-left">
                    <p class="site-title"><a href="/index.php">Bibliotheque LOG210</a></p>
                </div>
                <div class="float-right">
                    <section id="login">
                        <ul id="login">
                        <?php
                        if (logged_on())
                        {
                            //<a href="MyCart.php">My Cart</a>
                            echo '<li><a href="MyCart.php">My Cart</a></li>' . "\n";
                            echo '<li><a href="/logoff.php">Sign out</a></li>' . "\n";
                            if (is_admin())
                            {
                                echo '<li><a href="/addpage.php">Add</a></li>' . "\n";
                                echo '<li><a href="/selectpagetoedit.php">Edit</a></li>' . "\n";
                                echo '<li><a href="/deletepage.php">Delete</a></li>' . "\n";
                            }
                        }
                        else
                        {
                            echo '<li><a href="/logon.php">Login</a></li>' . "\n";
                            echo '<li><a href="/registerType.php">Register</a></li>' . "\n";
                        }
                        ?>
                        </ul>
                        <?php if (logged_on()) {

                            if(is_gestionnaire()){
                                echo "<div class=\"welcomeMessage\">Welcome gestionnaire, <strong>{$_SESSION['username']}</strong></div>\n";
                            }
                            else if(is_student()){
                                echo "<div class=\"welcomeMessage\">Welcome student, <strong>{$_SESSION['username']}</strong></div>\n";
                            }
                            else{
                                echo "<div class=\"welcomeMessage\">Welcome boss, <strong>{$_SESSION['username']}</strong></div>\n";
                            }
                        } ?>
                    </section>
                </div>

                <div class="clear-fix"></div>
            </div>

                <section class="navigation" data-role="navbar">
                    <nav>
                        <ul id="menu">
                            <li><a href="/index.php">Home</a></li>
                            <?php 
                                if(is_student())
                                {
                                    echo '<li><a href="/AddBook.php">Add Book</a></li>';
                                    echo '<li><a href="/MyBooks.php">My Books</a></li>';
                                }
                                elseif(is_gestionnaire())
                                {
                                    echo '<li><a href="/ValidationBook.php">Validate Book</a></li>';
                                    echo '<li><a href="/DeliverBook.php">Deliver Book</a></li>';
                                    echo '<li><a href="/ReceiveBook.php">Receive Book</a></li>';
                                }
                            ?>
                            <li><a href="/ShopBooks.php">Shop Books</a></li>
                            <?php
                                $statement = $databaseConnection->prepare("SELECT id, menulabel FROM pages");
                                $statement->execute();

                                if($statement->error)
                                {
                                    die("Database query failed: " . $statement->error);
                                }

                                $statement->bind_result($id, $menulabel);
                                while($statement->fetch())
                                {
                                    echo "<li><a href=\"/page.php?pageid=$id\">$menulabel</a></li>\n";
                                }
                            ?>
                        </ul>
                    </nav>
            </section>
        </header>
