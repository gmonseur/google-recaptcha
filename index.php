<?php
require_once('class/Recaptcha.php');
$recaptcha = new Recaptcha('SITE_KEY', 'SECRET_KET'); // Get the API keys from Google

if(!empty($_POST)){    
    $response = isset($_POST['g-recaptcha-response']) ? $_POST['g-recaptcha-response'] : NULL;
    
    if($recaptcha->isValid($response)){
        $message = '<p class="notify notify-success">Form Submit</p>';
    }else{
        $message = '<p class="notify notify-error">reCaptcha Error</p>';
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Google reCaptcha integration</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,300italic,700,700italic">
    <link rel="stylesheet" href="lib/normalize.css/normalize.css">
    <link rel="stylesheet" href="lib/milligram/dist/milligram.min.css">
    <link rel="stylesheet" href="styles/main.css">
</head>

<body>

    <main class="wrapper">
        <div class="container">
            <div class="row">
                <div class="column column-60">
                    <h1>Google reCaptcha</h1>
                    <p>Google reCaptcha integration with a simple php class</p>

                    <ul>
                        <li><a href="https://www.google.com/recaptcha/intro/invisible.html">Google reCaptcha</a></li>
                        <li><a href="https://developers.google.com/recaptcha/docs/verify">Documentation</a></li>
                    </ul>

                    <hr>                    

                    <h2>Form example</h2>
                    <?php echo (!empty($message))? $message : ''; ?>
                    <form action="" method="post">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name">
                        <?php echo $recaptcha->getHtml();?><br>
                        <input type="submit" value="submit">
                    </form>
                </div>
            </div>
        </div>
    </main>

    <script src="scripts/main.js"></script>
    <?php echo $recaptcha->getJs();?>


</body>

</html>
