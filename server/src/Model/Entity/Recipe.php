<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Recipe Entity
 *
 * @property string $id
 * @property string $title
 * @property string $description
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 */
class Recipe extends Entity
{
    /**
     * @var array
     */
    protected $_accessible = [
        'title' => true,
        'description' => true,
        'created' => true,
        'modified' => true,
    ];
}
