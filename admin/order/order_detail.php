<?php
    include_once '../../import/connect.php';
    $order_id = $_GET['order_id'];
    $select = $_GET['select'];
    if($select == 1){
        $sql_order_detail = "SELECT
        o.order_id AS OrderID,
        od.product_id AS ProductID,
        CASE
            WHEN b.book_name IS NOT NULL THEN b.book_name
            WHEN op.others_product_name IS NOT NULL THEN op.others_product_name
            ELSE 'Unknown Product'
        END AS ProductName,
        od.quantity AS Quantity,
        od.discount AS Discount,
        p.product_price AS PricePerUnit,
        CAST(od.quantity * p.product_price - (od.discount/100)*(od.quantity * p.product_price) AS DECIMAL(10,3)) AS TotalPrice,
        o.order_date_on AS OrderDate,
        o.note_on AS Note,
        o.status_on AS Status,
        case
			when LEN(u.middle_name)> 0 then
				 CONCAT(u.last_name, ' ', u.middle_name, ' ', u.first_name)
			else CONCAT(u.last_name,' ', u.first_name)
		end AS full_name
        FROM orders_online o
        JOIN order_details_on od ON o.order_id = od.order_id
        JOIN products p ON od.product_id = p.product_id
        LEFT JOIN books b ON p.product_id = b.product_id
        LEFT JOIN others_products op ON p.product_id = op.product_id
        JOIN customers c ON o.customer_id = c.customer_id
        JOIN users u ON c.user_id = u.user_id
        where o.order_id=$order_id";
        $result_order_detail = sqlsrv_query($connect,$sql_order_detail);
        $row_order_detail = sqlsrv_fetch_array($result_order_detail);
    }else{
        $sql_order_detail = "SELECT
        o.order_id AS OrderID,
        od.product_id AS ProductID,
        CASE
            WHEN b.book_name IS NOT NULL THEN b.book_name
            WHEN op.others_product_name IS NOT NULL THEN op.others_product_name
            ELSE 'Unknown Product'
        END AS ProductName,
        od.quantity AS Quantity,
        p.product_price AS PricePerUnit,
        od.discount AS Discount,
        CAST(od.quantity * p.product_price - (od.discount/100)*(od.quantity * p.product_price) AS DECIMAL(10,3)) AS TotalPrice,
        o.order_date_off AS OrderDate,
        o.note_off AS Note
        FROM orders_offline o
        JOIN order_details_off od ON o.order_id = od.order_id
        JOIN products p ON od.product_id = p.product_id
        LEFT JOIN books b ON p.product_id = b.product_id
        LEFT JOIN others_products op ON p.product_id = op.product_id
        where o.order_id=$order_id";
        $result_order_detail = sqlsrv_query($connect,$sql_order_detail);
        $row_order_detail = sqlsrv_fetch_array($result_order_detail);
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <title>Home Admin</title>
    <style>
        .action-buttons .btn.btn-info  {
            display: flex;
            align-items: center;
        }
        h3{
            color: var(--dark);
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <a href="#" class="logo">
            <i class='bx bxl-amazon'></i>
            <div class="logo-name"><span>A</span>&nbspBookstore</div>
        </a>
        <ul class="side-menu">
            <li><a href="../dashboard/index.php"><i class='bx bxs-dashboard'></i>Home</a></li>
            <li class="active"><a href="index.php"><i class='bx bx-clipboard'></i>Orders</a></li>
            <li><a href="../setting_up/setting_support.php"><i class='bx bx-support'></i>Support</a></li>
            <li><a href="../account/index.php"><i class='bx bx-group'></i>Users</a></li>
            <li><a href="../setting_up/index.php"><i class='bx bx-cog'></i>Settings</a></li>
        </ul>
        <ul class="side-menu">
            <li>
                <a href="#" class="logout">
                    <i class='bx bx-log-out-circle'></i>
                    Logout
                </a>
            </li>
        </ul>
    </div>

    <!-- content -->
    <div class="content">
        <!-- Navbar -->
        <nav>
            <i class='bx bx-menu'></i>
            <form action="#">
                <div class="form-input">
                    <input type="search" placeholder="Search...">
                    <button class="search-btn" type="submit"><i class='bx bx-search'></i></button>
                </div>
            </form>
            <input type="checkbox" id="theme-toggle" hidden>
            <label for="theme-toggle" class="theme-toggle"></label>
            <a href="#" class="notif">
                <i class='bx bx-bell'></i>
            </a>
            <a href="#" class="profile">
                <img src="images/logo.jpg">
            </a>
        </nav>

    <main>
    <div class="container-fluid mt-4">
        <div class="row mb-3">
            <div class="col-md-6">
            <h3><a style="color:black;" href="order_list.php"><i class='bx bxs-chevrons-left me-3' ></i></a>Thông tin hóa đơn</h3>
            </div>
                <div class="col-md-6">
                    <button type="button" class="btn btn-success float-end" data-bs-toggle="modal" data-bs-target="#editOrderModal">
                        <i class='bx bx-sm bx-edit-alt me-1'></i>Chỉnh sửa thông tin
                    </button>
                </div>
                </div>

                    <div class="tab-pane fade show active" id="thongtin">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4 text-center d-flex justify-content-center align-items-center">
                                            <img src="../../assets/images/avatar/chiecla.png" alt="Profile Image" class="img-fluid rounded-circle mb-3"
                                                style="width: 200px; height: 200px;">
                                        </div>
                                        <div class="col-md-8">
                                            <h4>Chi tiết hóa đơn</h4>
                                            <hr class="info-divider">
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item list-group-item-action list-group-item-light">
                                                    <div class="d-flex align-items-center">
                                                        <strong style="margin-right: 75px">Mã Hóa Đơn:</strong>
                                                        <p style="margin-bottom: 0px">DH00<?php echo $row_order_detail['OrderID'] ?></p>
                                                    </div>
                                                </li>
                                                <li class="list-group-item list-group-item-action list-group-item-light">
                                                    <div class="d-flex align-items-center">
                                                        <strong style="margin-right: 95px">Ngày đặt đơn:</strong>
                                                        <?php $order_date_detail = $row_order_detail['OrderDate'];
                                                                $formatted_date_detail = $order_date_detail->format('Y-m-d'); ?>
                                                        <p style="margin-bottom: 0px"><?php echo $formatted_date_detail; ?></p>
                                                    </div>
                                                </li>
                                                <li class="list-group-item list-group-item-action list-group-item-light">
                                                    <div class="d-flex align-items-center">
                                                        <strong style="margin-right: 50px">Ghi chú:</strong>
                                                        <p style="margin-bottom: 0px"><?php echo $row_order_detail['Note'] ?></p>
                                                    </div>
                                                </li>
                                                <?php if($select == 1) { ?>
                                                    <li class="list-group-item list-group-item-action list-group-item-light">
                                                    <div class="d-flex align-items-center">
                                                        <strong style="margin-right: 50px">Tên Khách Hàng:</strong>
                                                        <p style="margin-bottom: 0px"><?php echo $row_order_detail['full_name'] ?></p>
                                                    </div>
                                                    </li>
                                                    <li class="list-group-item list-group-item-action list-group-item-light">
                                                    <div class="d-flex align-items-center">
                                                        <strong style="margin-right: 50px">Trạng Thái:</strong>
                                                        <p style="margin-bottom: 0px"><?php echo $row_order_detail['Status'] ?></p>
                                                    </div>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

               <div class="mt-3">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">Product ID</th>
                                <th scope="col">Tên Sản Phẩm</th>
                                <th scope="col">Số lượng</th>
                                <th scope="col">Đơn giá</th>
                                <th scope="col">Khuyến mãi</th>
                                <th scope="col">Thành Tiền</th>
                                <th scope="col">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            sqlsrv_free_stmt($result_order_detail);
                            $result_order_detail = sqlsrv_query($connect,$sql_order_detail);
                            if ($result_order_detail) {
                                while ($row = sqlsrv_fetch_array($result_order_detail)) {
                            ?>
                                    <tr>
                                        <td>PS<?php echo $row['ProductID'] ?></td>
                                        <td><?php echo $row['ProductName'] ?></td>
                                        <td><?php echo $row['Quantity'] ?></td>
                                        <td><?php echo $row['PricePerUnit'] ?></td>
                                        <td><?php echo $row['Discount'] ?></td>
                                        <td><?php echo $row['TotalPrice'] ?></td>
                                        <td >
                                            <div class="d-flex">
                                                <button class="btn btn-sm btn-warning me-2"><i class='bx bx-edit bx-sm'></i></button>
                                                <button type="button" class="btn btn-sm btn-danger me-2" data-postid="<?php echo $row_account_admin['user_id']; ?>&delete=1" data-bs-toggle="modal" data-bs-target="#deleteUserModal"><i class='bx bx-sm bx-trash me-1'></i></button>
                                                <a href ="" class="btn btn-sm btn-info"><i class='bx bxs-show bx-sm' ></i></a>
                                            </div>
                                        </td>
                                    </tr>
                            <?php
                                }
                            }
                            ?>
                            <tr>
                                <td colspan="8">
                                    <div class="row">
                                        <div class="col-md-5 me-4">
                                            <strong>Tổng giá:</strong>
                                        </div>
                                        <div class="col-md-5 text-end ms-3">
                                            <?php
                                            $totalPrice = 0;
                                            sqlsrv_free_stmt($result_order_detail);
                                            $result_order_detail = sqlsrv_query($connect,$sql_order_detail);
                                            while ($row = sqlsrv_fetch_array($result_order_detail)) {
                                                $totalPrice += $row['TotalPrice'];
                                            }
                                            echo $totalPrice . "000";
                                            ?>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
               </div>
            </div>
        </main>
    </div>
    <div class="modal fade" id="editOrderModal" tabindex="-1" aria-labelledby="editOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editOrderModalLabel">Chỉnh sửa thông tin đơn hàng</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editOrderForm" action="process.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="order_id" value="<?php echo $order_id ?>">
                    <!-- Ngày đặt hàng -->
                    <div class="mb-3">
                        <label for="order_date" class="form-label">Ngày đặt hàng:</label>
                        <input type="date" class="form-control" id="order_date" name="order_date" value="<?php echo $formatted_date_detail ?>">
                    </div>
                    <!-- Ghi chú -->
                    <div class="mb-3">
                        <label for="note" class="form-label">Ghi chú:</label>
                        <textarea class="form-control" id="note" name="note" rows="3"><?php echo $row_order_detail['Note'] ?></textarea>
                    </div>
                    <?php if($select == 1) { ?>
                    <div class="mb-3">
                        <label for="customer" class="form-label">Mã sản phẩm:</label>
                        <input type="text" class="form-control" id="customer" name="customer" value="<?php echo $row_order_detail['full_name'] ?>">
                    </div>
                    <div class="mb-3">
                        <label for="Status" class="form-label">Trạng thái:</label>
                        <select class="form-select" id="gender" name="gender" required>
                            <option value="" disabled selected>Chọn trạng thái</option>
                            <option value="Confirmed" <?php echo ($row_order_detail['Status'] == 'Confirmed') ? 'selected' : ''; ?>>Confirmed</option>
                            <option value="Pending" <?php echo ($row_order_detail['Status'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                            <option value="Unpaid" <?php echo ($row_order_detail['Status'] == 'Unpaid') ? 'selected' : ''; ?>>Unpaid</option>
                            <option value="Completed" <?php echo ($row_order_detail['Status'] == 'Completed') ? 'selected' : ''; ?>>Completed</option>
                            <option value="Deleted" <?php echo ($row_order_detail['Status'] == 'Deleted') ? 'selected' : ''; ?>>Deleted</option>
                            <option value="Shipped" <?php echo ($row_order_detail['Status'] == 'Shipped') ? 'selected' : ''; ?>>Shipped</option>
                        </select>
                    </div>
                    <?php } ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                </div>
            </form>
        </div>
    </div>
</div>
    <script src="index.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <script>
        const editButton = document.querySelector('#editButton');
        const editOrderModal = document.querySelector('#editOrderModal');
        editButton.addEventListener('click', function() {
            editOrderModal.style.display = 'block';
        });
        const closeModalButton = document.querySelector('.btn-close');
        closeModalButton.addEventListener('click', function() {
            editOrderModal.style.display = 'none';
        });

</script>
</body>
</html>
