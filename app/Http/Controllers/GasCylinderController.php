<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GasCylinderController extends Controller
{
    public function index()
    {
        return response()->json(GasCylinder::all());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'size' => 'required|numeric|min:0',
            'isActive' => 'required|boolean',
        ]);

        $cylinder = GasCylinder::create($data);

        return response()->json($cylinder, 201);
    }

    public function show($id)
    {
        $cylinder = GasCylinder::findOrFail($id);
        return response()->json($cylinder);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'string|max:255',
            'description' => 'string|max:255',
            'size' => 'numeric|min:0',
            'isActive' => 'boolean',
        ]);

        $cylinder = GasCylinder::findOrFail($id);
        $cylinder->update($data);

        return response()->json($cylinder);
    }

    public function destroy($id)
    {
        $cylinder = GasCylinder::findOrFail($id);
        $cylinder->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }
}
