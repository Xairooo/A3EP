<?php if(!isset($include)){die("INVALID REQUEST");} ?>
<!-- Bootstrap FAQ - START -->
<div class="container">
  <div class="row">
    <?php
     if(!isset($AccountID) && empty($AccountID)) { ?>
      <div class='red-box'>
        <h3>Uh oh!</h3>
        <div class='text'>You're not logged in! You won't have access to all the A3 Exile Portal features. To get access, <a href="<?php echo $dirUp ?>register">register here</a> or <a href="<?php echo $dirUp ?>?page=login">login here</a>.</div>
      </div>
      <?php } ?>
      <div class="alert alert-warning alert-dismissible" role="alert">
        <button type="button" class="close" style="float:left; color:black;" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</button></span> If you have a questions and its not on the <strong>FAQ</strong>. Please post it in the forums and let us
        know, we will then try to get it added to the FAQ.
      </div>

      <div class="panel-group" id="accordion">
        <div class="faqHeader" style="color: white">General questions</div>
        <div class="panel panel-default">
          <div class="panel-heading">
            <h4 class="panel-title">
              <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">Question here</a>
            </h4>
          </div>
          <div id="collapseOne" class="panel-collapse collapse ">
            <div class="panel-body" style="color: white">
              Honor Here
            </div>
          </div>
        </div>
        <div class="panel panel-default">
          <div class="panel-heading">
            <h4 class="panel-title">
              <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">Question here</a>
            </h4>
          </div>
          <div id="collapseTwo" class="panel-collapse collapse">
            <div class="panel-body" style="color: white">
              Honor Here
            </div>
          </div>
        </div>
        <div class="panel panel-default">
          <div class="panel-heading">
            <h4 class="panel-title">
              <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree">Question here</a>
            </h4>
          </div>
          <div id="collapseThree" class="panel-collapse collapse">
            <div class="panel-body" style="color: white">
              Honor Here
            </div>
          </div>
        </div>

        <div class="faqHeader" style="color: white">FAQ HEADER</div>
        <div class="panel panel-default">
          <div class="panel-heading">
            <h4 class="panel-title">
              <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseFour">Question here</a>
            </h4>
          </div>
          <div id="collapseFour" class="panel-collapse collapse">
            <div class="panel-body" style="color: white">
              Honor Here
            </div>
          </div>
        </div>

      </div>
  </div>
</div>
</div>
</div>

<style>
  .faqHeader {
    font-size: 27px;
    margin: 20px;
  }

  .panel-heading [data-toggle="collapse"]:after {
    font-family: 'Glyphicons Halflings';
    content: "\e072";
    /* "play" icon */
    float: right;
    color: #a92c44;
    font-size: 18px;
    line-height: 22px;
    /* rotate "play" icon from > (right arrow) to down arrow */
    -webkit-transform: rotate(-90deg);
    -moz-transform: rotate(-90deg);
    -ms-transform: rotate(-90deg);
    -o-transform: rotate(-90deg);
    transform: rotate(-90deg);
  }

  .panel-heading [data-toggle="collapse"].collapsed:after {
    /* rotate "play" icon from > (right arrow) to ^ (up arrow) */
    -webkit-transform: rotate(90deg);
    -moz-transform: rotate(90deg);
    -ms-transform: rotate(90deg);
    -o-transform: rotate(90deg);
    transform: rotate(90deg);
    color: #2e3233;
  }
</style>