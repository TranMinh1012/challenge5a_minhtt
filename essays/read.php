<?php
    $essay = fopen("../assets/essays/" . $_GET['essay'], "r") or die("Tập tin không thể mở");
    echo 'Nội dung của tập tin: ' . fread($essay, filesize("../assets/essays/" . $_GET['essay']));
    fclose($essay);