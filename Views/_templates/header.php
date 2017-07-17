	<nav class="navbar navbar-mvc navbar-fixed-top">
    	<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-nav" aria-expanded="false" aria-conrols="sidebar-nav">
                    <span class="sr-only">Toggle navigation</span>
                    <i class="fa fa-bars"></i>
                </button>
				<a href="<?php echo URL; ?>" class="navbar-brand"><img src="<?php echo URL; ?>img/logo_small_white.png" alt="PHP-MVC" /></a>
			</div>
            
            <div class="collapse navbar-collapse navbar-right">
            	<ul class="nav navbar-nav">
                	<?php if($this->loggedIn): ?>
                	<li<?php echo ($this->checkForActiveController(getCurrentController(), "Messages") ? ' class="active"' : ''); ?>>
                    	<a href="<?php echo URL."Messages"; ?>" title="Messages" data-toggle="tooltip" data-placement="bottom">
                    		<i class="fa fa-envelope"></i>
                        	<div class="label label-danger"><?php echo $this->user['msg_count']; ?></div>
                        </a>
                    </li>
                    <li>
                    	<a href="javascript:void(0);" title="Notifications" data-toggle="tooltip" data-placement="bottom">
                        	<i class="fa fa-bell"></i>
                            <div class="label label-danger">0</div>
                        </a>
                    </li>
                    <li>
                    	<a href="<?php echo URL."Logout"; ?>" title="SignOff" data-toggle="tooltip" data-placement="bottom">
                        	<i class="fa fa-power-off"></i>
                        </a>
                    </li>
                    <?php else: ?>
                    <li<?php echo ($this->checkForActiveController(getCurrentController(), "Login") ? ' class="active"' : ''); ?>>
                    	<a href="<?php echo URL."Login"; ?>" title="Login"><i class="fa fa-fw fa-sign-in"></i> Log In</a>
                    </li>
                    <li<?php echo ($this->checkForActiveController(getCurrentController(), "Register") ? ' class="active"' : ''); ?>>
                        <a href="<?php echo URL."Register"; ?>" title="Sign Up"><i class="fa fa-fw fa-ticket"></i> Sign Up</a>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
		</div>
    </nav>
	<div class="container-fluid">
    	<div class="row">
        	<div class="col-md-2 col-sm-3 sidebar" id="sidebar-nav" role="navigation">
				<ul class="nav nav-sidebar">
					<?php
						$i = 1;
						foreach($this->mvcs as $mvc) {
							echo '<li'.($this->checkForActiveController(getCurrentController(), $mvc['mvc_name']) ? ' class="active"' : '').'>';
							echo '<a href="'.URL.$mvc['mvc_name'].'"><i class="fa fa-fw fa-'.$mvc['mvc_fa'].'"></i> '.$mvc['mvc_name'].'</a>';
							echo '</li>';
							$i++;
						}
					?>
                    <li class="dropdown">
                    	<a href="#"><i class="fa fa-bars fa-fw"></i> Dropdown Example<i class="fa fa-chevron-down chevronInSidebar pull-right"></i></a>
                        <ul class="dropdown-mvc">
                        	<li><a href="javascript:void(0);"><i class="fa fa-fw fa-bomb"></i> Point 1!</a></li>
                            <li><a href="javascript:void(0);"><i class="fa fa-fw fa-bullhorn"></i> Point 2!</a></li>
                        </ul>
                    </li>
				</ul>
            </div>
            <div class="col-md-10 col-sm-9 col-md-offset-2 col-sm-offset-3">
            	<div class="main">
            		<?php echo '<h2>'.ucfirst(getCurrentController()).'</h2>'; ?>
                	<?php Page::breadcrumb(); ?>
                	<noscript><?php Alert::error('Please activate JavaScript!'); ?></noscript>
                	<div class="feedback-msg">
            			<?php $this->renderFeedbackMessages(); ?>