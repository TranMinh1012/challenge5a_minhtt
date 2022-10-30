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
    $sql = "SELECT * FROM essays WHERE id = {$id}";
    $result = mysqli_query($con, $sql);
    $essay = mysqli_fetch_assoc($result);

    if (isset($_POST['submit'])) {
        $datetime = date("Y-m-d H:i:s");
        $answer = $_POST['answer'];
        if (strtolower($answer) == strtolower(basename($essay['essay'], ".txt"))) {
            $sql = "INSERT INTO answers (student_id, answer, essay_id, answer_time) 
            VALUES ({$_SESSION['id']}, '{$answer}', {$id}, '{$datetime}')";
            $status = mysqli_query($con, $sql);
            if ($status) {
                echo '<script>
                    alert("Trả lời đúng");
                    window.location.href = "index.php";
                </script>';
            }
        } else {
            echo '<script>
                alert("Trả lời sai, vui lòng thử lại");
                window.location.href = "submit.php?id=' . $id . '";
            </script>';
        }
    }
?>
<h1 class="h3 mb-2 text-gray-800">Trả lời</h1>

<div class="row">
    <div class="col-lg-12">
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="answer">Trả lời: <span class="text-danger">*</span></label>
                <input type="text" id="answer" name="answer" class="form-control" required>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Gửi</button>
        </form>
    </div>
</div>
<?php include '../inc/footer.php'; ?>