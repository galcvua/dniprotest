<?php
namespace App\Commands;
 
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Attribute\AsCommand;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Category;

#[AsCommand(
    name: 'category:import',
    description: 'Import categories from a json file',
    hidden: false,
)]
class CategoryCommand extends JsonImport
{
    function __construct(protected ManagerRegistry $doctrine) 
    {
        parent::__construct();
    }

    protected $entity = Category::class;

    protected function fillItem(array $arr):object {
        $category = new Category();
        $product->setName($arr['name'] ?? '');
        return $category;
    }

}