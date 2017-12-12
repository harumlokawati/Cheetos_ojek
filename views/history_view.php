
            <div class="row">
                <h3>Transaction History</h3>
                <ul class="row navbar">
                    <li class="col-6 align-center standard-border active" id="previous-order-tab">
                        <a onclick="toPreviousOrder()">My Previous Order</a>
                    </li>
                    <li class="col-6 align-center standard-border" id="driver-history-tab">
                        <a onclick="toDriverHistory()">Driver History</a>
                    </li>
                </ul>
            </div>
            <section id="driver-history">
                <?php
                    $pdo = Database::connect();
                    $query = 'SELECT * FROM (SELECT orders.ID, users.name AS cust_name, users.profile_pic_url FROM orders JOIN users ON orders.customer_id = users.ID) AS order_customer 
                    NATURAL JOIN (SELECT * FROM orders NATURAL JOIN (SELECT * FROM (SELECT orders.ID, locations.location AS departure FROM orders JOIN locations ON orders.location_id = locations.ID) AS order_depart 
                    NATURAL JOIN (SELECT orders.ID, locations.location AS destination FROM orders JOIN locations ON orders.destination_id = locations.ID) AS order_dest) as depart_dest) AS order_depart_dest WHERE driver_id='.$ID.' AND driver_show=1 ORDER BY time DESC';
                    $nbHistory = 0;
                    $data = $pdo->query($query);
                ?>
                <div id="history-exist" style="display: <?php echo (count($data) > 0) ? 'block' :  'none'; ?>" class="scrollable">
                    <?php foreach($data as $row){ ?>
                    <?php $nbHistory++; ?>
                    <div id="history-<?php echo $row['ID'];?>" class="row">    
                        <div class='col-3'>
                            <div class='picture driver-picture'>
                                <img src="<?php echo $row['profile_pic_url']; ?>" alt='no file'>
                            </div>
                        </div>
                        <div class='col-8 driver-detail'>
                            <div class='date'>
                                <?php echo date('l, F j Y', strtotime($row['time'])); ?>
                            </div>
                            <div class='driver-name'>
                                <?php echo $row['cust_name']; ?>
                            </div>
                            <div class="text">
                                gave <span class="rating"> <?php echo $row['rate']; ?></span> stars for this order
                            </div>
                            <div class="text">
                                <span class="text"><?php echo $row['departure']; ?></span>&rarr;<span class="text"><?php echo $row['destination'];?></span>
                            </div>
                            <div class="text">
                                and left comment:
                            </div>
                            <div class="comment">
                                <?php echo $row['comment'];?>
                            </div>
                        </div>
                        <div class="col-1 ">
                            <button class="button button-fail right" onclick="hideDriverHistory(<?php echo $row['ID']; ?>)">HIDE!</button>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <div id="no-history" class="margin-top" style="display : <?php echo  ($nbHistory == 0) ? 'block' : 'none'; ?>">
                    No transaction yet!
                </div>
            </section>

            <section id="previous-order">
                <?php
                    $query = 'SELECT * FROM (SELECT orders.ID, users.name AS driver_name, users.profile_pic_url FROM orders JOIN users ON orders.driver_id = users.ID) AS order_driver 
                    NATURAL JOIN (SELECT * FROM orders NATURAL JOIN (SELECT * FROM (SELECT orders.ID, locations.location AS departure FROM orders JOIN locations ON orders.location_id = locations.ID) AS order_depart 
                    NATURAL JOIN (SELECT orders.ID, locations.location AS destination FROM orders JOIN locations ON orders.destination_id = locations.ID) AS order_dest) as depart_dest) AS order_depart_dest WHERE customer_id='.$ID.' AND customer_show=1 ORDER BY time DESC';
                    $result = $pdo->query($query);
                    $nbPrev = 0;
                ?>
                <div id="previous-exist" style="display: <?php echo (count($result)>0) ? 'block' : 'none'; ?>" class="scrollable">
                <?php foreach($result as $row){ ?>
                <?php $nbPrev++; ?>
                    <div id="previous-<?php echo $row['ID'];?>" class="row">    
                        <div class='col-3'>
                            <div class='picture driver-picture'>
                                <img src="<?php echo $row['profile_pic_url']; ?>" alt='no file'>
                            </div>
                        </div>
                        <div class='col-8 driver-detail'>
                            <div class='date'>
                                <?php echo date('l, F j Y', strtotime($row['time'])); ?>
                            </div>
                            <div class='driver-name'>
                                <?php echo $row['driver_name']; ?>
                            </div>
                            <div class="text">
                                <span class="text"><?php echo $row['departure']; ?></span>&rarr;<span class="text"><?php echo $row['destination'];?></span>
                            </div>
                            <div class="row">
                                <div class="col-3" style="padding-left:0px;" >
                                    <div class="text">You rated:</div>
                                </div>
                                <?php for ($i = 0; $i < $row['rate']; $i++){ ?>
                                <span class="rating" id="driverrating">&#9734;</span>
                                <?php } ?>
                            </div>
                            <div class="text">
                                You commented:
                            </div>
                            <div class="comment">
                                <?php echo $row['comment'];?>
                            </div>
                        </div>
                        <div class="col-1 ">
                            <button class="button button-fail right" onclick="hidePreviousHistory(<?php echo $row['ID']; ?>)">HIDE!</button>
                        </div>
                    </div>
                <?php } ?>
                </div>
                <div id="no-previous" class="margin-top" style="display: <?php echo ($nbPrev == 0) ? 'block' : 'none';?>;">
                    No transaction yet!
                </div>
            </section>
            <script>
                var nbDriver = <?php echo $nbHistory; ?>;
                var nbMyPrev = <?php echo $nbPrev; ?>;
            </script>
            <script type="text/javascript" src="assets/js/ajax.js"></script>
            <script type="text/javascript" src="assets/js/history.js"></script>