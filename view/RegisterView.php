<?php

class RegisterView
{
    private $error;

    public function __construct($controller)
    {
        $this->error = $controller->getError();
    }

    public function response()
    {
        $message = $this->error;
        $response = $this->generateRegisterFormHTML($message);
        return $response;
    }

    private function generateRegisterFormHTML($message)
    {
        return "
          <h2>Register new user</h2>
          <form action='?register' method='post' enctype='multipart/form-data'>
            <fieldset>
            <legend>Register new user</legend>
              <p id='RegisterView::Message' class='error'>$message</p>

              <label for='RegisterView::UserName' >Username:</label>
              <input type='text' size='20' name='RegisterView::UserName' id='RegisterView::UserName' value='' />

              <label for='RegisterView::Password' >Password:</label>
              <input type='password' size='20' name='RegisterView::Password' id='RegisterView::Password' value='' />

              <label for='RegisterView::PasswordRepeat' >Repeat password:</label>
              <input type='password' size='20' name='RegisterView::PasswordRepeat' id='RegisterView::PasswordRepeat' value='' />

              <input id='submit' type='submit' name='DoRegistration'  value='Register' />

            </fieldset>
          </form>
        ";
    }

}
