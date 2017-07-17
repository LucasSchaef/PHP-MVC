<div class="container-fluid">
	<div class="panel panel-default">
    	<div class="panel-heading">
        	<div class="row">
        		<div class="col-md-11">Create MVC</div>
        		<div class="col-md-1"><?php echo '<a href="'.URL.$this->activeController().'"><i class="fa fa-angle-left"></i> Back</a>'; ?></div>
        	</div>
        </div>
        <div class="panel-body">
        	<?php
				$form = new form(URL.$this->activeController()."/Create", "post");
				$form->text("Name", "mvc_name");
				$form->text("Font Awesome-Icon", "mvc_fa", "Type in the FA-class to see a preview: <i class=\"fa fa-".DEFAULT_FA_CLASS."\" id=\"mvc_fa\"></i> <span id=\"mvc_fa_desc\">fa-".DEFAULT_FA_CLASS."</span>", false, 'puzzle-piece');
				$form->checkbox("This MVC is restricted", "mvc_restricted");
				$form->submit("Create");
				$form->write();
			?>
            <script>
				$('input#mvc_fa').keyup(function () {
					var fa_class = $(this).val();
					if(fa_class === '') {
						fa_class = "<?php echo DEFAULT_FA_CLASS; ?>";	
					}
					$('i#mvc_fa').attr('class', 'fa fa-'+fa_class);
					$('span#mvc_fa_desc').text('fa-'+fa_class);
				});
			</script>
        </div>
    </div>
</div>