<?php
namespace App\Commands;
 
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Attribute\AsCommand;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Category;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Import categories from json file.
 * 
 */
#[AsCommand(
    name: 'category:import',
    description: 'Import categories from a json file',
    hidden: false,
)]
class CategoryImport extends JsonImport
{
    function __construct(
        protected ManagerRegistry $doctrine,
        private ValidatorInterface $validator) 
    {
        parent::__construct();
    }


    /**
    * Creates category
    * 
    * Creates category entity from associative array and validations it.
    */
    protected function fillItem(array $arr):object|null {
        $category = new Category();
        $category->setName($arr['name'] ?? '');
        //The platform API performs validation automatically. But here we have to call it.
        $errors = $this->validator->validate($category);
        return count($errors)?null:$category;
    }

}