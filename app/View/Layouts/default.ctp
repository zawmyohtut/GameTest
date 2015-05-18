<?php
/*
  default.thtml design for CakePHP (http://www.cakephp.org)
  ported from http://contenteddesigns.com/ (open source template)
  ported by Shunro Dozono (dozono :@nospam@: gmail.com)
  2006/7/6
*/
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Games Manager - <?php echo $title_for_layout?></title>
<meta name="description" content="Website description" />
<meta name="keywords" content="keyword1,keyword2,keyword2,keyword4" />
<?php echo $this->Html->css('cake.generic', 'stylesheet', array("media"=>"all" ));?>
<?php echo $this->Html->css('style', 'stylesheet', array("media"=>"all" ));?>
</head>
<body>

<div id="header">

<!--<div id="contact"><a href="#">Contact</a></div> -->

<div id="title">Games Library</div>

<div id="slogan">Manage your list of games,'easily'.</div>

</div> <!-- end header -->

<div id="sidecontent">
<h2>Games Manager</h2>
<ul id="nav">
<!--<li><a class="selected" href="#">Home</a></li> -->

<?php if(AuthComponent::user()):?>
<li><a href="/GameTest/Users/logout">Log Out</a></li>	
<?php else: ?>
<li><a href="/GameTest/Users/login">Log In</a></li>	
<?php endif;?>

<li><a href="/GameTest/Games">Games</a></li>
<li><a href="/GameTest/Categories">Categories</a></li>
<li><a href="/GameTest/Users">Users</a></li>
<!-- 
<li><a href="http://api.cakephp.org/">API</a></li>
<li><a href="http://bakery.cakephp.org">Bakery</a></li>
<li><a href="https://trac.cakephp.org">Trac</a></li>
<li><a href="http://cakeforge.org">CakeForge</a></li>
-->

</ul>

<!-- 
<h2>News</h2>

<ul>
<li><a href="#"> News item link 1</a> (May 14, 2006)</li>
<li><a href="#"> News item link 2</a> (May 11, 2006)</li>
<li><a href="#"> News item link 3</a> (May 2, 2006)</li>
</ul>

<h2>Notes</h2>
<ul>
<li> Marginal note that explains something.</li>
</ul>


<h2>Links</h2>
<ul>
<li><a href="#"> Related link 1</a></li>
<li><a href="#"> Related link 2</a></li>
</ul>
-->


</div> <!-- end sidecontent -->

<div id="maincontent">
		
		<?php
		
		    echo $this->fetch('content');
			print $this->Session->flash("flash", array("element" => "alert"));
		?>
		

</div> <!-- end maincontent -->

<div id="footer">

<div id="copyright">
Copyright &copy; 2015 Zaw Myo Htut |
Design by <a href="http://ContentedDesigns.com">Contented Designs</a>
</div>

<div id="footercontact">
<a href="#">Contact</a>
</div>

</div>



</body>
</html>


