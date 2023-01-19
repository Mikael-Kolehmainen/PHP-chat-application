<?php

namespace public_site\controller;

class GroupController
{
    public function __construct()
    {

    }

    /**
     *  /index.php/groups
     */
    public function showGroups()
    {
        // TODO: replace placeholder data with data from database
        echo "
        </head>
        <section>
            <article class='box groups'>
                <a href='#' class='red-link'>LOGOUT</a>
                <h1>CHATS</h1>
                <ul class='list-image-title'>
                    <li>
                        <a href='#'>
                            <div class='round-image'>
                                <img src='/src/public_site/media/placeholder.png'>
                            </div>
                            <p>GROUPNAME</p>
                        </a>
                    </li>
                    <li>
                        <a href='#'>
                            <div class='round-image'>
                                <img src='/src/public_site/media/placeholder.png'>
                            </div>
                            <p>GROUPNAME</p>
                        </a>
                    </li>
                    <li>
                        <a href='#'>
                            <div class='round-image'>
                                <img src='/src/public_site/media/placeholder.png'>
                            </div>
                            <p>GROUPNAME</p>
                        </a>
                    </li>
                    <li>
                        <a href='#'>
                            <div class='round-image'>
                                <img src='/src/public_site/media/placeholder.png'>
                            </div>
                            <p>GROUPNAME</p>
                        </a>
                    </li>
                    <li>
                        <a href='#'>
                            <div class='round-image'>
                                <img src='/src/public_site/media/placeholder.png'>
                            </div>
                            <p>GROUPNAME</p>
                        </a>
                    </li>
                    <li>
                        <a href='#'>
                            <div class='round-image'>
                                <img src='/src/public_site/media/placeholder.png'>
                            </div>
                            <p>GROUPNAME</p>
                        </a>
                    </li>
                    <li>
                        <a href='#'>
                            <div class='round-image'>
                                <img src='/src/public_site/media/placeholder.png'>
                            </div>
                            <p>GROUPNAME</p>
                        </a>
                    </li>
                    <li>
                        <a href='#'>
                            <div class='round-image'>
                                <img src='/src/public_site/media/placeholder.png'>
                            </div>
                            <p>GROUPNAME</p>
                        </a>
                    </li>
                    <li>
                        <a href='#'>
                            <div class='round-image'>
                                <img src='/src/public_site/media/placeholder.png'>
                            </div>
                            <p>GROUPNAME</p>
                        </a>
                    </li>
                    <li>
                        <a href='#'>
                            <div class='round-image'>
                                <img src='/src/public_site/media/placeholder.png'>
                            </div>/**
                            *  /index.php/group/add-user
                            */
                            <div class='round-image'>
                                <img src='/src/public_site/media/placeholder.png'>
                            </div>
                            <p>GROUPNAME</p>
                        </a>
                    </li>
                </ul>
                <a href='/index.php/group/create' class='btn round add'>
                    <i class='fa-solid fa-plus'></i>
                </a>
            </article>
        </section>
        ";
    }

    /**
     *  /index.php/group/create
     */
    public function showCreateGroup()
    {
        echo "
            <script src='/src/public_site/js/image-preview.js' defer></script
        </head>
        <section>
            <article class='box create-group'>
                <h1>CREATE GROUP</h1>
                <form action='' method='POST'>
                    <label class='circle-file-input' id='image-file-input'>
                        <input type='file' id='image' name='group-image' accept='png/jpg/jpeg/gif' required>
                        <p id='file-input-text'>CHOOSE IMAGE</p>
                    </label>
                    <input type='text' name='groupname' placeholder='GROUP NAME' class='input-field' maxlength='20'>
                    <input type='submit' value='CREATE' class='btn'>
                </form>
                <a href='/index.php/groups'>Go back</a>
            </article>
        </section>
        ";
    }

