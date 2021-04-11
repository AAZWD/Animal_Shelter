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
                <li><a href="contact.html">Contact Us</a></li>
                <li><a href="successStory.php">Success Stories</a></li>
            </ul>
        </nav>
        <main>
        <?php
            $Username=$_POST['Username'];
            $Password=$_POST['Password'];
            $Email=$_POST['Email'];

            mysqli_query($conn,"INSERT INTO user_account (Username, Password, Email)
            VALUES ('$Username','$Password','$Email')");
                            
            if(mysqli_affected_rows($conn) > 0){
                header('Location: index.php');
            }else{
                echo "<br><br><div>This account already exists. <a href='index.php'>Try again</a> with a different username.
                    <br><br><img src='images/error.jpg' alt='error cat'>
                </div>";
            }
        ?>
        </main>
        <footer>
           <p>Party Animal Shelter &copy; | </p>
            <a href="references.html">References</a>
        </footer>
    </body>
</html>
    