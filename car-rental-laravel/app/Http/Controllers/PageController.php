<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\View\View;

class PageController extends Controller
{
    /**
     * Display a specific page by slug.
     */
    public function show(Page $page): View
    {
        // Ensure page is published
        if (!$page->is_published) {
            abort(404);
        }

        return view('pages.show', compact('page'));
    }
}
