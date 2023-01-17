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

        ";
    }
    
    public function showLogInForm()
    {
        echo "
        <section>
            <article class='box'>
                <h1>WELCOME BACK!</h1>
                <form action='' method='POST'>
                    <input type='text' class='input-field' placeholder='USERNAME'>
                    <input type='password' class='input-field' placeholder='PASSWORD'>
                    <input type='submit' class='btn' value='LOGIN'>
                </form>
                <a href='#'>New? Click here</a>
            </article>
        </section>
        ";
    }
}