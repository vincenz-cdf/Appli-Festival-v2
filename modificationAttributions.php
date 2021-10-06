<?php

$titre = "- Attributions";
include("_debut.inc.php");
include("_gestionBase.inc.php"); 
include("_controlesEtGestionErreurs.inc.php");

echo "<br><p class='textArianne' align='center'><font size='3'> <a  href = 'index.php'> Accueil </a> -> <a href = 'consultationAttributions.php'>
Attribution chambres </a> -> Effectuer ou modifier les attributions</p><br>
<table align='center' width='80%'>
   <tr>
      <td width='34%' align='left'><font size='3'></a>
      </td>
      <td class='reserveSiLien'>&nbsp;</td>
      <td width='30%' align='left'><font size='3'> Réservation possible si lien</td>
      <td class='reserve'>&nbsp;</td>
      <td width='30%' align='left'><font size='3'> Chambres réservées</td>
   </tr>
</table>
 ";
// EFFECTUER OU MODIFIER LES ATTRIBUTIONS POUR L'ENSEMBLE DES ÉTABLISSEMENTS

// CETTE PAGE CONTIENT UN TABLEAU CONSTITUÉ DE 2 LIGNES D'EN-TÊTE (LIGNE TITRE ET 
// LIGNE ÉTABLISSEMENTS) ET DU DÉTAIL DES ATTRIBUTIONS 
// UNE LÉGENDE FIGURE SOUS LE TABLEAU

// Recherche du nombre d'établissements offrant des chambres pour le 
// dimensionnement des colonnes
$nbEtabOffrantChambres=obtenirNbEtabOffrantChambres($connexion);
$nb=$nbEtabOffrantChambres;
// Détermination du pourcentage de largeur des colonnes "établissements"
$pourcCol=50/$nbEtabOffrantChambres;

$action=$_REQUEST['action'];

// Si l'action est validerModifAttrib (cas où l'on vient de la page 
// donnerNbChambres.php) alors on effectue la mise à jour des attributions dans 
// la base 
if ($action=='validerModifAttrib')
{
   $idEtab=$_REQUEST['idEtab'];
   $idGroupe=$_REQUEST['idGroupe'];
   $nbChambres=$_REQUEST['nbChambres'];
   modifierAttribChamb($connexion, $idEtab, $idGroupe, $nbChambres);
}

