<?php

    // Db credentials
    $host_name = "srv443.hstgr.io";
    $db_name = "u475920781_flood";
    $username = "u475920781_flood";
    $password = "flood4321A";

    // Connect to a databse (hostname, username, password and database name)
    $connection = mysqli_connect($host_name, $username, $password, $db_name);

    if(!$connection) {
        die("Connection failed : " . mysqli_connect_error());
    }
?>