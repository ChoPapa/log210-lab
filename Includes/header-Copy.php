<?php
    require_once ("Includes/session.php"); 
 ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Alarme Mobile</title>
        <link href="/Styles/Site.css" rel="stylesheet" type="text/css" />
        <meta name="viewport" content="width=device-width, initial-scale=1"> 


    </head>
    <body>
        <div class="outer-wrapper">
        <header>
            <div class="content-wrapper">
                <div class="float-left">
                    <p class="site-title"><a href="/index.php">Alarme Mobile</a></p>
                </div>
                <div class="float-right">
                    <section id="login">
                        <ul id="login">
                        <?php
                        if (logged_on())
                        {
                            if (is_admin())
                            {
                                echo '<li><a href="/AddModule.php">Add</a></li>' . "\n";
                                echo '<li><a href="/ModifierModule.php">Edit</a></li>' . "\n";
                                echo '<li><a href="/deletepage.php">Delete</a></li>' . "\n";
                                echo '<li><a href="/register.php">Créer un chauffeur</a></li>' . "\n";
                            }
                            echo '<li><a href="/logoff.php">Sign out</a></li>' . "\n";
                        }
                        else
                        {
                            echo '<li><a href="/logon.php">Login</a></li>' . "\n";  
                        }
                        ?>
                        </ul>
                        <?php if (logged_on()) {
                            echo "<div class=\"welcomeMessage\">Welcome, <strong>{$_SESSION['username']}</strong></div>\n";
                        } ?>
                    </section>
                </div>

                <div class="clear-fix"></div>
            </div>

                <section class="navigation" data-role="navbar">
                    <nav>
                        <ul id="menu">
                            <!--
                            <li><a href="/index.php">Détail des modules</a></li>
                            <li><a href="/index.php">Ajouter un module</a></li>
                            <li><a href="/index.php">Modifier un module</a></li>
                            -->
                            
                            <?php
                                if (logged_on())
                                {
                                    
                                    echo '<li><a href="/detaildesmodules.php">Détail des modules</a></li>' . "\n";
                                    if (is_admin())
                                    {
                                        echo '<li><a href="/AddModule.php">Ajouter un module</a></li>' . "\n";
                                        echo '<li><a href="/ModifierModule.php">Modifier un module</a></li>' . "\n";
                                    }
                                    else
                                    {
                                        echo '<li><a href="/ModulesChauffeur.php">Détail des modules du chauffeur</a></li>' . "\n";
                                    }
                                }
                                else
                                {
                                    echo '<li><a href="/logon.php">Welcome, Please Log In</a></li>' . "\n";
                                }
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
