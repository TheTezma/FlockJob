<?php
$Mustache = new Mustache_Engine;
$_SESSION['lastsearch'] = $_SERVER['REQUEST_URI'];
// echo $Mustache->render('Hello, {{planet}}!', array('planet' => 'World'));
?>
<div class="home-nav">
	<ul class="home-nav-ul">
		<li><a class="home-logo" href=".">FlockJob</a></li>
	</ul>

	<div class="home-nav-search">
		<?php
		if(empty($_SESSION['user'])) {
			echo $Mustache->render('<a href="/login">Login</a> {{sep}} <a href="/register">Register</a>', array("sep" => "/"));
		} else {
			echo $Mustache->render('<a>{{name}}</a>', array("name" => $_SESSION['user']['name']));
		}
		?>
	</div>
</div>

<div class="parallax"></div>

<div class="home-container">
	<div class="search-panel">
		<form action="/search" class="home-form">
			<strong>Search jobs</strong><br>
			<input class="home-input-field" type="text" name="job" placeholder="Job Title">
			<input class="home-input-field" type="text" name="location" placeholder="Location">
			<input type="text" name="minsal" value="0" hidden>
			<input class="home-input-submit fa" type="submit" value="&#xf002;">
		</form>
	</div>
</div>