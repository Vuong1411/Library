<?php
require_once "./mvc/core/AuthCore.php";
class Controller
{
    public function __construct() {}

    /**
     * Hàm nối địa chỉ cho thư mục models
     * @param mixed $model chọn model muốn lấy dữ liệu
     * @return object một đối tượng mới được khởi tạo
     */
    public function model($model)
    {
        require_once "./mvc/models/" . $model . ".php";
        return new $model;
    }

    /**
     * Hàm nối địa chỉ cho thư mục views
     * @param mixed $view chọn trang muốn hiển thị
     * @param mixed $data truyền dữ liệu cho trang hiển thị nếu có
     * @return void
     */
    public function view($view, $data = [])
    {
        require_once "./mvc/views/" . $view . ".php";
    }
    /**
     * Hàm phản hồi kiểu khi sử dụng các hàm controllers
     * @param mixed $success xác nhận kiểu 1 và 0
     * @param mixed $message tin nhắn cần phản hồi
     * @return void kiểu json_encode
     */
    public function response($success, $message)
    {
        header('Content-type: application/json');
        echo json_encode(['success' => $success, 'message' => $message]);
    }
}
