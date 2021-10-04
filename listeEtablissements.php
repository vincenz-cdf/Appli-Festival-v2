<?php

$titre = "- Etablissements";
include("_debut.inc.php");
include("_gestionBase.inc.php"); 
include("_controlesEtGestionErreurs.inc.php");

echo "
<br>

<p align='center' class='textArianne'><a  href = 'index.php'> Accueil </a> -> Liste des Etablissements</p>
<br> ";
// AFFICHER L'ENSEMBLE DES ÉTABLISSEMENTS
// CETTE PAGE CONTIENT UN TABLEAU CONSTITUÉ D'1 LIGNE D'EN-TÊTE ET D'1 LIGNE PAR
// ÉTABLISSEMENT

echo "
<table width='70%' cellspacing='0' cellpadding='0' align='center' 
class='content-equipe'>
   <thead>
   <tr>
      <th colspan='4'>Etablissements</th>
   </tr>
   </thead>
   ";
     
   $req=obtenirReqEtablissements();
   $rsEtab=$connexion->query($req);
   $lgEtab=$rsEtab->fetchAll();
   // BOUCLE SUR LES ÉTABLISSEMENTS
   while ($lgEtab!=FALSE)
   {
      foreach ($lgEtab as $row){
      $id=$row['id'];
      $nom=$row['nom'];
      echo "
      <tbody>
		<tr>
         <td width='52%'>$nom</td>
         
         <td width='16%' align='center'> 
         <a href='detailEtablissement.php?id=$id'>
         Voir détail</a></td>
         
         <td width='16%' align='center'> 
         <a href='modificationEtablissement.php?action=demanderModifEtab&amp;id=$id'>
         Modifier</a></td>";
      	
         // S'il existe déjà des attributions pour l'établissement, il faudra
         // d'abord les supprimer avant de pouvoir supprimer l'établissement
			if (!existeAttributionsEtab($connexion, $id))
			{
            echo "
            <td width='16%' align='center'> 
            <a href='suppressionEtablissement.php?action=demanderSupprEtab&amp;id=$id'>
            Supprimer</a></td>";
         }
         else
         {
              $résulte=obtenirNbOccup($connexion,$row['id']);
            echo "
            <td width='16%'>($résulte attributions) </td>";          
			}
			echo "
      </tr>";
      $lgEtab=$rsEtab->fetchAll();
      }
   }   
   echo "
   <tr class='content-equipe'>
      <td colspan='4'><a href='creationEtablissement.php?action=demanderCreEtab'>
      Création d'un établissement</a ></td>
  </tr>
  </tbody>
</table>";

?>
