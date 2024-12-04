<?php
include 'db.php';

// Maj du statut
if (isset($_POST['update_status'])) {
    $taskId = $_POST['task_id'];
    $newStatus = $_POST['new_status'];

    $query = "UPDATE tache SET status = :new_status, updated_at = :updated_at WHERE id = :id";
    $stmt = $pdo->prepare($query);

    try {
        $stmt->execute([
            ':new_status' => $newStatus,
            ':updated_at' => date('Y-m-d H:i:s'),
            ':id' => $taskId,
        ]);
        echo "Statut mis à jour.";
    } catch (PDOException $e) {
        echo "Erreur: " . $e->getMessage();
    }
}

// Pagination
$tasksPerPage = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $tasksPerPage;

// Récupération des tâches
$query = "SELECT * FROM tache LIMIT :limit OFFSET :offset";
$stmt = $pdo->prepare($query);
$stmt->bindValue(':limit', $tasksPerPage, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Total pour pagination
$totalTasks = $pdo->query("SELECT COUNT(*) FROM tache")->fetchColumn();
$totalPages = ceil($totalTasks / $tasksPerPage);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Tâches</title>
</head>
<body>
    <a href="index.php">Retour</a>
    <h1>Liste des Tâches</h1>

    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>ID</th>
                <th>Titre</th>
                <th>Description</th>
                <th>Statut</th>
                <th>Date de Création</th>
                <th>Date de Mise à Jour</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tasks as $task): ?>
                <tr>
                    <td><?= htmlspecialchars($task['id']) ?></td>
                    <td><?= htmlspecialchars($task['title']) ?></td>
                    <td><?= htmlspecialchars($task['description']) ?></td>
                    <td><?= htmlspecialchars($task['status']) ?></td>
                    <td><?= htmlspecialchars($task['created_at']) ?></td>
                    <td><?= htmlspecialchars($task['updated_at']) ?></td>
                    <td>
                        <form action="list.php" method="POST" style="display: inline-block;">
                            <input type="hidden" name="task_id" value="<?= $task['id'] ?>">
                            <select name="new_status" required>
                                <option value="">-- Changer le statut --</option>
                                <option value="todo" <?= $task['status'] === 'todo' ? 'disabled' : '' ?>>To Do</option>
                                <option value="in_progress" <?= $task['status'] === 'in_progress' ? 'disabled' : '' ?>>In Progress</option>
                                <option value="done" <?= $task['status'] === 'done' ? 'disabled' : '' ?>>Done</option>
                            </select>
                            <button type="submit" name="update_status">Mettre à jour</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <br>

    <!-- Pagination -->
    <div>
        <?php if ($page > 1): ?>
            <a href="list.php?page=<?= $page - 1 ?>">Page Précédente</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="list.php?page=<?= $i ?>" <?= $i === $page ? 'style="font-weight: bold;"' : '' ?>><?= $i ?></a>
        <?php endfor; ?>

        <?php if ($page < $totalPages): ?>
            <a href="list.php?page=<?= $page + 1 ?>">Page Suivante</
            </a>
        <?php endif; ?>
    </div>
</body>
</html>
