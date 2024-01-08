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
//        $values = new BoltAllinoneaccessibilityField();
//        $request = $this->getExtension()->getRequest();
//        // Only produce output when editing or creating a Record, with GET method.
//        if (! in_array($request->get('_route'), ['bolt_content_edit', 'bolt_content_new', 'bolt_content_duplicate'], true) ||
//            ($this->getExtension()->getRequest()->getMethod() !== 'GET')) {
//            return null;
//        }
        $conn = $this->getExtension()->getObjectManager()->getConnection();
        $data = $conn
            ->prepare("Select * from aioawidget_setting")
            ->executeQuery()
            ->fetch();
        if($data){
            $license_key = $data['license_key'];
            $colorcode = $data['color'];
            $position = $data['position'];
            $icon_type = $data['icon_type'];
            $icon_size = $data['icon_size'];
        }else{
            $license_key = '';
            $colorcode = '#420083';
            $position = 'bottom_right';
            $icon_type = 'aioa-icon-type-1';
            $icon_size = 'aioa-big-icon';
        }
        $getdata = "<script id='aioa-adawidget' src='https://www.skynettechnologies.com/accessibility/js/all-in-one-accessibility-js-widget-minify.js?colorcode=".$colorcode."&token=".$license_key."&position=".$position.".".$icon_type.".".$icon_size."' async='true'></script>";
        return $getdata;
    }
}
