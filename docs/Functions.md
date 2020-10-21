## URL functions:

`store_url($url = false)`

Returns url: https://avlo.uz/

Example: `store_url('category/electronics')` gives "https://avlo.uz/category/electronics"

--

`assets_url($url = false)`

Returns url: https://assets.avlo.uz/

Example: `assets_url('images/logo.png')` gives "https://assets.avlo.uz/images/logo.png"

--

`images_url($url = false)`

Returns url: https://assets.avlo.uz/

Example: `images_url('logo.png')` gives "https://assets.avlo.uz/images/logo.png"

--

`uploads_url($url = false)`

Returns url: https://assets.avlo.uz/uploads/

Example: `uploads_url('logo.png')` gives "https://assets.avlo.uz/uploads/logo.png"

--

`store_url($url = false)`

Returns url: https://avlo.uz/

Example: `store_url('category/electronics')` gives "https://avlo.uz/category/electronics"

--

`admin_url($url = false)`

Returns url: https://cp.avlo.uz/

Example: `admin_url('users/create')` gives "https://cp.avlo.uz/users/create"

--

`seller_url($url = false)`

Returns url: https://seller.avlo.uz/

Example: `seller_url('auth/login')` gives "https://seller.avlo.uz/auth/login"

--

`set_query_var($var, $value)`

Set query variable to URL

Add var: We have an url "https://avlo.loc/category" and when we use `set_query_var('sort', 'oldest')` it gives "https://avlo.loc/category?**sort=oldest**"

Add var without deleteting others: We have an url "https://avlo.loc/category?foo=bar" and when we use `set_query_var('sort', 'oldest')` it gives "https://avlo.loc/category?foo=bar**&sort=oldest**"

Change var: We have an url "https://avlo.loc/category?**sort=az**" and when we use `set_query_var('sort', 'oldest')` it gives "https://avlo.loc/category?**sort=oldest**"


## Global functions:

`debug($array)`

**print_r** funksiyasini bajaradi, faqat kodlarni saralab korsatadi.

--

`array_value($array = false, $key = false, $default = false)`

Arraydagi elementning znacheniyasini key ga qarab olib beradi. Agar arrayda key bolmasa defaultga yozilgan narsani qaytaradi.

--

`is_cli()`

**CLI** ekanligini aniqlaydi

--

`is_url($url)`

Stringni xaqiqiy URL ekanligini tekshirib beradi

--

## Category functions:

`category_sorting()`

Returns category sorting types as array

--

`subcategory_view_types()`

Returns category's subcategory view types as array

--

`category_products_view_types()`

Returns category products view types as array

--