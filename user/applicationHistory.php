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
        <title>PAS | Application History</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="CSS.css">
        <link rel="icon" href="Icon.ico">
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
            <div class="appHistory">
                <strong>You may only delete pending applications</strong><br><br><br>
                <?php
                    $result = $conn->query("call GetApplicationHistory('$_SESSION[email]')");
                    clearConnection($conn);        
                    $count = mysqli_num_rows($result);
                    if($count < 1){
                        echo "Oops! It looks like you haven't created any applications<br>
                                <img src='images/error.jpg' class='errorImage'>";
                    }    
                    while ($row = mysqli_fetch_assoc($result)){
                        echo "<strong>Application ID:</strong> " . $row['AppID'] . 
                        "  <strong>Animal ID: </strong>" . $row['AnimalID'] . 
                        "  <strong> Status: </strong>" . $row['Application_Status'] . 
                        "  <strong>Date: </strong>" . $row['Date_Of_Creation'];
                        if($row['Application_Status'] == 'Pending'){
                            echo  "&nbsp; <form class='deleteForm'action='deleteProcess.php?anid=". $row['AnimalID'] ."' method='post'>
                            <button class='deleteApp' name='deleteApp'>Delete</button>
                            </form>";
                        }
                        echo "<br>";
                    }
            
                ?>
            
            </div><br><br>
        </main>
        <footer>
           <p>Party Animal Shelter &copy; | </p>
            <a href="references.html">References</a>
        </footer>
    </body>
</html>