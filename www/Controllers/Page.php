<?php

namespace App\Controller;

use App\Core\View;
use App\Core\Helpers;
use App\Core\Auth;
use App\Core\FormValidator;

use App\Models\Page as PageModel;

class Page
{
    public function showPagesAction()
    {
        if (!Auth::isAuth())
            Helpers::redirect('/login');

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
        $error = false;
        $Page = new PageModel();
        $pages = $Page->search('url', $url);

        if (!$pages)
            $error = 'Page inexistante';
        else {
            $view->assign('title', $pages['title']);
            $view->assign('content', $pages['content']);
        }
        $view->assign('error', $error);
    }

    public function updatePageAction($id)
    {
        if (!Auth::isAuth())
            Helpers::redirect('/login');

        $view = new View('page/edit');
        $Page = new PageModel();
        $error = false;
        $page = $Page->selectById($id);

        if (!empty($_POST)) {

            $inputsError = FormValidator::check($Page->addPageForm(), $_POST);
            Helpers::convertToGoodData($_POST, Helpers::allowedTags());

            if (!count($inputsError)) {

                if (!($Page->search('url', $_POST['url']) && $page['url'] != $_POST['url'])) {
                    extract($_POST);

                    $Page->setId($page['id']);
                    $Page->import($_POST);

                    if ($Page->save()) {
                        Helpers::redirect('/pages');
                    } else {
                        $error = "Une erreur est survenue lors de l'enregistrement";
                    }
                } else {
                    $error = 'Cette URL est déjà utilisée';
                }
            }
        }

        if ($page) {
            $view->assign('form', $Page->editPageForm($page));
            $view->assign('allowedTags', "Tags HTML autorisé : " . implode(', ', Helpers::allowedTags()));
        } else
            $error = "Aucune information disponible";

        $view->assign('error', $error);
    }

    public function createPageAction()
    {
        if (!Auth::isAuth())
            Helpers::redirect('/login');

        $view = new View('page/create');
        $Page = new PageModel();
        $error = false;

        if (!empty($_POST)) {

            $inputsError = FormValidator::check($Page->addPageForm(), $_POST);
            Helpers::convertToGoodData($_POST, Helpers::allowedTags());
            $url = Helpers::convertForSlug($_POST['url']);

            echo $url;
            die();

            if (!count($inputsError))

                if (!($Page->search('url', $_POST['url']))) {

                    $Page->import($_POST);

                    if ($Page->save()) {
                        Helpers::redirect('/pages');
                    } else {
                        $error = "Une erreur est survenue lors de l'enregistrement";
                    }
                } else {
                    $error = 'Cette URL est déjà utilisée';
                }
        }

        $view->assign('form', $Page->addPageForm());
        $view->assign('allowedTags', "Tags HTML autorisé : " . implode(', ', Helpers::allowedTags()));
        $view->assign('error', $error);
    }

    public function deletePageAction($id)
    {
        if (!Auth::isAuth())
            Helpers::redirect('/login');

        $view = new View('page/delete');
        $error = false;
        $Page = new PageModel();
        $page = $Page->selectById($id);
        $Page->setId($page['id']);
        $Page->import($page);

        if (!empty($_POST)) {
            if ($Page->deleteById()) {
                Helpers::redirect('/pages');
            }
        }

        $view->assign('error', $error);
        $view->assign('form', $Page->deletePageForm($id));
        $view->assign('title', $Page->getTitle());
        $view->assign('url', $Page->getUrl());
    }
}
