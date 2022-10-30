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
    $sql = "SELECT * FROM users WHERE id = {$id}";
    $result = mysqli_query($con, $sql);
    $user = mysqli_fetch_assoc($result);

    $sqlMsg = "SELECT * FROM messages WHERE sender_id = {$_SESSION['id']} AND receiver_id = {$id} ORDER BY id DESC";
    $resultMsg = mysqli_query($con, $sqlMsg);

    if (isset($_POST['submit'])) {
        $message = $_POST['message'];
        $sql = "INSERT INTO messages (receiver_id, sender_id, msg) VALUES ({$id}, {$_SESSION['id']}, '{$message}')";

        mysqli_query($con, $sql);
        echo '<script>
            alert("Gửi thành công");
            window.location.href = "show.php?id=' . $id . '";</script>';
    }
?>
<h1 class="h3 mb-2 text-gray-800"><?= $user['name'] ?></h1>

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <tr>
                    <th>Ảnh đại diện</th>
                    <td><img src="../assets/avatars/<?= $user['avatar'] ?>" width="300"></td>
                </tr>
                <tr>
                    <th>Tài khoản</th>
                    <td><?= $user['username'] ?></td>
                </tr>
                <tr>
                    <th>Họ tên</th>
                    <td><?= $user['name'] ?></td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td><?= $user['email'] ?></td>
                </tr>
                <tr>
                    <th>Số điện thoại</th>
                    <td><?= $user['phone'] ?></td>
                </tr>
                <tr>
                    <th>Lời nhắn của tôi</th>
                    <td>
                        <?php if (mysqli_num_rows($resultMsg) > 0): ?>
                            <div style="overflow-y: auto;">
                                <table class="table table-bordered" width="100%" cellspacing="0">
                                    <tr>
                                        <th>Lời nhắn</th>
                                        <th>Ngày gửi</th>
                                        <th>Hành động</th>
                                    </tr>
                                    <?php while ($row = mysqli_fetch_assoc($resultMsg)): ?>
                                        <tr>
                                            <td><?= $row['msg'] ?></td>
                                            <?php $date = $row['created_at']; ?>
                                            <td><?= date('d/m/Y H:i:s', strtotime($date)) ?></td>
                                            <td>
                                                <a href="delete-msg.php?id=<?= $row['id']; ?>" onclick="return confirm('Bạn chắc chắn muốn xóa tin nhắn này không?');" class="btn btn-danger btn-circle btn-sm">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </table>
                            </div>
                        <?php else: ?>
                            Hiện tại chưa có lời nhắn nào
                        <?php endif; ?>
                    </td>
                </tr>
            </table>
        </div>
        <form action="" method="POST">
            <div class="form-group">
                <label for="message">Lời nhắn: <span class="text-danger">*</span></label>
                <textarea class="form-control" name="message" id="message" rows="3" cols="10"></textarea>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Gửi</button>
        </form>
    </div>
</div>
<?php include '../inc/footer.php'; ?>