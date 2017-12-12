            <div class="row profile">
                <h2>Edit Profile Information</h2>
                <form action="" method="post" accept-charset="utf-8" enctype="multipart/form-data" onsubmit="return validate(this);">
                    <div class="row">
                        <div class="col-4">
                            <div class="row">
                                <div class="picture edit-picture">
                                    <?php
                                    $default_pic = 'http://'.$_SERVER['HTTP_HOST'].'/assets/images/pikachu.png';
                                    echo '<img src="'.
                                    ((UserHelper::getPicUrl())?UserHelper::getPicUrl():$default_pic).
                                    '" alt="'.
                                    UserHelper::getName()
                                    .'">';
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-8 margin-top">
                            Update profile picture :
                            <div class="row">
                                <input class="col-8 input-standard upload-bar" id="uploadFile" placeholder="Choose File" disabled="disabled" />
                                <div class="file-upload col-4 button-upload">
                                    <span>Browse..</span>
                                    <input id="uploadBtn" name="uploaded_file" type="file" class="upload" onchange="uploadFinish()" />
                                </div>
                                <span class="warning"><?php echo $status; ?></span>
                            </div>
                        </div>
                    </div>
                    <input name="ID" type="hidden" value="<?php echo UserHelper::getID(); ?>">
                    <div class="row margin-top">
                        <div class="row">
                            <div class="col-4">
                                Your Name
                            </div>
                            <div class="col-8">
                                <input class="input-standard input-standard-v2" type="text" name="name" id='name' placeholder="Your name..." value="<?php echo UserHelper::getName();?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                Phone
                            </div>
                            <div class="col-8">
                                <input class="input-standard input-standard-v2" type="text" name="phone" id='phone' placeholder="Your phone.." value="<?php echo UserHelper::getPhone();?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                Status Driver
                            </div>
                            <div class="col-8">
                                <label class="switch">
                                <input type="checkbox" name="isDriver" <?php if(UserHelper::getDriver()) { ?>checked<?php } ?> >
                                <span class="slider"></span>
                                </label>
                            </div>
                        </div>
                        <div class="row margin-top">
                            <div class="col-2">
                                <a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/profile.php?id_active=<?php echo UserHelper::getID(); ?>" class="button button-fail" >Back</a>
                            </div>
                            <div class="col-8">
                            </div>
                            <div class="col-2">
                                <input class="button button-success" type="submit" name="submit" value="Save">
                            </div>
                        </div>
                        <div class="row warning-box" id="warning-msg" style='display: none;'>
                        </div>
                    </div>
                </form>
            </div>
            <script> 
                var id = <?php echo $ID; ?>;
            </script>
            <script type='text/javascript' src='../assets/js/ajax.js'></script>
            <script type='text/javascript' src='../assets/js/upload_profile_picture.js'></script>
            <script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/assets/js/edit_profile.js"></script>