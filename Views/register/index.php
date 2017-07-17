<?php

$form = new form(URL.'Register/DoRegistration', 'post');
$form->text("Username", "user_name");
$form->password("Password", "user_pw");
$form->password("Repeat Password", "user_pw_repeat");
$form->email("E-Mail", "user_email");
$form->email("Repeat E-Mail", "user_email_repeat");

foreach($form->formInfo['fields'] as $id => $options) {
	if(isset($this->formData[$id]) && empty($this->formData[$id])) {
		$form->addError($id, REGISTER_FORM_EMPTY_ERROR);	
	} elseif(isset($this->formData[$id]) && !empty($this->formData[$id]) && $id != 'user_pw' && $id != 'user_pw_repeat') {
		$form->addValue($id, $this->formData[$id]);	
	}
}
$form->hidden("register", TRUE);
$form->submit("Send");
$form->write();

?>