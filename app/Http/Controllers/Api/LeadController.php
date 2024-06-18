<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\NewLead;
use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class LeadController extends Controller
{
    public function store(Request $request)
    {
        // validiamo la request: i dati che arrivano dal form
        $data = $request->all();


        // deve essere un'istanza di Illuminate\Support\Facades\Validator;
        $validator = Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required'
        ]);

        // Se la validazione è fallita        
        if($validator->fails())
        {
            // ritorneremo una response in json con gli errori fatti
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ]);
        }

        // altrimenti, se i dati sono validi
        // salviamo il nuovo lead nel DB 
        $lead = Lead::create($data);

        // iniviamo una mail di notifica all'amministratore dei contatti
        Mail::to('marco.colloca@yahoo.it')->send(new NewLead($lead));

        // ritorniamo una response json con indicato il risultato di successo
        return response()->json([
            'success' => true
        ]);
        

    }
}
