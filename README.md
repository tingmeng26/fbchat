# 佈署正式站修改
  1. 根據正式站粉絲專頁資訊，修改 _parameter.php 中粉專編號、文章編號、$tag等參數
  2. 修改shard.php中導向路徑，正式站需建立m.me粉專短網址並於後台訂閱messaging_referrals功能

# 程式執行流程 (本例專案資料夾為ielts2)
  call.php 為粉專後台應用程式設定webhook網址
## POST 
  判斷回傳值有changes物件，為使用者於fb粉專文章中留言(本例遊戲開啟流程第一步) 載入專案資料夾changes.php，判斷使用者輸入之留言是否符合關鍵字要求，若符合，呼叫_parameter.php中getResponse方法，以參數**開始遊戲**開啟流程第一步，反之回傳提示錯誤訊息。
  判斷回傳值有messaging物件，為開始遊戲流程後使用者於聊天室回覆訊息或使用遊戲中帶postback屬性的按鈕，由call.php載入messaging.php，分為兩部分
### 遊戲回覆
  為使用者於聊天室中回應遊戲題目，按按鈕的postback值，會代入getResponse方法中進行switch判斷，進而執行下一題或相關操作。
### 分享結果至fb後redirect url
  為使用者結束遊戲流程後分享結果，完成後由fb執行redirect url。
  程式判斷到為此操作，執行getResponse方法代入相關物件參數執行下一步驟
## 本遊戲使用之圖片圴放置於 source資料夾中，結果圖、抽獎圖有執行預先上傳以attachment id 發送方式。
## 上傳檔案或得attachment id方法為updateImage.php，檔案中sender_id參數為近24小時與粉絲團互動過使用者代號，可至資料表ielts2查psid欄位或至message_log查看每一則webhook回傳值，目前為mark的代號，再依實際情形更改，
