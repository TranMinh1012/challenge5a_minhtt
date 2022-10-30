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

    function vn_to_str ($str){
        $unicode = array(
         
        'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
         
        'd'=>'đ',
         
        'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
         
        'i'=>'í|ì|ỉ|ĩ|ị',
         
        'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
         
        'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
         
        'y'=>'ý|ỳ|ỷ|ỹ|ỵ',
         
        'A'=>'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
         
        'D'=>'Đ',
         
        'E'=>'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
         
        'I'=>'Í|Ì|Ỉ|Ĩ|Ị',
         
        'O'=>'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
         
        'U'=>'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
         
        'Y'=>'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
         
        );
         
        foreach($unicode as $nonUnicode=>$uni){
         
            $str = preg_replace("/($uni)/i", $nonUnicode, $str);
         
        }

        $str = str_replace(' ','_',$str);
         
        return $str;
         
    }

    if (isset($_POST['submit'])) {
        $tip = $_POST['tip'];
        $fileE = $_FILES['essay'];
        $sql = "UPDATE essays SET tip = '{$tip}'";
        if (!is_null($fileE)) {
            $e_name = str_replace("_", " ", vn_to_str($fileE['name']));
            $tmp_name = $fileE['tmp_name'];
            if (move_uploaded_file($tmp_name, str_replace('\\', '/', dirname(__FILE__, 2)) . '/assets/essays/' . $e_name)) {
                $sql .= ", essay = '{$e_name}'";
            }
        }
        $sql .= " WHERE id = {$id}";
        $status = mysqli_query($con, $sql);
        if ($status) {
            echo '<script>
                alert("Cập nhật thành công");
                window.location.href = "index.php";
            </script>';
        }
    }
?>
<h1 class="h3 mb-2 text-gray-800">Cập nhật</h1>

<div class="row">
    <div class="col-lg-12">
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="tip">Gợi ý: <span class="text-danger">*</span></label>
                <textarea class="form-control" name="tip" id="tip" rows="3" cols="10" required><?= $essay['tip'] ?></textarea>
            </div>
            <div class="form-group">
                <label for="essay">Tập tin:</label>
                <input type="file" id="essay" name="essay" required>
            </div>
            <div class="d-block mb-3">
                <span class="mr-1">Câu đố đã giao:</span><a href="<?= '../assets/essays/' . $essay['essay'] ?>" download><?= $essay['essay'] ?></a>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Cập nhật</button>
          </form>
    </div>
</div>
<?php include '../inc/footer.php'; ?>