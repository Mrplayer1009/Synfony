<?php

namespace App\Entity;

use App\Repository\tacheRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: tacheRepository::class)]
class tache
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: 'text')]
    private ?string $description = null;

    #[ORM\Column(type: 'string', length: 20)]
    private ?string $status = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $updatedAt = null;

    // Getters et Setters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }


    public function valider(tache $task): array
    {
        $errors = [];
        if (strlen($task->getTitle()) < 3 || strlen($task->getTitle()) > 255) {
            $errors[] = "3 à 255 caractères pour le titre.";
    }
        if (empty($task->getDescription())) {
            $errors[] = "La description est obligatoire.";
    }
        if (!in_array($task->getStatus(), ['todo', 'in_progress', 'done'])) {
            $errors[] = "Erreur Statut.";
    }
        return $errors;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une Tâche</title>
</head>
<body>
    <h1>Ajouter une Tâche</h1>
    <form action="add_task.php" method="POST">
        <label for="title">Titre :</label><br>
        <input type="text" name="title" id="title" required><br><br>

        <label for="description">Description :</label><br>
        <textarea name="description" id="description" required></textarea><br><br>

        <label for="status">Statut :</label><br>
        <select name="status" id="status" required>
            <option value="todo">En attente</option>
            <option value="in_progress">En cours</option>
            <option value="done">Fini</option>
        </select><br><br>

        <button type="submit">Ajouter</button>
    </form>
</body>
</html>
