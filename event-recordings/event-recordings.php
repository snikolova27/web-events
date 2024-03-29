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

    // Method to create a new event link entry
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

    // Method to get all recordings for event
    public function getAllRecordingsForEvent($eventId)
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
            echo "Error getting all recordings for event : " . $e->getMessage();
            return null;
        }

        if ($statement->rowCount() > 0) {
            return $statement->fetch(PDO::FETCH_ASSOC);;
        } else {
            return null;
        }
    }

    // Method to update a link for an event
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

    // Method to approve a link for an event
    public function approveLinkForEvent($link, $eventId)
    {
        // Update query
        $query = "UPDATE " . $this->table_name . " SET is_approved= 1 
        WHERE event_id= :event_id AND link= :link ";

        // Prepare query statement
        $statement = $this->connection->prepare($query);

        // Bind data
        $statement->bindParam(":event_id", $eventId);
        $statement->bindParam(":link", $link);

        // Execute query
        if ($statement->execute()) {
            return true;
        }

        return false;
    }


    // Method to get approved event recordings by event_id
    public function getApprovedEventRecordingsByEventId($eventId)
    {
        // Select query
        $query = "SELECT * FROM " . $this->table_name . " WHERE event_id =:event_id and is_approved=1";

        // Prepare query statement
        $statement = $this->connection->prepare($query);

        // Bind parameter
        $statement->bindParam(':event_id', $eventId);

        // Execute query
        try {
            $statement->execute();

            // Fetch the result
            $row = $statement->fetchAll(PDO::FETCH_ASSOC);

            // Return the recordings data
            return $row;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }
    // Method to get approved event recordings 
    public function getNotApprovedEventRecordingsdWithDetails()
    {
        // Select query
        $query = "SELECT * FROM  event_recordings
        JOIN events on events.id = event_recordings.event_id
        JOIN fm_x_subject fmx ON events.fm_x_subject_id = fmx.id
        JOIN subjects s ON fmx.subject_id = s.id
        JOIN faculty_members fm ON fmx.fm_id = fm.fm_id
        JOIN users u ON fm.user_id = u.id
        WHERE is_approved=0";

        // Prepare query statement
        $statement = $this->connection->prepare($query);

        // Execute query
        try {
            $statement->execute();

            // Fetch the result
            $row = $statement->fetchAll(PDO::FETCH_ASSOC);

            // Return the recordings data
            return $row;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
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

    public function addRecordingToEvent($eventId, $recording) {
        // Insert query
        $query = "INSERT INTO " . $this->table_name . " (event_id, link, is_approved) VALUES (:event_id, :link, :is_approved)";
    
        // Prepare query
        $statement = $this->connection->prepare($query);
    
        // Clean data
        $cleanEventId = htmlspecialchars(strip_tags($eventId));
        $cleanRecordingLink = htmlspecialchars(strip_tags($recording));
        $cleanIsApproved = 0; // false by default
    
        // Bind data
        $statement->bindParam(":event_id", $cleanEventId);
        $statement->bindParam(":link", $cleanRecordingLink);
        $statement->bindParam(":is_approved", $cleanIsApproved);
    
        // Execute query
        if ($statement->execute()) {
            return true;
        }
    
        return false;
        }
}
