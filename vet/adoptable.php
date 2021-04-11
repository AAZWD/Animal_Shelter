<?php
//Start session
session_start();

/*Citation:
1BestCsharp (2017) Php How To Filter Data In Html Table Using Php And MySQL [Computer program]. 
Available at http://1bestcsharp.blogspot.ca/2015/10/php-html-table-search-filter-data-mysql-database.html 
(Accessed 17 November 2017)*/
$result='';
if(isset($_POST['search'])){
        if ($_POST['Species'] == 'All' && $_POST['Age'] == 'All' && $_POST['Sex'] == 'All' && $_POST['Vac'] == 'All' && $_POST['Preg'] == 'All' && $_POST['Dec'] == 'All' && $_POST['SAN'] == 'All') {
            $sql = "SELECT * FROM animal_and_med_info";
            $result = filterTable($sql);
        }else{
            $sChoice=$_POST['Species'];
            $aChoice=$_POST['Age'];   
            $sexChoice=$_POST['Sex'];
            $vacChoice=$_POST['Vac'];               
            $pregChoice=$_POST['Preg'];               
            $decChoice=$_POST['Dec'];  
            $sanChoice=$_POST['SAN'];                                      
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
            if($_POST['Sex']!= 'All'){
                if($count !=0){
                    $sql=$sql. " AND Sex = '" .$sexChoice. "'";                
                }else{
                    $sql=$sql. " Sex = '" .$sexChoice. "'";
                }
                $count++;                                
            }
            if($_POST['Vac']!= 'All'){
                if($count !=0){
                    $sql=$sql. " AND Vaccinated = '" .$vacChoice. "'";                
                }else{
                    $sql=$sql. " Vaccinated = '" .$vacChoice. "'";
                }
                $count++;                                
            }
            if($_POST['Preg']!= 'All'){
                if($count !=0){
                    $sql=$sql. " AND Pregnant = '" .$pregChoice. "'";                
                }else{
                    $sql=$sql. " Pregnant = '" .$pregChoice. "'";
                }
                $count++;                                
            }
            if($_POST['Dec'] !='All'){
                if($count !=0){
                    $sql=$sql. " AND Declawed = '" .$decChoice. "'";                
                }else{
                    $sql=$sql. " Declawed = '" .$decChoice. "'";
                }
                $count++; 
            }
            if($_POST['SAN'] !='All'){
                if($count !=0){
                    $sql=$sql. " AND Spay_Neut = '" .$sanChoice. "'";                
                }else{
                    $sql=$sql. " Spay_Neut = '" .$sanChoice. "'";
                }
            }
            //echo $sql;
            $result = filterTable($sql);
        }        
}else {
    $sql = "SELECT * FROM animal_and_med_info";
    $result = filterTable($sql);
}

