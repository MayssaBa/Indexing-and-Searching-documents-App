<?php
$mc = $_POST['mc'];

if(!empty($mc)){
    $cnx=mysqli_connect('localhost','root','');
    if($cnx){
        echo "<p>connexion réussie</p>";
        $bd = mysqli_select_db($cnx, "test");
        if($bd){
            echo "<p class='success-message'> Connexion à la base de données effectuée </p>";
            $requete = "SELECT doc_id,doc_title,doc_path FROM document WHERE doc_keywords LIKE '%$mc%'";
            $resultat = mysqli_query($cnx, $requete);
            if($resultat){
                if(mysqli_num_rows($resultat)>0){
                    $content.="<table style='width: 300px;
                    margin-bottom: 10px;
                    padding: 10px;
                    border: 1px solid #ccc;
                    border-radius: 7px;
                    box-sizing: border-box;'>
                    <tr><th>Num</th>
                    <th>Titre</th>
                    <th>Adresse</th></tr>";
                    $i=1;
                    while($row=mysqli_fetch_assoc($resultat)){
                        $content.= "<tr><td>".$i."</td><td>".$row['doc_title']."</td><td>".$row['doc_path']."</td></tr>";
                        $i++;
                    }$content.="</table>";
                }else{
                    $content.= "<p style='color:red;'>0 resutats!</p>";
                }
            }else{
                $content.= "<p style='color:red;'>Erreur: ".mysqli_error($cnx)."</p>";
            }
        }else{
            $content.= "<p style='color:red;'>Pas de base de donnees! ".mysqli_error($cnx)."</p>";
        }
    }else{
        $content.= "<p style='color:red;''>Erreur: ".mysqli_connect_error()."</p>";
    }
}else{
    $content.= "<p style='color:red;'>Entrer des mots clé!</p>";
}
include 'resl_rech.php';
