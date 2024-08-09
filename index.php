<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Cadastro de Cursos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            display: flex;
            height: 100vh;
        }
        .sidebar {
            width: 250px;
            background: #2c3e50;
            color: white;
            padding: 20px;
            box-sizing: border-box;
        }
        .sidebar a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 10px 0;
            border-bottom: 1px solid #34495e;
        }
        .sidebar a:hover, .sidebar a.active {
            background: #34495e;
        }
        .content {
            flex: 1;
            padding: 20px;
            box-sizing: border-box;
        }
        .hidden {
            display: none;
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        .actions a {
            margin-right: 10px;
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 5px;
            color: white;
            display: inline-block;
        }
        .actions a.edit {
            background: #95a5a6; /* cor neutra */
        }
        .actions a.delete {
            background: #95a5a6; /* cor neutra */
        }
        .actions a.edit:hover, .actions a.delete:hover {
            background: #7f8c8d; /* cor neutra mais escura */
        }
    </style>
    <script>
        function showContent(contentId) {
            // Hide all content divs
            const contents = document.querySelectorAll('.content div');
            contents.forEach(div => div.classList.add('hidden'));
            
            // Remove active class from all menu links
            const links = document.querySelectorAll('.sidebar a');
            links.forEach(link => link.classList.remove('active'));
            
            // Show the selected content div and add active class to the menu link
            document.getElementById(contentId).classList.remove('hidden');
            document.querySelector(`.sidebar a[href='#${contentId}']`).classList.add('active');
        }

        document.addEventListener('DOMContentLoaded', () => {
            // Set the default content to show
            showContent('home');
        });
    </script>
</head>
<body>
    <div class="sidebar">
        <a href="#home" onclick="showContent('home'); return false;" class="active">Home</a>
        <a href="#register-course" onclick="showContent('register-course'); return false;">Cadastrar Curso</a>
        <a href="#courses" onclick="showContent('courses'); return false;">Cursos</a>
    </div>
    <div class="content">
        <div id="home">
            <h2>Bem-vindo ao Sistema de Cadastro</h2>
            <p>Selecione uma opção no menu para começar.</p>
        </div>
        <div id="register-course" class="hidden">
            <h2>Cadastro de Curso</h2>
            <form action="register-course.php" method="post">
                <label for="course-name">Nome do Curso:</label>
                <input type="text" id="course-name" name="course-name" required>

                <label for="description">Descrição:</label>
                <textarea id="description" name="description" required></textarea>

                <label for="duration">Duração (em horas):</label>
                <input type="number" id="duration" name="duration" required>

                <input type="submit" value="Cadastrar">
            </form>
        </div>
        <div id="courses" class="hidden">
            <h2>Lista de Cursos</h2>
            <table>
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Descrição</th>
                        <th>Duração</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Verificar se o arquivo courses.json existe
                    $coursesFile = 'courses.json';
                    if (!file_exists($coursesFile)) {
                        file_put_contents($coursesFile, json_encode([]));
                    }

                    // Carregar cursos do arquivo JSON
                    $courses = json_decode(file_get_contents($coursesFile), true);
                    if (!empty($courses)) {
                        foreach ($courses as $id => $course) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($course['name']) . "</td>";
                            echo "<td>" . htmlspecialchars($course['description']) . "</td>";
                            echo "<td>" . htmlspecialchars($course['duration']) . " horas</td>";
                            echo "<td class='actions'>
                                    <a href='edit-course.php?id=$id' class='edit'>Editar</a>
                                    <a href='delete-course.php?id=$id' class='delete'>Excluir</a>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>Nenhum curso cadastrado.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
