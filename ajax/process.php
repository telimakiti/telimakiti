<?php
include "../include/database.php";
 $bd=new dataa();
  if(isset($_POST['action']) && $_POST['action']=='create'){
   extract($_POST);
   $bd->insererProduit($libelle_pro,$prix_pro,$photo_pro,$description_pro,$id_boutique);
   echo 'ok';
  }
  // if(isset($_POST['action']) && $_POST['action']=='fetch'){
  //   $output="";
  //   if($bd->contbill()>0){
  //       $line=$bd->show();
  //      echo "<table>";
  //      echo "<th>";
  //      echo "<tr>";
  //      echo "<td >numero</td>";
  //      echo   "<td>nom</td>";
  //      echo "</tr>";
  //      echo "</th>";
  //      echo "<tbody>";
  //       foreach($line as $li){
  //           echo "<tr>";
  //           echo "<td>".$li->id."</td>";
  //           echo "<td>".$li->nom."</td>";
  //           echo "</tr>";
            
  //       }
      
  //       echo "</tbody>";
  //      echo "</table>";
  //   }else{
  //       echo '<h3>pas elements dans la base</h3>';
  //   }
  // }

?>