<?php
include('html-begin.php');
?>
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
        echo "Vaja on sisestada enda nimi.";
    }
    else
    {
        echo "Tere tulemast, " . $_REQUEST["nimi"];
    }
}
include('html-end.php');
?>