<?php 
class dataa
{
    private $host="mysql:host=localhost";
    private $user="root";
    private $passwrd="";
    private $db="dbname=makiti";
  //fonction de connexion a la base
    private function getconnexion(){
     try{
          return new PDO($this->host.';'.$this->db,$this->user,$this->passwrd);
     }catch(PDOException $e){
            die('Error'.$e->getMessage());
        }
    }
    //verification de mail dans la boutique
    public function verifiermail($mail){
        $q=$this->getconnexion()->query("SELECT id_compte FROM compte WHERE mail='$mail'")->fetchAll(PDO::FETCH_OBJ);
        $q=json_encode($q);
        $q=json_decode($q,true);
        foreach($q as $ligne){
            $text=$ligne['id_compte'];
          } 
        return (int)$text;
    }
//insertion des dans la boutique
   public function boutique($id_boutique,$nom_boutique,$nom_quarter,$momo,$photo_boutique,$orange_money,$carte_bancaire,$paypal,$id_compte,$id_categorie){
        
    $q=$this->getconnexion()->prepare("INSERT INTO boutique(id_boutique,nom_boutique,nom_quarter,momo,photo_boutique,orange_money,carte_bancaire,paypal,id_compte,id_categorie) 
    VALUES(:id_boutique,:nom_boutique,:nom_quarter,:momo,:photo_boutique,:orange_money,:carte_bancaire,:paypal,:id_compte,:id_categorie)");
    return $q->execute([
        'id_boutique'=>$id_boutique,
         'nom_boutique'=>$nom_boutique,
         'nom_quarter'=>$nom_quarter,
         'momo'=>$momo,
         'photo_boutique'=>$photo_boutique,
         'orange_money'=>$orange_money,
         'carte_bancaire'=>$carte_bancaire,
         'paypal'=>$paypal,
         'id_compte'=>$id_compte,
         'id_categorie'=>$id_categorie
        ]); 
        }    //afficher toutes les categories des article du site
            public function categorie()
            {
                return $this->getconnexion()->query("SELECT id_categorie,non_categorie FROM categorie ORDER BY non_categorie ASC")->fetchAll(PDO::FETCH_OBJ);
            }
             //affichage des villes;
             public   function afficheVille()
            {
                return $this->getconnexion()->query("SELECT * FROM ville ORDER BY nom_ville  ASC")->fetchAll(PDO::FETCH_OBJ);
            }
           //affichage de profile
           public function profile($mail)
           {
            return $this->getconnexion()->query("SELECT nom,prenom,tel,mail,photo_profill FROM compte WHERE mail='$mail'")->fetchAll(PDO::FETCH_OBJ);
           }
           
     //cest une fonction qui permet de recuperer le nom et
     // le prenom d'un utilisateur pour les session
     public  function sessioner($mail){
        $text="";
        $q=$this->getconnexion()->query("SELECT prenom FROM compte WHERE mail='$mail'")->fetchAll(PDO::FETCH_OBJ);
        $q=json_encode($q);
        $q=json_decode($q,true);
        foreach($q as $ligne){
            $text=$ligne['prenom'];
          } 
        return $text;
    }
    //traitement de l'image avant de l'inserer dans la base

    public  function traitement(){
        $resutat=0;
        if(isset($_FILES['photo'])){
        $photo=$_FILES['photo']['name'];
        $photo_tmp=$_FILES['photo']['tmp_name'];
        strtolower($photo);
        $tt=explode('.',$photo);
        $ss=end($tt);
        if(isset($ss)){
        if($ss=='jpeg'OR $ss=='jpg'OR $ss=='jpng' OR $ss=='gif'){
           $resutat=1;
        }
        }
     }
   return  $resutat;
 }
//verification de login dans la base
public  function verification_login($mail,$pass)
    {
    $text=1;
    $q=$this->getconnexion()->query("SELECT mail,passwrd FROM compte")->fetchAll(PDO::FETCH_OBJ);
    $q=json_encode($q);
    $q=json_decode($q,true);
    foreach($q as $ligne){
        if(strtolower($ligne['mail'])==strtolower($mail)){
            if(password_verify($pass,$ligne['passwrd'])){
              $text=0;
            }
         }
      } 
      return $text;
}
//verification mail
public  function verification($mail)
{
    $text=1;
    $q=$this->getconnexion()->query("SELECT mail FROM compte")->fetchAll(PDO::FETCH_OBJ);
    $q=json_encode($q);
    $q=json_decode($q,true);
    foreach($q as $ligne){
        if(strtolower($ligne['mail'])==strtolower($mail)){
              $text=0;
         }
      } 
      return $text;
}

//insertion d'un utilisateur 

public  function inserer($nom,$prenom,$sex,$age,$tel,$mail,$ville,$photo,$passwrd)
{
    $q=$this->getconnexion()->prepare("INSERT INTO compte(nom,prenom,age,sex,photo_profill,mail,tel,passwrd,ville_id_ville) 
    VALUES(:nom,:prenom,:age,:sex,:photo_profill,:mail,:tel,:passwrd,:ville_id_ville)");
    return $q->execute([
         'nom'=>$nom,
         'prenom'=>$prenom,
         'sex'=>$sex,
         'age'=>$age,
         'photo_profill'=>$photo,
         'mail'=>$mail,
         'tel'=>$tel,
         'passwrd'=>$passwrd,
         'ville_id_ville'=>$ville
    ]); 
}
//affichage des boutiques dans la table boutique
public function afficheboutique()
{
    return $this->getconnexion()->query("SELECT id_boutique,nom_boutique,nom_quarter,photo_boutique,photo_profill FROM boutique INNER JOIN compte ON boutique.id_compte = compte.id_compte")->fetchAll(PDO::FETCH_OBJ);
}
//affichage des tous les produits de la table produit
public function afficheProduit()
{
    return $this->getconnexion()->query("SELECT id_pro,libelle_pro,prix_pro,photo_pro,description_pro FROM produit ORDER BY libelle_pro ASC")->fetchAll(PDO::FETCH_OBJ);
}

//insertion des produits dans la table produit

public  function insererProduit($libelle_pro,$prix_pro,$photo_pro,$description_pro,$id_boutique)
{
    $q=$this->getconnexion()->prepare("INSERT INTO produit(libelle_pro,prix_pro,photo_pro,description_pro,id_boutique);
    VALUES(:libelle_pro,:prix_pro,:photo_pro,:description_pro,:id_boutique)");
    return $q->execute([
         'libelle_pro'=>$libelle_pro,
         'prix_pro'=>$prix_pro,
         'photo_pro'=>$photo_pro,
         'description_pro'=>$description_pro,
         'id_boutique'=>$id_boutique
    ]); 
}

 

}
?>



