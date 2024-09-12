<?php

// Configuration
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'zepto';
$uploadDir = 'uploads/';
$allowedTypes = ['ttf'];

// Connect to the database
function getDatabaseConnection($host, $user, $password, $dbname) {
    $connection = new mysqli($host, $user, $password, $dbname);
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }
    return $connection;
}

// Handle file upload
function uploadFiles($files, $uploadDir, $allowedTypes, $db) {
    $result = [];
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    foreach ($files['name'] as $key => $name) {
        $fileTmpName = $files['tmp_name'][$key];
        $fileType = pathinfo($name, PATHINFO_EXTENSION);
        if (in_array(strtolower($fileType), $allowedTypes)) {
            $newFileName = uniqid() . "." . $fileType;
            $targetPath = $uploadDir . $newFileName;
            if (move_uploaded_file($fileTmpName, $targetPath)) {
                $fontName = pathinfo($name, PATHINFO_FILENAME);
                $fontId = logUploadToDb($db, $newFileName, $fontName);
                $result[] = [
                    "status" => "success",
                    "file" => $newFileName,
                    "font_name" => $fontName,
                    "id" => $fontId,
                    "fonts" => fetchFonts($db)
                ];
            } else {
                $result[] = ["status" => "error", "message" => "Failed to upload $name"];
            }
        } else {
            $result[] = ["status" => "error", "message" => "$name is not an allowed file type."];
        }
    }
    return $result;
}

// Log uploaded file to database
function logUploadToDb($db, $fileName, $fontName) {
    $stmt = $db->prepare("INSERT INTO fonts (file_name, name, uploaded_at) VALUES (?, ?, NOW())");
    $stmt->bind_param('ss', $fileName, $fontName);
    $stmt->execute();
    $fontId = $stmt->insert_id;
    $stmt->close();
    return $fontId;
}

// Handle font deletion
function deleteFont($fontId, $uploadDir, $db) {
    $stmt = $db->prepare("SELECT file_name FROM fonts WHERE id = ?");
    $stmt->bind_param('i', $fontId);
    $stmt->execute();
    $stmt->bind_result($fileName);
    $stmt->fetch();
    $stmt->close();

    $filePath = $uploadDir . $fileName;

    if (unlink($filePath)) {
        $stmt = $db->prepare("DELETE FROM fonts WHERE id = ?");
        $stmt->bind_param('i', $fontId);
        $stmt->execute();
        $stmt->close();
        return ["status" => "success"];
    } else {
        return ["status" => "error", "message" => "Failed to delete file"];
    }
}

// Fetch fonts from the database
function fetchFonts($db) {
    $query = "SELECT * FROM fonts ORDER BY uploaded_at DESC";
    $result = $db->query($query);
    $fonts = [];
    while ($row = $result->fetch_assoc()) {
        $fonts[] = $row;
    }
    return $fonts;
}

// Main logic handling
function handleRequest() {
    global $host, $user, $password, $dbname, $uploadDir, $allowedTypes;

    $db = getDatabaseConnection($host, $user, $password, $dbname);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_FILES['files'])) {
            $response = uploadFiles($_FILES['files'], $uploadDir, $allowedTypes, $db);
            echo json_encode($response);
            exit;
        } elseif (isset($_POST['delete_id'])) {
            $response = deleteFont((int)$_POST['delete_id'], $uploadDir, $db);
            echo json_encode($response);
            exit;
        }
    }

    return fetchFonts($db);
}

$fonts = handleRequest();
