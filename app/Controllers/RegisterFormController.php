<?php
/**
 * Created by PhpStorm.
 * User: kczechowski
 * Date: 18.05.19
 * Time: 17:43
 */

namespace App\Controllers;


use Slim\Http\Request;
use Slim\Http\Response;

class RegisterFormController extends Controller
{
    public function registerForm(Request $request, Response $response)
    {
        $params = $request->getParams();
        $html = '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
    <h1>OAuth register</h1>
    <form method="POST" action="" id="form" onsubmit="submitForm(event,this)">
        <input type="text" name="user" >
        <input type="password" name="password">
        <input type="email" name="email">
        <input type="submit">
    </form>
    <script type="application/javascript">
        function submitForm(e, form){
            e.preventDefault();
            let url = `http://10.10.10.1:9090/user`;
            let params = {username: form.user.value, password: form.password.value, email: form.email.value};
            fetch(url, {
                method: \'POST\',
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(params)
            }).then(handleResponse)
        }
        const handleResponse = (response) => {
            return response.text().then( (text) => {
                const data = text && JSON.parse(text);
                if(!response.ok){
                    const error = (data && data.message) || response.statusText;
                    return alert(error);
                }
                
                    alert("Account created");
            })
        };
    </script>
</body>
</html>';
        return $response->write($html);
    }
}