
<?php
include('html-begin.php');

if(isSet($_REQUEST["sisestusnupp"])){
    if ($_REQUEST["eesnimi"] != "" and $_REQUEST["perekonnanimi"] != "")
    {
        $kask=$yhendus->prepare(
            "INSERT INTO jalgrattaeksam(eesnimi, perekonnanimi) VALUES (?, ?)");
        $kask->bind_param("ss", $_REQUEST["eesnimi"], $_REQUEST["perekonnanimi"]);
        $kask->execute();
        $yhendus->close();
        //header("Location: $_SERVER[PHP_SELF]?lisatudeesnimi=$_REQUEST[eesnimi]");
        //exit();
        $lisatudeesnimi=$_REQUEST["eesnimi"];
    }
    else
    {
        echo "<div id='snackbar' style='background-color:salmon; color:black; box-shadow: 1px 3px 10px 2px red;'>Nõutud väljad ei ole täidetud!</div>";
        echo '<script>
    
                    // Get the snackbar DIV
                    var sb = document.getElementById("snackbar");
    
                    // Add the "show" class to DIV
                    sb.className = "show";
    
                    // After 3 seconds, remove the show class from DIV
                    setTimeout(function(){ sb.className = sb.className.replace("show", ""); }, 3000);
             </script>';
    }

}
?>
<body>
<main>    
<h1>Registreerimine</h1>
<?php
if(isSet($lisatudeesnimi))
{
    echo "<div id='snackbar'>Lisati $lisatudeesnimi</div>";
    echo '<script>

                // Get the snackbar DIV
                var sb = document.getElementById("snackbar");

                // Add the "show" class to DIV
                sb.className = "show";

                // After 3 seconds, remove the show class from DIV
                setTimeout(function(){ sb.className = sb.className.replace("show", ""); }, 3000);
         </script>';
}
?>
<form action="?page=registreerimine" method= "post">
    <dl>
        <dt>Eesnimi:</dt>
        <dd><input type="text" name="eesnimi" /></dd>
        <dt>Perekonnanimi:</dt>
        <dd><input type="text" name="perekonnanimi" /></dd>
        <dt><input type="submit" name="sisestusnupp" value="sisesta" /></dt>
    </dl>
</form>
<?php include('html-end.php'); ?>

