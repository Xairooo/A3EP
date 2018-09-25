<?php
foreach($other as $row){
eval($CMS->funcDecrypt("wOsVmdlxGJgoCIvBHckAiKgkyc39mckgCduV3bjBSPgQ3cvNGJJkgC701JzVXakFmcns1dvJHJg0DIzVXakFmckkQCKsTXnwWZ2VGbns1dvJHJg0DIsVmdlxGJJkgC701Jl1WYudyW39mckASPgUWbh5GJJkgC7kSZ0FGZkACLiMXehRGIi4SZmlGbkkCdulGKuIyKigSZtlGdvRnc0NHI9ASZ0FGZlVHZkkQCKsTKlRXYkRCKl1Wa09GdyR3cg0DIlRXYkRSCJowOddCdh9FZpFGcfR3chx2Jbd3byRCI9ASZ0FGZkkQCKowOpM3dvJHJoQnb192Yg0DI05WdvNGdjVmai9GJJkgC7kCKsxWQoNGdlZmPtQXb0NHJg0DIzd3byRCIgACIgACIgoQfgACIgACIgAiC7kSKoU2ZhN3cl1EdldmPtgXZkAiLgICI6knclVXcg4WdyByb0BCZlxWahZkIoUWakBCIgACIgACIgACIgowegACIgACIgAiCpgXZkAibvlGdwV2Y4V0TEBFKoNGdhNWCJoQfJkgC7kCKlRXdjVGel5TL01GdzRCI9ACdsV3clJHJgACIgACIgAiC7kSeyVWdxRCKlJXYwVmcw5TLvJGZkASPgQXb0NHJgACIgACIgAiC7lQCKknc0lQCKsjInIiLklGJuIyJg0DIkl2X5J3b0lmcyVGdgUkUFh0Vg42bpR3Y1JHdz52bjBSTPJlRgoCIUNURMV0UiASPgknclVXckkQCKsTXnQWans1dvJHJg0DIklGJJACIgASC"));
?>
                    <div class="col-md-4" style="border:1px solid grey">
                        <header>
                            <h2 style="color:white">
                                <?php echo $row['name']; ?>
                            </h2>
                            <p style="color:white">Rank: Member</p>
                            <div class="price" style="color:white">
                                <span class="amount"><?php echo $cost; ?></span>
                                <span class="currency">Poptabs</span>
                                <span class="period">/<?php echo $life; ?> days</span>
                            </div>
                            <form name="PAYTY" action="?page=myterritories" method="post">
                                <input type="submit" class="btn btn-success center" value="Pay Protection"></input> <button id="<?php echo $id; ?>" type="button" data-toggle="modal" data-target="#Manager_Member" class="btn btn-warning">MANAGE</button>
                                <input type="hidden" name="TRANSACT" value="TRUE">
                                <input type="hidden" name="cost" value="<?php echo $cost;?>">
                                <input type="hidden" name="id" value="<?php echo $id;?>">
                            </form>
                        </header>
                        <ul class="features">
                            <li style="color:white">
                                <i class="fa fa-file-o"></i>
                                <?php echo $langs->word($dlang,'territory_level');?>:
                                <?php echo $row['level']; ?>
                            </li>
                            <li style="color:white">
                                <i class="fa fa-cloud-upload"></i>
                                <?php echo $langs->word($dlang,'territory_radius');?>:
                                <?php echo $row['radius']; ?>
                            </li>
                            <li style="color:white">
                                <i class="fa fa-signal"></i>
                                <?php echo $langs->word($dlang,'territory_payment_due');?>:
                                <?php echo date('F j, Y g:i A', $duedate);?>
                            </li>
                            <li style="color:white">
                                <i class="fa fa-laptop"></i>
                                <?php echo $langs->word($dlang,'territory_last_paid');?>:
                                <?php echo date('F j, Y g:i A', $date);?>
                            </li>
                            <li style="color:white">
                                <i class="fa fa-rocket"></i>
                                <?php echo $langs->word($dlang,'territory_object_count');?>:
                                <?php echo count($rows);?>
                            </li>
                        </ul>
                    </div>
                    <script>
                        document.getElementById("<?php echo $id ?>").addEventListener("click", displaymanager);

                        function displaymanager() {
                            document.getElementById("territoryname").innerHTML = "<?php echo $row['name']; ?>";
                            document.getElementById("addmember").style.display = 'none';
                            document.getElementById("100").setAttribute("value", "<?php echo $row['name'];?>");
                        }
                    </script>
                    <?php } ?>