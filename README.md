內部資料管理系統

扣掉安全性套件的表格，主要由以下五個表格構成：
1.使用者－基本資料以及所屬權限
2.權限-權限名稱
3.領域-領域名稱
4.權限_領域-記錄各領域下所包含的權限，一個領域可以有數個權限，權限也可同時屬於多個領域
5.檔案-檔案名稱、內容、所屬領域

包含有功能的頁面均有一層登入保護，未登入者無法進入頁面
登入後的使用者，可以透過檔案的RESTful API進行檔案的CRUD，檔案建立時，使用者可以從權限所屬的領域中挑選一個來做為檔案的所屬領域。
使用者可以自行轉換檔案的所屬領域，可以轉換至非自身權限所屬的領域，但轉移至非所屬領域後，使用者將無法在查閱文件。

管理者權限帳號，管理者可以透過權限、領域的RESTful API來進行權限與領域的CRUD，並可以增加其他管理者。
管理者相關的頁面及API，會多一層路由保護，僅有管理者可以使用。
管理者可以擁有所有領域的權限，領域所屬的權限只有管理者可以做增加。
