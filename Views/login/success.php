<?php
		if(!isset($this->to)) {
			$this->to = "Overview";
		}
	?>
<div class="container-fluid">
	<div class="row">
    	<div class="col-md-6 col-md-offset-3" style="margin-top:20px;">
        	<?php $this->renderFeedbackMessages(); ?>
        </div>
    </div>
</div>   
 
<script>
	window.setTimeout('window.location = "<?php echo URL.$this->to; ?>"',5000);
</script>