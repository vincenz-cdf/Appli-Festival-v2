<?php

$titre = "- Attributions";
include("_debut.inc.php");
include("_gestionBase.inc.php"); 
include("_controlesEtGestionErreurs.inc.php");
echo "<br><p align='center' class='textArianne'><a  href = 'index.php'> Accueil </a> ->  Attributions chambres</p><br> ";
// CONSULTER LES ATTRIBUTIONS DE TOUS LES ÉTABLISSEMENTS

// IL FAUT QU'IL Y AIT AU MOINS UN ÉTABLISSEMENT OFFRANT DES CHAMBRES POUR  
// AFFICHER LE LIEN VERS LA MODIFICATION
$nbEtab=obtenirNbEtabOffrantChambres($connexion);
if ($nbEtab!=0)
{
   echo "
   <table width='75%' cellspacing='0' cellpadding='0' align='center'
   <tr><td>
   <p align='center'><a class='buttonCréa' href='modificationAttributions.php?action=demanderModifAttrib'>
   Effectuer ou modifier les attributions</a></p></td></tr></table><br><br>";
   
   // POUR CHAQUE ÉTABLISSEMENT : AFFICHAGE D'UN TABLEAU COMPORTANT 2 LIGNES 
   // D'EN-TÊTE ET LE DÉTAIL DES ATTRIBUTIONS
   $req=obtenirReqEtablissementsAyantChambresAttribuées();
   $rsEtab=$connexion->query($req);
   $lgEtab=$rsEtab->fetch();
   // BOUCLE SUR LES ÉTABLISSEMENTS AYANT DÉJÀ DES CHAMBRES ATTRIBUÉES
   if($lgEtab==FALSE){
      echo "<h1 align='center'>il n'y as aucune réservations <h1>" ;
   }
   while($lgEtab!=FALSE)
   {
      $idEtab=$lgEtab['id'];
      $nomEtab=$lgEtab['nom'];
   
      echo "
      <table width='75%' cellspacing='0' cellpadding='0' align='center' 
      class='content-table'>";
      
      $nbOffre=$lgEtab["nombreChambresOffertes"];
      $nbOccup=obtenirNbOccup($connexion, $idEtab);
      // Calcul du nombre de chambres libres dans l'établissement
      $nbChLib = $nbOffre - $nbOccup;
      
      // AFFICHAGE DE LA 1ÈRE LIGNE D'EN-TÊTE 
      echo "
      <thead>
      <tr>";
         if($nbChLib != 0){
         echo"
         <th colspan='3' align='left'><strong>$nomEtab</strong>&nbsp;
         (Offre : $nbOffre&nbsp;&nbsp;Disponibilités : $nbChLib)
         </th>";
         }else{
         echo"
         <th colspan='3' align='left'><strong>$nomEtab</strong>&nbsp;
         (Offre : $nbOffre&nbsp;&nbsp;Disponibilités : $nbChLib) (Complet)
         </th>" ;           
         }

         echo"
      </tr>
      </thead>
      ";
          
      // AFFICHAGE DE LA 2ÈME LIGNE D'EN-TÊTE 
      echo "
      <tr>
         <td width='35%' align='left'><i><strong>Nom groupe</strong></i></td>
         <td width='30%' align='left'><i><strong>Pays</strong></i></td>
         <td width='35%' align='left'><i><strong>Chambres attribuées</strong></i>
         </td>
      </tr>";
        
      // AFFICHAGE DU DÉTAIL DES ATTRIBUTIONS : UNE LIGNE PAR GROUPE AFFECTÉ 
      // DANS L'ÉTABLISSEMENT       
      $req=obtenirReqGroupesEtab($idEtab);
      $rsGroupe=$connexion->query($req);
      $lgGroupe=$rsGroupe->fetch();
               
      // BOUCLE SUR LES GROUPES (CHAQUE GROUPE EST AFFICHÉ EN LIGNE)
      while($lgGroupe!=FALSE)
      {
         $idGroupe=$lgGroupe['id'];
         $nomGroupe=$lgGroupe['nom'];
         $paysGroupe=$lgGroupe['nompays'];
         echo "
         <tr class='content-table'>
            <td width='35%' align='left'>$nomGroupe</td>
            <td width='30%' align='left'>$paysGroupe</td>";
         // On recherche si des chambres ont déjà été attribuées à ce groupe
         // dans l'établissement
         $nbOccupGroupe=obtenirNbOccupGroupe($connexion, $idEtab, $idGroupe);
         echo "
            <td width='35%' align='left'>$nbOccupGroupe</td>
         </tr>";
         $lgGroupe=$rsGroupe->fetch();
      } // Fin de la boucle sur les groupes
      
      echo "
      </table><br>";
      $lgEtab=$rsEtab->fetch();
   } // Fin de la boucle sur les établissements
}

?>