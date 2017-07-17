<div class="container-fluid">
	<?php echo button::write(URL.$this->activeController()."/Create", "Create MVC", "btn btn-success", "plus"); ?><br /><br />
    <div class="panel panel-default">
        <div class="panel-heading">MVC's</div>
        <div class="panel-body">
        	<?php echo $this->MVCList; ?>
        </div>
    </div>
</div>
