<?php

declare(strict_types=1);

namespace Skynettechnologies\BoltAllinoneaccessibility\Entity;

use Bolt\Entity\Field;
use Bolt\Entity\Field\Excerptable;
use Bolt\Entity\FieldInterface;
use Doctrine\ORM\Mapping as ORM;
use Twig\Markup;

/**
 * @ORM\Entity
 */
class BoltAllinoneaccessibilityField extends Field implements Excerptable, FieldInterface
{
    // This defines the name of the type used in the contenttypes.yaml field
    public const TYPE = 'allinoneaccessibility';

    /**
     * Override getTwigValue to render field as html
     */
    public function getTwigValue(): Markup
    {
        $value = parent::getTwigValue();
        return new Markup($value, 'UTF-8');
    }
}
