<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use App\Model\Entity\ProtocolTrait;

/**
 * Setting Entity
 *
 * @property int $id
 * @property string $site_name
 * @property string $site_cellphone
 * @property string $site_phone
 * @property string $site_email
 * @property string $social_facebook
 * @property string $social_twitter
 * @property string $social_instagram
 * @property string $street
 * @property string $city
 * @property string $country
 * @property bool $site_active
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 */
class Setting extends Entity
{
    use ProtocolTrait;

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

    protected $_hidden = [
        'id'
    ];

    /**
     * Set facebook url
     * @param string $url
     * @return string
     */
    public function _setSocialFacebook($url)
    {
        return $this->removeProtocol($url);
    }

    /**
     * Set twitter url
     * @param string $url
     * @return string
     */
    public function _setSocialTwitter($url)
    {
        return $this->removeProtocol($url);
    }

    /**
     * Set instagram url
     * @param string $url
     * @return string
     */
    public function _setSocialInstagram($url)
    {
        return $this->removeProtocol($url);
    }
}
