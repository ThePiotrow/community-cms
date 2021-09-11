<?php

foreach ($pages as $page) {
    echo "<a href='/page/" . $page['url'] . "'><h1>" . $page['title'] . "</h1>"
        . "<p style='border-bottom: 1px solid #333'>" . App\Core\Helpers::troncate($page['content'], 60) . "</p></a>";
}
