<?php   
    declare(strict_types=1);

    //Pour l'histogramme de la page statistiques
    header("Content-Type: image/svg+xml");
    $file = fopen("./datas/compteur.csv", "r");
    $content = "";
    $i = 25;
    $xtext = 5;
    $xrect = 320;
    $line = fgetcsv($file, 0, ";");
    //Chaque ligne représente le nom de la gare, le nombre associé, et la barre
    while(!feof($file)){
        if(strcmp($line[0],"0")){
            $ytext = $i;
            $yrect = $i-15;
            $widthrect = $line[0];
            $content.= "
                <text 
                    x=\"".$xtext."\" 
                    y=\"$ytext\" 
                    fill=\"limegreen\">"
                    .$line[1]
                    ." (".$line[0].")
                </text>
                <rect 
                    x=\"".$xrect."\" 
                    y=\"".$yrect."\" 
                    width=\"".$widthrect."\" 
                    height=\"15\" 
                    fill=\"royalblue\">
                </rect>";
            $i+=20;
        }
        $line = fgetcsv($file, 0, ";");
    }
    //On oublie pas de traiter le dernier car la boucle d'avant traite tous sauf le dernier car on a enlevé la ligne vide
    if(strcmp($line[0],"0")){
        $ytext = $i;
        $yrect = $i-15;
        $widthrect = $line[0];
        $content.= "
            <text 
                x=\"".$xtext."\" 
                y=\"$ytext\" 
                fill=\"limegreen\">"
                .$line[1]
                ." (".$line[0].")
            </text>
            <rect 
                x=\"".$xrect."\" 
                y=\"".$yrect."\" 
                width=\"".$widthrect."\" 
                height=\"15\" 
                fill=\"royalblue\">
            </rect>";
    }
    fclose($file);
    $svg = "<svg 
        xmlns=\"http://www.w3.org/2000/svg\" 
        class=\"chart\" 
        width=\"500\" 
        height=\"".$i."\" 
        aria-labelledby=\"title\" 
        role=\"img\">";
    $svg.= $content."</svg>";
    echo $svg;

?>