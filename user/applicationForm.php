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
        <main>
        <?php
            //Verify email, surrender, double application and animal number
            if (isset($_GET['submit'])) { 

                $AID = $_GET['AnimalID'];
                $sql = "SELECT AnimalID FROM Animals WHERE AnimalID='$AID'";
                $result = mysqli_query($conn,$sql);
                clearConnection($conn); 
                $count=mysqli_num_rows($result);

                $mail = $_GET['Email'];
                $sql2="SELECT * FROM applications WHERE Email='$mail'";
                $result2 = mysqli_query($conn,$sql2);
                clearConnection($conn); 
                $count2=mysqli_num_rows($result2);
                             
                
                if($count != 1){
                    echo "<strong>The animal you are attempting to adopt is not available. Please double check the Animal ID.</strong>"; 
                }elseif ($_SESSION['email'] != $_GET['Email']){ 
                    echo "<strong>The email address you entered is incorrect.</strong><br>"; 
                }elseif($_GET['Have_Surrendered'] == 'Y' && $_GET['Surrender_Reason'] ==''){
                    echo "<strong>You must enter a reason for having surrendered an animal in the past.</strong><br>"; 
                }elseif($count2 > 0){
                    echo"<strong>You already have a pending application.</strong>";  
                }else{
                    header('Location:applicationFormProcess.php?AnimalID='.$_GET['AnimalID'].'&First_Name='.$_GET['First_Name'].'&Last_Name='.$_GET['Last_Name'].'&DOB='.$_GET['DOB'].'&Address='.$_GET['Address'].'&City='.$_GET['City'].'&Postal_Code='.$_GET['Postal_Code'].'&BCID_DL='.$_GET['BCID_DL'].'&Email='.$_GET['Email'].'&Phone_Num='.$_GET['Phone_Num'].'&Household_size='.$_GET['Household_size'].'&Home_Type='.$_GET['Home_Type'].'&Home_Size='.$_GET['Home_Size'].'&Have_Small_Children='.$_GET['Have_Small_Children'].'&Own_Home=Y'.$_GET['Own_Home'].'&Landlord_Name='.$_GET['Landlord_Name'].'&Landlord_Contact='.$_GET['Landlord_Contact'].'&Reference_Name='.$_GET['Reference_Name'].'&Reference_Contact='.$_GET['Reference_Contact'].'&First_Time_Owner='.$_GET['First_Time_Owner'].'&Have_Surrendered='.$_GET['Have_Surrendered'].'&Surrender_Reason='.$_GET['Surrender_Reason'].'&Vet_Name='.$_GET['Vet_Name'].'&Vet_Contact='.$_GET['Vet_Contact'].'');
                }
            }
        ?>
            <div class="appForm">
                <form class="appContent" action="" method= "get">
                    <h2 class="appTitle">General Application</h2>
                    <label for="AnimalID">Animal Applying For(ID)</label>
                    <?php
                        if(!empty($_GET['id'])){
                            echo "<input class='input' type='number' id='AnimalID' name='AnimalID' value='" .$_GET['id']. "' required><br>";
                        }else{
                            echo "<input class='input' type='number' id='AnimalID' name='AnimalID' required>&nbsp;";
                        }
                    ?>
                    <label for="First_Name">First Name</label>
                    <input class="input" type="text" id="First_Name" name="First_Name" required>
                
                    <label for="Last_Name">&nbsp; Last Name</label>
                    <input class="input" type="text" id="Last_Name" name="Last_Name" required>
                    
                    <label for="DOB">&nbsp; Date of Birth</label>
                    <input class="input" type="text" id="DOB" name="DOB" placeholder="ddmmyyyy" required><br>

                    <label for="Address">Address</label>
                    <input class="input" type="text" id="Address" name="Address" required>

                    <label for="City">&nbsp; City</label>
                    <input class="input" type="text" id="City" name="City" required>

                    <label for="Postal_Code">&nbsp; Postal Code</label>
                    <input class="input" type="text" id="Postal_Code" name="Postal_Code" required><br>

                    <label for="BCID_DL">BC Identification/Drivers License</label>
                    <input class="input" type="number" id="BCID_DL" name="BCID_DL" required>

                    <label for="Email">Email</label>
                    <?php
                        echo "<input class='input' type='text' id='Email' name='Email' value='"
                        .$_SESSION['email']. "' required>";
                    ?>

                    <label for="Phone_Num">&nbsp; Phone Number</label>
                    <input class="input" type="number" id="Phone_Num" name="Phone_Num" required><br>

                    <label for="Household_size">Household Size</label>
                    <input class="input" type="number" id="Household_size" name="Household_size" required>

                    <label for="Home_Type">&nbsp; Home Type</label>
                    <input class="input" type="text" id="Home_Type" name="Home_Type" required>

                    <label for="Home_Size">&nbsp; Home Size</label>
                    <input class="input" type="number" id="Home_Size" name="Home_Size" required><br>
                    
                    <label for="Have_Small_Children">Do you have small children?</label>
                    <input class="radio" type="radio" id="Have_Small_Children" name="Have_Small_Children" value="Y"> Yes
                    <input class="radio" type="radio" id="Have_Small_Children" name="Have_Small_Children" value="N"> No 

                    <label for="Own_Home">&nbsp; &nbsp; Do you Own your Home?</label>
                    <input class="radio" type="radio" id="Own_Home" name="Own_Home" value="Y"> Yes
                    <input class="radio" type="radio" id="Own_Home" name="Own_Home" value="N"> No <br><br>                    
               
                    <label for="Landlord_Name">Landlord Name</label>
                    <input class="input" type="text" id="Landlord_Name" name="Landlord_Name">

                    <label for="Landlord_Contact">&nbsp; Landlord Contact</label>
                    <input class="input" type="text" id="Landlord_Contact" name="Landlord_Contact"><br>

                    <label for="Reference_Name">Reference Name</label>
                    <input class="input" type="text" id="Reference_Name" name="Reference_Name" required>

                    <label for="Reference_Contact">&nbsp; Reference Contact</label>
                    <input class="input" type="text" id="Reference_Contact" name="Reference_Contact" required><br>
                    
                    <label for="First_Time_Owner">First time pet owner?</label>
                    <input class="radio" type="radio" id="First_Time_Owner" name="First_Time_Owner" value="Y"> Yes
                    <input class="radio" type="radio" id="First_Time_Owner" name="First_Time_Owner" value="N"> No                    
                    
                    <label for="Have_Surrendered">&nbsp; Have you surrendered a pet in the past?</label>
                    <input class="radio" type="radio" id="Have_Surrendered" name="Have_Surrendered" value="Y"> Yes
                    <input class="radio" type="radio" id="Have_Surrendered" name="Have_Surrendered" value="N"> No

                    <label for="Surrender_Reason">&nbsp; Reason for surrendering</label>
                    <input class="input" type="text" id="Surrender_Reason" name="Surrender_Reason" ><br>

                    <label for="Vet_Name">Vet Name</label>
                    <input class="input" type="text" id="Vet_Name" name="Vet_Name">

                    <label for="Vet_Contact">&nbsp; Vet Contact</label>
                    <input class="input" type="text" id="Vet_Contact" name="Vet_Contact"><br>
                   
                    <button class="submitButton" type="submit" name="submit">Submit Part One</button>
                </form>
            </div>
    </main>
        </main>
        <footer>
           <p>Party Animal Shelter &copy; | </p>
            <a href="references.html">References</a>
        </footer>
    </body>
</html>