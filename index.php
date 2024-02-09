<?php include('connect.php') ?>
<?php
session_start();
// print_r($_SESSION);
include('header.php');
include('nav.php');


$act = (isset($_GET['act']) ? $_GET['act'] : '');
if ($act == 'showbytype') {
    include('list_prd_by_type.php');
} elseif ($act == 'q') {
    include('list_prd_by_search_multi_column.php');
} elseif ($act == 'p') {
    include('list_prd_by_price.php');
} else {
    include('list_product.php');
}

include('footer.php');
?>



