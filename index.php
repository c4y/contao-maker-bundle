<?php
namespace App;

require __DIR__.'/vendor/autoload.php';

use Symfony\Component\Console\Application;
use App\Command\MakeBundleCommand;
use App\Command\MakeContentElementCommand;
use App\Command\MakeIniCommand;
use App\Command\MakeAPICommand;

$application = new Application();

$application->add(new MakeBundleCommand());
$application->add(new MakeContentElementCommand());
//$application->add(new MakeIniCommand());
$application->add(new MakeAPICommand());

$application->run();