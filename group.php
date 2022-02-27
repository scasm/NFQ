<?php
//include 'database.php';

class Group
{
    public $id;
    public $max_students;
    public $students;

    public function __construct($id, $max_students, $students)
    {
        $this->id = $id;
        $this->max_students = $max_students;
        $this->students = $students;
    }
    //Displays a group
    public function showGroup($database)
    {
        echo "<div style='margin: auto;width: 250px;height: 200px;display: flex;'><table style='width: 100%;height: 100%'><tr><th>Group $this->id</th></tr>";
        for ($i = 0; $i <= $this->max_students; $i++) {
            if (array_key_exists($i, $this->students)) {
                $stud = $this->students[$i];
                echo "<tr><td>$stud</td></tr>";
            }
            else {
                echo "<tr><td><form name='form' method='post'><input type='hidden' name='groupId' value='$this->id'><select style='width: 200px' name='student' onchange='this.form.submit()'>";
                echo "<option value=''>ASSIGN A STUDENT</option>";
                $database->showStudentsForSelect();
                echo "</select></form></td></tr>";
            }

        }
        echo "</table></div><br>";
    }


}

?>

