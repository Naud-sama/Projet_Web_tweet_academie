<?php
class profile {
    public function affprof()
    {
        try
        {
            $bdd = new PDO('mysql:host=127.0.0.1;dbname=common-database;charset=utf8','root','');
            if(!isset($_SESSION))
            {
                session_start();
            }
        }
        catch(Exception $e)
        {
            die('Erreur : '.$e->getMessage());
        }
        $requser = $bdd->prepare('SELECT login,avatar,lastname,firstname,birthdate,email,register_date FROM users');
        $requser->execute();
        $userinfo = $requser->fetch();
        echo '
        <h2>Profil de
        '. $userinfo['login'] .'
        </h2>
        <table>
        <tr>
        <th>Avatar</th>
        <td>
         <img src="img/avatar/'. $userinfo['avatar'] .'" alt="avatar"/>
        </td>
        </tr>
        <tr>
        <th>Pseudo</th>
        <td>
        '.$userinfo['login'].'
        </td>
        </tr>
        <th>Nom</th>
        <td>
        '.$userinfo['lastname'].' 
        </td>
        <tr>
        <th>Prénom</th>
        <td>
        '.$userinfo['firstname'].'
        </td>
        </tr>
        <tr>
        <th>Date de Naissance</th>
        <td>
        '.$userinfo['birthdate'].'
        </td>
        </tr>
        <tr>
        <th>Email</th>
        <td>
        '.$userinfo['email'].'
        </td>
        </tr>
        <tr>
        <th>Date d'."'".'inscription</th>
        <td>
        '.$userinfo['register_date'].'
        </td>
        </tr>
        </table>';
    }
}
$pro = new profile();
$pro -> affprof();
?>