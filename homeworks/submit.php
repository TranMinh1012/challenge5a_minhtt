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
    $sql = "SELECT * FROM solutions WHERE student_id = {$_SESSION['id']} AND homework_id = {$id}";
    $result = mysqli_query($con, $sql);

    if (isset($_POST['submit'])) {
        $datetime = date("Y-m-d H:i:s");
        $fileSo = $_FILES['solution'];
        $so_name = date('Y_m_d_H_i_s') . $fileSo['name'];
        $tmp_name = $fileSo['tmp_name'];
        if (!move_uploaded_file($tmp_name, str_replace('\\', '/', dirname(__FILE__, 2)) . '/assets/solutions/' . $so_name)) {
            $so_name = '';
        }
        $sql = "INSERT INTO solutions (student_id, solution_file, submission_time, homework_id) 
        VALUES ({$_SESSION['id']}, '{$so_name}', '{$datetime}', {$id})";
        $status = mysqli_query($con, $sql);
        if ($status) {
            echo '<script>
                alert("Nộp bài thành công");
                window.location.href = "index.php";
            </script>';
        }
    }

    if (isset($_POST['update'])) {
        $datetime = date("Y-m-d H:i:s");
        $fileSo = $_FILES['solution'];
        $so_name = date('Y_m_d_H_i_s') . $fileSo['name'];
        $tmp_name = $fileSo['tmp_name'];
        if (!is_null($fileSo)) {
            $so_name = date('Y_m_d_H_i_s') . $fileSo['name'];
            $tmp_name = $fileSo['tmp_name'];
            if (move_uploaded_file($tmp_name, str_replace('\\', '/', dirname(__FILE__, 2)) . '/assets/solutions/' . $so_name)) {
                $sql = "UPDATE solutions SET solution_file = '{$so_name}', submission_time = '{$datetime}' WHERE student_id = {$_SESSION['id']} AND homework_id = {$id}";
            }
        }
        $status = mysqli_query($con, $sql);
        if ($status) {
            echo '<script>
                alert("Cập nhật thành công");
                window.location.href = "submit.php?id=' . $id . '";</script>';
        }
    }
?>
<h1 class="h3 mb-2 text-gray-800">Nộp bài tập</h1>

<div class="row">
    <div class="col-lg-12">
        <?php if (mysqli_num_rows($result) < 1): ?>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="solution">Bài làm: <span class="text-danger">*</span></label>
                    <input type="file" id="solution" name="solution" required>
                </div>
                <button type="submit" name="submit" class="btn btn-primary">Đăng tải</button>
            </form>
        <?php else: ?>
            <?php $solution = mysqli_fetch_assoc($result); ?>
            <form action="" method="POST" enctype="multipart/form-data">
                <?php if (is_null($solution['score'])): ?>
                    <div class="form-group">
                        <label for="solution">Bài làm: <span class="text-danger">*</span></label>
                        <input type="file" id="solution" name="solution" required>
                    </div>
                <?php endif; ?>
                <div class="d-block mb-3">
                    <span class="mr-1">Bài làm đã nộp:</span><a href="<?= '../assets/solutions/' . $solution['solution_file'] ?>" download><?= $solution['solution_file'] ?></a>
                </div>
                <?php if (is_null($solution['score'])): ?>
                    <button type="submit" name="update" class="btn btn-primary">Cập nhật</button>
                <?php else: ?>
                    <p class="text-danger">Điểm số: <?= $solution['score'] ?></p>
                <?php endif; ?>
            </form>
        <?php endif; ?>
    </div>
</div>
<?php include '../inc/footer.php'; ?>