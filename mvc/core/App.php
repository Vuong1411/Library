<?php
//http://localhost/MyProject/home/default/params
class App
{
    protected $controller = "home";
    protected $action = "default";
    protected $params = [];

    function __construct()
    {
        $url = $this->UrlProcess();
        
        // Controller
        if ($url != null) {
            if (file_exists("./mvc/controllers/" . $url[0] . ".php")) {
                $this->controller = $url[0];
                unset($url[0]);
            }
        }
        require_once "./mvc/controllers/" . $this->controller . ".php";
        $this->controller = new $this->controller;

        // Action
        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->action = $url[1];
            }
            unset($url[1]);
        } else {
            $this->action = "default";
        }

        // Params
        $this->params = $url ? array_values($url) : [];

        call_user_func_array([$this->controller, $this->action], $this->params);
    }

    /**
     * Hàm tách chuỗi địa chỉ
     * @return mixed mảng chứa các địa chỉ tới các thư mục trong MVC
     */
    function UrlProcess()
    {
        if (isset($_GET["url"])) {
            return explode("/", filter_var(trim($_GET["url"], "/")));
        }
    }
}
