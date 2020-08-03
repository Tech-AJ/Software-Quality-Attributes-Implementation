<?php
$data = json_decode(file_get_contents('php://input'));
$string1 = $data->str1;
$string2 = $data->str2;
$operation = $data->operation;
//$res = "";
//$string1 = "Apoorva Jain";
//$string2="Jain";
//$operation=5;
switch ($operation) {
    case 1:
        $res = $string1.$string2;
        break;
    case 2:
        $res = strrev($string1);
        break;
    case 3:
        $res = strval(strlen($string1));
        break;
    case 4:          //word count
        $res = str_word_count($string1);  
        break;
    case 5:         // search for text within a string
        $res = strpos($string1,$string2); ;
        break;
    case 6:
        $res = cos($num2);
        break;
}
// save it in sql
if (!empty($_ENV['MYSQL_HOST']))
    $host = $_ENV['MYSQL_HOST'];
else
    $host = 'mysql-app1';
if (!empty($_ENV['MYSQL_USER']))
    $user = $_ENV['MYSQL_USER'];
else
    $user = 'user1';
if (!empty($_ENV['MYSQL_PASSWORD']))
    $pass = $_ENV['MYSQL_PASSWORD'];
else
    $pass = 'passw1';
if (!empty($_ENV['MYSQL_DB']))
    $db_name = $_ENV['MYSQL_DB'];
else
    $db_name = 'db1';
//echo "Connecting to Database: $host $user $pass $db_name";
//echo "<br><br>";


try {
    $conn = new PDO("mysql:host=$host;dbname=$db_name", $user, $pass);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Connected successfully";

    // sql to create table - run this serparately
    //copied to M2.sql that is to be imported in PhpMyAdmin initially
  /*  $sql = "CREATE TABLE Strings (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        string1 VARCHAR(30) NOT NULL,
        string2 VARCHAR(30),
        operator DOUBLE NOT NULL,
        result VARCHAR(30) NOT NULL,
        reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )";

    // use exec() because no results are returned
    $conn->exec($sql);
    //echo "Table MyGuests created successfully";
*/
   
} catch (PDOException $e) {
   // echo "failed: " . $e->getMessage();
}



//insert in db
try {
   //use prepare statement for security
  // prepare sql and bind parameters
  $stmt = $conn->prepare("INSERT INTO Strings (string1,string2,operator,result) VALUES(:string1,:string2,:operation,:res)");
  //VALUES (:firstname, :lastname, :email)");
  $stmt->bindParam(':string1', $string1);
  $stmt->bindParam(':string2', $string2);
  $stmt->bindParam(':operation', $operation);
  $stmt->bindParam(':res', $res);
  $stmt->execute();
  //  echo "New record created successfully";
} catch (PDOException $e) {
    echo "failed: " . $e->getMessage();
}




//close the connection
$conn = null;
$response['res'] = $res;
//echo("res".$res);

$json_response = json_encode($response);
echo $json_response;
