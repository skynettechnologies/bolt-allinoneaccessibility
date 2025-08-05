<?php

declare(strict_types=1);

namespace Skynettechnologies\BoltAllinoneaccessibility;

use Bolt\Controller\TwigAwareController;
use Bolt\Extension\ExtensionRegistry;
use Bolt\Widget\BaseWidget;
use Bolt\Widget\CacheAwareInterface;
use Bolt\Widget\RequestAwareInterface;
use Bolt\Widget\StopwatchAwareInterface;
use Doctrine\DBAL\DriverManager;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Bolt\Configuration\Config;
use Doctrine\DBAL\Connection;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\EventManager;
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\Driver;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use symfony\bundle\frameworkbundle\controller;
use Doctrine\ORM\EntityRepository;

class BoltAllinoneaccessibilityConfig
{
    /** @var ExtensionRegistry */
    private $registry;

    /** @var CsrfTokenManagerInterface */
    private $csrfTokenManager;

    /** @var ParameterBagInterface */
    private $parameterBag;


    public function __construct(ExtensionRegistry $registry, CsrfTokenManagerInterface $csrfTokenManager, ParameterBagInterface $parameterBag)
    {
        $this->registry = $registry;
        $this->csrfTokenManager = $csrfTokenManager;
        $this->parameterBag = $parameterBag;

    }

    /**
     * Called by TwigExtension.php to
     * - merge default configs from bellow with the users custom config and
     * - pass them into the backend template
     */
    public function getConfig(): array
    {
        $extension = $this->registry->getExtension(Extension::class);
        $config = $extension->getConfig()['default'];
        $resolvedConfig = $this->parameterBag->resolveValue($config);
        return array_merge($this->getDefaults(), $resolvedConfig);
    }

    /**
     * Default configs which should always be present.
     * @throws \Doctrine\DBAL\Exception
     * @throws \Doctrine\DBAL\Driver\Exception
     */


    public function getDefaults(): array
    {
    }
}
