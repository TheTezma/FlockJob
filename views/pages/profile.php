<?php
$Mustache = new Mustache_Engine;
$_SESSION['lastsearch'] = $_SERVER['REQUEST_URI'];
// echo $Mustache->render('Hello, {{planet}}!', array('planet' => 'World'));
?>
<div class="container-fluid" ng-controller="Profile">
	<?php
	require_once 'views/elements/topnav.php';
	?>
	<div class="navigation">
		<div class="nav-row">
			<ul class="nav-ul">
				<li><a class="logo" href="/">FlockJob</a></li>
			</ul>

			<div class="nav-search">
				<form action="/search" style="margin:0;display: table-cell; vertical-align: middle; height: 75px; width: 900px; padding-left: 160px;">
					<input class="input-field" type="text" name="job" placeholder="Job Title">
					<input class="input-field" type="text" name="location" placeholder="Location">
					<input type="text" name="minsal" value="0" hidden>
					<input class="input-submit fa" type="submit" value="&#xf002;">
				</form>
			</div>
		</div>
	</div>
	<div class="row" style="margin-top: 25px;">
		<div class="col-sm-3">

		</div>
		<div class="col-sm-6">
			<div class="panel panel-default">
				<div class="panel-body">
					<strong>COMING SOON</strong>
				</div>
			</div>
		</div>
		<div class="col-sm-3">
			
		</div>
	</div>
</div>