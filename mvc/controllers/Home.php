<?php
class Home extends Controller
{

    var $layout = 'Master-Layout';

    public $userModel;

    public function __construct()
    {
        //$this->userModel = $this->model("UserModel");
    }
    /**
     * Hàm hiển thị trang mặc định
     * @return void trang cần hiển thị
     */
    public function default()
    {
        //if (AuthCore::user()) {
            $viewData = [
                "page" => "dashboard",
                "title" => "Trang Thống Kê",
            ];
            $this->view($this->layout, $viewData);
        //}
    }


}
