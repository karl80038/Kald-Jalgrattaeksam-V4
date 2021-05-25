<?php
require("html-begin.php");
include('hindamis-nav.php');
if(!empty($_REQUEST["jah"])){
    $kask=$yhendus->prepare(
        "UPDATE jalgrattaeksam SET t2nav=1 WHERE id=?");
    $kask->bind_param("i", $_REQUEST["id"]);
    $kask->execute();
}
if(!empty($_REQUEST["ei"])){
    $kask=$yhendus->prepare(
        "UPDATE jalgrattaeksam SET t2nav=2 WHERE id=?");
    $kask->bind_param("i", $_REQUEST["id"]);
    $kask->execute();
}
$kask=$yhendus->prepare("SELECT id, eesnimi, perekonnanimi 
     FROM jalgrattaeksam WHERE slaalom=1 AND ringtee=1 AND t2nav=-1");
$kask->bind_result($id, $eesnimi, $perekonnanimi);
$kask->execute();
?>
<!doctype html>
<body>
<main>
<div class="main-container">    
<h1>Tänavasõit</h1>

<table>
    <tr>
    <td>eesnimi</td>
	<td>perekonnanimi</td>
    <td>seis</td>
    </tr>
    <?php
    while($kask->fetch()){
        echo "
		    <tr>
			  <td>$eesnimi</td>
			  <td>$perekonnanimi</td>
			  <td><form action='?page=t2nav' method= 'post'>
			         <input type='hidden' name='id' value='$id' />
                     <input type='submit' name='jah' value='Sooritas'/>
                     <input type='submit' name= 'mittekorras' value='Ei sooritanud'/>
			      </form>
			  </td>
			</tr>
		  ";
    }
    ?>
</table>
</div>
<?php include('html-end.php'); ?>