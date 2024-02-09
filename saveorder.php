<?php
session_start();
include("connect.php");

// Check login
if (empty($_SESSION['m_name'])) {
    echo "<script type='text/javascript'>";
    echo "alert('กรุณา Login เพื่อสั่งซื้อสินค้า');";
    echo "window.location = 'shoppri/login.php'; ";
    echo "</script>";
    exit;
}

$name = mysqli_real_escape_string($conn, $_POST["m_name"]);
$address = mysqli_real_escape_string($conn, $_POST["m_address"]);
$email = mysqli_real_escape_string($conn, $_POST["m_email"]);
$phone = mysqli_real_escape_string($conn, $_POST["m_phone"]);
$m_id = mysqli_real_escape_string($conn, $_POST["m_id"]);
$total = mysqli_real_escape_string($conn, $_POST["total"]);
$dttm = date("Y-m-d H:i:s");

// Start transaction
mysqli_query($conn, "START TRANSACTION");

// Error handling and using prepared statements for order_head insertion
$stmt1 = $conn->prepare("INSERT INTO order_head VALUES (null, ?, ?, ?, ?, ?, ?, ?, 1, 0, '', '0000-00-00', 0, '','0000-00-00')");
$stmt1->bind_param("ssssssi", $m_id, $dttm, $name, $address, $email, $phone, $total);
$result1 = $stmt1->execute();

if (!$result1) {
    // Handle error for order_head insertion
    echo "Error in order_head insertion: " . $stmt1->error;
    mysqli_query($conn, "ROLLBACK");
    exit;
}

// Get the last inserted order ID
$o_id = $stmt1->insert_id;
$stmt1->close();

foreach ($_SESSION['cart'] as $p_id => $qty) {
    // Prepare and execute order_detail insertion
    $stmt2 = $conn->prepare("INSERT INTO order_detail VALUES (null, ?, ?, ?, ?)");
    $stmt2->bind_param("iiid", $o_id, $p_id, $qty, $pricetotal);

    // Fetch the product price from the database
    $sql3 = "SELECT p_price FROM tbl_prd WHERE p_id = ?";
    $stmt3 = $conn->prepare($sql3);
    $stmt3->bind_param("i", $p_id);
    $stmt3->execute();
    $stmt3->bind_result($p_price);
    $stmt3->fetch();
    $stmt3->close();

    // Calculate pricetotal
    $pricetotal = $p_price * $qty;

    $result2 = $stmt2->execute();

    // Update stock
    $sql5 = "UPDATE tbl_prd SET p_qty = p_qty - ? WHERE p_id = ?";
    $stmt5 = $conn->prepare($sql5);
    $stmt5->bind_param("ii", $qty, $p_id);
    $stmt5->execute();
    $stmt5->close();

    if (!$result2) {
        // Handle error for order_detail insertion
        echo "บันทึกข้อมูลไม่สำเร็จ กรุณาติดต่อเจ้าหน้าที่ค่ะ : " . $stmt2->error;
        mysqli_query($conn, "ROLLBACK");
        exit;
    }

    $stmt2->close();
}

// Commit the transaction
mysqli_query($conn, "COMMIT");

// Unset cart session
unset($_SESSION['cart']);

$msg = "บันทึกข้อมูลเรียบร้อยแล้ว ";
echo "<script type='text/javascript'>alert('$msg');</script>";
echo "<script>window.location = 'shoppri/member/order_detail.php?o_id=" . $o_id . "';</script>";

include('footer.php');
?>
