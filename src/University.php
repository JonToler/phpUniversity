
<?php
    class Department
    {
        private $id;
        private $department_name;

        function __construct($department_name, $id = null)
        {
        $this->department_name = $department_name;
        $this->id = $id;
        }
        //getters & setters
        function getId()
        {
            return $this->id;
        }
        function getDepartmentName()
        {
            return $this->department_name;
        }


//methods
        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO university (department) VALUES ('{$this->getdepartmentName()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function find($search_id)
        {
            $found_department = null;
            $departments = department::getAll();
            foreach($departments as $department) {
                $department_id = $department->getId();
                if ($department_id == $search_id) {
                    $found_department = $department;
                }
            }
           return $found_department;
         }
//static methods
        static function getAll()
        {
            $returned_departments = $GLOBALS['DB']->query("SELECT * FROM university;");
            $departments = array();
            foreach($returned_departments as $department) {
                $department_name = $department['department'];
                $id = $department['id'];
                $new_department = new department($department_name, $id);
                array_push($departments, $new_department);
            }
            return $departments;
        }
        static function deleteAll()
        {
        $GLOBALS['DB']->exec("DELETE FROM university;");
         }


        function delete()
        {
           $GLOBALS['DB']->exec("DELETE FROM university WHERE id = {$this->getId()};");
        }
    }

?>
