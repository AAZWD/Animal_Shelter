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
if($_SERVER["REQUEST_METHOD"] == "POST") {      
    $accountUsername = $_POST['username'];
    $accountPassword = $_POST['password']; 

        $sql1 = "SELECT employees.Username, EmpID, Password, employees.Email FROM employees LEFT JOIN user_account ON employees.Email = user_account.Email WHERE employees.Username = '$accountUsername'";
        $result1 = mysqli_query($conn,$sql1);
        $row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC);
        clearConnection($conn); 

        $sql2 = "SELECT vet.Username, VID, Password, vet.Email FROM vet LEFT JOIN user_account ON vet.Email = user_account.Email WHERE vet.Username = '$accountUsername'";
        $result2 = mysqli_query($conn,$sql2);
        $row2 = mysqli_fetch_array($result2,MYSQLI_ASSOC);
        clearConnection($conn); 

        $sql3 = "SELECT Username, Password, Email FROM user_account WHERE Username = '$accountUsername'";
        $result3 = mysqli_query($conn,$sql3);
        $row3 = mysqli_fetch_array($result3,MYSQLI_ASSOC);
        clearConnection($conn); 

        if($result1->num_rows != 0 && ($accountUsername == $row1['Username'] && $accountPassword == $row1['Password'])) {
            $_SESSION['user'] = $accountUsername;
            $_SESSION['ID'] = $row1['EmpID'];
            $_SESSION['email'] = $row1['Email'];
            
            header("location: employee/index.php"); 
        }elseif($result1->num_rows != 0 && ($accountUsername == $row1['Username'] && $accountPassword != $row1['Password'])){
            header("location: index.php");    
        }elseif($result2->num_rows != 0 && ($accountUsername == $row2['Username'] && $accountPassword == $row2['Password'])){
            $_SESSION['user'] = $accountUsername;
            $_SESSION['ID'] = $row2['VID'];
            $_SESSION['email'] = $row2['Email'];
            
            header("location: vet/index.php");         
        }elseif($result2->num_rows != 0 && ($accountUsername == $row2['Username'] && $accountPassword != $row2['Password'])){
            header("location: index.php");    
        }elseif($result3->num_rows != 0 && ($accountUsername == $row3['Username'] && $accountPassword == $row3['Password'])){
            $_SESSION['user'] = $accountUsername;
            $_SESSION['email'] = $row3['Email'];
            
            header("location: user/index.php");  
        }else{
            header("location: index.php");  
        }      
}                     
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
                <li><a href="about.html">About Us</a></li>
                <li><a href="adoptable.php">Adoptable Animals</a></li>
                <li><a href="contact.html">Contact Us</a></li>
                <li><a href="successStory.php">Success Stories</a></li>
            </ul>
        </nav>
        <main>
            <div id="create">
                <h1 id="title">Adopt a Best Friend Today!</h1>
                <p id="locate_text">Located in the <span>&hearts;</span> of Downtown, Vancouver B.C.</p>
                <div id="button">
                    <button class="click" onclick="openModal()"><span>LOGIN</span></button>
                </div>
            </div>
            <!--Modal-->
            <div id="modal" class="modal">
                <span onclick="closeModal();" class="close" title="Close Modal">&times;</span>
                <!--Login Form-->
                <form class="modalContent" action="index.php" method="post">
                    <div class="container">
                        <label><b>Username</b></label><br>
                        <input class="inputBox" type="text" placeholder="Enter Username" name="username" required><br>
                
                        <label><b>Password</b></label><br>
                        <input class="inputBox" type="password" placeholder="Enter Password" name="password" required><br>
                        <button class="submit"type="submit">Login</button>
                        <div><a href="createAccount.php">Don't have an account? Click here</a></div>
                    </div>
                </form>
                
            </div>
        </main>
        <footer>
           <p>Party Animal Shelter &copy; | </p>
            <a href="references.html">References</a>
        </footer>
    </body>
</html>

