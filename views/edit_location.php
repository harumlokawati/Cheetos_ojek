            <div class="row margin-top">
                <h2>Edit Preferred Locations</h2>
                <div class="row">
                    <?php 
                        $data = UserHelper::getAllPreferredLocation();
                        $nb = 0;
                    ?>
                    <table class="location_table" id='location_table'>
                        <tr>
                            <th style="width: 25px">No</th>
                            <th>Location</th>
                            <th style="width: 90px">Actions</th>
                        </tr>
                        <?php foreach($data as $row){ ?>
                        <?php $nb++; ?>
                            <tr id='row-<?php echo $row['preference_number']; ?>'>
                            <form action="" method="post" accept-charset="utf-8">
                                <td class='number'>
                                    <input type='text' id="pref-row-<?php echo $row['preference_number']; ?>" class='input-standard input-standard-v2' name="pref-<?php echo $row['preference_number']; ?>" value="<?php echo $row['preference_number']; ?>" style="display:none;">
                                    <span class='location-pref'><?php echo $nb; ?></span>
                                </td>
                                <td class='location'>
                                    <input type='text' id="loc-row-<?php echo $row['preference_number']; ?>" class='input-standard input-standard-v2' name="loc-<?php echo $row['preference_number']; ?>" value="<?php echo $row['location']; ?>" style="display:none;">
                                    <span class='location-name'><?php echo $row['location']; ?></span>
                                </td>
                                <td class='option'>
                                    <div class="row">
                                        <div class="col-6" id="edit-<?php echo $row['preference_number']; ?>">
                                            <a href="#" class="edit-icon" id="edit-link-<?php echo $row['preference_number']; ?>" onclick="editLocation(<?php echo $row['user_id'].','.$row['preference_number']; ?>)"><i class="material-icons md-36">edit</i></a>
                                            <button class="save-" id='submit-edited-location-<?php echo $row['preference_number']; ?>' value='submit-edited-location-<?php echo $row['preference_number']; ?>' style="display:none;"><i class='material-icons md-36'>save</i></button>
                                        </div>
                                        <div class="col-6" id="delete-<?php echo $row['preference_number']; ?>">
                                            <a href="#" class="delete-icon" id="delete-link-<?php echo $row['preference_number']; ?>" onclick="deleteLocation(<?php echo $row['user_id'].','.$nb; ?>)"><i class="material-icons md-36">clear</i></a>
                                        </div>
                                    </div>
                                </td>
                            </form>
                            </tr>
                        <?php } ?>
                        <tr id='no-data-row' style="display: <?php echo ($nb < 1) ? 'table-row' : 'none';?>;">
                            <td colspan='3' style='text-align: center;'> No data to display </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="row margin-top">
                <h3>Add New Location : </h3>
                <form action="" method="post" accept-charset="utf-8">
                <input name="ID" type="hidden" value="<?php echo UserHelper::getID(); ?>">
                <label class="col-10">
                    <input class="input-standard input-standard-v2" autocorrect="off" autocomplete="off" type="text" id="location" name="location" list="suggestLoc">
                    <datalist id="suggestLoc"></datalist>
                </label>
                <label class="col-2 ">
                <input class="button button-success button-add" id='submit-add-location' name="submit" type="submit" value="Add"></button>
                </label>
                </form>
            </div>
            <?php if(is_string($msg)) { ?>
            <div class="row warning-box" id="warning-msg">
                <span class="closebtn" onclick="this.parentElement.style.display = &quot;none&quot;;">&times;</span>
                <?php echo $msg;?>
            </div>  
            <?php } ?>
            <div class="row margin-top">
                <a href="<?php echo $path;?>/profile.php?id_active=<?php echo UserHelper::getID();?>" class="button button-fail">Back</a>
            </div>
            
            <script> 
                var id = <?php echo $ID; ?>;
                var nbPref = <?php echo $nb; ?>; 
            </script>
            <script type='text/javascript' src='../assets/js/ajax.js'></script>
            <script type='text/javascript' src='../assets/js/edit_location.js'></script>
