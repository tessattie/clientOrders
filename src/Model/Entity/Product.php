<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Product Entity
 *
 * @property int $id
 * @property string $ItemDescription
 * @property int $UPC
 * @property string $Pack
 * @property int $brand_id
 * @property string $SizeAlpha
 * @property float $Retail
 * @property float $CertCode
 * @property int $status
 * @property string $featured_image
 *
 * @property \App\Model\Entity\Brand $brand
 */
class Product extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
