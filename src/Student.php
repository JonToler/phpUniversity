
<?php
    class Student
    {
        private $id;
        private $student_name;
        private $major;
        private $enrollment_date;
        function __construct($student_name, $major= null, $enrollment_date = null, $id = null)
        {
        $this->student_name = $student_name;
        $this->major = $major;
        $this->enrollment_date = $enrollment_date;
        $this->id = $id;
        }
        //getters & setters
        function getId()
        {
            return $this->id;
        }
        function getStudentName()
        {
            return $this->student_name;
        }
        function setEnrollmentDate($enrollment_date)
        {
            $this->enrollment_date = (string) $new_enrollment_date;
        }

        function getEnrollmentDate()
        {
            return $this->enrollment_date;
        }
        function getMajor()
        {
            return $this->major;
        }
        function setMajor($new_major)
        {
            $this->major = (string) $new_major;
        }

//methods
        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO student (name, major, enrollment_date) VALUES ('{$this->getStudentName()}', '{$this->getMajor()}',     '{$this->getEnrollmentDate()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function find($search_id)
        {
            $found_student = null;
            $students = Student::getAll();
            foreach($students as $student) {
                $student_id = $student->getId();
                if ($student_id == $search_id) {
                    $found_student = $student;
                }
            }
           return $found_student;
         }
//static methods
        static function getAll()
        {
            $returned_students = $GLOBALS['DB']->query("SELECT * FROM student;");
            $students = array();
            foreach($returned_students as $student) {
                $student_name = $student['name'];
                $major = $student['major'];
                $enrollment_date = $student['enrollment_date'];
                $id = $student['id'];
                $new_student = new Student($student_name, $major, $enrollment_date, $id);
                array_push($students, $new_student);
            }
            return $students;
        }
        static function deleteAll()
        {
        $GLOBALS['DB']->exec("DELETE FROM student;");
         }


        function delete()
        {
           $GLOBALS['DB']->exec("DELETE FROM student WHERE id = {$this->getId()};");
        }
    }

?>
