<?php if(!isset($include)){die("INVALID REQUEST");} ?>
<?php
if(isset($_GET["post"]))
{
	  $query = "SELECT id, title, content, date, username FROM ".$tblpre."blog_post WHERE ID = :id";
						$query_params = array(
						':id' => (filter_var($_GET["post"] , FILTER_SANITIZE_FULL_SPECIAL_CHARS))
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
    $data = $stmt->fetch();
	$count = $stmt->rowcount();


	?>
	<div class="container">
		<div class="row">
			<div class="col-sm-10 col-sm-offset-1">
				<div class="underlined-title" >
					<h1 style="color:white">
						<?php echo stripslashes($data['title']); ?>
					</h1>
					<h3 style="color:Grey">
						<?php echo $langs->word($dlang,'author');?>: <?php echo $userClass->getUserUsername($data['username']); ?><br>
						<?php echo $langs->word($dlang,'date_posted');?>: <?php echo date('F j, Y g:i A', strtotime($data["date"])); ?>
					</h3>
					<hr>
					<div style="color:white"><?php echo stripslashes($data['content']);?></div>
				</div>
				<hr>
				<br>
				<?php
					$tid = (filter_var($_GET["post"] , FILTER_SANITIZE_FULL_SPECIAL_CHARS));
				?>
				<div id="disqus_thread"></div>
					<script>
						var dshortcode = "<?php echo $settingClass->getSetting('disqus_shortcode');?>";
						var disqus_config = function () {
						   this.page.url = '<?php echo $INFO['base_url'];?>?page=blog&post=<?php echo $tid;?>';  // Replace PAGE_URL with your page's canonical URL variable
						        this.page.identifier = '<?php echo $tid;?>'; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
							this.page.title = '<?php echo $data["title"];?> - Blog';  // Replace PAGE_URL with your page's canonical URL variable
						};

						(function() { // DON'T EDIT BELOW THIS LINE
							var d = document, s = d.createElement('script');
							s.src = "https://"+ dshortcode +".disqus.com/embed.js";
							s.setAttribute('data-timestamp', +new Date());
							(d.head || d.body).appendChild(s);
						})();
					</script>
					<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
					<p><a class="btn btn-primary btn-lg" href="?page=blog" role="button"><?php echo $langs->word($dlang,'general_return');?></a></p>
			</div>
		</div>
	</div>
	<?php } else {
		$offset = 0;
		$page_result = 3;
		if($_GET['p'] == 0 || !isset($_GET['p']))
		{
			header("location: ?page=blog&p=1");
			exit();
		}
		if($_GET['p'])
		{
			$page_value = $_GET['p'];
			if($page_value > 1)
			{
		  		$offset = ($page_value - 1) * $page_result;
		 	}
		}
	    $query = "SELECT id, title, content, date, username FROM ".$tblpre."blog_post ORDER BY id DESC LIMIT $offset, $page_result";
	    try
	    {
	        $stmt = $db->prepare($query);
	        $stmt->execute();
	    }
	    catch(PDOException $ex)
	    {
	        die("Failed to run query: " . $ex->getMessage());
	    }
	    $rows = $stmt->fetchAll();


	    $query2 = "SELECT id, title, content, date, username FROM ".$tblpre."blog_post ORDER BY id DESC";
	    try
	    {
	        $stmt2 = $db->prepare($query2);
	        $stmt2->execute();
	    }
	    catch(PDOException $ex)
	    {
	        die("Failed to run query: " . $ex->getMessage());
	    }
		$count = $stmt2->rowcount();
	?>
	<div class="container">
		<div class="row">
			<h1><span class="orange"><?php echo $langs->word($dlang,'blog');?> </span></h1>
			<div class="col-md-12">
				<div class="col-lg-8">
					<?php if($count == 0) { ?>
					<div class="blog-post">
						<p><?php echo $lang['no_blog_post'];?></p>
					</div>
					<?php } else foreach($rows as $row1): ?>
					<?php
						$userid = $row1['username'];
						$db2 = $row1['date'];
						$timestamp = strtotime($db2);
						$query = "SELECT username	FROM ".$tblpre."users WHERE id = :id";
						$query_params = array(
							':id' => $userid
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
						$row2 = $stmt->fetch();
					?>
					<div class="blog-listing-row">
						<h1>
							<span class="white"><?php echo stripslashes($row1['title']); ?></span>
						</h1>
						<p class="blog-post-meta">Submitted By:
							<?php echo $row2['username']; ?> on
							<?php echo date('F j, Y g:i A', $timestamp); ?>
						</p>
						<p>
							<?php echo stripslashes(substr($row1['content'], 0, 200)). "..."; ?>
						</p>
						<p><a class="btn btn-primary btn-lg" href="?page=blog&post=<?php echo $row1['id'];?>" role="button"><?php echo $langs->word($dlang,'learn_more');?></a></p>
					</div>
					<?php endforeach; ?>
					<nav aria-label="...">
					  	<ul class="pager">
							<?php
								$pagecount = $count;// Total number of rows
								$num1 = ceil($pagecount / $page_result);
								$num = (int)$_GET['p'];
								$float = (float)$num;
								if($float > 1)
								{
								 echo "<li class='previous'><a href='?page=blog&p=".($float - 1)."'><span aria-hidden='true'>&larr;</span> Older</a></li>";
								}

								if($num1 != $num)
								{
								 echo "<li class='next''><a href='?page=blog&p=".($float+ 1)."'>Newer <span aria-hidden='true'>&rarr;</span></a></li>";
								} ;
							?>
						</ul>
					</nav>
				</div>
				<div class="col-lg-4" style="padding-left:15px">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title"><?php echo $langs->word($dlang,'blog_menu');?></h3>
						</div>
						<div class="panel-body">
							menu coming soon
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php }?>