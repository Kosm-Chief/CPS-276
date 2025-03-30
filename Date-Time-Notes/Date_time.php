<?php
require_once 'Db_conn.php'; // Make sure this file sets up and returns a PDO connection

class Date_time {
    private $pdo;

    public function __construct() {
        $db = new Db_conn();
        $this->pdo = $db->connect();
    }

    // Called from add_note.php
    public function checkSubmit() {
        if (isset($_POST['submit'])) {
            $dateTime = $_POST['dateTime'] ?? '';
            $note = trim($_POST['note'] ?? '');

            if (empty($dateTime) || empty($note)) {
                return "<div class='alert alert-danger'>Please enter a date, time, and note.</div>";
            }

            $timestamp = date('Y-m-d H:i:s', strtotime($dateTime));

            $sql = "INSERT INTO notes (date_time, note) VALUES (:dt, :note)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':dt', $timestamp);
            $stmt->bindValue(':note', $note);
            $stmt->execute();

            return "<div class='alert alert-success'>Note added successfully!</div>";
        }
    }

    // Called from display_notes.php
    public function getNotes() {
        if (isset($_POST['getNotes'])) {
            $begDate = $_POST['begDate'] ?? '';
            $endDate = $_POST['endDate'] ?? '';

            if (empty($begDate) || empty($endDate)) {
                return "<div class='alert alert-danger'>Please select both beginning and ending dates.</div>";
            }

            // Append time to dates to make full-day ranges
            $begDate .= " 00:00:00";
            $endDate .= " 23:59:59";

            $sql = "SELECT date_time, note FROM notes 
                    WHERE date_time BETWEEN :begDate AND :endDate 
                    ORDER BY date_time DESC";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':begDate', $begDate);
            $stmt->bindValue(':endDate', $endDate);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (!$results) {
                return "<div class='alert alert-info'>No notes found in that date range.</div>";
            }

            // Build table
            $table = "<table class='table table-striped mt-3'>
                        <thead>
                          <tr>
                            <th>Date and Time</th>
                            <th>Note</th>
                          </tr>
                        </thead>
                        <tbody>";
            foreach ($results as $row) {
                $formattedDate = date('n/j/Y h:i a', strtotime($row['date_time']));
                $table .= "<tr>
                            <td>{$formattedDate}</td>
                            <td>{$row['note']}</td>
                          </tr>";
            }

            $table .= "</tbody></table>";
            return $table;
        }
    }
}
?>
