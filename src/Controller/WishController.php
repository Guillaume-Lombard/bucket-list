<?php

namespace App\Controller;

use App\Repository\WishRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WishController extends AbstractController
{
    /**
     * @Route("/wish/list/", name="wish_list")
     */
    public function list(WishRepository $wishRepository): Response
    {
        $title = "List of whishes";

        $wishes = $wishRepository -> findBy([], ["dateCreated" => "DESC"]);


        return $this->render('wish/list.html.twig', [
            "wishes" => $wishes,
            "title" => $title
        ]);
    }

    /**
     * @Route("/wish/listBestWish/", name="wish_listBestWish")
     */
    public function listBestWish(WishRepository $wishRepository): Response
    {
        $title = "Top 10 best whishes";

        $wishes = $wishRepository -> findBestWish();


        return $this->render('wish/list.html.twig', [
            "wishes" => $wishes,
            "title" => $title
        ]);
    }

    /**
     * @Route("/wish/detail/{id}", name="wish_detail")
     */
    public function detail($id, WishRepository $wishRepository): Response
    {
        $wish = $wishRepository -> find($id);

        if (!$wish){
            throw $this->createNotFoundException("This wish doen't exist ! ");
        }

        return $this->render('wish/detail.html.twig', [
            'wish' => $wish
        ]);
    }
}
