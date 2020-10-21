## BackendController:

Ushbu controller Backend dagi hr bir Controller uchun majburiy holatda extend qilinishi shart bo'lgan controllerdir. 

`yii\web\Controller` o'rniga extend qilinishi kerak bo'ladi. Bu controller user logged in, user has admin role kabi filter va bir qancha ishlashga qulay funksiyalarni o'z ichiga olgan.

--

`$this->registerCss($files)` / based on AppAsset

CSS faylni yoki fayllarni headerga qo'shadi. $files yeriga bir yoki array holatda ko'p file berish mumkin.

--

`$this->registerJs($files)` / based on AppAsset

JS faylni yoki fayllarni footerga qo'shadi. $files yeriga bir yoki array holatda ko'p file berish mumkin.


--


## Backend class:

`/base/Backend::current_user()`

Returns current user

--

`/base/Backend::current_user('id')`

Returns current user ID

--

`/base/Backend::current_user('roles')`

Returns current user roles as array

--

`/base/Backend::language('current')`

Returns current language

--

`/base/Backend::language('content')`

Returns current content language

--

`/base/Backend::language('list')`

Returns active languages list

