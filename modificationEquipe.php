<?php

$titre="- Equipes";
include("_debut.inc.php");
include("_gestionBase.inc.php"); 
include("_controlesEtGestionErreurs.inc.php");

echo "<br><p align='center' class='textArianne'><a  href = 'index.php'> Accueil </a> -><A href='gestionEquipe.php'> Gestion d'équipes</a> -> Modification d'équipe </p> <br>";

$action=$_REQUEST['action'];
$id=$_REQUEST['id'];
$chambretotal=nbchlouer($connexion,$id);
if ($action=='demanderModifEqu')
{
   $lgEqu=obtenirDetailEquipe($connexion, $id);
   foreach ($lgEqu as $row) {
      $nom=$row['nom'];
      $identiteResponsable=$row['identiteResponsable'];
      $adressePostale=$row['adressePostale'];
      $nombrePersonnes=$row['nombrePersonnes'];
      $nomPays=$row['nomPays'];
      $stand=$row['stand'];
   }
}
else
{
   $nombrePersonnes=$_REQUEST['nombrePersonnes'];
   if(($chambretotal[0]*3)<=$nombrePersonnes){
      $nom=$_REQUEST['nom'];
      $identiteResponsable=$_REQUEST['identiteResponsable'];
      $adressePostale=$_REQUEST['adressePostale'];
      $nomPays=$_REQUEST['nomPays'];
      $stand=$_REQUEST['stand'];
 
      modifierEquipe($connexion, $id, $nom,$identiteResponsable,$adressePostale, $nombrePersonnes, $nomPays, $stand);
   }else{
      $nom=$_REQUEST['nom'];
      $identiteResponsable=$_REQUEST['identiteResponsable'];
      $adressePostale=$_REQUEST['adressePostale'];
      $nomPays=$_REQUEST['nomPays'];
      $stand=$_REQUEST['stand'];
   }

}

echo "
<form method='POST' action='modificationEquipe.php?'>
   <input type='hidden' value='validerModifEqu' name='action'>
   <table width='85%' cellspacing='0' cellpadding='0' align='center' 
   class='content-table'>
   
      <thead>
      <tr>
         <th colspan='3'>".$nom." (".$id.")</th>
      </tr>
      </thead>
      <tr>
         <th><input type='hidden' value=".$id." name='id'></th>
      </tr>


";
      
      echo '
      <tr>
         <td> Nom Equipe: </td>
         <td><input type="text" value="'.$nom.'" name="nom" size="50" 
         maxlength="45" required></td>
      </tr>
      <tr>
         <td> Nom Ligue: </td>
         <td><input type="text" value="'.$identiteResponsable.'" name="identiteResponsable" size="50" 
         maxlength="45" required></td>
      </tr>
      <tr>
         <td> Code postale: </td>
         <td><input type="text" value="'.$adressePostale.'" name="adressePostale" size="50" 
         maxlength="45" required></td>
      </tr>
      <tr>
         <td> Nombre de personnes: </td>
         <td><input type="text" value="'.$nombrePersonnes.'" name="nombrePersonnes" 
         size="4" maxlength="4" required></td>
      </tr>
      <tr>
         <td> Origine: </td>
         <td><input type="text" value="'.$nomPays.'" name="nomPays" 
         size="50" maxlength="50" required></td>
      </tr>';
      echo'
      <tr>
         <td> Utilise un stand: </td>
         <td>';
            if ($stand==1)
            {
               echo " 
               <input type='radio' name='stand' value='1' checked >  
               Oui
               <input type='radio' name='stand' value='0' >  Non";
             }
             else
             {
                echo " 
                <input type='radio' name='stand' value='1'> 
                Oui
                <input type='radio' name='stand' value='0' checked> Non";
              }
              echo'
           </td>
         </tr>
      <tr>
         <td align="right">
         </td>
         <td align="left"><input class="buttonTab" type="submit" value="Valider" name="valider"><input class="buttonCréa" type="reset" value="Annuler" name="annuler">
         </td>
      </tr>
      <tr>
         <td colspan="2" align="center"><a class="buttonRetour" href="gestionEquipe.php">Retour</a>
         </td>
      </tr>
         
   </table>';
   
   echo "
</form>";

// En cas de validation du formulaire : affichage des erreurs ou du message de 
// confirmation
if ($action=='validerModifEqu')
{
   if(($chambretotal[0]*3)<=$nombrePersonnes){
      echo "
      <h5><center><strong>La modification a été effectuée</strong></center></h5>";
   }else{
      echo "
      <h5><center><strong>modifications imposible !!!</strong></center></h5>
      <h5><center><strong> Si vous souétez enlever des personnes, il faut que vous déprogramier des chambre </strong></center></h5>";
 
   }
}

?>
