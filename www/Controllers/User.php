<?php

namespace App\Controller;

use App\Core\View;
use App\Models\User as UserModel;
use App\Core\Mailer;
use App\Core\Helpers;
use App\Core\FormValidator;

class User
{
    public function showUsersAction()
    {
        $view = new View('user/list');

        $user = new UserModel();
        $users = $user->selectAll();

        $view->assign('users', $users);
    }

    public function updateUserAction($id)
    {
        $view = new View('user/profile');
        $User = new UserModel();
        $error = false;
        $user = $User->selectById($id);

        if (!empty($_POST)) {
            extract($_POST);

            $status = isset($status) ? 1 : 0;

            $User->setId($user['id']);
            $User->setFirstname($firstname);
            $User->setLastname($lastname);
            $User->setEmail($email);
            $User->setPassword(password_hash($password, PASSWORD_BCRYPT));
            $User->setStatus($status);

            $User->save();

            Helpers::redirect('/users');
        }

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

            Helpers::convertToGoodData($_POST);
            $inputsError = FormValidator::check($User->registrerForm(), $_POST);

            if ($inputsError)
                if (!($User->search('email', $_POST['email']))) {

                    extract($_POST);

                    $User->setFirstname(ucfirst($firstname));
                    $User->setLastname(strtoupper($lastname));
                    $User->setEmail(strtolower($email));
                    $User->setPassword(password_hash($password, PASSWORD_BCRYPT));
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
                            function () use (&$User, &$id) {
                                $error = "L'envoi du mail a échoué. Le compte n'a pas été créé";
                                $User->deleteById($id);
                            }
                        );
                    }
                } else {
                    $error = 'Adresse mail déjà utilisée';
                }
        }

        $form = $User->registrerForm();
        $form['csrf'] = uniqid(uniqid());
        $_SESSION['csrf'] = $form['csrf'];
        $view = new View('user/register');
        $User = new UserModel();

        $view->assign('form', $User->registrerForm());
        $view->assign('error', $error);
    }

    public function showLoginAction()
    {
        $view = new View('user/login');
        $User = new UserModel();
        $view->assign('form', $User->loginForm());
    }

    public function showForgotAction()
    {
        $view = new View('user/forgot');
        $User = new UserModel();
        $view->assign('form', $User->forgotForm());
    }

    public function deleteUserAction($id)
    {
        $view = new View('user/delete');
        $error = false;
        $User = new UserModel();
        $user = $User->selectById($id);
        $User->setId($user['id']);
        $User->import($user);

        if (!empty($_POST)) {
            if ($User->deleteById()) {
                Helpers::redirect('/users');
            }
        }

        $view->assign('error', $error);
        $view->assign('form', $User->deleteForm($id));
        $view->assign('fullname', $User->getFullName());
    }

    public function checkUserAction($verificationCode)
    {
        $view = new View('user/check');
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
