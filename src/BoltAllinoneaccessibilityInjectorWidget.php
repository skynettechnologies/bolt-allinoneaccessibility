<?php

declare(strict_types=1);

namespace Skynettechnologies\BoltAllinoneaccessibility;

use Bolt\Widget\BaseWidget;
use Bolt\Widget\Injector\RequestZone;
use Bolt\Widget\Injector\Target;
use Bolt\Widget\TwigAwareInterface;
use Doctrine\DBAL\DriverManager;

class BoltAllinoneaccessibilityInjectorWidget extends BaseWidget implements TwigAwareInterface
{

    protected $name = 'boltallinoneaccessibility Injector Widget';
    protected $target = Target::AFTER_JS;
    protected $zone = RequestZone::FRONTEND;
    protected $template = '@boltallinoneaccessibility/injector.html.twig';
    protected $priority = 200;

    public function __construct()
    {
    }

    /**
     * @throws \Doctrine\DBAL\Exception
     * @throws \Doctrine\DBAL\Driver\Exception
     */

    public function run(array $params = []): ?string
    {
        return '<script>
            const scriptTag = document.createElement("script");
            scriptTag.id = "aioa-adawidget";
            scriptTag.src = "https://www.skynettechnologies.com/accessibility/js/all-in-one-accessibility-js-widget-minify.js?colorcode=#&token=&position=";
            document.head.appendChild(scriptTag);
        </script>';
    }
}
