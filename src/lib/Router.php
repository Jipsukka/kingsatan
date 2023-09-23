<?php
declare(strict_types=1);

class Router
{
    public function start()
    {
        if (!empty($_POST)) {
            $this->routePost();
            return;
        }

        $this->render($this->getRoute());
    }

    private function getRoute()
    {
        $uri = $_SERVER['REQUEST_URI'];
        $uriParts = explode('/', $uri);
        $url = $uriParts[2];
        $path = parse_url($url)['path'];

        switch ($path) {
            case 'create':
                $view = 'create.php';
                break;
            case 'read':
                $view = 'read.php';
                break;
            case 'test':
                $view = 'test.php';
                break;
            default:
                $view = 'index.php';
                break;
        }

        return $view;
    }

    private function routePost()
    {
        $uri = $_SERVER['REQUEST_URI'];
        $uriParts = explode('/', $uri);
        $url = $uriParts[2];
        $path = parse_url($url)['path'];

        switch ($path) {
            case 'check':
                $this->renderAjax();
                break;
            case 'save':
                $this->render('save.php');
                break;
            default:
                die('404');
                break;
        }
    }

    private function render($view)
    {
        $viwFile = '../src/views/' .  $view;

        if (!file_exists($viwFile)) {
            die("View $view not found");
        }

        include '../src/views/header.phtml';
        include $viwFile;
        include '../src/views/footer.phtml';
    }

    private function renderAjax()
    {
        $viwFile = '../src/views/check.php';
        include $viwFile;
    }
}