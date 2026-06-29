<!DOCTYPE html>
<html lang="th">
<head>

<meta charset="UTF-8">
<title>Face Scan Device</title>

<style>

body{
font-family:Arial;
text-align:center;
background:#f4f6f9;
margin-top:120px;
}

button{
padding:15px 30px;
font-size:18px;
background:#2563eb;
color:white;
border:none;
border-radius:8px;
cursor:pointer;
}

ul{
margin-top:30px;
}

</style>

</head>

<body>

<h2 id="pageTitle">เครื่องสแกนใบหน้า</h2>
<p id="statusText" style="font-size: 18px; margin-bottom: 20px; font-weight: bold;"></p>

<button id="scanBtn" onclick="scanFace()">จำลองสแกน</button>

<p id="name"></p>

<ul id="scanList"></ul>

<script>

let event_code = "{{ $event_code }}";
let startTime = {{ \Carbon\Carbon::parse($event->date . ' ' . $event->start_time)->timestamp * 1000 }};
let endTime = {{ \Carbon\Carbon::parse(($event->end_date ?? $event->date) . ' ' . $event->end_time)->timestamp * 1000 }};

function checkEventStatus() {
    let now = Date.now();
    let titleEl = document.getElementById("pageTitle");
    let statusEl = document.getElementById("statusText");
    let scanBtn = document.getElementById("scanBtn");

    if (now < startTime) {
        titleEl.innerText = "หน้าจอรอสแกน (Scan Waiting Page)";
        statusEl.innerHTML = "สถานะ: <span style='color: orange;'>รอสแกน (Wait to Scan)</span>";
        scanBtn.disabled = true;
        scanBtn.style.opacity = "0.5";
        scanBtn.style.cursor = "not-allowed";
        return "waiting";
    } else if (now > endTime) {
        titleEl.innerText = "หน้าจอรอสแกน (Scan Waiting Page)";
        statusEl.innerHTML = "สถานะ: <span style='color: red;'>หยุด (Stop)</span>";
        scanBtn.disabled = true;
        scanBtn.style.opacity = "0.5";
        scanBtn.style.cursor = "not-allowed";
        return "stopped";
    } else {
        titleEl.innerText = "เครื่องสแกนใบหน้า";
        statusEl.innerHTML = "สถานะ: <span style='color: green;'>กำลังสแกน (Scanning)</span>";
        scanBtn.disabled = false;
        scanBtn.style.opacity = "1";
        scanBtn.style.cursor = "pointer";
        return "active";
    }
}

// Check immediately and then every second
checkEventStatus();
setInterval(checkEventStatus, 1000);

function scanFace(){
    if (checkEventStatus() !== "active") {
        alert("ไม่สามารถสแกนได้ในขณะนี้");
        return;
    }

    fetch("{{ url('/scan-face') }}",{

    method:"POST",

    headers:{
    "Content-Type":"application/json",
    "Accept":"application/json",
    "X-CSRF-TOKEN":"{{ csrf_token() }}"
    },

    body:JSON.stringify({

    /* ส่งแค่ event_code */
    event_code:event_code

    })

    })

    .then(res=>res.json())

    .then(data=>{

    console.log(data);

    if(data.status==="success"){

    document.getElementById("name").innerHTML=
    "✔ "+data.name+" ("+data.student_id+") สแกนสำเร็จ";

    let li=document.createElement("li");

    li.innerHTML=
    data.name+" ("+data.student_id+") - "+data.time;

    document.getElementById("scanList").prepend(li);

    }

    else if(data.status==="finished"){

    document.getElementById("name").innerHTML=
    "ทุกคนสแกนครบแล้ว";

    }
    
    else if(data.status==="error"){
        document.getElementById("name").innerHTML=
        "❌ " + data.message;
    }

    })

    .catch(err=>{
    console.error(err);
    });

}

</script>

</body>
</html>