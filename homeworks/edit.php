<?php 
    include '../inc/header.php';
    if (isset($_SESSION['role'])) {
        $users = [];
    } else {
        echo '<script>
            alert("Xin vui lòng đăng nhập");
            window.location.href = "../index.php";
        </script>';
    }

    $id = $_GET['id'];
    $sql = "SELECT * FROM homeworks WHERE id = {$id}";
    $result = mysqli_query($con, $sql);
    $homework = mysqli_fetch_assoc($result);

    if (isset($_POST['submit'])) {
        $datetime = date("Y-m-d H:i:s");
        $title = $_POST['title'];
        $fileHw = $_FILES['homework'];
        $sql = "UPDATE homeworks SET title = '{$title}'";
        if (!is_null($fileHw)) {
            $hw_name = date('Y_m_d_H_i_s') . $fileHw['name'];
            $tmp_name = $fileHw['tmp_name'];
            if (move_uploaded_file($tmp_name, str_replace('\\', '/', dirname(__FILE__, 2)) . '/assets/homeworks/' . $hw_name)) {
                $sql .= ", homework_file = '{$hw_name}'";
            }
        }
        $sql .= " WHERE id = {$id}";
        $status = mysqli_query($con, $sql);
        if ($status) {
            echo '<script>
                alert("Cập nhật thành công");
                window.location.href = "index.php";
            </script>';
        }
    }
?>
<h1 class="h3 mb-2 text-gray-800">Cập nhật bài tập về nhà</h1>

<div class="row">
    <div class="col-lg-12">
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Tiêu đề: <span class="text-danger">*</span></label>
                <input type="text" class="form-control" placeholder="Nhập tiêu đề" id="title" name="title" value="<?= $homework['title'] ?>" required>
            </div>
            <div class="form-group">
                <label for="homework">Tập tin:</label>
                <input type="file" id="homework" name="homework">
            </div>
            <div class="d-block mb-3">
                <span class="mr-1">Bài tập đã giao:</span><a href="<?= '../assets/homeworks/' . $homework['homework_file'] ?>" download><?= $homework['homework_file'] ?></a>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Cập nhật</button>
          </form>
    </div>
</div>
<?php include '../inc/footer.php'; ?>