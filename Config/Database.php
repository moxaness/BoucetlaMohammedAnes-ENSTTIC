<?php
namespace Config;

USE PDO;
USE PDOException;

class Database {
    private $dsn = 'mysql:host=localhost;';
    private $user = 'root';
    private $password = '';
    public $con;

    public function __construct() {
        try {
            // Connect to MySQL server
            $this->con = new PDO($this->dsn, $this->user, $this->password);
            $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Check if the database exists
            if ($this->databaseExists('BOUCETLA')) {
                // Connect to the existing database
                $this->con->exec('USE BOUCETLA');
            } else {
                // Create the database, tables, and insert data
                $this->createDatabase();
                $this->con->exec('USE BOUCETLA');
                $this->createTables();
            }

        } catch (PDOException $e) {
            die('Database connection failed: ' . $e->getMessage());
        }
    }

    private function databaseExists($dbName) {
        try {
            $stmt = $this->con->query("SHOW DATABASES LIKE '$dbName'");
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            die('Error checking database existence: ' . $e->getMessage());
        }
    }

    private function createDatabase() {
        try {
            $this->con->exec('CREATE DATABASE IF NOT EXISTS BOUCETLA');
        } catch (PDOException $e) {
            die('Error creating database: ' . $e->getMessage());
        }
    }

    private function createTables() {
        $queries = [
            "CREATE TABLE IF NOT EXISTS utilisateurs(
                id INT PRIMARY KEY AUTO_INCREMENT,
                username VARCHAR(100) NOT NULL UNIQUE,
                password VARCHAR(100) NOT NULL,
                role VARCHAR(50) NOT NULL
            )",
            "CREATE TABLE IF NOT EXISTS client(
                id INT PRIMARY KEY AUTO_INCREMENT,
                nom VARCHAR(100) NOT NULL,
                email VARCHAR(100) NOT NULL UNIQUE,
                telephone VARCHAR(10) NOT NULL
            )",
            "CREATE TABLE IF NOT EXISTS produit(
                id INT PRIMARY KEY AUTO_INCREMENT,
                nom VARCHAR(50) NOT NULL,
                quantite INT NOT NULL,
                prix DECIMAL(10,2) NOT NULL
            )",
            "CREATE TABLE IF NOT EXISTS facture(
                id INT PRIMARY KEY AUTO_INCREMENT,
                id_client INT NOT NULL,
                prix DOUBLE NOT NULL,
                FOREIGN KEY (id_client) REFERENCES client(id) ON UPDATE CASCADE ON DELETE CASCADE
            )",
            "CREATE TABLE IF NOT EXISTS produitFacture(
                id INT PRIMARY KEY AUTO_INCREMENT,
                id_facture INT NOT NULL,
                id_produit INT NOT NULL,
                quantite INT NOT NULL,
                FOREIGN KEY (id_facture) REFERENCES facture(id) ON UPDATE CASCADE ON DELETE CASCADE,
                FOREIGN KEY (id_produit) REFERENCES produit(id) ON UPDATE CASCADE ON DELETE CASCADE
            )"
        ];

        try {
            foreach ($queries as $query) {
                $this->con->exec($query);
            }
            // Insert initial data
            $this->insertData();
        } catch (PDOException $e) {
            die('Error creating tables: ' . $e->getMessage());
        }
    }

    private function insertData() {
        try {
            $stmt = $this->con->query("SELECT COUNT(*) FROM utilisateurs");
            $rowCount = $stmt->fetchColumn();

            if ($rowCount == 0) {
                $this->con->exec("INSERT INTO utilisateurs(username, role, password) VALUES
                    ('admin', 'admin', 'password1'),
                    ('agentSup', 'agentSup', 'password2'),
                    ('agent', 'agent', 'password3')");

                $this->con->exec("INSERT INTO client(nom, email, telephone) VALUES 
                    ('Amine Benali', 'amine.benali@example.com', '0555123456'),
                    ('Yasmine Tebbani', 'yasmine.tebbani@example.com', '0556234567'),
                    ('Rachid Belkacem', 'rachid.belkacem@example.com', '0557345678'),
                    ('Sabrina Merbah', 'sabrina.merbah@example.com', '0558456789'),
                    ('Nassim Cherif', 'nassim.cherif@example.com', '0559567890'),
                    ('Leila Ouartani', 'leila.ouartani@example.com', '0560678901'),
                    ('Karim Boudiaf', 'karim.boudiaf@example.com', '0561789012'),
                    ('Imane Bouzid', 'imane.bouzid@example.com', '0562890123'),
                    ('Ahmed Kaid', 'ahmed.kaid@example.com', '0563901234'),
                    ('Khaled Hachemi', 'khaled.hachemi@example.com', '0565012345'),
                    ('Sofiane Ait Ali', 'sofiane.aitali@example.com', '0566123456'),
                    ('Amel Ouahabi', 'amel.ouahabi@example.com', '0567234567'),
                    ('Tariq Lahlou', 'tariq.lahlou@example.com', '0568345678'),
                    ('Djamila Saadi', 'djamila.saadi@example.com', '0569456789'),
                    ('Mohammed Chikhi', 'mohammed.chikhi@example.com', '0570567890')");

                $this->con->exec("INSERT INTO produit(nom, prix, quantite) VALUES
                    ('Laptop', 999.99, 50),
                    ('Smartphone', 699.99, 100),
                    ('Tablet', 399.99, 80),
                    ('Headphones', 49.99, 60),
                    ('Keyboard', 29.99, 25),
                    ('Mouse', 19.99, 40),
                    ('Monitor', 199.99, 30),
                    ('Printer', 89.99, 12),
                    ('Camera', 499.99, 50),
                    ('Desk Chair', 129.99, 10),
                    ('Office Desk', 259.99, 9),
                    ('Notebook', 2.99, 100),
                    ('Pen Set', 4.99, 100),
                    ('Backpack', 49.99, 70),
                    ('Water Bottle', 14.99, 200)");

                $this->con->exec("INSERT INTO facture(id_client, prix) VALUES
                    (3, 230000),
                    (7, 2000),
                    (5, 3000),
                    (2, 80000),
                    (9, 150),
                    (10, 80000),
                    (4, 5000),
                    (6, 12000),
                    (8, 13000),
                    (1, 7000)");

                $this->con->exec("INSERT INTO produitFacture(id_facture, id_produit, quantite) VALUES
                    (1, 5, 10),
                    (2, 3, 10),
                    (2, 9, 2),
                    (3, 8, 6),
                    (4, 3, 6),
                    (4, 11, 1),
                    (5, 12, 3),
                    (6, 1, 8),
                    (6, 14, 1),
                    (7, 9, 10),
                    (7, 3, 1),
                    (8, 15, 37),
                    (8, 6, 1),
                    (9, 3, 1),
                    (10, 10, 1),
                    (10, 11, 1),
                    (10, 13, 1)");
            }
        } catch (PDOException $e) {
            die('Error inserting data: ' . $e->getMessage());
        }
    }
}
?>
