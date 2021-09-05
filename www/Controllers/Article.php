<?php

namespace App\Controller;

use App\Core\View;
use App\Core\Helpers;
use App\Models\Article as ArticleModel;
use App\Models\User as UserModel;

class Article
{
    public function showArticlesAction()
    {
        $view = new View('front.articles');

        $Article = new ArticleModel();

        $articles = $Article->selectAll();

        foreach ($articles as $index => $article) {
            $articles[$index]['content'] = Helpers::troncate($article['content'], 150);
        }

        $view->assign('articles', $articles);
    }

    public function showOneArticleAction($id)
    {
        $view = new View('front.article');

        $article = new ArticleModel();

        $articles = $article->selectById($id);


        if (!$articles)
            $view->assign('error', 'Article inexistant');
        else {
            $view->assign('author', $article->getAuthor($id));
            $view->assign('title', $articles['title']);
            $view->assign('thumbnail', $articles['thumbnail']);
            $view->assign('content', $articles['content']);
            $view->assign('updatedAt', $articles['updatedAt']);
        }
    }

    public function updateArticleAction($id)
    {
        echo 'Fiche utilisateur de ';
    }
}
