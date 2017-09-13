<?php

  class HelloWorldController extends BaseController{

    public static function index(){
      // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
   	  //View::make('home.html');
      echo 'Tämä on etusivu!';
    }

    public static function sandbox(){
      // Testaa koodiasi täällä
      //echo 'Hello World!';
      View::make('helloworld.html');
    }

    public static function course_show(){
    View::make('suunnitelmat/course_show.html');
    }

    public static function records_player(){
    View::make('suunnitelmat/records_player.html');
    }

    public static function edit_course_show(){
      View::make('suunnitelmat/edit_course_show.html');
    }

    public static function login(){
      View::make('suunnitelmat/login.html');
    }
  }
