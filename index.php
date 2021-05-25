<?php
    if (!isset($_SESSION))
    {
        session_start();
    }
?>
<?php
    $_SESSION["lastsubmission"] = "UNKNOWN";
?>
<?php
require_once('conf.php');
?>
<?php
    if(isSet($_GET["page"]))
    {
        include('content/'.$_GET["page"].".php");
    } 
    else 
    {
        include('content/pealeht.php');
    }
?>