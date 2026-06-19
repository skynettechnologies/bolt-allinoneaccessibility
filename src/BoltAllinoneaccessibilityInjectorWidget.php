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
        $domain = $_SERVER['HTTP_HOST'] ?? '';
        $domainBase64 = base64_encode($domain);
        // Widget settings
        $color   = '#420083';
        $token   = '';
        $position = 'bottom_right';
        $icon_type  = 'aioa-icon-type-1';
        $icon_size  = 'aioa-medium-icon';
        // Call API
        $apiUrl = 'https://ada.skynettechnologies.us/api/widget-settings';
        $ch = curl_init($apiUrl);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode([
                'website_url' => $domain
            ]),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json'
            ],
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
        ]);
        $response = curl_exec($ch);
        curl_close($ch);
        $apiResponse = json_decode($response, true);
        // 0 = EU | 1 = NON-EU
        $noRequiredEu = $apiResponse['Data']['no_required_eu'] ?? 1;
        if ($noRequiredEu == 0) {
            return "
                <script>
                    setTimeout(function () {
                        var s = document.createElement('script');
                        s.src = 'https://eu.skynettechnologies.com/accessibility/js/all-in-one-accessibility-js-widget-minify.js?colorcode={$color}&token={$token}&position={$position}';
                        s.id = 'aioa-adawidget';
                        s.defer = true;
                        document.body.appendChild(s);
                    }, 3000);
                </script>";
        } else {
            return "
            <script id='aioa-adawidget'
                src='https://www.skynettechnologies.com/accessibility/js/all-in-one-accessibility-js-widget-minify.js?colorcode={$color}&token={$token}&position={$position}.{$icon_type}.{$icon_size}'
                async='true'>
            </script>
        ";
        }
    }
}
