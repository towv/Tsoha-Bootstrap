<?php

$routes->get('/', function() {
    HelloWorldController::index();
});

$routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
});

$routes->get('/courses', function() {
    CourseController::index();
});

$routes->post('/courses', function() {
    CourseController::store();
});

$routes->get('/courses/add_course', function() {
    CourseController::create();
});

$routes->get('/courses/:id', function($id) {
    CourseController::show($id);
});

$routes->get('/teams', function() {
    TeamController::index();
});

$routes->post('/teams', function() {
    TeamController::store();
});

$routes->get('/teams/add_team', function() {
    TeamController::create();
});

$routes->get('/teams/:id', function($id) {
    TeamController::show($id);
});

$routes->get('/register', function() {
    HelloWorldController::register();
});

$routes->get('/login', function() {
    HelloWorldController::login();
});

$routes->get('/delete', function() {
    HelloWorldController::delete();
});

$routes->get('/records', function() {
    HelloWorldController::records_player();
});

$routes->get('/records/1', function() {
    HelloWorldController::records_other();
});

$routes->get('/holeinones', function() {
    HelloWorldController::holeinones();
});

$routes->get('/records/edit_record', function() {
    HelloWorldController::edit_record();
});

$routes->get('/records/add_record', function() {
    HelloWorldController::add_record();
});

$routes->get('/holeinones/add_holeinones', function() {
    HelloWorldController::add_holeinones();
});

$routes->get('/courses/show_course', function() {
    HelloWorldController::show_course();
});

$routes->get('/holeinones/show_holeinone', function() {
    HelloWorldController::show_holeinone();
});

$routes->get('/courses/show_course/edit_course', function() {
    HelloWorldController::edit_course();
});

$routes->get('/teams/show_team/edit_team', function() {
    HelloWorldController::edit_team();
});

$routes->get('/holeinones/show_holeinone/edit_holeinone', function() {
    HelloWorldController::edit_holeinone();
});

