<?php
    session_start();
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $con = mysqli_connect("localhost", "root", "");
    mysqli_select_db($con, "qlsv");
    mysqli_query($con, "SET NAMES 'utf8'");