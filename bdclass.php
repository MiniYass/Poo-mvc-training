<?php

    class Dbconnect{

        static public function connection(){

            try{
               $dns="mysql:host=localhost;dbname=clients;charset=utf8";
            }catch(PDOExeption $e){
                echo "DB connexion échoué";
            }
            return new PDO($dns,'root','');
        }
    }


?>