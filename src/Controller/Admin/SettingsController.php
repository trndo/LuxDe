<?php


namespace App\Controller\Admin;


use App\Entity\Settings;
use App\Form\SettingsType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SettingsController extends AbstractController
{
    /**
     * @Route("/admin/settings", name="settings")
     */
    public function addSettings(Request $request,EntityManagerInterface $em)
    {
        $form = $this->createForm(SettingsType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $data = $form->getData();

            $em->persist($data);
            $em->flush();

            $this->redirectToRoute('admin');
        }

        return $this->render('admin/settings.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/settings/add", name="edit_settings")
     */
    public function editSettings(Request $request,EntityManagerInterface $em,Settings $settings)
    {
        $form = $this->createForm(SettingsType::class,$settings);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){


            $em->flush();

            $this->redirectToRoute('admin');
        }

        return $this->render('admin/settings.html.twig',[
            'form' => $form->createView()
        ]);
    }
}