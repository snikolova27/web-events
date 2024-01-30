<?php
// Include necessary files and establish database connection
require_once("../db/db.php");

$db = new Db();
$connection = $db->getConnection();

// Fetch students and user data
$query = "SELECT u.names AS Names, u.email AS Email, s.fn AS FN, s.major AS Major, s.adm_group AS Adm_group, s.course AS Course FROM students s INNER JOIN users u ON s.user_id = u.id";
$stmt = $connection->prepare($query);
$stmt->execute();

// Fetch all records
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Define the filename for the CSV download
$filename = "students_export_" . date('Ymd') . ".csv";

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="' . $filename . '"');

// Open output stream to generate CSV content
$output = fopen('php://output', 'w');

// Add the headers for each column in the CSV
fputcsv($output, array('Names', 'Email', 'FN', 'Major', 'Adm_group', 'Course'));

// Add data to CSV
foreach ($students as $student) {
    fputcsv($output, $student);
}

// Close output stream
fclose($output);
exit();
?>
