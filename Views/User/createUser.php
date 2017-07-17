<div class="container-fluid">
	<div class="panel panel-default">
    	<div class="panel-heading">Create user</div>
        <div class="panel-body">
        	<form method="post" action="<?php echo getCurrentPath(); ?>">
            	<div class="form-group">
                	<label for="task_name">Task-Name</label>
                    <input class="form-control" type="text" id="task_name" name="task_name" placeholder="Task-Name" />
                </div>
                <div class="form-group">
                	<label for="task_start_date">Starting date</label>
                    <input class="form-control" type="text" id="task_start_date" name="task_start_date" placeholder="Select date..." />
                </div>
                <div class="form-group">
                	<label for="task_end_date">Ending date</label>
                    <input class="form-control" type="text" id="task_end_date" name="task_end_date" placeholder="Select date..." />
                </div>
                <div class="form-group">
                	<label for="task_importance">How important is this project?</label>
                    <select id="task_importance" name="task_importance" class="form-control">
                    	<option value="1">Very Important</option>
                        <option value="2">Medium</option>
                        <option value="3">Not so important</option>
                    </select>
                </div>
                <div class="form-group">
                	<label for="task_short_desc">Short Description</label>
                    <textarea class="form-control" rows="3" id="task_short_desc" name="task_short_desc" placeholder="Short Description..."></textarea>
                </div>

                
                <button type="submit" class="btn btn-default"><i class="fa fa-save"></i> Save</button>
            </form>
        </div>
    </div>
</div>