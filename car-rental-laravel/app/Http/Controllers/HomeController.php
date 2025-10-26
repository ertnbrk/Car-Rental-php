<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use App\Models\Testimonial;
use App\Models\Team;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Display the home page.
     */
    public function index(): View
    {
        // Get active sliders
        $sliders = Slider::active()->get();

        // Get featured/available cars (limit to 6)
        $featuredCars = Car::available()->take(6)->get();

        // Get published testimonials
        $testimonials = Testimonial::published()->take(10)->get();

        // Get active team members
        $team = Team::active()->take(8)->get();

        return view('home.index', compact('sliders', 'featuredCars', 'testimonials', 'team'));
    }
}
