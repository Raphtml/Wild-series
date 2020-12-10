<?php

namespace App\Controller;

use App\Entity\Actor;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ActorController
 * @package App\Controller
 * @Route("/actors", name="actor_")
 */
class ActorController extends AbstractController
{
    /**
     * @Route("/{id}", name="show", methods={"GET"})
     * @return Response
     */
    public function show(Actor $actor): Response
    {
        return $this->render("actor/show.html.twig", [
            'actor' => $actor
        ]);
    }
}