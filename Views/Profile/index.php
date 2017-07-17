<div class="container-fluid">
	<div class="row">
		<div class="col-md-6">
			<div class="panel panel-default">
            	<div class="panel-heading"><h3 class="panel-title">Profile</h3></div>
                <div class="panel-body">
                    <form autocomplete="off" id="usr_profile" method="post" action="#">
                        <div class="form-group">
                            <label for="usr_name">Username</label>
                            <input type="text" class="form-control" id="usr_name" name="usr_name" disabled="disabled" value="<?php echo $this->user['user_name']; ?>" />
                            <p class="help-block">Note: You cannot change your username for security reasons. If you want to change it, please send an email using our contact form.</p>
                        </div>
                        <div class="form-group">
                            <label for="usr_email">Email</label>
                            <input type="email" class="form-control" id="usr_email" name="usr_email" value="<?php echo $this->user['user_email']; ?>" />
                        </div>
                        <div class="form-group has-feedback" id="usr_email_rep" style="display:none;">
                            <label for="usr_email_rep">Repeat email</label>
                            <input type="email" class="form-control" id="usr_email_rep" name="usr_email_rep" placeholder="Please repeat the email..." />
                            <p class="help-block">You changed the email. Please repeat it here to verify it.</p>
                        </div>
                        <div class="form-group">
                            <label for="usr_password">Password</label>
                            <input type="password" class="form-control" id="usr_password" name="usr_password" placeholder="Type to change password..." />
                        </div>
                        <div class="form-group has-feedback" id="usr_password_rep" style="display:none">
                            <label for="usr_password_rep">Repeat password</label>
                            <input type="password" class="form-control" id="usr_password_rep" name="usr_password_rep" placeholder="Please repeat the password..." />
                            <p class="help-block">You changed the password. Please repeat it here to verify it.</p>
                        </div>
                        <button id="submit" type="submit" class="btn btn-default" style="display:none;">Save</button>
					</form>
				</div>
            </div>
		</div>
        <div class="col-md-6">
        	<div class="panel panel-default">
            	<div class="panel-heading"><h3 class="panel-title">Avatar</h3></div>
                <div class="panel-body">
                	<div class="col-md-3">
                		<img src="<?php echo URL.$this->user['user_avatar']; ?>" alt="<?php echo $this->user['user_name']; ?>" class="thumbnail" style="height:100px; width:100px;" />
                	</div>
                    <div class="col-md-9">
                    	<form id="usr_avatar" method="post" action="#">
                        	<div class="form-group">
                            	<label for="usr_avatar">Upload new avatar</label>
                            	<input type="file" id="usr_avatar" name="usr_avatar" />
                            </div>
                            <button type="submit" class="btn btn-default">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
	</div>
</div>
<script>
	$('input#usr_email').keyup(function() {
		$('div#usr_email_rep').show('slow');
	});
	
	$('input#usr_email_rep').keyup(function() {
		if($(this).val() == $('input#usr_email').val()) {
			$('div#usr_email_rep')
				.removeClass('has-error')
				.addClass('has-success');
			if($('div#usr_email_rep span.form-control-feedback').length == 0) {
				$('input#usr_email_rep').after('<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>');
			} else {
				$('div#usr_email_rep span.form-control-feedback').removeClass('glyphicon-remove').addClass('glyphicon-ok');
			}
			$('button#submit').show('fast');
		} else {
			$('div#usr_email_rep')
				.removeClass('has-success')
				.addClass('has-error');
			if($('div#usr_email_rep span.form-control-feedback').length == 0) {
				$('input#usr_email_rep').after('<span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>');
			} else {
				$('div#usr_email_rep span.form-control-feedback').removeClass('glyphicon-ok').addClass('glyphicon-remove');
			}
			$('button#submit').hide('fast');
		}
	});
	
	$('input#usr_password_rep').keyup(function() {
		if($(this).val() == $('input#usr_password').val()) {
			$('div#usr_password_rep')
				.removeClass('has-error')
				.addClass('has-success');
			if($('div#usr_password_rep span.form-control-feedback').length == 0) {
				$('input#usr_password_rep').after('<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>');
			} else {
				$('div#usr_password_rep span.form-control-feedback').removeClass('glyphicon-remove').addClass('glyphicon-ok');
			}
			$('button#submit').show('fast');
		} else {
			$('div#usr_password_rep')
				.removeClass('has-success')
				.addClass('has-error');
			if($('div#usr_password_rep span.form-control-feedback').length == 0) {
				$('input#usr_password_rep').after('<span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>');
			} else {
				$('div#usr_password_rep span.form-control-feedback').removeClass('glyphicon-ok').addClass('glyphicon-remove');
			}
			$('button#submit').hide('fast');
		}
	});
	
	$('input#usr_password').keyup(function() {
		$('div#usr_password_rep').show('slow');
	});
	
	$('form#usr_profile').submit(function(event){
		event.preventDefault();
		
		if($('input#usr_email').val() != '<?php echo $this->user['user_email']; ?>') {
			if($('input#usr_email_rep').val() == '')  {
				$('div#usr_email_rep').addClass('has-error');
				$('div#usr_email_rep p').text('Please repeat the email.');
				return false;
			} else if($('input#usr_email_rep').val() != $('input#usr_email').val()) {
				$('div#usr_email_rep').addClass('has-error');
				$('div#usr_email_rep p').text('The repition does not match the original.');
				return false;
			} else {
				var email = $('input#usr_email').val();	
			}
		}
		
		if($('input#usr_password').val() != '') {
			if($('input#usr_password_rep').val() == '')  {
				$('div#usr_password_rep').addClass('has-error');
				$('div#usr_password_rep p').text('Please repeat the password.');
				return false;
			} else if($('input#usr_password_rep').val() != $('input#usr_password').val()) {
				$('div#usr_password_rep').addClass('has-error');
				$('div#usr_password_rep p').text('The repition does not match the original.');
				return false;
			} else {
				var password = $('input#usr_password').val();	
			}
		}
		
		var button = $('button', this);
		button.html('<i class="fa fa-refresh fa-spin"></i> Saving...');
		$.post('<?php echo URL.getCurrentController().'/Save'; ?>', { usr_email : email, usr_pw : password }, function(data, status) {
			$('div.feedback-msg').html(data);
			button.attr('class', 'btn btn-success').attr('disabled', 'disabled').html('<i class="fa fa-check"></i> Saved!');	
		});
		
	});
	
	$('form#usr_avatar').submit(function (event) {
			event.preventDefault();
			var extension = $('input', this).val().split('.').pop().toLowerCase(),
			allowed = ['gif', 'jpg', 'jpeg', 'png'];
			
			if($.inArray(extension, allowed) != -1) {
				$.post('<?php echo URL.getCurrentController().'/SaveAvatar'; ?>', $(this).serialize(), function(data, status) {
					alert(data);
				});
			} else {
				$('div.form-group', this).addClass('has-error');
				$('input', this).after('<p class="help-block">Invalid file extension!</p>');
			}
	});
</script>
