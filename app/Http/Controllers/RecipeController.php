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

    public function nutrient()
    {
        return view('recipes.nutrient');
    }

    //食品番号検索
    public function nutrientSerch(Request $request)
    {
        //受け取った食材名を$foodにいれる
        $food = $request['nutrient'];

        //注意!!　72行目から79行目まではデータベースを登録していないため、動作確認できていません。参考程度にしてください。
        //ingredientsテーブルに同じ名前の食べ物が含まれていればそのデータを取得する
        // $registeredFood = Ingrediet::where('name', $food)->get();

        // //同じ食材が登録されないようにする
        // if ($food == $registeredFood) {
        //     //ddは処理を書かれた時点で止めて、データ等を確かめるデバック用の関数
        //     //ここは本番では処理を書き換えること
        //     return dd("既に登録済みです");
        // }

        //75行目から77行目まででAPIを呼び出している　ここでは食材の食品番号を検索している
        //$responseにはAPIの結果が入る
        $response = Http::get('https://script.google.com/macros/s/AKfycbzO6IMoPPbtBLb_AnRwgB1OheJyF5XwgNyj28NZdyjg76q4AzX0/exec', [
            //食材名をエンドポイントに含める
            'name' => $food
        ]);

        //APIの検索が失敗した場合
        if (empty($response->json()[0])) {
            //ここは本番では処理を書き換えること
            return dd("食材が見つかりませんでした");
        }

        //APIで呼び出した結果の中から、一番最初にヒットしたものを取り出す
        $result = $response->json()[0];

        //$foodの中から食品番号だけを取り出す　
        //preg_replace()は文字列を置換するためのPHPの関数　(int)で$foodNumber確実に数字として処理されるように定義
        $foodNumber = (int)preg_replace('/\D/', '', $result);

        //これまでの処理で得られた$foodNumber（食品番号）とユーザーが入力した食品名である$foodを引数に
        //食品の栄養素を調べるためにnutrientValue関数を呼び出す
        return $this->nutrientValue($foodNumber, $food);
    }

    //食材検索
    public function nutrientValue($foodNumber, $food)
    {
        //API呼び出し
        $response = Http::get('https://script.google.com/macros/s/AKfycbx7WZ-wdIBLqVnCxPwzedIdjhC3CMjhAcV0MufN2gJd-xsO3xw/exec', [
            //引数として渡された$foodNumber（食品番号）と重量（weight）をエンドポイントに追加
            'num' => $foodNumber,
            'weight' => 100
        ]);

        //APIの検索が失敗した場合
        if (empty($response->json())) {
            //ここは本番では処理を書き換えること
            return dd("食材が見つかりませんでした");
        }

        //結果を$nutrientsに取り出してから各栄養素を変数に代入
        $nutrients = $response->json();
        //保存処理をsaveIngredient関数で行う
        return $this->saveIngredient($nutrients, $food);
    }


    //データ保存処理
    public function saveIngredient($nutrients, $food)
    {
        $protein = $nutrients['たんぱく質'];
        $fat = $nutrients['脂質'];
        $carbohydrate = $nutrients['炭水化物'];

        //注意!!　以下の記述はデータベースを作成していないので動作確認ができていません　参考程度にしてください
        //上でuse宣言したうえで新しくingredientsテーブルのデータを作成する
        // $ingredient = new Ingredient();
        // //各カラムに値を入れる
        // $ingredient->name = $food;
        // $ingredient->protein = $protein;
        // $ingredient->fat = $fat;
        // $ingredient->carbohydrate = $carbohydrate;
        // //$ingredientsをテーブルに保存
        // $ingredient->save();

        //ここは本番では処理を書き換えること
        return dd("食材を保存しました", $protein, $fat, $carbohydrate);
    }
}
