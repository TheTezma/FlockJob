<?php
class PostsController {
    
    public function index() {
        $posts = Post::all();
        require_once('views/posts/index.php');
    }
    
    public function show() {
        if(!isset($_GET['id']))
            return call('pages', 'error');
        
        $post = Post::find($_GET['id']);
        require_once('views/posts/show.php');
    }
    
    public function newpost() {
        if(!isset($_GET['title']))
            return call('pages', 'error');
        
        if(isset($_GET['content']))
            $postContext = $_GET['content'];
        else
            $postContext = "NULL";
        
        $postTitle     = $_GET['title'];
        $postUserID    = $_SESSION['user']['id'];
        $postTopic     = $_GET['topic'];
        $postTimestamp = Time();
        
        Post::newpost($postTopic, $postTitle, $postContext, $postTimestamp, $postUserID);
    }
    
    public function vote() {
        if(!isset($_GET['id']))
            return call('pages', 'error');
        
        $voteID = $_GET['id'];
        $UserID = $_SESSION['user']['id'];
        
        Post::vote($voteID, $UserID);
    }
    
    public function check() {
        $voteID = $_GET['id'];
        $UserID = $_SESSION['user']['id'];
        
        Post::voteCheck($voteID, $UserID);
    }
    
}
?>