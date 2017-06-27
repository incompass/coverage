<?php

use App\CoverageCommand;
use org\bovigo\vfs\vfsStream;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * Class CommandTest
 *
 * @author  Joe Mizzi <joe@casechek.com>
 */
class CommandTest extends KernelTestCase
{
    /**
     * @var CommandTester
     */
    private $tester;

    /**
     * Setup the filesystem.
     */
    protected function setUp()
    {
        vfsStream::setup('test');
        self::bootKernel();
        $application = new Application(self::$kernel);
        $application->add(new CoverageCommand());
        $command = $application->find('coverage');
        $this->tester = new CommandTester($command);
    }

    /**
     * @test
     */
    public function it_throws_an_exception_if_file_not_found()
    {
        self::expectException(InvalidArgumentException::class);
        $this->tester->execute(
            [
                'file' => vfsStream::url('test/test.xml'),
                'percentage' => 75,
            ]
        );
    }

    /**
     * @test
     */
    public function it_returns_success_if_coverage_met()
    {
        $file = vfsStream::newFile('test/test.xml');
        file_put_contents($file->url(), '<coverage><project><metrics elements="6" coveredelements="6"/></project></coverage>');
        self::assertEquals(0, $this->tester->execute(
            [
                'file' => $file->url(),
                'percentage' => 75,
            ]
        ));
    }

    /**
     * @test
     */
    public function it_returns_error_if_coverage_not_met()
    {
        $file = vfsStream::newFile('test/test.xml');
        file_put_contents($file->url(), '<coverage><project><metrics elements="6" coveredelements="0"/></project></coverage>');
        self::assertNotEquals(0, $this->tester->execute(
            [
                'file' => $file->url(),
                'percentage' => 75,
            ]
        ));
    }
}
