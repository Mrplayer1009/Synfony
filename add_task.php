<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $status = $_POST['status'] ?? 'todo'; // Par défaut à todo si vide
    $createdAt = date('Y-m-d H:i:s');
    $updatedAt = date('Y-m-d H:i:s');

    // j'éxécute le SQL ici
    $query = "INSERT INTO tache (title, description, status, created_at, updated_at) VALUES (:title, :description, :status, :created_at, :updated_at)";
    $stmt = $pdo->prepare($query);

    try {
        $stmt->execute([
            ':title' => $title,
            ':description' => $description,
            ':status' => $status,
            ':created_at' => $createdAt,
            ':updated_at' => $updatedAt,
        ]);

        echo "La tâche a été ajoutée.  ";?>
        <a href="index.php">Retour</a>
        <?php
    } catch (PDOException $e) {
        echo "Erreur:" . $e->getMessage();
    }
}
?>
