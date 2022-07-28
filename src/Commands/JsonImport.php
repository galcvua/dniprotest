<?php
namespace App\Commands;
 
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\{InputInterface, InputArgument};
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Doctrine\Persistence\ManagerRegistry;

abstract class JsonImport extends Command
{
    protected $entity;
    protected ManagerRegistry $doctrine;
    protected abstract function fillItem(array $arr):object;

    protected function configure()
    {
        $this->addArgument('filename', InputArgument::REQUIRED, 'Pass the json file.');
    }
 
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $fileName = $input->getArgument('filename');

        $text = @file_get_contents($fileName);
        
        if($text === false) {
            $output->writeln( sprintf('Can`t read file "%s"', $fileName) );
            return Command::FAILURE;
        }

        $data = json_decode($text, true);
        if($data === null) {
            $output->writeln( sprintf('Can`t parse file "%s"', $fileName) );
            return Command::FAILURE;
        }

        if(!is_array($data) || !array_is_list($data)) {
            $output->writeln( sprintf('Invalid data parsed from file "%s"', $fileName) );
            return Command::FAILURE;
        }

        $em = $this->doctrine->getManager();
        foreach($data as $arr) {
            $item = $this->fillItem($arr);
            $em->persist($item);
            $output->writeln( sprintf('New item added "%s"', $item->getName()) );
        }
        $em->flush();

        return Command::SUCCESS;
    }
}