<?php
session_start();
session_destroy();
header('Location: ../pages/adm/login.php');
exit;
