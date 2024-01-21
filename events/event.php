<?php

class Event
{
    // Database connectionection
    private $connection;
    private $table_name = "events";

    // Object properties
    public $id;

    public $fm_x_subject_id;

    public $startDateTime;

    public $endDateTime;

    public $event_password;

    // Constructor with DB connectionection
    public function __construct($db)
    {
        $this->connection = $db;
    }

    // Method to create a new event
    public function create()
    {
        // Insert query
        $query = "INSERT INTO " . $this->table_name . " SET fm_x_subject_id= :fm_x_subject_id, startDateTime= :startDateTime, endDateTime= :endDateTime, event_password= :event_password ";

        // Prepare query
        $statement = $this->connection->prepare($query);

        // Clean data
        $this->fm_x_subject_id = htmlspecialchars(strip_tags($this->fm_x_subject_id));
        $this->startDateTime = htmlspecialchars(strip_tags($this->startDateTime));
        $this->endDateTime = htmlspecialchars(strip_tags($this->endDateTime));
        $this->event_password = htmlspecialchars(strip_tags($this->event_password));

        // Bind data
        $statement->bindParam(":fm_x_subject_id", $this->fm_x_subject_id);
        $statement->bindParam(":startDateTime", $this->startDateTime);
        $statement->bindParam(":endDateTime", $this->endDateTime);
        $statement->bindParam(":event_password", $this->event_password);

        // Execute query
        if ($statement->execute()) {
            return true;
        }

        return false;
    }

    // Method to get all events data
    public function getAllEvents()
    {
        // Select query
        $query = "SELECT * FROM " . $this->table_name;

        // Prepare query statement
        $statement = $this->connection->prepare($query);

        // Execute query
        try {
            $statement->execute();
        } catch (PDOException $e) {
            echo "Error getting all events : " . $e->getMessage();
            return null;
        }

        if ($statement->rowCount() > 0) {
            return $statement->fetch(PDO::FETCH_ASSOC);;
        } else {
            return null;
        }
    }

    // Method to update an event
    public function update()
    {
        // Update query
        $query = "UPDATE " . $this->table_name . " SET fm_x_subject_id = :fm_x_subject_id, startDateTime= :startDateTime, endDateTime= :endDateTime, event_password= :event_password  WHERE id = :id";

        // Prepare query statement
        $statement = $this->connection->prepare($query);

        // Bind data
        $statement->bindParam(":fm_x_subject_id", $this->fm_x_subject_id);
        $statement->bindParam(":startDateTime", $this->startDateTime);
        $statement->bindParam(":endDateTime", $this->endDateTime);
        $statement->bindParam(":event_password", $this->event_password);

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
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";

        // Prepare query
        $statement = $this->connection->prepare($query);

        // Clean data and bind value
        $statement->bindParam(":id", htmlspecialchars(strip_tags($this->id)));

        // Execute query
        if ($statement->execute()) {
            return true;
        }

        return false;
    }
}
