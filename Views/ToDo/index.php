<div class="container-fluid">
	<div class="panel panel-default">
    	<div class="panel-heading">ToDo</div>
        <div class="panel-body">
        	<a href="<?php echo URL.getCurrentController()."/Create"; ?>" class="btn btn-success"><i class="fa fa-plus"></i> Create Task</a><br /><br />
            <?php echo button::write(URL.getCurrentController()."/Gantt", "Gantt"); ?>
			<?php
				if($this->tasks['overdue'] > 0 OR $this->tasks['late'] > 0) {
					$text = "You have ";

					if($this->tasks['overdue'] == 1) {
						$text .= "one task that is overdue";	
					} elseif($this->tasks['overdue'] > 1) {
						$text .= $this->tasks['overdue']." tasks that are overdue";	
					}
					
					if($this->tasks['overdue'] > 0 && $this->tasks['late'] > 0) {
						$text .= " and ";	
					}
					
					if($this->tasks['late'] == 1) {
						$text .= "one task that will be overdue within the next seven days";	
					} elseif($this->tasks['late'] > 1) {
						$text .= $this->tasks['late']." tasks that will be overdue within the next seven days";	
					}
					
					$text .= ".";
					
					if($this->tasks['overdue'] > 0) {
						Alert::error($text, 'Watch Out!');
					} else {
						Alert::warning($text, 'Note:');
					}
				}
			?>
            <table class="table table-striped">
            	<thead>
                	<tr class="text-center">
                    	<th>Task ID</th>
                        <th>Importance</th>
                        <th>Task Name</th>
                        <th>Start</th>
                        <th>End</th>
                        <th>Progress</th>
                        <th>Options</th>
                	</tr>
                </thead>
                <tbody>
                	<?php
						echo $this->tasks['tasks'];
					?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
	$('input#ranger').mousedown(function () {
			$('span#r_val').text = $(this).val();
	});

	$('td.task_options a.task_done, a.task_add_10').click(function(event) {
		event.preventDefault();
		$(this).tooltip('destroy');
		var task_ID = $(this).attr('id'),
		type = $(this).attr('class'),
		task_row = $('tr#'+task_ID),
		task_link = $(this);
		
		if(type == 'task_add_10') {
			$('i', task_link).toggleClass('fa-plus').toggleClass('fa-refresh fa-spin');
			var task_pro = parseInt($('td>div>div', task_row).attr('aria-valuenow')) + 10,
			to_class = 'fa-plus';	
		} else {
			$('i', task_link).toggleClass('fa-check').toggleClass('fa-refresh fa-spin');
			var task_pro = 100,
			to_class = 'fa-check';
		}
		
		$.post('<?php echo URL.getCurrentController().'/updateProgress'; ?>', { task_ID : task_ID, task_progress : task_pro }, function(data, status) {
			if(task_pro >= 100) {
				task_row.removeClass('danger').toggleClass('success');
				$('a.task_done, a.task_add_10', task_row).hide('fast');
			}
			
			$('i', task_link).toggleClass(to_class).toggleClass('fa-refresh fa-spin');
			
			if(type == 'task_done') {
				$(task_link).css('pointer-events', 'none');	
			}

			$('td>div>div', task_row).attr('aria-valuenow', task_pro).css('width', task_pro+'%');
		}).fail(function() {
			$('td.task_options', task_row).html('<span class="text-danger">Error!</span>').css('pointer-events', 'none');
		});
	});
</script>