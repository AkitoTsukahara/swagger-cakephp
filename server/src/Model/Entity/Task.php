<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Task Entity
 *
 * @property string $id
 * @property string $description
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 */
class Task extends Entity
{
    /**
     * @var array
     */
    protected $_accessible = [
        'description' => true,
        'created' => true,
        'modified' => true,
    ];
}
