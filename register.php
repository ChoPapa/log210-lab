<?php 
    require_once ("Includes/simplecms-config.php"); 
    require_once  ("Includes/connectDB.php");
    include("Includes/header.php"); 

    if (isset($_POST['submit']))
    {    
        $username = $_POST['username'];
        $phoneNumber = $_POST['phoneNumber'];
        $password = $_POST['password'];
        
        $coopAdress = $_POST['coop'];
        $_SESSION['myCoopName'] = $coopAdress;

        if(userIsUnique($username,$phoneNumber))
        {
            $query = "INSERT INTO users (username, password, phoneNumber, coopAdress) VALUES (?, SHA(?), ?, ?)";
            $statement = $databaseConnection->prepare($query);
            $statement->bind_param('ssss', $username, $password, $phoneNumber, $coopAdress);
            $statement->execute();
            $statement->store_result();
            $creationWasSuccessful = $statement->affected_rows == 1 ? true : false;
            if ($creationWasSuccessful)
            {
                $userId = $statement->insert_id;
                $addToUserRoleQuery = "INSERT INTO users_in_roles (user_id, role_id) VALUES (?, ?)";
                $addUserToUserRoleStatement = $databaseConnection->prepare($addToUserRoleQuery);


                if ($_SESSION["accoutType"] == 'gestionnaire')
                {
                    $userRoleId = 2;
                    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
                        or die('Error connection to DB');
                    $query = "INSERT INTO coop (coopName) VALUES ('$coopAdress')";
        
                    mysqli_query($dbc, $query)
                        or die('Error while querying');
                }
                else if ($_SESSION["accoutType"] == 'student')
                {
                    $userRoleId = 3;
                }
            
                $addUserToUserRoleStatement->bind_param('dd', $userId, $userRoleId);
                $addUserToUserRoleStatement->execute();
                $addUserToUserRoleStatement->close();

                $_SESSION['userid'] = $userId;
                $_SESSION['username'] = $username;
                header ("Location: index.php");
            }
            else
            {
                echo "Failed registration";
            }
        }
    }
    elseif(isset($_POST['submitAccoutType']))
    {
        $accoutType = $_POST['accoutType'];
        $_SESSION["accoutType"] = $accoutType;
    }
?>
<div id="main">
    <h2>Register an <?php print $accoutType ?> account</h2>
        <form action="register.php" method="post">
            <fieldset>
                <legend>Register an <?php print $accoutType ?> account</legend>
                <ol>
                    <li>
                        <label for="username">Username:</label>
                        <input type="text" name="username" value="" id="username" />
                    </li>
                    <li>
                        <label for="phoneNumber">Phone Number:</label> 
                        <input type="text" name="phoneNumber" value="" id="phoneNumber" />
                    </li>
                    <li>
                        <label for="password">Password:</label>
                        <input type="password" name="password" value="" id="password" />
                    </li>
                    <!--
                    <FORM name ="form1" method ="post" action ="radioButton.php">

                    <label for="accountType">Select a type of account to create:</label>

                    <Input type = 'Radio' Name ='accoutType' value= 'gestionnaire'
                    <?PHP print $gestionnaire_status; ?>
                    >Gestionnaire

                    <Input type = 'Radio' Name ='accoutType' value= 'student' 
                    <?PHP print $student_status; ?>
                    >Student
                        -->
                    <?PHP
                        
                        if($accoutType == 'gestionnaire')
                        {
                            ?>
                            <li>
                                <label for="coop">Cooperation:</label> 
                                <input type="text" name="coop" value="" id="coop" />
                            </li>
                            <?PHP
                        }
                        elseif($accoutType == 'student')
                        {
                            ?>
                            <li>
                                <label for="coop">Cooperation:</label>
                                <select id="pageId" name="coop">
                                <option value="0">--Choose Coop--</option>
                                <?php
                                    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
                                        or die('Error connection to DB');
                                    $query = 'SELECT * FROM coop';
                                    $result = mysqli_query($dbc, $query)
                                        or die('Error while querying');

                                    while ($row = mysqli_fetch_array($result))
                                    {
                                        $coopName = $row['coopName'];
                                        echo "<option value=\"$coopName\">$coopName</option>\n";
                                    }
                                ?>
                                </select>
                            </li>
                            <?PHP
                        }
                    ?>


                    </FORM>



                </ol>
                <input type="submit" name="submit" value="Submit" />
                <p>
                    <a href="index.php">Cancel</a>
                </p>
            </fieldset>
        </form>
     </div>
</div> <!-- End of outer-wrapper which opens in header.php -->
<?php
    include ("Includes/footer.php");
?>