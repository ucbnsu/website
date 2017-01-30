<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include 'head.php' ?>
        <?php include 'jssor.php' ?>
        <script src="../js/roster.js"></script>
        <script src="../js/yosakoi.js"></script>
    </head>
    <body>
        <?php include 'header.php' ?>
        <div class="row container-fluid">
            <div class="col-md-8 col-md-offset-2">
                <center>
                    <div id="slider1_container" class="jssor_yosakoi_container">
                        <!-- Slides Container -->
                        <div u="slides" class="jssor_yosakoi_slides">
                            <?php 
                                include 'generateJssorImages.php' ;
                                generate_jssor_images("../pictures/yosakoi/");
                            ?>
                        </div>
                    </div>
                </center>
            </div>
        </div>
        <div id="general_content" class="row container-fluid">
            <div class="col-md-4 col-md-offset-2">
                <h2> Yosakoi? What's That? </h2>
                <p>
                    Yosakoi or Yosakoi-Soran is a
                    Japanese dance that combines the fluid motions of the fisherman's 
                    dance, "Soran Bushi", with high energy, contemporary music.
                </p>
                <p>
                    Yosakoi 
                    teams are found in virtually every Japanese university and are also 
                    often formed within local communities. With the epicenter of Kochi, 
                    Japan, major yosakoi festivals are held across Japan thoroughout the year.
                </p>
                <!--
                <h2> Upcoming Performances </h2>
                <p>
                    <h3> UC Berkeley's EAU Night Market </h3>
                    <ul>
                        <li>When: November 5, 2015</li>
                        <li>Where: Savio Steps at Upper Sproul</li>
                        <li>Performance time: ~6:35pm</li>
                        <li>Price: FREE!</li>
                        <li>Facebook event page: <a class="blue" href='https://www.facebook.com/events/455768621272614/'>https://www.facebook.com/events/455768621272614/</a></li>
                    </ul>
                    <h3> [M]ovement Showcase </h3>
                    <ul>
                        <li>When: November 14, 2015</li>
                        <li>Where: Zellerbach Playhouse (UC Berkeley)</li>
                        <li>Showcase time: 7 - 9:15pm</li>
                        <li>Price: $10 presale, $13 at the door</li>
                        <li>Facebook event page: <a class="blue" href='https://www.facebook.com/events/905268809508960/'>https://www.facebook.com/events/905268809508960/</a></li>
                    </ul>
                    <h3> [AAA] FUSION: Cultural Benefit Showcase </h3>
                    <ul>
                        <li>When: November 20, 2015</li>
                        <li>Where: Krutch Theatre at Clark Kerr Campus (2601 Warring St.)</li>
                        <li>Performance time: 7pm</li>
                        <li>Price: $5 presale, $7 at door</li>
                        <li>Facebook event page: <a class="blue" href='https://www.facebook.com/events/838653322898628/'>https://www.facebook.com/events/838653322898628/</a></li>
                    </ul>
                    <h3> NSU’s Culture Show </h3>
                    <ul>
                        <li>When: December 5, 2015</li>
                        <li>Where: Anna Head Alumnae Hall (2537 Haste St.)</li>
                        <li>Performance time: 1 - 3pm</li>
                    </ul>
                </p>    -->

                <h2> Our History </h2>
                <p>
                    Formed in the fall of 2006, NSU Yosakoi is one of the few recognized full-fledged teams in the United States. Drawing from the original soran bushi, we have moved on to create our own pieces including Matsuri Danshaku, Senin Monogatari, and Hinode.
                </p>
                <p> 
                    We perform at NSU’s annual Culture Show, NSU’s first general meeting of each semester, the SF Cherry Blossom Festival in Japantown, and Kodomo no Hi in Japantown. Other events we have performed at include:
                </p>
                <ul>
                    <li>
                        Dance the Bay Showcase [Fall 2015]
                    </li>
                    <li>
                        AAA's FUSION: Cultural Benefit Showcase [Fall 2015]
                    </li>
                    <li>
                        Movement Showcase [Fall 2015]
                    </li>
                    <li>
                        UC Berkeley’s EAU Night Market [Fall 2015]
                    </li>
                    <li>
                        SF Giants’ Japanese Heritage Night (Spring 2015)
                    </li>
                    <li>
                        J-sei Family Festival (Fall 2015)
                    </li>
                    <li>
                        bridges Senior Weekend (Spring 2015)
                    </li>
                    <li>
                        bridges Transfer Weekend (Spring 2015)
                    </li>
                    <li>
                        Concord Obon Festival (Summer 2014, Summer 2015)
                    </li>
                    <li>
                        JCYC Tomodachi Day Camp (Summer 2014)
                    </li>
                    <li>
                        EnVC Showcase (Spring 2014)
                    </li>
                    <li>
                        Perspectives Showcase (Spring 2013)
                    </li>
                    <li>
                        Movement Showcase (Fall 2012)
                    </li>
                    <li>
                        Cal Anime Destiny (Fall 2011)
                    </li>
                    <li>
                        Cal Raijin Taiko 2nd Annual Showcase (Spring 2009)
                    </li>
                </ul>
                </li>
                <h2> How Can I Join? </h2>
                <p> We are currently recruiting for the Spring 2016 semester!! </p>
                <p>
                    Recruitment occurs in the beginning of the Fall and Spring semesters. No dance experience? No problem! We'll teach you everything you'll need to know. Practices are held once a week for 2 hours. Contact us at <a href="mailto:ucbnsuyosakoi@gmail.com"> <span class="email"> ucbnsuyosakoi@gmail.com </span></a> if you’re interested in joining!
                </p>
                <h2> Contact Us! </h2>
                <p>
                    Our email is <a href="mailto:ucbnsuyosakoi@gmail.com"> <span class="email"> ucbnsuyosakoi@gmail.com </span></a>
                </p>
            </div>
            <div class="col-md-4">
                <form>
                    <select id="roster_select">
                    </select>
                </form>
                <div id="roster">
                </div>
            </div>
        <div class="row">
            <div id="videos" class="col-md-8 col-md-offset-2">
            </div>
        </div>
        </div>
        <?php include 'footer.php' ?>
    </body>
</html>