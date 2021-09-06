<?php

namespace App\Controller;

use App\Core\View;
use App\Core\Helpers;
use App\Models\Page as PageModel;
use App\Models\User as UserModel;

class Page
{
    public function showPagesAction()
    {
        $view = new View('page/list');

        $Page = new PageModel();

        $pages = $Page->selectAll();

        foreach ($pages as $index => $page) {
            $pages[$index]['content'] = Helpers::troncate(strip_tags($page['content']), 20);
        }

        $view->assign('pages', $pages);
    }

    public function showOnePageAction($url)
    {
        $view = new View('page/page');

        $Page = new PageModel();

        $pages = $Page->search('url', $url);

        if (!$pages)
            $view->assign('error', 'Page inexistante');
        else {
            $view->assign('title', $pages['title']);
            $view->assign('content', $pages['content']);
        }
    }

    public function updatePageAction($id)
    {
        $view = new View('page/edit');
        $Page = new PageModel();
        $error = false;
        $page = $Page->selectById($id);

        var_dump($page);

        if (!empty($_POST)) {
            extract($_POST);

            $status = isset($status) ? 1 : 0;

            $User->setId($user['id']);
            $User->setFirstname($firstname);
            $User->setLastname($lastname);
            $User->setEmail($email);
            $User->setPassword($password);
            $User->setStatus($status);

            $User->save();

            Helpers::redirect('/users');
        }

        if ($page) {
            $view->assign('form', $Page->editPageForm($page));
        } else
            $error = "Aucune information disponible";

        $view->assign('error', $error);
    }

    public function createPageAction()
    {
        $view = new View('page/create');
        $Page = new PageModel();

        if (!empty($_POST)) {
            $_POST = \App\Core\Helpers::prepareInputs($_POST);
            \App\Core\FormValidator::check($Page->addPageForm(), $_POST);

            if (!($Page->search('url', $_POST['url']))) {

                $Page->setTitle(html_entity_decode($_POST['title']));
                $Page->setContent(html_entity_decode($_POST['content']));
                $Page->setUrl(strtolower($_POST['url']));
                $Page->setAuthor(1);

                if ($Page->save()) {
                    Helpers::redirect('/pages');
                }
            } else {
                $error = 'Cette URL est déjà utilisée';
            }
        }

        $view->assign('form', $Page->addPageForm());
        $view->assign('error', $error);
    }

    public function deletePageAction($id)
    {
    }
}
