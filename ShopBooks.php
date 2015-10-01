<?php
     require_once ("Includes/simplecms-config.php"); 
     require_once  ("Includes/connectDB.php");
     include("Includes/header.php");
?>

<form action="ModifierModuleChoisi.php" method="post">


<?php
    AfficherTableau(ALL);
?>

  

</div> <!-- End of outer-wrapper which opens in header.php -->
<?php 
    include ("Includes/footer.php");
 ?>