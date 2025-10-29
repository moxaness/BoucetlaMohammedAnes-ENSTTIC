<?php
namespace application\Vues;

class AuthView{
    public $errorMessage;
    public function __construct($msg) {
        $this->errorMessage=$msg;
    }
    public function loginForm(){
        return "
        <!DOCTYPE html>
        <html lang='fr'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>LOGIN</title>
            <link rel='stylesheet' href='/boucetlaMohammedAnes/application/Css/Auth.css'>
        </head>
        <body>
             
            <h2>$this->errorMessage</h2><br>
            <form action='' method='get'>
                <label>username: <input type='text' name='username'></label><br>
                <label>mot de passe: <input type='password' name='password'></label><br>
                <input type='submit' name='connecter' value='connecter'>
            </form>
        </body>
        </html>";
    }
}
?>