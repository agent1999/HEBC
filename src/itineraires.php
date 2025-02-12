<?php 
    //Méta-donnéesnavitia
    $titre="Itinéraires | HEBC";
    $date="09/03/2024";
    require("include/header.inc.php");
?>
        <main>
            <h1>Itinéraires</h1>
                <form method = "get" action="itineraires.php">
                    <fieldset style="display:inline-block;">
                        <legend>Rechercher un itinéraire</legend>
                        <div>
                            <label for="depart">Départ</label>
                            <?php
                                $value="";
                                if(isset($_GET["depart"]) && !empty($_GET["depart"])){
                                    $value=$_GET["depart"];
                                }
                                echo "<input list=\"departs\" id=\"depart\" name=\"depart\" value=\"$value\"/>\n";
                            ?>
                            <datalist id="departs">
                                <?php 
                                    echo station_options("datas/nom_gares.csv");
                                ?>
                            </datalist>
                            <label for="arrive">Arrivée</label>
                            <?php
                                $value="";
                                if(isset($_GET["arrive"]) && !empty($_GET["arrive"])){
                                    $value=$_GET["arrive"];
                                }
                                echo "<input list=\"arrives\" id=\"arrive\" name=\"arrive\" value=\"$value\"/>\n";
                            ?>
                            <datalist id="arrives">
                                <?php 
                                    echo station_options("datas/nom_gares.csv");
                                ?>
                            </datalist>
                        </div>
                        <div>
                            <input type="submit" value="Rechercher"/>
                        </div>
                    </fieldset>
                </form>
                
                <?php
                    try{
                        echo itineraires();
                    }catch(Exception $e){
                        echo $e->getMessage();
                    }
                ?>

<?php
    require("include/footer.inc.php");
?>