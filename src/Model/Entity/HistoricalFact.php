<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * HistoricalFact Entity
 *
 * @property int $id
 * @property \Cake\I18n\FrozenTime $timestamp
 * @property string $schoolbox_totalusers
 * @property string $schoolbox_config_site_type
 * @property string $schoolbox_users_student
 * @property string $schoolbox_users_staff
 * @property string $schoolbox_users_parent
 * @property string $schoolbox_totalcampus
 * @property string $schoolbox_package_version
 * @property string $schoolboxdev_package_version
 * @property string $schoolbox_config_site_version
 * @property string $virtual
 * @property string $lsbdistdescription
 * @property string $kernelmajversion
 * @property string $kernelrelease
 * @property string $php_cli_version
 * @property string $mysql_extra_version
 * @property string $processorcount
 * @property string $memorysize
 * @property string $schoolbox_config_date_timezone
 * @property string $schoolbox_config_external_type
 * @property string $schoolbox_first_file_upload_year
 */
class HistoricalFact extends Entity
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
        'timestamp' => true,
        'schoolbox_totalusers' => true,
        'schoolbox_config_site_type' => true,
        'schoolbox_users_student' => true,
        'schoolbox_users_staff' => true,
        'schoolbox_users_parent' => true,
        'schoolbox_totalcampus' => true,
        'schoolbox_package_version' => true,
        'schoolboxdev_package_version' => true,
        'schoolbox_config_site_version' => true,
        'virtual' => true,
        'lsbdistdescription' => true,
        'kernelmajversion' => true,
        'kernelrelease' => true,
        'php_cli_version' => true,
        'mysql_extra_version' => true,
        'processorcount' => true,
        'memorysize' => true,
        'schoolbox_config_date_timezone' => true,
        'schoolbox_config_external_type' => true,
        'schoolbox_first_file_upload_year' => true,
    ];
}
