<?php 


    class User{

        public function validation($value){

            // va verifier le contenu des variable avant de laisser le code poursuivre ( trim , sanitisation)

            $email = strip_tags($value['email']); // ici on nettoie les valeurs envoyer par l'input de toute balise
            $username = strip_tags($value['username']);
            $password = strip_tags($value['password']);

            if (isset($email)) {
                $result = trim($email); // retire tout les espace vides
                 if (!preg_match("/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/", $result)) { 
                    $email='email erroné';
                }else{
                    $email = $result;
                }
            } // fin verif de l'email

            if (isset($username)) {
                $result = trim($username);
                 if (!preg_match("/^[a-zA-Z0-9 éèçà-]*$/", $result)) {
                    echo "Mauvais nom d'utilisateur";
                }else{
                    $username = $result;
                }
            } // fin verif username

            if (isset($password)) {
                $result = trim($password);
                 if (!preg_match("/^[a-zA-Z0-9 éèçà-]*$/", $result)) {                                 
                    echo "Mauvais MDP";
                }else{
                    $password = $result;
                }
            } // fin verif password


            if($value['inscription']=="register"){ // ici je m'assure qu'il a bien cliqué sur le bouton d'inscription
                
                $bdd=Dbconnect::connection();
                
                $this->saveUser($bdd,$email,$username,$password);
            }
        }
    
    
        public function saveUser($bdd,$email,$username,$password){
            // enregistre les donnée envoyer par le formulaire dans la ddb
            $table = $bdd->prepare("INSERT INTO users ( username,email,password) VALUES (?,?,?)");
            $table->bindParam(1, $username);
            $table->bindParam(2, $email);
            $table->bindParam(3, $password);

            $table->execute();
        }
    
        public function connectUser($val){
        
           $bdd=Dbconnect::connection();

           $resUser=strip_tags($val['userconnex']);
           $resPass=strip_tags($val['passconnex']);

           $actUser=trim($resUser,' ');
           $actPass=trim($resPass,' ');

            if (!preg_match("/^[a-zA-Z0-9 éèçà-]*$/", $actUser)) { 
                $userName=null;
                echo "mauvais nom d'utilisateur";
            }else{
              $userName = $actUser;
            }

            if (!preg_match("/^[a-zA-Z0-9 ,.éèçà-]*$/", $actPass)) { 
                 $userPass=null;
                echo "mauvais mot de passe";
            }else{
                $userPass = $actPass;
            }



                if($userPass != null && $userName!= null){

                

                    $reqUsr= $bdd->prepare("SELECT * FROM users WHERE username = ? AND password = ? ");
                    $reqUsr->execute( [$userName,$userPass] );

                    $data=$reqUsr->fetchALL(PDO::FETCH_ASSOC);

                    if($userPass==$data[0]['password'] && $userName==$data[0]['username']){
                    
                   

                    $id=$data[0]['userId'];
                    $userName=$data[0]['username'];
                    $userPass=$data[0]['password'];

                    $_SESSION['userId']=intval($id);
                    $_SESSION['user'] = $userName;
                    $_SESSION['mdp'] = $userPass;

                    echo"Bonjour :".$userName." vous êtes actuellement connecté";

                    $update= $bdd->prepare("UPDATE users SET connected=? WHERE userId=?");
                    $connected=1;
                    $execUpdt=$update->execute( [$connected,$id] );

                    if($execUpdt){
                       echo "<script>alert('Vous êtes bien connecter !');</script>";
                    }else{
                       echo "<script>alert('erreur de connexion !');</script>";
                    }

                    }    

                }
              
        }
    
        public function editUser($bdd,$isMail,$isUser,$id){
            $bdd=Dbconnect::connection();
            if($isMail){
                $update= $bdd->prepare("UPDATE users SET email=? WHERE userId=?");
                $newMail=$_POST['newMail'];
                $execUpdt=$update->execute( [$newMail,$id] );

                if($execUpdt){
                    echo"Modification executé";
                }
            }
            if($isUser){ 
                $update= $bdd->prepare("UPDATE users SET username=? WHERE userId=?");
                $newName=$_POST['newName'];
                $execUpdt=$update->execute( [$newName,$id] );

                if($execUpdt){
                    echo"Modification executé";
                }
            }

          
        }

 
        public function deleteUser($bdd,$id){
          
            $bdd=Dbconnect::connection();

            $delete=$bdd->prepare("DELETE FROM users WHERE userId=$id");
            $delete->execute();
            
            if($delete){
                echo "<script>alert('utilisateur supprimer !');</script>";
                
             }else{
                echo "<script>alert('erreur lors de la suppression !');</script>";
             }
            
        }

        public function deconectUser($bdd,$id){
            $connected=0;
        
            $deconect = $bdd->prepare("UPDATE users SET connected=? WHERE userId=?");
            $execdeconect = $deconect->execute( [$connected,$id] );

            echo "vous êtes deconnecté";
            session_destroy();
        }
    
    }




    






?>
