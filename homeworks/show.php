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

    $sql = "SELECT a.*, b.name FROM solutions a, users b WHERE a.student_id = b.id AND a.homework_id = {$_GET['id']}";
    $result = mysqli_query($con, $sql);
?>
<h1 class="h3 mb-2 text-gray-800">Bài làm</h1>

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <!-- /.col-lg-12 -->
            <table class="table table-bordered" id="dataTables-example" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Người nộp</th>
                        <th>Bài làm</th>
                        <th>Ngày nộp</th>
                        <th>Điểm số</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Người nộp</th>
                        <th>Bài làm</th>
                        <th>Ngày nộp</th>
                        <th>Điểm số</th>
                        <th>Hành động</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php $count = 1;
                    while ($solution = mysqli_fetch_assoc($result)) : ?>
                        <tr>
                            <td><?= $count ?></td>
                            <td><?= $solution['name'] ?></td>
                            <td><a href="<?= '../assets/solutions/' . $solution['solution_file'] ?>" download><?= basename($solution['solution_file']); ?></a></td>
                            <td><?= date('d/m/Y H:i:s', strtotime($solution['submission_time'])); ?></td>
                            <td><?= $solution['score'] ?? 'Chưa chấm điểm' ?></td>
                            <td>
                                <a href="score.php?id=<?= $solution['id']; ?>" class="btn btn-success btn-circle btn-sm">
                                    <i class="fas fa-pen"></i>
                                </a>
                            </td>
                        </tr>
                        <?php $count++; ?>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<?php include '../inc/footer.php'; ?>