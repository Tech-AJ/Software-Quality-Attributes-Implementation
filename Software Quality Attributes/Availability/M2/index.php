<?php 

$data = json_decode(file_get_contents('php://input'));

 $num1=$data->num1;
 $num2=$data->num2;

$sum=$num1+$num2;
$randNum=(rand(70, 100));
$response['sum']=$sum;
$response['randNum']=$randNum;
 
 $json_response = json_encode($response);
 echo $json_response;
  
?>