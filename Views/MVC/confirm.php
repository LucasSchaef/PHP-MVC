<div class="confirm">
Are you sure that you want to delete the <?php echo $this->delName; ?>-MVC?<br /><br />
<?php 	echo button::write($this->currentPath().'/Yes', "Yes", "btn btn-danger", "trash")." ";
		echo button::write(URL.$this->activeController(), "Cancel", "btn btn-default", "times"); ?>
</div>