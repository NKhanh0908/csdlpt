<link rel="stylesheet" href="../../css/admin/OneForAll.css">
<link rel="stylesheet" href="../../css/admin/thongke.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<body>
    <div class="header">    
        <div class="first-header">
            <p>Thống kê bán hàng</p>
        </div>
        <div class="second-header">
            <div class="second-header-main">
                <button class="home">
                    <a href="?page=employeeinfo"> 
                        <i class="fa-solid fa-house home-outline"></i>
                    </a>
                </button>
                <div class="line"></div>
                <button onclick="loadRevenueChart()">Doanh thu theo chi nhánh</button>
                <button onclick="loadOrderCountChart()">Số lượng đơn hàng</button>
                <button onclick="loadOrderStatusChart()">Tỷ lệ đơn hàng</button>
                <button onclick="loadGrowthChart()">Tăng trưởng doanh thu</button>
                <button onclick="loadBranchProductChart()">Sản phẩm bán chạy theo chi nhánh</button>
            </div>
        </div>
    </div>

    <!-- Nội dung chính -->
    <main class="main">
        <div class='container'>
            <div class="chart-container">
                <canvas id="revenueChart"></canvas>
                <canvas id="topProductsChart"></canvas>
                <canvas id="totalOrdersChart"></canvas>
                <canvas id="orderStatusChart"></canvas>
                <canvas id="revenueGrowthChart"></canvas>
                <canvas id="branchOrderChart"></canvas>
                <canvas id="branchProductChart"></canvas>
            </div>
            <!-- Danh sách sản phẩm bán chạy -->
            <div id="topProductsList">
                <h3>Sản phẩm bán chạy</h3>
                <ul id="productList"></ul>
            </div>
        </div>
    </main>
</body>

