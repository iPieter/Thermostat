<div id="topbar"> 

<nav class="navbar navbar-default" role="navigation">
  <div class="container-fluid">

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="dropdown" id="add"><a id="btn" href="#" href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-plus"></span> Add</a>
          <ul class="dropdown-menu">
            <li><a href="<?php echo $baseurl?>devices/add_file.php">Add new file</a></li>
            <li><a href="<?php echo $baseurl?>devices/add_file.php">Add new folder</a></li>
            <li class="divider"></li>
            <li><a href="#">Manage folders</a></li>
            <li class="divider"></li>
            <li><a href="#">Manage locations</a></li>
          </ul>
        </li>
      </ul>
      <form class="navbar-form navbar-left" role="search">
		<div class="input-group">
			<span class="input-group-btn">
				<button type="submit" class="btn btn-default" ><span class="glyphicon glyphicon-search"></span></button>
			</span>
			<input type="text" class="form-control" placeholder="Search">

		</div>
	</form> 
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>


<!--<nav class="navbar navbar-default" role="navigation">
	<div class="container-fluid">	

	<div id="searchbar" class="top">
	<form class="navbar-form navbar-left" role="search">
		<div class="input-group">
			<span class="input-group-btn">
				<button type="submit" class="btn btn-default" ><span class="glyphicon glyphicon-search"></span></button>
			</span>
			<input type="text" class="form-control" placeholder="Search">

		</div>
	</form> 
	</div>
	
	<div id="actionbtn" class="top"> 
	
		<span class="glyphicon glyphicon-th"></span>
	
	</div>
	</div>

</nav> -->
</div>