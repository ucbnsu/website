<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include 'pages/head.php' ?>
        <link rel="icon" href="/favicon.ico" type="image/x-icon">
        <script src="http://code.jquery.com/jquery-git.js"></script>
        <script>
			$(document).ready(function(){
				$('#result').load('/pages/events.php #future');
			});
        </script>
    </head>
    <div class="wrapper-x">
		<body style="background-color:ghostwhite;">
			<?php include 'pages/header.php' ?>
			<?php include_once("pages/analyticstracking.php") ?>

			<div class="row">
				<div style="background-image: url(header.jpg); overflow:hidden; background-size: cover; background-position: center; height:auto;" />
					<img id="homepage_image" src="pictures/NSU_Logo.jpg" alt="" style="display:block; margin-left:auto; margin-right:auto; width:15%;" />
				</div>
			</div>
			<div class="row">
				<div class="container">

					<div class="blurb col-sm-6">
						<h3> Welcome to NSU!! </h3>
						<hr>
						<p>
							NSU is a club that seeks to promote and celebrate Japanese American Culture. We have community service events and a Fall Semester Culture Show 
							that seek to highlight Japanese American issues and perspectives. We also have fun events such as our annual Ski Trip to Lake Tahoe in the Spring. 
						</p>
						<p>
							There is no need to be Japanese or Japanese American to join! We welcome anyone who has an interest in Japanese American culture or is looking to learn more about it! 
						</p>
					</div>

					<div class="col-sm-6 text-center">
						<h3> Join our Mailing List! </h3>
						<?php include 'pages/signup_form.php' ?>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="container">
					<div class="blurb">
						<h3> Upcoming Events </h3>
						<hr>
						<a href="pages/events.php" id="link"> All Events </a>
						<div id="result"></div>
					</div>
				</div>
			</div>		
		<?php include 'pages/footer.php' ?>
		</body>
	</div>
</html>
