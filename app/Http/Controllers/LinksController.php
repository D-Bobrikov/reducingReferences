<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;

class LinksController extends Controller
{
    public function index()
    {
        $link = Link::orderby('id', 'desc')->paginate(10);

        return response()->json($link);
    }

    public function store(Request $request)
    {
        $lastLink = Link::orderby('id', 'desc')->first();

        if (!$lastLink) {
            Link::create(['full_reference' => $request->link, 'short_reference' => 'a']);

            return response('OK', 200);
        } else {
            $lastShortLink = $lastLink['short_reference'];
            Link::create(['full_reference' => $request->link, 'short_reference' => ++$lastShortLink]);

            return response('OK', 200);
        }
    }

    public function destroy($id)
    {
        Link::find($id)->delete();

        return response('DELETE', 200);
    }
}
