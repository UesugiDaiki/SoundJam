-- 既に存在しているなら削除
drop database if exists test_db;
-- 新しくDBを作成
create database test_db default character set utf8 collate utf8_general_ci;
-- test_dbの操作の全権限を与えた状態でユーザーを作成
grant all on test_db.* to 'test_user'@'localhost' identified by 'secret';
-- データベースに接続（下のテーブル作成のコマンドを実行するため）
use test_db;

/*備考
    ・外部キーの投稿IDを主キーしていたので、
    機材テーブルの主キーを設定し、
    投稿IDは外部キーのみとして設定

    ・PROFILEが予約語で使用できなかった為、
    PROFILESに変更

    ・PASSWORDが予約語で使用できなかった為、
    PASSWORDSに変更
*/
-- insert into user_table values(null, 'test', 'テストですよ！！', 'https://mamimumemo','text/icon', 'test@gmail.com', 'test000', true, true, false)
-- -- ユーザーテーブル
create table user_table (
    -- 主キー
    id int auto_increment primary key,
    -- ユーザ名
    USER_NAME varchar(200) not null,
    -- プロフィール
    PROFILES varchar(200),
    -- 自前ウェブサイトのURL格納
    WEBSITE varchar(200),
    -- アイコン
    ICON varchar(200) not null,
    -- メールアドレス
    EMAIL_ADDRESS varchar(200) not null,
    -- パスワード
    PASSWORDS varchar(200) not null,
    -- フォロー通知ON/OF
    FOLLOW_NOTICE BOOLEAN not null,
    -- いいね通知ON/OFF
    LIKE_NOTICE BOOLEAN not null,
    -- 凍結フラグ
    FROZEN BOOLEAN not null
);

/*備考
    個人的に仮登録の必要性に疑問あり？
*/
-- 製品テーブル
create table product_table (
    -- 主キー
    id int auto_increment primary key,
    -- 製品名
    name varchar(200) not null,
    -- 画像
    image varchar(200) not null,
    -- 概要
    overview varchar(200) not null,
    -- 仮登録
    temp_regist BOOLEAN not null
);

/*　備考
    ・製品IDはNNをつけなくてよいのか？
    ・LIKEが予約ごで名前に設定出来なかった為、LIKESに変更した。
    ・DATEが予約ごで名前に設定出来なかった為、DATESに変更した。
*/
-- 投稿テーブル
create table post_table (
    -- 主キー
    id int auto_increment primary key,
    -- ユーザーID（外部キー）
    USER_ID int not null,
    -- 製品ID（外部キー）
    PRODUCT_ID int null,
    -- 題名
    TITLE varchar(200),
    -- 概要
    OVERVIEW varchar(200),
    -- 録音方法
    RECORDING_METHOD varchar(200),
    -- 日付
    DATES DATETIME not null,
    -- いいね数
    LIKES int not null,
    -- 音声1
    AUDIO1 varchar(200),
    -- 音声2
    AUDIO2 varchar(200),
    -- 画像
    IMAGES varchar(200),
    -- 投稿種別
    POST_TYPE BOOLEAN not null,


    -- 外部キー制約
    -- ユーザーID
    FOREIGN KEY (USER_ID) REFERENCES user_table(id) ON DELETE CASCADE,

    -- 製品ID
    FOREIGN KEY (PRODUCT_ID) REFERENCES product_table(id) ON DELETE CASCADE
);

-- 連結投稿テーブル
create table connected_post_table (
    -- 主キー
    id int auto_increment primary key,
    -- 連結元ID（連携元の投稿IDが保存される）
    SOURCE_POST_ID int null,
    -- 題名
    TITLE varchar(200),
    -- 概要
    OVERVIEW varchar(200),
    -- 音声1
    AUDIO1 varchar(200),
    -- 画像
    IMAGES varchar(200),

    -- 外部キー制約
    -- 連結元ID
    FOREIGN KEY (SOURCE_POST_ID) REFERENCES post_table(id) ON DELETE CASCADE
);

