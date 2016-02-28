<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class DefaultController extends Controller
{

    /**
     * @ApiDoc(
     *  resource=true,
     *  description="Hello method",
     *  input="Your\Namespace\Form\Type\YourType",
     *  output="Your\Namespace\Class"
     * )
     * 
     * 
     * @return array
     */
    public function getHelloAction()
    {
        return array('hello' => 'world');
    }
    
    /**
    * Create a client with a default Authorization header.
    *
    * @param string $username
    * @param string $password
    *
    * @return \Symfony\Bundle\FrameworkBundle\Client
    */
    protected function createAuthenticatedClient($username = 'user', $password = 'password')
    {
        $client = static::createClient();
        $client->request(
            'POST',
            '/api/login_check',
            array(
                '_username' => $username,
                '_password' => $password,
            )
        );

        $data = json_decode($client->getResponse()->getContent(), true);

        $client = static::createClient();
        $client->setServerParameter('HTTP_Authorization', sprintf('Bearer %s', $data['token']));

        return $client;
    }

    /**
    * test getPagesAction
    */
    public function testGetPages()
    {
        $client = $this->createAuthenticatedClient();
        $client->request('GET', '/api/pages');
        // ... 
    }

}
