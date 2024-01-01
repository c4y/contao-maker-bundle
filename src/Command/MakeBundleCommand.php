<?php

namespace App\Command;

use App\Template\TemplateFolder;
use App\Utils\StringUtil;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

#[AsCommand(name: 'make:bundle')]
class MakeBundleCommand extends Command
{
    protected function configure(): void
    {
        $this
            ->addArgument('folder', InputArgument::REQUIRED, 'Folder/BundleName (wihtout leading Contao)')
            ->addArgument('vendor', InputArgument::REQUIRED, 'Vendor')
            ->setDescription('Creates a new contao-bundle and adds the repository to the composer.json.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $to = $input->getArgument('folder');
        $name = explode("/", $to)[1];
        $vendor = $input->getArgument('vendor');

        $options = array(
            "name" => $name,
            "vendor" => $vendor,
            "scname" => StringUtil::camel_to_snake($name),
            "kcname" => StringUtil::camel_to_kebap($name),
            "namespace" => $name . "Bundle",
            "composer" => strtolower($vendor . "/" . StringUtil::camel_to_kebap($name))
        );

        TemplateFolder::createFromFolder('bundle', $to, $options);

        $addAutoload = readline('Repository wird in die composer.json hinzufügen? (y/n):');
        if($addAutoload == 'y') {
            $this->addRepositoryToComposerJson($to);
        }

        $composerName = StringUtil::camel_to_kebap($to);
        $output->writeln('The bundle was created!');
        $output->writeln("You can now install the bundle with: composer require $composerName");

        return Command::SUCCESS;
    }

    protected function addRepositoryToComposerJson($folder):void
    {
        //preg_match('#phar:\/\/(.*)\/[^\/].*src\/Command#', __DIR__, $matches, PREG_OFFSET_CAPTURE);
        //$cliFolder = $matches[1][0];
        $cliFolder = trim(shell_exec("pwd"));

        $composerJson = json_decode(file_get_contents($cliFolder . "/composer.json"), true);
        $composerJson['repositories'][] = [
            'type' => 'path',
            'url' => $folder
        ];
        file_put_contents($cliFolder . "/composer.json", json_encode($composerJson, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES));
    }
}