/*備考
    ・外部キーの投稿IDを主キーしていたので、
    機材テーブルの主キーを設定し、
    投稿IDは外部キーのみとして設定

    ・NUMBERが予約語で使用できなかった為、
    NUMBERSに変更
*/
-- 機材テーブル
create table equip_table (
    -- 主キー
    id int auto_increment primary key,
    -- 投稿ID（外部キー）
    POST_ID int not null,
    -- 品目
    NUMBERS int not null,
    -- 使用機材名
    EQUIP_NAME varchar(200) not null,

    -- 投稿ID
    FOREIGN KEY (POST_ID) REFERENCES post_table(id) ON DELETE CASCADE
);


-- フォローテーブル
create table follow_table (
    -- 主キー
    id int auto_increment primary key,
    -- フォロワーID（外部キー）（フォローしている人）
    FOLLOWER_ID int not null,
    -- フォロウィーID（外部キー）（フォローされている人）
    FOLLOWEE_ID int not null,

    -- フォロワーID（フォローしている人）
    FOREIGN KEY (FOLLOWER_ID) REFERENCES user_table(id) ON DELETE CASCADE,

    -- フォロウィーID（フォローされている人）
    FOREIGN KEY (FOLLOWEE_ID) REFERENCES user_table(id) ON DELETE CASCADE
);

-- いいねテーブル
create table nice_table (
    -- 主キー
    id int auto_increment primary key,
    -- ライカ―ID（いいねしている人のID）
    LIKER_ID int not null,
    -- 投稿ID（いいねされている投稿のID）
    POST_ID int not null,

    -- ライカーID
    FOREIGN KEY (LIKER_ID) REFERENCES user_table(id) ON DELETE CASCADE,

    -- 投稿ID
    FOREIGN KEY (POST_ID) REFERENCES post_table(id) ON DELETE CASCADE
);

-- 投稿通知テーブル
create table postNotice_table (
    -- 主キー
    id int auto_increment primary key,
    -- ONしている（外部キー）
    is_on int not null,
    -- ONされている（外部キー）
    is_truned_on int not null,

    -- 外部キー
    -- ONしている
    FOREIGN KEY (is_on) REFERENCES user_table(id) ON DELETE CASCADE,

    -- ONされている
    FOREIGN KEY (is_truned_on) REFERENCES user_table(id) ON DELETE CASCADE

);

-- お問い合わせテーブル
create table inquiry_table (
    -- 主キー
    id int auto_increment primary key,
    -- 製品ID（外部キー）
    PRODUCT_ID int null,
    -- 送信元（外部キー）
    REPLY_FROM int null,
    -- 送信先（外部キー）
    REPLY_TO int null,
    -- 題名
    TITLE varchar(200),
    -- 概要
    OVERVIEW varchar(200),
    -- 録音方法
    RECORDING_METHOD varchar(200),
    -- 音声1
    AUDIO1 varchar(200),
    -- 音声2
    AUDIO2 varchar(200),
    -- 画像
    IMAGES varchar(200),
    -- 識別
    IDENTIFICATION BOOLEAN not null,

    -- 外部キー制約
    -- 製品ID
    FOREIGN KEY (REPLY_FROM) REFERENCES product_table(id) ON DELETE CASCADE,

    -- 送信元（送信元のユーザーID）
    FOREIGN KEY (REPLY_FROM) REFERENCES user_table(id) ON DELETE CASCADE,

    -- 送信先（送信先のユーザーID）
    FOREIGN KEY (REPLY_FROM) REFERENCES user_table(id) ON DELETE CASCADE
);

/*備考
    ・ADMINが予約語で使用できなかった為、
    ADMINSに変更

    ・PASSWORDが予約語で使用できなかった為、
    PASSWORDSに変更
*/
-- 管理者テーブル
create table admin_table (
    -- 主キー
    id int auto_increment primary key,
    -- 管理者ID
    ADMINS varchar(200) not null,
    -- パスワード
    PASSWORDS varchar(200) not null
);


