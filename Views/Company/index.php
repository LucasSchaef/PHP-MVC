<div class="container-fluid">
	<div class="panel panel-default">
    	<div class="panel-heading">Company</div>
        <div class="panel-body">
        	<?php
				echo button::write(URL.getCurrentController()."/Create", "New Company");
				echo $this->list;
			?>
        </div>
    </div>
</div>