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
        <script src="Script.js" type="text/javascript"></script>                    
        <title>PAS | Party Animal Shelter</title>
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
            <div id="create">
                <h1 id="title">Adopt a Best Friend Today!</h1>
                <p id="locate_text">Located in the <span>&hearts;</span> of Downtown, Vancouver B.C.</p>
                <div id="button">
                <a href="logout.php"><button class="click"><span>LOGOUT</span></button></a>
                </div>
            </div>
        </main>
        <footer>
           <p>Party Animal Shelter &copy; | </p>
            <a href="references.html">References</a>
        </footer>
    </body>
</html>

