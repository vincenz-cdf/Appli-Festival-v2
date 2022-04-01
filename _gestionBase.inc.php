<?php

// FONCTIONS DE CONNEXION

   $hote="localhost";
   $login="root";
   $mdp="";

   try{
      $connexion = new PDO("mysql:host=$hote;dbname=festival", $login, $mdp);
      $connexion->exec("set names utf8");
      return $connexion;
   }
   catch(PDOException $e){
      echo "Erreur :" . $e->getMessage();
      die();
   }

// FONCTIONS DE GESTION DES ÉTABLISSEMENTS

function obtenirReqEtablissements()
{
   $req="SELECT id, nom, nombreChambresOffertes from Etablissement order by id";
   return $req;
}

function obtenirReqEquipe()
{
   $req="SELECT * from Groupe order by nom";
   return $req;
}

function obtenirReqEtablissementsOffrantChambres()
{
   $req="SELECT id, nom, nombreChambresOffertes from Etablissement where 
         nombreChambresOffertes!=0 order by id";
   return $req;
}

function obtenirReqEtablissementsAyantChambresAttribuées()
{
   $req="SELECT distinct id, nom, nombreChambresOffertes from Etablissement, 
         Attribution where id = idEtab order by id";
   return $req;
}

function obtenirDetailEtablissement($connexion, $id)
{
   $req="SELECT * from Etablissement where id='$id'";
   $rsEtab=$connexion->query($req);
   return $rsEtab->fetchAll();
}

function obtenirDetailEquipe($connexion, $id)
{
   $req="SELECT * from Groupe where id='$id'";
   $rsEtab=$connexion->query($req);
   return $rsEtab->fetchAll();
}

function supprimerEtablissement($connexion, $id)
{
   $req="DELETE from Etablissement where id='$id'";
   $connexion->exec($req);
}

function supprimerEquipe($connexion, $id)
{
   $req="DELETE from Groupe where id='$id'";
   $connexion->exec($req);
}

function modifierEtablissement($connexion, $id, $nom, $adresseRue, $codePostal, 
                               $ville, $tel, $adresseElectronique, $type, 
                               $civiliteResponsable, $nomResponsable, 
                               $prenomResponsable, $nombreChambresOffertes)
{  
   $nom=str_replace("'", "''", $nom);
   $adresseRue=str_replace("'","''", $adresseRue);
   $ville=str_replace("'","''", $ville);
   $adresseElectronique=str_replace("'","''", $adresseElectronique);
   $nomResponsable=str_replace("'","''", $nomResponsable);
   $prenomResponsable=str_replace("'","''", $prenomResponsable);
  
   $req="UPDATE Etablissement set nom='$nom',adresseRue='$adresseRue',
         codePostal='$codePostal',ville='$ville',tel='$tel',
         adresseElectronique='$adresseElectronique',type='$type',
         civiliteResponsable='$civiliteResponsable',nomResponsable=
         '$nomResponsable',prenomResponsable='$prenomResponsable',
         nombreChambresOffertes='$nombreChambresOffertes' where id='$id'";
   
   $connexion->exec($req);
}

function modifierEquipe($connexion, $id, $nom,$identiteResponsable,$adressePostale, $nombrePersonnes, $nomPays, $stand)
{  
   $nom=str_replace("'", "''", $nom);
   $identiteResponsable=str_replace("'", "''", $identiteResponsable);
   $adressePostale=str_replace("'", "''", $adressePostale);
   $nombrePersonnes=str_replace("'","''", $nombrePersonnes);
   $nomPays=str_replace("'","''", $nomPays);
   $stand=str_replace("'","''", $stand);
  
   $req="UPDATE Groupe set nom='$nom',identiteResponsable='$identiteResponsable',adressePostale='$adressePostale', nombrePersonnes='$nombrePersonnes', nomPays='$nomPays', stand='$stand' where id='$id'";
   
   $connexion->exec($req);
}

