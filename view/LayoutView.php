<?php

class LayoutView
{
    // TODO: set dependency LoginView
    public function render($isLoggedIn, $v, DateTimeView $dtv)
    {
        echo '<!DOCTYPE html>
		<html>
			<head>
				<meta charset="utf-8">
				<title>Login Example</title>
			</head>
			<body>
				<h1>Assignment 2</h1>
				' . $this->renderIsLoggedIn($isLoggedIn) . '

				<div class="container">
						' . $v->response() . '
						' . $dtv->show() . '
				</div>
				</body>
		</html>
	';
    }

    private function renderIsLoggedIn($isLoggedIn)
    {
        $msg = ($isLoggedIn) ? 'Logged in' : 'Not logged in';
        return "<h2>$msg</h2>";
    }
}
