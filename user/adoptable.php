<?php
//Start session
session_start();
/*Citation:
1BestCsharp (2017) Php How To Filter Data In Html Table Using Php And MySQL [Computer program]. 
Available at http://1bestcsharp.blogspot.ca/2015/10/php-html-table-search-filter-data-mysql-database.html 
(Accessed 17 November 2017)*/
$result='';
if(isset($_POST['search'])){
        if ($_POST['Species'] == 'All' && $_POST['Age'] == 'All' && $_POST['Temp'] == 'All' && $_POST['House'] == 'All' && $_POST['Sex'] == 'All'){
            $sql = "SELECT * FROM animal_and_med_info";
            $result = filterTable($sql);
        }else{
            $sChoice=$_POST['Species'];
            $aChoice=$_POST['Age'];   
            $tChoice=$_POST['Temp'];               
            $hChoice=$_POST['House'];               
            $sexChoice=$_POST['Sex'];                           
            $count=0;     
            $sql = "SELECT * FROM animal_and_med_info WHERE";
            if($sChoice != 'All'){
                $count++;
                $sql=$sql. " Species = '" .$sChoice. "'";
            }
            if($_POST['Age']!= 'All'){
                if($count !=0){
                    $sql=$sql. " AND Age = '" .$aChoice. "'";                
                }else{
                    $sql=$sql. " Age = '" .$aChoice. "'";
                }
                $count++;                
            }
            if($_POST['Temp']!= 'All'){
                if($count !=0){
                    $sql=$sql. " AND Temperament = '" .$tChoice. "'";                
                }else{
                    $sql=$sql. " Temperament = '" .$tChoice. "'";
                }
                $count++;                
            }
            if($_POST['House']!= 'All'){
                if($count !=0){
                    $sql=$sql. " AND Housebroken = '" .$hChoice. "'";                
                }else{
                    $sql=$sql. " Housebroken = '" .$hChoice. "'";
                }
                $count++;                
            }
            if($_POST['Sex']!= 'All'){
                if($count !=0){
                    $sql=$sql. " AND Sex = '" .$sexChoice. "'";                
                }else{
                    $sql=$sql. " Sex = '" .$sexChoice. "'";
                }
            }
            //echo $sql;
            $result = filterTable($sql);
        }        
}else {
    $sql = "SELECT * FROM animal_and_med_info";
    $result = filterTable($sql);
}
                
// function to connect and execute the query
function filterTable($sql){
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

    $filterResult = mysqli_query($conn, $sql);
    return $filterResult;
}
                
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
        <main class=adoptable>  
                
        <form action="adoptable.php" method="post" class="form">
            <div class="searchOption">    
                <span>Type: </span>
                <select name="Species">
                    <option value="All">All</option>
                    <option value="Cat">Cat</option>
                    <option value="Dog">Dog</option>
                    <option value="Rabbit">Rabbit</option>
                    <option value="Chinchilla">Chinchilla</option>
                    <option value="Lovebird">Lovebird</option>
                    <option value="Parrot">Parrot</option> 
                </select>
            </div>
            <div class="searchOption">
                <span>Age: </span>
                <select name="Age">
                    <option value="All">All</option>
                    <option value="Juvenile">Juvenile</option>
                    <option value="Young Adult">Young Adult</option>
                    <option value="Adult">Adult</option>
                    <option value="Senior">Senior</option>
                </select>
            </div>
            <div class="searchOption">
                <span>Temperament: </span>
                <select name="Temp">
                    <option value="All">All</option>
                    <option value="Silent Companion">Silent Companion</option>
                    <option value="Hidden Gem">Hidden Gem</option>
                    <option value="Gatorade">Gatorade</option>
                    <option value="Secret Agent">Secret Agent</option>
                    <option value="Mac Daddy">Mac Daddy</option>
                </select>
            </div>
            <div class="searchOption">
                <span>Housebroken: </span>
                <select name="House">
                    <option value="All">All</option>
                    <option value="Y">Yes</option>
                    <option value="N">No</option>
                </select>
            </div>
            <div class="searchOption">
                <span>Sex: </span>
                <select name="Sex">
                    <option value="All">All</option>
                    <option value="M">Male</option>
                    <option value="F">Female</option>
                </select>
            </div>
            <button class="submit" type="submit" name="search">Search</button>
            </form>

            <?php    
            //Create Table              
                echo "<table id='animalTable'>";
                if(mysqli_num_rows($result)==0){
                    echo"<div class=noResults>We don't have the animals you are looking for. Try a different search.</div>";
                    echo "<img src='images/error.jpg' alt='error cat'>";
                    echo "<style>.click{display:none;}</style>";                    
                }                
                while ($row = mysqli_fetch_array($result)){
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
                                    echo "<br><span id='applyHere'><strong><a href= 'applicationForm.php?id=" . $row['AnimalID'] ."'>Adopt " .$row['Name']. "!</strong></a></span>";                                    
                            echo "</td>";
                    echo "</tr>";
                    }
                }
                echo "</table>";
                echo "<button class='click'>Show More</button>";
                ?>
        </main>
        <footer>
            <p>Party Animal Shelter &copy; | </p>
            <a href="references.html">References</a>
        </footer>
    </body>
</html>