function creerEtablissement($connexion, $id, $nom, $adresseRue, $codePostal, 
                            $ville, $tel, $adresseElectronique, $type, 
                            $civiliteResponsable, $nomResponsable, 
                            $prenomResponsable, $nombreChambresOffertes)
{ 
   $nom=str_replace("'", "''", $nom);
   $adresseRue=str_replace("'","''", $adresseRue);
   $ville=str_replace("'","''", $ville);
   $adresseElectronique=str_replace("'","''", $adresseElectronique);
   $nomResponsable=str_replace("'","''", $nomResponsable);
   $prenomResponsable=str_replace("'","''", $prenomResponsable);
   
   $statement = $connexion->prepare("INSERT into Etablissement(id, nom, adresseRue, codePostal, ville, tel, adresseElectronique, type, civiliteResponsable, nomResponsable, prenomResponsable,
   nombreChambresOffertes) values (?,?,?,?,?,?,?,?,?,?,?,?)");
   
   $statement->bindParam(1, $id);
   $statement->bindParam(2, $nom);
   $statement->bindParam(3 , $adresseRue); 
   $statement->bindParam(4 , $codePostal);
   $statement->bindParam(5 , $ville);
   $statement->bindParam(6 , $tel);
   $statement->bindParam(7 , $adresseElectronique);
   $statement->bindParam(8 , $type);
   $statement->bindParam(9 , $civiliteResponsable);
   $statement->bindParam(10 , $nomResponsable);
   $statement->bindParam(11 , $prenomResponsable);
   $statement->bindParam(12 , $nombreChambresOffertes);
   $statement->execute();
}


function estUnIdEtablissement($connexion, $id)
{
   $req="SELECT * from Etablissement where id='$id'";
   $rsEtab=$connexion->query($req);
   return $rsEtab->fetchAll();
}

function estUnNomEtablissement($connexion, $mode, $id, $nom)
{
   $nom=str_replace("'", "''", $nom);
   // S'il s'agit d'une création, on vérifie juste la non existence du nom sinon
   // on vérifie la non existence d'un autre établissement (id!='$id') portant 
   // le même nom
   if ($mode=='C')
   {
      $req="SELECT * from Etablissement where nom='$nom'";
   }
   else
   {
      $req="SELECT * from Etablissement where nom='$nom' and id!='$id'";
   }
   $rsEtab=$connexion->query($req);
   return $rsEtab->fetchAll();
}

function obtenirNbEtab($connexion)
{
   $req="SELECT count(*) as nombreEtab from Etablissement";
   $rsEtab=mysqli_query($connexion, $req);
   $lgEtab=mysqli_fetch_array($rsEtab);
   return $lgEtab["nombreEtab"];
}

function obtenirNbEtabOffrantChambres($connexion)
{
   $req="SELECT count(*) as nombreEtabOffrantChambres from Etablissement where 
         nombreChambresOffertes!=0";
   $rsEtabOffrantChambres=$connexion->query($req);
   $lgEtabOffrantChambres=$rsEtabOffrantChambres->fetch();
   return $lgEtabOffrantChambres["nombreEtabOffrantChambres"];
}

// Retourne false si le nombre de chambres transmis est inférieur au nombre de 
// chambres occupées pour l'établissement transmis 
// Retourne true dans le cas contraire
function estModifOffreCorrecte($connexion, $idEtab, $nombreChambres)
{
   $nbOccup=obtenirNbOccup($connexion, $idEtab);
   return ($nombreChambres>=$nbOccup);
}

// FONCTIONS RELATIVES AUX GROUPES

function obtenirReqIdNomGroupesAHeberger()
{
   $req="SELECT id, nom, nompays, nombrePersonnes from Groupe order by id";
   return $req;
}

function obtenirNomGroupe($connexion, $id)
{
   $req="SELECT nom from Groupe where id='$id'";
   $rsGroupe=$connexion->query($req);
   $lgGroupe=$rsGroupe->fetch();
   return $lgGroupe["nom"];
}

// FONCTIONS RELATIVES AUX ATTRIBUTIONS

// Teste la présence d'attributions pour l'établissement transmis    
function existeAttributionsEtab($connexion, $id)
{
   $req="SELECT * From Attribution where idEtab='$id'";
   $rsAttrib=$connexion->query($req);
   return $rsAttrib->fetchAll();
}

// Retourne le nombre de chambres occupées pour l'id étab transmis
function obtenirNbOccup($connexion, $idEtab)
{
   $req="SELECT IFNULL(sum(nombreChambres), 0) as totalChambresOccup from
        Attribution where idEtab='$idEtab'";
   $rsOccup=$connexion->query($req);
   $lgOccup=$rsOccup->fetchAll();
   foreach ($lgOccup as $row) {
      return $row["totalChambresOccup"];
   }
}

