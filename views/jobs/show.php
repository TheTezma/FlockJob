<?php
$Mustache = new Mustache_Engine();
?>
<div class="container-fluid">
	<div class="top-nav">
		<div class="nav-row">
			<ul class="top-nav-ul">
				<?php
				if(empty($_SESSION['user'])) {
					echo $Mustache->render('<a href="/login">Login</a> {{sep}} <a href="/register">Register</a>', array("sep" => "/"));
				} else {
					echo $Mustache->render('<a>{{name}}</a>', array("name" => $_SESSION['user']['name']));
				}
				?>
			</ul>
		</div>
	</div>
	<div class="navigation">
		<div class="nav-row">
			<ul class="nav-ul">
				<li><a class="logo" href="/">FlockJob</a></li>
			</ul>

			<div class="nav-search">
				<form action="/FlockJob/search" style="margin:0;display: table-cell; vertical-align: middle; height: 75px; width: 900px; padding-left: 160px;">
					<input class="input-field" type="text" name="job" placeholder="Job Title">
					<input class="input-field" type="text" name="location" placeholder="Location">
					<input class="input-submit fa" type="submit" value="&#xf002;">
				</form>
			</div>
		</div>
	</div>
	<div class="row" style="margin-top: 10px;">
		<div class="col-sm-8">
			<div class="inner-row">
				<?=
				$Mustache->render('<a href="{{lastsearch}}" class="btn btn-danger back">Back to last search</a>', array("lastsearch" => $_SESSION['lastsearch']));
				?>
				<?=
				$Mustache->render('<a href="/apply/{{id}}" class="btn btn-danger apply">Apply For This Job</a>', array("id" => $job->id));
				?>
			</div>
			<div class="job-info-section">
				<?= $Mustache->render('<span class="job-title">{{title}}</span>', array("title" => $job->title)); ?>
				<br>
				<?= $Mustache->render('<span class="job-location">{{location}}</span>', array("location" => $job->location)); ?>
				<br>
				<br>
				<?= $Mustache->render('<span class="job-description">{{description}}</span>', array("description" => $job->description)); ?>
			</div>
			<div class="bottom-row">
				<?= $Mustache->render('<a href="/apply/{{id}}" class="btn btn-danger apply-bot">Apply For This Job</a>', array("id" => $job->id)); ?>
			</div>
		</div>
		<div class="col-sm-4">
			<div class="panel panel-default">
				<div class="panel-heading">Share this job</div>
				<div class="panel-body">
					<div class="img-row">
						<div class="img-col">
							<img class="share-img" src="/assets/images/facebook-share.png">
						</div>
						<div class="img-col">
							<img class="share-img" src="/assets/images/twitter-share.png">
						</div>
						<div class="img-col">
							<img class="share-img" src="/assets/images/google-share.png">
						</div>
						<div class="img-col">
							<img class="share-img" src="/assets/images/linkedin-share.png">
						</div>
					</div>
				</div>
			</div>

			<div class="panel panel-default">
				<div class="panel-heading">Similar Jobs</div>
				<div class="panel-body">
					<div id="similar-jobs"></div>
				</div>
			</div>
		</div>
	</div>
</div>