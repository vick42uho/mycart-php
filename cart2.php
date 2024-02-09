<?php
session_start();

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
}//cencel
if ($act == 'cancel')  //ยกเลิกการสั่งซื้อ
{
    unset($_SESSION['cart']);
}
?>

<?php include('header.php') ?>
<?php include('nav.php') ?>

<form id="frmcart" name="frmcart" method="post" action="?act=update&p_id=0">
    <table width="600" border="0" align="center" class="square">
        <tr>
            <td colspan="5" bgcolor="#CCCCCC">
                <b>ตะกร้าสินค้า</span>
            </td>
        </tr>
        <tr>
            <td bgcolor="#EAEAEA">สินค้า</td>
            <td align="center" bgcolor="#EAEAEA">ราคา</td>
            <td align="center" bgcolor="#EAEAEA">จำนวน</td>
            <td align="center" bgcolor="#EAEAEA">รวม(บาท)</td>
            <td align="center" bgcolor="#EAEAEA">ลบ</td>
        </tr>
        <?php
        $total = 0;
        if (!empty($_SESSION['cart'])) {
            
            foreach ($_SESSION['cart'] as $p_id => $qty) {
                $sql = "SELECT * FROM product WHERE p_id=$p_id";
                $query = mysqli_query($conn, $sql);
                $row = mysqli_fetch_array($query);
                $sum = $row['p_price'] * $qty; //ราคาสินค้า * จำนวน
                $total += $sum; // ราคารวม
                $p_qty = $row['p_qty'];  //จำนวนสินค้าในสต๊อก
                echo "<tr>";
                echo "<td width='334'>" . $row["p_name"] . "</td>";
                echo "<td width='46' align='right'>" . number_format($row["p_price"], 2) . "</td>";
                echo "<td width='57' align='right'>";
                echo "<input type='number' name='amount[$p_id]' value='$qty' size='2'/></td>";
                echo "<td width='93' align='right'>" . number_format($sum, 2) . "</td>";
                //remove product
                echo "<td width='46' align='center'><a href='cart.php?p_id=$p_id&act=remove'>ลบ</a></td>";
                echo "</tr>";
            }
            echo "<tr>";
            echo "<td colspan='3' bgcolor='#CEE7FF' align='center'><b>ราคารวม</b></td>";
            echo "<td align='right' bgcolor='#CEE7FF'>" . "<b>" . number_format($total, 2) . "</b>" . "</td>";
            echo "<td align='left' bgcolor='#CEE7FF'></td>";
            echo "</tr>";
        }
        ?>
        <tr>
            <td><a href="product.php">กลับหน้ารายการสินค้า</a></td>
            <td colspan="4" align="right">
            <input type="button" name="btncancel" value="ยกเลิกการสั่งซื้อ" onclick="window.location='cart.php?act=cancel';" />
                <input type="submit" name="button" id="button" value="ปรับปรุง" />
                <input type="button" name="Submit2" value="สั่งซื้อ" onclick="window.location='confirm.php';" />
            </td>
        </tr>
    </table>
</form>



<?php include('footer.php') ?>