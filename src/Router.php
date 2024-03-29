<?php 


    namespace App;

    use AltoRouter;
use App\security\ForbiddenException;

    class Router {


        /**
         * @var string
         */
        private $viewPath;

        /**
         * @var AltoRouter
         */
        private $router;



        public function __construct(string $viewPath){
            $this->viewPath = $viewPath;
            $this->router = new AltoRouter;
        }

        public function get(string $url, string $view, ?string $name = null):self
        {
            $this->router->map('GET', $url, $view, $name);
            return $this;
        }

        public function post(string $url, string $view, ?string $name = null):self
        {
            $this->router->map('POST', $url, $view, $name);
            return $this;
        }

        public function match(string $url, ?string $view, ?string $name = null):self
        {
            $this->router->map('POST|GET', $url, $view, $name);
            return $this;
        }

        public function url(string $name, array $params = [])
        {
            return $this->router->generate($name, $params);
        }

        public function run() : self
        {
            $match = $this->router->match();
            
            if($match != false){
                $view = $match['target'];
                $params = $match['params'];
            }else {
                $view = 'e404';
            }
            
            $router = $this;
            $isAdmin = strpos($view, 'admin/') !== false;
            $layout = $isAdmin ? 'admin/layout/default' : 'layout/default';
            
            try{
                ob_start();
                require $this->viewPath . DIRECTORY_SEPARATOR . $view . '.php';
                $content = ob_get_clean();
                require $this->viewPath . DIRECTORY_SEPARATOR . $layout .'.php';
            } catch(ForbiddenException $e){
                header('Location: ' . $router->url('connexion') . '?forbidden=1');
                exit();
            }
               
            return $this;
        }
        
    }
