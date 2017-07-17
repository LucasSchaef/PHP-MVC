<div class="container-fluid">
	<div class="panel panel-default">
    	<div class="panel-heading">Edit Task "<?php echo $this->task['task_name']; ?>"</div>
        <div class="panel-body">
        	<form id="task_edit" method="post" action="#">
            	<input type="hidden" id="task_ID" name="task_ID" value="<?php echo $this->task['task_ID']; ?>" />
            	<div class="form-group">
                	<label for="task_name">Task-Name</label>
                    <input id="task_name" name="task_name" class="form-control" type="text" value="<?php echo $this->task['task_name']; ?>" />
            	</div>
                <div class="form-group">
                	<label for="task_progress">Task-Progress</label>
                    <input id="task_progress" name="task_progress" type="range" value="<?php echo $this->task['task_progress']; ?>" min="0" max="100" />
                	<p class="help-block">Current Progress: <span id="task_progress" class="text-success"><?php echo $this->task['task_progress']; ?></span>%</p>
                </div>
                <div class="form-group">
                	<label for="task_start">Task-Start</label>
                    <input id="task_start" class="form-control" type="text" value="<?php echo date('m/d/Y', $this->task['task_start']); ?>" />
                </div>
                <div class="form-group">
                	<label for="task_end">Task-End</label>
                    <input id="task_end" class="form-control" type="text" value="<?php echo date('m/d/Y', $this->task['task_end']); ?>" />
                </div>
                <div class="form-group">
                	<label for="task_short_desc">Short description</label>
                    <textarea id="task_short_desc" class="form-control" rows="3"><?php echo $this->task['task_short_desc']; ?></textarea>
                </div>
                <div class="form-group">
                	<label for="task_long_desc">Long description</label>
                    <textarea id="task_long_desc" class="form-control" rows="5"><?php echo $this->task['task_long_desc']; ?></textarea>
                </div>
                <button type="submit" class="btn btn-default"><i class="fa fa-save"></i> Save</button>
                <a href="<?php echo URL.getCurrentController(); ?>" class="btn btn-danger"><i class="fa fa-times"></i> Cancel</a>
            </form>
        </div>
    </div>
</div>
<script>
	 $(function() {
		$( "input#task_start" ).datepicker({
			defaultDate: '<?php echo date('m/d/Y', $this->task['task_start']); ?>',
			showButtonPanel: true	
		});
		
		$( "input#task_end" ).datepicker({
			defaultDate: '<?php echo date('m/d/Y', $this->task['task_end']); ?>',
			showButtonPanel: true	
		});
	});

	$(function() {
		var range = $('input#task_progress');
		
		if(range.val() >= 90) {
			range.attr('class', 'success');
		} else if(now_val >= 60) {
			range.attr('class', 'info');	
		} else if(now_val >= 30) {
			range.attr('class', 'warning');
		} else {
			range.attr('class', 'danger');
		}
			
	});

	$('input#task_progress').on('input', function() {
		var currentValue = $('span#task_progress'),
		range = $('input#task_progress');
		
		range.on('input', function(){
			var now_val = range.val();
			
			if(now_val >= 90) {
				currentValue.attr('class', 'text-success');
				range.attr('class', 'success');
			} else if(now_val >= 60) {
				currentValue.attr('class', 'text-info');
				range.attr('class', 'info');	
			} else if(now_val >= 30) {
				currentValue.attr('class', 'text-warning');	
				range.attr('class', 'warning');
			} else {
				currentValue.attr('class', 'text-danger');
				range.attr('class', 'danger');
			}
			
    		currentValue.html(range.val());
		}); 
	});

	$('form#task_edit').submit(function(event) {
		event.preventDefault();
		var data = {
					task_ID : $('input#task_ID', this).val(),
					task_name : $('input#task_name', this).val(),
					task_progress : $('input#task_progress', this).val(),
					task_start : $('input#task_start', this).val(),
					task_end : $('input#task_end', this).val(),
					task_short_desc : $('textarea#task_short_desc', this).text(),
					task_long_desc : $('textarea#task_long_desc', this).text()
		};
		
		$('button[type=submit]', this).html('<i class="fa fa-refresh fa-spin"></i> Saving...').attr('disabled', 'disabled');
		
		$.post('<?php echo URL.getCurrentController().'/saveChanges'; ?>', data, function(data, status) {
			$('button[type=submit]').html('<i class="fa fa-check"></i> Saved').attr('class', 'btn btn-success');
		}).fail(function() {
			$('button[type=submit]').html('<i class="fa fa-times"></i> Error').attr('class', 'btn btn-danger');
		});
		
	});
</script>