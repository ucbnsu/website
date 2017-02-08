<?php
/*
Good Evening. It seems like you are here because you have succeeded me or a coup
has been staged and I've been incapacitated. In any case, you wish to edit the page
no? Well hopefully my comments can help.

If you can edit php and/or have programming experience, you should be able to figure it out
else read the comments
*/

// Must separate name and title by a ":", unless you know how to edit php
// The php function is called "explode"
$core_names = array(
			"John Okahata: President",
			"Michael Handa: External Vice President",
			"Kaitlin Hara: Internal Vice President",
			"Steven Veshkini: Historian",
			"Andrew Aikawa: Finance Coordinator",
			"Kayla Umemoto: Social Chair",
			"Nolan Takeshita: Issues Chair",
			"Kelly Hamamoto: Community Service Chair",
			"Alyssa Jolene: Publicity Chair",
			"Kaycee Ching: Culture Show Co-Chair",
			"Amy Fann: Culture Show Co-Chair ", //Added space as a hack LOL
			"Grace Yeo: Web and Graphics Chair");

// Name of the pictures in the pictures folder
// ../ Means to go up a folder (go back to "NSU" folder) and then it goes to "pictures"
$core_pics = array(
			" President" => "/pictures/core_president.png",
			" External Vice President" => "/pictures/core_external.png",
			" Internal Vice President" => "/pictures/core_internal.png",
			" Historian" => "/pictures/core_historian.png",
			" Finance Coordinator" => "/pictures/core_finance.png",
			" Social Chair" => "/pictures/core_social.png",
			" Issues Chair" => "/pictures/core_issues.png",
			" Community Service Chair" => "/pictures/core_community.png",
			" Publicity Chair" => "/pictures/core_publicity.png",
			" Culture Show Co-Chair" => "/pictures/core_culture2.png",
			" Culture Show Co-Chair " => "/pictures/core_culture1.png",
			" Web and Graphics Chair" => "/pictures/core_graphics.png"
			);

// You can add fields to the profile page just by adding to this
// You'll notice how some people have minors and some don't, use that as a guideline for adding
// Watch your commas
// Template:
/*
	array("Major: ",
			"Year: ",
			"SOME OTHER KOOKIE FIELD: EXCITING INFORMATION",
			"Why I Joined NSU: ",
			"Interests: ",
			"Contact: ",
			"Why I <3 NSU!: ");
*/

