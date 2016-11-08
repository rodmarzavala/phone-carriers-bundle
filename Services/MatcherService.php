<?php

namespace Rz\PhoneCarrierBundle\Services;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

class MatcherService
{
    /** @var ContainerInterface $container */
    protected $container;

    /**
     * ShopifyService constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Read YAML file.
     * @param int $country_code Country code
     * @return array
     * */
    public function load($country_code)
    {
        try {
            $filename = __DIR__.'/../Resources/config/PhoneNumbers/'.$country_code.'.yml';
            return Yaml::parse(@file_get_contents($filename));
        } catch (ParseException $e) {
            return [];
        }
    }

    /**
     * Find carrier for phone number.
     * @param mixed $phone_number Phone number
     * @param int $country_code
     * @return mixed
     * */
    public function find($phone_number, $country_code = null)
    {
        $phone_number = $this->sanitizePhoneNumber($phone_number);

        if (!$country_code) {
            $country_code = $this->container->getParameter('rz_phone_carrier.default_country_code');
        }

        $database = $this->load($country_code);
        $phone_numbers = isset($database['phone_numbers']) ? $database['phone_numbers'] : [];
        $carriers = isset($database['carriers']) ? $database['carriers'] : [] ;
        $carrier = null;

        foreach ($phone_numbers as $range) {
            $min = $range['min'];
            $max = $range['max'];

            if ($phone_number>= $min && $phone_number <= $max) {
                $carrier = isset($carriers[$range['carrier']]) ? $carriers[$range['carrier']] : '';
                break;
            }
        }

        return $carrier;
    }

    /**
     * Sanitize the phone number to integer.
     * @param mixed $phone_number
     * @return int
     * */
    protected function sanitizePhoneNumber($phone_number)
    {
        $phone_number = preg_replace("/[^0-9]/", "", $phone_number);
        return $phone_number;
    }
}
