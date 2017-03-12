<?php

class User {

	public $userid;
	public $username;
	public $loggedin;

	public static function isLoggedin() {
		if(empty($_SESSION['user'])) {
			$loggedin = 'false';
            $UserArray = array("LoggedIn" => "false");
		} else {
			$loggedin = 'true';
			User::userData();
            $UserArray = array("LoggedIn" => "true",
                               "name" => $_SESSION['user']['name']);
		}
	}

	public static function userData() {
		$sessid = $_SESSION['user']['id'];

		$db = Db::getInstance();
		$req = $db->query("SELECT * FROM users WHERE id = '$sessid'");
		$req->execute();
		$user = $req->fetch();

		return new User($user['id'], $user['name']);
	}

	public static function login() {
		$username = $_GET['username'];
		$password = $_GET['password'];

		$Cleanpassword = strip_tags($password);

		$db = Db::getInstance();
		try 
        { 
            // Execute the query against the database 
            $stmt = $db->prepare("SELECT * FROM users WHERE name = '$username'"); 
            $result = $stmt->execute(); 
        } 
        catch(PDOException $ex) 
        { 
            // Note: On a production website, you should not output $ex->getMessage(). 
            // It may provide an attacker with helpful information about your code.  
            die("Failed to run query: " . $ex->getMessage()); 
        } 

		$login_ok = false;

		$row = $stmt->fetch(); 

		if($row) {
			$check_password = hash('sha256', $password . $row['salt']); 
            for($round = 0; $round < 65536; $round++) 
            { 
                $check_password = hash('sha256', $check_password . $row['salt']); 
            } 
             
            if($check_password === $row['password']) 
            { 
                // If they do, then we flip this to true 
                $login_ok = true; 
            }
        } 
         
        // If the user logged in successfully, then we send them to the private members-only page 
        // Otherwise, we display a login failed message and show the login form again 
        if($login_ok) 
        { 
            // Here I am preparing to store the $row array into the $_SESSION by 
            // removing the salt and password values from it.  Although $_SESSION is 
            // stored on the server-side, there is no reason to store sensitive values 
            // in it unless you have to.  Thus, it is best practice to remove these 
            // sensitive values first. 
            unset($row['salt']); 
            unset($row['password']); 
             
            // This stores the user's data into the session at the index 'user'. 
            // We will check this index on the private members-only page to determine whether 
            // or not the user is logged in.  We can also use it to retrieve 
            // the user's details. 
            $_SESSION['user'] = $row;

            $User = User::isLoggedin();
             
            // Redirect the user to the private members-only page. 
            ?>
            <script type="text/javascript">
            window.location.href = '/';
            </script>
            <?php
            die("Redirecting to: ."); 
        } 
        else 
        { 
            // Tell the user they failed 
            print("Login Failed."); 
             
            // Show them their username again so all they have to do is enter a new 
            // password.  The use of htmlentities prevents XSS attacks.  You should 
            // always use htmlentities on user submitted values before displaying them 
            // to any users (including the user that submitted them).  For more information: 
            // http://en.wikipedia.org/wiki/XSS_attack 
            $submitted_username = htmlentities($username , ENT_QUOTES, 'UTF-8'); 
        } 

	}


