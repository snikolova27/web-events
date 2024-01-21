<?php
class Subject
{
    // Database connection
    private $connection;
    private $table_name = "subjects";

    // Object properties
    public $id;
    public $name;

    // Constructor with DB connection
    public function __construct($db)
    {
        $this->connection = $db;
    }

    // Method to create a new student
    public function create()
    {
        // Insert query
        $query = "INSERT INTO " . $this->table_name . " 
                  SET name=:name";

        // Prepare query
        $statement = $this->connection->prepare($query);

        // Clean data
        $this->name = htmlspecialchars(strip_tags($this->name));

        // Bind data
        $statement->bindParam(":name", $this->name);

        // Execute query
        try {
            $statement->execute();
        } catch (PDOException $e) {
            echo "Error creating subject: " . $e->getMessage();
            return false;
        }
        return true;
    }

    // Method to get all subjects 
    public function getAllSubjects()
    {
        // Select query
        $query = "SELECT * FROM " . $this->table_name;

        // Prepare query statement
        $statement = $this->connection->prepare($query);

        // Execute query
        try {
            $statement->execute();
            $rows = $statement->fetch(PDO::FETCH_ASSOC);
            return $rows;
        } catch (PDOException $e) {
            echo "Error getting all subjects : " . $e->getMessage();
            return null;
        }
    }

    // Method to update a subject
    public function update()
    {
        // Update query
        $query = "UPDATE " . $this->table_name . " 
                  SET name = :name
                  WHERE id = :id";

        // Prepare query statement
        $statement = $this->connection->prepare($query);

        // Clean data and bind values
        $statement->bindParam(":name", htmlspecialchars(strip_tags($this->name)));
        $statement->bindParam(":id", htmlspecialchars(strip_tags($this->id)));

        // Execute query
        try {
            $statement->execute();
        } catch (PDOException $e) {
            echo "Error updating subject: " . $e->getMessage();
            return false;
        }

        return true;
    }

    // Method to delete a student
    public function delete()
    {
        // Delete query
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";

        // Prepare query
        $statement = $this->connection->prepare($query);

        // Clean data and bind value
        $statement->bindParam(":id", htmlspecialchars(strip_tags($this->id)));

        // Execute query
        try {
            $statement->execute();
        } catch (PDOException $e) {
            echo "Error deleting subject: " . $e->getMessage();
            return false;
        }

        return true;
    }
}