if(isset($_POST['submit'])){
    $specChoice=$_POST['sick'];
    $illChoice=$_POST['ill'];   
    $sql2='SELECT species, COUNT(*) AS amount FROM animal_and_med_info WHERE';
    $count2=0;
    if(isset($_POST['sick']) && isset($_POST['ill'])){
        if($illChoice=='Parasites'){
            $sql2=$sql2. " Parasites IS NOT NULL";
        }
        if($illChoice=='Major_Illness'){ 
            $sql2=$sql2. " Major_Illness IS NOT NULL";             
        }
        if($illChoice=='Special_Needs'){
             $sql2=$sql2. " Special_Needs IS NOT NULL";
        }
        $sql2=$sql2. " AND Species = '" .$specChoice. "'";
    }
    $result2 = filterTable($sql2);
    
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
        <script src="Script.js" type="text/javascript"></script>     </head>
    <style>
        
    </style>
    <body>
        <center><img src="LOGO.png" alt="logo"></center>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="adoptable.php">Adoptable Animals</a></li>
                <li><a href="editMed.php">Medical History</a></li>                                
            </ul>
        </nav>
        <main class=adoptable>
<form action="adoptable.php" method="post" class="form">
    <div class="searchOption">    
        <span>Species: </span>
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
        <span>Sex: </span>
        <select name="Sex">
            <option value="All">All</option>
            <option value="M">Male</option>
            <option value="F">Female</option>
        </select>
    </div>
    <div class="searchOption">
        <span>Vaccinated: </span>
        <select name="Vac">
            <option value="All">All</option>
            <option value="Y">Yes</option>
            <option value="N">No</option>
        </select>
    </div>
    <div class="searchOption">
        <span>Pregnant: </span>
        <select name="Preg">
            <option value="All">All</option>
            <option value="Y">Yes</option>
            <option value="N">No</option>
        </select>
    </div>
    <div class="searchOption">
        <span>Declawed: </span>
        <select name="Dec">
            <option value="All">All</option>
            <option value="Y">Yes</option>
            <option value="N">No</option>
        </select>
    </div>
    <div class="searchOption">
        <span>Spayed/Neutered: </span>
        <select name="SAN">
            <option value="All">All</option>
            <option value="Y">Yes</option>
            <option value="N">No</option>
        </select>
    </div>
    <br><button class="submit" type="submit" name="search">Search</button>
    </form>

    <form action="adoptable.php" method="post" class="illCount">
        <div class="searchOption">
            <span>Illness: </span>
            <select name="ill">
                <option value="Special_Needs">Special Needs</option>
                <option value="Parasites">Parasites</option>
                <option value="Major_Illness">Major Illness</option>
            </select>
        </div>

        <span>Species: </span>
        <select name="sick">
            <option value="Cat">Cat</option>
            <option value="Dog">Dog</option>
            <option value="Rabbit">Rabbit</option>
            <option value="Chinchilla">Chinchilla</option>
            <option value="Lovebird">Lovebird</option>
            <option value="Parrot">Parrot</option> 
        </select>
        <br><button class="submit2" type="submit" name="submit">Get Illness Count</button>
    </form>
    <?php
        //Illness Count
        if(isset($result2)){
            $row2 = mysqli_fetch_assoc($result2);
            echo "<div class='illContainer'>" .$row2['amount']. "</div>";
        }
              //Create Table     
                echo "<table id='animalTable'>";
                if(mysqli_num_rows($result)==0){
                    echo"<div class=noResults>We don't have the animals you are looking for. Try a different search.</div>";
                    echo "<img src='images/error.jpg' alt='error cat'>";
                    echo "<style>.click{display:none;}</style>";
                }
                while ($row = mysqli_fetch_assoc($result)){
                    echo "<tr>";
                        echo "<td><div><img src='images/animals/" . $row['AnimalID'] . ".jpg'></div></td>";
                        echo "<td>";
                                    if(!empty($row['Animal'])){
                                        echo"<div class='med'>
                                        <span>
                                        <strong><a href= 'editMed.php?id=" . $row['AnimalID'] ."'>ID: </strong>" . $row['AnimalID'] . "</a>
                                        <strong>Name: </strong>" . $row['Name']. 
                                        "  <strong>Species: </strong>" . $row['Species']. 
                                        "  <strong>Breed: </strong>" . $row['Breed']. "
                                        </span><br>
                                        <span>
                                        <strong>Sex: </strong>" . $row['Sex']. 
                                        "  <strong>Age: </strong>" . $row['Age']. 
                                        "  <span class='vetEmp'><strong>Weight: </strong>" . $row['Weight']. "</span>
                                        </span><br>
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
                                        echo "  <strong>Spayed or Neutered: </strong>" . $row['Spay_Neut']. "</span><br>
                                    </div>";
                                    }else{
                                        echo "<div class='med'>
                                        <span>
                                        <strong><a href= 'editMed.php?id=" . $row['AnimalID'] ."'>ID: </strong>" . $row['AnimalID'] . "</a>
                                         <strong>Name: </strong>" . $row['Name']. 
                                        "  <strong>Species: </strong>" . $row['Species']. 
                                        "  <strong>Breed: </strong>" . $row['Breed']. "
                                        </span><br>
                                        <span>
                                        <strong>Sex: </strong>" . $row['Sex']. 
                                        "  <strong>Age: </strong>" . $row['Age'] . "<br><br> No medical record available";
                                    }
                                    echo  "<br><br><button class='showMore'>More</button>";
                                    echo "<div class='animalInfo'>                                  
                                        <span><strong>Application Status: </strong>" . $row['Application_Status']. "</span><br>
                                        <span>
                                        <strong>Housebroken: </strong>" . $row['Housebroken']. 
                                        "  <strong>Temperament: </strong>" . $row['Temperament']. "
                                        </span></br>
                                        <span>
                                        <strong>Intake Date: </strong>" . $row['Intake_Date'].
                                        "  <span class='vetEmp'><strong>Intake Condition: </strong>" . $row['Intake_Condition']. "</span>                                    
                                        <span class='vetEmp'><strong>Intake Location: </strong>" . $row['Intake_Location']. "</span>
                                        </span>
                                    <div><br>
                            </td>";
                    echo "</tr>";
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