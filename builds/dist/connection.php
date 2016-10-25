<?php

require("xmlapi.php"); // this can be downlaoded from https://github.com/CpanelInc/xmlapi-php/blob/master/xmlapi.php
$xmlapi = new xmlapi("joshboyan.com");   
$xmlapi->set_port( 3306 );   
$xmlapi->password_auth($opts['joshboya'],$opts['7A43any8Rs']);    
$xmlapi->set_debug(0);//output actions in the error log 1 for true and 0 false

$servername = "joshboyan.com";
$username = 'joshboya';
$password = '7A43any8Rs';
$dbname = "formSubmissions";
$databaseuser = 'josh';
$databasepass = "mb2010";
$tableName = "emails";
$cpaneluser = $opts[$username];
$cpanelpass = $opts[$password];

$Referer = $_SERVER['HTTP_REFERER'];
// Gets posted data from the HTML form fields and creates local variables. The items with the ' marks around them are the name values from the fields in the HTML form. Note, the first three variables are required for all email messages.

$EmailFrom = Trim(stripslashes($_POST['email'])); 
$EmailTo = "joshboyan@yahoo.com";
$Subject = Trim(stripslashes($_POST['subject'])); 
$Name = Trim(stripslashes($_POST['name'])); 
$Message = Trim(stripslashes($_POST['message'])); 
$current_date = date("Y-m-d");
 // This date is created when the form is submitted.

// This section below validates the $EmailFrom (data from the Email From field) and $Name (data from the Name field).

// Note -- you should always validate at least one field you use from your form so your form doesn't get "Submit Spam" (in other words, people continuous clicking submit and spamming your email without sending data). Even if you are using Javascript or Spry validation, it's still a very good idea to do this. Javascript and Spry (which is also Javascript) can easily be bypassed if the user doesn't allow Javascript to be active through their browser -- and it can easily be turned off through most browser preferences. 

// The fields being validated here, from the form example above, are the email and name fields. Those must contain some form of data for the PHP to accept them, otherwise the error.html page is generated to the form user.

$validationOK=true;
if (!filter_var(Trim($EmailFrom), FILTER_VALIDATE_EMAIL)) {
    $validationOK=false;
} 
if (Trim($Name)=="") $validationOK=false;
if (!$validationOK) {
//print "<meta http-equiv=\"refresh\" content=\"0;URL=$Referer\">";
echo "<script type='text/javascript'>alert('It seems your email address is invalid!');</script>";
//exit;
}   

//Create Database if none exists
try {
    //Special format for cpanel xmlapi
    if(file_exists("/usr/local/cpanel/version")) {
        //create database    
$createdb = $xmlapi->api1_query($cpaneluser, "Mysql", "adddb", array($dbname));   
//create user 
$usr = $xmlapi->api1_query($cpaneluser, "Mysql", "adduser", array($cpaneluser, $cpanelpass));   
//add user 
$addusr = $xmlapi->api1_query($cpaneluser, 'Mysql', 'adduserdb', array('' . $dbname . '', '' . $cpaneluser . '', 'all'));    
    } else {
    $conn = new PDO("mysql:host=$servername", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "CREATE DATABASE IF NOT EXISTS $dbname";
    // use exec() because no results are returned
    $conn->exec($sql);
    echo "Database $dbname created successfully<br>";
    }
}
catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }

//Create table if none exists
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $databaseuser, $databasepass);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // sql to create table
    $sql = "CREATE TABLE IF NOT EXISTS $tableName (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
    name VARCHAR(30) NOT NULL,
    email VARCHAR(50) NOT NULL,
    subject VARCHAR(50) NOT NULL,
    message VARCHAR(500) NOT NULL,
    reg_date TIMESTAMP
    )";

    // use exec() because no results are returned
    $conn->exec($sql);
    echo "Table $tableName created successfully";
    }
catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }

//Insert form data into database table
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $cpaneluser, $cpanelpass);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "INSERT INTO $tableName (name, email, subject, message)
    VALUES ('$Name', '$EmailFrom', '$Subject', '$Message')";
    // use exec() because no results are returned
    $conn->exec($sql);
    echo "<br>New record created successfully";
    }
catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }

$conn = null;

$myFilePath = "contacts/";
$myFileName = "form-data.csv";
if (!file_exists($myFilePath.$myFileName)) {
    mkdir($myFilePath.$myFileName, 0777, true);
    $myPointer = fopen ($myFilePath.$myFileName, "a+");
    $form_data = $current_date . "," . $EmailFrom . "," . $Name . "," . $Subject . "," . "," . $Message . "\n";
    fputs ($myPointer, $form_data);
    fclose ($myPointer);
} else {
$myPointer = fopen ($myFilePath.$myFileName, "a+");
$form_data = $current_date . "," . $EmailFrom . "," . $Name . "," . $Subject . "," . "," . $Message . "\n";
fputs ($myPointer, $form_data);
fclose ($myPointer);
}


// This section of PHP prepares the email body text. This is the fourth and final required element to compose and send an email message from a server-side script. 

$Body = "";
$Body .= $Message;
$Body .= "\n";

// Note -- The ".=" means to append to (added to) the previous variable. So there is only one $Body variable, and all the other parts are appended to that one. The "\n" means to place a hard return between these lines in the email message. If the "\n" weren't included, all the items would be run together on one long line.

// This is the sendmail function which send an email message from the server to the email address listed in the $EmailTo variable above.

$success = mail($EmailTo, $Subject, $Body, "From: <$EmailFrom>");

// If the page validates and there are no errors in the PHP, this line redirect to ok.html page, which is the "success page" for the form submission.

/*if ($success){  
  echo "<script type='text/javascript'>alert('Message has been successfully sent!');</script>";
  print "<meta http-equiv=\"refresh\" content=\"0;URL=$Referer\">";
}
else{ 
  echo "<script type='text/javascript'>alert('There was an error with the message!');</script>";
   print "<meta http-equiv=\"refresh\" content=\"0;URL=$Referer\">";
}
//Should I change these two meta tags to HTML5: <meta charset="UTF-8">?
*/
?>

