<?php
require_once 'database.php';

//Retrieves selected project
session_start();
$current_project = $_SESSION['project'];


//Makes the page refresh every 10 seconds
$url1 = $_SERVER['REQUEST_URI'];
header("Refresh: 10; URL=$url1");

//Creates a student
if (isset($_POST['submit'])) {
    $full_name = $database->sanitize($_POST['full_name']);
    $database->createStudent($full_name);
}

//Assigns student to a group
if (isset($_POST['student'])) {
    $student = $_POST['student'];
    $group = $_POST['groupId'];

    $database->assignStudentToAGroup($student, $current_project->id, $group);
}
//Deletes student
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $database->deleteStudent($id);
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
<div style="margin: 0 auto;text-align: center;">
    <a href="index.php">back to index</a>
    <?php

    echo "<h3>Current project: $current_project->title</h3>";
    echo "<h3>Number of groups: $current_project->num_of_groups</h3>";
    echo "<h3>Students per group: $current_project->stud_per_group</h3>";


    ?>
</div>
<div style="overflow-y: auto;margin: auto;width: 500px;height: 200px;display: flex;">
    <table style="width:100%">
        <tr>
            <th>Full name</th>
            <th>Project</th>
            <th>Group</th>
            <th>Actions</th>
        </tr>
        <?php
        //Lists all students
        $database->showStudents();
        ?>
    </table>
</div>
<br>
<div style="margin: auto;width: 500px;height: auto;">
    <h3 style="width: 100%;text-align: center">Add new student</h3>
    <form action="project_view.php" method="POST" style="margin: 0 auto">
        <label for="full_name">Full name: </label>
        <input type="text" name="full_name">
        <button type="submit" name="submit">Add new student</button>
    </form>
</div>
<br>


<?php
//Creates and displays groups
$current_project->createGroups($database);
?>


</body>
</html>
