<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UploadController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $uploadedFile = $request->file('file');

        $path = $uploadedFile->store('public');

        return response()->json([
            'id' => Str::of($path)->afterLast('/'),
            'name' => Str::of($path)->afterLast('/'),
            'url' => config('app.url') . Storage::url($path),
        ], 200);
    }
}
