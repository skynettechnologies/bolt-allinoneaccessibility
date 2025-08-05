<?php

// src/Extension.php

declare(strict_types=1);

namespace Skynettechnologies\BoltAllinoneaccessibility;

use Symfony\Component\Filesystem\Filesystem;
use Bolt\Extension\BaseExtension;

class Extension extends BaseExtension
{
    public function getName(): string
    {
        return 'All in One Accessibility';
    }

    public function initialize(): void
    {
        $this->addTwigNamespace('allinoneaccessibility');
        $this->addWidget(new BoltAllinoneaccessibilityInjectorWidget());
    }

    public function install(): void
    {
        $projectDir = $this->getContainer()->getParameter('kernel.project_dir');
        $public = $this->getContainer()->getParameter('bolt.public_folder');

        $source = dirname(__DIR__) . '/assets/';
        $destination = $projectDir . '/' . $public . '/assets/';

        $filesystem = new Filesystem();
        $filesystem->mirror($source, $destination);
    }

    public function uninstall(): void
    {
        // No table to drop anymore.
    }
}
