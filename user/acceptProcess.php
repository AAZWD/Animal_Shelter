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
            </ul>
        </nav>
        <main>
        <?php

            //Input values
            $AppID = $_GET['appid'];           
            
            //Update Application
            $sql = "UPDATE applications SET Application_status = 'Accepted' WHERE AppID='$AppID'";
            $result = mysqli_query($conn,$sql);
            clearConnection($conn); 

            $sql2= "SELECT AnimalID FROM created_for WHERE AnimalID='$AppID'";
            $result2 = mysqli_query($conn,$sql2);
            clearConnection($conn);
            $row2 = mysqli_fetch_array($result2,MYSQLI_ASSOC);
            
            $AnID=$row2['AnimalID'];
            $sql3 = "UPDATE animals SET Application_status = 'Adopted' WHERE AnimalID='$AnID'";
            $result3 = mysqli_query($conn,$sql3);
            clearConnection($conn); 

            if($result && $result2 && $result3){
                header('Location: editApplication.php');                
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
    