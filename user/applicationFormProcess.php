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
        <title>PAS</title>
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
            //Get AppID
            $sql = "SELECT MAX(AppID) AS 'MaxID' FROM applications";
            $result = mysqli_query($conn,$sql);
            $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
            clearConnection($conn); 
            //Get EmpID
            $sql2 = "SELECT i.* FROM (SELECT e.EmpID from employees AS e ORDER BY rand()) AS i Limit 1";
            $result2 = mysqli_query($conn,$sql2);
            $row2 = mysqli_fetch_array($result2,MYSQLI_ASSOC);
            clearConnection($conn); 

            //Default Values
            $AppID = $row['MaxID'] + 1;
            $App_Status= "Pending";
            date_default_timezone_set('America/Los_Angeles');
            $Date= date("Y-m-d");
            $EmpID= $row2['EmpID'];
            $_SESSION['appid']=$AppID;

            //Input values
            $FN=$_GET['First_Name'];
            $LN=$_GET['Last_Name'];
            $ADD=$_GET['Address'];
            $CITY=$_GET['City'];
            $PC=$_GET['Postal_Code'];
            $BCIDDL=$_GET['BCID_DL'];
            $DOB=$_GET['DOB'];
            $EMAIL=$_GET['Email'];
            $PN=$_GET['Phone_Num'];
            $HOUSEHOLD=$_GET['Household_size'];
            $CHILD=$_GET['Have_Small_Children'];
            $HT=$_GET['Home_Type'];
            $HS=$_GET['Home_Size'];
            $OH=$_GET['Own_Home'];
            $LN=$_GET['Landlord_Name'];
            $LC=$_GET['Landlord_Contact'];
            $RN=$_GET['Reference_Name'];
            $RC=$_GET['Reference_Contact'];
            $FTO=$_GET['First_Time_Owner'];
            $VN=$_GET['Vet_Name'];
            $VC=$_GET['Vet_Contact'];
            $HAVES=$_GET['Have_Surrendered'];
            $SR=$_GET['Surrender_Reason'];
            $AnimalID=$_GET['AnimalID'];

            //Update Application
            $sql3 = "INSERT INTO applications (AppID, First_Name, Last_Name, Address, City, Postal_Code, BCID_DL, DOB, Email, Phone_Num, 
            Household_size, Have_Small_Children, Home_Type, Home_Size, Own_Home, Landlord_Name, Landlord_Contact, Reference_Name, 
            Reference_Contact, First_Time_Owner, Vet_Name, Vet_Contact, Have_Surrendered, Surrender_Reason, Application_Status, 
            Date_Of_Creation) VALUES ('$AppID', '$FN', '$LN', '$ADD', '$CITY', '$PC', '$BCIDDL', '$DOB', '$EMAIL', '$PN', '$HOUSEHOLD', 
            '$CHILD', '$HT', '$HS', '$OH', '$LN', '$LC', '$RN', '$RC', '$FTO', '$VN', '$VC', '$HAVES', '$SR', '$App_Status', '$Date')";
            $result3 = mysqli_query($conn,$sql3);
            clearConnection($conn); 

            $sql4 = "UPDATE animals SET Application_Status = '$App_Status' WHERE AnimalID = '$AnimalID'";
            $result4 = mysqli_query($conn,$sql4);
            clearConnection($conn); 

            $sql5 = "INSERT INTO created_for (AppID, AnimalID) VALUES ('$AppID','$AnimalID')";
            $result5 = mysqli_query($conn,$sql5);
            clearConnection($conn); 

            $sql6 = "INSERT INTO review (AppID, EmpID) VALUES ('$AppID','$EmpID')";
            $result6 = mysqli_query($conn,$sql6);
            clearConnection($conn); 

            if($FTO=='N'){
                header('Location: applicationForm2.php');                
            }else{
                header('Location: applicationHistory.php');                
            }
        ?>
        </main>
        <footer>
           <p>Party Animal Shelter &copy; | </p>
            <a href="references.html">References</a>
        </footer>
    </body>
</html>
    