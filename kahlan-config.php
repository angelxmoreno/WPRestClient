<?php

/**
 * @var Kahlan\Cli\Kahlan $this
 */

const DS = DIRECTORY_SEPARATOR;
const FIXTURES_DIR = __DIR__ . DS . 'tests' . DS . 'fixtures' . DS;

$commandLine = $this->commandLine();
$commandLine->option('src', 'default', 'src');
$commandLine->option('spec', 'default', 'tests' . DS . 'unit');
$commandLine->option('reporter', 'default', 'tree');
$commandLine->option('ff', 'default', 1);
