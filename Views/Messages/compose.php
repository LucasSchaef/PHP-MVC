<div class="container-fluid">
	<div class="row">
    	<div class="panel panel-default">
        	<div class="panel-heading">New Message</div>
            <div class="panel-body">
            	<form autocomplete="off" role="form" method="post" action="<?php echo URL.getCurrentController().'/Send'; ?>">
                	<div class="form-group">
                    	<label for="msg_to">To</label>
                        <input type="text" id="msg_to" name="msg_to" class="form-control" placeholder="To" />
                        <ul class="suggestions">
                        </ul>
            		</div>
                    <div class="form-group">
                    	<label for="msg_msg">Message</label>
                        <textarea id="msg_msg" name="msg_msg" class="form-control" rows="10"></textarea>
                    </div>
                    
                    <button type="submit" class="btn btd-default">Send</button>
            	</form>
            </div>
        </div>
    </div>
</div>
<script>
$('input#msg_to').keyup(function() {
	if($(this).val() != '') {
		$('ul.suggestions').css('display','block').html('<li class="text-center"><i class="fa fa-refresh fa-spin"></i></li>');
		var data = { to: $(this).val() };
		$.post('<?php echo URL.'Messages/getUsers'; ?>', data, function(data,status){
			$('ul.suggestions').html(data);
		});
	} else {
		$('ul.suggestions').html('').css('display','none');
	}
});

$('ul.suggestions').mouseover(function(){
	$('li', this).click(function(){
		var value = $(this).text();
		$('input#msg_to').val(value);
		$('ul.suggestions').html('').css('display','none');
	})
});

</script>