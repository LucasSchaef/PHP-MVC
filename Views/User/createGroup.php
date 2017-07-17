<div class="container-fluid">
	<div class="panel panel-default">
    	<div class="panel-heading">Create Usergroup</div>
        <div class="panel-body">
        	<?php
				$form = new form($this->currentPath(), "post");
				$form->text("Name", "group_name");
				$form->submit("Create");
				$form->write();
			?>
        </div>
    </div>
</div>