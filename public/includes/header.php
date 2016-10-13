<?php
    require_once (realpath(__DIR__.'/../../app/init.php'));
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Barroc IT</title>
    <link rel="stylesheet" href="http://bootswatch.com/cosmo/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/mainstyle.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script src='https://cdn.tinymce.com/4/tinymce.min.js'></script>
    <script>
        tinymce.init({
            selector: 'textarea',
            menubar: false
        });
    </script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>