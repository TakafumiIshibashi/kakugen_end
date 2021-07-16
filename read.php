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

// $sql = 'SELECT * FROM word_table WHERE date = "2021-07-05"'; 
$sql = 'SELECT * FROM word_table WHERE date = current_date()';

$stmt = $pdo->prepare($sql);
$status = $stmt->execute();
date_default_timezone_set('Asia/Tokyo');
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
    $output4 .= '<img src="sake_img/' . $record["gazo"] . '" width="150px">';
    $output5 .= "<td>{$record["brand"]}</td>";
    $output6 .= "<td>{$record["description"]}</td>";
  }
}


$sql = 'SELECT * FROM word_table  INNER JOIN sake_table ON word_table.id = sake_table.id';

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
    $output7 .= "<td><a href='read2.php?date={$record["date"]}&id={$record["id"]}'>{$record["date"]}</a></td>";
    // $output7 .= "<td>{$record["date"]}</td>";
    // $output8 .= "<td>{$record["date2"]}</td>";
  }
}



// $output2 .= "<td><a href='themaphoto_upform.php?thema_id={$record["thema_id"]}'><img src={$record["thema_icon"]} height ='150px' ></td>";


?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="IE=Edge">
  <meta name="viewport" content="width=device-width, user-scalable=no">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
  <title>格言</title>
  <link rel="stylesheet" type="text/css" href="read.css">
  <style>
    /*ここにスタイルを記述*/

    /* 縦書き */
    /* body {
      -ms-writing-mode: tb-rl;
      writing-mode: vertical-rl;
      padding: 30px;
    } */

    a {
      color: black;
    }

    header a {
      color: white;
    }

    .contents a {
      color: black;
    }

    .leftmenu a {
      color: gray;
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
      width: 1060px;
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
      color: white;
    }

    .mm {
      width: 150px;
      font-size: 50px;
      color: white;
    }

    /* .eng_m {
      font-size: 25px;
      font-weight: bold;
      color: blue;
    } */

    .YYYY {
      width: 380px;
      text-align: center;
      margin-left: 20px;
      font-size: 50px;
      color: white;
    }

    .week {
      margin-top: 16px;
      text-align: center;
      font-size: 50px;
      color: white;
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


  <div class="top">
    <div class="YYYY"><?php echo date("Y"); ?>年</div>
    <div class="mm"><?php echo date("n"); ?>月</div>
    <!-- <div class="eng_m"><?php echo date("M"); ?></div> -->

    <div class="day">
      <div class="dd"><?php echo date("j"); ?></div>
      <div class="nichi">日</div>
      <?php $week = array("日", "月", "火", "水", "木", "金", "土"); ?>
      <div class="week">　　<?php echo $week[date("w")]; ?>曜日</div>
    </div>
  </div>
  <div class="kakugen_sake">
    <div>
      <div class="kakugen_main">
        <h1>『<?= $output1 ?>』</h1>
      </div>
      <div class="kakugen_name">
        <h2> <?= $output2 ?></h2>
      </div>
      <div class="kakugen_occupation">
        <?= $output3 ?>
      </div>
    </div>

    <div class="sakebox">
      <div class="sakegazo">
        <?= $output4 ?>
      </div>
      <div class="saketxte">
        <h1><?= $output5 ?></h1>
      </div>
      <div class="sakedescription">
        <?= $output6 ?>
      </div>
    </div>
  </div>

  <div class="container">
    <img src="img/barcounter.jpg" width="1060px">
  </div>
  <div class="chirami">
    <p> <?= $output7 ?></p>
  </div>
  <script>
    const hoge = <?= json_encode($result) ?>;
    console.log(hoge);
    const hoge2 = <?= json_encode($day) ?>;
    console.log(hoge2);
  </script>



</body>

</html>