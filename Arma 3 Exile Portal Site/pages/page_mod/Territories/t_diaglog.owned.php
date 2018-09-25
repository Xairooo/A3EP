    <div class="modal fade" id="Manager_Owned" name="Manager" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Territory Management for:
                        <div id=territoryname></div>
                    </h3>
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <input class="hidden" id=teritoryid></input>
                <div class="modal-body" id="addmember">
                    <div class="box-body">
                        <div class="form-group">
                            <label class="col-sm-4 control-label" style="color:white">Name</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="100" name="name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label" style="color:white">Remove Member</label>
                            <div class="col-sm-4">
                                <select class="form-control" name="userid" id="299">
                              <option value=""></option>
                        </select>
                            </div>
                            <button type="button" class="btn-sm" style="position:relative; top: 5px;">Kick 'em</button>
                        </div>
                        <div class="form-group">
                            <input class="hidden" id=ppo></input>
                            <input class="hidden" id=objects></input>
                            <input class="hidden" id=level></input>
                            <label class="col-sm-4 control-label" style="color:white">Vacation Payment</label>
                            <div class="col-sm-4">
                                <input name="calendarselect{ContactID}" class="timeselect" type="date" id="calendar">
                            </div>
                            <button type="button" class="btn-sm" style="position:relative; top: 5px;">Pay</button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary">Save changes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
        <div id="storage" name="storage" style="display:none;"> </div>
    <script>
        document.getElementById("datepickericon").onclick = function(e) {
            document.getElementById("calendar").focus();
        }
    </script>