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

    $sql = "SELECT a.*, b.name FROM essays a, users b WHERE a.teacher_id = b.id";
    
    if ($_SESSION['role'] == 0) {
        $sql .= " AND a.teacher_id = {$_SESSION['id']}";
    }

    $result = mysqli_query($con, $sql);

    function checkExistAnswer($con, $id)
    {
        $sql = "SELECT * FROM answers WHERE essay_id = {$id} AND student_id = {$_SESSION['id']}";
        $result = mysqli_query($con, $sql);
        if (mysqli_num_rows($result) > 0) {
            return false;
        }

        return true;
    }
?>
<h1 class="h3 mb-2 text-gray-800">Trò chơi giải đố</h1>

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
                        <th>Gợi ý</th>
                        <?php if ($_SESSION['role'] == 0): ?>
                            <th>Tập tin</th>
                        <?php endif; ?>
                        <th>Ngày giao</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Gợi ý</th>
                        <?php if ($_SESSION['role'] == 0): ?>
                            <th>Tập tin</th>
                        <?php endif; ?>
                        <th>Ngày giao</th>
                        <th>Hành động</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php $count = 1;
                    while ($essay = mysqli_fetch_assoc($result)) : ?>
                        <tr>
                            <td><?= $count ?></td>
                            <td><?= $essay['tip'] ?></td>
                            <?php if ($_SESSION['role'] == 0): ?>
                                <td><a href="<?= '../assets/essays/' . $essay['essay'] ?>" download><?= basename($essay['essay']); ?></a></td>
                            <?php endif; ?>
                            <td><?= date('d/m/Y H:i:s', strtotime($essay['assignment_time'])); ?></td>
                            <td>
                                <?php if($_SESSION['role'] == 0): ?>
                                    <a href="edit.php?id=<?= $essay['id']; ?>" class="btn btn-primary btn-circle btn-sm">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <a href="delete.php?id=<?= $essay['id']; ?>" onclick="return confirm('Bạn chắc chắn muốn xóa bài tập này không?');" class="btn btn-danger btn-circle btn-sm">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                <?php else: ?>
                                    <?php if (checkExistAnswer($con, $essay['id'])): ?>
                                        <a href="submit.php?id=<?= $essay['id']; ?>" class="btn btn-success btn-circle btn-sm">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                    <?php else: ?>
                                        <a href="read.php?essay=<?= $essay['essay']; ?>" class="btn btn-warning btn-circle btn-sm" target="_blank">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    <?php endif; ?>
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