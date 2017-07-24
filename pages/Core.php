<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'head.php'; ?>
    <script src="/js/roster.js"></script>
    <script src="/js/core.js"></script>
</head>
<body style="overflow-x:hidden !important;">

<?php include 'header.php'; ?>

<!-- CONTENT -->
<div id="general_content" class="row">
    <center>
        <?php include 'display_core_info.php'; ?>
    </center>
    <div class="col-sm-6 col-md-offset-3">
        <form>
            <select id="roster_select">
            </select>
        </form>
        <div id="roster">
        </div>
    </div>
<!-- CONTENT -->

<?php include 'footer.php'; ?>

</body>
</html>
