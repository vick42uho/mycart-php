<!--navbar-->
<style>
    /* สไตล์ของ dropdown-item */
    .dropdown-item {
        display: block;
        width: 100%;
        padding: 1rem;
        /* ปรับขนาด padding ตามที่ต้องการ */
        clear: both;
        font-weight: 400;
        color: #212529;
        text-align: inherit;
        white-space: nowrap;
        background-color: transparent;
        border: 0;
        transition: background-color 0.3s ease;
        /* เพิ่ม transition เพื่อทำให้มีเอฟเฟกต์เมื่อ hover */
    }

    /* เมื่อ hover ทำให้มีสีพื้นหลังเป็นสีเทาอ่อน */
    .dropdown-item:hover {
        background-color: #f8f9fa;
    }

    /* สไตล์ของ dropdown-menu */
    .dropdown-menu {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        z-index: 1000;
        background-color: #fff;
        border: 1px solid #ccc;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }

    /* สไตล์ของ dropdown-menu เมื่อเปิด */
    .show-dropdown .dropdown-menu {
        display: block;
    }


   
</style>
<header>

<nav class="nav">
    <a class="logo" href="#">Shoppri Online</a>
    <br><br><br><br>
    <div class="nav-items">
        <ul class="nav-list">
            <li class="link"><a href="index.php">หน้าแรก</a></li>
            <li class="link"><a href="#product">สินค้า</a></li>
            <li class="link">
                <a class="nav-list" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    เลือกประเภทสินค้า
                </a>
                <ul class="dropdown-menu">
                    <?php
                    $query = "SELECT t.*, COUNT(p.p_id) as ptotal
                FROM tbl_prd_type as t 
                LEFT JOIN tbl_prd as p ON t.t_id=p.ref_t_id
                GROUP BY t.t_id" or die("Error:" . mysqli_error($conn));
                    $result = mysqli_query($conn, $query);
                    ?>
                    <?php while ($row = mysqli_fetch_array($result)) { ?>
                        <li><a class="dropdown-item" href="index.php?act=showbytype&t_id=<?php echo $row["t_id"]; ?>&name=<?php echo $row["t_name"]; ?>"><?php echo $row["t_name"]; ?>(<?php echo $row["ptotal"]; ?>)</a></li>
                    <?php } ?>
                </ul>
            </li>
            <li class="link"><a href="./shoppri/report_problem.php">แจ้งปัญหา</a></li>
            <!-- <li class="link"><a href="shoppri/login.php">Login</a></li> -->
            <li class="link"><a href="shoppri/login.php">
                    <?php

                    if (!empty($_SESSION['m_name'])) {
                    } else {
                        echo 'Login';
                    }
                    ?>
                </a>
            </li>
            <li class="link"><a href="shoppri/member">
                    <?php

                    if (!empty($_SESSION['m_name'])) {
                        echo 'สวัสดีคุณ ' . $_SESSION['m_name'];
                    } ?>
                </a>
            </li>
            <li class="link"><a href="shoppri/logout.php">
                    <?php

                    if (!empty($_SESSION['m_name'])) {
                        echo 'Logout';
                    } ?>
                </a>
            </li>
        </ul>
    </div>

    <div class="search-form">
        <form class="form-horizontal">
            <div class="input-group mb-2">
                <div class="form-outline" data-mdb-input-init>
                    <input type="search" id="form1" class="form-control" placeholder="ค้นหาสินค้า..." name="search" required />
                </div>
                <button type="submit" name="act" value="q" class="btn btn-primary" data-mdb-ripple-init>
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>


    </div>

    <form action="" method="get" class="form-horizontal">
            <div class="input-group">
                <span class="input-group-text">ราคาต่ำสุด</span>
                <input type="number" class="form-control" name="ps" required>
                <span class="input-group-text">ราคาสูงสุด</span>
                <input type="number" class="form-control" name="pe" required>
                <button type="submit" name="act" value="p" class="btn btn-primary">ค้นหา</button>
            </div>
        </form>
</nav>


    <script>
        // เพิ่ม class 'show-dropdown' เมื่อ dropdown ถูกเปิด
        document.addEventListener('DOMContentLoaded', function() {
            var dropdowns = document.querySelectorAll('.dropdown');

            dropdowns.forEach(function(dropdown) {
                dropdown.addEventListener('show.bs.dropdown', function() {
                    dropdown.classList.add('show-dropdown');
                });

                dropdown.addEventListener('hide.bs.dropdown', function() {
                    dropdown.classList.remove('show-dropdown');
                });
            });
        });
    </script>

</header>
<!--navbar-->
<section class="header"></section>