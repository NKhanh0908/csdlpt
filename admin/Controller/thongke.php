    <?php

    include_once("connector.php");

    function getBranchProductStatistics() {
        $branches = ['branch1','branch2', 'branch3', 'branch4'];
        $branchProducts = [];

        foreach ($branches as $branch) {
            $conn = getConnection($branch);
            if ($conn === false) continue;

            $branchName = "Chi nhánh " . str_replace('branch', '', $branch);

            $sql = "SELECT TOP 3 sp.TENSP, SUM(ct.SOLUONG) AS total_sold 
                    FROM chitiethoadon ct 
                    JOIN sanpham sp ON ct.idSP = sp.idSP 
                    JOIN donhang dh ON ct.idHD = dh.idHD
                    GROUP BY sp.TENSP 
                    ORDER BY total_sold DESC";

            $result = sqlsrv_query($conn, $sql);
            if ($result === false) continue;

            $products = [];
            $quantities = [];

            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                $products[] = $row['TENSP'];
                $quantities[] = $row['total_sold'];
            }

            $branchProducts[] = [
                'name' => $branchName,
                'products' => $products,
                'quantities' => $quantities
            ];

            sqlsrv_close($conn);
        }

        return $branchProducts;
    }

    function getBranchRevenueStatistics($fromDate, $toDate) {
        $branches = ['branch2', 'branch3', 'branch4'];
        $data = [];

        foreach ($branches as $branch) {
            $conn = getConnection($branch);
            if ($conn === false) continue;

            $branchName = "Chi nhánh " . str_replace('branch', '', $branch);
            $sql = "SELECT MONTH(NGAYMUA) AS month, SUM(THANHTIEN) AS revenue
                    FROM donhang 
                    WHERE NGAYMUA BETWEEN ? AND ?
                    GROUP BY MONTH(NGAYMUA)
                    ORDER BY MONTH(NGAYMUA)";
            $params = [$fromDate, $toDate];
            $stmt = sqlsrv_query($conn, $sql, $params);

            $months = [];
            $revenues = [];

            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                $months[] = $row['month'];
                $revenues[] = $row['revenue'];
            }

            $data[] = [
                'name' => $branchName,
                'months' => $months,
                'revenues' => $revenues
            ];

            sqlsrv_close($conn);
        }

        return $data;
    }

    function getBranchOrderCountStatistics($fromDate, $toDate) {
        $branches = ['branch2', 'branch3', 'branch4'];
        $data = [];

        foreach ($branches as $branch) {
            $conn = getConnection($branch);
            if ($conn === false) continue;

            $branchName = "Chi nhánh " . str_replace('branch', '', $branch);
            $sql = "SELECT MONTH(NGAYMUA) AS month, COUNT(idHD) AS total_orders
                    FROM donhang 
                    WHERE NGAYMUA BETWEEN ? AND ?
                    GROUP BY MONTH(NGAYMUA)
                    ORDER BY MONTH(NGAYMUA)";
            $params = [$fromDate, $toDate];
            $stmt = sqlsrv_query($conn, $sql, $params);

            $months = [];
            $orders = [];

            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                $months[] = $row['month'];
                $orders[] = $row['total_orders'];
            }

            $data[] = [
                'name' => $branchName,
                'months' => $months,
                'orders' => $orders
            ];

            sqlsrv_close($conn);
        }

        return $data;
    }

    function getBranchOrderStatusStatistics($fromDate, $toDate) {
        $branches = ['branch2', 'branch3', 'branch4'];
        $data = [];
    
        foreach ($branches as $branch) {
            $conn = getConnection($branch);
            if ($conn === false) continue;
    
            $branchName = "Chi nhánh " . str_replace('branch', '', $branch);
            $sql = "SELECT TRANGTHAI, COUNT(idHD) AS total_orders
                    FROM donhang 
                    WHERE NGAYMUA BETWEEN ? AND ?
                    GROUP BY TRANGTHAI";
            $params = [$fromDate, $toDate];
            $stmt = sqlsrv_query($conn, $sql, $params);
    
            // Khởi tạo tất cả trạng thái = 0
            $statusData = [
                'Chờ xác nhận' => 0,
                'Đang chuẩn bị hàng' => 0,
                'Đang giao hàng' => 0,
                'Giao hàng thành công' => 0,
                'Đã hủy' => 0
            ];
    
            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                $status = (int)$row['TRANGTHAI'];
                $count = (int)$row['total_orders'];
    
                switch ($status) {
                    case 0:
                        $statusData['Chờ xác nhận'] += $count;
                        break;
                    case 1:
                        $statusData['Đang chuẩn bị hàng'] += $count;
                        break;
                    case 2:
                        $statusData['Đang giao hàng'] += $count;
                        break;
                    case 3:
                        $statusData['Giao hàng thành công'] += $count;
                        break;
                    case 4:
                        $statusData['Đã hủy'] += $count;
                        break;
                    default:
                        // Nếu có trạng thái lạ
                        break;
                }
            }
    
            $data[] = [
                'name' => $branchName,
                'statuses' => $statusData
            ];
    
            sqlsrv_close($conn);
        }
    
        return $data;
    }
    
    function getBranchRevenueGrowthStatistics($fromDate, $toDate) {
        $branches = ['branch2', 'branch3', 'branch4'];
        $data = [];

        foreach ($branches as $branch) {
            $conn = getConnection($branch);
            if ($conn === false) continue;

            $branchName = "Chi nhánh " . str_replace('branch', '', $branch);
            $sql = "WITH MonthlyRevenue AS (
                        SELECT MONTH(NGAYMUA) AS month, SUM(THANHTIEN) AS revenue
                        FROM donhang
                        WHERE NGAYMUA BETWEEN ? AND ?
                        GROUP BY MONTH(NGAYMUA)
                    )
                    SELECT month, revenue, 
                        LAG(revenue) OVER (ORDER BY month) AS prev,
                        (CAST(revenue - LAG(revenue) OVER (ORDER BY month) AS FLOAT) / 
                            NULLIF(LAG(revenue) OVER (ORDER BY month), 0)) * 100 AS growth_rate
                    FROM MonthlyRevenue";
            $params = [$fromDate, $toDate];
            $stmt = sqlsrv_query($conn, $sql, $params);

            $months = [];
            $growthRates = [];

            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                $months[] = $row['month'];
                $growthRates[] = $row['growth_rate'];
            }

            $data[] = [
                'name' => $branchName,
                'months' => $months,
                'growth' => $growthRates
            ];

            sqlsrv_close($conn);
        }

        return $data;
    }

    // Xử lý request qua query string
    $from = $_GET['fromDate'] ?? '2024-01-01';
    $to = $_GET['toDate'] ?? '2024-12-31';
    $action = $_GET['action'] ?? '';

    switch ($action) {
        case 'getBranchProductData':
            echo json_encode(['branchProducts' => getBranchProductStatistics()]);
            break;
        case 'getBranchRevenue':
            echo json_encode(['branchRevenue' => getBranchRevenueStatistics($from, $to)]);
            break;
        case 'getBranchOrders':
            echo json_encode(['branchOrders' => getBranchOrderCountStatistics($from, $to)]);
            break;
        case 'getBranchStatus':
            echo json_encode(['branchStatuses' => getBranchOrderStatusStatistics($from, $to)]);
            break;
        case 'getBranchGrowth':
            echo json_encode(['branchGrowth' => getBranchRevenueGrowthStatistics($from, $to)]);
            break;
        default:
            echo json_encode(['error' => 'Invalid action']);
            break;
    }
