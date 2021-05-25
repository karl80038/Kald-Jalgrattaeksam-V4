<h1>Nime Lugemine</h1>
<form>
    Sisestage enda nimi:
    <input type="hidden" name="leht"
           value="<?=basename(__FILE__, ".php")?>">
    <input type="text" name="nimi" size="5">
    <input type="submit" value="OK">
</form>
<?php
if (isset($_REQUEST["nimi"]))
{
    if(empty($_REQUEST["nimi"]))
    {
        echo "<h3 style=color:red;>Vaja on sisestada enda nimi.<h3>";
    }
    else
    {
        echo "<h3>Tere tulemast, " . "<b style=color:black;>". $_REQUEST["nimi"] . "!</b></h3>";
    }
}
?>