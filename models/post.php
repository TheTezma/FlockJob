<?php
class Post {
    // we define 3 attributes
    // they are public so that we can access them using $post->author directly
    public $id;
    public $title;
    public $author;
    public $content;
    public $timestamp;
    public $upvotes;

    public function __construct($id, $title, $author, $content, $timestamp, $upvotes) {
        $this->id = $id;
        $this->title = $title;
        $this->author = $author;
        $this->content = $content;
        $this->timestamp = $timestamp;
        $this->upvotes = $upvotes;
    }

    public static function all() {
        $list = [];
        $db = Db::getInstance();
        $req = $db->query('SELECT * FROM posts ORDER BY rand() LIMIT 15');
        // we create a list of Post objects from the database results
        foreach ($req->fetchAll() as $post) {
            $list[] = new Post($post['id'], $post['title'], $post['author'], $post['content'], $post['timestamp'], $post['upvotes']);
        }
        return $list;
    }

    public static function find($id) {
        $db = Db::getInstance();
        // we make sure $id is an integer
        $id = intval($id);
        $req = $db->prepare('SELECT * FROM posts WHERE id = :id');
        // the query was prepared, now we replace :id with our actual $id value
        $req->execute(array('id' => $id));
        $post = $req->fetch();
        return new Post($post['id'], $post['title'], $post['author'], $post['content'], $post['timestamp'], $post['upvotes']);
    }

    public static function newest() {
        $list = [];
        $db = Db::getInstance();
        $req = $db->query('SELECT * FROM posts ORDER BY timestamp DESC LIMIT 10');
        // we create a list of Post objects from the database results
        foreach ($req->fetchAll() as $newest) {
            $list[] = new Post($newest['id'], $newest['title'], $newest['author'], $newest['content'], $newest['timestamp'], $newest['upvotes']);
        }
        return $list;
    }

    public static function newpost($Topic, $Title, $Content, $Timestamp, $Author) {
        $db = Db::getInstance();
        $req = $db->prepare('INSERT INTO posts (topic, title, content, timestamp, author)
                           VALUES (?,?,?,?,?)');
        $req->execute([$Topic, $Title, $Content, $Timestamp, $Author]);
        $sql = "UPDATE topics SET score = score + ?, post_count = post_count + 1 WHERE name = ?";
        $db->prepare($sql)->execute(["3", $Topic]);
        header("Location: /QuoraClone");
        return call('pages', 'home');
    }

    public static function voteCheck($voteID, $UserID) {
        $db = Db::getInstance();
        $req = $db->prepare("SELECT * FROM upvotes WHERE post_id = ? AND user_id = ?");
        $req->execute([$voteID, $UserID]);
        $UserLiked = $req->rowCount();
        $stmt3 = $db->prepare("SELECT * FROM posts WHERE id = ?");
        $stmt3->execute([$voteID]);
        $Upvotes = $stmt3->fetch();
        if ($UserLiked < 1) {
            echo "8";
        } else {
            echo "1";
        }
    }
    
    public static function vote($voteID, $UserID) {
        $db = Db::getInstance();
        $req = $db->prepare("SELECT * FROM upvotes WHERE post_id = ? AND user_id = ?");
        $req->execute([$voteID, $UserID]);
        $UserLiked = $req->rowCount();
        if ($UserLiked < 1) {
            $Timestamp = Time();
            $stmt = $db->prepare("INSERT INTO upvotes (post_id, user_id, timestamp) VALUES (?,?, '$Timestamp')");
            $stmt->execute([$voteID, $UserID]);
            $stmt2 = $db->prepare("UPDATE posts SET upvotes = upvotes + 1 WHERE id = ?");
            $stmt2->execute([$voteID]);
            $stmt3 = $db->prepare("SELECT * FROM posts WHERE id = ?");
            $stmt3->execute([$voteID]);
            $Upvotes = $stmt3->fetch();
            $stmt4 = $db->prepare("UPDATE topics SET score = score + 2 WHERE name = ?");
            $UpvoteID = $Upvotes['topic'];
            $stmt4->execute([$UpvoteID]);
            echo "Upvoted | " . $Upvotes['upvotes'];
?>
        <script>
          $("#" + <?=$voteID ?>).attr('class', 'upvoted-btn');
        </script>
        <?php
        } else {
            $stmt = $db->prepare("DELETE FROM upvotes WHERE post_id = ? AND user_id = ?");
            $stmt->execute([$voteID, $UserID]);
            $stmt2 = $db->prepare("UPDATE posts SET upvotes = upvotes - 1 WHERE id = ?");
            $stmt2->execute([$voteID]);
            $stmt3 = $db->prepare("SELECT * FROM posts WHERE id = ?");
            $stmt3->execute([$voteID]);
            $Upvotes = $stmt3->fetch();
            $stmt4 = $db->prepare("UPDATE topics SET score = score - 2 WHERE name = ?");
            $UpvoteID = $Upvotes['topic'];
            $stmt4->execute([$UpvoteID]);
            echo "Upvote | " . $Upvotes['upvotes'];
?>
        <script>
          $("#" + <?=$voteID ?>).attr('class', 'upvote-btn');
        </script>
        <?php
        }
    }
}
?>