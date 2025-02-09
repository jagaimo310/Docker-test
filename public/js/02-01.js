// idがsampleであるElementを取得してbtnという変数に格納する
const btn = document.getElementById("sample");

// ブラウザで表示されたDOMの中から、sampleというIDの要素(エレメント)オブジェクトに対して、
// clickした時にイベントを設定する
btn.addEventListener("click", function () {
    // confirm関数は、「OK」ボタンが押されるとtrueを、「キャンセル」ボタンが押されるとfalseを返す
    if (confirm("CLICKが押されました")) {
        alert("OKが選ばれました"); //OKが押された場合の処理
    } else {
        alert("キャンセルが選ばれました"); //キャンセルが押された場合の処理
    }
});
