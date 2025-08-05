<?php

namespace Skynettechnologies\BoltAllinoneaccessibility\Field;

use Bolt\Entity\Field;
use Bolt\Entity\FieldInterface;
use Twig\Environment;

class AllinoneaccessibilityFieldType implements FieldInterface
{
    public function getName(): string
    {
        return 'allinoneaccessibility';
    }

    /**
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     * @throws \Twig\Error\LoaderError
     */
    public function render(Field $field, Environment $twig, array $context = []): string
    {
        $value = $field->getValue();
        return $twig->render('@allinoneaccessibility/allinoneaccessibility.html.twig', [
            'id' => $field->getId(),
            'user_name' => $value['user_name'] ?? 'admin',
            'email' => $value['email'] ?? 'admin@example.com',
            'domain' => $_SERVER['HTTP_HOST'] ?? 'localhost',
            'color' => $value['color'] ?? '#420083',
            'position' => $value['position'] ?? 'bottom_right',
            'icon_type' => $value['icon_type'] ?? 'aioa-icon-type-1',
            'icon_size' => $value['icon_size'] ?? 'aioa-default-icon',
            'widget_icon_size_custom' => $value['widget_icon_size_custom'] ?? 20,
            'widget_position_left' => $value['widget_position_left'] ?? 0,
            'widget_position_top' => $value['widget_position_top'] ?? 0,
            'widget_position_right' => $value['widget_position_right'] ?? 0,
            'widget_position_bottom' => $value['widget_position_bottom'] ?? 0,
            'widget_size' => $value['widget_size'] ?? 0,
            'is_widget_custom_position' => $value['is_widget_custom_position'] ?? 0,
            'is_widget_custom_size' => $value['is_widget_custom_size'] ?? 0,
        ]);
    }
    public function getStorageType(): string
    {
        return 'json';
    }

    public function isContentSelect(): bool
    {
        return false;
    }

    public function getType(): string
    {
        // TODO: Implement getType() method.
    }
}
