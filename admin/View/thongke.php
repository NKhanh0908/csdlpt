<!DOCTYPE html>
<html lang="vi">
<head>
    <title>Thống kê bán hàng</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 28px;
            color: #333;
        }

        .btn-container {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-bottom: 20px;
        }

        button {
            padding: 12px 20px;
            font-size: 16px;
            cursor: pointer;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0056b3;
        }

        .chart-container {
            text-align: center;
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
        }

        canvas {
            width: 100%;
            height: 500px;
            display: none;
            border: 1px solid #ccc;
            background-color: #f9f9f9;
            border-radius: 8px;
        }

        #topProductsList {
            display: none;
            margin-top: 20px;
            padding: 10px;
            background-color: #f1f1f1;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        #topProductsList ul {
            list-style-type: none;
            padding: 0;
        }

        #topProductsList li {
            padding: 5px 0;
            font-size: 16px;
            border-bottom: 1px solid #ddd;
        }

        #topProductsList li:last-child {
            border-bottom: none;
        }
    </style>
</head>
<body>
    <h2>Thống kê bán hàng</h2>

    <div class="btn-container">
        <button onclick="showChart('revenueChart')">Doanh thu</button>
        <button onclick="showProducts()">Sản phẩm</button>
        <button onclick="showChart('totalOrdersChart')">Đơn hàng</button>
        <button onclick="showChart('orderStatusChart')">Tỷ lệ đơn hàng</button>
        <button onclick="showChart('revenueGrowthChart')">Tăng trưởng</button>
    </div>

    <div class="chart-container">
        <canvas id="revenueChart"></canvas>
        <canvas id="topProductsChart"></canvas>
        <canvas id="totalOrdersChart"></canvas>
        <canvas id="orderStatusChart"></canvas>
        <canvas id="revenueGrowthChart"></canvas>
    </div>

    <!-- Danh sách sản phẩm bán chạy -->
    <div id="topProductsList">
        <h3>Sản phẩm bán chạy</h3>
        <ul id="productList"></ul>
    </div>

    <script>
        let charts = {}; 
        let topProductNames = []; 
        let topProductSales = [];

        document.addEventListener("DOMContentLoaded", function() {
            fetch('../Controller/thongke.php')
                .then(response => response.json())
                .then(data => {
                    topProductNames = data.productNames; 
                    topProductSales = data.productSales; 

                    charts.revenueChart = new Chart(document.getElementById('revenueChart').getContext('2d'), {
                        type: 'line',
                        data: {
                            labels: data.months,
                            datasets: [{
                                label: 'Doanh thu (VND)',
                                data: data.revenues,
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 2,
                                fill: true
                            }]
                        },
                        options: { responsive: true, maintainAspectRatio: false }
                    });

                    charts.topProductsChart = new Chart(document.getElementById('topProductsChart').getContext('2d'), {
                        type: 'bar',
                        data: {
                            labels: data.productNames,
                            datasets: [{
                                label: 'Số lượng bán',
                                data: data.productSales,
                                backgroundColor: 'rgba(255, 99, 132, 0.6)',
                                borderColor: 'rgba(255, 99, 132, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: { responsive: true, maintainAspectRatio: false, indexAxis: 'y' }
                    });

                    charts.totalOrdersChart = new Chart(document.getElementById('totalOrdersChart').getContext('2d'), {
                        type: 'bar',
                        data: {
                            labels: data.months,
                            datasets: [{
                                label: 'Tổng số đơn hàng',
                                data: data.totalOrders,
                                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: { responsive: true, maintainAspectRatio: false }
                    });

                    charts.orderStatusChart = new Chart(document.getElementById('orderStatusChart').getContext('2d'), {
                        type: 'pie',
                        data: {
                            labels: data.orderStatusLabels,
                            datasets: [{
                                data: data.orderStatusData,
                                backgroundColor: [
                                    'rgba(75, 192, 192, 0.6)',
                                    'rgba(255, 99, 132, 0.6)',
                                    'rgba(255, 206, 86, 0.6)'
                                ]
                            }]
                        }
                    });

                    charts.revenueGrowthChart = new Chart(document.getElementById('revenueGrowthChart').getContext('2d'), {
                        type: 'line',
                        data: {
                            labels: data.months,
                            datasets: [{
                                label: 'Tỷ lệ tăng trưởng (%)',
                                data: data.revenueGrowth,
                                backgroundColor: 'rgba(153, 102, 255, 0.2)',
                                borderColor: 'rgba(153, 102, 255, 1)',
                                borderWidth: 2,
                                fill: true
                            }]
                        },
                        options: { responsive: true, maintainAspectRatio: false }
                    });

                    showChart('revenueChart');
                })
                .catch(error => console.error('Lỗi tải dữ liệu thống kê:', error));
        });

        function showChart(chartId) {
            document.querySelectorAll('canvas').forEach(canvas => {
                canvas.style.display = (canvas.id === chartId) ? 'block' : 'none';
            });
            document.getElementById('topProductsList').style.display = 'none'; 
        }

        function showProducts() {
            showChart('topProductsChart'); 
            const productList = document.getElementById('productList');
            productList.innerHTML = ''; 
            topProductNames.forEach((productName, index) => {
                const li = document.createElement('li');
                li.textContent = `${productName}: ${topProductSales[index]} sản phẩm`;
                productList.appendChild(li);
            });
            document.getElementById('topProductsList').style.display = 'block'; 
        }
    </script>
</body>
</html>
