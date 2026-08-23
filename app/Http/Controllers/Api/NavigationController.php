<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\NavigationRequest;
use App\Models\Navigation;
use App\Services\NavigationService;
use Illuminate\Http\JsonResponse;

class NavigationController extends Controller
{
    public function __construct(
        private readonly NavigationService $navigationService,
    ) {}

    public function index(): JsonResponse
    {
        return response()->json(
            Navigation::query()->orderBy('order')->get()
        );
    }

    public function store(NavigationRequest $request): JsonResponse
    {
        $navigation = Navigation::create($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Navigation created successfully',
            'data' => $navigation,
        ], 201);
    }

    public function show(Navigation $navigation): JsonResponse
    {
        return response()->json($navigation);
    }

    public function update(NavigationRequest $request, Navigation $navigation): JsonResponse
    {
        $navigation->update($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Navigation updated successfully',
            'data' => $navigation,
        ]);
    }

    public function destroy(Navigation $navigation): JsonResponse
    {
        $navigation->delete();

        return response()->json(['message' => 'Navigation deleted successfully']);
    }

    public function active(): JsonResponse
    {
        return response()->json($this->navigationService->getActiveNavigations());
    }
}
