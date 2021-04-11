<?php
    /*Set up*/
    $servername = "localhost";
    $username = "animal";
    $password = "animal";
    $dbname = "partyanimal";
    // Create connections
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    //clear procedure
    function clearConnection($mysql){
        while($mysql->more_results()){
        $mysql->next_result();
        $mysql->use_result();
        }
    }
    //Start session
    session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="icon" href="Icon.ico">
        <link rel="stylesheet" href="CSS.css">
        <title>PAS</title>
    </head>
    <body>
       <center><img src="LOGO.png" alt="logo"></center>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="adoptable.php">Adoptable Animals</a></li>
                <li><a href="editMed.php">Medical History</a></li>
            </ul>
        </nav>
        <main>
        <?php

            //Input values
            
            $ID=$_GET['id'];
            $VID=$_GET['VID'];
            $Last_Checkup=$_GET['Last_Checkup'];
            $Vaccinated=$_GET['Vaccinated'];
            $Declawed=$_GET['Declawed'];
            $Special_Needs=$_GET['Special_Needs'];
            $Pregnant=$_GET['Pregnant'];
            $Offspring=$_GET['Offspring'];
            $Tagged=$_GET['Tagged'];
            $Tag_ID=$_GET['Tag_ID'];
            $Parasites=$_GET['Parasites'];
            $Major_Illness=$_GET['Major_Illness'];
            $Spay_Neut=$_GET['Spay_Neut'];
            
           
            
            //Update Animal
            $sql = "UPDATE medical_record SET VID = '$VID', Last_Checkup = '$Last_Checkup', Vaccinated = '$Vaccinated', Declawed = '$Declawed', 
            Special_Needs = IF('$Special_Needs'='',NULL,'$Special_Needs'), Pregnant = '$Pregnant', Offspring = '$Offspring', Tagged = '$Tagged', Tag_ID = '$Tag_ID', 
            Parasites = IF('$Parasites'='',NULL,'$Parasites') , Major_Illness = IF('$Major_Illness'='',NULL,'$Major_Illness'), Spay_Neut = '$Spay_Neut' WHERE Animal='$ID'";
            $result = mysqli_query($conn,$sql);
            clearConnection($conn); 

            if($result){
               header('Location: editMed.php');                
            }else{
                echo "error";
                echo $VID;
            }
        ?>
        </main>
        <footer>
           <p>Party Animal Shelter &copy; | </p>
            <a href="references.html">References</a>
        </footer>
    </body>
</html>
    