<?php
require "./require/common.php";
session_start();
session_unset();
session_destroy();
header("Location: http://localhost/GYM/login.php");
