<?php 
class InventoryModel{
    private static $db = null;

    // 🔌 Establish a centralized PDO connection
    private static function getDB() {
        if (self::$db === null) {
            // $host = 'localhost';
            // $dbname = 'inventory_system'; // Matches the name in phpMyAdmin
            // $username = 'root';       // XAMPP default
            // $password = '';           // XAMPP default is empty

            try {
                self::$db = new PDO(
                    "mysql:host=localhost;dbname=inventory_system;charset=utf8mb4", 
                    "root", 
                    "",
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::ATTR_EMULATE_PREPARES => false,
                    ]
                );
            } catch (PDOException $e) {
                // If connection fails, stop and show the error
                die("Database connection failed: " . $e->getMessage());
            }
        }
        return self::$db;
    }

    public static function getAllUnits(){
        $db = self::getDB();
        try {
            // 🚨 Make sure 'devices' matches your actual table name for inventory!
            $stmt = $db->query("SELECT * FROM laptop");
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return [];
        }
    }

    public static function getMetrics(){
        return [
        'computer' => ['percentage' => 98, 'available' => 1, 'broken' => 1, 'deprecated' => 4],
        'monitor'  => ['percentage' => 100, 'available' => 0, 'broken' => 0, 'deprecated' => 10]
        ];
    }



    // 🔐 Secure authentication against database records
    public static function authenticate($username, $password) {
        $db = self::getDB();

        // Use Prepared Statements to completely eliminate SQL Injection vulnerabilities
        $stmt = $db->prepare("SELECT * FROM users WHERE `User (user type)` = :username LIMIT 1");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch();

        if ($user) {
            if($password === $user['Password']) { // For demonstration; in production, use password_verify() with hashed passwords
                return true;
            }
        }

        return false;
    }
}
