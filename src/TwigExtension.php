<?php

namespace Skynettechnologies\BoltAllinoneaccessibility;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

/**
 * @method  array
 */
class TwigExtension extends AbstractExtension
{
    private ParameterBagInterface $params;

    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('aioa_script', [$this, 'renderWidgetScript'], ['is_safe' => ['html']]),
        ];
    }

    public function renderWidgetScript(): string
    {
        // Example: You can define this URL in your config/services.yaml or another config file
        $scriptUrl = $this->params->get('aioa.widget_url') ?? '';

        if (!$scriptUrl) {
            return '<!-- AIOA Widget URL not configured -->';
        }

        return sprintf(
            '<script>(function(d){var s = d.createElement("script");s.setAttribute("data-account", "aioa");s.setAttribute("src", "%s");(d.body || d.head).appendChild(s);})(document);</script>',
            htmlspecialchars($scriptUrl)
        );
    }

    public function __call(string $name, array $arguments)
    {
        // TODO: Implement @method  array
    }
}
