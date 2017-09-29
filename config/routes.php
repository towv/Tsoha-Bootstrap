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

$routes->get('/courses/:id/edit', function($id) {
    CourseController::edit($id);
});

$routes->post('/courses/:id/edit', function($id) {
    CourseController::update($id);
});

$routes->post('/courses/:id/destroy', function($id) {
    CourseController::destroy($id);
});

$routes->get('/courses/:id/delete', function($id) {
    CourseController::delete($id);
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

$routes->get('/holeinones', function() {
    HoleinoneController::index();
});

$routes->post('/holeinones', function() {
    HoleinoneController::store();
});

$routes->get('/holeinones/add_holeinones', function() {
    HoleinoneController::create();
});

$routes->get('/holeinones/:id', function($id) {
    HoleinoneController::show($id);
});

$routes->get('/records', function() {
    RecordController::index();
});

$routes->get('/records/add_record', function() {
    RecordController::create();
});

$routes->get('/records/my', function() {
    RecordController::my();
});

$routes->post('/records/my', function() {
    RecordController::store();
});

$routes->get('/register', function() {
    GolferController::create();
});

$routes->post('/register', function() {
    GolferController::store();
});

$routes->get('/login', function() {
    GolferController::login();
});

$routes->post('/login', function() {
    GolferController::handle_login();
});

$routes->get('/delete', function() {
    HelloWorldController::delete();
});

$routes->get('/records/edit_record', function() {
    HelloWorldController::edit_record();
});

$routes->get('/teams/show_team/edit_team', function() {
    HelloWorldController::edit_team();
});

$routes->get('/holeinones/show_holeinone/edit_holeinone', function() {
    HelloWorldController::edit_holeinone();
});

