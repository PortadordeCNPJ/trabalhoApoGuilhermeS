<?php

session_start();

require "app/models/Connection.php";
require "vendor/autoload.php";

use app\models\connection;

$pdo = connection::connect();