<?php
    //Uue laulu lisamine
    if(!empty($_REQUEST["uuslaul"]))
    {
        $command = $dbConnection -> prepare("INSERT INTO laulud(pealkiri, lisamisaeg, kommentaarid) VALUES (?, NOW(), ' ')");
        $command -> bind_param("s", $_REQUEST["uuslaul"]);
        $command -> execute();
        // header("Location: $_SERVER[PHP_SELF]?leht=haldus");
        // $dbConnection -> close();
    }
    // Peitmine, avalik = 0
    if (!empty($_REQUEST["peitmine"]))
    {
    $command = $dbConnection -> prepare("UPDATE laulud SET avalik = 0 WHERE id = ?");
    $command -> bind_param("i", $_REQUEST["id"]);
    $command -> execute();
    }
    // Avalikustamine, avalik = 1
    if (!empty($_REQUEST["avamine"]))
    {
    $command = $dbConnection -> prepare("UPDATE laulud SET avalik = 1 WHERE id = ?");
    $command -> bind_param("i", $_REQUEST["id"]);
    $command -> execute(); 
    }if (!empty($_REQUEST["kustutamine"]))
    {
    $command = $dbConnection -> prepare("DELETE FROM laulud WHERE id = ?");
    $command -> bind_param("i", $_REQUEST["id"]);
    $command -> execute(); 
    }
?>
<?php
    include('html-begin.php');
    echo "<h1>Laulude haldus</h1>";
    echo "<form action='?leht=haldus' method='post'>";
    echo "<label for = 'laulunimi'>Laulu nimi: </label>";
    echo "<input type='text' id='uuslaul' name='uuslaul' placeholder='Sisestage siia laulunimi'>";
    echo "<input type='submit' value='Lisa'>";
    echo "</form>";
?>
<?php
    $items;
    $cnt = 0;
    $index = 0;
    $command = $dbConnection -> prepare("SELECT id, pealkiri, avalik FROM laulud");    
    $command -> bind_result($id, $pealkiri, $avalik);
    $command -> execute();
    while($command -> fetch())
    {
        $song = array($id, $pealkiri, $avalik);
        $items[$index] = $song;
        $cnt += 1;
        $index += 1;
    }
    if ($cnt > 0)
    {
        echo "<table>";
        echo "<td><h3><b>Laulu nimi</b></h3></td>";
        echo "<td><h3><b>Hetkeseis</b></h3></td>";
        echo "<td><h3><b>Toimingud</b></h3></td>";
        foreach ($items as $item)
        {
            $avatekst = "Ava";
            $param = "avamine";
            $seisund = "Peidetud";
            echo "<tr>";
            echo "<td>$item[1]</td>";
            if($item[2] == 1)
            {
                $avatekst = "Peida";
                $param = "peitmine";
                $seisund = "Avatud"; 
            }
            echo "<td>".$seisund."</td>";
            echo "<div class='button-container'><td id='bcontain'><form action = '?leht=haldus' method = 'post'><input type = 'hidden' name = 'id' value = '$item[0]'/>
            <input type = 'submit' name = $param value = '$avatekst'/>
            </form>";
            echo "<form action = '?leht=haldus' method = 'post'><input type = 'hidden' name = 'id' value = '$item[0]'/>
            <input type = 'submit' name = 'kustutamine' value = 'Kustuta'/>
            </form></td></div>";
            echo "</tr>";
        }
        echo "</table>";
    }
    else
    {
        echo "Laulude nimekiri on hetkel tühi. Laulude lisamiseks kasutage üleval olevat vormi.";
    }
    $dbConnection -> close();
    include('html-end.php');
?>