<!DOCTYPE html>
<html lang="en">
<head>
	<?php include 'head.php' ?>
</head>
<div class="wrapper-x">
	<body>

		<?php include 'header.php' ?>

	<!-- CONTENT -->
	<div id="general_content" class="blurb row container-fluid">
		<div class="col-md-4 col-md-offset-2">
			<h2> Our Mission </h2><hr>
			<p>
				"The Nikkei Student Union serves to organize both social and community service activities while promoting interaction and communication between students of Japanese ancestry, students interested in Japanese American culture, the UC Berkeley campus, and its surrounding communities."
			</p>


			<h3> Sign up for our mailing list here and stay up to date with NSU events! </h3>
			<form id="mailing_list_form" action="list_serve.php" method="POST">
				<div>
					<input name="name" type="text" placeholder="Name">
					<br>
				</div>
				<div>
					<input name="email" type="text" placeholder="Email">
					<br>
				</div>
				<div>
					<input id="form_submit" name="submit" type="submit" value="Send">
				</div>
			</form>



		</div>
		<div class="col-md-4">
			<h2> Our History </h2><hr>
			<p>
				UC Berkeley's Nikkei Student Union, founded in the spring of 2002, is the up and coming Japanese-American interest organization on campus. We are a one-of-a-kind organization melding our interests in our Japanese American heritage with social and community events. And no, you don't have to be Japanese to join!
			</p>
			<p>
					We put on events such as our annual Culture Show, the Day of Remembrance, and volunteer opportunities at the Cherry Blossom Festival. We also have joint socials with different student groups and play IM sports. Whether you are interested in getting involved in the JA community, looking to make friends, or want to play sports, we offer a variety of options for you. So feel free to check out our club.
			</p>
			<p>
				If you are interested in receiving more information about our club, refer to our contact page, and we will add you to our mailing list.
			</p>
			<h3> Join us on <a class="email" href="https://www.facebook.com/groups/NikkeiStudentUnion/" target="_blank"> Facebook! </a> </h3>
		</div>
	</div>
	<!-- CONTENT -->

	<?php include 'footer.php' ?>

	</body>
</div>
</html>