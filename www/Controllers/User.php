<?php

namespace App\Controller;

use App\Core\View;
use App\Models\User as UserModel;
use App\Core\Mailer;
use App\Core\Helpers;

class User
{
    public function showUsersAction()
    {
        $view = new View('front.users');

        $user = new UserModel();
        $users = $user->selectAll();

        $view->assign('users', $users);
    }

    public function updateUserAction($id)
    {
        $view = new View('front.user');
        $User = new UserModel();
        $user = $User->selectById($id);

        $error = false;

        if ($user) {
            $view->assign('user', $user);
            $view->assign('form', $User->updateForm($user));
        } else
            $error = "Aucune information disponible";

        $view->assign('error', $error);
    }

    public function showRegisterAction()
    {
        session_start();
        $User = new UserModel();

        $error = false;

        if (!empty($_POST)) {

            $_POST = \App\Core\Helpers::prepareInputs($_POST);

            if (!($User->search('email', $_POST['email']))) {

                $User->setFirstname(ucfirst($_POST['firstname']));
                $User->setLastname(strtoupper($_POST['lastname']));
                $User->setEmail(strtolower($_POST['email']));
                $User->setPassword(password_hash($_POST['password'], PASSWORD_BCRYPT));
                $User->setStatus(0);
                $User->setVerificationCode();

                if ($User->save()) {
                    //Send mail
                    $mail = Mailer::init(
                        ["address" => "no-reply@community-cms.com", "name" => "Community CMS"],
                        [["address" => $User->getEmail(), "name" => $User->getFullName()]],
                        "Vérifiez votre adresse mail",
                        "<a href='" . HOST_ADDRESS . "/user/check/" . $User->getVerificationCode() . "'>Cliquez ici</a> pour vérifier votre adresse mail"
                    );

                    Mailer::sendEmail(
                        $mail,
                        function () {
                            Helpers::redirect('/');
                        },
                        function () use (&$userModel, &$id) {
                            $error = "L'envoi du mail a échoué. Le compte n'a pas été créé";
                            $userModel->deleteById($id);
                        }
                    );
                }
            } else {
                $error = 'Adresse mail déjà utilisée';
            }

            // \App\Core\Helpers::redirect('/');
        }

        $form = $User->registrerForm();

        $form['csrf'] = uniqid(uniqid());

        $_SESSION['csrf'] = $form['csrf'];

        $view = new View('front.register');

        $User = new UserModel();

        $view->assign('form', $User->registrerForm());
        $view->assign('error', $error);
    }

    public function showLoginAction()
    {
        $view = new View('front.login');

        $User = new UserModel();

        $view->assign('form', $User->loginForm());
    }

    public function checkUserAction($verificationCode)
    {
        $view = new View('front.check');

        $User = new UserModel();

        $user = $User->search("verificationCode", $verificationCode);

        $User->import($user);

        $error = false;

        if ($user) {
            if ($user['status'] == 1) {
                $error = "Le compte est déjà actif";
            } else {
                $User->setId($user['id']);
                $User->setStatus(1);
                $User->save();
            }
        } else {
            $error = "Aucun compte correspondant";
        }

        $view->assign('error', $error);
    }
}
