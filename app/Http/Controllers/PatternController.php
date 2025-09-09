<?php

namespace App\Http\Controllers;

use App\Models\Pattern;
use App\Models\Setting;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class PatternController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return response()->json(Pattern::all()->toArray());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'icon' => ['nullable', 'string', 'max:255'],
            'block' => ['required', 'array'],
        ]);
        $save = Pattern::create($validated);
        if ($save) {
            return back()->with('save', __('Pattern added successfully.'));
        } else {
            return back()->withErrors(['save', __('Save failed!')]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Pattern $pattern): JsonResponse
    {
        return response()->json($pattern->toArray());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pattern $pattern)
    {
        $delete = $pattern->delete();
        if ($delete) {
            return back()->with('delete', __('Pattern deleted successfully.'));
        } else {
            return back()->withErrors(['delete', __('Delete failed!')]);
        }
    }
}
