<?php                  
require_once 'connect.php';
// $sql1="SELECT FORMAT(dsp_dongia, '#,##0.00') AS 'dongsanpham_dongia'
// FROM dongsanpham";
// $sql = "SELECT dsp_id, 
//                 dsp_ten, 
//                 dsp_img, 
//                 h_ten, 
//                 lsp_ten,
//                 dmsp_ten,
//                 FORMAT(dsp_dongia, '#.##0.00') AS 'dsp_dongia', 
//                 FORMAT(dsp_khuyenmai, '#.##0.00') AS 'dsp_khuyenmai', 
//                 FORMAT(dsp_soluong, '#.##0.00') AS 'dsp_soluong', 
//                 dsp_thongsokythuat, 
//                 dsp_diengiai
//         FROM dongsanpham, hang, loaisanpham, danhmucsanpham
//         where hang.h_id=dongsanpham.h_id and 
//                 dongsanpham.lsp_id=loaisanpham.lsp_id and 
//                 loaisanpham.dmsp_id=danhmucsanpham.dmsp_id ORDER BY dsp_id DESC";
// $query = mysqli_query($conn, $sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AdminCP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="icon" href="./img/logo.png">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.tiny.cloud/1/a8v6p04mic23cdf31ofgu037g6bhr3gvxuj0n363hmuzjb58/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
        selector: 'textarea',
        plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
        });
    </script>
    <style>
        .menu div {
            height: 50px;
            width: auto;

        }
        .show-info {
            border:2px solid #ccc;
        }
        .container {
            max-width:90%;
        }
        body {
            /* background: url("../public/img/bg-admin3.jpg"); */
            background: url("../anh/back.jpg");
        }
    </style>
</head>
<body>
    <div class="container mt-3  ">
        <!-- <h2>Welcome <?php echo $_COOKIE['nv_tendangnhap'];  ?> to AdminCP!</h2>
        <hr width="80%" color="dark"> -->

        <?php if (isset($_SESSION['success_message'])): ?>
                <div id="notification"><?= $_SESSION['success_message'] ?></div>
                <?php unset($_SESSION['success_message']); ?>
        <?php endif; ?>
        <div class="row back">
            
            <div class="col-md-10 show-info">
                <!-- <div class="row " >
                    <h3 class="mt-3 mb-2">Quản lý sản phẩm</h3>
                </div> -->

                <?php
        //include 'connect.php';
        $sql = "SELECT * FROM hang";
        // $result = $conn->query($sql);
        $sql1 = "SELECT * FROM loaisanpham";
        // $result1 = $conn->query($sql1);
    ?>
    <div class="container-fluid ">
        <div class="card-header">
            <h1>Add New Product</h1>
        </div>
        <div class="card-body">
        <form method="POST" action="" enctype="multipart/form-data">
            <div class="form-group">
                <label for="h_id" >Hãng:</label>
                <select name="h_id" id="h_id" class='form-control' style="width: 400px;">
                    <?php
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<option  value='" . $row["h_id"] . "'>" . $row["h_ten"] . "</option> ";
                        }
                    } else {
                        echo "Không tim thấy Hãng nào!!!";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="lsp_id">Loại sản phẩm:</label>
                    <select name="lsp_id" id="lsp_id" class='form-control' style="width: 400px;">
                        <?php
                        if ($result1->num_rows > 0) {
                            while($row = $result1->fetch_assoc()) {
                                echo "<option value='" . $row["lsp_id"] . "'>" . $row["lsp_ten"] . "</option>";
                            }
                        } else {
                            echo "Không tim thấy Hãng nào!!!";
                        }
                        ?>
                    </select>
            </div>

            <div class="form-group">
                <label for="dsp_ten">Tên dòng sản phẩm:</label>
                <input type="text" id="dsp_ten" name="dsp_ten" class="form-control" style="width: 400px;" >
            </div>

            <div class="form-group">
                <label for="image">Ảnh đại diện sản phẩm:</label><br>
                <input type="hidden" name="size" value="1000000"> 
                <input type="file" name="image" class="form-control" style="width: 400px;" >
            </div>

            <div class="form-group">
                <label for="dsp_dongia">Đơn giá:</label>
                <input type="number" id="dsp_dongia" name="dsp_dongia" class="form-control" style="width: 400px;" >
            </div>

            <div class="form-group">
                <label for="dsp_khuyenmai">Giá khuyến mãi:</label>
                <input type="number" id="dsp_khuyenmai" name="dsp_khuyenmai" class="form-control" style="width: 400px;" >
            </div>

            <div class="form-group">
                <label for="dsp_soluong">Số lượng:</label>
                <input type="number" id="dsp_soluong" name="dsp_soluong" class="form-control" style="width: 400px;" >
            </div>

            <div class="">
                <label for="dsp_thongsokythuat">Thông số kỹ thuật:</label>
                <textarea id="dsp_thongsokythuat" name="dsp_thongsokythuat" class="form-control" ></textarea>
            </div><br>

            <div class="">
                <label for="dsp_diengiai">Diễn giải:</label>
                <textarea id="dsp_diengiai" name="dsp_diengiai" class="" ></textarea>
            </div><br>
            <div class="form-group ">
                <button class="btn btn-primary"  type="submit" name="upload" id="upload" style="border-radius: 10px; border 1px solid black">Lưu thông tin</button>
            </div>

        <style>
            body{
                color:white;
                font-size: 15px;
                /* background: rgba(0,0,0,.5); */
                box-sizing: border-box;
                box-shadow: 0 15px 25px rgba(0,0,0,.6);
                /* background: linear-gradient(#141e30, #243b55); */
                background: url("anh/back.jpg");
            }
            .form-control{
                border: 2px solid black;
            }
            .back{
                background-color: #182539;
            }
            h1{
                
                text-align: center;
                /* color:#0063D1; */
                
                
            }

            #upload{
                padding-left: 50px;
                padding-right: 50px;
                text-align: center;
            }

        </style>
    </form>
                
            </div>

        </div>
        <button style="border:none;"id="scrollToTopButton" onclick="scrollToTop()"><i class="fa-solid fa-up-long fa-xl" style="color: #13130b;width:40px; height:20px;"></i></button>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        const notification = $('#notification');
        notification.show();

      setTimeout(function () {
          notification.hide();
      }, 2200);
    </script>



