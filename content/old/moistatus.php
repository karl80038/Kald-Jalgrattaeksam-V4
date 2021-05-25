<?php
    date_default_timezone_set("Europe/Tallinn");
?>
<?php
    $city1 = "Tallinn";
    $city2 = "Tartu";
    $city3 = "Pärnu";
    $city4 = "Narva";
    $city5 = "Haapsalu";
    $question1 = "_" . substr($city1, 1, strlen($city1));
    $question2 = "_" .substr($city2, 1, strlen($city1));
    $question3 = "_" .substr($city3, 1, strlen($city1));
    $question4 = "_" .substr($city4, 1, strlen($city1));
    $question5 = "_" .substr($city5, 1, strlen($city1));
    include('html-begin.php');
    echo "<h1>Mis on järgnevate linnade esimeseks täheks?</h1>";
    echo "<br>";
    echo "<div id='info'> Algustäht vastuses võib olla sisestatud kas suure või väikse tähega, vastuse esimene täht teisendatakse automaatselt suureks täheks.
    <br> Vastusesse võib märkida ainult tähe, millega linnanimi algab, ent lubatud on ka vastus <br> täissõnana kirjutada.</div>";
?>
<br><br>
<form action="?leht=moistatus" method="post">
    <?php echo $question1;?>
    <br>
    Minu vastus: <input type = "text" name="txt1">
    <br>
    <?php echo $question2; ?>
    <br>
    Minu vastus: <input type = "text" name="txt2">
    <br>
    <?php echo $question3; ?>
    <br>
    Minu vastus: <input type = "text" name="txt3">
    <br>
    <?php echo $question4; ?>
    <br>
    Minu vastus: <input type = "text" name="txt4">
    <br>
    <?php echo $question5; ?>
    <br>
    Minu vastus: <input type = "text" name="txt5">
    <br><br>
    <input type="submit" value="Esita vastus">
    <br><br>
</form>
<?php
    if (isset($_REQUEST["txt1"]))
    {
        $validationResult;
        $corrl1 = substr ($city1, 0, 1);
        $corrl2 = substr ($city2, 0, 1);
        $corrl3 = substr ($city3, 0, 1);
        $corrl4 = substr ($city4, 0, 1);
        $corrl5 = substr ($city5, 0, 1);
        $usrAnsw1 = substr (strtoupper ($_REQUEST["txt1"]), 0, 1);
        $usrAnsw2 = substr (strtoupper ($_REQUEST["txt2"]), 0, 1);
        $usrAnsw3 = substr (strtoupper ($_REQUEST["txt3"]), 0, 1);
        $usrAnsw4 = substr (strtoupper ($_REQUEST["txt4"]), 0, 1);
        $usrAnsw5 = substr (strtoupper ($_REQUEST["txt5"]), 0, 1);
        $submitTimeStamp = date("d.m.Y H:i:s" ,strtotime("now"));

        $command = $dbConnection -> prepare("INSERT INTO game(question, answer, usrAnswer, correct, submitdatetime) VALUES (?,?,?,?,?)");
            
        if ($usrAnsw1 == $corrl1) {
            $validationResult = "Correct";
        }
        else {
            $validationResult = "Incorrect";
        }
        //Anname käsu päringutele parameetrid
        $command -> bind_param("sssss", $question1, $city1, $usrAnsw1, $validationResult, $submitTimeStamp);
    
        //Käivitame käsu
        $command -> execute();

        if ($usrAnsw2 == $corrl2) {
            $validationResult = "Correct";
        }
        else {
            $validationResult = "Incorrect";
        }
        $command -> bind_param("sssss", $question2, $city2, $usrAnsw2, $validationResult, $submitTimeStamp);

        $command -> execute();

        if ($usrAnsw3 == $corrl3) {
            $validationResult = "Correct";
        }
        else {
            $validationResult = "Incorrect";
        }
        
        $command -> bind_param("sssss", $question3, $city3, $usrAnsw3, $validationResult, $submitTimeStamp);

        $command -> execute();

        if ($usrAnsw4 == $corrl4) {
            $validationResult = "Correct";
        }
        else {
            $validationResult = "Incorrect";
        }
        
        $command -> bind_param("sssss", $question4, $city4, $usrAnsw4, $validationResult, $submitTimeStamp);

        $command -> execute();

        if ($usrAnsw5 == $corrl5) {
            $validationResult = "Correct";
        }
        else {
            $validationResult = "Incorrect";
        }      
        $command -> bind_param("sssss", $question5, $city5, $usrAnsw5, $validationResult, $submitTimeStamp);
        $command -> execute();
        //Aadressiribas päringuparameetrite kustutamine   
        //Sulge ühendus andmebaasiga
    }
?>
<?php
    //Andmete lugemine tabelist ning nende kuvamine
    echo "<h1>Tulemused</h1>";
?>
<table style="width:50%">
    <tr>
        <th>Küsimus</th>
        <th>Vastus</th> 
        <th>Kasutaja vastus</th>
        <th>Hinnang</th>
        <th>Vastus esitatud</th>
    </tr>
<?php      
    // fetch() - tagastab andmed, mis on olemas andmebaasis        
    $command = $dbConnection -> prepare("SELECT question, answer, usrAnswer, correct, submitdatetime FROM game");
    $command -> bind_result($q1, $a1, $a2, $c1, $d1);
    $command -> execute();
    while($command -> fetch())
    {
        $ratingEST;
        if ($c1 == "Correct")
        {
            $ratingEST = "Õige!";
        }
        else 
        {
            $ratingEST = "Vale!";
        }
        echo "<tr>";
        echo    "<td>" .$q1. "</td>";
        echo    "<td>" .$a1. "</td>";
        echo    "<td>" .$a2."</td>";
        echo    "<td>" .$ratingEST."</td>";
        echo    "<td>" .$d1."</td>";
        echo "</tr>";
    }
    echo "</table>";
    $dbConnection -> close();    
    include('html-end.php');
?>