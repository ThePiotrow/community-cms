<?php

namespace App\Controller;

use App\Core\View;
use App\Core\Mailer;
use App\Core\Helpers;
use App\Core\FormValidator;
use App\Core\Auth;

use App\Models\User as UserModel;

class User
{
    public function showUsersAction()
    {
        if (!Auth::isAuth())
            Helpers::redirect('/login');

        $view = new View('user/list');

        $user = new UserModel();
        $users = $user->selectAll();

        $view->assign('users', $users);
    }

    public function updateUserAction($id)
    {
        if (!Auth::isAuth())
            Helpers::redirect('/login');

        $view = new View('user/profile');
        $User = new UserModel();
        $error = false;
        $user = $User->selectById($id);

        if (!empty($_POST)) {
            Helpers::convertToGoodData($_POST);
            extract($_POST);

            $status = isset($status) ? 1 : 0;

            $User->setId($user['id']);
            $User->setFirstname(ucfirst($firstname));
            $User->setLastname(strtoupper($lastname));
            $User->setEmail(strtolower($email));
            $User->setPassword($user['password'] != $password ? password_hash($password, PASSWORD_BCRYPT) : $password);
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
        $User = new UserModel();
        $errors = false;

        if (Auth::isAuth())
            Helpers::redirect('/users');

        if (!empty($_POST)) {

            Helpers::convertToGoodData($_POST);
            $errors = FormValidator::check($User->registrerForm(), $_POST);
            FormValidator::checkEmail($_POST['email'], $errors);

            if (!count($errors)) {
                if (!($User->search('email', $_POST['email']))) {

                    extract($_POST);

                    $User->setFirstname(ucfirst($firstname));
                    $User->setLastname(strtoupper($lastname));
                    $User->setEmail(strtolower($email));
                    $User->setPassword(password_hash($password, PASSWORD_BCRYPT));
                    $User->setStatus(0);
                    $User->setVerificationCode();

                    $User->save();
                    Mailer::mail(
                        ["address" => "no-reply@community-cms.com", "name" => "Community CMS"],
                        ["address" => $User->getEmail(), "name" => $User->getFullName()],
                        "Vérifiez votre adresse mail",
                        "<a href='http://" . HOST_ADDRESS . "/user/check/" . $User->getVerificationCode() . "'>Cliquez ici</a> pour vérifier votre adresse mail"
                    );
                    $errors[] = "Un mail à été envoyé à " . $User->getEmail() . " avec un lien d'activation";
                } else {
                    $errors[] = 'Adresse mail déjà utilisée';
                }
            }
        }

        $form = $User->registrerForm();
        $form['csrf'] = uniqid(uniqid());
        $_SESSION['csrf'] = $form['csrf'];
        $view = new View('user/register');
        $User = new UserModel();

        $view->assign('form', $User->registrerForm());
        $view->assign('errors', $errors);
    }

    public function showLoginAction()
    {
        $view = new View('user/login');
        $User = new UserModel();
        $error = false;

        if (Auth::isAuth())
            Helpers::redirect('/users');

        if (!empty($_POST)) {
            extract($_POST);
            $user = $User->search('email', $email);

            if ($user) {
                if (password_verify($password, $user['password'])) {
                    if ($user['status'] == 1) {
                        Auth::setAuth($user['id']);
                        Helpers::redirect('/users');
                    } else {
                        $error = "Veuillez activer le compte";
                    }
                } else {
                    $error = "Identifiants incorrects";
                }
            } else {
                $error = "Aucun compte correspondant";
            }
        }

        $view->assign('error', $error);
        $view->assign('form', $User->loginForm());
    }

    public function showForgotAction()
    {
        $view = new View('user/forgot');
        $User = new UserModel();
        $error = false;

        if (!empty($_POST)) {
            FormValidator::checkEmail($_POST['email'], $error);
            $user = $User->search('email', $_POST['email']);

            if ($user) {
                $User->setId($user['id']);
                $User->import($user);
                $User->setVerificationCode();

                $User->save();
                Mailer::mail(
                    ["address" => "no-reply@community-cms.com", "name" => "Community CMS"],
                    ["address" => $User->getEmail(), "name" => $User->getFullName()],
                    "Réinitialisation de mot de passe",
                    "<a href='http://" . HOST_ADDRESS . "/user/resetpassword/" . $User->getVerificationCode() . "'>Cliquez ici</a> pour réinitialiser le mot de passe"
                );
                $error = "Un mail à été envoyé à " . $User->getEmail() . " avec un lien de réinitialisation";
            } else {
                $error = "Aucun compte correspondant";
            }
        }

        $view->assign('form', $User->forgotForm());
        $view->assign('error', $error);
    }

    public function resetPasswordAction($verificationCode)
    {
        $view = new View('user/resetpassword');
        $User = new UserModel();
        $user = $User->search("verificationCode", $verificationCode);
        $errors = false;

        if ($user) {
            if ($user['status'] == 1) {
                if (!empty($_POST)) {
                    $errors = FormValidator::check($User->resetPasswordForm(), $_POST);

                    if (!count($errors)) {
                        $User->setId($user['id']);
                        $User->import($user);
                        $User->setPassword(password_hash($_POST['password'], PASSWORD_BCRYPT));
                        $User->setVerificationCode();
                        $User->save();

                        Helpers::redirect('/');
                    }
                }
            } else {
                Helpers::redirect('/user/check/' . $verificationCode);
            }
        } else {
            $errors[] = "Aucun compte correspondant";
        }

        $view->assign('form', $User->resetPasswordForm());
        $view->assign('errors', $errors);
    }

    public function deleteUserAction($id)
    {
        if (!Auth::isAuth())
            Helpers::redirect('/login');

        $view = new View('user/delete');
        $error = false;
        $User = new UserModel();
        $user = $User->selectById($id);

        if ($user) {
            $User->setId($user['id']);
            $User->import($user);

            if (!empty($_POST)) {
                if ($User->deleteById()) {
                    Helpers::redirect('/users');
                }
            }
        } else {
            $error = "Aucun compte correspondant";
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
        $error = false;

        if ($user) {
            $User->import($user);
            if ($user['status'] == 1) {
                $error = "Le compte est déjà actif";
            } else {
                $User->setId($user['id']);
                $User->setStatus(1);
                $User->setVerificationCode(1);
                $User->save();
            }
        } else {
            $error = "Aucun compte correspondant";
        }

        $view->assign('error', $error);
    }

    public function logoutAction()
    {
        Auth::endAuth();
    }
}
