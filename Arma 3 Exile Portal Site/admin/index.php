<?php
if(!file_exists("../extra/common.php")) {
  header("location: ./install");
}
require("header.php");
?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php echo $langs->word($dlang,'dashboard'); ?>
        <small> A3 Exile Portal v<?php echo $settingClass->getA3EPVersion();?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> <?php echo $langs->word($dlang,'home'); ?></a></li>
        <li class="active"><?php echo $langs->word($dlang,'dashboard'); ?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
<?php
             $query = "
        SELECT
            *
        FROM ".$tblpre."users WHERE
                verified = 0;
    ";
    $query_params = array(
        );
        try
        {
            $stmt = $db->prepare($query);
            $result = $stmt->execute($query_params);
        }
        catch(PDOException $ex)
        {
            die("Failed to run query: " . $ex->getMessage());
        }
    $rows = $stmt->fetchAll();
  $count = $stmt->rowCount();
      function humanTiming ($time)
{
    $time = time() - $time; // to get the time since that moment
    $time = ($time<1)? 1 : $time;
    $tokens = array (
        31536000 => 'year',
        2592000 => 'month',
        604800 => 'week',
        86400 => 'day',
        3600 => 'hour',
        60 => 'minute',
        1 => 'second'
    );
    foreach ($tokens as $unit => $text) {
        if ($time < $unit) continue;
        $numberOfUnits = floor($time / $unit);
        return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
    }
}
?>
      <!-- Main row -->
      <div class="row">
        <?php } else {} ?>
        <!-- Left col -->
        <div class="col-md-8">
           <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo $langs->word($dlang,'users_awaiting_admin_validation'); ?></h3>
               <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                    </button>
                  </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table">
                <tr>
                  <th><?php echo $langs->word($dlang,'name'); ?></th>
                  <th><?php echo $langs->word($dlang,'time_since_registration'); ?></th>
                  <th><?php echo $langs->word($dlang,'action'); ?></th>
                </tr>
                  <?php if($count == 0){ ?>
                <tr>
                  <td></td>
                  <td><?php echo $langs->word($dlang,'no_users_waiting_validation'); ?></td>
                  <td></td>
                </tr>
               <?php } else
  foreach($rows as $row): ?>
                <?php
                $time = strtotime($row['regdate']);
                ?>
                <tr>
                  <td><?php echo $row['username']; ?></td>
                  <td><?php echo humanTiming($time); ?> ago</td>
                 <td> <a href="members.php?do=approve&id=<?php echo $row['id'];?>" role="button" data-toggle="tooltip" title="Approve" class="btn btn-success"><i class="fa fa-check-circle fa-lg"></i></a>
                        <button data-toggle="tooltip" title="Delete" role="button" class="btn btn-danger"><i data-toggle="modal" data-target="#delete<?php echo $row['id'];?>" class="fa fa-times-circle fa-lg"></i></button>

                    </td>
                </tr>
                <div class="modal fade" id="delete<?php echo $row['id'];?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-body">

                              <div class="row">
                                <div class="col-md-3">
                                  <center> <i class="fa fa-exclamation-triangle fa-5x"></i></center>

                                </div>
                                <div class="col-md-9">
                                  <span class="lead"><?php echo $langs->words($dlang,'delete_warning',0);?> <?php echo $row['username'];?><?php echo $langs->words($dlang,'delete_warning',1);?></span> <br>
                                  <span class="text-muted"><?php echo $langs->word($dlang,'delete_warning_con');?></span>
                                </div>

                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <a href="members.php?do=delete&id=<?php echo $row['id'];?>" type="button" class="btn btn-primary">OK</a>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
<?php endforeach; ?>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
          <div class="row">

            <div class="col-md-12">
              <!-- USERS LIST -->
              <div class="box box-danger">
                <div class="box-header with-border">
                  <h3 class="box-title"><?php echo $langs->word($dlang,'latest_members'); ?></h3>

                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                    </button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body no-padding">
                  <ul class="users-list clearfix">
                    <?php

             $query = "
        SELECT
            *
        FROM ".$tblpre."users ORDER BY regdate DESC LIMIT 8

    ";
    $query_params = array(
        );
        try
        {
            $stmt = $db->prepare($query);
            $result = $stmt->execute($query_params);
        }
        catch(PDOException $ex)
        {
            die("Failed to run query: " . $ex->getMessage());
        }

    $rows = $stmt->fetchAll();
  $count = $stmt->rowCount();
              foreach($rows as $row): ?>
                    <li>
                      <?php   if ($userClass->getUserAvatar($AccountID) == NULL) {
            ?><img width="128" height="128" avatar="<?php echo $row['username'];?>"><?php
            } else {
              ?><img src="../<?php echo $row['avatar'];?>" style="height:128px; width:128px" alt="User Image"><?php
            } ?>

                      <a class="users-list-name" href="#"><?php echo $row['username'];?></a>
                      <span class="users-list-date"></span>
                    </li>
                   <?php endforeach;?>
                  </ul>
                  <!-- /.users-list -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer text-center">
                  <a href="members.php" class="uppercase"><?php echo $langs->word($dlang,'view_all_members'); ?></a>
                </div>
                <!-- /.box-footer -->
              </div>
              <!--/.box -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.col -->

        <div class="col-md-4">


               <div class="box box-solid">
            <div class="box-header with-border">
             <h3 class="box-title">Latest A3EP News</h3>
            </div>
            <!-- /.box-header -->
             <div class="box-body">

            </div>
            <!-- /.box-body -->
          </div>




          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php require('footer.php');?>