// Met à jour (suppression, modification ou ajout) l'attribution correspondant à
// l'id étab et à l'id groupe transmis
function modifierAttribChamb($connexion, $idEtab, $idGroupe, $nbChambres)
{
   $req="SELECT count(*) as nombreAttribGroupe from Attribution where idEtab=
        '$idEtab' and idGroupe='$idGroupe'";
   $rsAttrib=$connexion->query($req);
   $lgAttrib=$rsAttrib->fetch();
   if ($nbChambres==0)
      $req="DELETE from Attribution where idEtab='$idEtab' and idGroupe='$idGroupe'";
   else
   {
      if ($lgAttrib["nombreAttribGroupe"]!=0)
         $req="UPDATE Attribution set nombreChambres=$nbChambres where idEtab=
              '$idEtab' and idGroupe='$idGroupe'";
      else
         $req="INSERT into Attribution values('$idEtab','$idGroupe', $nbChambres)";
   }
   $connexion->query($req);
}

// Retourne la requête permettant d'obtenir les id et noms des groupes affectés
// dans l'établissement transmis
function obtenirReqGroupesEtab($id)
{
   $req="SELECT distinct id, nom, nompays from Groupe, Attribution where 
        Attribution.idGroupe=Groupe.id and idEtab='$id'";
   return $req;
}
            
// Retourne le nombre de chambres occupées par le groupe transmis pour l'id étab
// et l'id groupe transmis
function obtenirNbOccupGroupe($connexion, $idEtab, $idGroupe)
{
   $req="SELECT nombreChambres From Attribution where idEtab='$idEtab'
        and idGroupe='$idGroupe'";
   $rsAttribGroupe=$connexion->query($req);
   if ($lgAttribGroupe=$rsAttribGroupe->fetch())
      return $lgAttribGroupe["nombreChambres"];
   else
      return 0;
}

function creerEquipe($connexion, $id, $nom,$identiteResponsable,$adressePostale, $nombrePersonnes, $nomPays, $stand)
{ 
   $id=str_replace("'", "''", $id);
   $nom=str_replace("'", "''", $nom);
   $identiteResponsable=str_replace("'", "''", $identiteResponsable);
   $adressePostale=str_replace("'", "''", $adressePostale);
   $nombrePersonnes=str_replace("'","''", $nombrePersonnes);
   $nomPays=str_replace("'","''", $nomPays);
   $stand=str_replace("'","''", $stand);
   $req="INSERT into Groupe values ('$id','$nom','$identiteResponsable','$adressePostale',$nombrePersonnes, '$nomPays','', $stand)";
   
   $connexion->query($req);
}

function creerLigue($connexion,$compte,$intitule,$tresorier, $adresseboo, $adresseecr)
{ 
   $compte=str_replace("'","''", $compte);
   $intitule=str_replace("'","''", $intitule);
   $tresorier=str_replace("'","''", $tresorier);
   $adresseboo=str_replace("'","''", $adresseboo); 
   $adresseecr=str_replace("'","''", $adresseecr);       
   $req="INSERT into Ligue values ('$compte','$intitule','$tresorier','$adresseboo','$adresseecr')";
   
   $connexion->query($req);
}

function obtenirIDEquipe($connexion)
{
    $req ='SELECT LAST_INSERT_ID(id) as "dernierID" from Groupe order by id desc limit 1';
    $sth = $connexion->query($req);
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

function obtenirIDEtab($connexion)
{
    $req ='SELECT LAST_INSERT_ID(id) as "dernierEID" from Etablissement order by id desc limit 1';
    $sth = $connexion->query($req);
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

function retourneNbchambre(int $nbChambres){ // cette fonctions permmet de mettre le nombre de chambre prise par groupe
   $chambre = round($nbChambres/3); // on prend la version arondit en dessous
   if($nbChambres%3 == 1){ // on regarde si il reste des personne si oui on rajoute une chmabre
      $chambre+=1;
   }
   return $chambre;
}

function nbchlouer($connexion, $idGroupe){
   $req= "Select SUM(nombreChambres) FROM attribution where idGroupe = '$idGroupe'";
   $obtenirCompte=$connexion->query($req);
   $sth = $obtenirCompte->fetch();
   return $sth;
}

function optionModifAttrib($i,$nbOccupGroupe){ // fonctions pour mettre en options les bonne valeur et selectionner la valeur qu'il faut 
   if($i == $nbOccupGroupe){
      echo "<option selected>$nbOccupGroupe</option>";    
   }else{
      echo "<option>$i</option>";
   }
}
?>

