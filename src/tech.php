<?php 
    //Méta-données
    $titre="Démonstration | HEBC";
    $date="09/03/2024";
    require("include/header.inc.php");
?>
        <main>
            <h1>Point d'avancement numéro 1</h1>
                <section id="section1">
                    <h2>Prise en main JSON et XML</h2>
                    <article>
                        <h3>NASA</h3>
                        <?php  
                            echo nasa(); 
                        ?>
                    </article>
                    <article>
                        <h3>geoPlugin</h3>
                        <?php
                            echo geoPlugin();
                        ?>
                    </article>
                    <article>
                        <h3>ipinfo.io</h3>
                        <?php
                            echo ipinfo();
                        ?>
                    </article>
                    <article>
                        <h3>WhatIsMyIP.com</h3>
                        <?php
                            echo whatismyip();
                        ?>
                    </article>
                </section>

<?php
    require("include/footer.inc.php");
?>