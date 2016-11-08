RzPhoneCarrierBundle
====================

The RzPhoneCarrierBundle helps you to find carrier name by phone number in Guatemala (+502)

Installation
------------


Step 1: Download the Bundle
---------------------------

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```
$ composer require praga/shopify-bundle "dev-master"
```

Step 2: Enable the Bundle
-------------------------

Then, enable the bundle by adding it to the list of registered bundles
in the app/AppKernel.php file of your project:

``` php
<?php
// app/AppKernel.php

// ...
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...

            new Rz\PhoneCarrierBundle\RzPhoneCarrierBundle(),
        );

        // ...
    }

    // ...
}
```

Getting Started
--------------------------
config.yml:

```
rz_phone_carrier:
    default_country_code: 502 #Default Country Code
```

Inside a controller:

```
# This will find the carrier for the default country code:
$carrier = $this->get('rz_phone_carrier.matcher')->find('59183101');

# If you want to find another country code phone number:
$carrier = $this->get('rz_phone_carrier.matcher')->find('59183101', 1);
```

TODO:
-----
* New phone number ranges at: /Resources/config/PhoneNumbers