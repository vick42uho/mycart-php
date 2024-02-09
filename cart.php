<?php
session_start();

//checkLogin
if (@$_SESSION['m_name'] == '') {
    echo "<script type='text/javascript'>";
    echo "alert('กรุณา Login เพื่อสั่งซื้อสินค้า');";
    echo "window.location = 'shoppri/login.php'; ";
    echo "</script>";
}
include('connect.php');
$p_id = mysqli_real_escape_string($conn, $_GET['p_id']);
$act = mysqli_real_escape_string($conn, $_GET['act']);

//add to cart
if ($act == 'add' && !empty($p_id)) {
    if (isset($_SESSION['cart'][$p_id])) {
        $_SESSION['cart'][$p_id]++;
    } else {
        $_SESSION['cart'][$p_id] = 1;
    }
}

if ($act == 'remove' && !empty($p_id))  //ยกเลิกการสั่งซื้อ
{
    unset($_SESSION['cart'][$p_id]);
}

// update 
if ($act == 'update') {
    $amount_array = $_POST['amount'];
    foreach ($amount_array as $p_id => $amount) {
        $_SESSION['cart'][$p_id] = $amount;
    }
} //cencel
if ($act == 'cancel')  //ยกเลิกการสั่งซื้อ
{
    unset($_SESSION['cart']);
}
?>

<?php include('header.php') ?>
<?php include('nav.php') ?>

<div class="container">
    <div class="row">
        <div class="col-12 col-sm-12 col-md-12">
            <h3>ตะกร้าสินค้า <a class="btn btn-primary btn-sm" href="index.php">กลับหน้ารายการสินค้า</a></h3>

            <form class="form-control-plaintext" id="frmcart" name="frmcart" method="post" action="?act=update&p_id=0">
                <table class="table table-bordered table-hover table-striped">

                    <tr class='table-dark'>
                        <th width="5%">#</th>
                        <th width="10%">รูปภาพ</th>
                        <th width="55%">สินค้า</th>
                        <th width="10%" align="center">ราคา</th>
                        <th width="10%" align="center">จำนวน</th>
                        <th width="5%" align="center">รวม(บาท)</th>
                        <th width="5%" align="center">ลบ</th>
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
                            $p_qty = $row['p_qty']; //จำนวนสินค้าในสต๊อก
                            echo "<tr>";
                            echo "<td >" . @$i += 1 . "</td>";
                            echo "<td>" . "<img src='./shoppri/pimg/" . $row['p_img'] . "' width='100'>" . "</td>";
                            echo "<td >" 
                            .$row["p_name"] 
                            ."<br>"
                            .'มีสินค้าทั้งหมด  : '
                            .$row["p_qty"]
                            .' ชิ้น'
                            ."</td>";
                            echo "<td  align='left'>" . number_format($row["p_price"], 2) . "</td>";
                            echo "<td  align='right'>";
                            echo "<input type='number' name='amount[$p_id]' value='$qty' class='form-control' min='1' max='$p_qty'/></td>";
                            echo "<td  align='right'>" . number_format($sum, 2) . "</td>";
                            //remove product
                            echo "<td  align='center'><a class='btn btn-danger btn-sm' href='cart.php?p_id=$p_id&act=remove'>ลบ</a></td>";
                            echo "</tr>";
                        }
                        echo "<tr>";
                        echo "<td colspan='5' class='table-dark' align='center'><b>ราคารวม</b></td>";
                        echo "<td align='right' class='table-dark'>" . "<b>" . number_format($total, 2) . "</b>" . "</td>";
                        echo "<td align='left' class='table-dark'></td>";
                        echo "</tr>";
                    }

                    if ($total > 0) {


                    ?>

                        <tr>

                            <td colspan="7" align="right">
                                <input type="button" class="btn btn-danger" name="btncancel" value="ยกเลิกการสั่งซื้อ" onclick="window.location='cart.php?act=cancel';" />
                                <input type="submit" class="btn btn-warning" name="button" id="button" value="ปรับปรุง" />

                                <?php if($act=='update'){ ?>
                                    
                                <input type="button" class="btn btn-success" name="Submit2" value="สั่งซื้อ" onclick="window.location='confirm.php';" />
                                    <?php } ?>
                            </td>

                        </tr>
                    <?php } else {
                        echo '<h4 align="center">-ไม่มีสินค้าในตะกร้าสินค้า กรุณาเลือกสินค้าใหม่อีกครั้ง-</h4>';
                    } ?>
                </table>
            </form>
        </div>

    </div>

</div>



<?php include('footer.php') ?>