<div class="container-fluid">
	<div class="row">
    	<div class="col-md-3">
        	<div class="panel panel-message">
            	<div class="panel-heading">
                	<div class="row">
                		<div class="col-xs-5"><i class="fa fa-comment-o fa-5x"></i></div>
                    	<div class="col-xs-7 text-right">
                    	     <div class="huge"><?php echo $this->newMsg; ?></div>
                    	     <div> New Message<?php echo ($this->newMsg > 1 OR $this->newMsg == 0) ? "s" : ""; ?></div>
                        </div>
                    </div>
            	</div>
                <a href="<?php echo URL."Messages"; ?>">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-7">
                                Messages
                            </div>
                            <div class="col-xs-5 text-right">
                                <i class="fa fa-arrow-circle-right"></i>
                            </div>
                        </div>
                    </div>
            	</a>
            </div>
        </div>
        <div class="col-md-3">
        	<div class="panel panel-user">
            	<div class="panel-heading">
                	<div class="row">
                		<div class="col-xs-5"><i class="fa fa-users fa-5x"></i></div>
                    	<div class="col-xs-7 text-right">
                    	     <div class="huge">7</div>
                    	     <div> New Users</div>
                        </div>
                    </div>
            	</div>
                <a href="<?php echo URL."User"; ?>">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-7">
                                Users
                            </div>
                            <div class="col-xs-5 text-right">
                                <i class="fa fa-arrow-circle-right"></i>
                            </div>
                        </div>
                    </div>
            	</a>
            </div>
        </div>
        <div class="col-md-3">
        	<div class="panel panel-contributions">
            	<div class="panel-heading">
                	<div class="row">
                		<div class="col-xs-4"><i class="fa fa-book fa-5x"></i></div>
                    	<div class="col-xs-8 text-right">
                    	     <div class="huge">12</div>
                    	     <div> New Contributions</div>
                        </div>
                    </div>
            	</div>
                <a href="<?php echo URL."Contributions"; ?>">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-7">
                                Contributions
                            </div>
                            <div class="col-xs-5 text-right">
                                <i class="fa fa-arrow-circle-right"></i>
                            </div>
                        </div>
                    </div>
            	</a>
            </div>
        </div>
        <div class="col-md-3">
        	<div class="panel panel-something">
            	<div class="panel-heading">
                	<div class="row">
                		<div class="col-xs-5"><i class="fa fa-cab fa-5x"></i></div>
                    	<div class="col-xs-7 text-right">
                    	     <div class="huge">23</div>
                    	     <div> New Something</div>
                        </div>
                    </div>
            	</div>
                <a href="<?php echo URL."Something"; ?>">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-7">
                                Something
                            </div>
                            <div class="col-xs-5 text-right">
                                <i class="fa fa-arrow-circle-right"></i>
                            </div>
                        </div>
                    </div>
            	</a>
            </div>
        </div>
    </div>
	<div class="row">
		<div class="panel panel-default">
			<div class="panel-heading"><i class="fa fa-area-chart"></i> Visitor stats</div>
			<div class="panel-body">
				<?php echo $this->StatsChart; ?>
			</div>
		</div>
    </div>
</div>