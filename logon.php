<?php 
    require_once ("Includes/session.php");
    require_once ("Includes/simplecms-config.php"); 
    require_once ("Includes/connectDB.php");
    include ("Includes/header.php");

    if (isset($_POST['submit']))
    {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $query = "SELECT id, username FROM users WHERE username = ? AND password = SHA(?) LIMIT 1";
        $statement = $databaseConnection->prepare($query);
        $statement->bind_param('ss', $username, $password);

        $statement->execute();
        $statement->store_result();

        if ($statement->num_rows == 1)
        {
            $statement->bind_result($_SESSION['userid'], $_SESSION['username']);
            $statement->fetch();


            //bind coop name to session user
            $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
                or die('Error connection to DB');
            $query = 'SELECT * FROM users WHERE username=' . "\"" . $_SESSION['username'] . "\"";
            $result = mysqli_query($dbc, $query)
                or die('Error while querying');

            while ($row = mysqli_fetch_array($result))
            {
                $_SESSION['myCoopName'] = $row['coopAdress'];
            }

            header ("Location: index.php");
        }
        else
        {

            $query = "SELECT id, username FROM users WHERE phoneNumber = ? AND password = SHA(?) LIMIT 1";
            $statement = $databaseConnection->prepare($query);
            $statement->bind_param('ss', $username, $password);

            $statement->execute();
            $statement->store_result();

            if ($statement->num_rows == 1)
            {
                $statement->bind_result($_SESSION['userid'], $_SESSION['username']);
                $statement->fetch();

                //bind coop name to session user
                $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
                    or die('Error connection to DB');
                $query = 'SELECT * FROM users WHERE username=' . "\"" . $_SESSION['username'] . "\"";
                $result = mysqli_query($dbc, $query)
                    or die('Error while querying');

                while ($row = mysqli_fetch_array($result))
                {
                    $_SESSION['myCoopName'] = $row['coopAdress'];
                }

                header ("Location: index.php");
            }
            else
            {
                echo "Username/password combination is incorrect.";
            }
        }

    }
?>
<div id="main">
    <h2>Log on</h2>
        <form action="logon.php" method="post">
            <fieldset>
            <legend>Log on</legend>
            <ol>
                <li>
                    <label for="username">Username or Phone Number:</label> 
                    <input type="text" name="username" value="" id="username" />
                </li>
                <li>
                    <label for="password">Password:</label>
                    <input type="password" name="password" value="" id="password" />
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