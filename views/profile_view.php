            <div class="row profile">
                <h3>My Profile</h3>
                <div class="row">
                    <div class="col-4">
                    </div>
                    <div class="col-4">
                        <div class="row">
                            <div class="picture center profile-picture">
                                <?php
                                $default_pic = $path.'/assets/images/pikachu.png';
                                echo '<img src="'.
                                ((UserHelper::getPicUrl())?UserHelper::getPicUrl():$default_pic).
                                '" alt="'.
                                UserHelper::getName()
                                .'">';
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                    <div class="right">
                        <a href="<?php echo $path; ?>/profile.php?edit=profile&id_active=<?php echo UserHelper::getID(); ?>" class="edit-icon"><i class="material-icons">&#xE254;</i></a>
                    </div>
                    </div>
                </div>
                <div class="row profile-info">
                    <div class="row">
                        <span class="username">
                        @<?php echo UserHelper::getUsername(); ?>
                        </span>
                    </div>
                    <div class="row">
                        <span class="full-name">
                        <?php echo UserHelper::getName(); ?>
                        </span>
                    </div>
                    <div class="row">
                        <?php
                        echo '<span class="status">'.
                        (UserHelper::getDriver()?'Driver':'').
                        '</span>'.
                        (UserHelper::getDriver()?' | <span style="color:orange">&#9734;</span><span class="rating">'.UserHelper::getRating().'</span> (<span class="votes">'.UserHelper::getVotes().'</span> votes)' : '');
                        ?>
                    </div>
                    <div class="row">
                        <span class="material-icons" style="font-size: 10pt">&#xe0e1;</span><span> </span><span class="email"><?php echo UserHelper::getEmail(); ?></span>
                    </div>
                    <div class="row">
                        <span>&#9742;</span><span> </span><span class="phone"><?php echo UserHelper::getPhone(); ?></span>
                    </div>
                </div>
                <?php if(UserHelper::getDriver()) { ?>
                <div class="row">
                    <div class="right">
                        <a href="<?php echo $path; ?>/profile.php?edit=location&id_active=<?php echo UserHelper::getID(); ?>" class="edit-icon"><i class="material-icons">&#xE254;</i></a>
                    </div>
                    <h4>Preferred Locations :</h4>
                    <ul class="scrollable">
                        <?php
                            $data = UserHelper::getAllPreferredLocation();
                            $margin_left = 0;
                            if(!count($data)){ ?>
                            
                            <li>You have no preferred location yet :(</li>

                            <?php }
                            foreach ($data as $row) { ?>
                            <li style="margin-left:<?php echo $margin_left; $margin_left+=10; ?>px"><i class="material-icons" style="font-size:16px">navigate_next</i> <?php echo $row['location']; ?></li>
                        <?php } ?>
                    </ul>
                </div>
                <?php } ?>
            </div>

