<?php

namespace App\Http\Controllers;

use App\Http\Resources\UrlCollection;
use App\Models\Url;
use App\Services\UrlService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UrlController extends Controller
{
    /**
     * Return and paginate all urls
     */
    public function showAll()
    {
        return response()->json(new UrlCollection(Url::paginate()));
    }

    /**
     * Return the long_url associated with the alias
     *
     * @param Request $request
     * @param UrlService $urlService
     */
    public function decode(Request $request, UrlService $urlService)
    {
        $shortUrl = $request->get('short_url');
        try {
            $url = $urlService->findUrlFromShortUrl($shortUrl);
            return response()->json(['url' => $url->url]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Url does not exist'], 404);
        }
    }

    /**
     * Redirect user from short url to long url
     *
     * @param UrlService $urlService
     * @param $alias
     */
    public function redirect(UrlService $urlService, $alias)
    {
        try {
            $url = $urlService->findUrlFromShortUrl($alias);
            return redirect($url->url);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Url does not exist'], 404);
        }
    }

    /**
     * Create a short url
     *
     * @param Request $request
     * @param UrlService $urlService
     */
    public function encode(Request $request, UrlService $urlService)
    {
        $validator = Validator::make($request->all(), [
            'url' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        try {
            $url = $urlService->createUrl($request->get('url'));
            return response()->json(['short_url' => $url->short_url]);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }
}
