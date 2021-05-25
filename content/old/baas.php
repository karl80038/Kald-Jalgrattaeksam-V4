<?php
$computers = simplexml_load_file("baas.xml");

//otsing arvuti nime järgi
function searchByName($query)
{
    global $computers;
    $result = array();
    foreach ($computers -> arvuti as $comp)
    {
        if(substr(strtolower($comp -> nimi), 0, strlen($query)) == strtolower($query))
            array_push($result, $comp);
        
    }
    return $result;
}


if(isset($_POST['Lisa_uude_faili']))
{
  // try
  // {
  //   $xmlDoc = new DOMDocument("1.0","UTF-8");
  //   $xmlDoc->formatOutput = true;
  //   $xmlDoc->preserveWhiteSpace = false;
        
  //   $xml_root = $xmlDoc->createElement("arvutid");
  //   $xmlDoc->appendChild($xml_root);
        
  //   $xml_toode = $xmlDoc->createElement("arvuti");
  //   $xmlDoc->appendChild($xml_toode);
        
  //   $xml_root->appendChild($xml_toode);
      
  //   $xml_toode->appendChild($xmlDoc->createElement('nimi',$_REQUEST['computerName']));
  //   $xml_toode->appendChild($xmlDoc->createElement('aasta',$_REQUEST['computerReleaseYear']));
  //   $xml_toode->appendChild($xmlDoc->createElement('hind',$_REQUEST['computerPrice']));
          
  //   $xmlDoc->save($_REQUEST['newFile'].'.xml');
  // }
  // catch (Exception $ex)
  // {
  //   echo "Faili loomine nurjus. Probleemiks on enamasti tühjad väljad. Veenduge, et kõik väljad oleks täidetud enne vormi edastamist.<br>";
  //   echo $ex;
  // }
  try
  {
    $xmlDoc = new DOMDocument("1.0","UTF-8");
    $xmlDoc->formatOutput = true;
    $xmlDoc->preserveWhiteSpace = false;
        
    $xml_root = $xmlDoc->createElement("arvutid");
    $xmlDoc->appendChild($xml_root);
        
    $xml_toode = $xmlDoc->createElement("arvuti");
    $xmlDoc->appendChild($xml_toode);
        
    $xml_root->appendChild($xml_toode);
      
    // $xml_toode->appendChild($xmlDoc->createElement('nimi',$_REQUEST['computerName']));
    // $xml_toode->appendChild($xmlDoc->createElement('aasta',$_REQUEST['computerReleaseYear']));
    // $xml_toode->appendChild($xmlDoc->createElement('hind',$_REQUEST['computerPrice']));
    unset($_POST['Lisa_uude_faili']);
    unset($_POST['option']);
    unset($_POST['newFile']);
    unset($_POST['wexistingFile']);
    unset($_POST['rexistingFile']);
    foreach($_POST as $voti=>$vaartus)
    {
        $kirje = $xmlDoc->createElement($voti,$vaartus);
        $xml_toode->appendChild($kirje);
    }      
    $xmlDoc->save($_REQUEST['newFile'].'.xml');
  }
  catch (Exception $ex)
  {
    echo "Faili loomine nurjus. Probleemiks on enamasti tühjad väljad. Veenduge, et kõik väljad oleks täidetud enne vormi edastamist.<br>";
    echo $ex;
  }

}
if(isset($_POST['Lisa_olemasolevasse_faili']))
{
  // try
  // {
  //   $xmlDoc = new DOMDocument("1.0","UTF-8");
  //   $xmlDoc->preserveWhiteSpace = false;
  //   $xmlDoc->load($_REQUEST['existingFile'].'.xml');
  //   $xmlDoc->formatOutput = true;
    
  //   $xml_root = $xmlDoc->documentElement;
  //   $xmlDoc->appendChild($xml_root);
    
  //   $xml_toode = $xmlDoc->createElement("arvuti");
  //   $xmlDoc->appendChild($xml_toode);
    
  //   $xml_root->appendChild($xml_toode);
  
  //   $xml_toode->appendChild($xmlDoc->createElement('nimi',$_REQUEST['computerName']));
  //   $xml_toode->appendChild($xmlDoc->createElement('aasta',$_REQUEST['computerReleaseYear']));
  //   $xml_toode->appendChild($xmlDoc->createElement('hind',$_REQUEST['computerPrice']));

  //   $xmlDoc->save($_REQUEST['existingFile'].'.xml');
  // }
  // catch (Exception $ex)
  // {
  //   echo "Olemasolevasse faili ei õnnestunud kirjutada. Veenduge, et fail on olemas ning failinime väli oleks täidetud.<br>";
  //   echo $ex;
  // }
  $xmlDoc = new DOMDocument("1.0","UTF-8");
  $xmlDoc->preserveWhiteSpace = false;
  $xmlDoc->load($_REQUEST['wexistingFile'].'.xml');
  $xmlDoc->formatOutput = true;
  
  $xml_root = $xmlDoc->documentElement;
  $xmlDoc->appendChild($xml_root);
  
  $xml_toode = $xmlDoc->createElement("arvuti");
  $xmlDoc->appendChild($xml_toode);
  
  $xml_root->appendChild($xml_toode);
  
  unset($_POST['Lisa_olemasolevasse_faili']);
  unset($_POST['option']);
  unset($_POST['newFile']);
  unset($_POST['wexistingFile']);
  unset($_POST['rexistingFile']);
  foreach($_POST as $voti=>$vaartus)
  {
      $kirje = $xmlDoc->createElement($voti,$vaartus);
      $xml_toode->appendChild($kirje);
  }
  $xmlDoc->save($_REQUEST['wexistingFile'].'.xml');    
}
if(isset($_POST['Kuva_olemasolevast_failist']))
{

}


