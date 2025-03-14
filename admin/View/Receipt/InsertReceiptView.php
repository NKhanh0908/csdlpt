
<div class="addreceipt-form" id="addreceipt-form">
    <h1>Thim phiếu nhập</h1><br>
    <div id='input-receipt'>
        <div id='input-receiptinfo'>
            <h2>Nhập thông tin phiếu</h2>
            <Label for='input-ncc'>Chọn nhà cung cấp:</Label>
            <select name="input-ncc" id="input-ncc">
            </select>
            <label for="input-loinhuan">Nhập mức lợi nhuận: </label>
            <input type="number" min='1' value='1' max='99' name='input-loinhuan' id='input-loinhuan' onchange="OnchangeLoiNhuan()"> (%)
        </div>

        <div id='input-receiptdetail'>
            <h2>Thêm danh sách sản phẩm</h2>
            <Label for='input-listSP'>Chọn sản phẩm:</Label>
            <select name="input-listSP" id="input-listSP" onchange="DisplayPrice()">
            </select><br>

            Giá nhập: <input type="text" id='input-gianhap'>
            Số lượng: <input type="number" id='input-soluong' min='1' value='1'>
            <button id='btn-addSP' onclick="AddProduct()">+ Sản phẩm</button><br>
            
            <button id="addProduct" onclick="OpenAddProductPop()">+ Sản phẩm mới</button>
        </div>
    </div>
    <div>
        <h2>Danh sách sản phẩm</h2>
        <div id="scrollView-SP"></div>
    </div>
    
    <div class="thanhtien">
        <p>Thành tiền:</p>
        <p id="thanhtien-sp">0</p>
    </div>
    <button id='close-receipt' type="button" onclick="CloseAddReceiptPop()">Trở về</button>
    <button id='submit-addreceipt' type="button" onclick="InsertReceipt()">Thim</button>
</div>

<div class="addproduct-container" id='addproduct-container'>
    <h1>Thêm sản phẩm</h1>
    
    <label for="Tensp">Tên sản phẩm: </label>
    <input type="text" name="Tensp" placeholder="Nhập tên sản phẩm."><br>

    <label for="hang">Hãng: </label>
    <select name="hang"></select><br>

    <label for="danhmuc">Danh mục</label>
    <select name="danhmuc"></select><br>   

    <label for="Mota">Mô tả</label>
    <textarea type="text" name="Mota" placeholder="Nhập mô tả cho sản phẩm." cols="50" rows="5"></textarea><br>
    
    <label for="Img">Hình ảnh</label><br>
    <input type="file" name="Img" accept="image/png, image/gif, image/jpeg"
    onchange="hienThiAnh(event)"><br>
    <div>
        <img id="img" src="" alt="" style="width: 100px; height: 100px;">
    </div>

    <button type="submit" name="Add-SP" onclick="InsertProduct()">Thêm sản phẩm</button>
    <button class="btn-cancel" name="Cancel" onclick="CloseAddProductPop()">Hủy</button>
</div>

<script type="text/javascript" src="/js/admin/InsertReceipt.js"></script>