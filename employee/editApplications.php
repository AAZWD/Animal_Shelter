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
        <title>PAS | Applications</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="CSS.css">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
        <script src="Script.js" type="text/javascript"></script> 
        <link rel="icon" href="Icon.ico">
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
            $result = $conn->query("call GetReviewApplication()");
            clearConnection($conn);            
            while ($row = mysqli_fetch_assoc($result)){
                echo "<button class='appClick'>" . $row['AppID'] ."</button>";
                echo"<div class='editApp'>
                <strong>First Name: </strong>". $row['First_Name'] .
                        "&nbsp; &nbsp; &nbsp;<strong>Last Name: </strong>" . $row['Last_Name'] .
                        "<br><strong>Address: </strong>" . $row['Address'] .
                        "&nbsp; &nbsp; &nbsp;<strong>City: </strong>" . $row['City'] .
                        "&nbsp; &nbsp; &nbsp;<strong>Postal Code: </strong>" . $row['Postal_Code'] .
                        "<br><strong>License Number: </strong>" . $row['BCID_DL'] .
                        "&nbsp; &nbsp; &nbsp;<strong>Date of Birth: </strong>" . $row['DOB'] .
                        "<br><strong>Email: </strong>" . $row['Email'] .
                        "&nbsp; &nbsp; &nbsp;<strong>Phone Number: </strong>" . $row['Phone_Num'] .
                        "<br><strong>Household Size: </strong>" . $row['Household_size'] .
                        "&nbsp; &nbsp; &nbsp;<strong>Have Small Children: </strong>" . $row['Have_Small_Children'] .
                        "<br><strong>Home Type: </strong>" . $row['Home_Type'] .
                        "&nbsp; &nbsp; &nbsp;<strong>Home Size: </strong>" . $row['Home_Size'] .
                        "&nbsp; &nbsp; &nbsp;<strong>Own Home: </strong>" . $row['Own_Home'] ;
                        if (empty($row['Landlord_Name'])){
                            echo "<br><strong>Landlord Name: </strong>none";
                        }else{
                            echo "<br><strong>Landlord Name: </strong>" . $row['Landlord_Name'];
                        }
                        if (empty($row['Landlord_Contact'])){
                            echo "&nbsp; &nbsp; &nbsp;<strong>Landlord Contact: </strong>none";
                        }else{
                            echo "&nbsp; &nbsp; &nbsp;<strong>Landlord Contact: </strong>" . $row['Landlord_Contact'];
                        }
                        echo "<br><strong>Reference Name: </strong>" . $row['Reference_Name'] . 
                        "&nbsp; &nbsp; &nbsp;<strong>Reference Contact: </strong>" . $row['Reference_Contact'] .
                        "&nbsp; &nbsp; &nbsp;<strong>First Time Owner: </strong>" . $row['First_Time_Owner'] ;
                        if (empty($row['Vet_Name'])){
                            echo "<br><strong>Vet Name: </strong>none";
                        }else{
                            echo "<br><strong>Vet Name: </strong>" . $row['Vet_Name'];
                        }
                        if (empty($row['Vet_Contact'])){
                            echo "&nbsp; &nbsp; &nbsp;<strong>Vet Contact: </strong>none";
                        }else{
                            echo "&nbsp; &nbsp; &nbsp;<strong>Vet Contact: </strong>" . $row['Vet_Contact'];
                        }
                        echo "<br><strong>Have Surrendered: </strong>" . $row['Have_Surrendered'] ;
                        if (empty($row['Surrender_Reason'])){
                            echo "&nbsp; &nbsp; &nbsp;<strong>Surrender Reason: </strong>none given";
                        }else{
                            echo "&nbsp; &nbsp; &nbsp;<strong>Surrender Reason: </strong>" . $row['Surrender_Reason'];
                        }
                        echo "<br><strong>Application Status: </strong>" . $row['Application_Status'] .
                        "&nbsp; &nbsp; &nbsp;<strong>Date Created: </strong>" . $row['Date_Of_Creation'] . "<br>";                                                            
               
                        if($_SESSION['ID'] == $row['EmpID'] && $row['Application_Status']=='Pending'){
                            echo "<form class='arApp' action='acceptProcess.php?appid=" .$row['AppID'] . "' method='post'>
                            <button class='accept' name='accept'>Accept</button>
                            </form>";
                            echo "<form class='arApp' action='rejectProcess.php?appid=" .$row['AppID'] . "' method='post'>
                            <button class='reject' name='reject'>Reject</button>
                            </form>";                        
                        }
                echo "</div>";
               }
        ?>
        </main>
        <footer>
           <p>Party Animal Shelter &copy; | </p>
            <a href="references.html">References</a>
        </footer>
    </body>
</html>