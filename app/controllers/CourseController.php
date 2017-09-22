<?php
require 'app/models/course.php';
class CourseController extends BaseController {

    public static function index() {
        $courses = Course::all();

        View::make('course/courses.html', array('courses' => $courses));
    }
    
    public static function show($id) {
        $course = Course::find($id);
        View::make('course/show_course.html', array('course' => $course));
    }

    public static function store() {
        $params = $_POST;

        $course = new Course(array(
            'name' => $params['name'],
            'holes' => $params['holes'],
            'par' => $params['par'],
            'location' => $params['location'],
            'description' => $params['description']
        ));

        $course->save();
        
        Redirect::to('/courses');

//        Redirect::to('/courses/' . $course->id, array('message' => 'Uusi rata lisätty!'));
    }

    public static function create() {
        View::make('course/add_course.html');
    }

}
