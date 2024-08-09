<?php
if (isset($_GET['id'])) {
    $id = htmlspecialchars($_GET['id']);

    // Verificar se o arquivo courses.json existe
    $coursesFile = 'courses.json';
    if (!file_exists($coursesFile)) {
        file_put_contents($coursesFile, json_encode([]));
    }

    // Carregar cursos existentes
    $courses = json_decode(file_get_contents($coursesFile), true);

    if (isset($courses[$id])) {
        unset($courses[$id]);

        // Salvar cursos no arquivo JSON
        file_put_contents($coursesFile, json_encode($courses));

        // Redirecionar de volta para a página inicial
        header('Location: index.php');
        exit;
    } else {
        echo "<p>Curso não encontrado.</p>";
    }
} else {
    echo "<p>Ocorreu um erro. Por favor, tente novamente.</p>";
}
?>
