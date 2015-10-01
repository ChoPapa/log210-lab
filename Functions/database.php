<?php
    require_once ("/Includes/simplecms-config.php");


    function AfficherTableau ($ChauffeurSeulement)
    {
        $dbc = mysqli_connect('alarmemobile.mattlachance.com', 'alarmeclient', 'ele400', 'AlarmeDB')
            or die('Error connection to DB');
        if($ChauffeurSeulement == ALL)
        {
            $query = 'SELECT * FROM Modules';
        }
        else
        {
            $query = 'SELECT * FROM Modules WHERE Chauffeur=' . "\"" . $_SESSION['username'] . "\"";

        }
        
        $result = mysqli_query($dbc, $query)
            or die('Error while querying');
        echo '<p><table>
                    <tr>
                        <th>ModuleID</th>
                        <th>Addresse</th>		
                        <th>Connected</th>
                        <th>Working</th>
                        <th>Chauffeur</th>
                        <th>ModuleType</th>
                        <th>T1</th>
                        <th>T2</th>
                        <th>T3</th>
                        <th>T4</th>
                        <th>T5</th>
                        <th>T6</th>
                        <th>T7</th>
                        <th>T8</th>
                        <th>T9</th>
                        <th>T10</th>
                        <th>E1</th>
                        <th>E2</th>
                    </tr>';
        while ($row = mysqli_fetch_array($result))
        {
            echo '<tr>';
                        if($_SESSION['username'] == admin)
                        {
                            echo '<td><input type="submit" name="SubmitModuleToModifie" value=', $row['ModuleID'], ' /></td>';
                        }
                        else
                        {
                            echo '<td>', $row['ModuleID'], '</td>';
                        }
                        //echo '<td><a type="submit" name="SubmitModuleToModifie" href="ModifierModule.php">', $row['ModuleID'], '</a></td>
                        
                        echo '<td>', $row['Addresse'], '</td>
                        <td>', $row['Connected'], '</td>
                        <td>', $row['Working'], '</td>
                        <td>', $row['Chauffeur'], '</td>';
                        

                        $ModuleType = $row['ModuleType'];
                        $dbc2 = mysqli_connect('alarmemobile.mattlachance.com', 'alarmeclient', 'ele400', 'AlarmeDB')
                            or die('Error connection to DB');
                        $query2 = 'SELECT ModuleTypeName,Tmax,Tup,EntrerMAup, EntrerMAmax FROM ModuleType WHERE ModuleTypeID=' . $ModuleType;
                        $result2 = mysqli_query($dbc2, $query2)
                            or die('Error while querying');
                        while ($row2 = mysqli_fetch_array($result2))
                        {
                            $ModuleTypeName = $row2['ModuleTypeName'];
                            $Tup = $row2['Tup'];
                            $Tmax = $row2['Tmax'];
                            $EntrerMAup = $row2['EntrerMAup'];
                            $EntrerMAmax = $row2['EntrerMAmax'];
                        }                 
                        echo '<td>', $row['ModuleType'] .' - '. $ModuleTypeName, '</td>';
                        Tempeture($row['T1'], $Tup, $Tmax);
                        Tempeture($row['T2'], $Tup, $Tmax);
                        Tempeture($row['T3'], $Tup, $Tmax);
                        Tempeture($row['T4'], $Tup, $Tmax);
                        Tempeture($row['T5'], $Tup, $Tmax);
                        Tempeture($row['T6'], $Tup, $Tmax);
                        Tempeture($row['T7'], $Tup, $Tmax);
                        Tempeture($row['T8'], $Tup, $Tmax);
                        Tempeture($row['T9'], $Tup, $Tmax);
                        Tempeture($row['T10'], $Tup, $Tmax);
                        Tempeture($row['E1'], $EntrerMAup, $EntrerMAmax);
                        Tempeture($row['E2'], $EntrerMAup, $EntrerMAmax);
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