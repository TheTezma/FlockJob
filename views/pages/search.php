<?php
$Mustache = new Mustache_Engine;
$_SESSION['lastsearch'] = $_SERVER['REQUEST_URI'];
// echo $Mustache->render('Hello, {{planet}}!', array('planet' => 'World'));
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
	<div class="result-info-row">
		<span ng-cloak>{{ TopInfo }}</span>
	</div>
	<div class="row">
		<div class="col-sm-3">
			<div class="panel panel-default">
				<div class="panel-body">
					<strong style="font-size: 18px;">Salary</strong>

					<span ng-repeat="slider in sliders track by $index"><br>
						<span ng-cloak class="slider-salary">{{slider.value | currency:"$":0}}</span>
				    	<input ng-init="slider.value = salary" type="range" ng-model="slider.value" min="0" max="200000" step="5000" onchange="SalarySearch(this.value)">
				    </span>
				</div>
			</div>
		</div>
		<div class="col-sm-6">
			<div class="srt">
				<span ng-cloak>{{ JobCount }} results</span>
			</div>	
			<div class="center-panel">
				<div class="job-panel" ng-repeat="x in Jobs" ng-cloak>
					<div class="job-panel-header">
						<a href="/details/{{ x.id }}" ng-cloak>{{ x.title }}</a>
					</div>
					<div class="job-panel-subheader">
						<span class="company" ng-cloak>{{ x.company }}</span> - 
						<span class="location" ng-cloak>{{ x.location }}</span>
					</div>
					<div class="job-panel-shortdesc">
						<span ng-cloak>{{ x.description }}</span>
					</div>
					<div class="job-panel-footer">
						<a href="/details/{{ x.id }}" ng-cloak>More Details »</a>
					</div>
				</div>
				<?php
				// foreach($Jobs as $Job):
				// 	echo $Mustache->render(
				// 		'<div class="job-panel">
				// 			<div class="job-panel-header"><a href="/details/{{id}}">{{title}}</a></div>
				// 			<div class="job-panel-subheader"><span class="company">{{company}}</span> - <span class="location">{{location}}</span></div>
				// 			<div class="job-panel-shortdesc">{{short-desc}}</div>
				// 			<div class="job-panel-footer"><a href="/details/{{id}}">More Details »</a></div>
				// 		</div>
				// 		', array(
				// 				"title" => $Job->title,
				// 				"company" => $Job->company,
				// 				"location" => $Job->location,
				// 				"short-desc" => substr($Job->description, 0, 140),
				// 				"id" => $Job->id
				// 				 ));
				// endforeach;
				?>
			</div>
		</div>
		<div class="col-sm-3">
			<div class="panel panel-default">
				<div class="panel-body">
					<?php
					// echo $Mustache->render('{{avgsalary}}', array("avgsalary" => Job::avg_salary())); 
					?>
					<div class="col-sm-6">
						<span ng-cloak>
							<strong class="averagesalary">{{ AverageSalary }}</strong><br>
							<span class="avgsal-sub">Average salary for jobs in Australia</span>
						</span>
					</div>
					<div class="col-sm-6">
						<img width="100" src="assets/images/dollar-bill.png">
					</div>
				</div>
			</div>
		</div>
	</div>
</div>