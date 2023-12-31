<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LinksController extends Controller
{
    public function index(): JsonResponse
    {
        $link = Link::orderby('id', 'desc')->paginate(10);

        return response()->json($link);
    }

    public function store(Request $request): JsonResponse
    {
        $lastLink = Link::orderby('id', 'desc')->first();

        if (! $lastLink) {
            $lastShortLink = 'a';
        } else {
            $lastShortLink = $lastLink['short_reference'];
            $lastShortLink++;
        }

        Link::create(['full_reference' => $request->link, 'short_reference' => $lastShortLink]);

        return response()->json(['message' => 'The link is shortened !']);
    }

    public function destroy($id): JsonResponse
    {
        Link::find($id)->delete();

        return response()->json(['message' => 'Link removed !']);
    }
}
