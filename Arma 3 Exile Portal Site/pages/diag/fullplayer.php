<?php if(!isset($include)){die("INVALID REQUEST");} ?>
<div class="modal fade in" id="fullplayer" tabindex="-1"  aria-labelledby="fullplayerLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button"  onclick="document.getElementById('fullplayer').style.display='none'" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
         <h2 id="fullplayerTitle"></h2>
        </h2>
      </div>
      <div style="border-top: 2px solid #4A4A4A;"></div>
      <div class="modal-body">
        <div class="form-horizontal">
          <div class="form-group">
            <div class="marg">
              <div class="col-lg-6">
                <div class="modal-tile t-cent c-green" style="padding-left:3s0px">
<img id="1029" width="225" height="225">
                </div>
              </div>
              <div class="col-lg-6" >
                <div class="modal-tile t-cent c-green">
                  <h4 id="1024">

                  </h4>
                  <div class="medium"><i class="fa fa-address-card-o" aria-hidden="true"></i><span class="white"> <?php echo $langs->word($dlang,'player_name');?> </span></div>
                </div>
              </div>
                <div class="col-lg-6 bot">
                  <div class="col-lg-6">
                    <div class="modal-tile t-cent c-green">
                      <h4 id="1025"></h4>
                        <div class="small"><i class="fa fa-heartbeat" aria-hidden="true"></i> <?php echo $langs->word($dlang,'health');?></div>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="modal-tile t-cent c-green">
                        <h4 id="1026">

                        </h4>
                        <div class="small"><i class="fa fa-thermometer-half" aria-hidden="true"></i> <?php echo $langs->word($dlang,'tempurature');?></div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="marg">
                <div class="col-lg-6 bot">
                  <div class="col-lg-6">
                    <div class="modal-tile t-cent c-green">
                      <h4 id="1027">

                      </h4>
                        <div class="small"><i class="fa fa-cutlery" aria-hidden="true"></i> <?php echo $langs->word($dlang,'hunger');?></div>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="modal-tile t-cent c-green">
                        <h4 id="1028">

                        </h4>
                          <div class="small"><i class="fa fa-glass" aria-hidden="true"></i> <?php echo $langs->word($dlang,'thrist');?></div>
                        </div>
                      </div>
                    </div>
                  </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" onclick="document.getElementById('fullplayer').style.display='none'" class="btn btn-sign no-margin" data-dismiss="modal"><?php echo $langs->word($dlang,'close');?></button>
                  </div>
                </div>
            </div>
          </div>
        </div>
      </div>
