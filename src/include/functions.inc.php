<?php
    declare(strict_types=1);

///////////////POUR LE POINT D'AVANCEMENT NUMERO 1
    
    /**
     * Affiche l'image du jour de la NASA
     * @author agent1999 et Goboun
     * @return string res la source de l'image du jour de la nasa
     */
    function nasa():string{
        $url = "https://api.nasa.gov/planetary/apod?api_key=AFVBqyZr9EPPLjhe1oZKnxJYomO8V04zHtiDnYfG&date=";
        $annee = date("o");
        $mois = date("m");
        $jour = date("d");
        $jsonEncode = file_get_contents($url.$annee."-".$mois."-".$jour);
        $jsonDecode = json_decode($jsonEncode, true);
        $res = "<figure>\n";
            $res.= "<img src=\"".$jsonDecode["url"]."\" alt=\"contacter webmaster\" width=\"500\"/>";
            $res.= "\t\t\t\t<figcaption>\n\t\t\t\t\tL'image du jour de la NASA\n\t\t\t\t</figcaption>\n";
        $res.= "\t\t\t</figure>";
        return $res;
    }

    /**
     * Affiche sous forme de liste les caractéristiques géographiques du visiteur de la page
     * @author agent1999 et Goboun
     * @return string res la liste des attributs géographiques
     */
    function geoPlugin():string{
        $location = 'http://www.geoplugin.net/xml.gp?ip='.$_SERVER['REMOTE_ADDR'];
        $xml = simplexml_load_file($location);
        $res = "<ul>\n";
            $res.= "\t\t\t\t\t<li>Ville : $xml->geoplugin_city</li>\n";
            $res.= "\t\t\t\t\t<li>Département : $xml->geoplugin_regionCode $xml->geoplugin_regionName</li>\n";
            $res.= "\t\t\t\t\t<li>Région : $xml->geoplugin_region</li>\n";
            $res.= "\t\t\t\t\t<li>Pays : $xml->geoplugin_countryCode $xml->geoplugin_countryName</li>\n";
            $res.= "\t\t\t\t\t<li>Continent : $xml->geoplugin_continentCode $xml->geoplugin_continentName</li>\n";
            $res.= "\t\t\t\t\t<li>Latitude : $xml->geoplugin_latitude</li>\n";
            $res.= "\t\t\t\t\t<li>Longitude : $xml->geoplugin_longitude</li>\n";
        $res.= "\t\t\t\t</ul>\n";
        return $res;
    }

    /**
     * Affiche sous forme de liste les caractéristiques de l'adresse IP du visiteur de la page
     * @author agent1999 et Goboun
     * @return string res la liste les attributs de l'ip
     */
    function ipinfo():string{
        $url = "https://ipinfo.io/".$_SERVER["REMOTE_ADDR"]."/geo";
        $jsonEncode = file_get_contents($url);
        $jsonDecode = json_decode($jsonEncode, true);
        $res = "<ul>\n";
            $res.= "\t\t\t\t\t\t<li>Code Postal : ".$jsonDecode["postal"]."</li>\n";
            $res.= "\t\t\t\t\t\t<li>Ville : ".$jsonDecode["city"]."</li>\n";
            $res.= "\t\t\t\t\t\t<li>Région : ".$jsonDecode["region"]."</li>\n";
            $res.= "\t\t\t\t\t\t<li>Pays : ".$jsonDecode["country"]."</li>\n";
            $res.= "\t\t\t\t\t\t<li>Localisation : ".$jsonDecode["loc"]."</li>\n";
        $res.= "\t\t\t\t\t</ul>\n";
        return $res;
    }

    /**
     * Affiche sous forme de liste les caractéristiques de l'adresse IP du visiteur de la page à l'aide d'une api différente
     * @author agent1999 et Goboun
     * @return string res la liste des attributs de l'ip
     */
    function whatismyip():string{
        $location = "https://api.whatismyip.com/ip-address-lookup.php?key=8feb2ac1b4522a8cf6b8011674431ef5&input=".$_SERVER["REMOTE_ADDR"]."&output=xml";
        $xml = simplexml_load_file($location);
        //Faire print_r($xml) pour voir le contenu et comprendre ce que ça fait
        $server_data = $xml->server_data;
        //Pareil avec $server_data
        $res = "<ul>\n";
            $res.= "\t\t\t\t\t<li>Ville : $server_data->postalcode $server_data->city</li>\n";
            $res.= "\t\t\t\t\t<li>Région : $server_data->region</li>\n";
            $res.= "\t\t\t\t\t<li>Pays : $server_data->country</li>\n";
            $res.= "\t\t\t\t\t<li>Latitude : $server_data->latitude</li>\n";
            $res.= "\t\t\t\t\t<li>Longitude : $server_data->longitude</li>\n";
        $res.= "\t\t\t\t</ul>\n";
        return $res;
    }

