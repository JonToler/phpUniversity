<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    require_once "src/University.php";
    $server = 'mysql:host=localhost;dbname=university_registrar_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);
    class DepartmentTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Department::deleteAll();
        }
        function test_getDepartmentName()
        {
            //Arrange
            // no need to pass in id because it is null by default.
            $department_name = "Biology";
            $test_department = new Department($department_name);
            //Act
            $result = $test_department->getDepartmentName();
            //Assert
            // id is null here, but that is not what we are testing. We are only interested in department number.
            $this->assertEquals($department_name, $result);
        }
        // Test your getters and setters.
        function test_getId()
        {
            //Arrange
            $id = 1;
            $department_name = "Biology";
            $test_department = new Department($department_name,  $id);
            //Act
            $result = $test_department->getId();
            //Assert
            $this->assertEquals($id, $result); //make sure id returned is the one we put in, not null.
        }
        function test_save()
        {
            //Arrange
            $department_name = "Biology";
            $test_department = new Department($department_name);
            $test_department->save(); // id gets created by database and written in during save method.
            //Act
            $result = department::getAll();
            //Assert
            $this->assertEquals($test_department, $result[0]);
        }
        function test_getAll()
        {
            //Arrange
            // create more than one department to make sure getAll returns them all.
            $department_name = "Biology";
            $department_name2 = "Chemistry";
            $test_department = new Department($department_name);
            $test_department->save();
            $test_department2 = new department($department_name2);
            $test_department2->save();
            //Act
            $result = department::getAll();
            //Assert
            $this->assertEquals([$test_department, $test_department2], $result);
        }
        function testFind()
        {
            //Arrange
            $department_name = "Biology";
            $id = 1;
            $test_department = new Department($department_name);
            $test_department->save();
            $department_name2 = "Chemistry";
            $id2 = 2;
            $test_department2 = new Department($department_name2);
            $test_department2->save();
            //Act
            $result = department::find($test_department->getId());
            //Assert
            $this->assertEquals($test_department, $result);
        }
        function testDelete()
        {
            //Arrange
            $department_name = "Biology";
            $id = 1;
            $test_department = new Department($department_name);
            $test_department->save();
            $department_name2 = "Chemistry";
            $id2 = 2;
            $test_department2 = new Department($department_name2);
            $test_department2->save();
            //Act
            $test_department->delete();
            $result = department::getAll();
            //Assert
            $this->assertEquals([$test_department2], $result);
        }
        function test_deleteAll()
        {
            //Arrange
            // create more than one department
            $department_name = "Biology";
            $department_name2 = "Chemistry";
            $test_department = new Department($department_name);
            $test_department->save();
            $test_department2 = new department($department_name2);
            $test_department2->save();
            //Act
            department::deleteAll(); // delete them.
            $result = department::getAll(); // get all to make sure they are gone.
            //Assert
            $this->assertEquals([], $result);
        }
    }
?>
