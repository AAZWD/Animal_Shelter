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
        <title>PAS | About Us</title>
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
                $sql = "SELECT EmpID FROM employees WHERE Email = '$email'";
                $result = mysqli_query($conn,$sql);
                $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
                if($row['EmpID'] == 1) {
                    echo "<li><a href='staff.php'>Staff</a></li>";
                }
                ?>              
            </ul>
        </nav>
        <main class="staff">
        <?php
            echo "<div class='EmpDetails'>";
                echo"<button class='empTitle'>Adoption Shelter Employees</button>";
                $people="employees.*";
                $sql1 = "SELECT DISTINCT $people FROM vet CROSS JOIN employees";
                $result1 = mysqli_query($conn,$sql1);
                clearConnection($conn); 
                echo "<div class='empDisplay'>";           
                echo "<table id='employeeTable'>";
                while ($row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC)){
                    echo "<tr>";
                        echo "<td><div><img src='images/employees/" . $row1['Username'] . ".jpg'></div></td>";
                        echo "<td>
                                <span>
                                <strong>First Name: </strong>" . $row1['First_Name']. 
                                "  <strong>Last Name: </strong>" . $row1['Last_Name']. 
                                "<br>  <strong>Username: </strong>" . $row1['Username']. "</span><br>
                                <span><strong>Email: </strong>" . $row1['Email'].
                                "<br>  <strong>Phone Number: </strong>" . $row1['Phone_Num']. "</span><br>
                                <span><strong>Certification: </strong>" . $row1['Certification']. "</span><br>"; 
                        echo "</td>";
                    echo "</tr>";
                }
                echo "</table>";
                echo "</div>";

                $result2 = $conn->query("call GetVets()");
                clearConnection($conn); 
                $count=0;                
                echo "<button class='vetTitle'>Vets</button>"; 
                $people="vet.*";
                $sql2 = "SELECT DISTINCT $people FROM vet CROSS JOIN employees";
                $result2 = mysqli_query($conn,$sql2);
                echo "<div class='vetDisplay'>";          
                echo "<table id='vetTable'>";
                while ($row2 = mysqli_fetch_array($result2,MYSQLI_ASSOC)){
                    $count++;
                    echo "<tr>";
                        echo "<td><div><img src='images/vets/" . $row2['Username'] . ".jpg'></div></td>";
                        echo "<td>
                                <span>
                                <strong>First Name: </strong>" . $row2['First_Name']. 
                                "'  <strong>Last Name: </strong>" . $row2['Last_Name']. 
                                "<br>  <strong>Username: </strong>" . $row2['Username']. "</span><br>
                                <span><strong>Email: </strong>" . $row2['Email'].
                                "<br>  <strong>Phone Number: </strong>" . $row2['Phone_Num']. "</span><br>
                                <span><strong>Clinic Name: </strong>" . $row2['Clinic_Name']. "</span><br>";    
                        echo "</td>";
                    echo "</tr>";
                }
                echo "</table>";
                echo"</div>";
            echo "</div>";

            echo "<div class='allVets'>";
                echo "<div class='allVetsTitle'>Contact the following to modify<br> any animals' medical histories</div>";
                $result3 = $conn->query("call GetAllVetsCareAllAnimals()");
                clearConnection($conn); 
                $count=0;                
                while ($row3 = mysqli_fetch_assoc($result3)){
                    $count++;
                    echo"<div class='eachVet'>".$row3['First_Name']."&nbsp;".$row3['Last_Name']."&nbsp;&nbsp;VID:&nbsp;" .$row3['VID']."</div>";
                }
            echo "</div>";
        ?>
        </main>
        <footer>
           <p>Party Animal Shelter &copy; | </p>
            <a href="references.html">References</a>
        </footer>
    </body>
</html>