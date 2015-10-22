<?php 
    require_once ("Includes/simplecms-config.php"); 
    require_once  ("Includes/connectDB.php");
    include("Includes/header.php"); 

    if (isset($_POST['submit'])){
        $username = $_POST['username'];
        $phoneNumber = $_POST['phoneNumber'];
        $password = $_POST['password'];

        if(userIsUnique($username,$phoneNumber)){

            //$query = "INSERT INTO users (username, password) VALUES (?, SHA(?))";
            $query = "INSERT INTO users (username, password, phoneNumber) VALUES (?, SHA(?), $phoneNumber)";

            $statement = $databaseConnection->prepare($query);
            //$statement->bind_param('ss', $username, $password, $phoneNumber);
            $statement->bind_param('ss', $username, $password);
            $statement->execute();
            $statement->store_result();

            $creationWasSuccessful = $statement->affected_rows == 1 ? true : false;
            if ($creationWasSuccessful)
            {
                $userId = $statement->insert_id;

                $addToUserRoleQuery = "INSERT INTO users_in_roles (user_id, role_id) VALUES (?, ?)";
                $addUserToUserRoleStatement = $databaseConnection->prepare($addToUserRoleQuery);

                // TODO: Extract magic number for the 'user' role ID.
                //$userRoleId = 2;
            
                $selected_radio = $_POST['accoutType'];
            
                if ($selected_radio == 'gestionnaire') {

                    $userRoleId = 2;

                }
                else if ($selected_radio == 'student') {

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
    }
?>
<div id="main">
    <h2>Register an <?php print $accoutType ?> account</h2>
        <form action="register.php" method="post">
            <fieldset>
                <legend>Register an account</legend>
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

                    <FORM name ="form1" method ="post" action ="radioButton.php">

                    <label for="accountType">Select a type of account to create:</label>

                    <Input type = 'Radio' Name ='accoutType' value= 'gestionnaire'
                    <?PHP print $gestionnaire_status; ?>
                    >Gestionnaire

                    <Input type = 'Radio' Name ='accoutType' value= 'student' 
                    <?PHP print $student_status; ?>
                    >Student

                    <?PHP
                        echo "affciher coop";
                        if($accoutType == 'gestionnaire')
                        {
                            echo "afficher coop";
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