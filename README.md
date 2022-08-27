# 前提
[docker-toolchains](https://github.com/NewWorldOrg/docker-toolchains)
が構築環境で稼働しているのが前提条件です。

# セットアップ

```shell script
cp .env.example .env
```

dockerのローカル開発環境は各自違うと思うのでdocker-compose.example.ymlから
docker-compose.ymlをコピーし適宜書き換えて以下を実行

## mutagen
ファイル同期の高速化にmutagenを使っているのであらかじめインストールしておく。

```shell
brew install mutagen-io/mutagen/mutagen-beta
brew install mutagen-io/mutagen/mutagen-compose-beta
```

## docker-compose.ymlの準備
```shell script
cp docker-compose.example.yml docker-compose-local.yml
# 書き換え不要ならそのまま実行
docker-compose up -d
```

## 初回起動

### dotenvの用意
.env.exampleから.envを生成

```shell
make init
```

### 起動
```shell
meke up
```

初回起動が終わったらセットアップコマンドを実行

```shell
make setup
```

このコマンドが完了して`nw.localhost/admin/auth/login`にアクセスできれば成功




