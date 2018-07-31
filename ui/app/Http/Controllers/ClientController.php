<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;

class ClientController extends Controller
{
    public function index()
    {
        return view('clients/create');
    }

    public function residentialIndex()
    {
        $clients = Client::getResidential();
        return view('clients/residential')->with(['clients' => $clients]);
    }

    public function businessIndex()
    {
        $clients = Client::getBusiness();
        return view('clients/business')->with(['clients' => $clients]);
    }

    public function create(Request $request)
    {
        if(empty($request['name']))
        {
            return back()->with('message', 'Name cannot be blank');
        }

        $client = new Client();
        $client->name = $request->name;
        $client->type = (int) $request->type;
        $client->save();

        return redirect($request->type == 1 ? 'clients/residential' : 'clients/business')->with('message', 'Successfully added new client');
    }

    public function edit(Request $request)
    {
        return view('clients/edit')->with('client', Client::where('id', $request->id)->first());
    }

    public function update(Request $request)
    {
        if(empty($request['name']))
        {
            return back()->with('message', 'Name cannot be blank');
        }

        $client = Client::find($request->id);
        $client->name = $request->name;
        $client->type = (int) $request->type;
        $client->save();

        return redirect($request->type == 1 ? 'clients/residential' : 'clients/business')->with('message', 'Successfully added new client');
    }

    public function delete(Request $request)
    {
        $client = Client::find($request->id);
        $client->delete();

        return back()->with('message', 'Successfully deleted client');
    }
}
