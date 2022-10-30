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

    $sql = "SELECT * FROM users WHERE id <> {$_SESSION['id']}";
    $result = mysqli_query($con, $sql);
?>
<h1 class="h3 mb-2 text-gray-800">Người dùng</h1>

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
                        <th>Tài khoản</th>
                        <th>Họ tên</th>
                        <th>Email</th>
                        <th>Số điện thoại</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Tài khoản</th>
                        <th>Họ tên</th>
                        <th>Email</th>
                        <th>Số điện thoại</th>
                        <th>Hành động</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php $count = 1;
                    while ($user = mysqli_fetch_assoc($result)) : ?>
                        <tr>
                            <td><?= $count ?></td>
                            <td><?= $user['username']; ?></td>
                            <td><?= $user['name']; ?></td>
                            <td><?= $user['email']; ?></td>
                            <td><?= $user['phone']; ?></td>
                            <td>
                                <?php if($_SESSION['role'] == 0 && $user['role'] != 0): ?>
                                    <a href="edit.php?id=<?= $user['id']; ?>" class="btn btn-primary btn-circle btn-sm">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <a href="delete.php?id=<?= $user['id']; ?>" onclick="return confirm('Bạn chắc chắn muốn xóa người dùng này không?');" class="btn btn-danger btn-circle btn-sm">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                <?php endif; ?>
                                <a href="show.php?id=<?= $user['id']; ?>" class="btn btn-warning btn-circle btn-sm">
                                    <i class="fas fa-eye"></i>
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