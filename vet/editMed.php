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
        <title>PAS | Medical History</title>
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
                <li><a href="adoptable.php">Adoptable Animals</a></li>
                <li><a href="editMed.php">Medical History</a></li>
            </ul>
        </nav>
        <main>
            <div class="animalContainer">
            <?php
                if (isset($_GET['submit'])) { 

                    $AID = $_GET['AnID'];                                
                    $sql1 = "SELECT Sex FROM Animals WHERE AnimalID='$AID'";
                    $result1 = mysqli_query($conn,$sql1);
                    $row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC);
                    clearConnection($conn); 
                    $sex = $row1['Sex'];

                    if($_GET['Vaccinated'] != 'Y' && $_GET['Vaccinated'] != 'N' && $_GET['Vaccinated'] != ''){
                        echo "<strong>Double check Vaccinated value. It can only be Y or N or NULL.</strong<br><br><br>";
                    }elseif($_GET['Declawed'] != 'Y' && $_GET['Declawed'] != 'N' && $_GET['Vaccinated'] != ''){
                        echo "<strong>Double check Declawed value. It can only be Y or N or NULL.</strong<br><br><br>";
                    }elseif($_GET['Tagged'] != 'Y' && $_GET['Tagged'] != 'N' && $_GET['Vaccinated'] != ''){
                        echo "<strong>Double check Tagged value. It can only be Y or N or NULL.</strong<br><br><br>";
                    }elseif($_GET['Pregnant'] != 'Y' && $_GET['Pregnant'] != 'N' && $_GET['Vaccinated'] != ''){
                        echo "<strong>Double check Pregnant value. It can only be Y or N or NULL.</strong<br><br><br>";
                    }elseif($_GET['Pregnant'] == 'Y' && $sex == 'M'){
                        echo"<strong>Double check pregnancy value. This animal is male.</strong<br><br><br>";
                    }elseif($_GET['Tagged'] == 'Y' && $_GET['Tag_ID'] == NULL ){
                        echo"<strong>Tag ID is missing.</strong<br><br><br>";
                    }else{
                        header('Location:editMedProcess.php?id='.$_GET['AnID'].'&VID='.$_GET['VID'].'&Major_Illness='.$_GET['Major_Illness'].'&Last_Checkup='.$_GET['Last_Checkup'].'&Vaccinated='.$_GET['Vaccinated'].'&Declawed='.$_GET['Declawed'].'&Special_Needs='.$_GET['Special_Needs'].'&Pregnant='.$_GET['Pregnant'].'&Offspring='.$_GET['Offspring'].'&Tagged='.$_GET['Tagged'].'&Tag_ID='.$_GET['Tag_ID'].'&Parasites='.$_GET['Parasites'].'&Spay_Neut='.$_GET['Spay_Neut'].'');
                    }
                } 
                //Display Animals to edit
                $result = $conn->query("call GetAnimalAndMedInfo()");
                clearConnection($conn);            
                while ($row = mysqli_fetch_assoc($result)){
                    echo "
                        <button class='animalClick'>" . $row['AnimalID'] ."</button>
                        <form class='editAnimal'";
                            if(!empty($_GET['id']) && ($_GET['id'] == $row['AnimalID'])){
                                echo " id='" .$_GET['id']. "'";
                            }
                            echo " action='#' method= 'get'>
    
                                <input class='hideID' type='number' id='AnID' name='AnID' value='". $row['AnimalID'] . "'>                            
                            
                                <label for='VID'>VID: </label>
                                <input class='input' type='number' id='VID' name='VID' value='". $row['VID'] . "'>
                
                                <label for='Last_Checkup'> Last Checkup: </label>
                                <input class='input' type='text' id='Last_Checkup' name='Last_Checkup' value='" . $row['Last_Checkup'] . "'><br>
                                    
                                <label for='Vaccinated'>Vaccinated(Y/N): </label>
                                <input class='input' type='text' id='Vaccinated' maxlength=1 name='Vaccinated' value='". $row['Vaccinated'] . "'>
                
                                <label for='Declawed'> Declawed(Y/N): </label>
                                <input class='input' type='text' id='Declawed' maxlength=1 name='Declawed' value='" . $row['Declawed'] . "'><br>

                                <label for='Special_Needs'>Special_Needs: </label>
                                <input class='input' type='text' id='Special_Needs' name='Special_Needs' value='". $row['Special_Needs'] . "'>
                
                                <label for='Pregnant'> Pregnant(Y/N): </label>
                                <input class='input' type='text' id='Pregnant' maxlength=1 name='Pregnant' value='" . $row['Pregnant'] . "'><br>

                                <label for='Offspring'>Offspring: </label>
                                <input class='input' type='number' id='Offspring' name='Offspring' value='". $row['Offspring'] . "'>
                
                                <label for='Tagged'> Tagged(Y/N): </label>
                                <input class='input' type='text' id='Tagged' maxlength=1 name='Tagged' value='" . $row['Tagged'] . "'><br>

                                <label for='Tag_ID'>Tag_ID: </label>
                                <input class='input' type='number' id='Tag_ID' name='Tag_ID' value='". $row['Tag_ID'] . "'>
                
                                <label for='Parasites'> Parasites: </label>
                                <input class='input' type='text' id='Parasites' name='Parasites' value='" . $row['Parasites'] . "'><br>

                                <label for='Major_Illness'>Major Illness: </label>
                                <input class='input' type='text' id='Major_Illness' name='Major_Illness' value='". $row['Major_Illness'] . "'><br>
                                
                                <label for='Spay_Neut'>Spayed or Neutered(Y/N): </label>
                                <input class='input' type='text' id='Spay_Neut' maxlength=1 name='Spay_Neut' value='". $row['Spay_Neut'] . "'><br>
                
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