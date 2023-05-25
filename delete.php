<?php
session_start();
require 'config.php';

$cartCollection->deleteOne(['_id' => new MongoDB\BSON\ObjectId(($_GET['idtrash']))]);
    header("Location: cart.php");
?>