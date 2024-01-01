<?php
namespace App\Command;

use App\Template\TemplateFolder;
use App\Utils\StringUtil;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Question\Question;

#[AsCommand(name: 'make:ce')]
class MakeContentElementCommand extends Command
{

    protected function configure(): void
    {
        $this
            ->addArgument('folder', InputArgument::REQUIRED, 'Folder/BundleName (wihtout leading Contao)')
            ->addArgument('name', InputArgument::REQUIRED, 'Content-Element Class-Name')
            ->setDescription('Creates a Content-Element inside the given bundle.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $bundleFolder = $input->getArgument('folder');
        $psr4Namespace = $this->getPSR4Namespace($bundleFolder);
        [$vendor, $namespace] = explode('\\', $psr4Namespace);

        $options = array(
            "vendor" => $vendor,
            "namespace" => $namespace,
            "name" => $input->getArgument('name'),
            "scname" => StringUtil::camel_to_snake($input->getArgument('name')),
            "kcname" => StringUtil::camel_to_kebap($input->getArgument('name'))
        );

        $helper = $this->getHelper('question');
        $question = new Question("Which category (key up/down)? ");
        $question->setAutocompleterValues(['texts', 'accordion', 'slider', 'links', 'media', 'files', 'includes']);
        $category = $helper->ask($input, $output, $question);
        $output->writeln(sprintf('Category: %s', $category));

        $options['category'] = $category;

        TemplateFolder::createFromFolder('ContentElement', $bundleFolder, $options);
        
        return Command::SUCCESS;
    }

    protected function getPSR4Namespace($bundleFolder)
    {
        //preg_match('#phar:\/\/(.*)\/[^\/].*src\/Command#', __DIR__, $matches, PREG_OFFSET_CAPTURE);
        $cliFolder = trim(shell_exec("pwd"));

        $destAbsoluteBundleFolder = $cliFolder . '/' . $bundleFolder;
        $composerJson = json_decode(file_get_contents($destAbsoluteBundleFolder . "/composer.json"), true);

        $psr4Namespaces = $composerJson['autoload']['psr-4'];
        $namespace = array_key_first($psr4Namespaces);

        return $namespace;
    }
}