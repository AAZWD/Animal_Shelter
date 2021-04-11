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
        <title>PAS | Application</title>
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
                    if (isset($_GET['submit'])) { 
                        header('Location:ownershipProcess.php?id='.$_SESSION['appid'].'&Name='.$_GET['Name'].'&Sex='.$_GET['Sex'].'&Age='.$_GET['Age'].'&Breed='.$_GET['Breed'].'&Species='.$_GET['Species'].'&Status='.$_GET['Status'].'&Cause_Of_Death='.$_GET['Cause_Of_Death'].'&Spay_Or_Neutered='.$_GET['Spay_Or_Neutered'].'');
                    }
               ?>
            <div class="appForm">
                <form class="histContent" action="" method= "get">
                    <h2 class="appTitle">Ownership History</h2>
                    
                    <?php
                        echo "<input class='hideID' name='id' value='".$_SESSION['appid']."'>"
                    ?>
                  
                    <label for="Name">Name</label>
                    <input class="input" type="text" id="Name" name="Name" required>
                
                    <label for="Sex">&nbsp; &nbsp; Sex </label>
                    <input class="radio" type="radio" id="Sex" name="Sex" value="M" required> Male
                    <input class="radio" type="radio" id="Sex" name="Sex" value="F"> Female <br>                
               
                    <label for="Age">Age</label>
                    <input class="input" type="number" id="Age" name="Age" required>

                    <label for="Breed">&nbsp; Breed</label>
                    <input class="input" type="text" id="Breed" name="Breed">

                    <label for="Species">&nbsp; Species</label>
                    <input class="input" type="text" id="Species" name="Species" required><br>

                    <label for="Status">Status</label>
                    <input class="input" type="text" id="Status" name="Status" required>

                    <label for="Cause_Of_Death">&nbsp; Cause of Death</label>
                    <input class="input" type="text" id="Cause_Of_Death" name="Cause_Of_Death"><br>

                    <label for="Spay_Or_Neutered">Spayed or Neutered</label>
                    <input class="radio" type="radio" id="Spay_Or_Neutered" name="Spay_Or_Neutered" value="Y" required> Yes
                    <input class="radio" type="radio" id="Spay_Or_Neutered" name="Spay_Or_Neutered" value="N"> No <br><br>
                    <button class="submitButton" type="submit" name="submit">Submit Part Two</button>
                </form>
            </div>
        </main>
        <footer>
           <p>Party Animal Shelter &copy; | </p>
            <a href="references.html">References</a>
        </footer>
    </body>
</html>