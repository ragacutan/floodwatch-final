<?php
header("Access-Control-Allow-Origin: *");

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../src/vendor/autoload.php';

$app = new \Slim\App;

//Endpoint postName
$app->post('/postUser', function (Request $request, Response $response, array $args) {
    $data=json_decode($request->getBody());

    $name =$data->name;
    $email =$data->email;
    $password =$data->password;
    $address =$data->address ;
    $contactNumber =$data->contactNumber;
    $user_type =$data->user_type;

    //Database
    $servername = "srv443.hstgr.io";
    $username = "u475920781_flood";
    $dbpassword = "flood4321A";
    $dbname = "u475920781_flood";
    try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $dbpassword);
    
    // set the PDO error mode ato exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "INSERT INTO users (name, email, password, address, user_type)
    VALUES ('". $name ."','". $email ."','". $password ."','". $address ."','". $user_type ."')";
    // use exec() because no results are returned

    $conn->exec($sql);
    $response->getBody()->write(json_encode(array("status"=>"success","data"=>null)));
    
    } catch(PDOException $e){
    $response->getBody()->write(json_encode(array("status"=>"error",
    "message"=>$e->getMessage())));
    }
    $conn = null;

});

//Endpoint printName
$app->post('/printName', function (Request $request, Response $response, array $args) {
    $data=json_decode($request->getBody());

    //Database
    $servername = "srv443.hstgr.io";
    $username = "u475920781_flood";
    $dbpassword = "flood4321A";
    $dbname = "u475920781_flood";
    // Create connection
    $conn = new mysqli($servername, $username, $dbpassword, $dbname);
    // Check connection
    if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM users";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
    $data=array();
    while($row = $result->fetch_assoc()) {
    array_push($data,array("name"=>$row["name"],"email"=>$row["email"],"addresss"=>$row["address"], "contactNumber"=>$row["contactNumber"] ));
    }

    $data_body=array("status"=>"success","data"=>$data);
    $response->getBody()->write(json_encode($data_body));
    } else {
    $response->getBody()->write(json_encode(array("status"=>"success","data"=>null)));
    }
    $conn->close();

});

//Endpoint updateName
$app->post('/updateName', function (Request $request, Response $response, array $args) {
    $data=json_decode($request->getBody());

    $id =$data->id;
    $fname =$data->fname ;
    $lname =$data->lname ;
    //Database
    $servername = "srv443.hstgr.io";
    $username = "u475920781_flood";
    $dbpassword = "flood4321A";
    $dbname = "u475920781_flood";
    try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "UPDATE names SET fname = '". $fname ."', lname = '". $lname ."' WHERE id = $id";
    // use exec() because no results are returned

    $conn->exec($sql);
    $response->getBody()->write(json_encode(array("status"=>"success","data"=>null)));
    
    } catch(PDOException $e){
    $response->getBody()->write(json_encode(array("status"=>"error",
    "message"=>$e->getMessage())));
    }
    $conn = null;

});

//endpoint deleteName
$app->post('/deleteUser', function (Request $request, Response $response, array $args) {
    $data=json_decode($request->getBody());

    $id =$data->id ;

    //Database
    $servername = "localhost";
    $servername = "srv443.hstgr.io";
    $username = "u475920781_flood";
    $dbpassword = "flood4321A";
    $dbname = "u475920781_flood";
    try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "DELETE FROM users WHERE id = $id";
    // use exec() because no results are returned

    $conn->exec($sql);
    $response->getBody()->write(json_encode(array("status"=>"success","data"=>null)));
    
    } catch(PDOException $e){
    $response->getBody()->write(json_encode(array("status"=>"error",
    "message"=>$e->getMessage())));
    }
    $conn = null;

});



$app->run();

?>
