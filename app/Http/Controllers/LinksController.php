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
        $alphabet = 'abcdefghijklmnopqrstuvwxyz';
        $lastLink = Link::orderby('id', 'desc')->first();

        if (!$lastLink) {
            Link::create(['full_reference' => $request->link, 'short_reference' => 'a']);

            return response('OK', 200);
        }

        $posAlphabet = strripos($alphabet, substr($lastLink->short_reference, -1));
        $currentPosition = strripos($alphabet, $alphabet[$posAlphabet]);

        if ((strlen($lastLink->short_reference) === 1) && ($currentPosition < 25)) {
            $shortReference = $alphabet[$currentPosition + 1];
            Link::create(['full_reference' => $request->link, 'short_reference' => $shortReference]);

            return response('OK', 200);
        }

        elseif ((strlen($lastLink->short_reference) === 1) && ($currentPosition === 25 )) {
            Link::create(['full_reference' => $request->link, 'short_reference' => 'aa']);

            return response('OK', 200);
        }

        elseif (((strlen($lastLink->short_reference) > 1) && ($currentPosition < 25 ))) {
            $shortReference = $alphabet[$currentPosition + 1];
            $shortReference = substr($lastLink->short_reference, 0, -1) . $shortReference;
            Link::create(['full_reference' => $request->link, 'short_reference' => $shortReference]);

            return response('OK', 200);
        }

        elseif (((strlen($lastLink->short_reference) > 1) && ($currentPosition === 25 ))) {
            Link::create(['full_reference' => $request->link, 'short_reference' => $lastLink->short_reference . 'a']);

            return response('OK', 200);
        }
    }

    public function destroy($id)
    {
        Link::find($id)->delete();

        return response('DELETE', 200);
    }
}
