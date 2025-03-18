<?php

namespace App\Http\Controllers;

use App\Models\Guarantor;
use Illuminate\Http\Request;

class GuarantorController extends Controller
{
    public function index()
    {
        $guarantors = Guarantor::all();
        $pageTitle = 'Jjj | Guarantors';
        return view('guarantors.index', compact('guarantors','pageTitle'));
    }

    public function create()
    {
        return view('guarantors.create');
    }

    public function store(Request $request)
    {
        $guarantor = Guarantor::create($request->all());
        session()->flash('message', 'Guarantor created successfully!');
        session()->flash('alert-type', 'success');
        return redirect()->route('guarantors.index');
    }

    public function show(Guarantor $guarantor)
    {
        return view('guarantors.show', compact('guarantor'));
    }

    public function edit(Guarantor $guarantor)
    {
        return view('guarantors.edit', compact('guarantor'));
    }

    public function update(Request $request, Guarantor $guarantor)
    {
        $guarantor->update($request->all());
        session()->flash('message', 'Guarantor updated successfully!');
        session()->flash('alert-type', 'success');
        return redirect()->route('guarantors.index');
    }

    public function destroy($id)
    {

        $guarantor = Guarantor::findOrFail($id);
        $guarantor->delete();
        session()->flash('message', 'Guarantor deleted successfully!');
        session()->flash('alert-type', 'success');
        return redirect()->route('guarantors.index');
    }
}
