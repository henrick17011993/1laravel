<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    // Adicionar novo curso
    $courses[] = [
        'name' => $courseName,
        'description' => $description,
        'duration' => $duration
    ];

    // Salvar cursos no arquivo JSON
    file_put_contents($coursesFile, json_encode($courses));

    // Redirecionar de volta para a página inicial
    header('Location: index.php');
    exit;
} else {
    echo "<p>Ocorreu um erro com o cadastro. Por favor, tente novamente.</p>";
}
?>
