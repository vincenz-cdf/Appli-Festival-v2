<?php

$titre = "- Etablissements";
include("_debut.inc.php");
include("_gestionBase.inc.php"); 
include("_controlesEtGestionErreurs.inc.php");

echo "<br><p class='textArianne' align='center'><a href = 'index.php'> Accueil </a> -> <a href = 'listeEtablissements.php'>
Liste des établissements </a> -> Détail des établissements</p><br>";

$id=$_REQUEST['id'];  

// OBTENIR LE DÉTAIL DE L'ÉTABLISSEMENT SÉLECTIONNÉ

$lgEtab=obtenirDetailEtablissement($connexion, $id);

foreach ($lgEtab as $row) {
   $nom=$row['nom'];
   $adresseRue=$row['adresseRue'];
   $codePostal=$row['codePostal'];
   $ville=$row['ville'];
   $tel=$row['tel'];
   $adresseElectronique=$row['adresseElectronique'];
   $type=$row['type'];
   $civiliteResponsable=$row['civiliteResponsable'];
   $nomResponsable=$row['nomResponsable'];
   $prenomResponsable=$row['prenomResponsable'];
   $nombreChambresOffertes=$row['nombreChambresOffertes'];

   echo "
   <table width='60%' cellspacing='0' cellpadding='0' align='center' 
   class='content-table'>
      
      <thead>
      <tr>
         <th colspan='3'>$nom</th>
      </tr>
      </thead>

      <tr>
         <td  width='20%'> Id: </td>
         <td>$id</td>
      </tr>
      <tr>
         <td> Adresse: </td>
         <td>$adresseRue</td>
      </tr>
      <tr>
         <td> Code postal: </td>
         <td>$codePostal</td>
      </tr>
      <tr>
         <td> Ville: </td>
         <td>$ville</td>
      </tr>
      <tr>
         <td> Téléphone: </td>
         <td>$tel</td>
      </tr>
      <tr>
         <td> E-mail: </td>
         <td>$adresseElectronique</td>
      </tr>
      <tr>
         <td> Type: </td>";
         if ($type==1)
         {
            echo "<td> Etablissement scolaire </td>";
         }
         else
         {
            echo "<td> Autre établissement </td>";
         }
      echo "
      </tr>
      <tr>
         <td> Responsable: </td>
         <td>$civiliteResponsable&nbsp; $nomResponsable&nbsp; $prenomResponsable
         </td>
      </tr> 
      <tr>
         <td> Offre: </td>
         <td>$nombreChambresOffertes&nbsp;chambre(s)</td>
      </tr>
   </table>
   <table align='center'>
      <tr>
         <td align='center'><a class='buttonRetour' href='listeEtablissements.php'>Retour</a>
         </td>
      </tr>
   </table>";
}
?>
