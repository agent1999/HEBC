<?php 
    //Méta-données
    $titre="Infos trafic | HEBC";
    $date="18/04/2024";
    require("include/header.inc.php");
?>
        <main>
            <h1>Infos trafic</h1>
                <?php 
                    if(isset($_GET["train"]) && !empty($_GET["train"])){
                        echo infostraffic();
                    }
                    $res = "\t\t\t<form method = \"get\" action=\"infostrafic.php\">\n";
                    $res.= "\t\t\t\t<fieldset style=\"display:inline-block;\">\n";
                    $res.= "\t\t\t\t\t<legend>Train - RER</legend>\n";
                    $res.= "\t\t\t\t\t<button type=\"submit\" name=\"train\" value=\"A\"><img src=\"images/rer_a.png\" alt=\"RER A\"/></button>\n";
                    $res.= "\t\t\t\t\t<button type=\"submit\" name=\"train\" value=\"B\"><img src=\"images/rer_b.png\" alt=\"RER B\"/></button>\n";
                    $res.= "\t\t\t\t\t<button type=\"submit\" name=\"train\" value=\"C\"><img src=\"images/rer_c.png\" alt=\"RER C\"/></button>\n";
                    $res.= "\t\t\t\t\t<button type=\"submit\" name=\"train\" value=\"D\"><img src=\"images/rer_d.png\" alt=\"RER D\"/></button>\n";
                    $res.= "\t\t\t\t\t<button type=\"submit\" name=\"train\" value=\"E\"><img src=\"images/rer_e.png\" alt=\"RER E\"/></button>\n";
                    $res.= "\t\t\t\t\t<button type=\"submit\" name=\"train\" value=\"H\"><img src=\"images/train_h.png\" alt=\"Train H\"/></button>\n";
                    $res.= "\t\t\t\t\t<button type=\"submit\" name=\"train\" value=\"J\"><img src=\"images/train_j.png\" alt=\"Train J\"/></button>\n";
                    $res.= "\t\t\t\t\t<button type=\"submit\" name=\"train\" value=\"K\"><img src=\"images/train_k.png\" alt=\"Train K\"/></button>\n";
                    $res.= "\t\t\t\t\t<button type=\"submit\" name=\"train\" value=\"L\"><img src=\"images/train_l.png\" alt=\"Train L\"/></button>\n";
                    $res.= "\t\t\t\t\t<button type=\"submit\" name=\"train\" value=\"N\"><img src=\"images/train_n.png\" alt=\"Train N\"/></button>\n";
                    $res.= "\t\t\t\t\t<button type=\"submit\" name=\"train\" value=\"P\"><img src=\"images/train_p.png\" alt=\"Train P\"/></button>\n";
                    $res.= "\t\t\t\t\t<button type=\"submit\" name=\"train\" value=\"R\"><img src=\"images/train_r.png\" alt=\"Train R\"/></button>\n";
                    $res.= "\t\t\t\t\t<button type=\"submit\" name=\"train\" value=\"U\"><img src=\"images/train_u.png\" alt=\"Train U\"/></button>\n";
                    $res.= "\t\t\t\t</fieldset>\n";       
                    $res.="\t\t\t</form>\n";
                    echo $res;
                ?>

<?php
    require("include/footer.inc.php");
?>