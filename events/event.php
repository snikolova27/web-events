<?php

class Event
{
    // Database connectionection
    private $connection;
    private $table_name = "events";

    // Object properties
    public $id;

    public $fm_x_subject_id;

    public $start_date_time;

    public $end_date_time;

    public $event_password;

    public $event_name;

    // Constructor with DB connectionection
    public function __construct($db)
    {
        $this->connection = $db;
    }

    // Method to create a new event
    public function create()
    {
        // Insert query
        $query = "INSERT INTO " . $this->table_name . " SET fm_x_subject_id= :fm_x_subject_id, start_date_time= :start_date_time, end_date_time= :end_date_time, event_password= :event_password, event_name= :event_name";

        // Prepare query
        $statement = $this->connection->prepare($query);

        // Clean data
        $this->fm_x_subject_id = htmlspecialchars(strip_tags($this->fm_x_subject_id));
        $this->start_date_time = htmlspecialchars(strip_tags($this->start_date_time));
        $this->end_date_time = htmlspecialchars(strip_tags($this->end_date_time));
        $this->event_password = htmlspecialchars(strip_tags($this->event_password));
        $this->event_name = htmlspecialchars(strip_tags($this->event_name));

        // Bind data
        $statement->bindParam(":fm_x_subject_id", $this->fm_x_subject_id);
        $statement->bindParam(":start_date_time", $this->start_date_time);
        $statement->bindParam(":end_date_time", $this->end_date_time);
        $statement->bindParam(":event_password", $this->event_password);
        $statement->bindParam(":event_name", $this->event_name);

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
        $query = "UPDATE " . $this->table_name . " SET fm_x_subject_id = :fm_x_subject_id, start_date_time= :start_date_time, end_date_time= :end_date_time, event_password= :event_password, event_name= :event_name  WHERE id = :id";

        // Prepare query statement
        $statement = $this->connection->prepare($query);

        // Bind data
        $statement->bindParam(":fm_x_subject_id", $this->fm_x_subject_id);
        $statement->bindParam(":start_date_time", $this->start_date_time);
        $statement->bindParam(":end_date_time", $this->end_date_time);
        $statement->bindParam(":event_password", $this->event_password);
        $statement->bindParam(":event_name", $this->event_password);

        // Execute query
        if ($statement->execute()) {
            return true;
        }

        return false;
    }


    // Method to delete an event
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
