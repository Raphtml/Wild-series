<?php

namespace App\Controller;

use App\Entity\Episode;
use App\Entity\Program;
use App\Entity\Season;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/programs", name="program_")
 */
class ProgramController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        $programs = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findAll();

        return $this->render('program/index.html.twig', [
            'website' => 'Wild Series' ,
            'programs' => $programs
        ]);
    }

    /**
     * @Route("/{id<\d+>}", methods={"GET"}, name="show")
     * @return Response
     */
    public function show(int $id): Response
    {
        $program = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findOneBy(['id' => $id]);

        $seasons = $this->getDoctrine()
            ->getRepository(Season::class)
            ->findBy(['program_id' => $id]);

        if ((!$program)) {
            throw $this->createNotFoundException(
                'No program with id : ' . $id . ' found in program\'s table.'
            );
        }


        return $this->render('program/show.html.twig', [
            'id' => $id,
            'program' => $program,
            'seasons' => $seasons
        ]);
    }

    /**
     * @Route("/{programId}/seasons/{seasonId}", methods={"GET"}, name="season_show")
     * @param int $programId
     * @param int $seasonId
     * @return Response
     */
    public function showSeason(int $programId, int $seasonId): Response
    {
        $program = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findOneBy(['id' => $programId]);

        $season = $this->getDoctrine()
            ->getRepository(Season::class)
            ->findOneBy(['id' => $seasonId]);

        $episodes = $this->getDoctrine()
            ->getRepository(Episode::class)
            ->findBy(['season_id' => $seasonId]);

        return $this->render('program/season_show.html.twig', [
            'program' => $program,
            'season' => $season,
            'episodes' => $episodes
        ]);
    }
}