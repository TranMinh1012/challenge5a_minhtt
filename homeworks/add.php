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

    if (isset($_POST['submit'])) {
        $title = $_POST['title'];
        $datetime = date("Y-m-d H:i:s");
        $fileHw = $_FILES['homework'];
        $hw_name = date('Y_m_d_H_i_s') . $fileHw['name'];
        $tmp_name = $fileHw['tmp_name'];
        if (!move_uploaded_file($tmp_name, str_replace('\\', '/', dirname(__FILE__, 2)) . '/assets/homeworks/' . $hw_name)) {
            $hw_name = '';
        }
        $sql = "INSERT INTO homeworks (title, homework_file, assignment_time, teacher_id) 
        VALUES ('{$title}', '{$hw_name}', '{$datetime}', {$_SESSION['id']})";
        $status = mysqli_query($con, $sql);
        if ($status) {
            echo '<script>
                alert("Thêm thành công");
                window.location.href = "index.php";
            </script>';
        }
    }
?>
<h1 class="h3 mb-2 text-gray-800">Thêm bài tập về nhà</h1>

<div class="row">
    <div class="col-lg-12">
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Tiêu đề: <span class="text-danger">*</span></label>
                <input type="text" class="form-control" placeholder="Nhập tiêu đề" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="homework">Tập tin: <span class="text-danger">*</span></label>
                <input type="file" id="homework" name="homework" required>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Thêm</button>
          </form>
    </div>
</div>
<?php include '../inc/footer.php'; ?>