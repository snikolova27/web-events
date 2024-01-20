<?php
class User
{
    // Database connection
    private $connection;
    private $table_name = "users";

    // Object properties
    public $id;
    public $names;
    public $email;
    public $is_admin;

    public $password;

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
        $query = "INSERT INTO " . $this->table_name . " SET names=:names, email=:email, is_admin=:is_admin, password=:password";

        // Prepare query
        $statement = $this->connection->prepare($query);

        // Clean data
        $this->names = htmlspecialchars(strip_tags($this->names));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password =  password_hash(htmlspecialchars(strip_tags($this->password)),  PASSWORD_BCRYPT);
        $this->is_admin = htmlspecialchars(strip_tags($this->is_admin));

        // Bind data
        $statement->bindParam(":names", $this->names);
        $statement->bindParam(":email", $this->email);
        $statement->bindParam(":is_admin", $this->is_admin);
        $statement->bindParam(":password", $this->password);


        // Execute query
        try {
            $statement->execute();
        } catch (PDOException $e) {
            echo "Error creating user: " . $e->getMessage();
            return false;
        }

        return true;
    }

    // Method to update a user
    public function update()
    {
        // Update query
        $query = "UPDATE " . $this->table_name . " 
                  SET names = :names, email = :email, is_admin = :is_admin, password=:password
                  WHERE id = :id";

        // Prepare query statement
        $statement = $this->connection->prepare($query);

        // Clean data
        $this->names = htmlspecialchars(strip_tags($this->names));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->is_admin = htmlspecialchars(strip_tags($this->is_admin));
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->password =  password_hash(htmlspecialchars(strip_tags($this->password)),  PASSWORD_BCRYPT);

        // Bind data
        $statement->bindParam(':names', $this->names);
        $statement->bindParam(':email', $this->email);
        $statement->bindParam(':is_admin', $this->is_admin);
        $statement->bindParam(':id', $this->id);
        $statement->bindParam(':password', $this->password);

        // Execute query
        try {
            $statement->execute();
        } catch (PDOException $e) {
            echo "Error updating user: " . $e->getMessage();
            return false;
        }

        return true;
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
        try {
            $statement->execute();
        } catch (PDOException $e) {
            echo "Error deleting user: " . $e->getMessage();
            return false;
        }

        return true;
    }

    // Method to get the last registered user
    public function getLastRegisteredUser()
    {
        // Select query
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY id DESC LIMIT 1";

        // Prepare query statement
        $statement = $this->connection->prepare($query);


        try {
            // Execute query
            $statement->execute();

            // Fetch the result
            $row = $statement->fetch(PDO::FETCH_ASSOC);

            // Return the user data
            return $row;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return null; 
        }
    }
}

// To use this class, you need to have a database connection. For example:
/*
$db = new PDO("mysql:host=your_host;dbname=your_db", "your_username", "your_password");
$user = new User($db);
*/