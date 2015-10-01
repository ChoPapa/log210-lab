<?php
    /*
    $ModuleTypeNameCreated = "NoModuleCreated";
    if (isset($_POST['CreateModuleType']))
    {
        header('Location: CreateModuleType.php');
    }
    elseif (isset($_POST['SubmitAddModule']))
    {
        $Addresse = $_POST["AddresseBox"];
        $Chauffeur = $_POST["ChauffeurBox"];
        $ModuleType = $_POST["ModuleTypeBox"];
        $dbc = mysqli_connect('alarmemobile.mattlachance.com', 'alarmeclient', 'ele400', 'AlarmeDB')
            or die('Error connection to DB');
        
        $query = "INSERT INTO Modules(Addresse,Chauffeur,ModuleType) VALUES ('$Addresse','$Chauffeur','$ModuleType')";
        mysqli_query($dbc, $query)
            or die('Error while querying');

        header('Location: detaildesmodules.php');
    }
    elseif (isset($_POST['SubmitCreateModuleType']))
    {
        //$ModuleTypeName = $_POST["ModuleTypeNameBox"];
        $ModuleTypeNameCreated = $_POST["ModuleTypeNameBox"];
        $Tup = $_POST["ThautBox"];
        $Tmax = $_POST["TmaxBox"];
        $EntrerMAup = $_POST["EhautBox"];
        $EntrerMAmax = $_POST["EmaxBox"];
        $dbc = mysqli_connect('alarmemobile.mattlachance.com', 'alarmeclient', 'ele400', 'AlarmeDB')
            or die('Error connection to DB');
        
        $query = "INSERT INTO ModuleType(ModuleTypeName,Tup,Tmax,EntrerMAup,EntrerMAmax) VALUES ('$ModuleTypeNameCreated','$Tup','$Tmax','$EntrerMAup','$EntrerMAmax')";
        mysqli_query($dbc, $query)
            or die('Error while querying');

        //header('Location: AddModule.php');
    }
    */
     
    require_once ("Includes/session.php");
    require_once ("Includes/simplecms-config.php"); 
    require_once ("Includes/connectDB.php");
    include("Includes/header.php"); 
    //confirm_is_admin();
?>
<div id="main">
    <h2>Ajouter un livre</h2>
        <!--<form action="detaildesmodules.php" method="post">-->
        <form action="AddModule.php" method="post">
            <fieldset>
            <legend>Add Page</legend>
            <ol>
                <li>
                    <label for="menulabel">Nom du livre:</label> 
                    <input type="text" name="AddresseBox" value="" id="menulabel" />
                </li>
                <li>
                    <label for="menulabel">Prix du livre:</label> 
                    <input type="text" name="ChauffeurBox" value="" id="menulabel" />
                </li>
            </ol>
                <form action="Ajouter.php" method="get">
                    <input type="submit" name="SubmitAddModule">
                </form>
            <p>
                <a href="detaildesmodules.php">Cancel</a>
            </p>
        </fieldset>
    </form>
</div>
</div> <!-- End of outer-wrapper which opens in header.php -->
<?php include ("Includes/footer.php"); ?>

