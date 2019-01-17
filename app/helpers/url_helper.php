<?php
//Simple fucntion redirect

function redirect($page)
{
    header('location:'. URLROOT.'/'.$page);
}