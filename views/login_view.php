<!DOCTYPE html>
<html>
    <head>
        <title>Login</title>
        <link rel="stylesheet" href="<?php echo $path;?>/assets/css/style.css">
        <link rel="stylesheet" href="<?php echo $path;?>/assets/css/element.css">
    </head>
    <body>
        <div class="login-extern-container">
            <div class="row">
                <div class="col-4 align-center">
                    <hr class="loginhr">
                </div>
                <div class="col-4 align-center">
                    <h3 class="headstyle">LOGIN</h3>
                </div>
                <div class="col-4 align-center">
                    <hr class="loginhr">
                </div>
            </div>
            <div class="logincontainer">
                <div class="row">
                    <form action="" method="post" accept-charset="utf-8">
                        <div class="row">
                            <div class="col-5">
                                <p class="loginformup">Username</p>
                            </div>
                            <input class="col-7 input-standard" name="username">
                        </div>
                        <div class="row">
                            <div class="col-5">
                                <p class="loginformup">Password</p>
                            </div>
                            <input class="col-7 input-standard" name="password" type="password">
                        </div>
                        <div class="row margin-top">
                            <div class="col-8">
                                <a href="http://<?php echo $_SERVER['HTTP_HOST']?>/signup.php"> <u>Don't an have account?</u></a>
                            </div>
                            <div class="col-4">
                                <input class="button button-green right" name="submit" type="submit" value="GO!">
                            </div>
                        </div>
                        <?php if($status_aborted && $has_submit){ ?>
                        <div class="row warning-box" id="warning-msg">
                            <span class="closebtn" onclick="this.parentElement.style.display = &quot;none&quot;;">&times;</span>
                            Wrong username &amp; password
                        </div>
                        <?php } ?>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>