?>
<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>XML andmete lugemine PHP abil</title>
    <link rel = "stylesheet" type="text/css" href="style.css">
    <script src="script.js"></script>
</head>
<body>
  <h1>Andmed baas.xml failist</h1>
  Esimese arvuti nimi on 
  <?php
  echo $computers -> arvuti[0] -> nimi; 
  //loeb XML atribuuti
  echo "<p>Arvuti id</p>".$computers -> arvuti[0] -> attributes() -> id;

  ?>
  <table>
    <tr>
        <th>Arvuti nimi</th>
        <th>Arvuti hind</th>
        <th>Aasta</th>
        <th>Monitor</th>
        <th>Monitori suurus</th>
    </tr>
    <?php
        foreach($computers -> arvuti as $comp)
        {
            echo "<tr>";
            echo "<td>".($comp -> nimi)."</td>";
            echo "<td>".($comp -> hind)."</td>";
            echo "<td>".($comp -> aasta)."</td>";
            echo "<td>".($comp -> monitor -> nimi)."</td>";
            echo "<td>".($comp -> monitor -> suurus)."</td>";
            echo "</tr>";
        }
        

    ?>
    <br>
  </table>
  <form action="?" method="post">
      <label for = "search">Otsing: </label>
      <input type="text" name="search" id="search" placeholder="Otsi arvutinime järgi">
      <input type="submit" value="Otsi">  
  </form>
  <ul>     
    <?php
        $count = 0;
        if (!empty($_POST["search"]))
        {
            $result = searchByName($_POST["search"]);
            foreach ($result as $comp)
            {
                echo "<li>";
                echo $comp -> nimi.", ".$comp -> aasta;
                echo "</li>";
            }
        } 
                    
    ?>
  </ul>
  <h2>XML faili toimingud</h2>
  <form action="?" method="post">
      <label for = "computerName">Arvuti nimi: </label>
      <input type="text" name="computerName" id="computerName" placeholder="Siia sisestage arvuti nimi">
      <br>
      <label for = "computerReleaseYear">Arvuti väljalaske aasta: </label>
      <input type="text" name="computerReleaseYear" id="computerReleaseYear" placeholder="Siia sisestage arvuti väljalaske aasta">
      <br>
      <label for = "computerPrice">Arvuti hind: </label>
      <input type="text" name="computerPrice" id="computerPrice" placeholder="Siia sisestage arvuti hind">
      <br>
     <p>Soovin...</p>
      <input type="radio" name="option" id="newXML" value="newXML" onchange="saveOption()">
      <label for = "newXML">...väärtuse salvestada uude XML faili</label>
      <input type="radio" name="option" id="appendXML" value="appendXML" onchange="saveOption()">
      <label for = "appendXML">...väärtuse salvestada juba olemasolevasse XML faili</label>
      <input type="radio" name="option" id="viewXML" value="viewXML" onchange="saveOption()">
      <label for = "viewXML">...kuvada olemasoleva XML faili sisu</label>
      <div id="write_newFileField">
        <br>
        <input type="text" name="newFile" id="newFile" placeholder="Sisestage loodava faili nimi" style="width: 350px;">
        <br><br>
        <input type="submit" name="Lisa_uude_faili" id="Lisa_uude_faili" value="Edasta"> 
      </div>
      <div id="write_existingFileField">
        <br>
        <input type="text" name="wexistingFile" id="wexistingFile" placeholder="Sisestage täiendatava faili nimi" style="width: 350px;">
        <br><br>
        <input type="submit" name="Lisa_olemasolevasse_faili" id="Lisa_olemasolevasse_faili" value="Edasta"> 
      </div>
      <div id="view_existingFileField">
        <br>
        <input type="text" name="rexistingFile" id="rexistingFile" placeholder="Sisestage kuvatava faili nimi" style="width: 350px;">
        <br><br>
        <input type="submit" name="Kuva_olemasolevast_failist" id="Kuva_olemasolevast_failist" value="Edasta"> 
      </div>
 
  </form>
  <h2> RSS uudused </h2>
  <?php
    // $feed = simplexml_load_file('https://www.err.ee/rs');
    // $linkide_arv = 10;
    // $loendur = 1;

    // foreach ($feed -> channel -> item as $item)
    // {
    //     if ($loendur <= $linkide_arv)
    //     {
    //         echo "<li>";
    //         echo "<a href='$item -> link' target = '_blank'>
    //         $item -> title</a>";
    //         echo "</li>";
    //         $loendur++;
    //     }
    // }
  ?>

</body>
</html>