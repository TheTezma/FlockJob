<?php
  function call($controller, $action) {
    require_once('controllers/' . $controller . '_controller.php');

    switch($controller) {
      case 'pages':
        require_once 'models/jobs.php';
        require_once 'models/user.php';
        $controller = new PagesController();
      break;
      case 'posts':
        require_once('models/post.php');
        require_once 'models/user.php';
        $controller = new PostsController();
      break;
      case 'jobs':
        require_once 'models/jobs.php';
        require_once 'models/user.php';
        $controller = new JobsController();
      break;
      case 'users':
        require_once 'models/user.php';
        $controller = new UsersController();
      break;
      case 'topics':
        require_once 'models/topic.php';
        $controller = new TopicController();
      break;
    }

    $controller->{ $action }();
  }

  // we're adding an entry for the new controller and its actions
  $controllers = array(
      'pages' => ['home', 'error', 'login', 'register', 'jobs', 'search', 'advertise', 'profile'],
      'jobs'  => ['show'],
      'posts' => ['show', 'newpost', 'vote', 'check'],
      'users' => ['login', 'register', 'logout']);

  if (array_key_exists($controller, $controllers)) {
    if (in_array($action, $controllers[$controller])) {
      call($controller, $action);
    } else {
      call('pages', 'error');
    }
  } else {
    call('pages', 'error');
  }
?>
