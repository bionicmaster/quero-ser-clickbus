<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {

        $form = $this->createFormBuilder()
            ->add('arreglo', 'textarea')
            ->add('rango', 'number')
            ->getForm();
        $form->handleRequest($request);

        $result = [
            'range_input'    => '',
            'sorted_input'   => '',
            'sorted_output'  => '',
            'grouped_output' => ''
        ];

        if ($form->isValid()) {
            /** @var  \GroupBundle\GroupByRange\GroupByRangeManager $manager */
            $manager = $this->get('groupbyrange_manager');
            $data = $form->getData();
            $manager->sort_and_group(array_map('intval', explode(',', trim($data['arreglo']))), $data['rango']);
            $grouped = $manager->getGrouped();

            $set = [];
            foreach($grouped as $group)
            {
                $set[] = '[' . implode(',', $group) . ']';
            }

            $result['range_input']   = $data['rango'];
            $result['sorted_input']  = $data['arreglo'];
            $result['sorted_output'] = implode(', ', $manager->getSorted());
            $result['grouped_output'] = implode(', ', $set);
        }

        return $this->render('AppBundle::number.html.twig', array('form' => $form->createView(), 'result' => $result));
    }
}
