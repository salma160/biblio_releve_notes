<?php
require_once 'notes.php';
// vous avez dit qu'on peut faire avec seulement 2 personnes
$etudiants=[
    ["prenom" => "Yassine","nom"=> "Elbouari", "notes" => [14,12,9,15,11]],
    ["prenom" => "Mehdi","nom"=> "Tazi", "notes" => [17,18,15,16,19]]
];

$matieres=["Maths","Physique","Informatique","Anglais","Francais"];
$seuil_admission=10;


foreach($etudiants as $etudiant){
    echo genererReleve($etudiant,$matieres,$seuil_admission)."<br>";
}

$moy_general=calculerStatistiquesPromotion($etudiants,$seuil_admission)['moyenne_promo'];

$meilleur=calculerStatistiquesPromotion($etudiants,$seuil_admission)['meilleur'];

$moins_bon=calculerStatistiquesPromotion($etudiants,$seuil_admission)['moins_bon'];

$admis=calculerStatistiquesPromotion($etudiants,$seuil_admission)['nb_admis'];

$ajournes=calculerStatistiquesPromotion($etudiants,$seuil_admission)['nb_ajournes'];

$nb_etudiants=count($etudiants);

$taux_reussite=calculerStatistiquesPromotion($etudiants,$seuil_admission)['taux_reussite'];

$text=<<<SYNTHESE
        ============================================
        <br>
        RAPPORT DE SYNTHESE -- PROMOTION JM2
        <br>
        ============================================
        <br>
        Moyenne generale   : $moy_general/20
        <br>
        Meilleur etudiant  : $meilleur
        <br>
        Moins bon resultat : $moins_bon
        <br>
        Admis              : $admis/$nb_etudiants
        <br>
        Ajournes           : $ajournes/$nb_etudiants 
        <br>
        Taux de reussite   : $taux_reussite %
        <br>
        ============================================
        SYNTHESE;
echo $text;

?>
