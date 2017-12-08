<?php

namespace App\Controller;

use App\Entity\BlogEntry;
use App\Form\BlogEntryType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BlogEntryController extends Controller
{
    /**
     * @Route("/blog/entry", name="blog_entry")
     */
    public function index()
    {
        $em= $this ->getDoctrine()->getManager();
        $blogEntries=$em->getRepository(BlogEntry::class)->findAll();

        return $this->render("blog/index.html.twig",array(
            "blog_entries"=> $blogEntries
        ));



    }

    /**
     * @Route("/blog/entry/today")
     */
    public function showToday(){
        $em = $this -> getDoctrine()->getManager();
        $blogEntries=$em->getRepository(BlogEntry::class)->findAllCreatedToday();
        return new Response(var_dump($blogEntries));
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("blog/entry/new")
     */
    public function newAction(Request $request){
        $blogEntry= new BlogEntry();
        $form=$this->createForm(BlogEntryType::class,$blogEntry);
        $form->handleRequest($request);
        if ($form->isSubmitted()){
            $blogEntry=$form->getData();
            $em=$this->getDoctrine()->getManager();
            $em->persist($blogEntry);
            $em->flush();

            return new Response("créé avec succès".$blogEntry->getId());

        }
        return $this->render("blog/new.html.twig",array(
            "form"=>$form->createView()
        ));
    }

    /**
     * @param $id
     * @return Response
     * @Route("/blog/entry/{id}", name="blogEntry_Show")
     */
    public function show(BlogEntry $blogEntry){

        if(!$blogEntry) {
            throw $this->createNotFoundException('KAKAKAKAAK');
        }
     return new Response('Regardez ma grosse bite'.$blogEntry->getTitle());

    }

}
