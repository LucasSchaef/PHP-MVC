<div class="container-fluid">
	<div class="panel panel-default">
    	<div class="panel-heading">User</div>
        <div class="panel-body">
        	<div class="row">
                <div class="col-md-3">
					<?php 
                        echo button::write('#', 'User', 'btn btn-default', 'user', true).' ';
                        echo button::write(getCurrentPath()."Groups", "Usergroups", "btn btn-default", "users");
                    ?>
                </div>
                <div class="col-md-5">
                	<form method="post" action="<?php echo getCurrentPath(); ?>">
                        <div class="form-group">
                            <input class="form-control" type="text" name="AjaxSearch_user_name" id="AjaxSearch_user_name" placeholder="Search User..." />
                        </div>
            		</form>
                </div>
            </div>
            <div class="row" id="user_list">
            <?php
				echo $this->UserList; 
			?>
            </div>
            <div class="row">
            <?php
				echo button::write(getCurrentPath()."Create", "Create User", "btn btn-success", "plus");
			?>
            </div>
        </div>
    </div>
</div>

<script>
	$('input#AjaxSearch_user_name').keyup(function(event) {
		var AjaxSearch_user_name = $(this).val();
		
		$.post('<?php echo URL.getCurrentController().'/AjaxUserSearch'; ?>', {AjaxSearch_user_name : AjaxSearch_user_name}, function(data, status) {
			$('div#user_list').html(data);
		});
	});
</script>