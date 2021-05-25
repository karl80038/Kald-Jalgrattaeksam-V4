<!-- © Karl-Erik Kald -->
<?php
// $computers = simplexml_load_file("baas.xml");
//otsing arvuti nime järgi
function searchByName($query)
{
  global $computers;
  $result = array();
  foreach ($computers -> arvuti as $comp)
  {
    if(substr(strtolower($comp -> nimi), 0, strlen($query)) == strtolower($query))
    {
      array_push($result, $comp);
    }        
  }
  return $result;
}
if(isset($_POST['Lisa_uude_faili']))
{
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
  if ($_REQUEST['wexistingFile'] != '')
  {
    $xmlDoc = new DOMDocument("1.0","UTF-8");
    $xmlDoc->preserveWhiteSpace = false;
    if (file_exists($_REQUEST['wexistingFile'].'.xml'))
    {
      $xmlDoc->load($_REQUEST['wexistingFile'].'.xml');
      $xml_root = $xmlDoc->documentElement;
      $xmlDoc->appendChild($xml_root);
    }
    else
    {
      $xml_root = $xmlDoc->createElement("arvutid");
      $xmlDoc->appendChild($xml_root);
    }
    $xmlDoc->formatOutput = true;
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
}
?>
<?php
include('html-begin.php');
?>
  <h2>XML faili toimingud</h2>
    <form action="?leht=Kald_XML_toimingud" method="post">
      <table>
        <td><label for = "computerName">Arvuti nimi: </label></td>
        <td><input type="text" name="computerName" id="computerName" placeholder="Siia sisestage arvuti nimi"></td>
        <tr>
          <td><label for = "computerReleaseYear">Arvuti väljalaske aasta: </label></td>
          <td><input type="text" name="computerReleaseYear" id="computerReleaseYear" placeholder="Siia sisestage arvuti väljalaske aasta"></td>
        </tr>
        <tr>
          <td><label for = "computerPrice">Arvuti hind: </label></td>
          <td> <input type="text" name="computerPrice" id="computerPrice" placeholder="Siia sisestage arvuti hind"></td>
        </tr>
      </table>
      <p><h3>Soovin...</h3></p>
        <input type="radio" name="option" id="newXML" value="newXML" onchange="saveOption()">
        <label for = "newXML">...väärtuse salvestada uude XML-faili</label>
        <br>
        <input type="radio" name="option" id="appendXML" value="appendXML" onchange="saveOption()">
        <label for = "appendXML">...väärtuse salvestada juba olemasolevasse XML faili (faili puudumisel luuakse uus XML-fail)</label>
        <br>
        <input type="radio" name="option" id="viewXML" value="viewXML" onchange="saveOption()">
        <label for = "viewXML">...kuvada olemasoleva XML-faili sisu</label>
        <br>
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
<?php    
if(isset($_REQUEST['Kuva_olemasolevast_failist']))
{
  $xmlfile = simplexml_load_file("./".$_REQUEST['rexistingFile'].".xml");
  echo "<table>";
  echo "<tr>";
  // foreach($xmlfile as $file)
  // {
    // echo "<th>".$item -> children()."</th>";
  foreach($xmlfile as $file)
  {
    echo "<tr>";
    // echo "<th>".$item -> children()."</th>";
    foreach($file->children() as $item)
    {
      echo "<td id='name'>".$item -> getName()." ";
      foreach($item -> children() as $child)
      {
        echo "".$child -> getName()." ";
      }
      echo "</td>";
    }      
    echo "</tr>";
    echo "<tr>";
    foreach($file->children() as $item)
    {
      echo "<tr>";
      echo "<td>".$item;
      foreach($item -> children() as $child)
      {
        echo $child." ";
      }
      echo "</td>";
      echo "</tr";
  
    }
    echo "</tr>";
  }
  // }       
  // echo "</tr>";
  // foreach($xmlfile as $file)
  // {
  //   // echo "<th>".$item -> children()."</th>";
  //   foreach($file->children() as $item)
  //   {
  //     echo "<tr>";
  //     echo "<td>".$item;
  //     foreach($item -> children() as $child)
  //     {
  //       echo $child." ";
  //     }
  //     echo "</td>";
  //     echo "</tr";
  //   }
  // }  
  echo "</table>";
}
?>
<script>
function saveOption()
{
  var newFile=document.getElementById("newXML");
  var appendFile=document.getElementById("appendXML");
  var viewFile=document.getElementById("viewXML");
  var wnewFileName = document.getElementById("write_newFileField");
  var wexistingFileName = document.getElementById("write_existingFileField");
  var rexistingFileName = document.getElementById("view_existingFileField");

  if (newFile.checked)
  {
    wexistingFileName.style.display = "none";
    rexistingFileName.style.display = "none";
    wnewFileName.style.display = "block";
  }

  else if (appendFile.checked) 
  {
    wexistingFileName.style.display = "block";
    rexistingFileName.style.display = "none";
    wnewFileName.style.display = "none";    
  }
  else if (viewFile.checked) 
  {
    wexistingFileName.style.display = "none";
    rexistingFileName.style.display = "block";
    wnewFileName.style.display = "none";    
  }
}
</script>
<?php
  include('html-end.php');
?>