<?php
class Welcome extends Controller
{

    public function __construct() {}

    /**
     * Hàm hiển thị trang mặc định
     * @return void trang cần hiển thị
     */
    function default()
    {
        $viewData = [
            "title" => "Trang Tổng Quan",
        ];
        $this->view("Landing", $viewData);
    }
}
