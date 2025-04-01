<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RecipeController extends Controller
{
    //
    public function recipe()
    {
        $results = 0;
        return view('recipes.recipe')->with(['results' => $results]);;
    }

    public function recipeCategory(Request $request)
    {
        $serch = $request['category'];
        $response = Http::get('https://app.rakuten.co.jp/services/api/Recipe/CategoryList/20170426', [
            'applicationId' => config('services.rakuten.api')
        ]);

        // ステータスコード確認
        if ($response->successful()) {
            $results = $response->json();
            foreach ($results as $smallResults) {
                foreach ($smallResults as $results) {
                    foreach ($results as $result) {
                        $categoryName = $result['categoryName'];
                        $categoryId = $result['categoryId'];
                        if ($categoryName == $serch) {
                            return $this->serchRecipe($categoryId);
                        }
                    }
                }
            }
        } else {
            dd($response->body());
        }
    }

    public function serchRecipe($categoryId)
    {
        $response = Http::get('https://app.rakuten.co.jp/services/api/Recipe/CategoryRanking/20170426', [
            'applicationId' => config('services.rakuten.api'),
            'categoryId' => $categoryId
        ]);

        if ($response->successful()) {
            $results = $response->json()["result"];
            //dd($results);
            return view('recipes.recipe')->with(['results' => $results]);
        } else {
            dd($response->body());
        }
    }
}
