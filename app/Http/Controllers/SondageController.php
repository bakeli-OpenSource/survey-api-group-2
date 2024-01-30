<?php

namespace App\Http\Controllers;
use App\Models\Sondage;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SondageController extends Controller
{
    // get all
    public function index()
        {
            $sondages = Sondage::all();
            return response()->json($sondages, 200);
        }
// get ID
    public function show($id)
       {
        $sondage = Sondage::find($id);

        if (!$sondage) {
            return response()->json(["message' => 'Sondage non trouvé avec l'ID $id"], 404);
        }

        return response()->json($sondage, 200);
       }
//   Post Sondage
    public function store(Request $request)
        {
            // Validation des données
            $sondageDonnee = $request->validate([
                'question' => 'required|string',
                'options' => 'required|array|min:2',
                'options.*' => 'string',
            ]);

            $sondages = Sondage::create([
                "question"=> $sondageDonnee["question"],
                "options"=> $sondageDonnee["options"],
            ]);
            return response($sondages,201);
        }

    // Update Sondage 
    public function update(Request $request, $id)
       {
    // Validation des données
    $sondageDonnee = $request->validate([
        'question' => 'required|string',
        'options' => 'required|array|min:2',
        'options.*' => 'string', 
    ]);

    $sondages = Sondage::findOrFail($id);

    // Mise à jour des données du sondage
    $sondages->update([
        "question" => $sondageDonnee["question"],
        "options" => $sondageDonnee["options"],
    ]);

    return response()->json($sondages, 200);
        }

        // Delete Sondage
        public function destroy($id)
            {
                $sondages = Sondage::findOrFail($id);

                $sondages->delete();

               return response()->json(['message' => 'Sondage supprimé avec succès'], 200);
        
    }

}



// /**
//      * Récupère la liste des sondages.
//      *
//      * @return \Illuminate\Http\Response
//      */
//     public function index()
//     {
//         $sondages = Sondage::all();
//         return response()->json($sondages, 200);
//     }

//     /**
//      * Récupère les détails d'un sondage spécifique.
//      *
//      * @param  int  $id
//      * @return \Illuminate\Http\Response
//      */
//     public function show($id)
//     {
//         $sondage = Sondage::find($id);

//         if (!$sondage) {
//             return response()->json(['message' => 'Sondage non trouvé'], 404);
//         }

//         return response()->json($sondage, 200);
//     }

//     /**
//      * Crée un nouveau sondage.
//      *
//      * @param  \Illuminate\Http\Request  $request
//      * @return \Illuminate\Http\Response
//      */
//     public function store(Request $request)
//     {
//         // Validation des données
//         $validator = Validator::make($request->all(), [
//             'question' => 'required|string',
//             'options' => 'required|array|min:2',
//         ]);

//         if ($validator->fails()) {
//             return response()->json(['error' => $validator->errors()], 400);
//         }

//         // Création du sondage
//         $sondage = Sondage::create([
//             'question' => $request->input('question'),
//             'options' => $request->input('options'),
//         ]);

//         return response()->json($sondage, 201);
//     }

//     /**
//      * Met à jour un sondage existant.
//      *
//      * @param  \Illuminate\Http\Request  $request
//      * @param  int  $id
//      * @return \Illuminate\Http\Response
//      */
//     public function update(Request $request, $id)
//     {
//         // Validation des données
//         $validator = Validator::make($request->all(), [
//             'question' => 'required|string',
//             'options' => 'required|array|min:2',
//         ]);

//         if ($validator->fails()) {
//             return response()->json(['error' => $validator->errors()], 400);
//         }

//         // Mise à jour du sondage
//         $sondage = Sondage::find($id);

//         if (!$sondage) {
//             return response()->json(['message' => 'Sondage non trouvé'], 404);
//         }

//         $sondage->update([
//             'question' => $request->input('question'),
//             'options' => $request->input('options'),
//         ]);

//         return response()->json($sondage, 200);
//     }

//     /**
//      * Supprime un sondage spécifique.
//      *
//      * @param  int  $id
//      * @return \Illuminate\Http\Response
//      */
//     public function destroy($id)
//     {
//         $sondage = Sondage::find($id);

//         if (!$sondage) {
//             return response()->json(['message' => 'Sondage non trouvé'], 404);
//         }

//         $sondage->delete();

//         return response()->json(['message' => 'Sondage supprimé avec succès'], 204);
//     }

