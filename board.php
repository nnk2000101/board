<!DOCTYPE html>
<html lang="ja">
    <head>
        <title>mission5-1</title>
        <meta charset="UTF-8">
    </head>
    <body>
        <?php
        
        $dsn = 'データベース名';
        $user = 'ユーザー名';
        $password = 'パスワード';
        $pdo = new PDO($dsn, $user, $password, 
        array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
        
        $sql = 'CREATE TABLE IF NOT EXISTS board'
        .'('
        .'id INT AUTO_INCREMENT PRIMARY KEY,'
        .'name char(32),'
        .'com TEXT'
        .');';
        $stmt = $pdo -> query($sql);

        $name = $_POST["name"];
        $com = $_POST["com"];
        $delnum = $_POST["delnum"];
        $date = date("Y/m/d H時i分s秒");
        $mypass = "urano";
        $editnum = $_POST["editnum"];
        $reeditnum = $_POST["reeditnum"];
        $inputpass = $_POST["inputpass"];
        $delpass = $_POST["delpass"];
        $editpass = $_POST["editpass"];
        
        if($name != "" && $com != ""){
            if($reeditnum == "" && $inputpass == $mypass){
                $sql = 'INSERT INTO board (name, com)
                VALUES (:name, :com)';
                $stmt = $pdo -> prepare($sql);
                $stmt -> bindParam(':name', $name,
                PDO::PARAM_STR);
                $stmt -> bindParam(':com', $com,
                PDO::PARAM_STR);
                $stmt -> execute();
            }
        }
        if($delnum != ''){
            if($delpass == $mypass){
                $id = $delnum;
                $sql = 'DELETE FROM board WHERE id=:id';
                $stmt = $pdo -> prepare($sql);
                $stmt -> bindParam(':id', $id, PDO::PARAM_INT);
                $stmt -> execute();
            }
        }
        
        if($editnum != ''){
            if($editpass == $mypass){
                $id = $editnum;
                $sql = 'SELECT * FROM board WHERE id=:id';
                $stmt = $pdo -> prepare($sql);
                $stmt -> bindParam(':id', $id, PDO::PARAM_INT);
                $stmt -> execute();
                foreach($stmt as $row){
                    $editname = $row['name'];
                    $editcom = $row['com'];
                }
            }
        }
        
        if($reeditnum != ''){
            $id = $reeditnum;
            $sql = 'UPDATE board SET name=:name, com=:com 
            WHERE id=:id';
            $stmt = $pdo -> prepare($sql);
            $stmt -> bindParam(':name', $name, PDO::PARAM_STR);
            $stmt -> bindParam(':com', $com, PDO::PARAM_STR);
            $stmt -> bindParam(':id', $id, PDO::PARAM_INT);
            $stmt -> execute();
        }
        ?>
        
        <form action="" method="post">
            お名前
            <input type="text" name="name" 
            value="<?php if(isset($editnum)){
            echo $editname;}?>">
            コメント
            <input type="text" name="com" 
            value="<?php if(isset($editnum)){
            echo $editcom;}?>">
            パスワード
            <input type="text" name="inputpass">
            <input type="submit" name="send" value="送信">
            <br>
            <br>
            削除番号
            <input type="text" name="delnum">
            パスワード
            <input type="text" name="delpass">
            <input type="submit" name="num" value="削除">
            <br>
            <br>
            編集番号
            <input type="text" name="editnum">
            パスワード
            <input type="text" name="editpass">
            <input type="submit" name="edit" value="編集">
            <input type="hidden" name="reeditnum"
            value="<?php if(isset($editnum)){
            echo $editnum;}?>">
            <br>
            <br>
        </form>
        
        <?php
        $sql = 'SELECT * FROM board';
        $stmt = $pdo -> query($sql);
        foreach($stmt as $row){
            echo $row['id'].','.$row['name'].','.$row['com'].
            '<br>';
        }
        ?>
    </body>
</html>