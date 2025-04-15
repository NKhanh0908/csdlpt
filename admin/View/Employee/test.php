<html> 
<head> 
  <title>Index</title> 
  <script>
   document.addEventListener('DOMContentLoaded', function() {
        // Lấy các phần tử
        var loaderFrame = document.getElementById('loaderFrame');
        var printerButton = document.getElementById('printerButton');

        loaderFrame.addEventListener('load', function() {
            var iframeWindow = loaderFrame.contentWindow || loaderFrame.contentDocument.defaultView;
            iframeWindow.print();
        });

        printerButton.addEventListener('click', function() {
            loaderFrame.setAttribute('src', 'Payslip.php');
        });
    });
  </script>
  <style>
     #loaderFrame{
        visibility: hidden;
        height: 1px;
        width: 1px;
     }
  </style>
</head> 
<body> 
    <input type="button" id="printerButton" name="print" value="Print It" />

    <iframe id="loaderFrame" ></iframe>
</body>
</html>