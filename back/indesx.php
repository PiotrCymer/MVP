<?php


$it = new RecursiveDirectoryIterator("/home/users/webs/piotrc/dev/profesja/projektsem");
$it->setFlags(RecursiveDirectoryIterator::SKIP_DOTS);
$e = new RecursiveIteratorIterator($it);
$pattern = "oso";
$filesArray = array();
foreach ($e as $file) {
if(preg_match("/boo*/", end(explode('/', $file))))
        echo $file."<br />";
}
