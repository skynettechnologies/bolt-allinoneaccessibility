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
//        $qb = $this->getQueryBuilder();
//        $conn = $qb->getEntityManager()->getConnection();
//        $data = $conn ->createQueryBuilder()
//            ->select("*")
//            ->from("aioawidget_setting");
//        $results = $data->getQuery()->getResult();
//        $user = $this->get('doctrine.orm.default_entity_manager')
//            ->getEntityManager()
//            ->createQueryBuilder()
//            ->select('*')
//            ->from('aioawidget_setting')
//            ->getQuery()->execute();
//        $conn = $this->getExtension()->getObjectManager()->getConnection();
//        $data = $conn
//            ->prepare("Select * from aioawidget_setting")
//            ->executeQuery()
//            ->fetch();

//        if ($data){
//            $getdata = [
//                'license_key' => $data['license_key'],
//                'color' => $data['color'],
//                'position' => $data['position'],
//                'icon_type' => $data['icon_type'],
//                'icon_size' => $data['icon_size'],
//                'is_valid_key' => $data['is_valid_key'],
//                '_csrf_token' => $this->csrfTokenManager->getToken('bolt_allinoneaccessibility')
//                    ->getValue(),
//            ];
//        }
//        else{
            $getdata = [
                'license_key' => '',
                'color' => '#40628',
                'position' => 'bottom_right',
                'icon_type' => 'aioa-icon-type-1',
                'icon_size' => 'aioa-default-icon',
                'is_valid_key' => 0,
                '_csrf_token' => $this->csrfTokenManager->getToken('bolt_allinoneaccessibility')->getValue()
            ];
        //}
        return array_merge($getdata);
    }
}
