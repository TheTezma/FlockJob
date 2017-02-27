<?php
  class PagesController {
    public function home() {
      $Jobs = Job::all();
      $userdata = User::isLoggedin();
      require_once 'views/pages/navigation.php';
      require_once('views/pages/home.php');
    }

    public function error() {
      require_once('views/pages/error.php');
    }

    public function login() {
      require_once 'views/pages/login.php';
    }

    public function register() {
      require_once 'views/pages/register.php';
    }

    public function newpost() {
      $userdata = User::isLoggedin();
      $newest = Post::newest();
      require_once 'views/pages/navigation.php';
      require_once 'views/pages/new-post.php';
    }

    public function jobs() {

    }

    public function jobdetails() {
      $Jobs = Job::show();
      $userdata = User::isLoggedin();
      require_once 'views/pages/jobdetails.php';
    }
  }
?>