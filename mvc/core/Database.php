<?php
require_once './config.php';
class Database
{
    protected $dbHost = DB_HOST;
    protected $dbName = DB_NAME;
    protected $dbUser = DB_USER;
    protected $dbPass = DB_PASS;
    public $conn;

    protected $table = '';

    /**
     * Hàm khởi tạo kết nối
     */
    function __construct()
    {
        try {
            $this->conn = new PDO("mysql:host=$this->dbHost;dbname=$this->dbName", $this->dbUser, $this->dbPass);
            // set the PDO error mode to exception
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    /**
     * Hàm xử lý truy vấn
     * @param mixed $sql lệnh truy vấn
     * @param mixed $data dữ liệu cần xử lý
     * @throws \Exception 
     * @return mixed trả về kết quả nếu có
     */
    protected function query($sql, $data = [])
    {
        try {
            $stmt = $this->conn->prepare($sql);

            if (!$stmt) {
                throw new Exception("Error preparing query: " . $$this->conn->error);
            }
            if ($data) {
                $stmt->execute($data);
            } else {
                $stmt->execute();
            }
            return $stmt;
        } catch (PDOException $e) {
            // Mã lỗi 23000 là lỗi mắc khóa ngoại
            if ($e->getCode() == '23000') {
                return false;
            } else {
                echo "Error: " . $e->getMessage();
            }
        }
    }

    /**
     * Hàm đếm thủ công số hàng dữ liệu trong database
     * @param mixed $sql câu lệnh truy vấn
     * @param mixed $data để rỗng
     * @return mixed số hàng truy vấn
     */
    function countCustomRows($sql, $data = [])
    {
        return $this->query($sql, $data)->fetchColumn();
    }

    /**
     * Hàm lấy thủ công 1 hàng dữ liệu trong database
     * @param mixed $sql câu lệnh truy vấn
     * @param mixed $data để rỗng
     * @return mixed dữ liệu truy vấn
     */
    public function getCustomRow($sql, $data = [])
    {
        return $this->query($sql, $data)->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Hàm lấy thủ công nhiều hàng dữ liệu trong database
     * @param mixed $sql câu lệnh truy vấn
     * @param mixed $data để rỗng
     * @return mixed mảng dữ liệu truy vấn
     */
    public function getCustomRows($sql, $data = [])
    {
        return $this->query($sql, $data)->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Hàm đếm số hàng dữ liệu trong database
     * @param mixed $where điều kiện truy vấn
     * @return mixed số hàng truy vấn
     */
    function countRows($where = [])
    {
        $sql = "SELECT COUNT(*) FROM {$this->table}";

        if (!empty($where)) {
            $whereClauses = implode(' AND ', array_map(function ($key) {
                return "$key=:$key";
            }, array_keys($where)));
            $sql .= " WHERE $whereClauses";
        }

        return $this->query($sql, $where)->fetchColumn();
    }

    /**
     * Hàm lấy 1 hàng dữ liệu trong database
     * @param mixed $columns cột cần truy vấn
     * @param mixed $where điều kiện truy vấn
     * @param mixed $joins các bảng cần kết nối
     * @return mixed dữ liệu truy vấn
     */
    function getRow($columns = [], $where = [], $joins = [])
    {
        $columnClauses = empty($columns) ? '*' : implode(', ', $columns);
        $sql = "SELECT $columnClauses FROM {$this->table}";

        // Thêm các câu lệnh JOIN nếu có
        if (!empty($joins)) {
            foreach ($joins as $join) {
                $sql .= " {$join['type']} JOIN {$join['table']} ON {$join['condition']}";
            }
        }

        // Thêm các điều kiện WHERE nếu có giữa các điều kiện thêm 'AND'
        if (!empty($where)) {
            $whereClauses = implode(' AND ', array_map(function ($key) {
                return "$key=:$key";
            }, array_keys($where)));
            $sql .= " WHERE $whereClauses";
        }
        return $this->query($sql, $where)->fetch();
    }

    /**
     * Hàm lấy nhiều hàng dữ liệu trong database
     * @param mixed $columns cột cần lấy
     * @param mixed $where điều kiện truy vấn
     * @return array mảng dữ liệu truy vấn
     */
    public function getRows($columns = [], $where = [], $joins = [])
    {
        $columnClauses = empty($columns) ? '*' : implode(', ', $columns);
        $sql = "SELECT $columnClauses FROM {$this->table}";

        // Thêm các câu lệnh JOIN nếu có
        if (!empty($joins)) {
            foreach ($joins as $join) {
                $sql .= " {$join['type']} JOIN {$join['table']} ON {$join['condition']}";
            }
        }

        // Thêm các điều kiện WHERE nếu có giữa các điều kiện thêm 'AND'
        if (!empty($where)) {
            $whereClauses = implode(' AND ', array_map(function ($key) {
                return "$key=:$key";
            }, array_keys($where)));
            $sql .= " WHERE $whereClauses";
        }
        return $this->query($sql, $where)->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Hàm thêm dữ liệu vào database
     * @param mixed $data dữ liệu cần thêm
     * @return bool|PDOStatement TRUE nếu thành công
     */
    function insert($data)
    {
        $columnClauses = implode(',', array_keys($data));
        $valueClauses = implode(',', array_map(function ($key) {
            return ":$key";
        }, array_keys($data)));
        $sql = "INSERT INTO {$this->table} ($columnClauses) VALUES ($valueClauses)";
        return $this->query($sql, $data);
    }

    /**
     * Hàm cập nhật dữ liệu database
     * @param mixed $data dữ liệu cần chỉnh sửa
     * @param mixed $where điều kiện truy vấn
     * @return bool|PDOStatement TRUE nếu thành công
     */
    function update($data, $where)
    {
        $setClauses = implode(',', array_map(function ($key) {
            return "$key=:$key";
        }, array_keys($data)));
        $whereClauses = implode(' AND ', array_map(function ($key) {
            return "$key=:$key";
        }, array_keys($where)));
        $sql = "UPDATE {$this->table} SET $setClauses WHERE $whereClauses";
        return $this->query($sql, array_merge($data, $where));
    }

    /**
     * Hàm xóa dữ liệu database
     * @param mixed $where điều kiện truy vấn
     * @return bool|PDOStatement TRUE nếu thành công
     */
    function delete($where)
    {
        $whereClauses = implode(' AND ', array_map(function ($key) {
            return "$key=:$key";
        }, array_keys($where)));
        $sql = "DELETE FROM {$this->table} WHERE $whereClauses";
        return $this->query($sql, $where);
    }
}
