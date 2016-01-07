<nav class="navbar navbar-inverse">
	<div class="container-fluid">
		<div class="navbar-header">
			<a class="navbar-brand" href="#">Session</a>
		</div>
		<ul class="nav navbar-nav">
			<li class="<?php if($page == 'home') echo 'active'; ?>"><a href="home.php">Home</a></li>
			<li class="<?php if($page == 'friends') echo 'active'; ?>"><a href="#">Friends</a></li>
		</ul>
		<ul class="nav navbar-nav navbar-right">
			<li class="<?php if($page == 'profile') echo 'active'; ?>"><a href="profile.php">Profile</a></li>
			<li><a href="logout.php">Lougout</a></li>
		</ul>
	</div>
</nav>