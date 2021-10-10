<?php

$titre="- Equipes";
include("_debut.inc.php");
include("_gestionBase.inc.php"); 
include("_controlesEtGestionErreurs.inc.php");
echo "<br><p class='textArianne' align='center'><a  href = 'index.php'> Accueil </a> -> <a href = 'gestionequipe.php'>
Gestion d'équipes  </a> -> Détail de l'équipe</p><br>";


$id=$_REQUEST['id'];  

// OBTENIR LE DÉTAIL DE L'ÉTABLISSEMENT SÉLECTIONNÉ

$lgEtab=obtenirDetailEquipe($connexion, $id);

foreach ($lgEtab as $row) {
      $id=$row['id'];
      $nom=$row['nom'];
      $identiteResponsable=$row['identiteResponsable'];
      $adressePostale=$row['adressePostale'];
      $nombrePersonnes=$row['nombrePersonnes'];
      $nomPays=$row['nomPays'];
      $stand=$row['stand'];

   echo "
   <table width='60%' cellspacing='0' cellpadding='0' align='center' class='content-table'>
      
      <thead>
      <tr>
         <th colspan='3'>$nom ($id)</th>
      </tr>
      </thead>
      <tr>
         <td  width='20%'> Nombres de personnes: </td>
         <td>$nombrePersonnes</td>
      </tr>
      <tr>
         <td  width='20%'> Nom de la ligue: </td>
         <td>$identiteResponsable</td>
      </tr>
            <tr>
         <td  width='20%'> Code postal: </td>
         <td>$adressePostale</td>
      </tr>
      <tr>
         <td> Origine : </td>
         <td>$nomPays</td>
      </tr>
      <tr>
         <td> Utilise un stand: </td>";
         if ($stand==1)
         {
            echo "<td> Oui </td>";
         }
         else
         {
            echo "<td> Non </td>";
         }
      echo "
      </tr>
   </table>;
   
   <table align='center' cellspacing='15' cellpadding='0'>
      <tr>
         <td colspan='2' align='center'><a class='buttonRetour' href='gestionEquipe.php'>Retour</a>
         </td>
      </tr>";
}
?>
