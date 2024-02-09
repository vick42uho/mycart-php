<?php
session_start();
// echo '<pre>';
// print_r($_SESSION);
// echo '</pre>';

//checkLogin
include("connect.php");
if (@$_SESSION['m_name'] == '') {
    echo "<script type='text/javascript'>";
    echo "alert('กรุณา Login เพื่อสั่งซื้อสินค้า');";
    echo "window.location = 'shoppri/login.php'; ";
    echo "</script>";
}

$m_id = $_SESSION['m_id'];


$qmember = "SELECT m_id, m_fname, m_name, m_lname, m_address, m_email, m_phone 
FROM tbl_member 
WHERE m_id = $m_id";
$remember = mysqli_query($conn, $qmember) or die ("Error in mysqli_query: $qmember". mysqli_error($conn));
$rowmember = mysqli_fetch_array($remember);

// echo '<pre>';
// print_r($rowmember);
// echo '</pre>';
// exit;

?>

<?php include('header.php') ?>
<?php include('nav.php') ?>



<div class="container">
    <div class="row">
        <div class="col-12 col-sm-12 col-md-12">
            <h3>ตะกร้าสินค้า</h3>

            <form class="needs-validation" novalidate id="frmcart" name="frmcart" method="post" action="saveorder.php">
                <table class="table table-bordered table-hover table-striped">

                    <tr class='table-dark'>
                        <th width="5%">#</th>
                        <th width="10%">รูปภาพ</th>
                        <th width="55%">สินค้า</th>
                        <th width="10%" align="center">ราคา</th>
                        <th width="10%" align="center">จำนวน</th>
                        <th width="5%" align="center">รวม(บาท)</th>

                    </tr>
                    <?php
                    $total = 0;
                    if (!empty($_SESSION['cart'])) {

                        foreach ($_SESSION['cart'] as $p_id => $qty) {
                            $sql = "SELECT * FROM tbl_prd WHERE p_id=$p_id";
                            $query = mysqli_query($conn, $sql);
                            $row = mysqli_fetch_array($query);
                            $sum = $row['p_price'] * $qty; //ราคาสินค้า * จำนวน
                            $total += $sum; // ราคารวม
                            echo "<tr>";
                            echo "<td >" . @$i += 1 . "</td>";
                            echo "<td>" . "<img src='./shoppri/pimg/" . $row['p_img'] . "' width='100'>" . "</td>";
                            echo "<td >" . $row["p_name"] . "</td>";
                            echo "<td  align='left'>" . number_format($row["p_price"], 2) . "</td>";
                            echo "<td  align='right'>";
                            echo "<input type='number' name='amount[$p_id]' value='$qty' class='form-control' readonly /></td>";
                            echo "<td  align='right'>" . number_format($sum, 2) . "</td>";
                            echo "</tr>";
                        } //close foreach
                        echo "<tr>";
                        echo "<td colspan='5' class='table-dark' align='center'><b>ราคารวม</b></td>";
                        echo "<td align='right' class='table-dark'>" . "<b>" . number_format($total, 2) . "</b>" . "</td>";

                        echo "</tr>";
                    }

                    ?>

                </table>

                <h3>รายละเอียดที่อยู่สำหรับการจัดสั่ง</h3>




                <div class="container" style="background-color: #e6f7ff; border: 1px solid #b3d7ff; padding: 20px;">
                    <div class="form-row justify-content-center">
                        <div class="form-group col-md-6 mb-3">
                            <label for="validationCustom01">ชื่อ - นามสกุล</label>
                            <input type="text" class="form-control" id="m_name" name="m_name" value="<?php echo $rowmember['m_fname'].$rowmember['m_name'].' '.$rowmember['m_lname']; ?>" style="border: 1px solid #99c2ff;">
                            <div class="valid-feedback"></div>
                        </div>
                        <div class="form-group col-md-7 mb-3">
                            <label for="validationCustom02">ที่อยู่</label>
                            <textarea class="form-control" id="m_address" name="m_address" rows="3" style="border: 1px solid #99c2ff;"><?php echo $rowmember['m_address']; ?></textarea>
                            <div class="valid-feedback"></div>
                        </div>
                    </div>
                    <div class="form-row justify-content-center">
                        <div class="col-md-6 mb-3">
                            <label for="validationCustom03">Email</label>
                            <input type="email" class="form-control" id="m_email" name="m_email" value="<?php echo $rowmember['m_email']; ?>" style="border: 1px solid #99c2ff;">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationCustom04">Phone</label>
                            <input type="text" class="form-control" id="m_phone" name="m_phone" value="<?php echo $rowmember['m_phone']; ?>" style="border: 1px solid #99c2ff;">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="form-row justify-content-center">
                        <div class="col-md-6 mb-3">
                            <input type="hidden" name="m_id" value="<?php echo $m_id; ?>">
                            <input type="hidden" name="total" value="<?php echo $total ?>">
                            <button class="btn btn-primary" type="submit" style="border: 1px solid #007bff; background-color: #007bff;">สั่งซื้อสินค้า</button>
                        </div>
                    </div>
                </div>







            </form>
        </div>

    </div>

</div>

<?php include('footer.php') ?>


<script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
</script>