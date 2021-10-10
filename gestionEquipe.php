<?php

$titre="- Equipes";
include("_debut.inc.php");
include("_gestionBase.inc.php"); 
include("_controlesEtGestionErreurs.inc.php");


echo "
<br>
<p align='center' class='textArianne'><a  href = 'index.php'> Accueil </a> ->  Gestion d'équipes </p> <br>";

?>
<!DOCTYPE html>
<html>
<head>
	<title>Gestions d'équipes</title>
</head>
<body>
	<?php
      echo "
   <p align='center'><a class='buttonCréa' href='creationEquipe.php?action=demanderCreEqu'>
   Créer une équipe</a></p>";
      echo "<h4 class='textArianne' align='center'>Le symbole * indique que l'on ne peux pas le supprimer car il a déjà des chambres d'attribuées<h4>";
      echo "
      <table width='70%' cellspacing='0' cellpadding='0' align='center' 
      class='content-equipe'>";

      echo "
      <thead>
      <tr>
         <th><strong> Equipe</strong>&nbsp;
         </th>
         <th>&nbsp
         </th>
         <th><strong>Nom groupe</strong>&nbsp;
         </th>
         <th><strong>Stand</strong>&nbsp;
         </th>
         <th><strong>Modifications / Suppressions</strong>&nbsp;
         </th>
      </tr>
      </thead>
      ";

   $req=obtenirReqEquipe();
   $rsEqu=$connexion->query($req);
   $lgEqu=$rsEqu->fetchAll();
   foreach ($lgEqu as $row){
      $id=$row['id'];
      $nom=$row['nom'];
      $nombrePersonnes=$row['nombrePersonnes'];
      $stand=$row['stand'];
            echo "<tr class='content-table'>";
            if($nombrePersonnes == 0){
            }else{
               if($nombrePersonnes == 1){
                     echo"<td>solo ( ".$nombrePersonnes."  personne) </td><td><a href='detailEquipe.php?id=$id' class='buttonTab'>Détail</a>&nbsp;&nbsp;&nbsp;</td>";
               }else if($nombrePersonnes> 1){
                     echo"<td>Équipe (".$nombrePersonnes." personnes)</td><td> <a href='detailEquipe.php?id=$id' class='buttonTab'>Détail</a>&nbsp;</td>";
               }

            echo"<td>".$nom."</td>";
           if ($stand == 1) {
				echo"<td><input type='checkbox' onclick='return false' value='1' checked='yes' >&nbsp</input></td>";
		}else{
				echo"<td><input type='checkbox' onclick='return false' value='1'></input></td>";
		}
		echo"<td><a class='buttonTab' href='modificationEquipe.php?action=demanderModifEqu&amp;id=$id'>Modifier</a> / "; 
      $req="SELECT * from attribution where idGroupe = '$id'";
      $teste=$connexion->query($req);
      $teste=$teste->fetchAll();
      $cpt=0;
      foreach ($teste as $row) {
         $cpt=$cpt+1;
      }
      if($cpt>0){
         echo " *     &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";
      }else{
      echo "<a class='buttonTab' href='suppressionEquipe.php?action=demanderSupprEqu&amp;id=$id'>Supprimer</a></td>";}
      }
  }
   ?>
</body>
</html>