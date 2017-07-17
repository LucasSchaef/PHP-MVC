	<div class="container-fluid>
    	<div class="row" style="margin:20px 0">
        	<div class="col-md-4 col-md-offset-4">
            	<?php 	$this->renderFeedbackMessages(); ?>
            </div>
		</div>
        <div class="row">
            <div class="form-signin">
            <?php
            $to = URL."Login/DoLogin";
            if(isset($this->to)) {
                $to .= "/".$this->to;	
            }
            
            $form = new form($to, "post");
            $form->hidden('login', true);
            $form->text('Username', 'user_name');
            $form->password('Password', 'user_password');
            $form->checkbox('Remember me', 'user_remember');
            $form->submit('Log In');
            
            foreach($form->formInfo['fields'] as $id => $field) {
                if(isset($_POST[$id]) && empty($_POST[$id])) {
                    $form->addError($id, REGISTER_FORM_EMPTY_ERROR);
                } elseif(isset($_POST[$id]) && !empty($_POST[$id]) && $id != "user_password") {
                    $form->addValue($id, $_POST[$id]);
                }
            }
            
            $form->write();
            ?>
            </div>
		</div>
	</div>