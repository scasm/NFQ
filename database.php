<?php
include "project.php";


class Database
{
    private $connection;

    function __construct()
    {
        $this->connectToDb();
    }

    //Establishes connection to database
    public function connectToDb()
    {
        $this->connection = mysqli_connect('localhost', 'root', '', 'nfq');
        if (mysqli_connect_error()) {
            die("Database connection failed" . mysqli_connect_error() . mysqli_connect_errno());
        }
    }
    //Get students belonging to a certain project group
    public function getStudentsBelongingToAGroup($project, $group)
    {
        $sql = "SELECT * FROM students WHERE project = $project AND groupNr = $group";
        $res = mysqli_query($this->connection, $sql);
        if (!$res)
            die("Query failed");
        $students[] = null;
        while ($row = mysqli_fetch_assoc($res)) {
            array_push($students, $row['full_name']);
        }
        return $students;
    }
    //Assigns student to a group
    public function assignStudentToAGroup($student_id, $project, $group)
    {
        $sql = "UPDATE students SET project = $project, groupNr = $group WHERE id = $student_id";
        $res = mysqli_query($this->connection, $sql);

        if (!$res)
            die("Query failed");
    }

    //Reads all the projects from the database
    public function readAllProjects()
    {
        global $projects;
        $projects[] = null;
        $sql = "SELECT * FROM projects";
        $res = mysqli_query($this->connection, $sql);
        if (!$res)
            die("Query failed");

        while ($row = mysqli_fetch_assoc($res)) {
            array_push($projects, new Project($row['id'], $row['title'], $row['number_of_groups'], $row['students_per_group']));
        }
    }
    //Retrieves the project by id
    public function getProjectById($id)
    {
        $sql = "SELECT * FROM projects WHERE id = $id";
        $res = mysqli_query($this->connection, $sql);
        if (!$res)
            die('query failed');

        $row = mysqli_fetch_assoc($res);
        return new Project($row['id'], $row['title'], $row['number_of_groups'], $row['students_per_group']);
    }
    //Reads projects and makes them as options for select
    public function showProjectsForSelect()
    {
        $sql = "SELECT * FROM projects";
        $res = mysqli_query($this->connection, $sql);

        if (!$res)
            die("Query failed");

        while ($row = mysqli_fetch_assoc($res)) {
            $title = $row['title'];
            $id = $row['id'];
            echo "<option value='$id'>$title</option>";

        }
    }
    //Shows students for select
    public function showStudentsForSelect()
    {
        $sql = "SELECT * FROM students WHERE groupNr IS NULL";
        $res = mysqli_query($this->connection, $sql);
        if (!$res)
            die('Query failed');
        while ($row = mysqli_fetch_assoc($res)) {
            $id = $row['id'];
            $name = $row['full_name'];
            echo "<option value='$id'>$name</option>";
        }
    }
    //Shows students in a list
    public function showStudents()
    {
        $sql = "SELECT * FROM students";
        $res = mysqli_query($this->connection, $sql);
        if (!$res)
            die("Query failed");
        if ($res->num_rows === 0)
            echo "<tr><td colspan='4' style='text-align: center'>No students</td></tr>";
        while ($row = mysqli_fetch_assoc($res)) {
            $name = $row['full_name'];
            $project = $row['project'];
            $group = $row['groupNr'];
            $id = $row['id'];
            echo "<tr><td>$name</td><td>$project</td><td>$group</td><td><a href='project_view.php?id=$id'>Delete</a></td></tr>";
        }
    }
    //Deletes a student
    public function deleteStudent($id)
    {
        $sql = "DELETE FROM students WHERE id = $id";
        $res = mysqli_query($this->connection, $sql);
        if (!$res)
            die("Query failed");
    }
    //Creates a project
    public function createProject($name, $nog, $spg)
    {
        $sql = "INSERT INTO projects(title, number_of_groups, students_per_group) VALUES ('$name', '$nog', '$spg') ";
        $res = mysqli_query($this->connection, $sql);
        if ($res)
            return true;
        else
            return false;
    }
    //Creates a student
    public function createStudent($name)
    {

        $sql = "INSERT INTO students(full_name) VALUES ('$name')";
        try {
            mysqli_query($this->connection, $sql);
            return true;
        } catch (Exception $e) {
            echo "<h3>This student already exists</h3>";
        }

    }

    //Prevents SQL Injection
    public function sanitize($var)
    {
        return mysqli_real_escape_string($this->connection, $var);
    }
}

$database = new Database();
?>