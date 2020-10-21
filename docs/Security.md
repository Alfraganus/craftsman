## General functions:

`input_get($key, $default = false)`

**$_GET** dan kerakli datani keyga qarab olib secure holatda qaytaradi. Agarda key topilmasa defaultga yozilgan narsani qaytaradi.

Misol: `https://avlo.uz/?foo=bar&hello=<script>alert('Hacked');</script>`

Agar `Yii::$app->request->get('hello')` desak Hacked alerti ishlaydi. Sababi bu GET parametrini filter qilmaydi. Bu holatda JS kodlarni injection qilib hack qilsa boladi.

Agar `input_get('hello')` desak ekranda faqat `alert('Hacked')` so'zini koramiz. Bu holatda JS kod ishlamaydi va hack qilishning oldi olinadi. Sababi bu funksiya print qilishdan oldin taglarni va xavfli simvollardan tozalaydi.

--

`input_post($key, $default = false)`

**$_POST** dan kerakli datani keyga qarab olib secure holatda qaytaradi. Agarda key topilmasa defaultga yozilgan narsani qaytaradi.

Misol: Hacker https://avlo.uz/user/profile/update URL iga POST bilan saytni hack qilish maqsadida datani JS yoki PHP kod holatida jo'natish mumkin.

Agar `Yii::$app->request->post('password')` desak hackerning jo'natgan kodlari ishlaydi va saytni hack qilish qobiliyati ochiladi. Sababi bu POST dan kelayotgan datalarni filter qilmaydi va sayt jo'natilgan kodga qarab hack qilinadi.

Agar `input_post('password')` desak POST dan kelayotgan datalarda JS yoki PHP kod ishlamaydi va hack qilishning oldi olinadi. Sababi bu funksiya return qilishdan oldin taglarni va xavfli simvollardan tozalaydi.

--

`clean_array($array)`

Arraydagi datalarini tozalab secure holatda qaytaradi. Misol, qo'limizda biror array bor va uni tozash uchun filter qilmoqchi bo'lsak ishlatsak bo'ladi.

--

`clean_str($string)`

Stringni tozalab secure holatda qaytaradi. Misol, qo'limizda biror string bor va uni tozash uchun filter qilmoqchi bo'lsak ishlatsak bo'ladi.

--

`csrf_input($as_string = false)`

Form uchun kerakli inputlardan biri. Saytdagi datalarni xohlang POST xohlang GET ko'rinishda jo'natishda CSRF atakadan himoya qilish maqsadida ishlatiladi.

Misol: 
```
<form>
    <?php csrf_input(); ?>
    ...
</form>
```