///////////////FIN POINT AVANCEMENT NUMERO 1

///////////////FONCTIONS POUR LES RER ET LES TRAINS

    /**
     * Affiche une liste des informations des meilleurs trajet au moment même entre le départ et l'arrivée
     * @author agent1999 et Goboun
     * @return string res la liste des meilleurs trajet
     */
    function itineraires():string{
        $res = "";
        if((isset($_GET["depart"]) && !empty($_GET["depart"]))
            &&(isset($_GET["arrive"]) && !empty($_GET["arrive"]))){
                /**
                 * VERIFICATION
                 * Si quelqu'un écrit exactement la même gare au départ et à l'arrivée, il y a une exception
                 */
                assert(strcmp($_GET["depart"], $_GET["arrive"]), new Exception("<p style=text-align:center;>La gare de départ et la gare d'arrivée doivent être différentes.</p>"));
                //DEPART
                //Traitement : remplacer les espaces par des tirets car l'api n'aime pas quand on met des espaces
                $depart = str_replace(" ", "-", $_GET["depart"]);
                $urlDepart = "https://23fa1a0c-f611-4566-bbfc-ec2829f8ba83@api.navitia.io/v1/coverage/fr-idf/places?q=".$depart;
                $repDepart = file_get_contents($urlDepart);
                $dataDepart = json_decode($repDepart, true);
                $placesDepart = $dataDepart["places"];
                $zeroDepart = $placesDepart["0"];
                $idDepart = $zeroDepart["id"];
                //ARRIVÉE
                //Traitement : remplacer les espaces par des tirets car l'api n'aime pas quand on met des espaces
                $arrive = str_replace(" ", "-", $_GET["arrive"]);
                $urlArrive = "https://23fa1a0c-f611-4566-bbfc-ec2829f8ba83@api.navitia.io/v1/coverage/fr-idf/places?q=".$arrive;
                $repArrive = file_get_contents($urlArrive);
                $dataArrive = json_decode($repArrive, true);
                $placesArrive = $dataArrive["places"];
                $zeroArrive = $placesArrive["0"]; //"0"
                $idArrive = $zeroArrive["id"];
                //TRAJET
                $urlTrajet = "https://23fa1a0c-f611-4566-bbfc-ec2829f8ba83@api.navitia.io/v1/coverage/fr-idf/journeys?from=".$idDepart."&to=".$idArrive."&";
                $repTrajet = file_get_contents($urlTrajet);
                $dataTrajet = json_decode($repTrajet, true);
                $journeys = $dataTrajet["journeys"];
                //Affiche les 5 premiers trajets, à modifier ici si nécessaire
                for($i=0;$i<5;$i++){
                    if(isset($journeys[$i])){
                        $journey = $journeys[$i];
                        $sections = $journey["sections"];
                        //La 1ère et la dernière ne contiennent pas de réelles informations
                        array_shift($sections);
                        array_pop($sections);
                        
                        $departure_date_time = $sections[0]["departure_date_time"];
                        $departure_time = date("H:i:s", strtotime($departure_date_time));
                        $res .= "\t\t\t\t<section>\n\t\t\t\t\t<h2>Trajet numéro ".($i+1).", départ à $departure_time</h2>\n";

                        $res .= "\t\t\t\t\t<ul>\n"; 
                        
                        foreach($sections as $key => $value){
                            if(array_key_exists("display_informations", $sections[$key])){
                                $departure_date_time = $sections[$key]["departure_date_time"];
                                $departure = date("H:i:s", strtotime($departure_date_time));   
                                $arrival_date_time = $sections[$key]["arrival_date_time"];
                                $arrival = date("H:i:s", strtotime($arrival_date_time));
                                $from = $sections[$key]["from"];
                                $to = $sections[$key]["to"];
                                $display_informations = $sections[$key]["display_informations"];
                                $res.="\t\t\t\t\t\t<li>".$display_informations["commercial_mode"]." ".$display_informations["label"]." ".$display_informations["direction"].", depuis ".$from["name"]." à ".$departure." jusqu'à ".$to["name"]." à ".$arrival."</li>\n";
                            }
                        }
    
                        $res.="\t\t\t\t\t</ul>\n";

                        $arrival_date_time = $sections[$key]["arrival_date_time"];
                        $arrival_time = date("H:i:s", strtotime($arrival_date_time));
                        $res .= "\t\t\t\t\t<p>Arrivée à $arrival_time</p>\n\t\t\t\t</section>\n";
                    }
                }
        }
        return $res;
    }

    /**
     * Retourne la liste des stations à partir d'un fichier donné
     * @author agent1999 et Goboun
     * @param string fichier chemin du fichier csv en string
     * @return array stations la liste des stations disponibles
     */
    function station_liste($fichier){
        $stations = [];
        if (($status = fopen($fichier, "r")) !== FALSE) {
            while (($val = fgetcsv($status, 1000, ",")) !== FALSE) {
                //Le tableau est dans la première colonne, il y en a qu'une ici
                $stations[] = $val[0]; 
            }
            fclose($status);
        }
        return $stations;
    }

    /**
     * Pour les select utilisés dans horaires : retourne la liste des stations sous forme d'option de formulaire
     * Et pour les datalists dans itinéraires : retourne la liste des stations sous forme de datalist
     * @author agent1999 et Goboun
     * @param string fichier chemin du fichier csv en string
     * @param string depart sert à éviter les doublons lorsque la dernière gare sélectionné est remise en tête de liste
     * @return string res la liste des stations disponibles en idf
     */
    function station_options($fichier, $depart = ""):string{
        $res = "";
        $stations = station_liste($fichier);
        //Ajouter les stations une par une comme option de la liste du formulaire
        if (is_array($stations)) {
            foreach ($stations as $station) {
                if ($station !== $depart) {
                    $res .= "\t\t\t\t\t\t\t<option value=\"$station\">$station</option>\n";
                }
            }
        } else {
            $res = "\t\t\t\t\t\t\t<option value=\"\">Erreur: " . $stations . "</option>\n";
        }
        return $res;
    }

    /**
     * Affiche les prochains trains d'une gare pour une ligne uniquement
     * @author agent1999 et Goboun
     * @return string res la liste, au moment même, des prochains trains d'une gare pour une ligne uniquement
     */
    function horaires():string{
        $res = "";
        //1er traitement : on récupère l'id de la gare
        if(isset($_GET["gare"]) && !empty($_GET["gare"])){
            $urlGare = "https://23fa1a0c-f611-4566-bbfc-ec2829f8ba83@api.navitia.io/v1/coverage/fr-idf/places?q=".$_GET["gare"];
            $repGare = file_get_contents($urlGare);
            $dataGare = json_decode($repGare, true);
            $placesGare = $dataGare["places"];
            $zeroGare = $placesGare["0"];
            /**
             * Il y a des cas comme la gare d'Antony qui ne donne pas l'id de la gare à cet endroit dans l'api,
             * donc on va chercher à l'endroit suivant en espérant que c'est comme ça pour toutes les gares
             */
            if(!strcmp($zeroGare["embedded_type"],"administrative_region")){
                $unGare = $placesGare["1"];
                $idGare = $unGare["id"];
            }
            else{
                $idGare = $zeroGare["id"];
            }
        }
        //Sinon s'il y a rien, on affiche rien
        else{
            return $res;
        }
        //2nd traitement : on récupère l'id de la ligne
        if(isset($_GET["train"]) && !empty($_GET["train"])){
            if(!strcmp($_GET["train"], "A")){
                $ligne = "/lines/line%3AIDFM%3AC01742/stop_schedules?items_per_schedule=5&";
            }
            else if(!strcmp($_GET["train"], "B")){
                $ligne = "/lines/line%3AIDFM%3AC01743/stop_schedules?items_per_schedule=5&";
            }
            else if(!strcmp($_GET["train"], "C")){
                $ligne = "/lines/line%3AIDFM%3AC01727/stop_schedules?items_per_schedule=5&";
            }
            else if(!strcmp($_GET["train"], "D")){
                $ligne = "/lines/line%3AIDFM%3AC01728/stop_schedules?items_per_schedule=5&";
            }
            else if(!strcmp($_GET["train"], "E")){
                $ligne = "/lines/line%3AIDFM%3AC01729/stop_schedules?items_per_schedule=5&";
            }
            else if(!strcmp($_GET["train"], "H")){
                $ligne = "/lines/line%3AIDFM%3AC01737/stop_schedules?items_per_schedule=5&";
            }
            else if(!strcmp($_GET["train"], "J")){
                $ligne = "/lines/line%3AIDFM%3AC01739/stop_schedules?items_per_schedule=5&";
            }
            else if(!strcmp($_GET["train"], "K")){
                $ligne = "/lines/line%3AIDFM%3AC01738/stop_schedules?items_per_schedule=5&";
            }
            else if(!strcmp($_GET["train"], "L")){
                $ligne = "/lines/line%3AIDFM%3AC01740/stop_schedules?items_per_schedule=5&";
            }
            else if(!strcmp($_GET["train"], "N")){
                $ligne = "/lines/line%3AIDFM%3AC01736/stop_schedules?items_per_schedule=5&";
            }
            else if(!strcmp($_GET["train"], "P")){
                $ligne = "/lines/line%3AIDFM%3AC01730/stop_schedules?items_per_schedule=5&";
            }
            else if(!strcmp($_GET["train"], "R")){
                $ligne = "/lines/line%3AIDFM%3AC01731/stop_schedules?items_per_schedule=5&";
            }
            else if(!strcmp($_GET["train"], "U")){
                $ligne = "/lines/line%3AIDFM%3AC01741/stop_schedules?items_per_schedule=5&";
            }
            //Si quelqu'un modifie et met n'importe quoi dans la barre, on s'arrête et on affiche rien
            else{
                return $res;
            }
        }
        //3ème traitement : on construit l'url de l'api
        $url = "https://23fa1a0c-f611-4566-bbfc-ec2829f8ba83@api.navitia.io/v1/coverage/fr-idf/stop_areas/".$idGare.$ligne;
        $rep = file_get_contents($url);
        $data = json_decode($rep, true);
        //4ème traitement : on récupère les informations
        $stop = $data["stop_schedules"];
        foreach($stop as $value){
            if(is_null($value["additional_informations"])){
                $res.= "\t\t\t\t<section>\n\t\t\t\t\t<h2>".$value["display_informations"]["direction"]."</h2>\n";
                $datetime = $value["date_times"];
                $res.= "\t\t\t\t\t<ul>\n";
                foreach($datetime as $valueTime){
                    $heure = date("H:i:s", strtotime($valueTime["date_time"])); 
                    $res.= "\t\t\t\t\t\t<li>".$heure."</li>\n";
                }
                $res.= "\t\t\t\t\t</ul>\n";
                $res.= "\t\t\t\t</section>\n";
            }
        }
        return $res;
    }

    /**
     * Pour la page infostraffic,
     * affiche les informations du traffic d'une ligne en fonction du paramètre "train" dans l'URL
     * @author agent1999 et Goboun
     * @return string res la longue liste des évènements en cours et à venir
     */
    function infostraffic():string{
        $res="";
        $ligne="";
        //1er traitement : créer le lien de l'api
        if(!(strcmp($_GET["train"], "A"))){
            $ligne = "line%3AIDFM%3AC01742/disruptions?";
        }
        else if(!(strcmp($_GET["train"], "B"))){
            $ligne = "line%3AIDFM%3AC01743/disruptions?";
        }
        else if(!(strcmp($_GET["train"], "C"))){
            $ligne = "line%3AIDFM%3AC01727/disruptions?";
        }
        else if(!(strcmp($_GET["train"], "D"))){
            $ligne = "line%3AIDFM%3AC01728/disruptions?";
        }
        else if(!(strcmp($_GET["train"], "E"))){
            $ligne = "line%3AIDFM%3AC01729/disruptions?";
        }
        else if(!(strcmp($_GET["train"], "H"))){
            $ligne = "line%3AIDFM%3AC01737/disruptions?";
        }
        else if(!(strcmp($_GET["train"], "J"))){
            $ligne = "line%3AIDFM%3AC01739/disruptions?";
        }
        else if(!(strcmp($_GET["train"], "K"))){
            $ligne = "line%3AIDFM%3AC01738/disruptions?";
        }
        else if(!(strcmp($_GET["train"], "L"))){
            $ligne = "line%3AIDFM%3AC01740/disruptions?";
        }
        else if(!(strcmp($_GET["train"], "N"))){
            $ligne = "line%3AIDFM%3AC01736/disruptions?";
        }
        else if(!(strcmp($_GET["train"], "P"))){
            $ligne = "line%3AIDFM%3AC01730/disruptions?";
        }
        else if(!(strcmp($_GET["train"], "R"))){
            $ligne = "line%3AIDFM%3AC01731/disruptions?";
        }
        else if(!(strcmp($_GET["train"], "U"))){
            $ligne = "line%3AIDFM%3AC01741/disruptions?";
        }
        /**
         * Sinon, si quelqu'un modifie directement dans la barre de recherche
         * et met n'importe quoi, on s'arrete ici et rien ne s'affiche
         */
        else { 
            return $res;
        }
        $api = "https://23fa1a0c-f611-4566-bbfc-ec2829f8ba83@api.navitia.io/v1/coverage/fr-idf/lines/".$ligne;
        //2nd traitement : obtenir les informations
        $apiContent = file_get_contents($api);
        $apiDecode = json_decode($apiContent, true);
        $disruptions = $apiDecode["disruptions"];
        //Informations traffic en cours
        $res = "\t\t\t\t<section>\n\t\t\t\t\t<h2>En cours</h2>\n";
        /**
         * S'il n'y a aucun problème sur la ligne,
         * alors le compteur est à zéro et on affiche que tout va bien
         * Fonctionne comme un flag
         */
        $compteurActive = 0;
        foreach($disruptions as $value){
            $etat = $value["status"];
            if(!(strcmp($etat, "active"))){
                $compteurActive++;
                $messageTitre = $value["messages"][0]["text"];
                $messagePave = $value["messages"][1]["text"];
                /**
                 * Pour certaines lignes, ces 2 messages sont inversés,
                 * donc on va les positionner correctement
                 * Le plus lourd est le contenu, le plus léger le titre
                 */
                if(strlen($messageTitre) > strlen($messagePave)){
                    $messageTitre = $value["messages"][1]["text"];
                    $messagePave = $value["messages"][0]["text"];
                }
                $titre = "\t\t\t\t\t\t<article>\n\t\t\t\t\t\t\t<h3>".$messageTitre."</h3>\n";
                $pave = $messagePave."\t\t\t\t\t\t</article>\n";
                $res.= $titre;
                $res.= $pave;
            }
        }
        if($compteurActive == 0){
            $res.= "\t\t\t\t\t\t\t<p>Traffic normal</p>\n";
        }
        $res.= "\t\t\t\t</section>\n";
        //Informations traffic à venir
        $res.= "\t\t\t\t<section>\n\t\t\t\t\t<h2>À venir</h2>\n";
        /**
         * S'il n'y a aucun problème sur la ligne,
         * alors le compteur est à zéro et on affiche que tout va bien
         * Fonctionne comme un flag
         */
        $compteurFuture = 0;
        foreach($disruptions as $value){
            $etat = $value["status"];
            if((!(strcmp($etat, "future")))){
                $compteurFuture++;
                $messageTitre = $value["messages"][0]["text"];
                $messagePave = $value["messages"][1]["text"];
                /**
                 * Pour certaines lignes, ces 2 messages sont inversés,
                 * donc on va les positionner correctement
                 * Le plus lourd est le contenu, le plus léger le titre
                 */
                if(strlen($messageTitre) > strlen($messagePave)){
                    $messageTitre = $value["messages"][1]["text"];
                    $messagePave = $value["messages"][0]["text"];
                }
                $titre = "\t\t\t\t\t\t<article>\n\t\t\t\t\t\t\t<h3>".$messageTitre."</h3>\n";
                $pave = $messagePave."\t\t\t\t\t\t</article>\n";
                $res.= $titre;
                $res.= $pave;
            }
        }
        if($compteurFuture == 0){
            $res.= "\t\t\t\t\t<p>Traffic normal</p>\n";
        }
        $res.= "\t\t\t\t</section>\n";
        return $res;
    }

    /**
     * Augmente le nombre de visites de 1 à chaque consultation d'une page à partir d'un fichier qui sauvegardera ce nombre
     * @author agent1999 et Goboun
     */
    function updateHits():void{
        //On récupère le nombre stocké dans le fichier
        $read = fopen("./datas/hits.txt", "r");
        $res = fgets($read);
        fclose($read);
        //On augmente le nombre de 1
        $res = $res + 1;
        //On stocke le nombre dans le fichier
        $write = fopen("./datas/hits.txt", "w");
        fprintf($write, "%d", $res);   
        fclose($write);
    }

    /**
     * Affiche le nombre de visite qui est stocké dans un fichier
     * @author agent1999 et Goboun
     * @return string res le nombre de visites
     */
    function afficheHits():string{
        $read = fopen("./datas/hits.txt", "r");
        $res = fgets($read);
        fclose($read);
        return $res;
    }

    /**
     * Pour créer le fichier csv des gares avec une colonne de 0 à partir du fichier de toutes les gares
     * Attention, il faut supprimer manuellement la dernière ligne vide pour utiliser updateCompteur
     * et l'histogramme dans statistiques et bargraph
     * @author agent1999 et Goboun
     * @return void
     */
    function initCompteur():void{
        $file = fopen("./datas/nom_gares.csv", "r");
        $truefile = fopen("./datas/compteur.csv", "w");
        while(!feof($file)){
            $line = "0;".fgets($file);
            fputs($truefile, $line);
        }
        fclose($file);
        fclose($truefile);
    }

    /**
     * Dans le fichier compteur, incrémente de 1 le nombre à coté d'une gare si elle est recherchée
     * @author agent1999 et Goboun
     * @return void
     */
    function updateCompteur():void{
        //Pour la gare de départ dans itinéraires
        if(isset($_GET["depart"]) && !empty($_GET["depart"])){
            $file = fopen("./datas/compteur.csv", "r");
            $tmp = fopen("./datas/tmp.csv", "w");
            $lineArray = fgetcsv($file, 0, ";");
            /**
             * Traiter tous les cas sauf le dernier, la gare de Yerres,
             * car il y a un problème avec feof et la ligne vide s'il y a
             */
            while(strcmp($lineArray[1], "Yerres")){
                if(!strcmp($_GET["depart"], $lineArray[1])){
                    $update = $lineArray[0] + 1;
                    $line = $update.";".$lineArray[1]."\n";
                }
                else{
                    $line = $lineArray[0].";".$lineArray[1]."\n";
                }
                fputs($tmp, $line);
                $lineArray = fgetcsv($file, 0, ";");
            }
            //Cas particulier : la dernière gare
            if(!strcmp($_GET["depart"],"Yerres")){
                $update = $lineArray[0] + 1;
                $line = $update.";".$lineArray[1];
                fputs($tmp, $line);
            }
            else{
                $line = $lineArray[0].";".$lineArray[1];
                fputs($tmp, $line);
            }
            fclose($file);
            fclose($tmp);
            rename("./datas/tmp.csv", "./datas/compteur.csv");
        }
        //Pour la gare d'arrivée dans itinéraires
        if(isset($_GET["arrive"]) && !empty($_GET["arrive"])){
            $file = fopen("./datas/compteur.csv", "r");
            $tmp = fopen("./datas/tmp.csv", "w");
            $lineArray = fgetcsv($file, 0, ";");
            /**
             * Traiter tous les cas sauf le dernier, la gare de Yerres,
             * car il y a un problème avec feof et la ligne vide s'il y a
             */
            while(strcmp($lineArray[1], "Yerres")){
                if(!strcmp($_GET["arrive"], $lineArray[1])){
                    $update = $lineArray[0] + 1;
                    $line = $update.";".$lineArray[1]."\n";
                }
                else{
                    $line = $lineArray[0].";".$lineArray[1]."\n";
                }
                fputs($tmp, $line);
                $lineArray = fgetcsv($file, 0, ";");
            }
            //Cas particulier : la dernière gare
            if(!strcmp($_GET["arrive"],"Yerres")){
                $update = $lineArray[0] + 1;
                $line = $update.";".$lineArray[1];
                fputs($tmp, $line);
            }
            else{
                $line = $lineArray[0].";".$lineArray[1];
                fputs($tmp, $line);
            }
            fclose($file);
            fclose($tmp);
            rename("./datas/tmp.csv", "./datas/compteur.csv");
        }
        //Pour la gare dans horaires
        if(isset($_GET["gare"]) && !empty($_GET["gare"])){
            $file = fopen("./datas/compteur.csv", "r");
            $tmp = fopen("./datas/tmp.csv", "w");
            $lineArray = fgetcsv($file, 0, ";");
            /**
             * Traiter tous les cas sauf le dernier, la gare de Yerres,
             * car il y a un problème avec feof et la ligne vide s'il y a
             */
            while(strcmp($lineArray[1], "Yerres")){
                if(!strcmp($_GET["gare"], $lineArray[1])){
                    $update = $lineArray[0] + 1;
                    $line = $update.";".$lineArray[1]."\n";
                }
                else{
                    $line = $lineArray[0].";".$lineArray[1]."\n";
                }
                fputs($tmp, $line);
                $lineArray = fgetcsv($file, 0, ";");
            }
            //Cas particulier : la dernière gare
            if(!strcmp($_GET["gare"],"Yerres")){
                $update = $lineArray[0] + 1;
                $line = $update.";".$lineArray[1];
                fputs($tmp, $line);
            }
            else{
                $line = $lineArray[0].";".$lineArray[1];
                fputs($tmp, $line);
            }
            fclose($file);
            fclose($tmp);
            rename("./datas/tmp.csv", "./datas/compteur.csv");
        }
    }

    /**
     * Affiche une photographie aléatoirement parmi les photographies dans le dossier photos
     * @author agent1999 et Goboun
     * @return string photo une photographie choisi aléatoirement
     */
    function affichePhoto():string{
        $photos = scandir("./photos");
        $i = 0;
        foreach($photos as $value){
            $i++;
        }
        /**
         * scandir renvoie un tableau des élements dans un dossier donné
         * mais les 2 premiers éléments sont tout le temps "." et "..", donc on les exclut
         */
        $rand = rand(2, $i-1);
        $photo = $photos[$rand];
        return $photo;
    }

    /**
     * Affiche le logo sous le format base64 à partir de l'image original en png
     * @author agent1999 et Goboun
     * @return string data la longue chaine de caractères du logo
     */
    function afficheLogo(){
        $img = file_get_contents("./images/logo.png");
        $data = base64_encode($img);
        return $data;
    }

    /**
     * Affiche le navigateur utilisé du client dans le footer
     * @author agent1999 et Goboun
     * @return string res le navigateur utilisé
     */
    function get_navigateur():string{
        $res = $_ENV['HTTP_USER_AGENT'];
        return $res;
    }

///////////////FIN FONCTIONS POUR LES RER ET LES TRAINS

?>