</body>
</html>

<?php
    //include 'connect.php';
        if (isset($_POST['upload'])) {
        $errors= array();
        $file_name = $_FILES['image']['name'];
        $file_size = $_FILES['image']['size'];
        $file_tmp = $_FILES['image']['tmp_name'];
        $file_type = $_FILES['image']['type'];
        $file_parts =explode('.',$_FILES['image']['name']);
        $file_ext=strtolower(end($file_parts));
        $expensions= array("jpeg","jpg","png");
        if(in_array($file_ext,$expensions)=== false){
            $errors[]="Chỉ hỗ trợ upload file JPEG hoặc PNG.";
        }
        if($file_size > 52428800) {
            $errors[]='Kích thước file không được lớn hơn 50Mb';
            
        }
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $dsp_ten = $_POST["dsp_ten"];
            $dsp_dongia = $_POST['dsp_dongia'];
            $dsp_khuyenmai = $_POST['dsp_khuyenmai'];
            $dsp_soluong =$_POST['dsp_soluong'];
            $dsp_thongsokythuat =$_POST['dsp_thongsokythuat'];
            $dsp_diengiai = $_POST['dsp_diengiai'];
            $h_id =$_POST['h_id'];
            $lsp_id =$_POST['lsp_id'];
            $image = $_FILES['image']['name'];
            $target = "photo/".basename($image);
            $sql_themdsp ="INSERT INTO `dongsanpham` (`dsp_id`, `h_id`, `lsp_id`, `dsp_ten`, `dsp_dongia`, `dsp_khuyenmai`, `dsp_soluong`, `dsp_ngaytao`, `dsp_ngaycapnhat`, `dsp_img`, `dsp_thongsokythuat`, `dsp_diengiai`) 
                                         VALUES (NULL, '$h_id', '$lsp_id', '$dsp_ten', '$dsp_dongia', '$dsp_khuyenmai', '$dsp_soluong', current_timestamp(), current_timestamp(), '$image', '$dsp_thongsokythuat', '$dsp_diengiai')";
            mysqli_query($conn, $sql_themdsp);
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                echo '<script language="javascript">alert("Đã upload thành công!");</script>';
            }else{
                echo '<script language="javascript">alert("Đã upload thất bại!");</script>';
            }
        }
    }
?>