echo "
<table width='80%' cellspacing='0' cellpadding='0' align='center' 
class='content-equipe'>";

   // AFFICHAGE DE LA 1ÈRE LIGNE D'EN-TÊTE
   echo "
   <thead>
   <tr>
      <th><strong>Equipes</strong></th>
      <th width='10%'><strong>nombre chambre réservées</strong></th>
      <th width='10%'><strong>Pays d'origine</strong></th>
      <th colspan=$nb><strong>Attributions</strong></th>
   </tr>
   </thead>
   ";
      

   // AFFICHAGE DE LA 2ÈME LIGNE D'EN-TÊTE (ÉTABLISSEMENTS)
   echo "
   <tr>
      <td>▼</td>
      <td>▼</td>
      <td>▼</td>";
      
   $req=obtenirReqEtablissementsOffrantChambres();
   $rsEtab=$connexion->query($req);
   $lgEtab=$rsEtab->fetch();

   // Boucle sur les établissements (pour afficher le nom de l'établissement et 
   // le nombre de chambres encore disponibles)
   while ($lgEtab!=FALSE)
   {
      $idEtab=$lgEtab["id"];
      $nom=$lgEtab["nom"];
      $nbOffre=$lgEtab["nombreChambresOffertes"];
      $nbOccup=obtenirNbOccup($connexion, $idEtab);
                    
      // Calcul du nombre de chambres libres
      $nbChLib = $nbOffre - $nbOccup;
      echo "
      <td valign='top' width='$pourcCol%'><i>Disponibilités : $nbChLib </i> <br>
      $nom </td>";
      $lgEtab=$rsEtab->fetch();
   }
   echo "
   </tr>"; 

   // CORPS DU TABLEAU : CONSTITUTION D'UNE LIGNE PAR GROUPE À HÉBERGER AVEC LES 
   // CHAMBRES ATTRIBUÉES ET LES LIENS POUR EFFECTUER OU MODIFIER LES ATTRIBUTIONS
         
   $req=obtenirReqIdNomGroupesAHeberger();
   $rsGroupe=$connexion->query($req);
   $lgGroupe=$rsGroupe->fetch();
         
   // BOUCLE SUR LES GROUPES À HÉBERGER 
   while ($lgGroupe!=FALSE)
   {
      $idGroupe=$lgGroupe['id'];
      $nom=$lgGroupe['nom'];
      $paysGroupe=$lgGroupe['nompays'];
      $chambre=retourneNbchambre($lgGroupe['nombrePersonnes']);
      $chambretotal=nbchlouer($connexion,$idGroupe);
      echo "
      <tr>
         <td width='15%' > <font size='2'> $nom <p><Strong>(Ch à louer : $chambre)<p></strong></td>\n";
         if($chambretotal[0]>0){
            echo" 
            <td width=’10%’><font size='2'> $chambretotal[0]</td>";            
         }else{
            echo" 
            <td width=’10%’><font size='2'> 0</td>";
         }
         echo"
         <td width=’10%’><font size='2'> $paysGroupe</td>";
      $req=obtenirReqEtablissementsOffrantChambres();
      $rsEtab=$connexion->query($req);
      $lgEtab=$rsEtab->fetch();
      $comtp=0;
      // BOUCLE SUR LES ÉTABLISSEMENTS
      while ($lgEtab!=FALSE)
      {
         $idEtab=$lgEtab["id"];
         $nbOffre=$lgEtab["nombreChambresOffertes"];
         $nbOccup=obtenirNbOccup($connexion, $idEtab);
                   
         // Calcul du nombre de chambres libres
         $nbChLib = $nbOffre - $nbOccup;
                  
         // On recherche si des chambres ont déjà été attribuées à ce groupe
         // dans cet établissement
         $nbOccupGroupe=obtenirNbOccupGroupe($connexion, $idEtab, $idGroupe);
         
         // Cas où des chambres ont déjà été attribuées à ce groupe dans cet
         // établissement
         if ($nbOccupGroupe!=0)
         {
            // Le nombre de chambres maximum pouvant être demandées est la somme 
            // du nombre de chambres libres et du nombre de chambres actuellement 
            // attribuées au groupe (ce nombre $nbmax sera transmis si on 
            // choisit de modifier le nombre de chambres)
            $comtp+=$nbOccupGroupe;
      echo "
      <td class='reserve'>
         <form method='POST' action='modificationAttributions.php'>
            <input type='hidden' value='validerModifAttrib' name='action'>
            <input type='hidden' value='$idEtab' name='idEtab'>
            <input type='hidden' value='$idGroupe' name='idGroupe'>";
               echo "&nbsp;<select name='nbChambres'>";
               if($nbChLib>=($chambre-$chambretotal[0])){
               for ($i=0; $i<=(($chambre-$chambretotal[0])+$nbOccupGroupe); $i++)
                  optionModifAttrib($i,$nbOccupGroupe);
            }else if($nbChLib == 0){
               for($i=0;$i<=$nbOccupGroupe;$i++)
                  optionModifAttrib($i,$nbOccupGroupe); 
            }else{
               if($nbChLib<$nbOccupGroupe){
                  for ($i=0; $i<=$nbOccupGroupe; $i++)
                     optionModifAttrib($i,$nbOccupGroupe);
               }else{
               for ($i=0; $i<=$nbChLib; $i++)
                  optionModifAttrib($i,$nbOccupGroupe);
            }
            }
            echo "
            </select></h5>
            <input type='submit' value='Valider' name='valider'>
         </form></td>";
         }
         else
         {
            // Cas où il n'y a pas de chambres attribuées à ce groupe dans cet 
            // établissement : on affiche un lien vers donnerNbChambres s'il y a 
            // des chambres libres sinon rien n'est affiché    
            if ($nbChLib != 0 && $chambretotal[0]!=$chambre)
            {
               echo "
               <td class='reserveSiLien'>
                  <form method='POST' action='modificationAttributions.php'>
                     <input type='hidden' value='validerModifAttrib' name='action'>
                     <input type='hidden' value='$idEtab' name='idEtab'>
                     <input type='hidden' value='$idGroupe' name='idGroupe'>";
                     
                     echo "&nbsp;<select name='nbChambres'>";
                     if($nbChLib>=($chambre-$chambretotal[0])){ 
                     for ($i=0; $i<=$chambre-$chambretotal[0]; $i++)
                     {
                        echo "<option>$i</option>";
                     }
                  }else{
                     for ($i=0; $i<$nbChLib+1; $i++)
                     {
                        echo "<option>$i</option>";
                     }
                  }
                     echo "
                     </select></h5>
                     <input type='submit' value='Valider' name='valider'>
                  </form>
               </td>
                  ";
            }
            else
            {
               echo "<td class='reserveSiLien'>complet</td>";
            }
         }
         
         $lgEtab=$rsEtab->fetch();
      } // Fin de la boucle sur les établissements    
      $lgGroupe=$rsGroupe->fetch();  
   } // Fin de la boucle sur les groupes à héberger
echo "
</table>"; // Fin du tableau principal

?>
