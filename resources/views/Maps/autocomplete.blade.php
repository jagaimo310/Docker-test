<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>オートコンプリート</title>
</head>

<body>
    <!-- オートコンプリート機能をつける対象を記述 -->
    <input type="text" id="place" placeholder="場所を入力">

    <script>
        (g => {
            var h, a, k, p = "The Google Maps JavaScript API",
                c = "google",
                l = "importLibrary",
                q = "__ib__",
                m = document,
                b = window;
            b = b[c] || (b[c] = {});
            var d = b.maps || (b.maps = {}),
                r = new Set,
                e = new URLSearchParams,
                u = () => h || (h = new Promise(async (f, n) => {
                    await (a = m.createElement("script"));
                    e.set("libraries", [...r] + "");
                    for (k in g) e.set(k.replace(/[A-Z]/g, t => "_" + t[0].toLowerCase()), g[k]);
                    e.set("callback", c + ".maps." + q);
                    a.src = `https://maps.${c}apis.com/maps/api/js?` + e;
                    d[q] = f;
                    a.onerror = () => h = n(Error(p + " could not load."));
                    a.nonce = m.querySelector("script[nonce]")?.nonce || "";
                    m.head.append(a)
                }));
            d[l] ? console.warn(p + " only loads once. Ignoring:", g) : d[l] = (f, ...n) => r.add(f) && u().then(() => d[l](f, ...n))
        })({
            key: "{{ config('services.googlemap.api') }}",
            v: "weekly",
        });
    </script>
    <script>
        async function initMap() {
            //placesライブラリをロード
            const {
                Autocomplete
            } = await google.maps.importLibrary("places");
            let place = document.getElementById("place"); //オートコンプリートをつける、inputタグを指定
            //検索制限を記述
            const options = {
                //観光地
                types: defaultBounds,
                componentRestrictions: {
                    country: "ja"
                },
                fields: ["geometry", "name"],
            };
            //インスタンス作成時に制限条件を加える
            let autocomplete = new Autocomplete(place, options); //オートコンプリート機能を持ったインスタンス作成
            autocomplete.addListener('place_changed', function() {
                const placeInfo = autocomplete.getPlace();
                if (placeInfo.geometry) {
                    //今回は指定したinputタグに場所の名前を入れる
                    console.log(placeInfo);
                    document.getElementById('place').value = placeInfo.name;
                } else {
                    alert("場所が見つかりませんでした。");
                }
            });
        }
        initMap();
    </script>
</body>

</html>