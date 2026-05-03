 <?php 
    function calculerMoyenne($notes){
        return count($notes)!=0?round(array_sum($notes)/count($notes),2):0;
    }
    
    function determinerMention($moyenne){
        switch(true){
            case $moyenne>=16: 
                return "Très bien";
            case $moyenne>=14: 
                return "Bien";
            case $moyenne>=12: 
                return "Assez bien";
            case $moyenne>=10: 
                return "Passable";
            default: 
                return "Insuffisant";
        }
    }

    function estAdmis($moyenne,$seuil=10){//j'ai choisi que $seuil soit à valeur par defaut pour que ça ne pose pas de pb lors de son appel plustard
        return $moyenne>=$seuil?TRUE:FALSE;
    }

    function formaterNomComplet($prenom,$nom){
        return ucfirst(strtolower($prenom))." ".strtoupper($nom);
    }

    function genererReleve($etudiant, $matieres, $seuil) {
    $grade = "";
    $resultat = ""; 

    
    foreach (array_map(null, $etudiant["notes"], $matieres) as [$note, $matiere]) {
        $grade .=  $matiere . " : " . $note."<br>" ;
    }

    $moy = calculerMoyenne($etudiant["notes"]);
    $mention = determinerMention($moy);

    // Test d'admission
    if (estAdmis($moy, $seuil) === true) {
        $resultat = "ADMIS";
    } else {
        $resultat = "NON ADMIS";
    }

    return 
        "======================================="."<br>"."Relevé de notes -- " . formaterNomComplet($etudiant["prenom"], $etudiant["nom"]) . "<br>" .
        "=======================================" ."<br>". $grade . "<br>" .
           "---------------------------------------" . "<br>" .
           "Moyenne : " . $moy . "/20" . "<br>" .
           "Mention : " . $mention . "<br>" .
           "RESULTAT : " . $resultat."<br>";
    }

function calculerStatistiquesPromotion($etudiants,$seuil){
    $tab_moyenne=[];

    foreach($etudiants as ['prenom'=>$prenom,'nom'=>$nom,'notes'=>$notes]){// j'ai choisi cette structure pour ''dezipper'' un tab associatif
        $tab_moyenne[formaterNomComplet($prenom,$nom)]= calculerMoyenne($notes);
    }

    $moyenne_promo=calculerMoyenne($tab_moyenne);
    $meilleur=max($tab_moyenne);
    $moins_bon=min($tab_moyenne);

    foreach($tab_moyenne as $k=>$v){
        if($meilleur==$v){
            $meilleur=$k;
        }
        if($moins_bon==$v){
            $moins_bon=$k;
        }
    }
    $nb_admis = count(array_filter($tab_moyenne, function($Moyenne) use ($seuil) {
    return estAdmis($Moyenne, $seuil) === true;
    }));
    //la focntion anonyme utilisée, n'utilise et ne laisse utiliser que ce qu'on lui passe, d'où use($seuil),pour lui dire qu'elle a le droit d'utiliser cette variable

    $nb_ajournes = count(array_filter($tab_moyenne, function($Moyenne) use ($seuil) {
        return estAdmis($Moyenne, $seuil) === false;
    }));

    $taux_reussite=round(($nb_admis*100)/count($etudiants),1);

    return array(
        'moyenne_promo'=>$moyenne_promo,
        'meilleur'=>$meilleur,
        'moins_bon'=>$moins_bon,
        'nb_admis'=>$nb_admis,
        'nb_ajournes'=>$nb_ajournes,
        'taux_reussite'=>$taux_reussite,
    );

    

    }
?>