<?php

function escape($string)
{
    return htmlentities($string, 'ENT_QUOTE','utf-8');
}