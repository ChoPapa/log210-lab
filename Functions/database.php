<?php
    require_once ("/Includes/simplecms-config.php");


    function userIsUnique ($userName,$phoneNumber)
    {
        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
            or die('Error connection to DB');
        $query = "SELECT * FROM users WHERE username='$userName' OR phoneNumber='$phoneNumber'";

        $checkUserID = mysqli_query($dbc, $query)
            or die('Error while querying');

        if (mysqli_num_rows($checkUserID) > 0){
            echo "User or phone number already exist.";
            return FALSE;
        }
        else{
            return TRUE;
        }

        
    }

    function printBookTable ($userSelected)
    {
        echo '

            <li>
                <input type="text" name="search" value="" id="menulabel" />
                <input type="submit" name="submitSearch" value="Search" />
            </li>

        ';


        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
            or die('Error connection to DB');
        if($userSelected == ALL)
        {
            if (isset($_POST['submitSearch']))
            {
                $search = $_POST["search"];
                $query = "SELECT * FROM books WHERE (bookCode LIKE '%$search%') 
                                                OR (bookTitle LIKE '%$search%')
                                                OR (bookWriter LIKE '%$search%')
                                                OR (bookLanguage LIKE '%$search%')
                                                OR (bookPublicationDate LIKE '%$search%')
                                                OR (state LIKE '%$search%')
                                                OR (sellerName LIKE '%$search%')";
            }
            else
            {
                $query = 'SELECT * FROM books';
            }
        }
        else
        {
            if($_SESSION['url'] == "MyBooks")
            {
                $query = 'SELECT * FROM books WHERE sellerName=' . "\"" . $_SESSION['username'] . "\"";
            }
            elseif($_SESSION['url'] == "MyCart")
            {
                $query = 'SELECT * FROM books WHERE reservedBy=' . "\"" . $_SESSION['username'] . "\"";
            }
            elseif($_SESSION['url'] == "DeliverBook")
            {
                $query = 'SELECT * FROM books WHERE reservedBy IS NOT NULL';
            }

        }
        
        $result = mysqli_query($dbc, $query)
            or die('Error while querying');
        echo '<p><table>
                    <tr>
                        <th>Book Id</th>
                        <th>Code ISBN</th>
                        <th>Title</th>		
                        <th>Writer</th>
                        <th>Language</th>
                        <th>Publication Date</th>
                        <th>Page Amount</th>
                        <th>State</th>
                        <th>Valid</th>
                        <th>Price</th>
                        <th>Seller ID</th>
                        <th>Seller Name</th>
                        <th>Reserved By</th>
                        <th>Reserved Since</th>
                    </tr>';
        while ($row = mysqli_fetch_array($result))
        {

            if($row['state'] == 0){
                $printState = 'New';
            }
            elseif($row['state'] == 1){
                $printState = 'Almost New';
            }
            elseif($row['state'] == 2){
                $printState = 'Used';
            }
            elseif($row['state'] == 3){
                $printState = 'Very used';
            }

            echo '<tr>';

                echo '<td><input type="submit" name="SubmitBook" value=', $row['idBook'], ' /></td>';
                //echo '<td>', $row['idBook'], '</td>';
                //echo '<td><a type="submit" name="SubmitModuleToModifie" href="ModifierModule.php">', $row['ModuleID'], '</a></td>
                        
                echo '<td>', $row['bookCode'], '</td>
                <td>', $row['bookTitle'], '</td>
                <td>', $row['bookWriter'], '</td>
                <td>', $row['bookLanguage'], '</td>
                <td>', $row['bookPublicationDate'], '</td>
                <td>', $row['bookNbPage'], '</td>
                <td>', $printState, '</td>
                <td>', $row['valid'], '</td>
                <td>', $row['bookPrice'], '</td>
                <td>', $row['sellerID'], '</td>
                <td>', $row['sellerName'], '</td>
                <td>', $row['reservedBy'], '</td>
                <td>', $row['reservedSince'], '</td>';
               
            echo '</tr>';
        }//fin du while
        echo '</table></p>';

        ?>
            <style>
            table,th,td
            {
                border:1px solid black;
                border-collapse:collapse;
            }
            th,td
            {
                padding:5px;
            }
            </style>
        <?php   
    }




    function prep_DB_content ()
    {
        global $databaseConnection;
        $admin_role_id = 1;

        create_tables($databaseConnection);
        create_roles($databaseConnection, $admin_role_id);
        create_admin($databaseConnection, $admin_role_id);
    }

    function create_tables($databaseConnection)
    {
        $query_users = "CREATE TABLE IF NOT EXISTS users (id INT NOT NULL AUTO_INCREMENT, username VARCHAR(50), password CHAR(40), PRIMARY KEY (id))";
        $databaseConnection->query($query_users);

        $query_roles = "CREATE TABLE IF NOT EXISTS roles (id INT NOT NULL, name VARCHAR(50), PRIMARY KEY (id))";
        $databaseConnection->query($query_roles);

        $query_users_in_roles = "CREATE TABLE IF NOT EXISTS users_in_roles (id INT NOT NULL AUTO_INCREMENT, user_id INT NOT NULL, role_id INT NOT NULL, ";
        $query_users_in_roles .= " PRIMARY KEY (id), FOREIGN KEY (user_id) REFERENCES users(id), FOREIGN KEY (role_id) REFERENCES roles(id))";
        $databaseConnection->query($query_users_in_roles);

        $query_pages = "CREATE TABLE IF NOT EXISTS pages (id INT NOT NULL AUTO_INCREMENT, menulabel VARCHAR(50), content TEXT, PRIMARY KEY (id))";
        $databaseConnection->query($query_pages);
    }

    function create_roles($databaseConnection, $admin_role_id)
    {
        $query_check_roles_exist = "SELECT id FROM roles WHERE id <= 2";
        $statement_check_roles_exist = $databaseConnection->prepare($query_check_roles_exist);
        $statement_check_roles_exist->execute();
        $statement_check_roles_exist->store_result();
        if ($statement_check_roles_exist->num_rows == 0)
        {
            $query_insert_roles = "INSERT INTO roles (id, name) VALUES ($admin_role_id, 'admin'), (2, 'user')";
            $statement_inser_roles = $databaseConnection->prepare($query_insert_roles);
            $statement_inser_roles->execute();
        }
    }

    function create_admin($databaseConnection, $admin_role_id)
    {
        // HACK: Storing config values in variables so that they aren't passed by reference later.
        $default_admin_username = DEFAULT_ADMIN_USERNAME;
        $default_admin_password = DEFAULT_ADMIN_PASSWORD;

        $query_check_admin_exists = "SELECT id FROM users WHERE username = ? LIMIT 1";
        $statement_check_admin_exists = $databaseConnection->prepare($query_check_admin_exists);
        $statement_check_admin_exists->bind_param('s', $default_admin_username);
        $statement_check_admin_exists->execute();
        $statement_check_admin_exists->store_result();
        if($statement_check_admin_exists->num_rows == 0)
        {
            $query_insert_admin = "INSERT INTO users (username, password) VALUES (?, SHA(?))";
            $statement_insert_admin = $databaseConnection->prepare($query_insert_admin);
            $statement_insert_admin->bind_param('ss', $default_admin_username, $default_admin_password);
            $statement_insert_admin->execute();
            $statement_insert_admin->store_result();

            $admin_user_id = $statement_insert_admin->insert_id;
            $query_add_admin_to_role = "INSERT INTO users_in_roles(user_id, role_id) VALUES (?, ?)";
            $statement_add_admin_to_role = $databaseConnection->prepare($query_add_admin_to_role);
            $statement_add_admin_to_role->bind_param('dd', $admin_user_id, $admin_role_id);
            $statement_add_admin_to_role->execute();
            $statement_add_admin_to_role->close();
        }
    }
?>