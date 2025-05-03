<?php
    function getAllAccounts() {
        
        $connect = getConnection("branch2");

        if ($connect === false) {
            die("Kết nối thất bại: " . print_r(sqlsrv_errors(), true));
        }

        $sql = "SELECT tk.idTK, tk.USERNAME, tk.HOTEN, tk.EMAIL, tk.TRANGTHAI 
        FROM taikhoan tk";

        $result = sqlsrv_query($connect, $sql);

        $accounts = [];
        if ($result !== false) {
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                $accounts[] = $row;
            }
        }

        sqlsrv_free_stmt($result);
        sqlsrv_close($connect);
        return $accounts;
    }
?>