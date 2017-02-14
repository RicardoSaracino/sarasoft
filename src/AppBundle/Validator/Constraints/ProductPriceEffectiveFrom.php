<?php
/**
 * @author Ricardo Saracino
 * @since 02/10/17
 */

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Class ProductPriceEffectiveFrom
 * @package AppBundle\Validator\Constraints
 *
 * @Annotation
 */
class ProductPriceEffectiveFrom extends Constraint
{
	public $message = 'Effective from date must be after %date%';
}