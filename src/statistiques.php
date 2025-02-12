<?php

    //Méta-données
    $titre="Statistiques | HEBC";
    $date="20/04/2024";
    require("include/header.inc.php");
?>
        <main>
            <h1>Statistiques</h1>
                <section>
                    <h2>Nombre de voyageurs</h2>
                        <?php
                            echo "<p>".afficheHits()." visiteurs au total depuis le lancement du site.</p>";
                        ?>
                </section>
                <section>
                    <h2>Gares les plus populaires</h2>
                        <img src="bargraph.php" alt="Histogramme.svg"/>
                </section>

<?php
    require("include/footer.inc.php");
?>