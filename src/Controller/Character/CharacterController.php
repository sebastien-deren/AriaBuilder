<?php

namespace App\Controller\Character;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CharacterController extends AbstractController
{
    #[Route('api/character', name: 'app_character_index', methods: 'GET')]
    public function getAll(Request $request): Response
    {
        $request = json_decode($request->getContent());
        return new Response();
    }
    public function create(Request $request): Response
    {
        return new Response();
    }
    public function get(Request $request): Response
    {
        return new Response();
    }
    public function modify(Request $request): Response
    {
        return new Response();
    }
    public function delete(Request $request): Response
    {
        return new Response();
    }
}
