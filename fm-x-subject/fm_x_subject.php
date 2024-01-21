<?php
class FmXSubject
{
    // Database connection
    private $connection;
    private $table_name = "fm_x_subject";

    // Object properties
    public $id;
    public $fm_id;
    public $subject_id;
    public $start_date;
    public $end_date;

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
                  SET fm_id=:fm_id, subject_id=:subject_id, start_date=:start_date, end_date=:end_date";

        // Prepare query
        $statement = $this->connection->prepare($query);

        // Clean data
        $this->fm_id = htmlspecialchars(strip_tags($this->fm_id));
        $this->subject_id = htmlspecialchars(strip_tags($this->subject_id));
        $this->start_date = htmlspecialchars(strip_tags($this->start_date));
        $this->end_date = htmlspecialchars(strip_tags($this->end_date));

        // Bind data
        $statement->bindParam(":fm_id", $this->fm_id);
        $statement->bindParam(":subject_id", $this->subject_id);
        $statement->bindParam(":start_date", $this->start_date);
        $statement->bindParam(":end_date", $this->end_date);

        // Execute query
        try {
            $statement->execute();
        } catch (PDOException $e) {
            echo "Error creating subject: " . $e->getMessage();
            return false;
        }
        return true;
    }

    // Method to update a subject
    public function update()
    {
        // Update query
        $query = "UPDATE " . $this->table_name . " 
                  SET fm_id = :fm_id, subject_id = :subject_id, start_date = :start_date, end_date = :end_date
                  WHERE id = :id";

        // Prepare query statement
        $statement = $this->connection->prepare($query);

        // Clean data and bind values
        $statement->bindParam(":id", htmlspecialchars(strip_tags($this->id)));
        $statement->bindParam(":fm_id", htmlspecialchars(strip_tags($this->fm_id)));
        $statement->bindParam(":subject_id", htmlspecialchars(strip_tags($this->subject_id)));
        $statement->bindParam(":start_date", htmlspecialchars(strip_tags($this->start_date)));
        $statement->bindParam(":end_date", htmlspecialchars(strip_tags($this->end_date)));

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
