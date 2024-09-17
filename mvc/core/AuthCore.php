<?php
class AuthCore
{
    /**
     * Hàm lưu kết nối khi đăng nhập
     * @return void
     */
    public static function onLogin()
    {
        if (isset($_COOKIE['remember'])) {
            $dataSession = json_decode($_COOKIE['remember']);
            $_SESSION['user'] = $dataSession;
            header('Location:' . APP_PATH . 'Home');
        }
    }

    /**
     * Xác thực quyền quản lý admin
     * @return bool TRUE nếu đúng, FALSE trả về trang lỗi 503
     */
    public static function owner()
    {
        if ($_SESSION['user'] && $_SESSION['user']['role'] == 'owner') {
            return true;
        } else {
            header('Location:' . APP_PATH .  'MyError/page503');
            return false;
        }
    }

    /**
     * Xác thực quyền admin
     * @return bool TRUE nếu đúng, FALSE trả về trang lỗi 503
     */
    public static function admin()
    {
        if ($_SESSION['user'] && $_SESSION['user']['role'] == 'admin') {
            return true;
        } else {
            header('Location:' . APP_PATH .  'MyError');
            return false;
        }
    }

    /**
     * Xác thực người dùng tồn tại
     * @return bool TRUE nếu đúng, FALSE trả về trang Welcome
     */
    public static function user()
    {
        if ($_SESSION['user']) {
            return true;
        } else {
            header("Location: " . WELCOME_PATH);
            return false;
        }
    }
}
