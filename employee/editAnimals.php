<?php
    $servername = "localhost";
    $username = "animal";
    $password = "animal";
    $dbname = "partyanimal";
     // Create connection
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
        <title>PAS | Animal Profiles</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="CSS.css">
        <link rel="icon" href="Icon.ico">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
        <script src="Script.js" type="text/javascript"></script> 
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
            <div class="animalContainer">
            <?php
                if (isset($_GET['submit'])) { 
                    header('Location:editAnimalProcess.php?id='.$_GET['AnID'].'&Name='.$_GET['Name'].'&Sex='.$_GET['Sex'].'&Intake_Date='.$_GET['Intake_Date'].'&Intake_Condition='.$_GET['Intake_Condition'].'&Intake_Location='.$_GET['Intake_Location'].'&Temperament='.$_GET['Temperament'].'&Housebroken='.$_GET['Housebroken'].'&Weight='.$_GET['Weight'].'&Age='.$_GET['Age'].'&Breed='.$_GET['Breed'].'&Species='.$_GET['Species'].'');
                } 
                //Display Animals to edit
                $result = $conn->query("call GetAnimalInfo()");
                clearConnection($conn);  
                $count=0;          
                while ($row = mysqli_fetch_assoc($result)){
                    $count++;
                    echo "<button class='animalClick'>" . $row['AnimalID'] ."</button>"; 
                        echo "<form class='editAnimal'";
                            if(!empty($_GET['id']) && ($_GET['id'] == $row['AnimalID'])){
                                echo " id='" .$_GET['id']. "'";
                            }
                            echo " action='' method= 'get'>
                                
                                <input class='hideID' type='number' id='AnID' name='AnID' value='". $row['AnimalID'] . "'>                            

                                <label for='Name'>Name: </label>
                                <input class='input' type='text' id='Name' name='Name' required value='". $row['Name'] . "'>
                
                                <label for='Species'> Species: </label>
                                <input class='input' type='text' id='Species' name='Species' required value='" . $row['Species'] . "'><br>
                                    
                                <label for='Breed'>Breed: </label>
                                <input class='input' type='text' id='Breed' name='Breed' value='". $row['Breed'] . "'>
                
                                <label for='Sex'> Sex: </label>
                                <input class='input' type='text' id='Sex' maxlength=1 name='Sex' value='" . $row['Sex'] . "'><br>

                                <label for='Age'>Age: </label>
                                <input class='input' type='text' id='Age' name='Age' value='". $row['Age'] . "'>
                
                                <label for='Weight'> Weight: </label>
                                <input class='input' type='text' id='Weight' name='Weight' value='" . $row['Weight'] . "'><br>

                                <label for='Housebroken'>Housebroken(Y/N): </label>
                                <input class='input' type='text' id='Housebroken' maxlength=1 required name='Housebroken' value='". $row['Housebroken'] . "'>
                
                                <label for='Temperament'> Temperament: </label>
                                <input class='input' type='text' id='Temperament' name='Temperament' value='" . $row['Temperament'] . "'><br>

                                <label for='Intake_Date'>Intake Date: </label>
                                <input class='input' type='text' id='Intake_Date' name='Intake_Date' required value='". $row['Intake_Date'] . "'>
                
                                <label for='Intake_Condition'> Intake Condition: </label>
                                <input class='input' type='text' id='Intake_Condition' name='Intake_Condition' required value='" . $row['Intake_Condition'] . "'><br>

                                <label for='Intake_Location'>Intake Location: </label>
                                <input class='input' type='text' id='Intake_Location' name='Intake_Location' required value='". $row['Intake_Location'] . "'><br>
                
                                <button class='submitButtonMini' type='submit' name='submit'>Apply</button>
                            </form>";    
                }
            ?>
            </div>
        </main>
        <footer>
           <p>Party Animal Shelter &copy; | </p>
            <a href="references.html">References</a>
        </footer>
    </body>
</html>