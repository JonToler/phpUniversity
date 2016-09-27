<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    require_once "src/Courses.php";
    $server = 'mysql:host=localhost;dbname=university_registrar_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);
    class CoursesTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Courses::deleteAll();
        }
        function test_getCourseName()
        {
            //Arrange
            // no need to pass in id because it is null by default.
            $courses_name = "Bio101";
            $test_courses = new Courses($courses_name);
            //Act
            $result = $test_courses->getCourseName();
            //Assert
            // id is null here, but that is not what we are testing. We are only interested in courses number.
            $this->assertEquals($courses_name, $result);
        }
        // Test your getters and setters.
        function test_getId()
        {
            //Arrange
            $id = 1;
            $courses_name = "Bio101";
            $test_courses = new Courses($courses_name, "pass", $id);
            //Act
            $result = $test_courses->getId();
            //Assert
            $this->assertEquals($id, $result); //make sure id returned is the one we put in, not null.
        }
        function test_save()
        {
            //Arrange
            $courses_name = "Bio101";
            $test_courses = new Courses($courses_name);
            $test_courses->save(); // id gets created by database and written in during save method.
            //Act
            $result = Courses::getAll();
            //Assert
            $this->assertEquals($test_courses, $result[0]);
        }
        function test_getAll()
        {
            //Arrange
            // create more than one courses to make sure getAll returns them all.
            $courses_name = "Bio101";
            $courses_name2 = "Chem101";
            $test_courses = new Courses($courses_name);
            $test_courses->save();
            $test_courses2 = new Courses($courses_name2);
            $test_courses2->save();
            //Act
            $result = Courses::getAll();
            //Assert
            $this->assertEquals([$test_courses, $test_courses2], $result);
        }
        function testFind()
        {
            //Arrange
            $courses_name = "Bio101";
            $id = 1;
            $test_courses = new Courses($courses_name);
            $test_courses->save();
            $courses_name2 = "Chem101";
            $id2 = 2;
            $test_courses2 = new Courses($courses_name2);
            $test_courses2->save();
            //Act
            $result = Courses::find($test_courses->getId());
            //Assert
            $this->assertEquals($test_courses, $result);
        }
        function testDelete()
        {
            //Arrange
            $courses_name = "Bio101";
            $id = 1;
            $test_courses = new Courses($courses_name);
            $test_courses->save();
            $courses_name2 = "Chem101";
            $id2 = 2;
            $test_courses2 = new Courses($courses_name2);
            $test_courses2->save();
            //Act
            $test_courses->delete();
            $result = Courses::getAll();
            //Assert
            $this->assertEquals([$test_courses2], $result);
        }
        function test_deleteAll()
        {
            //Arrange
            // create more than one courses
            $courses_name = "Bio101";
            $courses_name2 = "Chem101";
            $test_courses = new Courses($courses_name);
            $test_courses->save();
            $test_courses2 = new Courses($courses_name2);
            $test_courses2->save();
            //Act
            Courses::deleteAll(); // delete them.
            $result = Courses::getAll(); // get all to make sure they are gone.
            //Assert
            $this->assertEquals([], $result);
        }
    }
?>
