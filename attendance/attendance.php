<?php

class Attendance
{
    // Database connectionection
    private $connection;
    private $table_name = "attendances";

    // Object properties
    public $fn;
    public $event_id;

    // Constructor with DB connectionection
    public function __construct($db)
    {
        $this->connection = $db;
    }

    // Method to create a new attendance entry
    public function create()
    {
        // Insert query
        $query = "INSERT INTO " . $this->table_name . " SET fn=:fn, event_id=:event_id";

        // Prepare query
        $statement = $this->connection->prepare($query);

        // Clean data
        $this->fn = htmlspecialchars(strip_tags($this->fn));
        $this->event_id = htmlspecialchars(strip_tags($this->event_id));

        // Bind data
        $statement->bindParam(":fn", $this->fn);
        $statement->bindParam(":event_id", $this->event_id);

        // Execute query
        if ($statement->execute()) {
            return true;
        }

        return false;
    }

    // Method to getAllAttendance data
    public function getAllAttendancesWithEventInfo()
    {
        // SQL query to join attendance with event and get the names of the events
        $query = "SELECT * FROM attendances 
        JOIN events on events.id = attendances.event_id
        JOIN fm_x_subject on events.fm_x_subject_id = fm_x_subject.id
        JOIN subjects on subjects.id = fm_x_subject.subject_id";

        // Prepare query statement
        $statement = $this->connection->prepare($query);

        // Execute query
        try {
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error getting all attendances data: " . $e->getMessage();
            return null;
        }
    }

    // Method to update an attendance entry
    public function update()
    {
        // Update query
        $query = "UPDATE " . $this->table_name . " SET fn = :fn, event_id=:event_id WHERE fn = :fn and event_id=:event_id";

        // Prepare query statement
        $statement = $this->connection->prepare($query);

        // Clean data and bind values
        $statement->bindParam(":fn", htmlspecialchars(strip_tags($this->fn)));
        $statement->bindParam(":event_id", htmlspecialchars(strip_tags($this->event_id)));

        // Execute query
        if ($statement->execute()) {
            return true;
        }

        return false;
    }


    // Method to delete a an attendance entry
    public function delete()
    {
        // Delete query
        $query = "DELETE FROM " . $this->table_name . " WHERE fn = :fn and event_id =:event_id";

        // Prepare query
        $statement = $this->connection->prepare($query);

        // Clean data and bind value
        $statement->bindParam(":fn", htmlspecialchars(strip_tags($this->fn)));
        $statement->bindParam(":event_id", htmlspecialchars(strip_tags($this->event_id)));


        // Execute query
        if ($statement->execute()) {
            return true;
        }

        return false;
    }

    public function getAttendancesByFn($facultyNumber)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE fn = :fn";

        $statement = $this->connection->prepare($query);
        $statement->bindParam(":fn", $facultyNumber);

        try {
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error getting attendace entries for faculty number : " . $e->getMessage();
            return null;
        }
    }

    public function getAttencersByFnAndEventId($eventId, $facultyNumber)
    {
        $query = "SELECT * FROM " . $this->table_name .  " WHERE fn = :fn and event_id= :event_id";

        $statement = $this->connection->prepare($query);
        $statement->bindParam(":fn", $facultyNumber);
        $statement->bindParam(":event_id", $eventId);

        try {
            $statement->execute();
            return $statement->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error getting attendace entries for faculty number and event : " . $e->getMessage();
            return null;
        }
    }
}
