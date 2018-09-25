
<div class="container">
	<h1 id="top">A3EP Documentation <small style="font-size: 17px;"><?php echo $lang['general_language_info']; ?> - <?php echo $lang['general_language_en_only']; ?></small></h1>
	<h3>Contents</h3>
	<ul>
		<li><a href="#introduction">Introduction</a></li>
		<li><a href="#pagemanager">Page Management</a></li>
		<li><a href="#statsClass">Statistics Functions</a></li>
		<li><a href="#rewrite">Signature Rewrite Rules</a></li>
	</ul>
	<br />
	<h3 id="introduction">Introduction <small>[<a href="#top">Top</a>]</small></h3>
	<div class="panel panel-default">
	  <div class="panel-body" style="color:white">
		Below is a brief documentation on how to use the this software.
	  </div>
	</div>
	
<h3 id="pagemanager">Page Management <small>[<a href="#top">Top</a>]</small></h3>

	<div class="panel panel-default">
	  <div class="panel-body">
		[1] - usable variables for statsClass
		<pre><code class="PHP">

</code></pre>
	  </div>
	</div>
	<h3 id="statsClass">statsClass <small>[<a href="#top">Top</a>]</small></h3>

	<div class="panel panel-default">
	  <div class="panel-body">
		[1] - usable variables for statsClass
		<pre><code class="PHP">
To use any one of the classes lised below while in the editor. Simply click the insert class button and select the required class.
// Gets the total Amount of players that have joined your server
$statsClass->getTotalusers();

// Gets the total amount of members that have joined your A3EP
$statsClass->getMembers();

// Gets the total money on players
$statsClass->getTotalMoneyPlayer();

// Returns total connections on your server
$statsClass->getTotalconnections();

// Returns total kills
$statsClass->getTotalKills();

// Returns total deaths
$statsClass->getTotalDeaths();

// Returns total poptabs in lockers
$statsClass->getTotalLocker();

// Returns total score
$statsClass->getTotalScore();

// Returns total users from PENDING users
$statsClass->getPendingUsers();

</code></pre>
	  </div>
	</div>
	<h3 id="rewrite">Signature Rewrite Rules <small>[<a href="#top">Top</a>]</small></h3>
		<div class="panel panel-default">
		  <div class="panel-body">
			To make your signatures more user friend you're able to use the following rewrite rules. These will convert your signatures from being "signature.php?id=X" to "/X/signature.png", meaning they can be used on the Multiplayer Forums and other places with ease. These are differnet for different webservers, please use the appropriate one for your webserver.
			<br /><br />
			<strong>Apache</strong><br />
			<pre><code>RewriteRule ^([0-9]+)/signature.png$ signature.php?id=$1</code></pre>

			<br /><br />
			<strong>NGinx</strong><br />
			<pre><code>rewrite "^/([0-9]+)/signature.png$" /signature.php?id=$1</code></pre>
		  </div>
		</div>
	</div>

</div>