<script>
    let charts = {};
    let topProductNames = [];
    let topProductSales = [];
    const fromDate = new URLSearchParams(window.location.search).get('fromDate') || '2024-01-01';
            const toDate = new URLSearchParams(window.location.search).get('toDate') || '2025-12-31';

    function showChart(chartId) {
        document.querySelectorAll('canvas').forEach(canvas => {
            canvas.style.display = (canvas.id === chartId) ? 'block' : 'none';
        });
        document.getElementById('topProductsList').style.display = 'none';

        document.querySelectorAll('.second-header button').forEach(button => {
            if (button.getAttribute('onclick') === `showChart('${chartId}')`) {
                button.classList.add('active');
            } else {
                button.classList.remove('active');
            }
        });
    }

    window.loadRevenueChart = function() {
        showChart('revenueChart');
        if (!charts.revenueChart) {
            fetch(`../Controller/thongke.php?action=getBranchRevenue&fromDate=${fromDate}&toDate=${toDate}`)
                .then(res => res.json())
                .then(data => {
                    const datasets = [];
                    const colors = ['#36a2eb', '#ff6384', '#4bc0c0'];

                    data.branchRevenue.forEach((branch, index) => {
                        datasets.push({
                            label: branch.name,
                            data: branch.revenues,
                            backgroundColor: colors[index % colors.length],
                            borderColor: colors[index % colors.length],
                            tension: 0.3,
                            fill: false
                        });
                    });

                    charts.revenueChart = new Chart(document.getElementById('revenueChart').getContext('2d'), {
                        type: 'line',
                        data: {
                            labels: data.branchRevenue[0].months.map(month => `Tháng ${month}`),
                            datasets: datasets
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                title: {
                                    display: true,
                                    text: 'Doanh thu theo chi nhánh'
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            return `${context.dataset.label}: ${context.raw.toLocaleString()} VND`;
                                        }
                                    }
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    title: {
                                        display: true,
                                        text: 'Doanh thu (VND)'
                                    },
                                    ticks: {
                                        callback: function(value) {
                                            return value.toLocaleString();
                                        }
                                    }
                                },
                                x: {
                                    title: {
                                        display: true,
                                        text: 'Tháng'
                                    }
                                }
                            }
                        }
                    });
                });
        }
    };



    window.loadOrderCountChart = function() {
                showChart('totalOrdersChart');
                if (!charts.totalOrdersChart) {
                    fetch(`../Controller/thongke.php?action=getBranchOrders&fromDate=${fromDate}&toDate=${toDate}`)
                        .then(res => res.json())
                        .then(data => {
                            const datasets = [];
                            const colors = ['#ff9f40', '#9966ff', '#ffcd56'];

                            data.branchOrders.forEach((branch, index) => {
                                datasets.push({
                                    label: branch.name,
                                    data: branch.orders,
                                    backgroundColor: colors[index % colors.length],
                                    borderColor: colors[index % colors.length],
                                    borderWidth: 1
                                });
                            });

                            charts.totalOrdersChart = new Chart(document.getElementById('totalOrdersChart').getContext('2d'), {
                                type: 'bar',
                                data: {
                                    labels: data.branchOrders[0].months.map(month => `Tháng ${month}`),
                                    datasets: datasets
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    plugins: {
                                        title: {
                                            display: true,
                                            text: 'Số lượng đơn hàng theo chi nhánh'
                                        }
                                    },
                                    scales: {
                                        y: {
                                            beginAtZero: true,
                                            title: {
                                                display: true,
                                                text: 'Số lượng đơn'
                                            }
                                        },
                                        x: {
                                            title: {
                                                display: true,
                                                text: 'Tháng'
                                            }
                                        }
                                    }
                                }
                            });
                        });
                }
            };




    window.loadBranchProductChart = function () {
        showChart('branchProductChart');
        if (!charts.branchProductChart) {
            fetch('../Controller/thongke.php?action=getBranchProductData')
                .then(response => response.json())
                .then(data => {
                    const datasets = [];
                    const labels = data.branchProducts[0].products;
                    const colors = ['#4bc0c0', '#9966ff', '#ff6384'];

                    data.branchProducts.forEach((branch, index) => {
                        datasets.push({
                            label: branch.name,
                            data: branch.quantities,
                            backgroundColor: colors[index % colors.length],
                            borderColor: colors[index % colors.length],
                            borderWidth: 1
                        });
                    });

                    charts.branchProductChart = new Chart(document.getElementById('branchProductChart').getContext('2d'), {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: datasets
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                title: {
                                    display: true,
                                    text: 'Top sản phẩm bán chạy theo chi nhánh'
                                }
                            }
                        }
                    });
                });
        }
    };



    window.loadOrderStatusChart = function () {
        showChart('orderStatusChart');
        if (!charts.orderStatusChart) {
            fetch(`../Controller/thongke.php?action=getBranchStatus&fromDate=${fromDate}&toDate=${toDate}`)
                .then(res => res.json())
                .then(data => {
                    const labels = [
                        'Chờ xác nhận',
                        'Đang chuẩn bị hàng',
                        'Đang giao hàng',
                        'Giao hàng thành công',
                        'Đã hủy'
                    ];

                    const branchColors = ['#ff6384', '#36a2eb', '#4bc0c0', '#9966ff', '#ff9f40'];

                    // Mỗi chi nhánh là 1 dataset
                    const datasets = data.branchStatuses.map((branch, i) => ({
                        label: branch.name,
                        data: labels.map(status => branch.statuses[status] || 0),
                        backgroundColor: branchColors[i % branchColors.length]
                    }));

                    charts.orderStatusChart = new Chart(document.getElementById('orderStatusChart').getContext('2d'), {
                        type: 'bar',
                        data: {
                            labels: labels, // 5 trạng thái
                            datasets: datasets // mỗi chi nhánh
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                title: {
                                    display: true,
                                    text: 'Tỷ lệ đơn hàng theo trạng thái và chi nhánh'
                                }
                            },
                            scales: {
                                x: {
                                    stacked: false,
                                    title: {
                                        display: true,
                                        text: 'Trạng thái đơn hàng'
                                    }
                                },
                                y: {
                                    beginAtZero: true,
                                    title: {
                                        display: true,
                                        text: 'Số lượng đơn hàng'
                                    }
                                }
                            }
                        }
                    });
                });
        }
    };



    window.loadGrowthChart = function () {
        showChart('revenueGrowthChart');
        if (!charts.revenueGrowthChart) {
            fetch('../Controller/thongke.php?action=getBranchGrowth')
                .then(res => res.json())
                .then(data => {
                    const datasets = [];
                    const colors = ['#4bc0c0', '#9966ff', '#ff6384'];

                    data.branchGrowth.forEach((branch, index) => {
                        datasets.push({
                            label: branch.name,
                            data: branch.growth,
                            borderColor: colors[index % colors.length],
                            backgroundColor: colors[index % colors.length],
                            tension: 0.2,
                            fill: false
                        });
                    });

                    charts.revenueGrowthChart = new Chart(document.getElementById('revenueGrowthChart').getContext('2d'), {
                        type: 'line',
                        data: {
                            labels: data.branchGrowth[0].months,
                            datasets: datasets
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                title: {
                                    display: true,
                                    text: 'Tỷ lệ tăng trưởng doanh thu'
                                }
                            }
                        }
                    });
                });
        }
    };
</script>