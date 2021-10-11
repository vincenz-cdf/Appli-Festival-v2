<?php

$titre="- Equipes";
include("_debut.inc.php");
include("_gestionBase.inc.php"); 
include("_controlesEtGestionErreurs.inc.php");

echo "<br><p align='center' class='textArianne'><a  href = 'index.php'> Accueil </a> -> <a href = 'gestionequipe.php'>
Gestion d'équipes  </a> -> Création d'équipes</p><br>";

$action=$_REQUEST['action'];

if ($action=='demanderCreEqu') 
{
   $id='';
   $nom='';
   $nombrePersonnes='';
   $nomPays='';
   $stand='';
   $identiteResponsable='';
   $adressePostale='';  
}
else
{
              $nom=$_REQUEST['nom'];
              $identiteResponsable=$_REQUEST['identiteResponsable'];
              $adressePostale=$_REQUEST['adressePostale'];
              $nombrePersonnes=$_REQUEST['nombrePersonnes'];
              $nomPays=$_REQUEST['nomPays'];
              $stand=$_REQUEST['stand'];

}
  $obtenirID=obtenirIDEquipe($connexion);
foreach ($obtenirID as $row)
{
  $id=$row['dernierID'];
  $id=$id+1;
}

echo "
<form method='POST' action='creationEquipe.php?'>
   <input type='hidden' value='validerCreEqu' name='action'>
   <table width='85%' align='center' cellspacing='0' cellpadding='0' 
   class='content-table'>
      <thead>
         <tr>
         <th colspan='3'>Nouvelle Equipe</th>
         </tr>
      </thead>";
      echo '
      <tr>
         <td> Nom équipe: </td>
         <td><input type="text" value="'.$nom.'" name="nom" size="50" 
         maxlength="45" required></td>
      </tr>
      <tr class="ligneTabNonQuad">
         <td> Nom de la ligue: </td>
         <td><input type="text" value="'.$identiteResponsable.'" name="identiteResponsable" size="50" 
         maxlength="45" required></td>
      </tr>
      <tr class="ligneTabNonQuad">
         <td> Code postal: </td>
         <td><input type="text" value="'.$adressePostale.'" name="adressePostale" size="50" 
         maxlength="45" required></td>
      </tr>
      <tr class="ligneTabNonQuad">
         <td> Nombres Personnes: </td>
         <td><input type="number" value="'.$nombrePersonnes.'" name="nombrePersonnes" 
         size="3" maxlength="3" required></td>
      </tr>
      <tr class="ligneTabNonQuad">
         <td> Nom pays: </td>
         <td><input type="text" value="'.$nomPays.'" name="nomPays" size="40" 
         maxlength="35" required></td>
      </tr>';
      echo "
      <tr>
         <td> Stand: </td>
         <td>";
            if ($stand==1)
            {
               echo " 
               <input type='radio' name='stand' value='1' checked>  
               Oui
               <input type='radio' name='stand' value='0'>  Non";
             }
             else
             {
                echo " 
                <input type='radio' name='stand' value='1'> 
                Oui
                <input type='radio' name='stand' value='0' checked> Non";
              }
           echo '
           </td>
         </tr>
               <tr>
         <td align="right"></td>
         <td><input class="buttonTab" type="submit" value="Valider" name="valider"><input type="reset" class="buttonCréa" value="Annuler" name="annuler"></td>
      </tr>
      <tr>
         <td colspan="2" align="center"><a class="buttonRetour" href="gestionequipe.php">Retour</a>
         </td>
      </tr>
   </table>';
   
   echo "
   <table class='content-table' align='center' cellspacing='15' cellpadding='0'>


   </table>
</form>";

// En cas de validation du formulaire : affichage des erreurs ou du message de 
// confirmation
if ($action=='validerCreEqu')
{
                  $sql="SELECT id FROM Groupe ORDER by id Desc LIMIT 0,1";
            $sth=$connexion->query($sql);
            $resultat=$sth->fetchall(PDO::FETCH_ASSOC);
            foreach ($resultat as $row) {
                $code= $row['id'];
            }
            $codeC = substr($code, 0,1);
            $codeCh = substr($code, 1,4);
            $codeCh =$codeCh +1;
            $id = $codeC.$codeCh;
            $sql="SELECT nom FROM Groupe where nom='$nom'";
            $sth=$connexion->query($sql);
            $resultat=$sth->fetchall(PDO::FETCH_ASSOC);
            $cpt=0;
            foreach ($resultat as $row) {
              $cpt=$cpt+1;
            }
            if($cpt>0){
                echo '<script language="Javascript"> alert ("Les données entrées sont similaires à une autre équipe déjà existante" )</script>';  
            }else{
              $nom=$_REQUEST['nom'];
              $identiteResponsable=$_REQUEST['identiteResponsable'];
              $adressePostale=$_REQUEST['adressePostale'];
              $nombrePersonnes=$_REQUEST['nombrePersonnes'];
              $nomPays=$_REQUEST['nomPays'];
              $stand=$_REQUEST['stand'];
              creerEquipe($connexion,$id,$nom,$identiteResponsable,$adressePostale,$nombrePersonnes,$nomPays,$stand);
                    echo "
      <h5><center>La création de l'équipe a été effectuée</center></h5>";
            }
}

?>
