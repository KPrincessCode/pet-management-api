<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class PetController extends Controller
{
    #[OA\Get(path: '/api/pets', summary: 'Get all pets', tags: ['Pets'])]
    #[OA\Response(response: 200, description: 'List of pets')]
    public function index()
    {
        return Pet::all();
    }

    #[OA\Post(path: '/api/pets', summary: 'Create a pet', tags: ['Pets'])]
    #[OA\Response(response: 201, description: 'Pet created')]
    public function store(Request $request)
    {
        $pet = Pet::create([
            'name' => $request->name,
            'type' => $request->type,
            'age' => $request->age,
            'owner_name' => $request->owner_name,
        ]);

        return response()->json($pet, 201);
    }

    #[OA\Get(path: '/api/pets/{id}', summary: 'Get single pet', tags: ['Pets'])]
    #[OA\Parameter(name: 'id', in: 'path', required: true, description: 'Pet ID')]
    #[OA\Response(response: 200, description: 'Pet details')]
    public function show($id)
    {
        return Pet::findOrFail($id);
    }

    #[OA\Put(path: '/api/pets/{id}', summary: 'Update pet', tags: ['Pets'])]
    #[OA\Parameter(name: 'id', in: 'path', required: true, description: 'Pet ID')]
    #[OA\Response(response: 200, description: 'Pet updated')]
    public function update(Request $request, $id)
    {
        $pet = Pet::findOrFail($id);

        $pet->update([
            'name' => $request->name,
            'type' => $request->type,
            'age' => $request->age,
            'owner_name' => $request->owner_name,
        ]);

        return response()->json($pet);
    }

    #[OA\Delete(path: '/api/pets/{id}', summary: 'Delete pet', tags: ['Pets'])]
    #[OA\Parameter(name: 'id', in: 'path', required: true, description: 'Pet ID')]
    #[OA\Response(response: 200, description: 'Pet deleted')]
    public function destroy($id)
    {
        $pet = Pet::findOrFail($id);
        $pet->delete();

        return response()->json([
            'message' => 'Deleted successfully'
        ]);
    }
}