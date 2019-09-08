<html>
	<head>
		<meta charset = "utf-8">
	</head>
<body>

<?php

//接続開始

	$dsn = 'mysql:dbname=******;host=******';
	$user = '******';
	$password = '******';
	$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

//接続終わり

//テーブル作成開始

	$sql = "CREATE TABLE IF NOT EXISTS tbk"
	." ("
	. "id INT AUTO_INCREMENT PRIMARY KEY,"
	. "name char(32),"
	. "comment TEXT,"
	. "date datetime,"
	. "password char(32)"
	.");";
	$stmt = $pdo->query($sql);

//テーブル作成終わり
  	
//編集選択機能開始

	if(isset($_POST['btn3'])){		
	
		$sql = 'SELECT * FROM tbk';
		$stmt = $pdo->query($sql);
		$results = $stmt->fetchAll();
		$edit = $_POST['edit'];
		foreach ($results as $row){		
		if($row['id'] == $edit){
		$ediNum = $row['id'];
		$ediName = $row['name'];
		$ediComment = $row['comment'];
		}
		}
	}		
//編集選択機能終了

//編集機能開始
	if ((isset($_POST['btn'])) &&(isset($_POST['editNumber'])) && (isset($_POST['ediPass']))){ 		//編集モードかどうかの分岐
		$id = $_POST['editNumber'];
		$name = $_POST['namae'];
		$comment = $_POST['comment']; 
		$password =$_POST['ediPass'];
		$date=date('Y-m-d H:i:s');
			$sql = 'update tbk set name=:name,comment=:comment,date=:date where id=:id and password=:password';
			$stmt = $pdo->prepare($sql);
			$stmt->bindParam(':id', $id, PDO::PARAM_INT);
			$stmt->bindParam(':name', $name, PDO::PARAM_STR);
			$stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
			$stmt->bindParam(':date', $date, PDO::PARAM_STR);
			$stmt->bindParam(':password', $password, PDO::PARAM_STR);
			$stmt -> execute();
		
//編集機能終了

	//投稿機能開始
	
	}elseif(isset($_POST['btn'])){
		
	$sql = $pdo -> prepare("INSERT INTO tbk (name, comment, date, password) VALUES (:name, :comment, :date, :password)");
    $sql -> bindParam(':name', $name, PDO::PARAM_STR);
    $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
    $sql -> bindParam(':date', $date, PDO::PARAM_STR);
    $sql -> bindParam(':password', $password, PDO::PARAM_STR);
    $name=$_POST['namae'];
    $comment=$_POST['comment'];
    $date=date('Y-m-d H:i:s');
    $password=$_POST['password'];
    $sql -> execute();

//投稿機能終わり

//削除機能始まり
			
	}elseif (isset($_POST['btn2'])){
	$id = $_POST['delete'];
	$password = $_POST['delPass'];
	$sql = 'delete from tbk where id=:id
	and password=:password'; 
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':id', $id, PDO::PARAM_INT);
	$stmt->bindParam(':password', $password, PDO::PARAM_STR);
	$stmt->execute();
	}
	
//削除機能終わり
?>

<form method = "POST" action = "mission_5-1.php">
<?php
	if (isset($_POST['btn3'])){
	echo "編集番号： <input type = 'text' name = 'editNumber' value = '".$ediNum."'>"; 
	echo "<br />";
	echo "名前：         <input type = 'text' name = 'namae' value= '".$ediName."'>";
	echo "<br />";
	echo "コメント：   <input type = 'text' name = 'comment' value = '".$ediComment."'>"."<br />";
	echo "パスワード： <input type ='text' name ='ediPass' placeholder = 'パスワード'>"."<br />";
	}else{
		echo "名前：         <input type = 'text' name = 'namae' placeholder= '名前'>"."<br />";
		echo "コメント：   <input type = 'text' name = 'comment' placeholder = 'コメント'>"."<br />";
		echo "パスワード：　<input type ='text' name ='password' placeholder = 'パスワード'>";
	}
	?>
	<input type = "submit" name = "btn" value = "送信"><br>
</form>

<form method = "POST" action ="mission_5-1.php">
	<input type = "text" name = "delete" placeholder = "削除番号"><br>
	<input type = "text" name ="delPass" placeholder ="パスワード">
	<input type = "submit" name = "btn2" placeholder = "削除"><br>
</form>

<form method = "POST" action = "mission_5-1.php">
	<input type = "text" name = "edit" placeholder = "編集対象番号">
	<input type = "submit" name = "btn3" placeholder = "編集"><hr>
</form>

<?php
//表示
$sql = 'SELECT * FROM tbk';
$results = $pdo -> query($sql);
foreach ($results as $row) {
    echo $row['id'].',';
    echo $row['name'].',';
    echo $row['comment'].',';
    echo $row['date'].'<br>';
}
?>

	</body>
	</html>