<?php
    include '../inc/connect.php';
    if (isset($_POST['submit'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $sql = "SELECT * FROM users";
        $result = mysqli_query($con, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                if ($row['username'] === $username && md5($password) === $row['password']) {
                    $_SESSION['name'] = $row['name'];
                    $_SESSION['role'] = $row['role'];
                    $_SESSION['id'] = $row['id'];
                    header('Location: ../users/index.php');
                }
            }

            echo '<script>
                alert("Tài khoản / Mật khẩu không đúng, vui lòng thử lại");
                window.location.href = "../index.php";
            </script>';
        }
    }