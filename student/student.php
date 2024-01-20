<?php
class Student
{
    // Database connection
    private $connection;
    private $table_name = "students";

    // Object properties
    public $fn;
    public $major;
    public $adm_group;
    public $user_id;

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
                  SET fn=:fn,  major=:major, adm_group=:adm_group, user_id=:user_id";

        // Prepare query
        $statement = $this->connection->prepare($query);

        // Clean data
        $this->fn = htmlspecialchars(strip_tags($this->fn));
        $this->major = htmlspecialchars(strip_tags($this->major));
        $this->adm_group = htmlspecialchars(strip_tags($this->adm_group));
        $this->user_id = htmlspecialchars(strip_tags($this->user_id));

        // Bind data
        $statement->bindParam(":fn", $this->fn);
        $statement->bindParam(":major", $this->major);
        $statement->bindParam(":adm_group", $this->adm_group);
        $statement->bindParam(":user_id", $this->user_id);

        // Execute query
        if ($statement->execute()) {
            return true;
        }

        return false;
    }

    // Method to getAllStudents 
    public function getAllStudents()
    {
        // Select query
        $query = "SELECT * FROM " . $this->table_name . " WHERE fn = ? LIMIT 0,1";

        // Prepare query statement
        $statement = $this->connection->prepare($query);

        // Bind fn
        $statement->bindParam(1, $this->fn);

        // Execute query
        $statement->execute();

        $row = $statement->fetch(PDO::FETCH_ASSOC);

        return $row;
    }

    // Method to update a student
    public function update()
    {
        // Update query
        $query = "UPDATE " . $this->table_name . " 
                  SET major = :major, adm_group = :adm_group, user_id = :user_id
                  WHERE fn = :fn";

        // Prepare query statement
        $statement = $this->connection->prepare($query);

        // Clean data and bind values
        $statement->bindParam(":major", htmlspecialchars(strip_tags($this->major)));
        $statement->bindParam(":adm_group", htmlspecialchars(strip_tags($this->adm_group)));
        $statement->bindParam(":user_id", htmlspecialchars(strip_tags($this->user_id)));
        $statement->bindParam(":fn", htmlspecialchars(strip_tags($this->fn)));

        // Execute query
        if ($statement->execute()) {
            return true;
        }

        return false;
    }

    // Method to delete a student
    public function delete()
    {
        // Delete query
        $query = "DELETE FROM " . $this->table_name . " WHERE fn = :fn";

        // Prepare query
        $statement = $this->connection->prepare($query);

        // Clean data and bind value
        $statement->bindParam(":fn", htmlspecialchars(strip_tags($this->fn)));

        // Execute query
        if ($statement->execute()) {
            return true;
        }

        return false;
    }
}

// Usage example
/*
$db = new PDO("mysql:host=your_host;dbname=your_db", "your_username", "your_password");
$student = new Student($db);
*/