    /**
     *  /index.php/group/chat
     */
    public function showChat()
    {
        // TODO: replace placeholder data with data from database
        echo "
        </head>
        <section>
            <article class='box chat'>
                <header>
                    <div class='icon-link-container back-to-groups-icon'>
                        <a href='/index.php/groups' class='icon-link'>
                            <i class='fa-solid fa-arrow-left'></i>
                        </a>
                    </div>
                    <div class='round-image'>
                        <img src='/src/public_site/media/placeholder.png'>
                    </div>
                    <h1>GROUPNAME</h1>
                    <div class='icon-link-container add-users-icon'>
                        <a href='/index.php/group/add-user' class='icon-link'>
                            <i class='fa-solid fa-user-plus'></i>
                        </a>
                    </div>
                </header>
                <div class='chat-view'>
                    <div class='messages'>
                        <p class='date'>12.01.2023</p>
                        <div class='message'>
                            <div class='round-image'>
                                <img src='/src/public_site/media/placeholder.png'>
                            </div>
                            <p>This is a longer message sent by the user. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut in leo posuere, lacinia est sit amet, cursus risus. Ut ultrices elit ac arcu sodales pretium.</p>
                        </div>
                        <div class='message'>
                            <div class='round-image'>
                                <img src='/src/public_site/media/placeholder.png'>
                            </div>
                            <p>This is a message sent by an other user</p>
                        </div>
                        <div class='message'>
                            <div class='round-image'>
                                <img src='/src/public_site/media/placeholder.png'>
                            </div>
                            <p>This is a message sent by an other user</p>
                        </div>
                        <div class='message'>
                            <div class='round-image'>
                                <img src='/src/public_site/media/placeholder.png'>
                            </div>
                            <p>This is a message sent by an other user</p>
                        </div>
                        <div class='message'>
                            <div class='round-image'>
                                <img src='/src/public_site/media/placeholder.png'>
                            </div>
                            <p>This is a message sent by an other user</p>
                        </div>
                        <div class='message'>
                            <div class='round-image'>
                                <img src='/src/public_site/media/placeholder.png'>
                            </div>
                            <p>This is a message sent by an other user</p>
                        </div>
                        <div class='message'>
                            <div class='round-image'>
                                <img src='/src/public_site/media/placeholder.png'>
                            </div>
                            <p>This is a message sent by an other user</p>
                        </div>
                        <div class='message'>
                            <div class='round-image'>
                                <img src='/src/public_site/media/placeholder.png'>
                            </div>
                            <p>This is a message sent by an other user</p>
                        </div>
                        <div class='message'>
                            <div class='round-image'>
                                <img src='/src/public_site/media/placeholder.png'>
                            </div>
                            <p>This is a message sent by an other user</p>
                        </div>
                        <div class='message'>
                            <div class='round-image'>
                                <img src='/src/public_site/media/placeholder.png'>
                            </div>
                            <p>This is a message sent by an other user</p>
                        </div>
                        <div class='message'>
                            <div class='round-image'>
                                <img src='/src/public_site/media/placeholder.png'>
                            </div>
                            <p>This is a message sent by an other user</p>
                        </div>
                        <div class='message'>
                            <div class='round-image'>
                                <img src='/src/public_site/media/placeholder.png'>
                            </div>
                            <p>This is a message sent by an other user</p>
                        </div>
                        <p class='date'>19.01.2023</p>
                        <div class='message'>
                            <div class='round-image'>
                                <img src='/src/public_site/media/placeholder.png'>
                            </div>
                            <p>This is a message sent by an other user</p>
                        </div>
                        <div class='message sent'>
                            <div class='round-image'>
                                <img src='/src/public_site/media/placeholder.png'>
                            </div>
                            <p>This is a message sent by the user</p>
                        </div>
                    </div>
                </div>
                <form action='' method='POST' class='chat-controller'>
                    <input type='text' name='message' class='input-field' placeholder='Write message here'>
                    <div class='icon-link-container camera'>
                        <a href='#' class='icon-link'>
                            <i class='fa-solid fa-camera'></i>
                        </a>
                    </div>
                    <input type='submit' value='SEND' class='btn'>
                </form>
            </article>
        </section>
        ";
    }

    /**
     *  /index.php/group/add-user
     */
    public function showAddUsers()
    {
        echo "
        </head>
        <section>
            <article class='box add-users'>
                <h1>ADD USERS TO GROUPNAME</h1>
                <form action='' method='POST'>
                    <input type='text' placeholder='Search here (username)' class='search-field input-field'>
                    <ul class='list-image-title'>
                        <li>
                            <div class='round-image'>
                                <img src='/src/public_site/media/placeholder.png'>
                            </div>
                            <p>USERNAME</p>
                            <input type='checkbox' name='username-checkbox'>
                        </li>
                        <li>
                            <div class='round-image'>
                                <img src='/src/public_site/media/placeholder.png'>
                            </div>
                            <p>USERNAME</p>
                            <input type='checkbox' name='username-checkbox'>
                        </li>
                        <li>
                            <div class='round-image'>
                                <img src='/src/public_site/media/placeholder.png'>
                            </div>
                            <p>USERNAME</p>
                            <input type='checkbox' name='username-checkbox'>
                        </li>
                        <li>
                            <div class='round-image'>
                                <img src='/src/public_site/media/placeholder.png'>
                            </div>
                            <p>USERNAME</p>
                            <input type='checkbox' name='username-checkbox'>
                        </li>
                        <li>
                            <div class='round-image'>
                                <img src='/src/public_site/media/placeholder.png'>
                            </div>
                            <p>USERNAME</p>
                            <input type='checkbox' name='username-checkbox'>
                        </li>
                    </ul>
                    <input type='submit' class='btn' value='ADD'>
                </form>
                <a href='/index.php/group/chat'>Go back</a>
            </article>
        </section>
        ";
    }
}