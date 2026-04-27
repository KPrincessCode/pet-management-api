<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class PetController extends Controller
{
    #[OA\Get(path: '/api/pets', summary: 'Get all pets', tags: ['Pets'])]
    #[OA\Response(response: 200, description: 'List of pets')]
    public function index(Request $request)
    {
        $query = Pet::query();

        if ($request->has('owner_name')) {
            $query->where('owner_name', $request->owner_name);
        }

        return response()->json($query->get());
    }

    #[OA\Post(path: '/api/pets', summary: 'Create a pet', tags: ['Pets'])]
    #[OA\Response(response: 201, description: 'Pet created')]
    public function store(Request $request)
{
    $pet = Pet::create([
        'name' => $request->name,
        'type' => $request->type,
        'age' => $request->age,
        'medicine_needed' => $request->medicine_needed,
        'injection_status' => $request->injection_status,
        'owner_name' => $request->owner_name,
    ]);

    return response()->json($pet, 201);
}

    #[OA\Get(path: '/api/pets/{id}', summary: 'Get single pet', tags: ['Pets'])]
    public function show($id)
    {
        return response()->json(Pet::findOrFail($id));
    }

    #[OA\Put(path: '/api/pets/{id}', summary: 'Update pet', tags: ['Pets'])]
    public function update(Request $request, $id)
{
    $pet = Pet::findOrFail($id);

    $pet->update([
        'name' => $request->name,
        'type' => $request->type,
        'age' => $request->age,
        'medicine_needed' => $request->medicine_needed,
        'injection_status' => $request->injection_status,
        'owner_name' => $request->owner_name,
    ]);

    return response()->json($pet);
}

    #[OA\Delete(path: '/api/pets/{id}', summary: 'Delete pet', tags: ['Pets'])]
    public function destroy($id)
    {
        $pet = Pet::findOrFail($id);
        $pet->delete();

        return response()->json([
            'message' => 'Deleted successfully'
        ]);
    }
}