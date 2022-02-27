<?php

include 'group.php';

class Project
{
    public $id;
    public $title;
    public $num_of_groups;
    public $stud_per_group;

    public function __construct($id, $title, $nog, $spg)
    {
        $this->id = $id;
        $this->title = $title;
        $this->num_of_groups = $nog;
        $this->stud_per_group = $spg;
    }
    //Creates groups
    public function createGroups($database)
    {
        for ($i = 1; $i <= $this->num_of_groups; $i++) {
            $students = $database->getStudentsBelongingToAGroup($this->id, $i);
            $group = new Group($i,$this->stud_per_group, $students);
            $group->showGroup($database);
        }
    }
}

?>