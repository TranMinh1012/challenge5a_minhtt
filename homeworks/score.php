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
    $sql = "SELECT * FROM solutions WHERE id = {$id}";
    $result = mysqli_query($con, $sql);

    if (isset($_POST['submit'])) {
        $score = $_POST['score'];
        $sql = "UPDATE solutions SET score = {$score} WHERE id = {$id}";
        $status = mysqli_query($con, $sql);
        if ($status) {
            echo '<script>
                alert("Cập nhật thành công");
                window.location.href = "show.php?id=' . $_POST['homework_id'] . '";</script>';
        }
    }
?>
<h1 class="h3 mb-2 text-gray-800">Chấm điểm</h1>

<div class="row">
    <?php 
        if (mysqli_num_rows($result) > 0) {
            $solution = mysqli_fetch_assoc($result);
        }
    ?>
    <div class="col-lg-12">
        <form action="" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="homework_id" value="<?= $solution['homework_id'] ?>" />
            <div class="form-group">
                <label for="score">Điểm số: <span class="text-danger">*</span></label>
                <input type="text" class="form-control" placeholder="Nhập điểm số" id="score" name="score" value="<?= isset($solution) ? $solution['score'] : '' ?>" required>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Chấm điểm</button>
        </form>
    </div>
</div>
<?php include '../inc/footer.php'; ?>