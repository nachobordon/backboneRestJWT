<?php

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\Response;

class TestController extends Controller
{

    /**
    * Create a client with a default Authorization header.
    *
    * @param string $username
    * @param string $password
    *
    * @return \Symfony\Bundle\FrameworkBundle\Client
    */
    protected function createAuthenticatedClient($username = 'admin', $password = '123')
    {

        $client = new Client();
        $res = $client->request(
            'POST',
            'http://pruebas/visualcover/web/app_dev.php/api/login_check',
            [ 'form_params' => [
                '_username' => $username,
                '_password' => $password,
            ]]
        );
        
        $data = json_decode($res->getBody()->getContents(), true);
    var_dump($data);

        $client = new Client([
            'headers' => [
                'Authorization' => sprintf('Bearer %s', $data['token'])
            ]
        ]);


        return $client;
    }

   

    /**
    * @Route("/hello")
    * 
    * test getHelloAction
    */
    public function helloAction()
    {
        $client = $this->createAuthenticatedClient();
        $res = $client->get('http://pruebas/visualcover/web/app_dev.php/api/hello');
        
        
        return new Response($res->getBody()->getContents());
    }


}
