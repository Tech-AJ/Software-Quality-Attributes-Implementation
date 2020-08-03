<!DOCTYPE html>
<html>
<body >
<form action="" method="POST">
Number 1 -
<input type="number" name="num1"><br>
Number 2 -
<input type="number" name="num2"><br>
Calculate
<input type="submit" name="submit" value="Calculate"><br>


<?php
$host1 = 'http://localhost:8082'; //service 1
$host2= 'http://localhost:8083';  // service 2
$url=$host1+ '/index.php';



/* our simple php ping function */
function ping($host)
{
        exec(sprintf('ping -c 1 -W 5 %s', escapeshellarg($host)), $res, $rval);
        return $rval === 0;
}



$valid_response="HTTP/1.1 200 OK";

$ip_m1='172.17.0.3';   // found using docker container inspect command
$ip_m2='172.17.0.4';

$s1=(get_headers($host1)[0]==$valid_response);
$s2=(get_headers($host2)[0]==$valid_response);

$url=$host1.'/index.php';

if(!$s1){

       $url=$host2.'/index.php';
       $bv1 = ping($ip_m1); // vm 1
       if($bv1){

       echo nl2br ("\nBV1 ");
       echo '<img src="green.png" height="30" width="60"/>';
       echo"(VM1 is UP).";
       
       echo nl2br ("\nBVS1");
       echo '<img src="black.png" height="30" width="44"/>';
       echo("(S1 is down).");
       }
       else {
       echo nl2br ("\n BV1 ");
       echo '<img src="red.png" height="30" width="60"/>';
       echo"(VM1 is DOWN).";


       echo nl2br ("\n BVS1");
       echo '<img src="white.png" height="30" width="60"/>';
       echo ("(S1 is DOWN).");
       }

}else{
       echo nl2br ("\n BV1 ");
       echo '<img src="green.png" height="30" width="60"/>';
       echo "(VM1 is UP).";

       echo nl2br ("\n BVS1");
       echo '<img src="yellow.png" height="30" width="60"/>'; 
       echo ("(S1 is UP).");
     
     
}

if(!$s2){
       $bv2 = ping($ip_m2); // vm 2
       if($bv2){

       echo nl2br ("\nBV2 ");
       echo '<img src="green.png" height="30" width="60"/>';
       echo"(VM2 is UP).";
       
       echo nl2br ("\nBVS2");
       echo '<img src="black.png" height="30" width="44"/>';
       echo("(S2 is down).");
       }
       else {
              echo nl2br ("\n BV2 ");
       echo '<img src="red.png" height="30" width="60"/>';
       echo"(VM2 is DOWN).";


       echo nl2br ("\n BVS2");
       echo '<img src="white.png" height="30" width="60"/>';
       echo ("(S2 is DOWN).");
       }

}else{
       echo nl2br ("\n BV2 ");
       echo '<img src="green.png" height="30" width="60"/>';
       echo "(VM2 is UP).";

       echo nl2br ("\n BVS2");
       echo '<img src="yellow.png" height="30" width="60"/>'; 
       echo ("(S2 is UP).");
     
     
}



if((isset($_POST[num1]))&& (isset($_POST[num2])) )
{
   //latest state of s1 and s2 can be checked again here by simply using the above bulb code again.

       $num1= $_POST['num1'];
       $num2=$_POST['num2'];
     
       $data = array(
              'num1' => $num1,
              'num2' => $num2
          );
           
          $payload = json_encode($data);
     
       $client = curl_init($url);
       //set the content type to application/json
       curl_setopt($client, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
     
       curl_setopt($client,CURLOPT_RETURNTRANSFER,true);
      curl_setopt($client, CURLOPT_POSTFIELDS,$payload);
       
     
       $response = curl_exec($client);
     //  echo("res=".$response);
       $result = json_decode($response);

       $sum=$result->sum;
       $randNum= $result->randNum;
       echo nl2br ("\n Sum of $num1 , $num2 is ".$sum);
       echo nl2br ("\n Random number is ".$randNum);

}

?>  


</body>
</html>

