<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    require_once "src/Student.php";
    $server = 'mysql:host=localhost;dbname=university_registrar_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);
    class StudentTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Student::deleteAll();
        }
        function test_getStudentName()
        {
            //Arrange
            // no need to pass in id because it is null by default.
            $student_name = "Bill";
            $test_student = new Student($student_name, "biology", "2016-10-02");
            //Act
            $result = $test_student->getStudentName();
            //Assert
            // id is null here, but that is not what we are testing. We are only interested in Student number.
            $this->assertEquals($student_name, $result);
        }
        // Test your getters and setters.
        function test_getId()
        {
            //Arrange
            $id = 1;
            $student_name = "Bill";
            $test_student = new Student($student_name, "biology", "2016-10-02",  $id);
            //Act
            $result = $test_student->getId();
            //Assert
            $this->assertEquals($id, $result); //make sure id returned is the one we put in, not null.
        }
        function test_save()
        {
            //Arrange
            $student_name = "Ted";
            $test_student = new Student($student_name, "biology", "2016-10-02");
            $test_student->save(); // id gets created by database and written in during save method.
            //Act
            $result = Student::getAll();
            //Assert
            $this->assertEquals($test_student, $result[0]);
        }
        function test_getAll()
        {
            //Arrange
            // create more than one student to make sure getAll returns them all.
            $student_name = "Ted";
            $student_name2 = "Bill";
            $test_student = new Student($student_name, "biology", "2016-10-02");
            $test_student->save();
            $test_student2 = new Student($student_name2, "chemistry",  "2016-09-15");
            $test_student2->save();
            //Act
            $result = Student::getAll();
            //Assert
            $this->assertEquals([$test_student, $test_student2], $result);
        }
        function testFind()
        {
            //Arrange
            $student_name = "Bill";
            $id = 1;
            $test_student = new Student($student_name, "biology", "2016-10-02");
            $test_student->save();
            $student_name2 = "Ted";
            $id2 = 2;
            $test_student2 = new Student($student_name2, "chemistry",  "2016-09-15");
            $test_student2->save();
            //Act
            $result = Student::find($test_student->getId());
            //Assert
            $this->assertEquals($test_student, $result);
        }
        function testDelete()
        {
            //Arrange
            $student_name = "Bill";
            $id = 1;
            $test_student = new Student($student_name, "biology", "2016-10-02");
            $test_student->save();
            $student_name2 = "Ted";
            $id2 = 2;
            $test_student2 = new Student($student_name2, "chemistry",  "2016-09-15");
            $test_student2->save();
            //Act
            $test_student->delete();
            $result = Student::getAll();
            //Assert
            $this->assertEquals([$test_student2], $result);
        }
        function test_deleteAll()
        {
            //Arrange
            // create more than one student
            $student_name = "Bill";
            $student_name2 = "Ted";
            $test_student = new Student($student_name);
            $test_student->save();
            $test_student2 = new Student($student_name2);
            $test_student2->save();
            //Act
            Student::deleteAll(); // delete them.
            $result = Student::getAll(); // get all to make sure they are gone.
            //Assert
            $this->assertEquals([], $result);
        }
    }
?>
