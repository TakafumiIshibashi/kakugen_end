<?php

// DB接続情報
$dbn = 'mysql:dbname=test;charset=utf8;port=3306;host=localhost';
$user = 'root';
$pwd = '';

// DB接続
try {
    $pdo = new PDO($dbn, $user, $pwd);
} catch (PDOException $e) {
    echo json_encode(["db error" => "{$e->getMessage()}"]);
    exit();
}
// 「dbError:...」が表示されたらdb接続でエラーが発生していることがわかる.

// 参照はSELECT文!
// $sql = 'SELECT * FROM word_table ORDER BY id ASC LIMIT 30'; 

// $sql = 'SELECT * FROM word_table WHERE date = "2021-07-05"'; 
$sql = 'SELECT * FROM word_table WHERE date = current_date()';
// $sql = 'SELECT * FROM word_table WHERE date = "date"'; 
// SELECT * FROM `word_table` WHERE date= "2021-07-05"

$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

$stmt->bindValue(':date', $day, PDO::PARAM_INT);
$day = new DateTime();
echo $day->format('Y-m-d');
// var_dump($day);
//   exit();

if ($status == false) {
    $error = $stmt->errorInfo();
    exit('sqlError:' . $error[2]);
    //   // 失敗時􏰂エラー出力

} else {
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $output = "";
    foreach ($result as $record) {
        $output1 .= "<td>{$record["word"]}</td>";
        $output2 .= "<td>{$record["name"]}</td>";
        $output3 .= "<td>{$record["trivia"]}</td>";
    }
}





$sql = 'SELECT * FROM sake_table WHERE date2 = current_date()';

$stmt = $pdo->prepare($sql);
$status = $stmt->execute();


if ($status == false) {
    $error = $stmt->errorInfo();
    exit('sqlError:' . $error[2]);
    //   // 失敗時􏰂エラー出力

} else {
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $output = "";
    foreach ($result as $record) {
        $output4 .= '<img src="sake_img/' . $record["gazo"] . '" width="150">';
        $output5 .= "<td>{$record["brand"]}</td>";
        $output6 .= "<td>{$record["description"]}</td>";
    }
}




?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <title>電子カレンダ７</title>
    <link rel="stylesheet" type="text/css" href="read.css">
    <style>
        /*ここにスタイルを記述*/

        body {
            -ms-writing-mode: tb-rl;
            writing-mode: vertical-rl;
            padding: 30px;
        }

        h1 {
            font-size: 30px;
            margin-left: 20px;
        }

        p {
            line-height: 1.7;
            margin-left: 20px;
        }

        body {
            width: 450px;
            margin: 25px auto 0;
        }

        .top {
            border-bottom: 2px solid gray;
        }

        .top,
        .day {
            display: flex;
            align-items: flex-end;
        }

        .day {
            justify-content: center;
        }

        .mm {
            width: 50px;
            font-size: 40px;
            font-weight: bold;
        }

        .eng_m {
            font-size: 25px;
            font-weight: bold;
            color: blue;
        }

        .YYYY {
            width: 200px;
            text-align: right;
            font-size: 25px;
        }

        .week {
            margin-top: 16px;
            text-align: center;
            font-size: 25px;
        }

        .dd {
            font-size: 50px;
        }

        .nichi {
            font-size: 50px;
        }

        .week,
        .day {
            <?php
            if (date("w") == 0) {
                echo "color: red;";
            }
            if (date("w") == 6) {
                echo "color: blue;";
            }
            ?>
        }
    </style>
</head>

