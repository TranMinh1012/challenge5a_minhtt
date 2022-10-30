<?php
    include '../inc/connect.php';
    if (isset($_SESSION['role'])) {
        $id = $_GET['id'];
        $sql = "DELETE FROM messages WHERE id = {$id}";
        mysqli_query($con, $sql);
        echo '<script>
            alert("Xóa thành công");
            history.back();
        </script>';
    } else {
        echo '<script>
            alert("Xin vui lòng đăng nhập");
            window.location.href = "../index.php";
        </script>';
    }