<!Doctype html>
<html>
<head>
    <title>Php lehestik</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="style/style.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,700|Roboto+Mono:300,400|Roboto:300,400&display=swap" rel="stylesheet">
    <script>
    function startTime() 
    {
        var today = new Date();
        var h = today.getHours();
        var m = today.getMinutes();
        var s = today.getSeconds();
        var Cdate = today.getDate();
        var Cmonth = today.getMonth() + 1;
        var Cyear = today.getFullYear();
        m = checkTime(m);
        s = checkTime(s);
        document.getElementById('clock').innerHTML =
        h + ":" + m + ":" + s;
        document.getElementById('date').innerHTML =
        Cdate + "." + Cmonth + "." + Cyear;    
        var t = setTimeout(startTime, 500);
    }
    function checkTime(i) 
    {
        if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
        return i;
    }
</script>
</head>
<?php
    include_once('header.php');
?>
<?php
    include('navigation.php');

?>
<body>


