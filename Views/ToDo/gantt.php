<div class="panel panel-default">
	<div class="panel-heading">Gantt View</div>
    <div class="panel-body">
    	<?php
			$gantt = new gantt($this->tasks);
			$gantt->write();
		?>
    </div>
</div>