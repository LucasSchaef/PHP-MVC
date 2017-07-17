<div class="container-fluid">
	<div class="panel panel-default">
    	<div class="panel-heading">Messages</div>
        <div class="panel-body">
        	<div class="col-lg-4">
            	<a class="btn btn-success" href="<?php echo URL.getCurrentController().'/Compose'; ?>"><i class="fa fa-plus"></i> New Message</a>
                <hr />
                <div class="messages-list">
                	<?php
						foreach($this->conversations as $id => $msg) {
							if($msg[0]['message_from'] == $this->user['user_ID']) {
								$msg[0]['message_read'] = true;
								$icon = 'reply';
							} else {
								$icon = 'caret-right';
							}
							
							if(date("d.m.Y", $msg[0]['message_sent']) == date("d.m.Y", time())) {
								$date_format = "h:i A";
							} else {
								$date_format = "d.m.Y h:i A";
							}
							
							echo '<a href="#" class="msg-link" id="'.$msg['other_user'].'">';
							echo '<div class="message-list'.(($msg[0]['message_read']) ? '' : ' new').'">';
							echo '<span class="pull-left msg_user">'.$msg['other_user'].'</span>';
							echo '<span class="pull-right msg_time">'.date($date_format, $msg[0]['message_sent']).'</span><br />';
							echo '<span class="pull-left msg_preview"><i class="fa fa-'.$icon.'"></i> '.substr($msg[0]['message_text'], 0, 40).'...</span>';
							echo '<span class="pull-right msg_read"><i class="fa fa-'.(($msg[0]['message_read']) ? 'check' : 'circle-thin').'"></i></span>';
							echo '</div>';
							echo '</a>';
						}
						?>
                </div>
            </div>
            <div class="col-lg-8">
            	<div class="msg-head"></div>
                <div class="message-view">
                	<div class="no_msg_selected text-center">No message selected</div>
                </div>
                <div class="msg-bottom">
                   	<form id="msg-reply" method="post" action="#" user="" style="display:none;">
						<div class="form-group">
							<textarea id="msg_msg" class="form-control" rows="3" style="resize:none;" placeholder="Reply..."></textarea>
						</div>
                    	<button type="submit" class="btn btn-default">Send</button>
					</form>
				</div>
            </div>
     	</div>
    </div>
</div>
<script>
	<?php
		if(getCurrentAction()):	
	?>
		// Load Messages from URL-Data
		$(function() {
			$('a#<?php echo getCurrentAction(); ?> div.message-list').addClass('active');
			var d = $("div.message-view");
			d.html('<div class="text-center"><i class="fa fa-1x fa-refresh fa-spin"></i></div>');
			var name = '<?php echo getCurrentAction(); ?>';
			$.get("<?php echo URL.'Messages/Conversation/';?>"+name,function(data,status){
				$('form#msg-reply').css('display', 'block').attr('name', name);
				$("div.msg-head").append('<h3>'+name+'</h3>');
				var d = $("div.message-view");
				d.html(data).scrollTop(d.prop('scrollHeight'));
			});
		});
	<?php
		endif;
	?>
	// Load Message after a conversation has been clicked on
	$('a.msg-link').click(function(event) {
		event.preventDefault(); // Prevents the default event of the link so there is no '#' in the URL
		
		var d = $("div.message-view");
		
		// This is what shows up during AJAX is loading
		d.html('<div class="text-center"><i class="fa fa-1x fa-refresh fa-spin"></i></div>');
		
		// Change active msg
		$('div.message-list').removeClass('active');
		$('div.message-list',this).addClass('active').removeClass('new');
		$('div.message-list>.msg_read>i', this).attr('class', 'fa fa-check');
		
		var name = $(this).attr('id');
		history.pushState({}, '', '<?php echo URL.'Messages/'; ?>'+name+'/');
		$.get("<?php echo URL.'Messages/Conversation/';?>"+name,function(data,status){
			$('form#msg-reply').css('display', 'block').attr('name', name);
			$("div.msg-head").html('<h3>'+name+'</h3>');
			var d = $("div.message-view");
			d.html(data).scrollTop(d.prop('scrollHeight'));
		});
	});
	
	$('form#msg-reply').submit(function(event) {
		event.preventDefault();
		var name = $(this).attr('name'),
		d = $("div.message-view"),
		msg = $('textarea#msg_msg').val();
		if(msg == '') {
			$('div.form-group', this).addClass('has-error');
			$('textarea#msg_msg').after('<p class="help-block">Please type in your message!</p>');
		} else {
			$.post("<?php echo URL.'Messages/Reply'; ?>", { msg_to : name, msg_msg : msg }, function(data,status){
				$('div.message-view').append(data);
				$('div#reply').show('slow');
				d.scrollTop(d.prop('scrollHeight'));
			});
		}
	});
</script>