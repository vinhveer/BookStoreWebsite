<?php
include_once ('layout.php')
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/boxicons/2.0.7/css/boxicons.min.css">
    <title>Thống kê đơn hàng</title>
</head>

<body>
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-6">
                <h3>Thống kê đơn hàng</h3>
            </div>
            <div class="col-md-6">
                <button class="btn btn-primary float-end">Xuất báo cáo</button>
                <a href="order_list.php" class="btn btn-primary float-end me-2" type ="button">Xem chi tiết đơn hàng</a>
            </div>
        </div>
    </div>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Tổng quan</h5>
                        <hr>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="card text-white bg-primary mb-3">
                                    <div class="card-body">
                                        <h5 class="card-title">Số lượng đơn hàng</h5>
                                        <p class="card-text">325</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card text-white bg-success mb-3">
                                    <div class="card-body">
                                        <h5 class="card-title">Giá trị đơn hàng</h5>
                                        <p class="card-text">825 triệu (20%)</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card text-white bg-warning mb-3">
                                    <div class="card-body">
                                        <h5 class="card-title">Thực thu</h5>
                                        <p class="card-text">480 triệu (20%)</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card text-white bg-danger mb-3">
                                    <div class="card-body">
                                        <h5 class="card-title">Số còn phải thu</h5>
                                        <p class="card-text">345 triệu (20%)</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-4 mb-5">
        <div class="row">
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Thống kê</h5>
                                <hr>
                                <div class="row">
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">Đã thực hiện 325</h5>
                                            <!-- Thêm icon vào đây -->
                                            <p class="card-text border"><i class='bx bxs-check-circle'></i> Chưa thực hiện: 125</p>
                                            <p class="card-text border"><i class='bx bxs-time'></i> Đang thực hiện: 124</p>
                                            <p class="card-text border"><i class='bx bxs-check-circle'></i> Đã thực hiện: 325</p>
                                            <p class="card-text border"><i class='bx bxs-x-circle'></i> Đã hủy: 15</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">Đã thanh toán: 300</h5>
                                            <!-- Thêm icon vào đây -->
                                            <p class="card-text border"><i class='bx bxs-check-circle'></i> Chưa thanh toán: 35</p>
                                            <p class="card-text border"><i class='bx bxs-check-circle'></i> Đã thanh toán 1 phần: 45</p>
                                            <p class="card-text border"><i class='bx bxs-check-circle'></i> Đã thanh toán 300: 300</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">Đã giao hàng: 75</h5>
                                            <!-- Thêm icon vào đây -->
                                            <p class="card-text border"><i class='bx bxs-check-circle'></i> Chưa giao hàng: 100</p>
                                            <p class="card-text border"><i class='bx bxs-time'></i> Đang giao hàng: 150</p>
                                            <p class="card-text border"><i class='bx bxs-check-circle'></i> Đã giao hàng: 75</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mt-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Biểu đồ đơn hàng</h5>
                            <hr>
                            <!-- Nội dung biểu đồ -->
                            <canvas id="orderChart" width="400" height="200"></canvas>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-center">Hoạt động giao dịch</h5>
                        <div class="d-flex justify-content-center align-items-center">
                            <div class="col-sm-9">
                                <select class="form-select" id="activity" name="activity" required>
                                    <option value="" disabled selected>Chọn Lịch sử</option>
                                    <option value="">Hôm nay</option>
                                    <option value="">Ngày hôm qua</option>
                                    <option value="">Một tuần trước</option>
                                    <option value="">Một tháng trước</option>
                                    <option value="">Một Năm trước</option>
                                </select>
                            </div>
                        </div>
                        <hr class="info-divider">
                        <p><i class='bx bx-package bx-sm'></i> Đơn hàng giá trị là 100.000 đã thanh toán</p>
                        <p><i class='bx bx-package bx-sm'></i> Đơn hàng giá trị là 100.000 đã thanh toán</p>
                        <p><i class='bx bx-package bx-sm'></i> Đơn hàng giá trị là 100.000 đã thanh toán </p>
                        <p><i class='bx bx-shopping-bag bx-sm'></i></i> Đơn hàng giá trị là 100.000 đang chờ thanh toán</p>
                        <p><i class='bx bx-package bx-sm'></i> Đơn hàng giá trị là 100.000 đã thanh toán </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Lấy thẻ canvas
    var ctx = document.getElementById('orderChart').getContext('2d');

    // Dữ liệu mẫu cho biểu đồ
    var data = {
        labels: ['Đã thanh toán', 'Chưa thanh toán', 'Đang giao hàng', 'Chưa giao hàng'],
        datasets: [{
            label: 'Thống kê đơn hàng',
            data: [300, 35, 75, 100],
            backgroundColor: [
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(255, 99, 132, 0.2)'
            ],
            borderColor: [
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(255, 99, 132, 1)'
            ],
            borderWidth: 1
        }]
    };

    // Tạo biểu đồ
    var orderChart = new Chart(ctx, {
        type: 'bar',
        data: data,
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

</body>

</html>
