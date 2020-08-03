<?php
$data = json_decode(file_get_contents('php://input'));

//echo("num1".$num1);
$num1 = $data->num1;
$num2 = $data->num2;
//echo("num m3".$num1."num2 m3  ".$num2 );
$operation = $data->operation;
$res = 0;
//$num1 = 1;
//$num2 = 0;
//$operation = 1;
switch ($operation) {
    case 1:
        $res = $num1 + $num2;
        $dis=$num1."+".$num2."=".$res;
        break;
    case 2:
        $res = $num1 - $num2;
        $dis=$num1."-".$num2."=".$res;
        break;
    case 3:
        $res = $num1 * $num2;
        $dis=$num1."*".$num2."=".$res;
        break;
    case 4:
        $res = $num1 / $num2;    // check for / 0 error at client side
        $dis=$num1."/".$num2."=".$res;
   
        break;
    case 5:
        $res = sin(deg2rad($num1));
        $dis="sin".$num1."=".$res;
        break;
    case 6:
        $res = cos(deg2rad($num1));
        $dis="cos".$num1."=".$res;
        break;
    case 7:
        $res = tan(deg2rad($num1));
        $dis="tan".$num1."=".$res;
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
  //  echo "Connected successfully";

    // sql to create table - copied to M1.sql that is to be imported in PhpMyAdmin
 /*   $sql = "CREATE TABLE Calculator (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        num1 DOUBLE NOT NULL,
        num2 DOUBLE,
        operator DOUBLE NOT NULL,
        result DOUBLE NOT NULL,
        reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )";

    // use exec() because no results are returned
    $conn->exec($sql);*/
  
} catch (PDOException $e) {
    // echo "failed: " . $e->getMessage();
}



//insert in db
try {
    //   $sql = "INSERT INTO Calculator (num1,num2,operator,result) VALUES ('$num1', '$num2', '$operation','$res')";
    // $conn->exec($sql);

    //use prepare statement for security
    // prepare sql and bind parameters
    $stmt = $conn->prepare("INSERT INTO Calculator (num1,num2,operator,result) VALUES(:num1,:num2,:operation,:res)");
    //VALUES (:firstname, :lastname, :email)");
    $stmt->bindParam(':num1', $num1);
    $stmt->bindParam(':num2', $num2);
    $stmt->bindParam(':operation', $operation);
    $stmt->bindParam(':res', $res);
    $stmt->execute();
    //echo "New record created successfully";
} catch (PDOException $e) {
    //echo "failed: " . $e->getMessage();
}




//close the connection
$conn = null;
//echo("hello".$res);
$response['res'] = $dis;
// $response['randNum'] = $randNum;

$json_response = json_encode($response);
echo $json_response;
