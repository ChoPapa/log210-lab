<?php 
    require_once ("Includes/simplecms-config.php"); 
    require_once  ("Includes/connectDB.php");
    include("Includes/header.php"); 

?>
<div id="main">
    <h2>Register an account</h2>
        <form action="register.php" method="post">
            <fieldset>
                <legend>Register a type of account</legend>
                <ol>

                    <FORM name ="form1" method ="post" action ="radioButton.php">

                    <label for="accountType">Select a type of account to create:</label>

                    <Input type = 'Radio' Name ='accoutType' value= 'gestionnaire'
                    <?PHP print $gestionnaire_status; ?>
                    >Gestionnaire

                    <Input type = 'Radio' Name ='accoutType' value= 'student' 
                    <?PHP print $student_status; ?>
                    >Student

                    </FORM>

                </ol>
                <input type="submit" name="submitAccoutType" value="Register Accout" />
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