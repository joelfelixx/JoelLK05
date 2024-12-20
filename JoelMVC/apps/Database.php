<?php
/**
 * Kelas DB untuk koneksi dan operasi database dengan PDO.
 */

class DB {
    /**
     * Objek PDO
     * @var PDO
     */
    private $conn = NULL;

    /**
     * Pesan error terakhir
     * @var string
     */
    private $error = '';

    /**
     * Koneksi ke server SQL
     *
     * @param string $driver
     * @param string $host
     * @param string $username
     * @param string $password
     * @param string $database
     * @param integer $port
     * @param array $options
     * @return boolean
     */
    public function connect($driver, $host, $username, $password, $database, $port = 0, $options = []) {
        if (!extension_loaded("pdo")) {
            die("Missing <a href=\"http://www.php.net/manual/en/book.pdo.php\">PDO</a> PHP extension.");
        }

        $driver = strtolower($driver);
        try {
            if ($driver == "mysql") {
                if (!extension_loaded("pdo_mysql")) {
                    die("Missing <a href=\"http://php.net/manual/en/ref.pdo-mysql.php\">pdo_mysql</a> PHP extension.");
                }
                $port = $port ?: 3306;
                $this->conn = new PDO("mysql:host=$host;port=$port;dbname=$database", $username, $password, $options);
            } elseif ($driver == "pgsql") {
                if (!extension_loaded("pdo_pgsql")) {
                    die("Missing <a href=\"http://php.net/manual/en/ref.pdo-pgsql.php\">pdo_pgsql</a> PHP extension.");
                }
                $port = $port ?: 5432;
                $this->conn = new PDO("pgsql:host=$host;port=$port;dbname=$database", $username, $password, $options);
            } elseif ($driver == "sqlite") {
                if (!extension_loaded("pdo_sqlite")) {
                    die("Missing <a href=\"http://php.net/manual/en/ref.pdo-sqlite.php\">pdo_sqlite</a> PHP extension.");
                }
                if (!file_exists($database)) {
                    @touch($database);
                }
                if (is_readable($database) && is_writable($database)) {
                    $this->conn = new PDO("sqlite:$database", $username, $password, $options);
                } else {
                    $this->error = "Cannot create/connect to the SQLite database";
                    return false;
                }
            } else {
                $this->error = "Database type not supported.";
                return false;
            }
            return true;
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            return false;
        }
    }

    /**
     * Menutup koneksi database
     */
    public function close() {
        $this->conn = NULL;
    }

    /**
     * Mengirimkan query ke server SQL
     *
     * @param string $res
     * @param array $bind
     * @return mixed
     */
    public function query($res, $bind = []) {
        try {
            $query = $this->conn->prepare($res);
            if ($query) {
                $query->execute($bind);
                return $query;
            } else {
                $this->error = "Failed to prepare the query.";
                return false;
            }
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            return false;
        }
    }

    /**
     * Mengambil satu baris dari hasil query
     *
     * @param PDOStatement $res
     * @return array|false
     */
    public function fetch_array($res) {
        try {
            return $res->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            return false;
        }
    }

    /**
     * Mendapatkan ID dari data terakhir yang disisipkan
     *
     * @return integer|string
     */
    public function last_id() {
        return $this->conn->lastInsertId();
    }

    /**
     * Mendapatkan pesan error terakhir
     *
     * @return string
     */
    public function error() {
        return $this->error;
    }

    /**
     * Memanggil metode PDO secara dinamis
     *
     * @param string $name
     * @param array $arguments
     * @return mixed
     * @throws Exception
     */
    public function __call($name, $arguments) {
        if (!method_exists($this->conn, $name)) {
            throw new Exception("Unknown method '$name'");
        }
        return call_user_func_array([$this->conn, $name], $arguments);
    }
}
?>