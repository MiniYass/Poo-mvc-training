<?php

    class Dbconnect{

        static public function connection(){
            // ici la fonction est en static pour pouvoir être utilisé plus facilement sur mes differente pages.

            try{
               $dns="mysql:host=localhost;dbname=clients;charset=utf8";
            }catch(PDOExeption $e){
                echo "DB connexion échoué";
            }
            return new PDO($dns,'root','');
        }
    }


?>
