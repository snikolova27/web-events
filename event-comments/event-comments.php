<?php

class EventComment
{
    // Database connectionection
    private $connection;
    private $table_name = "event_comments";

    // Object properties
    public $id;

    public $event_id;

    public $comment;

    public $review;

    // Constructor with DB connectionection
    public function __construct($db)
    {
        $this->connection = $db;
    }

    // Method to create a new comment for an event
    public function create()
    {
        // Insert query
        $query = "INSERT INTO " . $this->table_name . " SET event_id= :event_id, comment= :comment, review= :review";

        // Prepare query
        $statement = $this->connection->prepare($query);

        // Clean data
        $this->event_id = htmlspecialchars(strip_tags($this->event_id));
        $this->comment = htmlspecialchars(strip_tags($this->comment));
        $this->review = htmlspecialchars(strip_tags($this->review));

        // Bind data
        $statement->bindParam(":event_id", $this->event_id);
        $statement->bindParam(":comment", $this->comment);
        $statement->bindParam(":review", $this->review);

        // Execute query
        if ($statement->execute()) {
            return true;
        }

        return false;
    }

    // Method to get all comments for an event
    public function getAllCommentsForEvent($eventId)
    {
        // Select query
        $query = "SELECT * FROM " . $this->table_name . " WHERE event_id=:event_id";


        // Prepare query statement
        $statement = $this->connection->prepare($query);

        // Bind parameter
        $statement->bindParam(':event_id', $eventId);

        // Execute query
        try {
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error getting all comments for event: " . $e->getMessage();
            return null;
        }
    }

    // Method to update a comment for an event
    public function update()
    {
        // Update query
        $query = "UPDATE " . $this->table_name . " SET  event_id= :event_id, comment= :comment, review= :review";

        // Prepare query statement
        $statement = $this->connection->prepare($query);

        // Bind data
        $statement->bindParam(":event_id", $this->event_id);
        $statement->bindParam(":comment", $this->comment);
        $statement->bindParam(":review", $this->review);

        // Execute query
        if ($statement->execute()) {
            return true;
        }

        return false;
    }


    // Method to delete a comment for an event
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

    public function addCommentToEvent($eventId, $commentText, $review) {
        // Insert query
        $query = "INSERT INTO " . $this->table_name . " (event_id, comment, review) VALUES (:event_id, :comment, :review)";

        // Prepare query
        $statement = $this->connection->prepare($query);

        // Clean data
        $cleanEventId = htmlspecialchars(strip_tags($eventId));
        $cleanComment = htmlspecialchars(strip_tags($commentText));
        $cleanReview = htmlspecialchars(strip_tags($review)); // Hardcoded review value

        // Bind data
        $statement->bindParam(":event_id", $cleanEventId);
        $statement->bindParam(":comment", $cleanComment);
        $statement->bindParam(":review", $cleanReview);

        // Execute query
        if ($statement->execute()) {
            return true;
        }

        return false;
    }
}
