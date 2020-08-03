 <?php

       $host2 = 'http://localhost:32001';     //service 2



       if (isset($_POST['action'])) {
              //echo ($_POST['action']);
              switch ($_POST['action']) {
                     case 'Add':
                            calculate(1);
                            break;
                     case 'Subtract':
                            calculate(2);
                            break;
                     case 'Multiply':
                            calculate(3);
                            break;
                     case 'Divide':
                            calculate(4);
                            break;
                     case 'Sin':
                            calculate(5);
                            break;
                     case 'Cos':
                            calculate(6);
                            break;
                     case 'Tan':
                            calculate(7);
                            break;
                     case 'Concatenate':
                            stringOperation(1);
                            break;
                     case 'Reverse':
                            stringOperation(2);
                            break;
                     case 'StringLength':
                            stringOperation(3);
                            break;
                     case 'WordCount':
                            stringOperation(4);
                            break;
              }
       }


       function calculate($operation)
       {

              $host1 = 'http://localhost:8081';   // service 1
              $url = $host1 . '/index.php';

              //echo ($operation);

              $num1 = $_POST['num1'];
              $num2 = $_POST['num2'];
              //echo ("num1" . $num1);

              $data = array(
                     'num1' => $num1,
                     'num2' => $num2,
                     'operation' => $operation
              );

              $payload = json_encode($data);

              $client = curl_init();
              //echo ("client=" . $client);
              // set URL and other appropriate options
              curl_setopt($client, CURLOPT_URL, 'http://php-app1?index.php');
              //echo ("url=" . $url);
              //echo ("client=" . $client);
              //set the content type to application/json
              curl_setopt($client, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

              curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
              curl_setopt($client, CURLOPT_POSTFIELDS, $payload);
              curl_setopt($client, CURLOPT_RETURNTRANSFER, 1);

              //echo ("client=" . $client);
              $response = curl_exec($client);
              //   echo ("res=" . $response);
              if ($response === FALSE) {
                     die(curl_error($client));
              }
              // echo ("res=" . $response);
              $result = json_decode($response);

              $res = $result->res;
              //echo("resonse ".$response);

              echo nl2br(" Result is " . $res);
       }


       function stringOperation($operation)
       {

              $str1 = $_POST['str1'];
              $str2 = $_POST['str2'];
              //echo ("num1" . $num1);

              $data = array(
                     'str1' => $str1,
                     'str2' => $str2,
                     'operation' => $operation
              );

              $payload = json_encode($data);

              $client = curl_init();
              //echo ("client=" . $client);
              // set URL and other appropriate options
              curl_setopt($client, CURLOPT_URL, 'http://php-app2?index.php');
              //echo ("url=" . $url);
              //echo ("client=" . $client);
              //set the content type to application/json
              curl_setopt($client, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

              curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
              curl_setopt($client, CURLOPT_POSTFIELDS, $payload);
              curl_setopt($client, CURLOPT_RETURNTRANSFER, 1);

              //echo ("client=" . $client);
              $response = curl_exec($client);
              //   echo ("res=" . $response);
              if ($response === FALSE) {
                     die(curl_error($client));
              }
             // echo ("res=" . $response);
              $result = json_decode($response);

              $res = $result->res;
              //echo("resonse ".$response);

              echo nl2br(" Result is " . $res);
       }




       ?>

