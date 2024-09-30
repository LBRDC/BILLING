<?php
session_start();
// Check if the session variable 'user' is set
if (!isset($_SESSION['user'])) {
    $res = array("res" => "invalid");
    echo json_encode($res);
} else {
    $res = array("res" => "valid");
    echo json_encode($res);
}