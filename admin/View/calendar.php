<!DOCTYPE html>
<html lang="en">

<?php
    $path = $_SERVER["DOCUMENT_ROOT"] . '/admin/Controller/connectDB.php';
    include($path);

    $id = $_SESSION['idNV'];
?>
<head>
    <meta charset="UTF-8">
    <title>Chấm Công FullCalendar</title>
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <style>
        #calendar {
            max-width: 1000px;
            margin: 20px auto;
        }
    </style>
</head>
<body>
    <input type="hidden" id='idNV' value="<?php echo $id?>">
    <h1 style="text-align: center;">Chấm Công Nhân Viên</h1>
    <div style="text-align: center; margin-bottom: 10px;">
        <button onclick="Checkin()">Check In</button>
        <button onclick="Checkout()">Check Out</button>
        <button onclick="LoadTimekeeping()">Xem lịch chấm công</button>
    </div>
    <div id="calendar"></div>

    <script>
        let calendar;
        const idNV = document.getElementById("idNV").value;
        
        function Checkin() {
            fetch('../Controller/Employee/InsertTimekeeping.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({id: idNV, action: 'checkin'})
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                LoadTimekeeping();
            })
            .catch(error => {
                alert('Lỗi khi check in');
                console.error(error);
            });
        }

        function Checkout() {
            fetch('../Controller/Employee/InsertTimekeeping.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({id: idNV, action: 'checkout'})
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                LoadTimekeeping();
            })
            .catch(error => {
                alert('Lỗi khi check out');
                console.error(error);
            });
        }

        function LoadTimekeeping() {
            const calendarEl = document.getElementById('calendar');

            if (!calendar) {
                calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek'
                    },
                    events: 'get_events.php',
                    eventClick: function(info) {
                        alert('Sự kiện: ' + info.event.title + '\nNgày: ' + info.event.start.toLocaleDateString());
                    }
                });
                calendar.render();
            } else {
                calendar.refetchEvents();
            }
        }
    </script>
</body>
</html>