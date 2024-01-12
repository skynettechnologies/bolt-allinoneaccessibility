<?php

declare(strict_types=1);

namespace Skynettechnologies\BoltAllinoneaccessibility;

use Doctrine\DBAL\Schema\Schema;
use Symfony\Component\Filesystem\Filesystem;
use Bolt\Extension\BaseExtension;
use Doctrine\DBAL\Connection;

class Extension extends BaseExtension
{
    /**
     * The name of the extension in the backend (/bolt/extensions)
     */

    public function getName(): string
    {
        return 'All in One Accessibility';
    }

    /**
     * @throws \Doctrine\DBAL\Exception
     */
    public function initialize(): void
    {
        $this->addTwigNamespace('allinoneaccessibility');

        $this->addWidget(new BoltAllinoneaccessibilityInjectorWidget());
        $sql = "
        CREATE TABLE IF NOT EXISTS `aioawidget_setting` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `license_key` VARCHAR(255),
            `color` VARCHAR(255),
            `position` VARCHAR(255),
            `icon_type` VARCHAR(255),
            `icon_size` VARCHAR(255),
            `is_valid_key` INT(50),
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
    ";
        $this->container->get('database_connection')->executeQuery($sql);
        if(isset($_POST["save"])){
            $select = "SELECT * FROM aioawidget_setting limit 1";
            $data = $this->container->get('database_connection')->executeQuery($select)->fetch();
//            var_dump($data);
//            exit();
            $license_key = isset($_POST['field-settings_license_key'])?$_POST['field-settings_license_key']:'';
            $colorcode = isset($_POST['field-settings_color'])?$_POST['field-settings_color']:'';
            $position = isset($_POST['field-settings_position'])?$_POST['field-settings_position']:'';
            $icon_type = isset($_POST['field-settings_allinoneaccessibility_icon_type'])?$_POST['field-settings_allinoneaccessibility_icon_type']:'';
            $icon_size = isset($_POST['field-settings_aioa_icon_size'])?$_POST['field-settings_aioa_icon_size']:'';
//            $is_valid_key = isset($_POST['field-settings_isvalid_key'])?$_POST['field-settings_isvalid_key']:'';

            $url = "https://www.skynettechnologies.com/add-ons/license-api.php?";
            $domain_name = $_SERVER['HTTP_HOST'];
            $metadata['token'] = isset($_POST['field-settings_license_key'])?$_POST['field-settings_license_key']:'';
            $metadata['domain'] = $domain_name;
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $metadata);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            $resp = curl_exec($curl);
            $resp = json_decode($resp);
            if ($resp->valid == 0 ){
                $_POST['field-settings_isvalid_key'] = 0;
            }else{
                $_POST['field-settings_isvalid_key'] = 1;
            }
            if(!empty($data)){
                $update = "UPDATE aioawidget_setting SET license_key = '".$license_key."',color = '".$colorcode."',position = '".$position."',icon_type = '".$icon_type."',icon_size = '".$icon_size."',is_valid_key = '".$_POST['field-settings_isvalid_key']."'  ";
                $this->container->get('database_connection')->executeQuery($update);
            }else{
                $insert = "INSERT INTO aioawidget_setting(license_key,color,position,icon_type,icon_size,is_valid_key) VALUES ('".$license_key."','".$colorcode."','".$position."','".$icon_type."','".$icon_size."','".$_POST['field-settings_isvalid_key']."') ";
                $this->container->get('database_connection')->executeQuery($insert);
            }
        }
    }

    /**
     * This function will copy all the files from /assets/ into the
     * /public/<extension-name>/ folder after it has been installed.
     *
     * If the user defines a different public directory the assets will
     * be copied to the custom public directory
     */
    public function install(): void
    {
        $projectDir = $this->getContainer()->getParameter('kernel.project_dir');
        $public = $this->getContainer()->getParameter('bolt.public_folder');

        $source = dirname(__DIR__) . '/assets/';
        $destination = $projectDir . '/' . $public . '/assets/';

        $filesystem = new Filesystem();
        $filesystem->mirror($source, $destination);

    }
    public function uninstall(): void
    {
        $drop = "DROP TABLE IF EXISTS 'aioawidget_setting' ";
        $this->container->get('database_connection')->executeQuery($drop);
    }
}
