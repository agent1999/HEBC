<?php    
    declare(strict_types=1);
    require_once("./include/functions.inc.php");

    //Cookies
    setcookie('user_theme', 'light_theme', time()+3600*24, '/', '', true, true);
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <!--Méta-données avec les 5W et autres-->
        <title><?php echo $titre;?></title>
        <meta charset="utf-8"/>
        <meta name="titre" content="<?php echo $titre;?>"/>
        <meta name="description" content="Page <?php echo $titre;?> du projet sur les RER et trains"/>
        <meta name="auteur" content="agent1999 et Goboun"/>
        <meta name="date" content="<?php echo $date;?>"/>
        <meta name="lieu" content="CY CERGY PARIS UNIVERSITÉ, 2 Avenue Adolphe Chauvin, 95300 Pontoise"/>

        <!--CSS-->
        <?php
            //Si le client a cliqué sur l'un des boutons du menu pour les modes, alors on redéfinit le cookie
            if(isset($_GET["style"])) {
                $sty = $_GET["style"];
                if($sty === "night") {
                    setcookie('user_theme', 'dark_theme');
                    echo '<link rel="stylesheet" type="text/css" href="alternatifs.css"/>';
                } else {
                    //rien
                    setcookie('user_theme', 'light_theme');           
                    echo '<link rel="stylesheet" type="text/css" href="styles.css"/>';
                }
            } 
            //Par défaut si aucun mode est choisi, c'est en fonction du cookie
            else {
                if(isset($_COOKIE['user_theme'])){
                    if($_COOKIE['user_theme']==='dark_theme'){
                        echo '<link rel="stylesheet" type="text/css" href="alternatifs.css"/>';
                    }
                    else{
                        echo '<link rel="stylesheet" type="text/css" href="styles.css"/>';
                    }
                }
                else{
                    setcookie('user_theme', 'light_theme');
                    echo '<link rel="stylesheet" type="text/css" href="styles.css"/>';
                }
            }
        ?>

        <!--favicon.ico-->
        <link rel="icon" href="/images/favicon.ico"/>

        <!--Pour les données du visiteur de la page tech-->
        <script src="http://www.geoplugin.net/javascript.gp"></script>

    </head>

    <body> 

        <!--Menu de navigation et bannière-->
        <header>
            <nav>
                <a class ="crumb" href="index.php">Home</a>
                <a class ="crumb" href="itineraires.php">Itinéraires</a>
                <a class ="crumb" href="horaires.php">Horaires</a>
                <a class ="crumb" href="infostrafic.php">Infos trafic</a>
                <a class ="crumb" href="statistiques.php">Statistiques</a>
            </nav>
            <nav>
                <a class ="jour" href="?style=day">Mode jour</a>
                <a class ="nuit" href="?style=night">Mode nuit</a>
            </nav>
            <?php
                $base64=afficheLogo();
                echo "<img class=\"header\" src=\"data:image/png;base64,".$base64."\" alt=\"\"/>";
            ?>
            
        </header>

        <?php
            updateHits();
            updateCompteur();
        ?>

    