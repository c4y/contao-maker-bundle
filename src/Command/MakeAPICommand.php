<?php

namespace App\Command;

use App\Template\TemplateFolder;
use App\Utils\StringUtil;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

#[AsCommand(name: 'make:api')]
class MakeAPICommand extends Command
{
    protected function configure(): void
    {
        $this
            ->addArgument('folder', InputArgument::REQUIRED, 'Folder/BundleName (wihtout leading Contao)')
            ->addArgument('name', InputArgument::REQUIRED, 'Name des Controllers')
            ->setDescription('Creates a new API.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $bundleFolder = $input->getArgument('folder');

        $name = explode("/", $bundleFolder)[1];
        $psr4Namespace = $this->getPSR4Namespace($bundleFolder);
        [$vendor, $namespace] = explode('\\', $psr4Namespace);

        $options = array(
            "name" => $name,
            "vendor" => $vendor,
            "namespace" => $namespace,
            "scname" => StringUtil::camel_to_snake($name),
            "kcname" => StringUtil::camel_to_kebap($name),
            "namespace" => $name . "Bundle",
        );

        TemplateFolder::createFromFolder('API', $bundleFolder, $options);

        $output->writeln("You can now test the API with DOMAIN/example");

        return Command::SUCCESS;
    }

    protected function getPSR4Namespace($bundleFolder)
    {
        $cliFolder = trim(shell_exec("pwd"));
        $destAbsoluteBundleFolder = $cliFolder . '/' . $bundleFolder;
        $composerJson = json_decode(file_get_contents($destAbsoluteBundleFolder . "/composer.json"), true);

        $psr4Namespaces = $composerJson['autoload']['psr-4'];
        $namespace = array_key_first($psr4Namespaces);

        return $namespace;
    }
}
