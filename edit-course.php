<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = htmlspecialchars($_POST['id']);
    $courseName = htmlspecialchars($_POST['course-name']);
    $description = htmlspecialchars($_POST['description']);
    $duration = htmlspecialchars($_POST['duration']);

    // Verificar se o arquivo courses.json existe
    $coursesFile = 'courses.json';
    if (!file_exists($coursesFile)) {
        file_put_contents($coursesFile, json_encode([]));
    }

    // Carregar cursos existentes
    $courses = json_decode(file_get_contents($coursesFile), true);

    // Atualizar curso
    $courses[$id] = [
        'name' => $courseName,
        'description' => $description,
        'duration' => $duration
    ];

    // Salvar cursos no arquivo JSON
    file_put_contents($coursesFile, json_encode($courses));

    // Redirecionar de volta para a página inicial
    header('Location: index.php');
    exit;
} else if (isset($_GET['id'])) {
    $id = htmlspecialchars($_GET['id']);

    // Verificar se o arquivo courses.json existe
    $coursesFile = 'courses.json';
    if (!file_exists($coursesFile)) {
        file_put_contents($coursesFile, json_encode([]));
    }

    // Carregar cursos existentes
    $courses = json_decode(file_get_contents($coursesFile), true);

    if (isset($courses[$id])) {
        $course = $courses[$id];
    } else {
        echo "<p>Curso não encontrado.</p>";
        exit;
    }
} else {
    echo "<p>Ocorreu um erro. Por favor, tente novamente.</p>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Curso</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            display: flex;
            height: 100vh;
        }
        .content {
            flex: 1;
            padding: 20px;
            box-sizing: border-box;
        }
        form {
            max-width: 500px;
            margin: 0 auto;
        }
        form input, form textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        form input[type="submit"] {
            background: #2c3e50;
            color: white;
            border: none;
            cursor: pointer;
        }
        form input[type="submit"]:hover {
            background: #34495e;
        }
    </style>
</head>
<body>
    <div class="content">
        <h2>Editar Curso</h2>
        <form action="edit-course.php" method="post">
            <input type="hidden" name="id" value="<?php echo $id; ?>">

            <label for="course-name">Nome do Curso:</label>
            <input type="text" id="course-name" name="course-name" value="<?php echo htmlspecialchars($course['name']); ?>" required>

            <label for="description">Descrição:</label>
            <textarea id="description" name="description" required><?php echo htmlspecialchars($course['description']); ?></textarea>

            <label for="duration">Duração (em horas):</label>
            <input type="number" id="duration" name="duration" value="<?php echo htmlspecialchars($course['duration']); ?>" required>

            <input type="submit" value="Salvar">
        </form>
    </div>
</body>
</html>

