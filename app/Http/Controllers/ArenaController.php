<?php
namespace App\Http\Controllers;

use App\Domains\Arenas\Services\ArenaService;
use Illuminate\Http\Request;
use Exception;

class ArenaController extends Controller {
    protected  $arenaService;

    public function __construct(ArenaService $arenaService) {
        $this->arenaService = $arenaService;
    }


    public function create(Request $request)
    {
        try {

            $data= $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'duration'    => 'required|integer|min:30|max:180',
            ]);

            $arena = $this->arenaService->createArena($data);

            return response()->json([
                'arena' => $arena,
                'message' => 'Arena created successfully',
            ], 201);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

}
