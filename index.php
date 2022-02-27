<?php
session_start();
require_once('database.php');

$database->readAllProjects();

if (isset($_POST['submit']) & !empty($_POST['name']) & !empty($_POST['num_of_groups']) & !empty($_POST['stud_per_group'])) {
    $name = $database->sanitize($_POST['name']);
    $nog = $database->sanitize($_POST['num_of_groups']);
    $spg = $database->sanitize($_POST['stud_per_group']);
    $res = $database->createProject($name, $nog, $spg);
    if ($res)
        echo "insert successful";
    else
        echo "insert unsuccessful";
    $database->readAllProjects();
    $_SESSION['project'] = end($projects);
    header("Location: project_view.php");
}

if (isset($_POST['other'])) {
    $_SESSION['project'] = $database->getProjectById($_POST['projects']);
    print_r($_SESSION['project']);
    header("Location: project_view.php");
}


?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>NFQ</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div style="margin: auto; text-align: center">
    <h1>Create a new project</h1>
</div>
<div style="margin: auto;">
    <form action="index.php" method="post" style="width: auto;text-align: center">
        <label for="name">Project name:</label>
        <br>
        <input type="text" id="name" name="name">
        <br>
        <br>
        <label for="nog">Number of groups:</label>
        <br>
        <input type="number" id="nog" name="num_of_groups">
        <br>
        <br>
        <label for="spg">Students per group:</label>
        <br>
        <input type="number" id="spg" name="stud_per_group">
        <br><br>
        <button type="submit" name='submit'>Submit</button>
</div>


</form>
<div style="text-align: center"><h1>Other projects</h1></div>


<form action="index.php" method="post" style="text-align: center;">
    <label for="projects">Select an existing project: </label>
    <br>
    <select name="projects" id="projects">
        <?php
        $database->showProjectsForSelect();
        ?>
    </select>
    <br>
    <br>
    <button type="submit" name="other">Select</button>


</form>
</body>
</html>