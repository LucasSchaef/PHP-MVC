<div class="container-fluid">
	<div class="panel panel-default">
    	<div class="panel-heading">Usergroups</div>
        <div class="panel-body">
        
			<?php
				echo button::write(URL.getCurrentController(), 'User', 'btn btn-default', 'user').' ';
				echo button::write("#", "Usergroups", "btn btn-default", "users", true).' ';
				echo $this->userGroupList; 
				echo button::write(getCurrentPath()."/Create", "Create Group", "btn btn-success", "plus");
			?>
        </div>
    </div>
</div>