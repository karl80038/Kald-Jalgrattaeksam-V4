<?php
require('html-begin.php');
include('hindamis-nav.php');
if(!empty($_REQUEST["jah"])){
    $kask=$yhendus->prepare(
        "UPDATE jalgrattaeksam SET slaalom=1 WHERE id=?");
    $kask->bind_param("i", $_REQUEST["id"]);
    $kask->execute();
}
if(!empty($_REQUEST["ei"])){
    $kask=$yhendus->prepare(
        "UPDATE jalgrattaeksam SET slaalom=2 WHERE id=?");
    $kask->bind_param("i", $_REQUEST["id"]);
    $kask->execute();
}
$kask=$yhendus->prepare("SELECT id, eesnimi, perekonnanimi 
     FROM jalgrattaeksam WHERE teooriatulemus>=9 AND slaalom=-1");
$kask->bind_result($id, $eesnimi, $perekonnanimi);
$kask->execute();
?>
<body>
<main>
<div class="main-container">    
    <title>Teooriaeksam</title>
    <h1>Slaalom</h1>

 
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
			  <td><form action='?page=slaalom' method= 'post'>
			         <input type='hidden' name='id' value='$id' />
                     <input type='submit' name='jah' value='Sooritas'/>
                     <input type='submit' name= 'ei' value='Ei sooritanud'/>
			      </form>
			  </td>
			</tr>
		  ";
    }
    ?>
</table>
</div>
<?php include('html-end.php'); ?>
