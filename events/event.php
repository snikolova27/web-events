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
        $query = "INSERT INTO " . $this->table_name . " SET fm_x_subject_id= :fm_x_subject_id, start_date_time= :start_date_time, end_date_time= :end_date_time, event_password= :event_password, event_name =:event_name";

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

    // Method to get all events with subject names and faculty member names
    public function getAllEvents()
    {
        // SQL query to join the tables and get all required data
        $query = "SELECT e.*, s.name AS subject_name, u.names AS faculty_member_name FROM " . $this->table_name . " e
                  JOIN fm_x_subject fmx ON e.fm_x_subject_id = fmx.id
                  JOIN subjects s ON fmx.subject_id = s.id
                  JOIN faculty_members fm ON fmx.fm_id = fm.fm_id
                  JOIN users u ON fm.user_id = u.id";

        // Prepare query statement
        $statement = $this->connection->prepare($query);

        // Execute query
        try {
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error getting all events: " . $e->getMessage();
            return null;
        }
    }

    // Method to get event details with subject names and faculty member names
    public function getEventDetailsById($eventId)
    {
        // SQL query to join the tables and get all required data
        $query = "SELECT e.*, s.name AS subject_name, u.names AS faculty_member_name FROM " . $this->table_name . " e
                      JOIN fm_x_subject fmx ON e.fm_x_subject_id = fmx.id
                      JOIN subjects s ON fmx.subject_id = s.id
                      JOIN faculty_members fm ON fmx.fm_id = fm.fm_id
                      JOIN users u ON fm.user_id = u.id
                      WHERE e.id=:id";

        // Prepare query statement
        $statement = $this->connection->prepare($query);

        // Clean data and bind value
        $statement->bindParam(":id", $eventId);

        // Execute query
        try {
            $statement->execute();
            return $statement->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error getting details about event: " . $e->getMessage();
            return null;
        }
    }

    // Method to update an event
    public function update()
    {
        // Update query
        $query = "UPDATE " . $this->table_name . " SET fm_x_subject_id = :fm_x_subject_id, start_date_time= :start_date_time, end_date_time= :end_date_time, event_password= :event_password, event_name =:event_name WHERE id = :id";

        // Prepare query statement
        $statement = $this->connection->prepare($query);

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

    // Method to get event data by id
    public function getEventById($eventId)
    {
        // Select query
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";

        // Prepare query statement
        $statement = $this->connection->prepare($query);

        // Bind parameter
        $statement->bindParam(':id', $eventId);

        // Execute query
        try {
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