<body>


    <!-- 雨降らせる -->
    <div class="container">
        <img src="img/mon.jpeg" border="0" />
        <div class="rains">

            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>

            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>

            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>

            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
    <!-- 雨降らせる -->




    <div class="top">
        <div class="mm"><?php echo date("m"); ?></div>
        <div class="eng_m"><?php echo date("M"); ?></div>
        <div class="YYYY"><?php echo date("Y"); ?></div>
    </div>
    <?php $week = array("日", "月", "火", "水", "木", "金", "土"); ?>
    <div class="week"><?php echo $week[date("w")]; ?>曜日</div>
    <div class="day">
        <div class="dd"><?php echo date("j"); ?></div>
        <div class="nichi">日</div>
    </div>



    <h1><?= $output1 ?></h1>
    <h2> <?= $output2 ?></h2>
    <?= $output3 ?>


    <?= $output4 ?>
    <h2><?= $output5 ?></h2>
    <?= $output6 ?>
    <script>
        const hoge = <?= json_encode($result) ?>;
        console.log(hoge);
        const hoge2 = <?= json_encode($day) ?>;
        console.log(hoge2);
    </script>



    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>




    <!-- ここから記述 -->

    <header>


    </header>

    <div class="main_title2">


        <section class="top_link">
            <div>
                <p id="title"></p>

                <ul>
                    <li id="date"></li>
                    <li id="rain0"></li>
                    <li id="rain1"></li>
                    <li id="rain2"></li>
                    <li id="rain3"></li>
                    <li id="rain4"></li>
                    <li id="rain5"></li>
                </ul>
            </div>

            <div class="icon_tag">
                <a href="https://www.facebook.com/"><span class="fab fa-facebook blue fa-5x fa-fw"></span></a>
                <a href="https://twitter.com/"><span class="fab fa-twitter-square aqua fa-5x fa-fw"></span></a>
                <a href="https://www.instagram.com/"><span class="fab fa-instagram crimson fa-5x fa-fw"></span></a>
                <a href="https://line.me/ja/"><span class="fab fa-line green fa-5x fa-fw"></span></a>
                <a href="https://www.amazon.co.jp/"><span class="fas fa-shopping-cart fa-5x fa-fw"></span></a>
            </div>

        </section>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <!-- axiosライブラリの読み込み -->
        <script src="https://unpkg.com/axios/dist/axios.min.js"></script>

        <script src="https://www.bing.com/api/maps/mapcontrol?key=" async defer></script>
        <script src="https://www.bing.com/api/maps/mapcontrol?mkt=ja-jp&key=AjlN_yLDV3Zl1lH4GgUgG8badzcZdxiFVFSCtdLFgy8zkHdorTfXtD67uxw-diut"></script>

        <script>
            // map表示用に使用する変数
            let map;

            // yahoo気象情報APIへリクエストする関数を定義
            function weather(lat, lng) {
                // yahoo気象情報APIにリクエストを送るurlを準備
                const url = "https://map.yahooapis.jp/weather/V1/place";
                const appid =
                    "dj00aiZpPUVTa1RLbkNkeGZxMiZzPWNvbnN1bWVyc2VjcmV0Jng9YjM-";
                //リクエストの順番注意！！！経度(lng),緯度(lat) データの渡し方は下の２行のどちらでもOK
                // const coord = `${lng},${lat}`;
                const coord = [138.53111, 34.984702];
                console.log(coord);

                axios
                    .get(
                        "https://map.yahooapis.jp/weather/V1/place?coordinates=" +
                        coord +
                        "&output=jsonp&appid=" +
                        appid
                    )
                    .then(function(response) {
                        console.log(response);
                        console.log(response.data.Feature[0].Property.WeatherList.Weather);
                        console.log(response.data.Feature[0].Name);
                        const name = response.data.Feature[0].Name;
                        const data = [];
                        response.data.Feature[0].Property.WeatherList.Weather.forEach(
                            function(x) {
                                data.push(x.Rainfall);
                            }
                        );
                        $("ul").fadeIn();
                        $("#title").html(`現在地の10分毎の降水確率`);
                        $("#date").html(`　現在の降水量 　：${data[0]}mm/h`);
                        $("#rain0").html(`10分後の降水確率：${data[1]}mm/h`);
                        $("#rain1").html(`20分後の降水確率：${data[2]}mm/h`);
                        $("#rain2").html(`30分後の降水確率：${data[3]}mm/h`);
                        $("#rain3").html(`40分後の降水確率：${data[4]}mm/h`);
                        $("#rain4").html(`50分後の降水確率：${data[5]}mm/h`);
                        $("#rain5").html(`60分後の降水確率：${data[6]}mm/h`);
                        // const w = data[0];
                        // console.log(w);
                        // if (data[0] = 0);
                        // alert('ok');


                    })
                    .catch(function(error) {
                        // リクエスト失敗時の処理(errorにエラー内容が入っている)
                        console.log(error);
                    })
                    .finally(function() {
                        // 成功失敗に関わらず必ず実行
                        console.log("done!");
                    });
            }

            // ピンを作成する関数を定義
            function pushPin(lat, lng, map) {
                const location = new Microsoft.Maps.Location(lat, lng);
                const pin = new Microsoft.Maps.Pushpin(location, {
                    color: "red", // 色の設定
                    visible: true, // これ書かないとピンが見えない
                });
                map.entities.push(pin);
            }



            // 現在地を取得するときのオプション
            const option = {
                enableHighAccuracy: true,
                maximumAge: 20000,
                timeout: 1000000,
            };

            // 現在地の取得に成功したときの関数
            function mapsInit(position) {
                // console.log(position);
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;
                console.log(lat);
                console.log(lng);


                // yahoo気象情報APIへリクエストする関数を実行
                weather(lat, lng);
            }

            // 現在位置の取得に失敗したときの関数
            function showError(error) {
                let e = "";
                if (error.code == 1) {
                    e = "位置情報が許可されてません";
                } else if (error.code == 2) {
                    e = "現在位置を特定できません";
                } else if (error.code == 3) {
                    e = "位置情報を取得する前にタイムアウトになりました";
                }
                alert("error:" + e);
            }

            function getPosition() {
                navigator.geolocation.getCurrentPosition(mapsInit, showError, option);
            }

            // 地図を表示する処理
            window.onload = function() {
                getPosition();
            };
        </script>


        <script>
            // if (data[0] = 0);
            // alert('ok');
        </script>




</body>

</html>