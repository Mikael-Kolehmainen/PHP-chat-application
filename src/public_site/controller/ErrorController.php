<?php

namespace public_site\controller;

class ErrorController
{
    /** @var string */
    private $title;

    /** @var string */
    private $message;

    /** @var string */
    private $link;

    public function __construct($errorTitle, $errorMessage, $redirectLink)
    {
        $this->title = $errorTitle;
        $this->message = $errorMessage;
        $this->link = $redirectLink;
    }

    public function showErrorPage(): void
    {
        echo "
            <title>$this->title</title>
        </head>
        <section>
            <article class='box error'>
                <h1>$this->title</h1>
                <p>$this->message</p>
                <a href='$this->link'>Go back</a>
            </article>
        </section>
        ";
    }
}