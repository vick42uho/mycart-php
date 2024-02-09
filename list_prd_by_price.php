<?php
$ps = $_GET['ps'];
$pe = $_GET['pe'];
$queryprd = "
SELECT * FROM `tbl_prd` WHERE `p_price` BETWEEN $ps AND $pe ORDER BY p_id DESC";
$rsprd = mysqli_query($conn, $queryprd) or die("Error: " . mysqli_error($rsprd));
// echo $query;
?>

<section id="product">


    <?php foreach ($rsprd as $rsprd) { ?>
        <div class="card-content">

            <img src="shoppri/pimg/<?php echo $rsprd['p_img']; ?>" width="100%" height="150" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false">
            <h2><?php echo mb_strimwidth($rsprd['p_name'], 0, 30, '...'); ?></h2>

            <p style="color: #ed3621;">ราคา ฿<?php echo number_format($rsprd['p_price'], 0, '', ','); ?></p>


            <h6 class="card-text"><?php
                                    echo $rsprd['p_intro']
                                        . 'มีสินค้าทั้งหมด '
                                        . $rsprd['p_qty']
                                        . ' ชิ้น'; ?></h6>

            <?php
            if ($rsprd['p_qty'] > 0) { ?>
                <a href="cart.php?p_id=<?php echo $rsprd['p_id']; ?>&act=add" class="custom-btn">Add to Cart</a>
            <?php } else {
                echo '<button class=" btn btn-danger" disabled>สินค้าหมด!!</button>';
            } ?>

            <a href="./shoppri/detail.php?p_id=<?php echo $rsprd['p_id']; ?>" class="custom-btn2" target="_blank">รายละเอียด</a>


        </div>
    <?php } ?>
</section>