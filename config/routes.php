<?php

  $routes->get('/', function() {
    HelloWorldController::index();
  });

  $routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
  });

  $routes->get('/records', function() {
  HelloWorldController::records_player();
});
$routes->get('/records/1', function() {
  HelloWorldController::course_show();
});

$routes->get('/records/1/1', function() {
  HelloWorldController::edit_course_show();
});

$routes->get('/login', function() {
  HelloWorldController::login();
});

$routes->get('/login', function() {
  HelloWorldController::login();
});