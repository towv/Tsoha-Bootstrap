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

        $attributes = array(
            'name' => $params['name'],
            'holes' => $params['holes'],
            'par' => $params['par'],
            'location' => $params['location'],
            'description' => $params['description']
        );

        $course = new Course($attributes);
        $errors = $course->errors();

        if (count($errors) == 0) {
            $course->save();
            Redirect::to('/courses');
        } else {
            View::make('course/add_course.html', array('errors' => $errors, 'attributes' => $attributes));
        }



//        $course = new Course(array(
//            'name' => $params['name'],
//            'holes' => $params['holes'],
//            'par' => $params['par'],
//            'location' => $params['location'],
//            'description' => $params['description']
//        ));
//
//        $course->save();
//
//        Redirect::to('/courses');
//        Redirect::to('/courses/' . $course->id, array('message' => 'Uusi rata lisätty!'));
    }

    public static function create() {
        View::make('course/add_course.html');
    }

    // Radan muokkaaminen (lomakkeen esittäminen)
    public static function edit($id) {
        $course = Course::find($id);
        View::make('course/edit_course.html', array('attributes' => $course[0]));
    }

    // Radan muokkaaminen (lomakkeen käsittely)
    public static function update($id) {
        $params = $_POST;

        $attributes = array(
            'id' => $id,
            'name' => $params['name'],
            'holes' => $params['holes'],
            'par' => $params['par'],
            'location' => $params['location'],
            'description' => $params['description']
        );
        // Alustetaan Rata-olio käyttäjän syöttämillä tiedoilla
        $course = new Course($attributes);
        $errors = $course->errors();

        if (count($errors) > 0) {
            View::make('/course/edit_course.html', array('errors' => $errors, 'attributes' => $attributes));
        } else {
            // Kutsutaan alustetun olion update-metodia, joka päivittää pelin tiedot tietokannassa
            $course->update();
            Redirect::to('/courses/' . $course->id, array('message' => 'Rataa on nyt muokattu.'));
        }
    }

    //Radan poisto
    public static function destroy($id) {
        //Alustetaan Rata-olio annetulla ideellä
        $course = new Course(array('id' => $id));
        //Kutsutaan coursemodel eli Rata-malliluokan metodia destroy, joka poistaa radan sen ideellä
        $course->destroy();
        //Ohjataan käyttäjä ratojen listaussivulle ilmoituksen kera
        Redirect::to('/courses', array('message' => 'Rata on poistettu :('));
    }

    public static function delete($id) {
        $course = Course::find($id);
        View::make('course/delete.html', array('attributes' => $course[0]));
    }

}
