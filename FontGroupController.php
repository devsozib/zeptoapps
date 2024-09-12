<?php
// Configuration
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'zepto';

// Connect to the database
$connection = new mysqli($host, $user, $password, $dbname);
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Function to fetch font groups with associated fonts
function getFontGroups($connection) {
    $sql = "SELECT fg.id, fg.group_title, GROUP_CONCAT(f.name SEPARATOR ', ') as fonts, COUNT(fg_f.font_id) as font_count
            FROM font_groups fg
            LEFT JOIN font_group_fonts fg_f ON fg.id = fg_f.font_group_id
            LEFT JOIN fonts f ON fg_f.font_id = f.id
            GROUP BY fg.id
            ORDER BY fg.created_at DESC";
    
    $result = $connection->query($sql);

    if ($result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    } else {
        return [];
    }
}

// Fetch available fonts from the database
$fontsResult = $connection->query("SELECT id, name FROM fonts");
$fonts = [];
while ($row = $fontsResult->fetch_assoc()) {
    $fonts[] = $row;
}

// Fetch and display font groups on initial load
$fontGroups = getFontGroups($connection);

// Function to fetch a specific font group by ID
function getFontGroupById($connection, $id) {
    $sql = "SELECT fg.id, fg.group_title, f.id as font_id, f.name as font_name, fg_f.specific_size, fg_f.price_change
            FROM font_groups fg
            LEFT JOIN font_group_fonts fg_f ON fg.id = fg_f.font_group_id
            LEFT JOIN fonts f ON fg_f.font_id = f.id
            WHERE fg.id = ?";

    if ($stmt = $connection->prepare($sql)) {
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();

        $fontGroup = [
            'id' => $id,
            'group_title' => '',
            'fonts' => []
        ];

        while ($row = $result->fetch_assoc()) {
            if (empty($fontGroup['group_title'])) {
                $fontGroup['group_title'] = $row['group_title'];
            }

            $fontGroup['fonts'][] = [
                'id' => $row['font_id'],
                'name' => $row['font_name'],
                'specific_size' => $row['specific_size'],
                'price_change' => $row['price_change']
            ];
        }

        if (empty($fontGroup['fonts'])) {
            return ['error' => 'Font group not found.'];
        }

        $stmt->close();
        return $fontGroup;
    } else {
        return ['error' => 'SQL query preparation failed.'];
    }
}


// Handle form submission for creating a new font group
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action === 'create') {
        $groupTitle = $_POST['group_title'];
        $fontIds = $_POST['fonts']; // Array of font IDs
        $specificSizes = $_POST['specific_size']; // Array of specific sizes
        $priceChanges = $_POST['price_change']; // Array of price changes

        // Insert the new font group
        $stmt = $connection->prepare("INSERT INTO font_groups (group_title) VALUES (?)");
        $stmt->bind_param('s', $groupTitle);
        $stmt->execute();
        $groupId = $stmt->insert_id;
        $stmt->close();

        // Insert associated fonts
        if (!empty($fontIds)) {
            foreach ($fontIds as $index => $fontId) {
                $specificSize = $specificSizes[$index] ?? null;
                $priceChange = $priceChanges[$index] ?? null;

                $stmt = $connection->prepare("INSERT INTO font_group_fonts (font_group_id, font_id, specific_size, price_change) VALUES (?, ?, ?, ?)");
                $stmt->bind_param('iidd', $groupId, $fontId, $specificSize, $priceChange);
                $stmt->execute();
                $stmt->close();
            }
        }

        // Fetch updated font groups and generate HTML for the table
        $fontGroups = getFontGroups($connection);
        $output = '';
        foreach ($fontGroups as $group) {
            $output .= '<tr>';
            $output .= '<td>' . htmlspecialchars($group['group_title']) . '</td>';
            $output .= '<td>' . htmlspecialchars($group['fonts']) . '</td>';
            $output .= '<td>' . htmlspecialchars($group['font_count']) . '</td>';
            $output .= '<td>';
            $output .= '<button class="btn btn-primary btn-sm edit-group" data-id="' . htmlspecialchars($group['id']) . '">Edit</button> ';
            $output .= '<a href="deleteFontGroup.php?id=' . $group['id'] . '" class="btn btn-danger btn-sm">Delete</a>';
            $output .= '</td>';
            $output .= '</tr>';
        }

        echo $output;
        $connection->close();
        exit;
    }

    if ($action === 'update') {
        // echo(print_r($_POST));
        // return;
        $groupId = intval($_POST['group_id']);
        $groupTitle = $_POST['group_title'];
        $fontIds = $_POST['fonts']; // Array of font IDs
        $specificSizes = $_POST['specific_size']; // Array of specific sizes
        $priceChanges = $_POST['price_change']; // Array of price changes

        // Update the font group title
        $stmt = $connection->prepare("UPDATE font_groups SET group_title = ? WHERE id = ?");
        $stmt->bind_param('si', $groupTitle, $groupId);
        $stmt->execute();
        $stmt->close();

        // Delete existing font associations
        $stmt = $connection->prepare("DELETE FROM font_group_fonts WHERE font_group_id = ?");
        $stmt->bind_param('i', $groupId);
        $stmt->execute();
        $stmt->close();

        // Insert updated font associations
        if (!empty($fontIds)) {
            foreach ($fontIds as $index => $fontId) {
                $specificSize = $specificSizes[$index] ?? null;
                $priceChange = $priceChanges[$index] ?? null;

                $stmt = $connection->prepare("INSERT INTO font_group_fonts (font_group_id, font_id, specific_size, price_change) VALUES (?, ?, ?, ?)");
                $stmt->bind_param('iidd', $groupId, $fontId, $specificSize, $priceChange);
                $stmt->execute();
                $stmt->close();
            }
        }

        // Return success response
        echo json_encode(['success' => 'Font group updated successfully.']);
        $connection->close();
        exit;
    }
}

// Handle GET request to fetch font group data
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $groupId = intval($_GET['id']);
    $fontGroup = getFontGroupById($connection, $groupId);
    echo json_encode($fontGroup);
    $connection->close();
    exit;
}

// Fetch available fonts from the database
$fontsResult = $connection->query("SELECT id, name FROM fonts");
$fonts = [];
while ($row = $fontsResult->fetch_assoc()) {
    $fonts[] = $row;
}

// Fetch and display font groups on initial load
$fontGroups = getFontGroups($connection);

$connection->close();
?>
