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

    if (isset($_POST['submit'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $phone = $_POST['phone'];
        if ($user['password'] === $_POST['password']) {
            $password = $_POST['password'];
        } else {
            $password = md5($_POST['password']);
        }
        $fileImg = $_FILES['image'];
        $img_name = date('Y_m_d_H_i_s') . $fileImg['name'];
        $tmp_name = $fileImg['tmp_name'];
        $sql = "UPDATE users SET name = '{$name}', 
        username = '{$username}', phone = '{$phone}', email = '{$email}', password = '{$password}'";
        if (move_uploaded_file($tmp_name, str_replace('\\', '/', dirname(__FILE__, 2)) . '/assets/avatars/' . $img_name)) {
            $sql .= ", avatar = '{$img_name}'";
        }
        $sql .= "  WHERE id = {$id}";
        $status = mysqli_query($con, $sql);
        if ($status) {
            echo '<script>
                alert("Cập nhật thành công");
                window.location.href = "index.php";
            </script>';
        }
    }
?>
<h1 class="h3 mb-2 text-gray-800">Cập nhật người dùng</h1>

<div class="row">
    <div class="col-lg-12">
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="username">Tài khoản: <span class="text-danger">*</span></label>
                <input type="text" class="form-control" placeholder="Nhập tài khoản" id="username" name="username" value="<?= $user['username'] ?>" required>
            </div>
            <div class="form-group">
                <label for="name">Họ tên: <span class="text-danger">*</span></label>
                <input type="text" class="form-control" placeholder="Nhập họ tên" id="name" name="name" value="<?= $user['name'] ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email: <span class="text-danger">*</span></label>
                <input type="email" class="form-control" placeholder="Nhập email" id="email" name="email" value="<?= $user['email'] ?>" required>
            </div>
            <div class="form-group">
                <label for="password">Mật khẩu: <span class="text-danger">*</span></label>
                <input type="password" class="form-control" placeholder="Nhập mật khẩu" id="password" name="password" value="<?= $user['password'] ?>" required>
            </div>
            <div class="form-group">
                <label for="phone">Số điện thoại: <span class="text-danger">*</span></label>
                <input type="tel" class="form-control" placeholder="Nhập số điện thoại" id="phone" name="phone" pattern="[0-9]{10}" value="<?= $user['phone'] ?>" required>
            </div>
            <div class="form-group">
                <label for="image">Ảnh đại diện: <span class="text-danger">*</span></label>
                <div class="custom-file">
                    <input type="file" id="image" name="image" accept=".png,.gif,.jpg,.jpeg" />
                </div>
            </div>
            <div class="image-preview mb-4" id="imagePreview">
                <img src="<?= isset($user['id']) ? '../assets/avatars/' . $user['avatar'] : ''; ?>" alt="Image Preview" class="image-preview__image" style="<?= isset($user['id']) ? 'display:block;' : '' ?>" />
                <span class="image-preview__default-text" style="<?= isset($user['id']) ? 'display:none;' : '' ?>">Hình ảnh</span>
            </div>
            <br />
            <button type="submit" name="submit" class="btn btn-primary">Cập nhật</button>
          </form>
    </div>
</div>
<?php include '../inc/footer.php'; ?>