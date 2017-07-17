<?php
	$files = scandir($this->mvc['mvc_view_folder']);
	$view_files = array_slice($files, 2, count($files));
?>

<div class="container-fluid">
	<div class="panel panel-default">
    	<div class="panel-heading">Edit MVC</div>
        <div class="panel-body">
        	<div class="container-fluid">
                <div class="row">
                    <div class="col-lg-3" id="file_nav">
						<ul class="nav nav-pills nav-stacked">
                        	<li><a href="#" id="Overview">Overview</a></li>
							<li><a href="#" id="<?php echo $this->mvc['mvc_controller']; ?>">Controller</a></li>
                            <li><a href="#" id="<?php echo $this->mvc['mvc_model']; ?>">Model</a></li>
                            <li class="dropdown">
                            	<a class="dropdown-toggle" data-toggle="dropdown" href="#" id="Views">Views <i class="fa fa-caret-down pull-right"></i></a>
                                <ul class="dropdown-menu">
                                	<?php
										foreach($view_files as $vf) {
											echo '<li><a href="#" class="view_file" id="'.$this->mvc['mvc_view_folder']."/".$vf.'">'.strstr($vf, '.', true).'</a></li>';	
										}
									?>
                                </ul>
                        	</li>
                    	</ul>
                        <br />
                        <a href="#" id="add_view" class="btn btn-success"><i class="fa fa-plus"></i> Add View</a>
                    </div>
                    <div class="col-lg-9" id="edit_content">
						<form id="edit_form" action="#" method="post">
                        	<div class="form-group text-center">
                            	<p class="help-block">Please select a file from the left to edit it.</p>
                            </div>
                        </form>
                    </div>
                </div>
        	</div>
        </div>
    </div>
</div>
<script>
	$('div#file_nav a').not('a#Views').click(function(event) {
		event.preventDefault();
		var id = $(this).attr('id');
		
		$.post('<?php echo URL.getCurrentController().'/getEditContent'; ?>', { file : id }, function(data, status) {
				$('form#edit_form').html(data);
		});
	});
	
	$('form#edit_form').submit(function(event) {
		event.preventDefault();
		var file = $('textarea', this).attr('name'),
		file_content = $('textarea', this).val();
		$('button', this).html('<i class="fa fa-refresh fa-spin"></i> Saving');
		$.post('<?php echo URL.getCurrentController().'/saveFileChanges'; ?>', { file : file, file_content : file_content }, function(data, status) {
			$('form#edit_form button').html('<i class="fa fa-check"></i> Saved').removeClass('btn-default').removeClass('btn-danger').addClass('btn-success').attr('disabled', true);
		}).fail(function(data) {
			$('form#edit_form button').html('<i class="fa fa-times"></i> Error').removeClass('btn-default').removeClass('btn-success').addClass('btn-danger').attr('disabled', true);
		});
	});
</script>
