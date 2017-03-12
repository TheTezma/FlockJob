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