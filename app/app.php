<?php
    date_default_timezone_set('America/Los_Angeles');
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Courses.php";
    require_once __DIR__."/../src/Student.php";
    require_once __DIR__."/../src/University.php";
    $app = new Silex\Application();
    $app['debug'] = true;
    $server = 'mysql:host=localhost;dbname=university_registrar';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);
    $app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path' => __DIR__.'/../views'));
    $app->register(new Silex\Provider\UrlGeneratorServiceProvider());

    $app->get("/", function() use ($app) {
        return $app['twig']->render('home.html.twig', array('students' => Student::getAll(), 'courses' => Courses::getAll(), 'university' => Department::getAll()));
    });
    $app->post("/add_student", function() use ($app) {
        $new_student_name = $_POST['name'];
        $new_major = $_POST['major'];
        $new_enrollment_date = $_POST['enrollment_date'];
        $new_student = new Student($new_student_name, $new_major, $new_enrollment_date);
        $new_student->save();
        return $app->redirect("/");
    });
    $app->post("/add_courses", function() use ($app){
        $new_courses = new Courses($_POST['courses'], $_POST['completion']);
        $new_courses->save();
        return $app->redirect("/");
      });
    $app->post("/delete_all_students", function() use ($app) {
        Student::deleteAll();
        return $app->redirect("/");
    });
    $app->post("/add_Department", function() use ($app){
        $new_department = new Department($_POST['flight_number'], $_POST['departure_time'], $_POST['flight_status']);
        $new_department->save();
        return $app->redirect("/");
    });
    $app->post("/delete_all_courses", function() use ($app){
        Courses::deleteAll();
        return $app->redirect("/");
    });

    $app->get('/student/{id}', function($id) use ($app) {
      $student = Student::find($id);
      $courses = Courses::getAll();
      $studentCourses = $student->getCourses();
      return $app['twig']->render('student.html.twig', array('student' =>$student, 'courses' =>$courses, 'studentCourses' => $studentCourses));
    })
    ->bind('student');

    $app->post('/student/addCourse', function() use ($app) {
      $course = Courses::find($_POST['course']);
      $student = Student::find($_POST['studentId']);
      $student->addCourse($course);
      return $app->redirect($app['url_generator']->generate('student', array('id' => $student->getId())));
    });
    return $app;
 ?>
