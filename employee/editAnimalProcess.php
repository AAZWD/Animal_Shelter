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
                <li><a href="adoptable.php">Animals</a></li>
                <li><a href="editApplications.php">Applications</a></li>
                <li><a href="editAnimals.php">Animal Profiles</a></li>
                <?php
                $email =  $_SESSION['email'];
                $sql1 = "SELECT EmpID FROM employees WHERE Email = '$email'";
                $result1 = mysqli_query($conn,$sql1);
                $row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC);
                if($row1['EmpID'] == 1) {
                    echo "<li><a href='staff.php'>Staff</a></li>";
                }
                ?> 
            </ul>
        </nav>
        <main>
        <?php

            //Input values
            
            $ID=$_GET['id'];
            $Name=$_GET['Name'];
            $Sex=$_GET['Sex'];
            $Age=$_GET['Age'];
            $Breed=$_GET['Breed'];
            $Species=$_GET['Species'];
            $Weight=$_GET['Weight'];
            $Housebroken=$_GET['Housebroken'];
            $Temperament=$_GET['Temperament'];
            $Intake_Date=$_GET['Intake_Date'];
            $Intake_Condition=$_GET['Intake_Condition'];
            $Intake_Location=$_GET['Intake_Location'];
            
            
            //Update Animal
            $sql = "UPDATE animals SET Name = '$Name', Sex = IF('$Sex'='',NULL,'$Sex'), Age = IF('$Age'='',NULL,'$Age'), Breed = IF('$Breed'='',NULL,'$Breed'), Species = '$Species', Weight = IF('$Weight'='',NULL,'$Weight'),
            Housebroken = '$Housebroken', Temperament = IF('$Temperament'='',NULL,'$Temperament'), Intake_Date = '$Intake_Date', Intake_Condition = '$Intake_Condition', 
            Intake_Location = '$Intake_Location' WHERE AnimalID='$ID'";
            $result = mysqli_query($conn,$sql);
            clearConnection($conn); 

            if($result){
               header('Location: editAnimals.php');                
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
    