<?php

include("_debut.inc.php");
include("_gestionBase.inc.php"); 
include("_controlesEtGestionErreurs.inc.php");

echo "<br><p class='textArianne' align='center'><a href = 'index.php'> Accueil </a> -> <a href = 'listeEtablissements.php'>
Liste des établissements </a> -> Suppression d'Etablissements</p><br>";
// SUPPRIMER UN ÉTABLISSEMENT 

$id=$_REQUEST['id'];  

$lgEtab=obtenirDetailEtablissement($connexion, $id);
foreach ($lgEtab as $row) {
   $nom=$row['nom'];
}

// Cas 1ère étape (on vient de listeEtablissements.php)

if ($_REQUEST['action']=='demanderSupprEtab')    
{
   echo "
   <br><center><h5 class='texteAccueil'>Souhaitez-vous vraiment supprimer l'établissement $nom ? 
   <br><br>
   <a class='buttonCréa2' href='suppressionEtablissement.php?action=validerSupprEtab&amp;id=$id'>
   Oui</a>&nbsp; &nbsp; &nbsp; &nbsp;
   <a class='buttonCréa' href='listeEtablissements.php?'>Non</a></h5></center>";
}

// Cas 2ème étape (on vient de suppressionEtablissement.php)

else
{
   supprimerEtablissement($connexion, $id);
   echo "
   <br><br><center><h5>L'établissement $nom a été supprimé</h5>
   <a class='buttonRetour' href='listeEtablissements.php?'>Retour</a></center>";
}

?>
