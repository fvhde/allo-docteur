<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Finder\Finder;

class AppFixtures extends Fixture
{
    public const FIXTURES_PATH = __DIR__.'/../../fixtures';

    public function __construct(private ContainerInterface $container)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $files = iterator_to_array(
            Finder::create()
                ->files()
                ->in(self::FIXTURES_PATH)
                ->depth(0)
                ->name('/.*\.(ya?ml)$/i')
        );
        $files = array_keys($files);

        $loader = $this->container->get('fidry_alice_data_fixtures.loader.doctrine');
        $loader->load($files);
    }
}
