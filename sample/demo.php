<?php

require dirname(__DIR__) . '/profiler.php';

Profiler::init();
declare(ticks=1);

test();

function test()
{
    echo 'dd';
}

Profiler::dump();