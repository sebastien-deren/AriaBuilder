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
use App\Domain\Personnages\Characteristiques\CharacRules;

class CharacteristicsController extends AbstractController
{
    #[Route('api/characteristics', name: 'app_characteristics')]
    public function index(): Response
    {
        return new JsonResponse(['id' => 4, 'name' => 'toto'], 200);
    }
    #[Route('api/characacter/{id}/Characteristics', name: 'characteristics_create')]
    public function create(Request $request, CharacBuilderInterface $builder, CaracteristiqueRepository $repository, Personnage $personnage): Response
    {
        try {
            $jsonData = \json_decode($request->getContent()) ?? throw new \Exception('json file couldn\'t be retrieve', Response::HTTP_BAD_REQUEST);
            $receivedCharacteristics = $this->processCharac($jsonData);
            $caracteristique = $builder->Build($receivedCharacteristics);
            $personnage->setCaracteristique($caracteristique);
            $repository->save($caracteristique, true);
        } catch (\Exception $e) {
            return new JsonResponse('{"errror": ' . $e->getMessage() . '}', $e->getCode(), [], true);
        }
        return new JsonResponse($caracteristique, Response::HTTP_CREATED);
    }
    private function processCharac(array $content): Characteristics
    {
        if ('ok' === $content['status']) {
            $createCharacs = $content['characteristics'];
            $characteristics  = new Characteristics();
            $characteristics->force = $createCharacs['force'];
            $characteristics->dexterite = $createCharacs['dexterite'];
            $characteristics->endurance = $createCharacs['endurance'];
            $characteristics->intelligence = $createCharacs['intelligence'];
            $characteristics->charisme = $createCharacs['charisme'];
            $characteristics->rules = in_array($content['rules'], CharacRules::cases()) ? $content['rules'] : throw new \Exception('Rules you tried to use is invalid, valid rules are : "dice","three dices","point"', Response::HTTP_BAD_REQUEST);
            $characteristics->dices = $content['dices'];
            return $characteristics;
        }

        if ('error' === $content['status']) {
            throw new \Exception('unable to retrieve data', Response::HTTP_BAD_REQUEST);
        }
    }
}
