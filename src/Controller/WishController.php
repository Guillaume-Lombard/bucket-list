<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Form\WishType;
use App\Repository\WishRepository;
use App\Services\Censurator;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WishController extends AbstractController
{
    /**
     * @Route("/wish/list/", name="wish_list")
     */
    public function list(WishRepository $wishRepository): Response
    {
        $titlePage = "List of whishes";

        $wishes = $wishRepository -> findAllWithCat();

        return $this->render('wish/list.html.twig', [
            "wishes" => $wishes,
            "titlePage" => $titlePage
        ]);
    }

    /**
     * @Route("/wish/listBestWish/", name="wish_listBestWish")
     */
    public function listBestWish(WishRepository $wishRepository): Response
    {
        $titlePage = "Top 10 best whishes";

        $wishes = $wishRepository -> findBestWish();


        return $this->render('wish/list.html.twig', [
            "wishes" => $wishes,
            "titlePage" => $titlePage
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

        dump($wish);

        return $this->render('wish/detail.html.twig', [
            'wish' => $wish
        ]);
    }

    /**
     * @Route("/wish/create/", name="wish_create")
     */
    public function create(Request $request, EntityManagerInterface $entityManager, Censurator $censurator): Response
    {
        $wish = new Wish();

        if ($this->getUser()){
            $wish->setAuthor($this->getUser()->getUsername());
        }

        $wishForm = $this->createForm(WishType::class, $wish);
        $wish->setIsPublished(true);
        $wish->setDateCreated(new \DateTime());

        $wishForm->handleRequest($request);

        if ($wishForm->isSubmitted() && $wishForm->isValid()){

            //service Censurator
            $string = $censurator->purify($wish->getDescription());
            $wish->setDescription($string);

            $entityManager->persist($wish);
            $entityManager->flush();

            $this->addFlash('success', 'Idea successfully added!');

            return $this->redirectToRoute('wish_detail', ['id' => $wish->getId()]);
        }

        return $this->render('wish/create.html.twig', [
                'wishForm' => $wishForm->createView()
        ]);
    }
}
