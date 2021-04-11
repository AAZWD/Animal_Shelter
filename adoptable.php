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
        <title>PAS | Adoptable Animals</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="CSS.css">
        <link rel="icon" href="Icon.ico">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
        <script src="Script.js" type="text/javascript"></script>                    
    </head>
    <style>
        
    </style>
    <body>
        <center><img src="LOGO.png" alt="logo"></center>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="about.html">About Us</a></li>
                <li><a href="adoptable.php">Adoptable Animals</a></li>
                <li><a href="contact.html">Contact Us</a></li>
                <li><a href="successStory.php">Success Stories</a></li>
            </ul>
        </nav>
        <main class=adoptable>
            <div class="details">
                <?php
                //Create Table
                $result = $conn->query("call GetAnimalAndMedInfo()");
                clearConnection($conn);            
                
                echo "<table id='animalTable'>";
                while ($row = mysqli_fetch_assoc($result)){
                    if($row['Application_Status'] != 'Adopted'){
                    echo "<tr>";
                        echo "<td><div><img src='images/animals/" . $row['AnimalID'] . ".jpg'></div></td>";
                        echo "<td>
                                    <span>
                                    <strong>ID: </strong>" . $row['AnimalID'] . 
                                    "  <strong>Name: </strong>" . $row['Name']. 
                                    "  <strong>Species: </strong>" . $row['Species']. 
                                    "  <strong>Breed: </strong>" . $row['Breed']. "
                                    </span><br>
                                    <span>
                                    <strong>Sex: </strong>" . $row['Sex']. 
                                    "  <strong>Age: </strong>" . $row['Age']. 
                                    "  <span class='vetEmp'><strong>Weight: </strong>" . $row['Weight']. "</span>
                                    </span><br>
                                    <span><strong>Application Status: </strong>" . $row['Application_Status']. "</span><br>
                                    <span>
                                    <strong>Housebroken: </strong>" . $row['Housebroken']. 
                                    "  <strong>Temperament: </strong>" . $row['Temperament']. "
                                    </span></br>
                                    <span>
                                    <strong>Intake Date: </strong>" . $row['Intake_Date'].
                                    "  <span class='vetEmp'><strong>Intake Condition: </strong>" . $row['Intake_Condition']. "</span>                                    
                                       <span class='vetEmp'><strong>Intake Location: </strong>" . $row['Intake_Location']. "</span>
                                    </span></br>";
                                    if (!empty($row['Animal'])){
                                        echo "<div class='med'>
                                            <button>Medical History</button>
                                            <span><strong>Vet ID: </strong>" . $row['VID']. 
                                            "  <strong>Last Checkup: </strong>" . $row['Last_Checkup']."</span></br>
                                            <span><strong>Vaccinated: </strong>" . $row['Vaccinated']. 
                                            "  <strong>Decalwed: </strong>" . $row['Declawed']. 
                                            "  <strong>Special Needs: </strong>"; 
                                            if (empty($row['Special_Needs'])){
                                                echo "none";
                                            }else{
                                                echo $row['Special_Needs'];
                                            } 
                                            echo "</span></br>
                                            <span><strong>Pregnant: </strong>" . $row['Pregnant']. 
                                            "  <strong>Offspring: </strong>" . $row['Offspring']. "</span></br>
                                            <span><strong>Taggged: </strong>" . $row['Tagged']. 
                                            "  <strong>Tag ID: </strong>";
                                            if (empty($row['Tag_ID'])){
                                                echo "none";
                                            }else{
                                                echo $row['Tag_ID'];
                                            } 
                                            echo "</span></br>
                                            <span><strong>Parasites: </strong>";
                                            if (empty($row['Parasites'])){
                                                echo "none";
                                            }else{
                                                echo $row['Parasites'];
                                            } 
                                            echo "  <strong>Major Illness: </strong>";
                                            if (empty($row['Major_Illness'])){
                                                echo "none";
                                            }else{
                                                echo $row['Major_Illness'];
                                            } 
                                            echo "  <strong>Spayed or Neutered: </strong>" . $row['Spay_Neut']. "</span>
                                        </div>";
                                    }
                            echo "</td>";
                    echo "</tr>";
                    }
                }
                echo "</table>";
                echo "<button class='click'>Show More</button>";
                ?>
            </div>
        </main>
        <footer>
            <p>Party Animal Shelter &copy; | </p>
            <a href="references.html">References</a>
        </footer>
    </body>
</html>