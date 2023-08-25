<?php

namespace App\Controller;

use App\Domain\Model\Personnage;
use App\Controller\Characteristics;
use App\Repository\CaracteristiqueRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Domain\Personnages\Characteristiques\CharacBuilderInterface;

class CharacteristicsController extends AbstractController
{
    #[Route('api/characteristics', name: 'app_characteristics')]
    public function index(): Response
    {
        return $this->render('characteristics/index.html.twig', [
            'controller_name' => 'CharacteristicsController',
        ]);
    }
    #[Route('api/characacter/{id}/Characteristics', name: 'characteristics_create')]
    public function create(Request $request, CharacBuilderInterface $builder, CaracteristiqueRepository $repository, Personnage $personnage): Response
    {
        try {
            $jsonData = \json_decode($request->getContent()) ?? throw new \Exception('json file couldn\'t be retrieve', Response::HTTP_BAD_REQUEST);
            $receivedCharacteristics = $this->processResponse($jsonData);
            $caracteristique = $builder->Build($receivedCharacteristics);
            $personnage->setCaracteristique($caracteristique);
            $repository->save($caracteristique, true);
        } catch (\Exception $e) {
            return new JsonResponse('{"errror": ' . $e->getMessage() . '}', $e->getCode(), [], true);
        }
        return new JsonResponse($caracteristique, Response::HTTP_CREATED);
    }
    private function processResponse(array $content): Characteristics
    {
        if ('ok' === $content['status']) {
            $createCharacs = $content['characteristics'];
            $characteristics  = new Characteristics();
            $characteristics->force = $createCharacs['force'];
            $characteristics->dexterite = $createCharacs['dexterite'];
            $characteristics->endurance = $createCharacs['endurance'];
            $characteristics->intelligence = $createCharacs['intelligence'];
            $characteristics->charisme = $createCharacs['charisme'];
            return $characteristics;
        }

        if ('error' === $content['status']) {
            throw new \Exception('unable to retrieve data', Response::HTTP_BAD_REQUEST);
        }
    }
}
