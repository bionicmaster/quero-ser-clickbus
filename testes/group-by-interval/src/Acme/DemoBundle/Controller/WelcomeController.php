<?php

namespace Acme\DemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use GroupBundle\GroupByRange\Sorter;

class WelcomeController extends Controller
{
    public function indexAction()
    {
        /*
         * The action's view can be rendered using render() method
         * or @Template annotation as demonstrated in DemoController.
         *
         */

        /** @var \GroupBundle\GroupByRange\GroupByRangeManager $manager */
        $manager = $this->get('groupbyrange_manager');
        $grouped = $manager->sort_and_group([10, 1, -20,  14, 99, 136, 19, 20, 117, 22, 93,  120, 131], 10);


        print_r($grouped);
        return $this->render('AcmeDemoBundle:Welcome:index.html.twig');
    }
}
