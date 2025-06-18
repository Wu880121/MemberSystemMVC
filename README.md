# EatingForYou會員系統

這是一個使用 原生PHP 建置MVC架構的 Web 專案，功能包含帳號註冊、登入、角色管理、資料列表與搜尋等，支援 Docker 自動化部署。

---
&nbsp;


## 作品:
作品連結：https://keepgoingpiggy.com/

---
&nbsp;


## 專案功能:
-  會員註冊 / 登入（支援 JWT / cookie）
-   使用者角色（Admin / User）
-   後台功能
-  密碼寄信（PHPMailer + Gmail SMTP）
-  第三方登入 (Google)
-  註冊信箱驗證
-  使用者圖片上傳
-  搜尋與分頁功能
-  Docker 環境建置 + GitHub Actions 自動部署

---
&nbsp;

## 環境需求:
-  PHP 8.2+
-  MariaDB 10.5.25
-  Docker / Docker Compose
-  Mailtrap / Gmail SMTP（忘記密碼功能）

---
&nbsp;

## 開發環境會建立預設帳號：

-  Admin 帳號：TestAdmin ， 密碼: TestAdmin@123
-  User 帳號：TestUser ， 密碼: TestUser@123

---
&nbsp;

## 自動部署流程:
-  當 push 到 main 分支時，自動打包 Docker Image 並推送到 Docker Hub
-  使用 SSH 登入 AWS EC2，拉取最新 image 並重新啟動容器


---
&nbsp;

## 作品:
作品連結：https://keepgoingpiggy.com/


---
&nbsp;

## 備註:
本專案為自學作品，開發目的為練習 PHP + HTML + MVC架構。
