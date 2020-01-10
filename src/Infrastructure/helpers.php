<?php

function dd(...$data)
{
    array_map(function($data) {
        echo '<pre>' . print_r($data, true) . '</pre><hr>';
    }, $data);

    die;
}
