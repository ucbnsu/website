<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include 'pages/head.php' ?>
        <link rel="icon" href="/favicon.ico" type="image/x-icon">
    </head>
    <body>
        <?php include 'pages/header.php' ?>
        <?php include_once("pages/analyticstracking.php") ?>

        <div class="row">
            <div class="container">
                <img id="homepage_image" src="pictures/homepage_image.png" alt="">
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
                    <h3> Site Under Construction! </h3>
                    <h3> Join our Mailing List! </h3>
                    <?php include 'pages/signup_form.php' ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="container">
                <div class="blurb col-sm-6">
                    <h3> Upcoming Events </h3>
                    <a class="blue" href="https://www.facebook.com/groups/NikkeiStudentUnion/events/">https://www.facebook.com/groups/NikkeiStudentUnion/events/</a>
                </div>
            </div>
        </div>

        <?php include 'pages/footer.php' ?>
    </body>
</html>
