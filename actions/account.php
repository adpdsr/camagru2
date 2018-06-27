<?php

require_once "../config/database.php";

session_start();

if (isset($_POST)) {

    $mail = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    if (filter_var($mail, FILTER_VALIDATE_EMAIL) == false) {
        $_SESSION['msg_flash']['alert'] = "Unvalid email";
    }
    else if (!($login = filter_var($_POST['username'], FILTER_SANITIZE_STRING))) {
        $_SESSION['msg_flash']['alert'] = "Unvalid username";
    }
    else if (!empty($_POST['new_password'])) {
        if (!($password = filter_var($_POST['new_password'], FILTER_SANITIZE_STRING))) {
            $_SESSION['msg_flash']['alert'] = "Unvalid password";
        } else if (preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,15}$/', $password) === 0) {
            $_SESSION['msg_flash']['alert'] = "Le mot de passe doit contenir entre 8 et 16 caractères, au moins un nombre, une majuscule et une minuscule";
        }
    }

    if (isset($_SESSION['msg_flash']['alert'])) {
        header("Location: ../index.php?page=account");
    } else {

        try {

            $newpassword = hash('whirlpool', $_POST['new_password']);

            $db = new PDO($DB_DSN, $DB_USR, $DB_PWD);

            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            if (!empty($_POST['new_password'])) {
                $stmt = $db->prepare('UPDATE users SET login = :newlogin, mail = :newemail, notif = :notif, password = :newpassword WHERE login = :oldlogin ');

                $false = false;

                //$stmt->bindParam(':oldlogin', $_SESSION['login'], PDO::PARAM_STR);
                //$stmt->bindParam(':notif', $false, PDO::PARAM_BOOL;
                //$stmt->bindParam(':newlogin', $_POST['username'], PDO::PARAM_STR);
                //$stmt->bindParam(':newemail', $_SESSION['email'], PDO::PARAM_STR);
                //$stmt->bindParam(':newpassword', $newpassword, PDO::PARAM_STR);

                $stmt->execute([
                    ':oldlogin'    => $_SESSION['login'],
                    ':notif'       => ($_POST['comment_notification'] === 'yes') ? 1 : 0,
                    ':newlogin'    => $_POST['username'],
                    ':newemail'    => $_POST['email'],
                    ':newpassword' => $newpassword,
                ]);

            } else {
                $stmt = $db->prepare('UPDATE users SET login = :newlogin, mail = :newemail, notif = :notif WHERE login = :oldlogin ');

                $stmt->execute([
                    ':oldlogin'    => $_SESSION['login'],
                    ':notif'       => ($_POST['comment_notification'] === 'yes') ? 1 : 0,
                    ':newlogin'    => $_POST['username'],
                    ':newemail'    => $_POST['email'],
                ]);
            }

            $_SESSION['login'] = $_POST['username'];

            $db = null;
        }

        catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                $_SESSION['msg_flash']['alert'] = "Username or email already exists";

                header("Location: ../index.php?page=account");
            } else {
                print "error : " . $e->getMessage() . "<br/>";
            }
            die();
        }

        $_SESSION['msg_flash']['success'] = "Your account parameters have been modified !";

        header("Location: ../index.php?page=account");
    }
}
