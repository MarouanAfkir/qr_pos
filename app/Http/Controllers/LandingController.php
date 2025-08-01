<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingController extends Controller
{
    /**
     * Affiche la page d’accueil (FR ou AR) selon le paramètre lang.
     *
     *  URL : /
     *  ?lang=ar  => vue arabe
     *  ?lang=fr  => vue française (défaut)
     */
    public function index(Request $request)
    {
        // 1) Déterminer la langue demandée
        $lang = $request->query('lang', 'fr');   // fr par défaut
        $view = 'landing_fr';                    // vue par défaut

        // 2) Sélectionner la bonne vue + fixer la locale Laravel
        if ($lang === 'ar') {
            app()->setLocale('ar');
            $view = 'landing_ar';                // votre fichier arabe
        } else {
            app()->setLocale('fr');
        }

        // 3) Retourner la vue
        return view($view);
    }
}
