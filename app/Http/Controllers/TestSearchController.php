<?php

namespace App\Http\Controllers;

use App\Test_search;
use Illuminate\Http\Request;
use TeamTNT\TNTSearch\TNTSearch;

class TestSearchController extends Controller
{
    public function home()
    {
        return view('TestSearch/TestSearch');

    }
    public function show()
    {
        return Test_search::get();

    }
    public function search(Request $request)
    {
        $key = $request->search;
        $kq = Test_search::search($key)->get();

        $tnt = new TNTSearch;
        $kq = $kq->map(function ($article) use ($key, $tnt) {
            $article->name = $tnt->highlight($article->name, $key, 'b');
            $article->age = $tnt->highlight($article->age, $key, 'b');
            $article->school = $tnt->highlight($article->school, $key, 'b');
            return $article;
        });
        $kq_count = $kq->count();

        return response([
            'kq' => $kq,
            'kq_count' => $kq_count,
        ]);

    }
}
