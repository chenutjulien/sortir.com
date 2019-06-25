<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class TripController extends Controller
{
    /**
     * @Route("/listTrip", name="trip_trip")
     */
    public function listTrip()
    {
        return $this->render('trip/trip.html.twig');
    }
}
