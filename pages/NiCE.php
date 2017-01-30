<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include 'head.php' ?>
        <?php include 'jssor.php' ?>
        <script src="../js/roster.js"></script>
        <script src="../js/nice.js"></script>
    </head>
    <body>
        <?php include 'header.php' ?>
        <div id="general_content" class="container-fluid">
            <div class="row container-fluid">
                <div class="col-md-8 col-md-offset-2">
                    <center>
                        <div id="slider1_container" class="jssor_yosakoi_container">
                            <!-- Slides Container -->
                            <div u="slides" class="jssor_yosakoi_slides">
                                <?php 
                                    include 'generateJssorImages.php' ;
                                    generate_jssor_images("../pictures/nice/");
                                ?>
                            </div>
                        </div>
                    </center>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 col-md-offset-2">
                    <h2> NiCE </h2>
                    <p>
                    NSU's Nikkei Choral Ensemble (NiCE) was started during the 
                    2010 Fall Culture Show and emphasizes a comfortable zone where 
                    people can sing out freely with a group of fun loving people. 
                    We sing both English and Japanese songs through a cappella or w
                    ith background instrumentals. If you are interested in joining,
                     please contact our directors at <a class="email" href="mailto:nikkeichoralensemble@gmail.com"> nikkeichoralensemble@gmail.com </a>
                    </p>
                    <br>
                    <br>
                    <p> We are looking especially for tenors! </p>
                </div>
                <div class="col-md-4">
                <form>
                    <select id="roster_select">
                    </select>
                </form>
                <div id="roster">
                </div>
            </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <iframe class="video_group" src="https://www.youtube.com/embed/videoseries?list=PL7bkkg2rE7qPUeBpZXPmH5gwwZ_cvwnjj" frameborder="0" allowfullscreen></iframe>
            </div>
        </div>
        <?php include 'footer.php' ?>
    </body>
</html>