	public static function register() {
		$db = Db::getInstance();

		$username = $_GET['username'];
		$email = $_GET['email'];
		$password = $_GET['password'];

		 if(empty($_GET['username'])) 
        { 
            // Note that die() is generally a terrible way of handling user errors 
            // like this.  It is much better to display the error with the form 
            // and allow the user to correct their mistake.  However, that is an 
            // exercise for you to implement yourself. 
            die("Please enter a username."); 
        } 
         
        // Ensure that the user has entered a non-empty password 
        if(empty($_GET['password'])) 
        { 
            die("Please enter a password."); 
        } 
         
        // Make sure the user entered a valid E-Mail address 
        // filter_var is a useful PHP function for validating form input, see: 
        // http://us.php.net/manual/en/function.filter-var.php 
        // http://us.php.net/manual/en/filter.filters.php 
        if(!filter_var($_GET['email'], FILTER_VALIDATE_EMAIL)) 
        { 
            die("Invalid E-Mail Address"); 
        } 
         
        // Now we perform the same type of check for the email address, in order 
        // to ensure that it is unique. 
        $query = " 
            SELECT 
                1 
            FROM users 
            WHERE 
                email = :email 
        "; 
         
        $query_params = array( 
            ':email' => $_GET['email'] 
        ); 
         
        try 
        { 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex) 
        { 
            die("Failed to run query: " . $ex->getMessage()); 
        } 
         
        $row = $stmt->fetch(); 
         
        if($row) 
        { 
            die("This email address is already registered"); 
        } 
         
        // An INSERT query is used to add new rows to a database table.
        // Again, we are using special tokens (technically called parameters) to 
        // protect against SQL injection attacks. 
        $query = " 
            INSERT INTO users ( 
                name, 
                password, 
                salt, 
                email 
            ) VALUES ( 
                :username, 
                :password, 
                :salt, 
                :email 
            ) 
        "; 
         
        // A salt is randomly generated here to protect again brute force attacks 
        // and rainbow table attacks.  The following statement generates a hex 
        // representation of an 8 byte salt.  Representing this in hex provides 
        // no additional security, but makes it easier for humans to read. 
        // For more information: 
        // http://en.wikipedia.org/wiki/Salt_%28cryptography%29 
        // http://en.wikipedia.org/wiki/Brute-force_attack 
        // http://en.wikipedia.org/wiki/Rainbow_table 
        $salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647)); 
         
        // This hashes the password with the salt so that it can be stored securely 
        // in your database.  The output of this next statement is a 64 byte hex 
        // string representing the 32 byte sha256 hash of the password.  The original 
        // password cannot be recovered from the hash.  For more information: 
        // http://en.wikipedia.org/wiki/Cryptographic_hash_function 
        $password = hash('sha256', $_GET['password'] . $salt); 
         
        // Next we hash the hash value 65536 more times.  The purpose of this is to 
        // protect against brute force attacks.  Now an attacker must compute the hash 65537 
        // times for each guess they make against a password, whereas if the password 
        // were hashed only once the attacker would have been able to make 65537 different  
        // guesses in the same amount of time instead of only one. 
        for($round = 0; $round < 65536; $round++) 
        { 
            $password = hash('sha256', $password . $salt); 
        } 
         
        // Here we prepare our tokens for insertion into the SQL query.  We do not 
        // store the original password; only the hashed version of it.  We do store 
        // the salt (in its plaintext form; this is not a security risk). 
        $query_params = array( 
            ':username' => $_GET['username'], 
            ':password' => $password, 
            ':salt' => $salt, 
            ':email' => $_GET['email'] 
        ); 
         
        try 
        { 
            // Execute the query to create the user 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex) 
        { 
            // Note: On a production website, you should not output $ex->getMessage(). 
            // It may provide an attacker with helpful information about your code.  
            die("Failed to run query: " . $ex->getMessage()); 
        } 
         
        // This redirects the user back to the login page after they register 
        ?>
            <script type="text/javascript">
            window.location.href = '/login';
            </script>
            <?php
         
        // Calling die or exit after performing a redirect using the header function 
        // is critical.  The rest of your PHP script will continue to execute and 
        // will be sent to the user if you do not die or exit. 
        die("Redirecting to login");
	}

	public static function logout() {
		unset($_SESSION['user']);

	    // Otherwise, we unset all of the session variables.
	    $_SESSION = array();

	    // If it's desired to kill the session, also delete the session cookie.
	    // Note: This will destroy the session, and not just the session data!
	    if (ini_get("session.use_cookies")) {
	        $params = session_get_cookie_params();
	        setcookie(session_name(), '', time() - 42000,
	            $params["path"], $params["domain"],
	            $params["secure"], $params["httponly"]
	        );
	    }

	    // Finally, destroy the session.
	    session_destroy();

	    // Whether we destroy the session or not, we redirect them to the login page
	    ?>
            <script type="text/javascript">
            window.location.href = '/login';
            </script>
            <?php
	    die("Redirecting to: login");
	}

    public static function accountsetup() {
        $db = Db::getInstance();

        $sessid = $_SESSION['user']['id'];

        $stmt = $db->query("SELECT * FROM posts WHERE author = '$sessid'");
        $stmt->execute();
        $rows = $stmt->rowCount();

        if($rows >= 1):
            ?>  <span>
                    <span class="checked">&#10004;</span>
                    <strike>Ask your first question</strike>
                </span> <?php
        elseif($rows == 0):
            ?>  <span>
                    <span class="unchecked">&#10004;</span>
                    <a href="new-post">Ask your first question</a>
                </span> <?php
        endif;
    }

}

?>