<?php

namespace App\Tests\Command;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class ProductImportTest extends KernelTestCase
{
    public function testExecute()
    {
        $kernel = self::bootKernel();
        $application = new Application($kernel);

        $command = $application->find('product:import');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'filename' => 'json/product.json',
        ]);

        $commandTester->assertCommandIsSuccessful();

        // the output of the command in the console
        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('New item added "Product 1"', $output);
        $this->assertStringContainsString('New item added "Product 2"', $output);
        $this->assertStringContainsString('New item added "Product 3"', $output);
        $this->assertStringContainsString('New item added "Product 4"', $output);
        $this->assertStringContainsString('New item added "Product 5"', $output);
    }

    public function testBadCategory()
    {
        $kernel = self::bootKernel();
        $application = new Application($kernel);

        $command = $application->find('category:import');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'filename' => 'json/badproduct.json',
        ]);

        $commandTester->assertCommandIsSuccessful();

        // the output of the command in the console
        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('skipped', $output);
    }

}