<?php

function check_logged_in() {
    BaseController::check_logged_in();
}

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

$routes->get('/teams/:id/edit', function($id) {
    TeamController::edit($id);
});

$routes->post('/teams/:id/edit', function($id) {
    TeamController::update($id);
});

$routes->post('/teams/:id/destroy', function($id) {
    TeamController::destroy($id);
});

$routes->post('/teams/:id/join', 'check_logged_in', function($id) {
    MemberController::store($id);
});

$routes->post('/teams/:id/leave', 'check_logged_in', function($id) {
    MemberController::destroy($id);
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

$routes->get('/holeinones/:id/edit', function($id) {
    HoleinoneController::edit($id);
});

$routes->post('/holeinones/:id/edit', function($id) {
    HoleinoneController::update($id);
});

$routes->post('/holeinones/:id/destroy', function($id) {
    HoleinoneController::destroy($id);
});

$routes->get('/records', function() {
    RecordController::index();
});

$routes->post('/records', function() {
    RecordController::index();
});

$routes->get('/records/add_record', function() {
    RecordController::create();
});

$routes->get('/records/my', 'check_logged_in', function() {
    RecordController::my();
});

$routes->post('/records/my', function() {
    RecordController::store();
});

$routes->post('/records/:id/destroy', function($id) {
    RecordController::destroy($id);
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

$routes->post('/logout', function() {
    GolferController::logout();
});

$routes->get('/golfers', function() {
    GolferController::index();
});

$routes->get('/delete', function() {
    HelloWorldController::delete();
});

$routes->get('/records/edit_record', function() {
    HelloWorldController::edit_record();
});

