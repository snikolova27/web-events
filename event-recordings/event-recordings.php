<?php

class EventRecording
{
    // Database connectionection
    private $connection;
    private $table_name = "event_recordings";

    // Object properties
    public $id;

    public $event_id;

    public $link;

    public $is_approved;

    // Constructor with DB connectionection
    public function __construct($db)
    {
        $this->connection = $db;
    }

    // Method to create a new event
    public function create()
    {
        // Insert query
        $query = "INSERT INTO " . $this->table_name . " SET event_id= :event_id, link= :link, is_approved= :is_approved";

        // Prepare query
        $statement = $this->connection->prepare($query);

        // Clean data
        $this->event_id = htmlspecialchars(strip_tags($this->event_id));
        $this->link = htmlspecialchars(strip_tags($this->link));
        $this->is_approved = htmlspecialchars(strip_tags($this->is_approved));

        // Bind data
        $statement->bindParam(":event_id", $this->event_id);
        $statement->bindParam(":link", $this->link);
        $statement->bindParam(":is_approved", $this->is_approved);

        // Execute query
        if ($statement->execute()) {
            return true;
        }

        return false;
    }

    // Method to get all links for event
    public function getAllLinksForEvent($eventId)
    {
        // Select query
        $query = "SELECT * FROM " . $this->table_name . "WHERE event_id=: event_id";


        // Prepare query statement
        $statement = $this->connection->prepare($query);

        // Bind parameter
        $statement->bindParam(':event_id', $eventId);

        // Execute query
        try {
            $statement->execute();
        } catch (PDOException $e) {
            echo "Error getting all links for event : " . $e->getMessage();
            return null;
        }

        if ($statement->rowCount() > 0) {
            return $statement->fetch(PDO::FETCH_ASSOC);;
        } else {
            return null;
        }
    }

    // Method to update a link for an evenet
    public function update()
    {
        // Update query
        $query = "UPDATE " . $this->table_name . " SET  event_id= :event_id, link= :link, is_approved= :is_approved";

        // Prepare query statement
        $statement = $this->connection->prepare($query);

        // Bind data
        $statement->bindParam(":event_id", $this->event_id);
        $statement->bindParam(":link", $this->link);
        $statement->bindParam(":is_approved", $this->is_approved);

        // Execute query
        if ($statement->execute()) {
            return true;
        }

        return false;
    }


    // Method to delete a link for an event
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
