<?php

require('config/database.php');
require_once('includes/functions/db_connexion.php');

///////////////////////////
// Display flash message //
///////////////////////////

session_start();

if (isset($_SESSION['msg_flash']))
{
    foreach ($_SESSION['msg_flash'] as $type => $msg)
    {
        echo '<div id="msg-flash" class="msg-flash ';
        echo $type;
        echo '" onclick="document.getElementById(\'msg-flash\').style.display=\'none\';">';
        echo $msg;
        echo '</div>';
    }
    unset($_SESSION['msg_flash']);
}

/////////////////////////
// Fetch users's datas //
/////////////////////////

try {

    $bdd = new PDO($DB_DSN, $DB_USR, $DB_PWD);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $req = $bdd->prepare('SELECT * FROM `users` WHERE login = :username');
    $req->bindParam(':username', $_SESSION['login'], PDO::PARAM_STR, 255);
    $req->execute();

    $data = $req->fetch(PDO::FETCH_ASSOC);
    $bdd = null;

} catch (Exception $e) {
    echo '<p>', $e->getMessage(), '</p>';
}

?>

<html>

    <head>
        <link rel='stylesheet' href='css/camagru.css'>
    </head>

    <body>
        <div class="container" style='margin-top:100px'>
            <div style="width: 400px;">
                <h2 style="margin-bottom: 50px">Mes paramètres</h2>
                <form method="post" action="actions/account.php">
                    <label style="color: #292c2f"><b>Username</b></label>
                    <input type="text" placeholder="Enter new username" name="username" maxlength="16" value="<?= $data['login'] ?>" required>
                    <hr>
                    <label style="color: #292c2f"><b>Email</b></label>
                    <input type="text" placeholder="Enter new email" name="email" value="<?= $data['mail'] ?>" required>
                    <hr>
                    <label style="color: #292c2f"><b>Reset password</b></label>
                    <input type="password" placeholder="Enter new password" name="new_password" maxlength="16">
                    <hr>
                    <label for="comment_notification" style="color: #292c2f"><b>Email notifications</b></label><br>
                    <select name="comment_notification" style="margin-top: 8px">
                        <option value="yes" <?php if ($data['notif'] === '1') { echo 'selected'; } ?>>YES</option>
                        <option value="no"  <?php if ($data['notif'] === '0') { echo 'selected'; } ?>>NO</option>
                    </select>
                    <hr>
                    <button type="submit">Reset</button>
                </form>
            </div>
        </div>
    </body>

</html>
