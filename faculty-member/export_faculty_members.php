<?php
// Include necessary files and establish database connection
require_once("../db/db.php");

$db = new Db();
$connection = $db->getConnection();

// Fetch students and user data
$query = "SELECT u.names AS Names, u.email AS Email FROM faculty_members f INNER JOIN users u ON f.user_id = u.id";
$stmt = $connection->prepare($query);
$stmt->execute();

// Fetch all records
$faculty_members = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Define the filename for the CSV download
$filename = "faculty_members_export_" . date('Ymd') . ".csv";

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="' . $filename . '"');

// Open output stream to generate CSV content
$output = fopen('php://output', 'w');

// Add the headers for each column in the CSV
fputcsv($output, array('Names', 'Email'));

// Add data to CSV
foreach ($faculty_members as $faculty_member) {
    fputcsv($output, $faculty_member);
}

// Close output stream
fclose($output);
exit();
?>
