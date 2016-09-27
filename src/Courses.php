
<?php
    class Courses
    {
        private $id;
        private $courses_name;
        private $completion;

        function __construct($courses_name, $completion="pass", $id = null)
        {
        $this->courses_name = $courses_name;
        $this->completion = $completion;
        $this->id = $id;
        }
        //getters & setters
        function getId()
        {
            return $this->id;
        }
        function getCourseName()
        {
            return $this->courses_name;
        }
        function getCompletion()
        {
            return $this->completion;
        }


//methods
        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO courses (course_name,completion) VALUES ('{$this->getCourseName()}', '{$this->getCompletion()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function find($search_id)
        {
            $found_courses = null;
            $coursess = Courses::getAll();
            foreach($coursess as $courses) {
                $courses_id = $courses->getId();
                if ($courses_id == $search_id) {
                    $found_courses = $courses;
                }
            }
           return $found_courses;
         }
//static methods
        static function getAll()
        {
            $returned_coursess = $GLOBALS['DB']->query("SELECT * FROM courses;");
            $coursess = array();
            foreach($returned_coursess as $courses) {
                $courses_name = $courses['course_name'];
                $completion = $courses['completion'];
                $id = $courses['id'];
                $new_courses = new courses($courses_name, $completion, $id);
                array_push($coursess, $new_courses);
            }
            return $coursess;
        }
        static function deleteAll()
        {
        $GLOBALS['DB']->exec("DELETE FROM courses;");
         }


        function delete()
        {
           $GLOBALS['DB']->exec("DELETE FROM courses WHERE id = {$this->getId()};");
        }
    }

?>
