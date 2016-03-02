<?php

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class TestController extends Controller
{

    /**
    * Create a client with a default Authorization header.
    *
    * @param string $host
    * @param string $username
    * @param string $password
    *
    * @return \Symfony\Bundle\FrameworkBundle\Client
    */
    protected function createAuthenticatedClient($host, $username = 'test', $password = '123')
    {
        $client = new Client();
        $res = $client->request('POST', "http://$host/api/login_check", [
            'form_params' => [
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
    public function helloAction(Request $request)
    {
        $host = $request->getHost();        
        $client = $this->createAuthenticatedClient($host);
        $res = $client->get("http://$host/api/hello");
        
        return new Response( $res->getBody()->getContents() );
    }


}
