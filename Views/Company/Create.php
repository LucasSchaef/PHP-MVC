<div class="panel panel-default">
	<div class="panel-heading">Add Company</div>
    <div class="panel-body">
    	<form action="<?php echo URL.getCurrentController().'/Create'; ?>" method="post">
        	<div class="form-group">
            	<label for="company_name">Company Name:</label>
                <input type="text" name="company_name" id="company_name" class="form-control" />
            </div>
        </form>
    </div>
</div>