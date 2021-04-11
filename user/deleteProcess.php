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

            //Input values
            $email = $_SESSION['email']; 
            $AID = $_GET['anid'];           
            
            //Update Application
            $sql = "DELETE FROM Applications WHERE Email= '$email' AND Application_Status='Pending'";
            $result = mysqli_query($conn,$sql);
            clearConnection($conn); 

            $sql2 = "SELECT * FROM applications LEFT JOIN created_for ON created_for.AppID=applications.AppID WHERE applications.Application_Status='Pending' AND created_for.AnimalID='$AID'";
            $result2 = mysqli_query($conn,$sql2);
            clearConnection($conn); 
            if(mysqli_num_rows($result2) > 0){
                $sql3 = "UPDATE animals SET  Application_status = 'Pending' WHERE AnimalID='$AID'";
                $result3 = mysqli_query($conn,$sql3);
                clearConnection($conn); 
            }elseif(mysqli_num_rows($result2) == 0){
                $sql4 = "UPDATE animals SET  Application_status = 'No Applicants' WHERE AnimalID='$AID'";
                $result4 = mysqli_query($conn,$sql4);
                clearConnection($conn); 
            }

            if($result && $result2 && ($result3 || $result4)){
                header('Location: applicationHistory.php');                
            }else{
                echo "error";
                echo $email; //check session email
            }
        ?>
        </main>
        <footer>
           <p>Party Animal Shelter &copy; | </p>
            <a href="references.html">References</a>
        </footer>
    </body>
</html>
    