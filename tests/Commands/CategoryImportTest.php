<?php

namespace App\Tests\Command;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class CategoryImportTest extends KernelTestCase
{
    public function testExecute()
    {
        $kernel = self::bootKernel();
        $application = new Application($kernel);

        $command = $application->find('category:import');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'filename' => 'json/category.json',
        ]);

        $commandTester->assertCommandIsSuccessful();

        // the output of the command in the console
        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('New item added "Category 1"', $output);
        $this->assertStringContainsString('New item added "Category 2"', $output);
        $this->assertStringContainsString('New item added "Category 3"', $output);
    }

    public function testBadCategory()
    {
        $kernel = self::bootKernel();
        $application = new Application($kernel);

        $command = $application->find('category:import');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'filename' => 'json/badcategory.json',
        ]);

        $commandTester->assertCommandIsSuccessful();

        // the output of the command in the console
        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('skipped', $output);
    }

}