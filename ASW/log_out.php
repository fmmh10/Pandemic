<?php
session_start(); //to ensure you are using same session
unset($_COOKIE['user']);
session_destroy(); //destroy the session
session_regenerate_id();
header('Location: /index.php');
?>
