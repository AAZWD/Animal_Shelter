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
                <li><a href="about.html">About Us</a></li>
                <li><a href="adoptable.php">Adoptable Animals</a></li>
                <li><a href="applicationHistory.php">Application History</a></li>
                <li><a href="contact.html">Contact Us</a></li>
                <li><a href="successStory.php">Success Stories</a></li>
            </ul>
        </nav>
        <main>
        <?php

            //Get AppID
            $AppID = $_SESSION['appid'];
           
            //Input values
            $Name=$_GET['Name'];
            $Sex=$_GET['Sex'];
            $Age=$_GET['Age'];
            $Breed=$_GET['Breed'];
            $Species=$_GET['Species'];
            $State=$_GET['Status'];
            $COD=$_GET['Cause_Of_Death'];
            $SON=$_GET['Spay_Or_Neutered'];
            
            //Update Application
            $sql = "INSERT INTO pet_ownership_history (AppID, Name, Sex, Age, Breed, Species, State, Cause_Of_Death, Spay_Or_Neutered) 
            VALUES ('$AppID', '$Name', '$Sex', '$Age', '$Breed', '$Species', '$State', '$COD', '$SON')";
            $result = mysqli_query($conn,$sql);
            clearConnection($conn); 

            if($result){
                echo "<br><br><strong>To add add the details of another animal you have owned <a href='applicationForm2.php'>click here</a></strong><br><br>";
               // header('Location: applicationHistory.php');                
            }else{
                echo "error";
            }
        ?>
        </main>
        <footer>
           <p>Party Animal Shelter &copy; | </p>
            <a href="references.html">References</a>
        </footer>
    </body>
</html>
    