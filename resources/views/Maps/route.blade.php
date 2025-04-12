<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>ルート検索</title>
</head>

<body>
    <div id="mapArea" style="
    width: 80%; 
    height: 400px; 
    margin: 20px auto;"></div>
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
            //ルート表示用にマップを表示
            //ルート表示用にインポート
            const {
                Map,
                LatLng,
                MapTypeId
            } = await google.maps.importLibrary('maps');
            let map = new google.maps.Map(document.getElementById("mapArea"), {
                zoom: 5,
                center: new google.maps.LatLng(36, 138),
                mapTypeId: google.maps.MapTypeId.ROADMAP
            });


            //マップ検索用にインスタンス作成
            let directionsService = new google.maps.DirectionsService();
            //ルート描画用にインスタンスを作成
            let directionsRenderer = new google.maps.DirectionsRenderer();
            //ルートを描画するマップをセット
            directionsRenderer.setMap(map);

            //リクエストの出発点の位置（東京駅の緯度経度）
            let start = new google.maps.LatLng(35.6812996, 139.7670658);

            //リクエストの終着点の位置（東京タワーの緯度経度）
            let end = new google.maps.LatLng(35.6585805, 139.7454329);

            // ルートを取得するリクエスト
            let request = {
                origin: start, // 出発地点の緯度経度
                destination: end, // 到着地点の緯度経度
                travelMode: "WALKING" //"WALKING"で歩き、"DRIVING"で車でのルートの検索となる
            };

            //DirectionsServiceでの検索
            directionsService.route(request, function(result, status) {
                //ステータスがOKの場合、
                if (status === 'OK') {
                    //取得したルート（結果：result）をセット
                    directionsRenderer.setDirections(result);
                    //ルート情報を定義し表示
                    console.log(result);
                    const route = result.routes[0];
                    console.log(route);
                }
            });
        }
        initMap();
    </script>
</body>

</html>