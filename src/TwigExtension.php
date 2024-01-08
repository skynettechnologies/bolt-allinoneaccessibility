<?php

declare(strict_types=1);

namespace Skynettechnologies\BoltAllinoneaccessibility;

use Bolt\Common\Json;
use Symfony\Component\DependencyInjection\Container;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Exception;
use Psr\Container\ContainerInterface;

class TwigExtension extends AbstractExtension
{
    /** @var BoltAllinoneaccessibilityConfig */
    private  $allinoneaccessibilityConfig;

    /** @var Container */
    private $container;

    public function __construct(BoltAllinoneaccessibilityConfig $allinoneaccessibilityConfig, ContainerInterface $container)
    {
        $this->allinoneaccessibilityConfig = $allinoneaccessibilityConfig;
        $this->container = $container;
    }

    /**
     * This functions create a custom TWIG function `allinoneaccessibility_settings()`
     *
     * @return TwigFunction[]
     */
    public function getFunctions(): array
    {
        $safe = [
            'is_safe' => ['html'],
        ];

        return [
            new TwigFunction('allinoneaccessibility_settings', [$this, 'allinoneaccessibilitySettings'], $safe),
        ];
    }

    public function getFilters()
    {
        return [
            'allinoneaccessibility_decode_json' => new TwigFilter('allinoneaccessibility_decode_json', [$this, 'allinoneaccessibilityDecodeJson']),
        ];
    }

    public function allinoneaccessibilitySettings(): string
    {
        $settings = $this->allinoneaccessibilityConfig->getConfig();
        return Json::json_encode($settings, JSON_HEX_QUOT | JSON_HEX_APOS);
    }

    /**
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function allinoneaccessibilityDecodeJson($str): object
    {
//        $settings = $this->allinoneaccessibilityConfig->getConfig();
        $select = "SELECT * FROM aioawidget_setting";
        $data = $this->container->get('database_connection')->executeQuery($select)->fetch();
        if (!$data){
          $data = [
                'license_key' => '',
                'color' => '#420083',
                'position' => 'bottom_right',
                'icon_type' => 'aioa-icon-type-1',
                'icon_size' => 'aioa-default-icon',
                'is_valid_key' => 0,
              ];
        }
        if (empty($str)) {
            return (object) [
                'license_key' => $data['license_key'],
                'color' => $data['color'],
                'position' => $data['position'],
                'icon_type' => $data['icon_type'],
                'icon_size' => $data['icon_size'],
            ];
        }
        return Json::json_decode($str);
    }
}
