<?php

  $servername = 'localhost';
  $username = 'root';
  $password = '';
  $database = 'inviia_ccp';

  // Create connection
  $db = new mysqli($servername, $username, $password, $database);

  // Check connection
  if ($db->connect_error) {
    die();
  }
?>
