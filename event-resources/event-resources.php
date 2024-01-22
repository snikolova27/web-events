<?php

class EventComment
{
    // Database connectionection
    private $connection;
    private $table_name = "event_resources";

    // Object properties
    public $id;

    public $event_id;

    public $link;

    // Constructor with DB connectionection
    public function __construct($db)
    {
        $this->connection = $db;
    }

    // Method to add a resource link to an event
    public function create()
    {
        // Insert query
        $query = "INSERT INTO " . $this->table_name . " SET event_id= :event_id, link= :link";

        // Prepare query
        $statement = $this->connection->prepare($query);

        // Clean data
        $this->event_id = htmlspecialchars(strip_tags($this->event_id));
        $this->link = htmlspecialchars(strip_tags($this->link));

        // Bind data
        $statement->bindParam(":event_id", $this->event_id);
        $statement->bindParam(":link", $this->link);

        // Execute query
        if ($statement->execute()) {
            return true;
        }

        return false;
    }

    // Method to get all resouce links for event
    public function getAllResourceLinksForEvent($eventId)
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
            echo "Error getting all resource links for event : " . $e->getMessage();
            return null;
        }

        if ($statement->rowCount() > 0) {
            return $statement->fetch(PDO::FETCH_ASSOC);;
        } else {
            return null;
        }
    }

    // Method to update a resource link for an evenet
    public function update()
    {
        // Update query
        $query = "UPDATE " . $this->table_name . " SET  event_id= :event_id, link= :link";

        // Prepare query statement
        $statement = $this->connection->prepare($query);

        // Bind data
        $statement->bindParam(":event_id", $this->event_id);
        $statement->bindParam(":link", $this->link);

        // Execute query
        if ($statement->execute()) {
            return true;
        }

        return false;
    }


    // Method to delete a resource link for an event
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
