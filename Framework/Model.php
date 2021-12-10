<?php 

    namespace Framework;

    require_once(__DIR__.'/../config/config.php');

    use App\Config;
    use \PDO;

    class Model{

        private $db;

        public function __construct(){

            $dsn = 'mysql:host=' . Config::DB_HOST . ';dbname=' . Config::DB_NAME . ';charset=utf8';
            $db = new PDO($dsn, Config::DB_USER, Config::DB_PASSWORD);
    
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
            $this->db = $db;

        }

        public function getDb(){

            return $this->db;

        }

    }

?>