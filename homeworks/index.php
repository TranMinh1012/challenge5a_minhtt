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
    $sql = "SELECT a.*, b.name FROM homeworks a, users b WHERE a.teacher_id = b.id";
    
    if ($_SESSION['role'] == 0) {
        $sql .= " AND a.teacher_id = {$_SESSION['id']}";
    }

    $result = mysqli_query($con, $sql);

    function checkExistSolution($con ,$id)
    {
        $sql = "SELECT * FROM solutions WHERE homework_id = {$id}";
        $result = mysqli_query($con, $sql);
        if (mysqli_num_rows($result) > 0) {
            return false;
        }

        return true;
    }
?>
<h1 class="h3 mb-2 text-gray-800">Bài tập về nhà</h1>

<div class="card shadow mb-4">
    <?php if($_SESSION['role'] == 0): ?>
        <div class="card-header py-3">
            <a href="add.php" class="btn btn-sm btn-primary">Thêm mới</a>
        </div>
    <?php endif; ?>
    <div class="card-body">
        <div class="table-responsive">
            <!-- /.col-lg-12 -->
            <table class="table table-bordered" id="dataTables-example" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th width="100">Tiêu đề</th>
                        <th>Tập tin</th>
                        <th>Ngày giao</th>
                        <?php if ($_SESSION['role'] == 1): ?>
                            <th>Người giao</th>
                        <?php endif; ?>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Tiêu đề</th>
                        <th>Tập tin</th>
                        <th>Ngày giao</th>
                        <?php if ($_SESSION['role'] == 1): ?>
                            <th>Người giao</th>
                        <?php endif; ?>
                        <th>Hành động</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php $count = 1;
                    while ($homework = mysqli_fetch_assoc($result)) : ?>
                        <tr>
                            <td><?= $count ?></td>
                            <td><?= $homework['title'] ?></td>
                            <td><a href="<?= '../assets/homeworks/' . $homework['homework_file'] ?>" download><?= basename($homework['homework_file']); ?></a></td>
                            <td><?= date('d/m/Y H:i:s', strtotime($homework['assignment_time'])); ?></td>
                            <?php if ($_SESSION['role'] == 1): ?>
                                <td><?= $homework['name'] ?></td>
                            <?php endif; ?>
                            <td>
                                <?php if($_SESSION['role'] == 0): ?>
                                    <?php if (checkExistSolution($con, $homework['id'])): ?>
                                        <a href="edit.php?id=<?= $homework['id']; ?>" class="btn btn-primary btn-circle btn-sm">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                    <?php endif; ?>
                                    <a href="delete.php?id=<?= $homework['id']; ?>" onclick="return confirm('Bạn chắc chắn muốn xóa bài tập này không?');" class="btn btn-danger btn-circle btn-sm">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                    <a href="show.php?id=<?= $homework['id']; ?>" class="btn btn-warning btn-circle btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                <?php else: ?>
                                    <a href="submit.php?id=<?= $homework['id']; ?>" class="btn btn-success btn-circle btn-sm">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                <?php endif; ?>
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