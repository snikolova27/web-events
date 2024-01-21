<?php

class FacultyMember
{
    // Database connectionection
    private $connection;
    private $table_name = "faculty_members";

    // Object properties
    public $fm_id;
    public $user_id;

    // Constructor with DB connectionection
    public function __construct($db)
    {
        $this->connection = $db;
    }

    // Method to create a new faculty member
    public function create()
    {
        // Insert query
        $query = "INSERT INTO " . $this->table_name . " SET user_id=:user_id";

        // Prepare query
        $statement = $this->connection->prepare($query);

        // Clean data
        $this->user_id = htmlspecialchars(strip_tags($this->user_id));

        // Bind data
        $statement->bindParam(":user_id", $this->user_id);

        // Execute query
        if ($statement->execute()) {
            return true;
        }

        return false;
    }

    // Method to getAllFacultyMembers faculty member data
    public function getAllFacultyMembers()
    {
        // Select query
        $query = "SELECT * FROM " . $this->table_name;

        // Prepare query statement
        $statement = $this->connection->prepare($query);

        // Execute query
        try {
            $statement->execute();
        } catch (PDOException $e) {
            echo "Error getting all faculty members : " . $e->getMessage();
            return null;
        }

        if ($statement->rowCount() > 0) {
            return $statement->fetch(PDO::FETCH_ASSOC);;
        } else {
            return null;
        }

    }

    // Method to update a faculty member
    public function update()
    {
        // Update query
        $query = "UPDATE " . $this->table_name . " SET user_id = :user_id WHERE fm_id = :fm_id";

        // Prepare query statement
        $statement = $this->connection->prepare($query);

        // Clean data and bind values
        $statement->bindParam(":user_id", htmlspecialchars(strip_tags($this->user_id)));
        $statement->bindParam(":fm_id", htmlspecialchars(strip_tags($this->fm_id)));

        // Execute query
        if ($statement->execute()) {
            return true;
        }

        return false;
    }


    // Method to delete a faculty member
    public function delete()
    {
        // Delete query
        $query = "DELETE FROM " . $this->table_name . " WHERE fm_id = :fm_id";

        // Prepare query
        $statement = $this->connection->prepare($query);

        // Clean data and bind value
        $statement->bindParam(":fm_id", htmlspecialchars(strip_tags($this->fm_id)));

        // Execute query
        if ($statement->execute()) {
            return true;
        }

        return false;
    }
}
