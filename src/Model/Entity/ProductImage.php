<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ProductImage Entity
 *
 * @property int $id
 * @property string $file_name
 * @property string $file_dir
 * @property int $product_id
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 *
 * @property \App\Model\Entity\Product $product
 */
class ProductImage extends Entity
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

    protected $_virtual = ['file_path'];

    public function _getFilePath()
    {
        if (isset($this->_properties['file_dir']) && isset($this->_properties['file_name'])) {
            return str_replace('webroot/', '', $this->_properties['file_dir']).$this->_properties['file_name'];
        }
        return '';
    }
}
