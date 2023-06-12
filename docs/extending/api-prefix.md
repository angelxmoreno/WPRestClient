# Changing the API Prefix

Once you have an instance of `ApiClient` you can use the `setApiPrefix()` method override the default prefix
of `wp-json/wp/v2`. See [Api Prefix](../usage/client.md#api-prefix) for more info.

You may find that you are unable to work with Custom Post types configured in either ACF or CPT-UI.  To work around this for now you can create your own class in your sourcecode that implements the `AbstractWpEndpoint` interface. 

In order to get data from a custom post type of "Promotions" you can include this code

```PHP
<?php

namespace App\WpApiClient;

use Vnn\WpApiClient\Endpoint\AbstractWpEndpoint;

/**
 * Class Posts
 * @package Vnn\WpApiClient\Endpoint
 */
class Promotion extends AbstractWpEndpoint
{
    /**
     * {@inheritdoc}
     */
    protected function getEndpoint()
    {
        // make sure that the URL renders in a browser 
        return '/wp-json/wp/v2/promotion';
    }
}

```

Then calling 

```PHP
use App\WPApiClient\Promotion;

$client = new WpClient(); // your client credentials  

$promotions = new Promotion($client); // WpClient

return $promotions->get();

```
