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
    // Modified Method to get all faculty members with names
    public function getAllFacultyMembers() 
    {
        // SQL query to join faculty_members with users and get the names
        $query = "SELECT faculty_members.fm_id, users.names, users.email FROM " . $this->table_name . "
                  JOIN users ON faculty_members.user_id = users.id";

        // Prepare query statement
        $statement = $this->connection->prepare($query);

        // Execute query
        try {
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error getting all faculty members: " . $e->getMessage();
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

    public function getFacultyMemberByUserId($userId) {
        $query = "SELECT * FROM faculty_members WHERE user_id = :user_id LIMIT 1";

        $statement = $this->connection->prepare($query);
        $statement->bindParam(":user_id", $userId);

        try {
            $statement->execute();
            return $statement->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error getting faculty member by user ID: " . $e->getMessage();
            return null;
        }
    }

    // Method to get subjects assigned to a faculty member
    public function getAssignedSubjects($facultyMemberId) {
        // SQL query to join the tables and get the subjects for this faculty member
        $query = "SELECT s.*, fmx.id AS fm_x_subject_id  FROM subjects s
                  JOIN fm_x_subject fmx ON s.id = fmx.subject_id
                  WHERE fmx.fm_id = :fm_id";

        // Prepare query statement
        $statement = $this->connection->prepare($query);
        $statement->bindParam(":fm_id", $facultyMemberId);

        // Execute query
        try {
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error getting assigned subjects: " . $e->getMessage();
            return null;
        }
    }
}
