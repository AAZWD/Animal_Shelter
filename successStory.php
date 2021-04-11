 
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="icon" href="Icon.ico">
        <link rel="stylesheet" href="CSS.css"><link rel="stylesheet" href="CSS.css">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
        <script src="Script.js" type="text/javascript"></script>                    
        <title>PAS | Application</title>
    </head>
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
        <main class="succ">
        <?php
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
            
            //Create div with success count
            $result1 = $conn->query("call GetNumberAdoptedEach()");
            clearConnection($conn);            
            echo "<div class='successBox'>";
            $count=0;   
            echo "<span class='animalsAdopted'> Thanks to people like you, ";       
            while ($row1 = mysqli_fetch_assoc($result1)){
                if($count>0){
                    echo",&nbsp;";
                }
                $count++;
                echo $row1['Successfully_Adopted']."&nbsp;".$row1['Species']; 
                         
            }
            if($count=1){
                echo"&nbsp; has found a home!";
                echo"<br>Click to read our success story</span>"; 
            }else{
                echo"&nbsp; have found homes!";
                echo"<br>Click to read our success stories</span>"; 
            }
             
            echo "</div>";

            //Create Table for success stories
            $result = $conn->query("call GetSuccess()");
            clearConnection($conn);            
            echo "<table class='successTable'> ";
            while ($row = mysqli_fetch_assoc($result)){
                echo "<tr>";
                    echo "<td rowspan='2'><div><img src='images/animals/" . $row['ID'] . ".jpg'></div></td>";
                    echo "<td><div class='name'>" . $row['names'] . "</div></td>";
                    echo "<td><div class='story'>" . $row['story'] . "</div></td>";
                echo "</tr>";
            }
            echo "</table>";

            ?>
        </main>
        <footer>
           <p>Party Animal Shelter &copy; | </p>
            <a href="references.html">References</a>
        </footer>
    </body>
</html>
    
