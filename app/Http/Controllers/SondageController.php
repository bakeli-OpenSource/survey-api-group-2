<?php

namespace App\Http\Controllers;
use Exception;

use App\Models\Sondage;
use illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\SondageRequest;

class SondageController extends Controller
 {

    public function store(SondageRequest $request)
    {
        try 
        {
        $sondage = new Sondage();
        $sondage->titre = $request->titre; 
        $sondage->option = json_encode($request->option);
        $sondage->utilisateur_id = Auth::user()->id;
        $sondage->save();  

        return response()->json([
            'status_code' => 200,
            'status_message' => "Sondage créé avec succès",
            'sondage' => $sondage,
            'link' => url("api/sondage/{$sondage->id}")
            
        ]);

    } catch (Exception $e) {
        return response()->json($e);
    }
    }

     // liste des sondages d'un utilisateur
     public function sondage()
     {
         try 
         {
         $sond = Sondage::where('utilisateur_id', Auth::user()->id)->get();
         return response()->json([
             'status_code' => 200,
             'status_message' => "Liste de mes sondages créés",
             'sondage' => $sond
             
         ]);
 
     } catch (Exception $e) {
         return response()->json($e);
     }
     }
 // pour l'affichage d'un sondage
 public function singleSondage(Sondage $sondage)
 { 
     try 
     {
         $son = Sondage::where('id', $sondage->id)->firstOrFail();
         return response()->json([
         'status_code' => 200,
         'status_message' => "sondage généré",
         'titre' => $son->titre,
         'option' => explode(',', $son->option)
         
     ]);

 } catch (Exception $e) {
     return response()->json($e);
 }
 }

 }