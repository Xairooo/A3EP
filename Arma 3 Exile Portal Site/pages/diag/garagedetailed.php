<?php if(!isset($include)){die("INVALID REQUEST");} ?>

	<div class="w3-modal" id="fullvehicle" tabindex="-1" role="dialog" aria-labelledby="fullvehicle">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="document.getElementById('fullvehicle').style.display='none';"><span aria-hidden="true">&times;</span></button>
						<h2 style="color:white" id="fullvehiclename"></h2>
					</div>
					<div class="modal-body">
						<div class="form-horizontal">
							<div class="form-group">
								<div class="col-md-12" style="padding-right:15px;padding-left:15px;">
									<div class="col-lg-6" style="">
										<div class="tile t-cent c-orange" style="height:68px">
											<h4 id="1023">
											</h4>
											<div class="small"><?php echo $langs->word($dlang,'vehicle_name');?></div>
										</div>

									</div>

									<div class="col-lg-6" style="" >
              <div class="tile t-cent" style="height:68px">
                <form id="1025" name="togglelock" action="?page=mygarage" method="post">
                  <input type="hidden" name="id" id="1026" value="">
                  <input type="hidden" name="locked" id="stat">
                  <input type="submit" id="1027" style="color:white" name="togglelock" value="Lock Vehicle" class="text_button"></form>
                <div class="small" style="color:white" id="1028"></div>
              </div>
									</div>
								</div>
								<div class="col-md-12" style="padding-right:15px;padding-left:15px;">
									<div class="col-lg-4">
										<div class="tile t-cent">
											<h4 id="1030">
											</h4>
											<div class="small" style="color:white"><?php echo $langs->word($dlang,'damage');?></div>
										</div>
									</div>
									<div class="col-lg-4">
										<div class="tile t-cent">
											<h4 id="1031"> </h4>
											<div class="small" style="color:white"><?php echo $langs->word($dlang,'fuel');?></div>
										</div>
									</div>
									<div class="col-lg-4" style="">

										<div class="tile t-cent">
											<h4 id="1032">
											</h4>
											<div class="small" style="color:white"><?php echo $langs->word($dlang,'money');?></div>
										</div>

									</div>
								</div>

								<div class="col-md-12" style="padding-right:15px;padding-left:15px;">
									<div class="col-lg-6" style="height:96px">

										<div class="tile t-cent" style=" margin: 0px;height:86px">
											<h4 id="1033">

											</h4>
											<div class="small" style="color:white"><?php echo $langs->word($dlang,'pin_code');?></div>
										</div>

									</div>
									<div class="col-lg-6" style="">

										<div class="tile t-cent">
											<form name="pinchange" action="?page=mygarage" method="post">
												<input type="hidden" name="id"  id="1034">
												<input type="text" name="pinc" maxlength="4" pattern="\d{4}" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" type="number" class="form-controltwo t-cent cent" style="width:100px" id="1035">
												<input type="submit" name="pin" value="Change Pin" style="padding-bottom:0; color:white" class="text_button"></form>

										</div>
									</div>
								</div>


								<div class="col-md-12" style="padding-right:15px;padding-left:15px;">
									<div class="col-lg-6" style="">
										<div class="tile t-cent c-blue">
											<h4 id="1036">

											</h4>
											<div class="small"><?php echo $langs->word($dlang,'bought_on');?></div>
										</div>
									</div>
									<div class="col-lg-6" style="">
										<div class="tile t-cent c-blue">
											<h4 id="1037">

											</h4>
											<div class="small"><?php echo $langs->word($dlang,'last_updated');?></div>
										</div>
									</div>
								</div>
								<div style="padding-left:493px; padding-right:15px;">
									<button style="" type="button" class="btn btn-sign" onclick="document.getElementById('fullvehicle').style.display='none';"><?php echo $langs->word($dlang,'close');?></button>
								</div>

							</div>
						</div>

					</div>
				</div>
			</div>
		</div>