INSERT INTO user_table VALUES (1,'雅弥','プロフィールプロフィール','linklink','storage/icon/masaya.png','test@test','testtest',1,1,0);
INSERT INTO user_table VALUES (2,'管理者','プロフィールプロフィール','testlink','storage/icon/masaya.png','admin@admin','adminadmin',1,1,0);
INSERT INTO user_table VALUES (3,'オフロスキー','お風呂は好きかい？','testlink','storage/icon/オフロスキー1.jpg','admin@admin','adminadmin',1,1,0);


INSERT INTO product_table VALUES (1,'ZOOM/ MS-50G マルチストンプ マルチエフェクター','storage/product/ms50g.png','製品概要',true);
INSERT INTO product_table VALUES (2,'ギターだよ','storage/product/ms50g.png','これはギターです。',true);


INSERT INTO post_table VALUES (1,1,1,'投稿１','投稿１の概要です','録音方法は。。。','2023/11/21',3,'storage/music/maou_bgm_fantasy15.mp3','storage/music/maou_bgm_fantasy15.mp3','storage/product/ms50g.png',true);
INSERT INTO post_table VALUES (2,1,2,'投稿2','投稿2の概要です','録音方法は。。。','2023/11/21',3,'storage/music/maou_bgm_fantasy15.mp3','storage/music/maou_bgm_fantasy15.mp3','storage/product/ms50g.png',true);
INSERT INTO post_table VALUES (3,1,1,'投稿3','投稿3の概要です','録音方法は。。。','2023/11/21',3,'storage/music/maou_bgm_fantasy15.mp3','storage/music/maou_bgm_fantasy15.mp3','storage/product/ms50g.png',true);
INSERT INTO post_table VALUES (4,2,2,'投稿2-1','投稿2-1の概要です','録音方法は。。。','2023/11/21',3,'storage/music/maou_bgm_fantasy15.mp3','storage/music/maou_bgm_fantasy15.mp3','storage/product/ms50g.png',true);
INSERT INTO post_table VALUES (5,2,2,'投稿2-2','投稿2-2の概要です','録音方法は。。。','2023/11/21',3,'storage/music/maou_bgm_fantasy15.mp3','storage/music/maou_bgm_fantasy15.mp3','storage/product/ms50g.png',true);
INSERT INTO post_table VALUES (6,2,2,'投稿2-3','投稿2-3の概要です','録音方法は。。。','2023/11/21',3,'storage/music/maou_bgm_fantasy15.mp3','storage/music/maou_bgm_fantasy15.mp3','storage/product/ms50g.png',true);
INSERT INTO post_table VALUES (7,3,2,'投稿2-3','投稿2-3の概要です','録音方法は。。。','2023/11/21',3,'storage/music/maou_bgm_fantasy15.mp3','storage/music/maou_bgm_fantasy15.mp3','storage/product/AC-3.jpg',true);

INSERT INTO post_table VALUES (8,3,2,'投稿2-3','投稿2-3の概要です','録音方法は。。。','2023/11/21',3,'storage/music/maou_bgm_fantasy15.mp3',null,'storage/product/AC-3.jpg',false);


INSERT INTO connected_post_table VALUES (null, 8,'連結投稿','概要','storage/music/maou_bgm_fantasy15.mp3','storage/product/AC-3.jpg');

INSERT INTO equip_table VALUES (null,1,1,'マルチストンプ');
INSERT INTO equip_table VALUES (null,1,2,'投稿1使用機材2');
INSERT INTO equip_table VALUES (null,1,3,'投稿1使用機材3');
INSERT INTO equip_table VALUES (null,2,1,'ギター');
INSERT INTO equip_table VALUES (null,3,1,'ギター');
INSERT INTO equip_table VALUES (null,7,1,'マルチストンプ');
INSERT INTO equip_table VALUES (null,7,2,'投稿1使用機材2');
INSERT INTO equip_table VALUES (null,7,3,'投稿1使用機材3');
INSERT INTO equip_table VALUES (null,7,1,'ギター');



