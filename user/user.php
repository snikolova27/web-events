<?php
class User
{
    // Database connection
    private $connection;
    private $table_name = "users";

    // Object properties
    public $id;
    public $name;
    public $email;
    public $is_admin;

    // Constructor with DB connection
    public function __construct($db)
    {
        $this->connection = $db;
    }

    // Method to read all users
    public function getAllUsers()
    {
        // Select all query
        $query = "SELECT * FROM " . $this->table_name;

        // Prepare query statement
        $statement = $this->connection->prepare($query);

        // Execute query
        $statement->execute();

        return $statement;
    }

    // Method to create a new user
    public function create()
    {
        // Insert query
        $query = "INSERT INTO " . $this->table_name . " SET name=:name, email=:email, is_admin=:is_admin";

        // Prepare query
        $statement = $this->connection->prepare($query);

        // Clean data
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->is_admin = htmlspecialchars(strip_tags($this->is_admin));

        // Bind data
        $statement->bindParam(":name", $this->name);
        $statement->bindParam(":email", $this->email);
        $statement->bindParam(":is_admin", $this->is_admin);

        // Execute query
        if ($statement->execute()) {
            return true;
        }

        return false;
    }

    // Method to update a user
    public function update()
    {
        // Update query
        $query = "UPDATE " . $this->table_name . " 
                  SET name = :name, email = :email, is_admin = :is_admin
                  WHERE id = :id";

        // Prepare query statement
        $statement = $this->connection->prepare($query);

        // Clean data
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->is_admin = htmlspecialchars(strip_tags($this->is_admin));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Bind data
        $statement->bindParam(':name', $this->name);
        $statement->bindParam(':email', $this->email);
        $statement->bindParam(':is_admin', $this->is_admin);
        $statement->bindParam(':id', $this->id);

        // Execute query
        if ($statement->execute()) {
            return true;
        }

        return false;
    }

    // Method to delete a user
    public function delete()
    {
        // Delete query
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";

        // Prepare query
        $statement = $this->connection->prepare($query);

        // Clean data
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Bind data
        $statement->bindParam(':id', $this->id);

        // Execute query
        if ($statement->execute()) {
            return true;
        }

        return false;
    }
}

// To use this class, you need to have a database connection. For example:
/*
$db = new PDO("mysql:host=your_host;dbname=your_db", "your_username", "your_password");
$user = new User($db);
*/