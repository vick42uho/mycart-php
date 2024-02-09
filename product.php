<?php include('header.php') ?>
<?php include('nav.php') ?>



<table width="600" border="1" align="center" bordercolor="#666666">
  <tr>
    <td width="91" align="center" bgcolor="#CCCCCC"><strong>ภาพ</strong></td>
    <td width="200" align="center" bgcolor="#CCCCCC"><strong>ชื่อหนังสือ</strong></td>
    <td width="44" align="center" bgcolor="#CCCCCC"><strong>ราคา</strong></td>
    <td width="100" align="center" bgcolor="#CCCCCC"><strong>รายละเอียดสินค้า</strong></td>
  </tr>
  
  
  <?php
  //connect db
  include("connect.php");
  $sql = "SELECT * FROM product ORDER BY p_id";  //เรียกข้อมูลมาแสดงทั้งหมด
  $result = mysqli_query($conn, $sql);

  echo $sql;
//   exit;

  foreach ($result as $row)
  {
  	echo "<tr>";
	echo "<td align='center'><img src='img/" . $row["p_pic"] ." ' width='80'></td>";
	echo "<td align='left'>" . $row["p_name"] . "</td>";
    echo "<td align='center'>" .number_format($row["p_price"],2). "</td>";
    echo "<td align='center'><a href='product_detail.php?id=$row[p_id]'>คลิก</a></td>";
	echo "</tr>";
  }
  ?>
</table>


<?php include('footer.php') ?>