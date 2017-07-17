<?php
define('FEEDBACK_GENERAL_ERROR', 'Something went wrong.');
define('NO_ACCESS_ERROR', "You don't have access to this MVC.");

// Registration
define('REGISTER_DEFAULT_ERROR', 'Something went wrong during registration. Please try again.');
define('REGISTER_SUCCESS', 'You have successfully registered.');
define('REGISTER_FIELD_MISSING', '-field was empty!');
define('REGISTER_PASSWORD_REPEAT_ERROR', 'The password repitition does not match the original one.');
define('REGISTER_EMAIL_ERROR', 'Couldn\'t send registration mail, because the given mail address is not valid.');
define('REGISTER_EMAIL_REPEAT_ERROR', 'The E-Mail repitition does not match the original one.');
define('REGISTER_EMAIL_SUCCESS', 'An activation mail has been sent to your email adress.');
define('REGISTER_PASSWORD_CRITERIA', 'The password does not match the minimum criteria.');
define('REGISTER_USER_EXISTS', 'There is already an user with this Username or E-Mail');
define('REGISTER_FORM_EMPTY_ERROR', "This field must not be empty!");
define('ALREADY_ACTIVATED_ERROR', 'This user is already activated.');
define('USER_DOES_NOT_EXIST', 'This user does not exist.');

// Login
define('LOGIN_FIELD_EMPTY', "-field was empty!");
define('LOGIN_FAILED', "The user does either not exist or the password was wrong."); // For security reasons we don't tell the user what exactly went wrong.
define('LOGIN_TO_MANY_TRIES', "Sorry, you've tried to often. Please wait until ");
define('LOGIN_SUCCESS', 'Successfully logged in!');

// MVC
define('MVC_DEFAULT_ERROR', "Something went wrong.");
define('MVC_COULDNT_DELETE_FILE', "Could not delete the following file: ");
define('MVC_COULDNT_DELETE_FOLDER', "Could not delete the following folder: ");
define('MVC_RENAME_ERROR', "Could not rename the following file or directory: ");
define('MVC_CREATE_ERROR', "Something went wrong. Couldnt create the MVC.");
define('MVC_ALREADY_EXISTS', "This MVC seems to already exist");
define('MVC_COULDNT_FIND_TMPL', "Could not find or open the following template: ");
define('MVC_CREATED', "MVC was successfully created!");

// Contact
define('CONTACT_ERROR', "Please fill out all fields.");
define('CONTACT_SUCCESS', "Your message has successfully been sent! Thank You!");
define('CONTACT_SAVE_ERROR', 'Your message could not be send. Please try again later!');

// User
define('USERGROUP_SUCCESSFULLY_CREATED', "Usergroup was created successfully!");
define('COULDNT_CREATE_USERGROUP', 'Could not create usergroup.');
define('USERGROUP_ALREADY_EXISTS', 'A usergroup with this name does already exist.');

// Logout
define('LOGOUT_SUCCESS', 'You were successfully logged out. You\'re beeing redirected to the home page. If not, please click <a href="'.URL.'">here</a>!');

// Messages
define('COULD_NOT_LOAD_MSG_ERROR', 'Could not load messages.');
?>