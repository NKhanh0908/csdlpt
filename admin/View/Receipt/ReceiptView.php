<link rel="stylesheet" href="/css/admin/Receipt.css">

<h1>Quản lý Phiếu nhập</h1><br>
<div class='containers'>
    <div class="filter" style="cursor: pointer;">
        Tìm kiếm: <input id='keyword' name="search-filter" placeholder="Nhập từ khóa" oninput="LoadReceipt()"></input>
        Ngày nhập: <input type="date" name="date-search" id="date-serch" onchange="LoadReceipt()">
        Lọc theo thành tiền: <select id="order-price" onchange="LoadReceipt()">
        <option value="0" selected>--Sắp xếp theo--</option>
        <option value="1">Giá tăng dần</option>
        <option value="2">Giá giảm dần</option>
        </select>
        
    </div><br>
    <button onclick="OpenAddReceiptPop()" class='btn-add'>Thim phiếu nhập</button><br><br>
    <h3>Danh sách phiếu nhập</h3>

    <body class="receipt-list" onload="OnloadData()">
        <table>
            <thead>
                <tr>
                <th style="width: 10%;">Mã phiếu nhập</th>
                <th style="width: 15%;">Nhà cung cấp</th>
                <th style="width: 20%;">Địa chỉ</th>
                <th style="width: 20%;">Ngày nhập</th>
                <th style="width: 20%;">Thành tiền</th>
                <th style="width: 8%;">Lợi nhuận</th>
                <th style="width: 7%;"></th>
                </tr>
            </thead>
            <tbody id='hang'></tbody>
        </table>
        <div id='result'></div>
    </body>
</div>
<div class='modal' id='modal'>
    <div class="receiptDetail-form" id="receiptDetail-form" >
        <h1>Chi tiết phiếu nhập</h1><br>
        <h3 id='maPN'>Mã phiếu nhập: </h3>
        <button id='close-receiptdetail' type="button" onclick="closeReceiptDetailPop()">X</button>
        <div class='receiptdetail-container'>
            <table>
                <thead>
                    <tr>
                    <th style="width: 50%;">Tên sản phẩm</th>
                    <th style="width: 15%;">Giá nhập</th>
                    <th style="width: 15%;">Giá bán</th>
                    <th style="width: 10%;">Số lượng</th>
                    </tr>
                </thead>
                <tbody id='hang-sp'></tbody>
            </table>
        </div>
    </div>
</div>

<div id='addReceipt-popup' class="addReceipt-popup">
    <?php include('InsertReceiptView.php');?>
</div>

<script src="/js/admin/Receipt.js"></script>
