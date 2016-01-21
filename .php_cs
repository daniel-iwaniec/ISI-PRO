<?php

$finder = Symfony\CS\Finder\DefaultFinder::create()
    ->exclude('AppBundle/Resources')
    ->in('src');

return Symfony\CS\Config\Config::create()
    ->level(Symfony\CS\FixerInterface::PSR2_LEVEL)
    ->finder($finder)
    ->setUsingCache(true);