$core_data = array
(
	// John
	array("Major:  Electrical Engineering & Computer Science",
			"Year: Senior",
			"Why I Joined NSU: The flyer had Totoro on it and I was like, 'Hey I know what that is!'",
			"Interests: Hip Hop Dance, Yosakoi, Video Games, KPOP, JPOP, Let's Plays, Office Supplies, Perplexing things :), Social Analysis",
			"Contact: jokahata@berkeley.edu",
			"Why I <3 NSU!: I feel like I've found my home in NSU. And everyone can find someone to hang out with, whether it's fanboying over an anime, freaking out at Game of Thrones, or discussing something something philosphy something, there's always someone who's into it!"),
	// Michael
	array("Major: Public Health",
			"Minor: History",
			"Year: Senior",
			"Why I Joined NSU: I joined NSU because I grew up in a JA Community, and wanted to keep that environment.",
			"Interests: I like basketball, volleyball, Disney, the Raiders, the A's, the Warriors, and the Sharks. ",
			"Contact: michael_handa@berkeley.edu",
			"Why I <3 NSU!: I love NSU because it is like a second home. It's highly inclusive, and has allowed me to make many weird friends. You could be next!!!"),
	// Kaitlin
	array("Major: Molecular Environmental Biology (MEB)",
			"Year: Junior",
			"Why I Joined NSU: I joined NSU because Jon Kawasaki told me to. I stayed because NSU is awesome<3 :)",
			"Interests: Basketball, singing in the shower, drawing, taking derpy pictures of people and using it as blackmail",
			"Contact: khara@berkeley.edu",
			"Why I <3 NSU!:  We're like one big happy family ^_^"),
	// Steven
	array("Major: EECS",
			"Minor: Japanese",
			 "Year: Sophmore",
			 "Why I Joined NSU: NSU was a club that aligned with my interests and had the very fun and friendly people :)",
			 "Interests: Stalking other peoples photos on instagram, taking pics, keeping my selfie game on point",
			 "Contact: sveshkini@berkeley.edu",
			 "Why I <3 NSU!: the ppl r awes0me!11!"),
	// Andrew
	array("Major: Physics & Computer Science",
			"Year: Junior",
			"Why I Joined NSU: 4 Lulz",
			"Interests: XBONE, Smash, Judo, Powerlifting, Nano-Electronics",
			"Contact: asai@berkeley.edu",
			"Why I <3 NSU!: There are so many different people in NSU and yet we all get along like family.  Everyone feels included in the NSU family."),
	// Kayla
	array("Major: Molecular and Cell Biology",
			"Year: Sophmore",
			"Why I Joined NSU: Tara (old community service chair) introduced me! Then I stay, reason mentioned in \"Why I <3 NSU\".",
			"Interests: I'm boring, and therefore, I don't have interests (eh you have to get to know me to find out).",
			"Contact: kayla.umemoto@berkeley.edu ",
			"Why I <3 NSU!: We're one big family :) it's super cool being in this community!"),
	// Nolan
	array("Major: Computer Science",
			"Year: Senior",
			"Why I Joined NSU: Wanted some cool people to hang out with and also make a difference in the community.",
			"Interests: Video Games, Art, Dance, Reddit",
			"Contact: nolan@berkeley.edu ",
			"Why I <3 NSU!: NSU allows members to help and learn about the larger Japanese American community while also make a lot of friends along the way!"),
	// Kelly
	array("Major: MCB",
			"Year: Sophmore",
			"Why I Joined NSU: I wanted to join a club and right when I was looking I got hit with an NSU flyer! It was destiny!",
			"Interests:  FOOOOD and cheesy jokes, \"What's the only thing Batman likes in his drinks........JUST-ICE\" ...I'm sorry, I'll stop. Anyways I also love Kpop, basketball, drawing, and I'll watch the occasional anime too",
			"Contact: khamamoto@berkeley.edu",
			"Why I Love NSU!: They really are like a family to me. It's a group of people you won't find anywhere else!"),
	// Alyssa
	array("Major: Cognitive Science",
			 "Minor: Computer Science",
			 "Year: Junior",
			 "Why I Joined NSU: I am interested in Japanese culture and language and want to learn more about it and one day study abroad to Japan!",
			 "Interests: Interests: dancing, watching movies, roller coasters, eating, science fiction, cats >^.^<",
			 "Contact: ajalvarez@berkeley.edu",
			 "Why I <3 NSU!: Even though I was initially interested in learning more about Japanese culture, what kept me captivated with NSU was the beautiful and wonderfully nice people in the group, and how easily I can get along with everyone I meet through the club. My closest friends are now the friends I’ve made through NSU."),
	// Kaycee
	array("Major: Psychology",
			 "Year: Junior",
			 "Why I Joined NSU: To meet other people who are also interested in being involved in the JA community.",
			 "Interests: I like cooking, watching Netflix, and playing basketball with friends.",
			 "Contact: kkching@berkeley.edu",
			 "Why I <3 NSU!: When I first joined, everyone I met was amazingly friendly and went out of their way to make me feel welcome. I love NSU because it really is like a family, where great friendships are just waiting to be made!"),
	// Amy
	array("Major: Molecular and Cell Biology (MCB)",
			 "Minor: Japanese",
			 "Year: Sophmore",
			 "Why I Joined NSU: Darien Lau invited me to first mini-gen second semester of my freshman year. I liked the atmosphere and the warmness of the group so I stayed!",
			 "Interests: Admiring pretty art and smashing ping pong balls and binge watching and/or reading animes/mangas and daydreaming and bugging people to hang out with me and cooking for everyone and and and and and... ok let's just face reality and say there's a lot.",
			 "Contact: amyfann@berkeley.edu",
			 "Why I <3 NSU!: It's like a 家族（かぞく）! It's fascinating how such a diverse group of people are bonded together by their love for this community and the things it does (:"),
	// Grace
	array("Major: Undeclared/Business",
			"Minor: Japanese",
			"Year: Sophmore",
			"Why I Joined NSU: I joined NSU because I provides me a space to experience everything about Japan as well as the Japanese American culture.",
			"Interests: Yosakoi, artsy stuff (drawing, painting, sewing, crafting), baking, eating, Anime, Cosplay, playing MMO/RPG",
			"Contact: grace.jh.yeo@gmail.com",
			"Why I <3 NSU!: Because we are a family."),
);

// Displays Core member data
for ($row = 0; $row < count($core_names); $row++)
{
	// Split Name and title into variables by ':'
	list($name, $title) = explode(":", $core_names[$row]);
	echo '<div class="core_member">';

		echo '<table>';
			echo '<tr>';
				echo '<td class="core_member_img_td">';
					// Display Picture
					$picture_directory = $core_pics[$title];
					if (file_exists($picture_directory))
					{
						echo '<img src="', $picture_directory, '" alt="">';
					}
					else {
						echo '<img src="/pictures/core_filler.png" alt="">';
					}
				echo '</td>';
				echo '<td class="core_member_data_td">';
					// Show Data
					echo '<table class="core_data">';

						// Display name
						echo '<tr class="core_title">';
							echo '<td colspan="2">', $name, '</td>';
						echo '</tr>';

						// Display Title
						echo '<tr class="core_title">';
							echo '<td colspan="2">', $title, '</td>';
						echo '</tr>';

						// Display factoids
						for ($data_row = 0; $data_row < count($core_data[$row]); $data_row++)
						{
							// Split data like "Major" by ":"
							list($data_name, $data_information) = explode(":", $core_data[$row][$data_row]);
							echo '<tr>';
								echo '<td class="core_data_name">', $data_name, '</td>';
								if (strpos($data_information, "@"))
								{
									echo '<td class="core_data_information"><a class="email" href="mailto:', $data_information,'">', $data_information, '</a></td>';
								}
								else
								{
									echo '<td class="core_data_information">', $data_information, '</td>';
								}
							echo '</tr>';
						}

					echo '</table>';
				echo '</td>';
			echo '</tr>';
		echo '</table>';
	echo '</div>';
}

