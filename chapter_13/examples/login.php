<?php
/**
* This is a sample docblock
*
* This is a sample docblock. Content prior to the first empty line
* of the comment block is called the 'short description'; this
* content here is considered the 'long description'.
*/

/**
* Login a user
*
* Logs in a user, applying their credentials against those found in
* the database.
*
* @param string $user Username
* @param string $password User's password
* @return boolean
* @throws Exception on database error
*/
function login($user, $password)
{
  //login function body
}

/**
* Validate a password
*
* Validates a password for {@link login() the login function}.
*
* @sees login() Login function
* @param string $user Username
* @param string $password User's password
* @return boolean
*/
function validatePassword($user, $password)
{
  //validatePassword function body
}
?>