<?php

namespace App\Controller;

use App\Services\SlugifyService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/wild", name="wild_")
 */
class WildController extends AbstractController
{
    /**
     * @param string $slug The slugger
     * @Route("/show/{slug<^[a-z0-9-]+$>}",
     *     name="show",
     *     defaults={"slug"=null},
     *  )
     * @return Response
     */
    public function show(?string $slug): Response
    {
        dump($slug);

        if ($slug == null) {
            $slug =  "Aucune série sélectionnée, veuillez choisir une série";
        } else {
            $slug = SlugifyService::unslugify($slug);
        }

        return $this->render('wild/show.html.twig',
            [
                'slug'  => $slug,
            ]
        );
    }
}
