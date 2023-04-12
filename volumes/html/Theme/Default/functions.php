<?php

function loadDefaultScript(){
    foreach(__THEME__DEFAULT_SCRIPT__ as $value){
        echo $value . PHP_EOL;
    }
}