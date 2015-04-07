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

        // Creamos el formulario de entrada
        $form = $this->createFormBuilder()
            ->add('arreglo', 'textarea')
            ->add('rango', 'number')
            ->getForm();
        $form->handleRequest($request);

        // Inicializamos los valores
        $result = [
            'range_input'    => '',
            'sorted_input'   => '',
            'sorted_output'  => '',
            'grouped_output' => ''
        ];

        if ($form->isValid()) {
            // Si el formulario es correcto
            /** @var  \GroupBundle\GroupByRange\GroupByRangeManager $manager */
            $manager = $this->get('groupbyrange_manager');

            //Obtenemos los datos
            $data = $form->getData();

            //E invocamos a los servicios, con los valores correctos y limpios
            $manager->sort_and_group(explode(',', trim($data['arreglo'])), $data['rango']);
            $grouped = $manager->getGrouped();

            $set = [];

            // Agrupamos los valores, para que se vean en formato de presentacion
            foreach($grouped as $group)
            {
                $set[] = '[' . implode(',', $group) . ']';
            }

            // Asignamos los valores obtenidos en los requests para ponerse en la vista
            $result['range_input']   = $data['rango'];
            $result['sorted_input']  = $data['arreglo'];
            $result['sorted_output'] = implode(', ', $manager->getSorted());
            $result['grouped_output'] = implode(', ', $set);
        }

        return $this->render('AppBundle::number.html.twig', array('form' => $form->createView(), 'result' => $result));
    }
}
