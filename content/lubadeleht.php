<?php
require('html-begin.php');
if(!empty($_REQUEST["vormistan"])){
$kask=$yhendus->prepare(
"UPDATE jalgrattaeksam SET luba=1 WHERE id=?");
$kask->bind_param("i", $_REQUEST["id"]);
$kask->execute();
}
$kask=$yhendus->prepare(
"SELECT id, eesnimi, perekonnanimi, teooriatulemus,
slaalom, ringtee, t2nav, luba FROM jalgrattaeksam;");
$kask->bind_result($id, $eesnimi, $perekonnanimi, $teooriatulemus,
$slaalom, $ringtee, $t2nav, $luba);
$kask->execute();

function asenda($nr)
{
    if($nr==-1){return ".";} //tegemata
    if($nr== 1){return "korras";}
    if($nr== 2){return "ebaõnnestunud";}
    return "Tundmatu number";
}
function eksport_csv() 
{

}
?>
<main>
<h1>Lõpetamine</h1>
<div style="overflow-x:auto;overflow-y:auto;">
<table>
    <tr>
        <th>Eesnimi</th>
        <th>Perekonnanimi</th>
        <th>Teooriaeksam</th>
        <th>Slaalom</th>
        <th>Ringtee</th>
        <th>Tänavasõit</th>
        <th>Lubade väljastus</th>
    </tr>
    
    <?php
    $tulemused;
    $index = 0;
    while($kask->fetch()){
        $asendatud_slaalom=asenda($slaalom);
        $asendatud_ringtee=asenda($ringtee);
        $asendatud_t2nav=asenda($t2nav);
        $loalahter=".";
        if($luba==1){$loalahter="Väljastatud";}
        if($luba==-1 and $t2nav==1){
            $loalahter="
            <form action='?page=lubadeleht' method= 'post'>
            <input type='hidden' name='id' value='$id' />
            <input type='submit' name='vormistan' value='Vormista'/>
            </form>";
        }
        echo "
		     <tr>
			   <td>$eesnimi</td>
			   <td>$perekonnanimi</td>
			   <td>$teooriatulemus</td>
			   <td>$asendatud_slaalom</td>
			   <td>$asendatud_ringtee</td>
			   <td>$asendatud_t2nav</td>
			   <td>$loalahter</td>
			 </tr>
           ";
           
    }
    ?>
</table>
</div>
<?php include('html-end.php'); ?>

