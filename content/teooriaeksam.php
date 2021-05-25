<?php
    include('html-begin.php');
    include('hindamis-nav.php');
if(!empty($_REQUEST["teooriatulemus"])){
    $kask=$yhendus->prepare(
        "UPDATE jalgrattaeksam SET teooriatulemus=? WHERE id=?");
    $kask->bind_param("ii", $_REQUEST["teooriatulemus"], $_REQUEST["id"]);
    $kask->execute();
}
$kask=$yhendus->prepare("SELECT id, eesnimi, perekonnanimi 
     FROM jalgrattaeksam WHERE teooriatulemus=-1");
$kask->bind_result($id, $eesnimi, $perekonnanimi);
$kask->execute();
?>
<body>
<main>
<div class="main-container">    
    <title>Teooriaeksam</title>
    <h1>Teooriaeksami hindamine</h1>
    <br>
    Kui punktide arv on 9 või suurem, siis lubatakse järgmisele eksamile.
    <br><br>
<table>
    <tr>
        <th>eesnimi</th>
        <th>perekonnanimi</th>
        <th>punktid</th>
    </tr>
    <?php
    while($kask->fetch()){
        echo "
		    <tr>
			  <td>$eesnimi</td>
			  <td>$perekonnanimi</td>
			  <td><form action='?page=teooriaeksam' method= 'post'>
			         <input type='hidden' name='id' value='$id' />
					 <input type='text' name='teooriatulemus' />
					 <input type='submit' value='Sisesta tulemus' />
			      </form>
			  </td>
			</tr>
		  ";
    }
    ?>
</table>
</div>
<?php include('html-end.php');
