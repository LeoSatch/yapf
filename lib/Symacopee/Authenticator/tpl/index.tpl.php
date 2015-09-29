<?php
$sPage = <<<EOD
<h2>Formulaire d'identification</h2>
    <form id='authenForm' action='/authenticator/valid/' method='post'>
        <table>
            <tr>
                <td>Login :</td>
                <td><input type='text' id='login' name='login' /></td>
            </tr>
            <tr>
                <td>Pass :</td>
                <td><input type='text' id='password' name='password' value='' /></td>
            </tr>
            <tr>
                <td><input type='submit' value='Annuler' /></td>
                <td><input type='submit' value='Valider' /></td>
            </tr>
        </table>
    </form>
EOD;

