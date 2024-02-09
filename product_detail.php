<?php include('header.php') ?>
<?php include('nav.php') ?>


<table width="600" border="0" align="center" class="square">
    <tr>
        <td colspan="3" bgcolor="#CCCCCC"><b>Product</b></td>
    </tr>

    <?php
    //connect db 
    include("connect.php");
    $p_id = mysqli_real_escape_string($conn, $_GET['id']); //สร้างตัวแปร p_id เพื่อรับค่า

    $sql = "SELECT * FROM product WHERE p_id=$p_id";  //รับค่าตัวแปร p_id ที่ส่งมา
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    //แสดงรายละเอียด
    echo "<tr>";
    echo "<td width='85' valign='top'><b>Title</b></td>";
    echo "<td width='279'>" . $row["p_name"] . "</td>";
    echo "<td width='70' rowspan='4'><img src='img/" . $row["p_pic"] . " ' width='100'></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td valign='top'><b>Detail</b></td>";
    echo "<td>" . $row["p_detail"] . "</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td valign='top'><b>Price</b></td>";
    echo "<td>" . number_format($row["p_price"], 2) . "</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td colspan='2' align='center'>";
    echo "<a href='cart.php?p_id=$row[p_id]&act=add'> เพิ่มลงตะกร้าสินค้า </a></td>";
    echo "</tr>";
    ?>
</table>

<p>
    <center><a href="product.php">กลับไปหน้ารายการสินค้า</a></center>



    <?php include('footer.php') ?>