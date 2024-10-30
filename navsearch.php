<?php
$title = "Search Results";
include('include/db_connect.inc');
include('include/header.inc'); 
include('include/nav.inc');

// Check if the search parameters are set
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
$petType = ''; // Assuming you only want to search by keyword for the navbar

// Prepare the query based on the search parameters
$query = "SELECT name, image_path, id FROM pets WHERE 1=1"; // Start with a generic query

// Append conditions based on the keyword
if ($keyword) {
    $query .= " AND (name LIKE ? OR location LIKE ? OR description LIKE ?)"; // Include location and description
}

$stmt = $conn->prepare($query);

// Bind parameters for the prepared statement
$types = '';
$params = [];
if ($keyword) {
    $types .= 'sss'; // three string types for keyword, location, and description
    $params[] = "%$keyword%"; // add wildcard for name
    $params[] = "%$keyword%"; // add wildcard for location
    $params[] = "%$keyword%"; // add wildcard for description
}

if ($types) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();
?>

<main class="container my-4">
    <h1 class="text-center mb-4">Search Results</h1>

    <div class="row g-4">
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($pet = $result->fetch_assoc()): ?>
                <div class="col-md-4">
                    <div class="pet-card">
                        <a href="details.php?id=<?= $pet['id'] ?>" style="text-decoration: none;">
                            <img src="<?= htmlspecialchars($pet['image_path']) ?>" alt="<?= htmlspecialchars($pet['name']) ?>" class="img-fluid">
                            <div class="pet-name"><?= htmlspecialchars($pet['name']) ?></div>
                        </a>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-md-12">
                <p class="text-center">No pets found matching your search criteria.</p>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php include('include/footer.inc'); ?>
