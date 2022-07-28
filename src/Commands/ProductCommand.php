<?php
namespace App\Commands;
 
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Attribute\AsCommand;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\{Product, Category};
use App\Repository\CategoryRepository;

#[AsCommand(
    name: 'product:import',
    description: 'Import products from a json file',
    hidden: false,
)]
class ProductCommand extends JsonImport
{
    function __construct(
        protected ManagerRegistry $doctrine,
        private CategoryRepository $categoryRepository
        ) 
    {
        parent::__construct();
    }

    protected $entity = Product::class;
    
    protected function fillItem(array $arr):object {
        $product = new Product();
        $product->setName($arr['name'] ?? '');
        $product->setPrice( isset($arr['price']) ? floatval($arr['price']) : 0.0 );
        $category = $this->categoryRepository->findOneBy(['name'=>trim($arr['categoryName'])]);
        $product->setCategory( $category );

        return $product;
    }
}