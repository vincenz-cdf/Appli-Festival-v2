<?php

$titre = "- Etablissements";
include("_debut.inc.php");
include("_gestionBase.inc.php"); 
include("_controlesEtGestionErreurs.inc.php");
echo "<br><p align='center' class='textArianne'><a  href = 'index.php'> Accueil </a> -> <a href = 'listeEtablissements.php'>
Liste des établissements </a> -> Modification d'un établissement</p> <br> ";


// MODIFIER UN ÉTABLISSEMENT 

// Déclaration du tableau des civilités
$tabCivilite=array("M.","Mme","Melle");  

$action=$_REQUEST['action'];
$id=$_REQUEST['id'];

// Si on ne "vient" pas de ce formulaire, il faut récupérer les données à partir 
// de la base (en appelant la fonction obtenirDetailEtablissement) sinon on 
// affiche les valeurs précédemment contenues dans le formulaire
if ($action=='demanderModifEtab')
{
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
   }
}
else
{
   $nom=$_REQUEST['nom']; 
   $adresseRue=$_REQUEST['adresseRue'];
   $codePostal=$_REQUEST['codePostal'];
   $ville=$_REQUEST['ville'];
   $tel=$_REQUEST['tel'];
   $adresseElectronique=$_REQUEST['adresseElectronique'];
   $type=$_REQUEST['type'];
   $civiliteResponsable=$_REQUEST['civiliteResponsable'];
   $nomResponsable=$_REQUEST['nomResponsable'];
   $prenomResponsable=$_REQUEST['prenomResponsable'];
   $nombreChambresOffertes=$_REQUEST['nombreChambresOffertes'];

   verifierDonneesEtabM($connexion, $id, $nom, $adresseRue, $codePostal, $ville,  
                        $tel, $nomResponsable, $nombreChambresOffertes);      
   if (nbErreurs()==0)
   {        
      modifierEtablissement($connexion, $id, $nom, $adresseRue, $codePostal, $ville, 
                            $tel, $adresseElectronique, $type, $civiliteResponsable, 
                            $nomResponsable, $prenomResponsable, $nombreChambresOffertes);
   }
}

echo "
<form method='POST' action='modificationEtablissement.php?'>
   <input type='hidden' value='validerModifEtab' name='action'>
   <table width='85%' cellspacing='0' cellpadding='0' align='center' 
   class='content-table'>
   
      <thead>
      <tr>
         <th colspan='3'>$nom ($id)</th>
      </tr>
      </thead>
      <tr>
         <th><input type='hidden' value='$id' name='id'></th>
      </tr>";
      
      echo '
      <tr>
         <td> Nom*: </td>
         <td><input type="text" value="'.$nom.'" name="nom" size="50" 
         maxlength="45"></td>
      </tr>
      <tr>
         <td> Adresse*: </td>
         <td><input type="text" value="'.$adresseRue.'" name="adresseRue" 
         size="50" maxlength="45"></td>
      </tr>
      <tr>
         <td> Code postal*: </td>
         <td><input type="text" value="'.$codePostal.'" name="codePostal" 
         size="4" maxlength="5"></td>
      </tr>
      <tr>
         <td> Ville*: </td>
         <td><input type="text" value="'.$ville.'" name="ville" size="40" 
         maxlength="35"></td>
      </tr>
      <tr>
         <td> Téléphone*: </td>
         <td><input type="text" value="'.$tel.'" name="tel" size ="20" 
         maxlength="10"></td>
      </tr>
      <tr>
         <td> E-mail: </td>
         <td><input type="text" value="'.$adresseElectronique.'" name=
         "adresseElectronique" size ="75" maxlength="70"></td>
      </tr>
      <tr>
         <td> Type*: </td>
         <td>';
            if ($type==1)
            {
               echo " 
               <input type='radio' name='type' value='1' checked>  
               Etablissement Scolaire
               <input type='radio' name='type' value='0'>  Autre";
             }
             else
             {
                echo " 
                <input type='radio' name='type' value='1'> 
                Etablissement Scolaire
                <input type='radio' name='type' value='0' checked> Autre";
              }
           echo "
           </td>
         </tr>
         <tr class='ligneTabNonQuad'>
            <td colspan='2' ><strong>Responsable:</strong></td>
         </tr>
         <tr class='ligneTabNonQuad'>
            <td> Civilité*: </td>
            <td> <select name='civiliteResponsable'>";
               for ($i=0; $i<3; $i=$i+1)
                  if ($tabCivilite[$i]==$civiliteResponsable) 
                  {
                     echo "<option selected>$tabCivilite[$i]</option>";
                  }
                  else
                  {
                     echo "<option>$tabCivilite[$i]</option>";
                  }
               echo '
               </select>&nbsp; &nbsp; &nbsp; Nom*: 
               <input type="text" value="'.$nomResponsable.'" name=
               "nomResponsable" size="26" maxlength="25">
               &nbsp; &nbsp; &nbsp; Prénom: 
               <input type="text"  value="'.$prenomResponsable.'" name=
               "prenomResponsable" size="26" maxlength="25">
            </td>
         </tr>
         <tr>
            <td> Nombre chambres offertes*: </td>
            <td><input type="text" value="'.$nombreChambresOffertes.'" name=
            "nombreChambresOffertes" size ="2" maxlength="3"></td>
         </tr>
      <tr>
         <td align="right">
         </td>
         <td align="left"><input type="submit" value="Valider" name="valider"><input type="reset" value="Annuler" name="annuler">
         </td>
      </tr>
      <tr>
         <td colspan="2" align="center"><a href="listeEtablissements.php">Retour</a>
         </td>
      </tr>
   </table>';
   
   echo "
  
</form>";

// En cas de validation du formulaire : affichage des erreurs ou du message de 
// confirmation
if ($action=='validerModifEtab')
{
   if (nbErreurs()!=0)
   {
      afficherErreurs();
   }
   else
   {
      echo "
      <h5><center>La modification de l'établissement a été effectuée</center></h5>";
   }
}

?>
