<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Code Test</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="img/logo.png"/>
    <link rel="stylesheet" href="css/menu.css"/>
    <link rel="stylesheet" href="css/main.css"/>
    <link rel="stylesheet" href="css/bgimg.css"/>
    <link rel="stylesheet" href="css/font.css"/>
    <link rel="stylesheet" href="css/font-awesome.min.css"/>
    <script type="text/javascript" src="js/jquery-1.12.4.min.js"></script>
    <script type="text/javascript" src="js/main.js"></script>
    <!-- <script src="script.js"></script> -->
</head>
<body>
    <div class="menu">
        <a href="#" class="bars" id="bars">
            <i class="fa fa-bars"></i>
        </a>
        <ul id="menu-list">
            <li>
                <a href="/">Home</a>
            </li>
        </ul>
    </div>
    <div class="background"></div>
    <div class="backdrop"></div>
    <div class="login-form-container" id="login-form">
        <div class="login-form-content">
            <div class="login-form-header">
                <div class="logo">
                    <img src="img/logo.png"/>
                </div>
                <h3>File Upload</h3>
            </div>
            <form enctype="multipart/form-data" action="action_page_2.php" method="POST" class="login-form">                                
                <div class="file-container">
                    <input name="userfile" type="file" />
                </div>
                <input type="submit" name="submit-file" value="Upload File" class="button"/>
            </form>
        </div>
    </div>
</body>
</html>