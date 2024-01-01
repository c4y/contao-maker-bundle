<?php
namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'make:ini')]
class MakeIniCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $name = readline('Bundle-Name (CamelCase), BundleName => ContaoBundleNameBundle: ');
        $vendor = readline('Vendor: ');
        $namespace = readline('Vendor (without Vendor or Leading/Trailing Slashes): ');
        $folder = readline('Folder (eg bundles/BundleName, only for Development: ');
        $composer = readline('Composer (eg c4y/contao-apo-not) => becomes folder in vendor : ');

        file_put_contents(__DIR__.'/../../.make', 'name='.$name."\n", FILE_APPEND);
        file_put_contents(__DIR__.'/../../.make', 'vendor='.$vendor."\n", FILE_APPEND);
        file_put_contents(__DIR__.'/../../.make', 'namespace='.$namespace."\n", FILE_APPEND);
        file_put_contents(__DIR__.'/../../.make', 'folder='.$folder."\n", FILE_APPEND);
        file_put_contents(__DIR__.'/../../.make', 'composer='.$composer."\n", FILE_APPEND);
        
        return Command::SUCCESS;
    }
}