<?php
$title = "Pet Details Page";
include('include/db_connect.inc');
include('include/header.inc'); 
include('include/nav.inc'); 

// Check if pet ID is provided
if (!isset($_GET['id'])) {
    header("Location: gallery.php"); // Redirect if no ID is provided
    exit();
}

$petId = intval($_GET['id']);

// Prepare the query to fetch the pet details
$query = "SELECT * FROM pets WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $petId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $pet = $result->fetch_assoc();
} else {
    echo "<p class='text-center'>No pet found.</p>";
    exit();
}
?>

<main class="container my-4 flex-grow-1">
    <h1 class="text-center mb-4"><?= htmlspecialchars($pet['name']) ?></h1>
    <div class="row">
        <div class="col-md-6">
            <img src="<?= htmlspecialchars($pet['image_path']) ?>" alt="<?= htmlspecialchars($pet['name']) ?>" class="img-fluid">
        </div>
        <div class="col-md-6">
            <h3>Details</h3>
            <p><strong><i class="fas fa-paw"></i> Type:</strong> <?= htmlspecialchars($pet['type']) ?></p>
            <p><strong><i class="fas fa-calendar-alt"></i> Age:</strong> <?= htmlspecialchars($pet['age']) ?> months</p>
            <p><strong><i class="fas fa-map-marker-alt"></i> Location:</strong> <?= htmlspecialchars($pet['location']) ?></p>
            <p><strong><i class="fas fa-info-circle"></i> Description:</strong> <?= htmlspecialchars($pet['description']) ?></p>
            <a href="gallery.php" class="btn btn-secondary">Back to Gallery</a>
        </div>
    </div>
</main>

<?php include('include/footer.inc'); ?>
