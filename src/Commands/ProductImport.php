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
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Import products from json file.
 * 
 */
#[AsCommand(
    name: 'product:import',
    description: 'Import products from a json file',
    hidden: false,
)]
class ProductImport extends JsonImport
{
    function __construct(
        protected ManagerRegistry $doctrine,
        private CategoryRepository $categoryRepository,
        private ValidatorInterface $validator
        ) 
    {
        parent::__construct();
    }
   
    /**
    * Creates product
    * 
    * Creates product entity from associative array and validations it.
    */
    protected function fillItem(array $arr):object|null {
        $product = new Product();
        $product->setName($arr['name'] ?? '');
        $product->setPrice( isset($arr['price']) ? floatval($arr['price']) : 0.0 );
        $category = $this->categoryRepository->findOneBy(['name'=>trim($arr['categoryName'])]);
        $product->setCategory( $category );
        //The platform API performs validation automatically. But here we have to call it.
        $errors = $this->validator->validate($product);
        return count($errors)?null:$product;
    }
}