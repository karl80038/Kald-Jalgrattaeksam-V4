<?php
include('html-begin.php');
?>
<h1>Pildi valimine</h1>
<form method="post" action="">
    <select name="images" id="images">
        <option value="">Vali pilt</option>
        <?php
        $catalog = 'images';
        $path=opendir($catalog);
        while($row = readdir($path))
        {
            if($row!='.' && $row!='..')
            {
                echo "<option value='$row'>$row</option>\n";
            }
        }
        ?>
    </select>
    <input type="submit" value="Näita">
    <input type="submit" value="Kuva juhuslik pilt" onclick="rndgen()">
</form>
<script>
    function rndgen()
    {
        var sel= document.getElementById(("images"));
        sel.selectedIndex = Math.floor(Math.random() * (sel.length - 1) + 1 );
    }
    function suurem1()
    {
        var img1 = document.getElementById("img1");
        // img1.style.width = 200px;
        // img1.style.height = 200px;
    }
</script>
<?php
    if(!empty($_POST['images']))
    {
        $max_width = 120;
        $max_height = 90;
        $image = $_POST['images'];
        $image_address = 'images/'.$image;
        $image_properties = getimagesize($image_address);

        $width = $image_properties[0];
        $height = $image_properties[1];
        $format = $image_properties[2];

            //suhtearvu leidmine
        if($width <= $max_width && $height<=$max_height)
        {
            $ratio = 1;
        } 
        elseif($width>$height)
        {
            $ratio = $max_width/$width;
        } 
        else 
        {
            $ratio = $max_height/$height;
        }
        //uute mõõtmete leidmine
        $decr_width = round($width*$ratio);
        $decr_height = round($height*$ratio);

        echo '<h3>Originaal pildi andmed</h3>';
        echo "Laius: $width<br>";
        echo "Kõrgus: $height<br>";
        echo "Formaat: $format<br>";
        echo '<h3>Uue pildi andmed</h3>';
        echo "Arvutamise suhe: $ratio <br>";
        echo "Laius: $decr_width<br>";
        echo "Kõrgus: $decr_height<br>";
        echo "<img width='$decr_width' src='$image_address'><br>";
    }
    include('html-end.php');
    // <!---->
    // <!--2. metshein.com Reegistreeri end kursusele PHP alused.-->
    // <!--<br>-->
    // <!--3. Tee lahti Harjutus 14. Töö pildifailidega,-->
    // <!--<br>-->
    // <!--4. Tee harjutus läbi ja paiguta valmis leht-->
    // <!--Töö piltidega lingi alla (kasuta tunnis-->
    // <!--tehtud PHP lehestik).-->
    // <!--Tee ka ülesanded harjutus 14 lehe lõpus!-->
    // <!--<br>-->
    // <!--5. Lisa  PHP lehestikku oma css kujundust. //-->
?>