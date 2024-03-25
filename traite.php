<?php
$titre = $_POST['titre'];
$mc = $_POST['mc'];
$path = "";

if (isset ($_FILES['doc']['name']) and $_FILES['doc']['error'] == 0) {
    if ($_FILES['doc']['size'] <= 100000000) {
        $infosfichier = pathinfo($_FILES['doc']['name']);
        $extension_upload = $infosfichier['extension'];
        $extensions_autorisees = array('txt', 'doc', 'pdf', 'docx','jpg');
        if (in_array($extension_upload,$extensions_autorisees)) {
            $path = 'C/DOCS/' . basename($_FILES['doc']['name']);
            if (!empty($titre)){
                if(!empty($mc)) {
                    move_uploaded_file($path,$_FILES['doc']['tmp_name']);
                    $connexion = mysqli_connect("localhost", "root", "");
                    if ($connexion) {
                        $content.= "<p style='color: #008000;margin-bottom: 10px;'>Connexion au serveur effectuée</p>";
                        $content.= "<p style='color: #008000;margin-bottom: 10px;'>connexion réussie</p>";
                        $bd = mysqli_select_db($connexion, "test");
                        if ($bd) {
                             $content.= "<p style='color: #008000;margin-bottom: 10px;'> Connexion à la base de données effectuée </p>";
                            $requete = "INSERT INTO document(doc_title,doc_path,doc_keywords) values ('$titre','$path','$mc')";
                            $resultat = mysqli_query($connexion, $requete);
                            if($resultat){
                                $content.= "<p style='color: #008000;margin-bottom: 10px;'>Document bien inserée </p>";
                            }else{
                                $content.= "<p style='color: #ff0000;margin-bottom: 10px;'>Erreur: ".mysqli_error($connexion)."</p>";
                            }
                        } else{
                            $content.= "<p style='color: #ff0000;margin-bottom: 10px;'>Pas de base de donnees! ".mysqli_error($connexion)."</p>";
                        }
                    }else{
                        $content.= "<p style='color: #ff0000;margin-bottom: 10px;'>Erreur: ".mysqli_connect_error()."</p>";}
            }else{
                $content.= "<p style='color: #ff0000;margin-bottom: 10px;'>Tous les champs doit etre saisi!</p>";    
            }
        }else{
            $content.= "<p style='color: #ff0000;margin-bottom: 10px;'>Tous les champs doit etre saisi!</p>";    
        }
    }else{
        $content.= "<p style='color: #ff0000;margin-bottom: 10px;'>Entrer un fichier avec une extension autoriseé!</p>";
    }  
}else{
    $content.= "<p style='color: #ff0000;margin-bottom: 10px;'>Le fichier est trop volumineux!</p>";
}
}else{
    $content.= "<p style='color: #ff0000;margin-bottom: 10px;'>Tous les champs doit etre saisi!</p>";
}
include 'resl_ajout.php';
