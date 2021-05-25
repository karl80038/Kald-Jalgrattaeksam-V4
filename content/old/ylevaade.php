<?php
    if(isset($_REQUEST["healaul"]))
    {
        $command = $dbConnection -> prepare("UPDATE laulud SET punktid = punktid + 1 WHERE id=? AND avalik=1");
        $command -> bind_param("i", $_REQUEST["healaul"]);
        $command -> execute();
        header("Location: $_SERVER[PHP_SELF]?leht=ylevaade&ylevaade_id=".$_REQUEST["healaul"]);
    }
    if(isset($_REQUEST["uus_kommentaar"]))
    {
        if($_REQUEST["kommentaar"] != "")
        {
            $command = $dbConnection -> prepare("UPDATE laulud SET kommentaarid = CONCAT(kommentaarid, ?) WHERE id=? AND avalik=1");
            $kommentaarilisa = $_REQUEST["kommentaar"]."\n";
            $command -> bind_param("si", $kommentaarilisa, $_REQUEST["uus_kommentaar"]);
            $command -> execute();
            $_SESSION["lastsubmission"] = "SUCCESSFUL";
            header("Location: $_SERVER[PHP_SELF]?leht=ylevaade&ylevaade_id=".$_REQUEST["uus_kommentaar"]);
        }
        else
        {
            $_SESSION["lastsubmission"] = "FAILURE";

        }
    }
    if ($_SESSION["lastsubmission"] == "FAILURE")
    {
        echo "<script type='text/javascript'>alert('Kommentaariväli peab olema täidetud!');</script>";
        $_SESSION["lastsubmission"] == "REVIEWED";
    }  
?>
<?php
    $cnt = 0;
    $index = 0;
    $items;
    // remove all session variables
    session_unset();
    // destroy the session
    session_destroy();
    include('html-begin.php');
    echo "<h1>Laulude loetelu</h1>";
    $command = $dbConnection -> prepare("SELECT id, pealkiri FROM laulud WHERE avalik = 1");
    $command -> bind_result($id, $pealkiri);
    $command -> execute();
    while($command -> fetch())
    {        
        //echo "<tr><td><a href='?ylevaade_id=$id'>".htmlspecialchars($pealkiri)."</a></td></tr>";
        $items[$index] = "<tr><td><a href='?leht=ylevaade&ylevaade_id=$id'>".htmlspecialchars($pealkiri)."</a></td></tr>";
        $cnt += 1;
        $index += 1;
    }
    if ($cnt > 0)
    {
        echo "<table>";
        echo "<tr>";
        echo "<td><h3><b>Laulu nimi</b></h3></td>";
        echo "</tr>";
        foreach ($items as $item)
        {
            echo "$item <br>";
        }
        echo "</table>";
    }
    else
    {
        echo "Laulude loetelu on hetkel tühi.";
    }
?>
<?php
    if ($cnt > 0)
    {
        echo "<div id = 'valitud_laul'>";
        if (!empty($_REQUEST{"ylevaade_id"}))
        {
            $command = $dbConnection -> prepare("SELECT id, pealkiri, kommentaarid, punktid FROM laulud WHERE id = ? AND avalik = 1");
            $command -> bind_param("i", $_REQUEST["ylevaade_id"]);
            $command -> bind_result($id, $pealkiri, $kommentaarid, $punktid);
            $command -> execute();
            while($command -> fetch())
            {
                $kommentaarid = nl2br(htmlspecialchars($kommentaarid));
                echo "<h2>".htmlspecialchars($pealkiri)."</h2>";
                echo "<br>";
                echo "<h3>Punkte hetkel: ".htmlspecialchars($punktid)."</h3>";
                //<button onclick="document.location='default.asp'">HTML Tutorial</button>
                echo '<h3><button onclick='.'"document.location='."'?leht=ylevaade&healaul=".$id."'".'">Lisa punkt</button>'."</h3>";
                echo "<br>";
                echo "<h3>Kommentaarid</h3>";
                echo $kommentaarid;
                echo "<br>";
                echo "<form id='add-item' action = '?leht=ylevaade' method = 'post'>";
                echo "<input type='hidden' name='uus_kommentaar' value='$id'>";
                echo "<h3>Uue kommentaari lisamine</h3>";
                echo "<label for='kommentaar' >Kommentaari sisu: </label>";
                echo "<input type='text' id = 'kommentaar' name = 'kommentaar' placeholder = 'Sisestage siia enda kommentaar'/><br>";
                echo "<input type='submit' value='Lisa kommentaar'/>";
                echo "</form>";                
            }
        }
        else
        {
            echo "<h2>Laulu pole valitud</h2>";
            echo "<br>";
            echo "Laulu saate valida nimekirjast.";   
        }        
        echo "</div>";
    }
    include('html-end.php');    
?>