<?php

namespace public_site\controller;

class UserController
{
    public function __construct()
    {

    }

    public function showCreateForm()
    {
        echo "
        <section>
            <article class='box'>
                <h1>WELCOME BACK!</h1>
                <form action='' method='POST'>
                    <input type='text' class='input-field' maxlength='25' onkeydown='return /[a-z0-9]/i.test(event.key)' placeholder='USERNAME' required>
                    <input type='password' class='input-field' maxlength='25' onkeydown='return /[a-z0-9]/i.test(event.key)' placeholder='PASSWORD' required>
                    <input type='submit' class='btn' value='LOGIN'>
                </form>
                <a href='/index.php/user/log-in'>New? Click here</a>
            </article>
        </section>
        ";
    }

    public function showLogInForm()
    {
        echo "
        <section>
            <article class='box'>
                <h1>WELCOME BACK!</h1>
                <form action='' method='POST'>
                    <input type='text' class='input-field' maxlength='25' onkeydown='return /[a-z0-9]/i.test(event.key)' placeholder='USERNAME' required>
                    <input type='password' class='input-field' maxlength='25' onkeydown='return /[a-z0-9]/i.test(event.key)' placeholder='PASSWORD' required>
                    <input type='submit' class='btn' value='LOGIN'>
                </form>
                <a href='/index.php/user/create'>New? Click here</a>
            </article>
        </section>
        ";
    }
}