## Routing

*Routing* adalah kumpulan daftar alamat website yang sudah di daftarkan. Sehingga setiap alamat website yang terdaftar pada *routing* dapat diakses pengguna maupun mengirim informasi kepada pengguna.

###### Dalam *routing* terdapat beberapa *method* atau metode penerimaan *routing* yang terdiri dari:

1. GET adalah Metode penerimaan ini digunakan untuk meminta data sesuai dengan alamat website yang dituju & didaftarkan.
2. POST adalah Metode penerimaan ini digunakan untuk mengirim data untuk diproses oleh sistem sesuai dengan alamat website yang dituju & didaftarkan.
3. DELETE adalah Metode penerimaan ini digunakan untuk menghapus data sesuai dengan alamat website yang dituju & didaftarkan.
4. PUT adalah Metode penerimaan ini digunakan untuk melakukan perubahan data sesuai dengan alamat webiste yang dituju & didaftarkan
5. PATCH adalah Metode penerimaan ini digunakan untuk melakukan perubahan sebagian data sesuai dengan alamat webiste yang dituju & didaftarkan


### Routing Web

*Routing web* berisi daftar alamat website yang dapat diakses oleh pengguna yang berupa proses sesuai dengan alamat website yang dituju. setiap *routing* akan membaca setelah `https://www.example.com/`

###### Daftar *routing web* yang terdaftar:

1. Route::get("{collection}", 'ResourcesController@index')   
   
*Routing* ini menggunakan *method* GET dan nama alamat website untuk diakses pengguna adalah `{collection}`, `{collection}` disini merupakan nama *model* atau nama tabel basis data yang sudah dibuat. Ketika mengakses *routing* ini maka untuk prosesnya akan diterukan ke *controller* bernama *ResourcesController* dengan nama *function index*. setelah proses persiapan data pada *controller* sudah selesai, maka hasil data tersebut akan diteruskan kepada pengguna. pada *routing* ini akan menampilkan halaman list data dari `{collection}` yang dituju.
   
contoh alamat website:
- `https://www.example.com/countries`
- `https://www.example.com/provinces`

pada contoh alamat website `https://www.example.com/countries` akan meminta data dari basis data dengan tabel countries.   
pada contoh alamat website `https://www.example.com/provinces` akan meminta data dari basis data dengan tabel provinces.   
   
2. Route::get("{collection}/trash", 'ResourcesController@trash')   
   
*Routing* ini menggunakan *method* GET dan nama alamat website untuk diakses pengguna adalah `{collection}/trash`, `{collection}` disini merupakan nama *model* atau nama tabel basis data yang sudah dibuat. Ketika mengakses *routing* ini maka untuk prosesnya akan diterukan ke *controller* bernama *ResourcesController* dengan nama *function trash*. setelah proses persiapan data pada *controller* sudah selesai, maka hasil data tersebut akan diteruskan kepada pengguna. pada *routing* ini akan menampilkan halaman list data dari `{collection}` yang telah melakukan *soft delete*.

contoh alamat website:
- `https://www.example.com/countries/trash`
- `https://www.example.com/provinces/trash`

pada contoh alamat website `https://www.example.com/countries/trash` akan meminta data dari basis data dengan tabel countries yang telah melakukan *soft delete*.   
pada contoh alamat website `https://www.example.com/provinces/trash` akan meminta data dari basis data dengan tabel provinces yang telah melakukan *soft delete*.   

3. Route::get("{collection}/create", 'ResourcesController@create')   
   
*Routing* ini menggunakan *method* GET dan nama alamat website untuk diakses pengguna adalah `{collection}/create`, `{collection}` disini merupakan nama *model* atau nama tabel basis data yang sudah dibuat. Ketika mengakses *routing* ini maka untuk prosesnya akan diterukan ke *controller* bernama *ResourcesController* dengan nama *function create*. setelah proses persiapan data pada *controller* sudah selesai, maka hasil data tersebut akan diteruskan kepada pengguna. pada *routing* ini akan menampilkan halaman *create* atau pembuatan sesuai dengan nama `{collection}`.

contoh alamat website:
- `https://www.example.com/countries/create`
- `https://www.example.com/provinces/create`

pada contoh alamat website `https://www.example.com/countries/create` akan menampilkan halaman *create* atau pembuatan.   
pada contoh alamat website `https://www.example.com/provinces/create` akan menampilkan halaman *create* atau pembuatan.  

4. Route::post("{collection}", 'ResourcesController@store')  
  
*Routing* ini menggunakan *method* POST dan nama alamat website untuk diakses pengguna adalah `{collection}`, `{collection}` disini merupakan nama *model* atau nama tabel basis data yang sudah dibuat. Ketika mengakses *routing* ini maka untuk prosesnya akan diterukan ke *controller* bernama *ResourcesController* dengan nama *function store*. Proses ini melakukan penyimpanan data sesuai yang telah diisi pada halaman *create* pada tabel basis data sesuai dengan nama `{collection}`. pada alamat website ini dapat diakses setelah melakukan *submit* pada halaman *create* atau pembuatan 
  
contoh alamat website:
- `https://www.example.com/countries`
- `https://www.example.com/provices`
  
pada contoh alamat website `https://www.example.com/countries` akan melakukan penyimpanan data pada table basis data *countries*.   
pada contoh alamat website `https://www.example.com/provinces` akan melakukan penyimpanan data pada table basis data *provinces*.

5. Route::get("{collection}/import", 'ResourcesController@import')  
  
*Routing* ini menggunakan *method* GET dan nama alamat website untuk diakses pengguna adalah `{collection}/import`, `{collection}` disini merupakan nama *model* atau nama tabel basis data yang sudah dibuat. Ketika mengakses *routing* ini maka untuk prosesnya akan diterukan ke *controller* bernama *ResourcesController* dengan nama *function import*. setelah proses persiapan data pada *controller* sudah selesai, maka hasil data tersebut akan diteruskan kepada pengguna. pada *routing* ini akan menampilkan halaman *import* sesuai dengan nama `{collection}`.

contoh alamat website:
- `https://www.example.com/countries/import`
- `https://www.example.com/provinces/import`

pada contoh alamat website `https://www.example.com/countries/import` akan menampilkan halaman *import*.   
pada contoh alamat website `https://www.example.com/provinces/import` akan menampilkan halaman *import*.  

6. Route::post("{collection}/import", 'ResourcesController@doImport')  
  
*Routing* ini menggunakan *method* POST dan nama alamat website untuk diakses pengguna adalah `{collection}\import`, `{collection}` disini merupakan nama *model* atau nama tabel basis data yang sudah dibuat. Ketika mengakses *routing* ini maka untuk prosesnya akan diterukan ke *controller* bernama *ResourcesController* dengan nama *function doImport*. Proses ini melakukan penyimpanan data sesuai dengan file csv yang telah dipilihan kemudian disimpan pada tabel basis data sesuai dengan nama `{collection}`. pada alamat website ini dapat diakses setelah melakukan *import* pada halaman *import*
  
contoh alamat website:
- `https://www.example.com/countries/import`
- `https://www.example.com/provices/import`
  
pada contoh alamat website `https://www.example.com/countries/import` akan melakukan penyimpanan data sesuai file csv pada table basis data *countries*.   
pada contoh alamat website `https://www.example.com/provinces/import` akan melakukan penyimpanan data sesuai file csv pada table basis data *provinces*.

7. Route::get("{collection}/export", 'ResourcesController@export')  
  
*Routing* ini menggunakan *method* GET dan nama alamat website untuk diakses pengguna adalah `{collection}/export`, `{collection}` disini merupakan nama *model* atau nama tabel basis data yang sudah dibuat. Ketika mengakses *routing* ini maka untuk prosesnya akan diterukan ke *controller* bernama *ResourcesController* dengan nama *function export*. setelah proses persiapan data pada *controller* sudah selesai, maka hasil data tersebut akan diteruskan kepada pengguna. pada *routing* ini akan menampilkan halaman *export* sesuai dengan nama `{collection}`.

contoh alamat website:
- `https://www.example.com/countries/export`
- `https://www.example.com/provinces/export`

pada contoh alamat website `https://www.example.com/countries/export` akan menampilkan halaman *export*.   
pada contoh alamat website `https://www.example.com/provinces/export` akan menampilkan halaman *export*.  

8. Route::post("{collection}/export", 'ResourcesController@doExport')  
  
*Routing* ini menggunakan *method* POST dan nama alamat website untuk diakses pengguna adalah `{collection}\export`, `{collection}` disini merupakan nama *model* atau nama tabel basis data yang sudah dibuat. Ketika mengakses *routing* ini maka untuk prosesnya akan diterukan ke *controller* bernama *ResourcesController* dengan nama *function doExport*. Proses ini melakukan mengeluarkan data sesuai dengan nama `{collection}` kemudia data tersebut akan dibentuk menjadi file berformat csv dan dapat di undah. pada alamat website ini dapat diakses setelah melakukan *export* pada halaman *export*
  
contoh alamat website:
- `https://www.example.com/countries/export`
- `https://www.example.com/provices/export`
  
pada contoh alamat website `https://www.example.com/countries/export` akan melakukan pengeluaran data table basis data *countries* dan kemudian akan dibentuk menjadi file berformat csv dan dapat di undah.   
pada contoh alamat website `https://www.example.com/provinces/export` akan melakukan pengeluaran data table basis data *provices* dan kemudian akan dibentuk menjadi file berformat csv dan dapat di undah.

9. Route::get("{collection}/{id}", 'ResourcesController@show')  
  
*Routing* ini menggunakan *method* GET dan nama alamat website untuk diakses pengguna adalah `{collection}/{id}`, `{collection}` disini merupakan nama *model* atau nama tabel basis data yang sudah dibuat dan `{id}` disini merupakan *id* yang telah disimpan pada basis data di tabel `{collection}` yang dituju. Ketika mengakses *routing* ini maka untuk prosesnya akan diterukan ke *controller* bernama *ResourcesController* dengan nama *function show*. setelah proses persiapan data pada *controller* sudah selesai, maka hasil data tersebut akan diteruskan kepada pengguna. pada *routing* ini akan menampilkan halaman detail data sesuai dengan nama `{collection}` dan `{id}`.

contoh alamat website:
- `https://www.example.com/countries/1`
- `https://www.example.com/provinces/2`

pada contoh alamat website `https://www.example.com/countries/1` akan menampilkan halaman detail *countries* yang memiliki id 1.   
pada contoh alamat website `https://www.example.com/provinces/2` akan menampilkan halaman detail *provices* yang memiliki id 2.  

10. Route::get("{collection}/{id}/edit", 'ResourcesController@edit')  
  
*Routing* ini menggunakan *method* GET dan nama alamat website untuk diakses pengguna adalah `{collection}/{id}/edit`, `{collection}` disini merupakan nama *model* atau nama tabel basis data yang sudah dibuat dan `{id}` disini merupakan *id* yang telah disimpan pada basis data di tabel `{collection}` yang dituju. Ketika mengakses *routing* ini maka untuk prosesnya akan diterukan ke *controller* bernama *ResourcesController* dengan nama *function edit*. setelah proses persiapan data pada *controller* sudah selesai, maka hasil data tersebut akan diteruskan kepada pengguna. pada *routing* ini akan menampilkan halaman *edit* sesuai dengan nama `{collection}` dan `{id}`.

contoh alamat website:
- `https://www.example.com/countries/1/edit`
- `https://www.example.com/provinces/2/edit`

pada contoh alamat website `https://www.example.com/countries/1/edit` akan menampilkan halaman edit *countries* yang memiliki id 1.   
pada contoh alamat website `https://www.example.com/provinces/2/edit` akan menampilkan halaman edit *provices* yang memiliki id 2.  

11. Route::put("{collection}/{id}", 'ResourcesController@update')  
  
*Routing* ini menggunakan *method* PUT dan nama alamat website untuk diakses pengguna adalah `{collection}/{id}`, `{collection}` disini merupakan nama *model* atau nama tabel basis data yang sudah dibuat dan `{id}` disini merupakan *id* yang telah disimpan pada basis data di tabel `{collection}` yang dituju. Ketika mengakses *routing* ini maka untuk prosesnya akan diterukan ke *controller* bernama *ResourcesController* dengan nama *function update*. Pada proses ini akan melakukan *update* data sesuai dengan data yang telah di *submit* pada halaman *edit* sesuai dengan nama `{collection}` dan `{id}`. pada alamat website ini dapat diakses setelah melakukan *submit* pada halaman *edit*.  

contoh alamat website:
- `https://www.example.com/countries/1`
- `https://www.example.com/provinces/2`

pada contoh alamat website `https://www.example.com/countries/1` akan mengubah data pada table basis data *countries* dengan id 1.   
pada contoh alamat website `https://www.example.com/provinces/2` akan mengubah data pada table basis data *provinces* dengan id 2.  

12. Route::delete("{collection}/{id}", 'ResourcesController@destroy')  
  
*Routing* ini menggunakan *method* DELETE dan nama alamat website untuk diakses pengguna adalah `{collection}/{id}`, `{collection}` disini merupakan nama *model* atau nama tabel basis data yang sudah dibuat dan `{id}` disini merupakan *id* yang telah disimpan pada basis data di tabel `{collection}` yang dituju. Ketika mengakses *routing* ini maka untuk prosesnya akan diterukan ke *controller* bernama *ResourcesController* dengan nama *function destroy*. Pada proses ini akan melakukan *soft delete* data sesuai dengan data dengan nama `{collection}` dan `{id}`. pada alamat website ini dapat diakses setelah melakukan *delete* pada halaman *index*.  

contoh alamat website:
- `https://www.example.com/countries/1`
- `https://www.example.com/provinces/2`

pada contoh alamat website `https://www.example.com/countries/1` akan melakukan *soft delete* pada table basis data *countries* dengan id 1.   
pada contoh alamat website `https://www.example.com/provinces/2` akan melakukan *soft delete* pada table basis data *provinces* dengan id 2.

13. Route::get("{collection}/{id}/trashed", 'ResourcesController@trashed')  
  
*Routing* ini menggunakan *method* GET dan nama alamat website untuk diakses pengguna adalah `{collection}/{id}`, `{collection}` disini merupakan nama *model* atau nama tabel basis data yang sudah dibuat dan `{id}` disini merupakan *id* yang telah disimpan pada basis data di tabel `{collection}` yang dituju. Ketika mengakses *routing* ini maka untuk prosesnya akan diterukan ke *controller* bernama *ResourcesController* dengan nama *function trashed*. setelah proses persiapan data pada *controller* sudah selesai, maka hasil data tersebut akan diteruskan kepada pengguna. pada *routing* ini akan menampilkan halaman detail data yang sudah melakukan *soft delete* sesuai dengan nama `{collection}` dan `{id}`.

contoh alamat website:
- `https://www.example.com/countries/1/trashed`
- `https://www.example.com/provinces/2/trashed`

pada contoh alamat website `https://www.example.com/countries/1/trashed` akan menampilkan halaman detail *countries* yang memiliki id 1 yang sudah melakukan *soft delete*.   
pada contoh alamat website `https://www.example.com/provinces/2/trashed` akan menampilkan halaman detail *provices* yang memiliki id 2 yang sudah melakukan *soft delete*. 

14. Route::put("{collection}/{id}/restore", 'ResourcesController@restore')  
  
*Routing* ini menggunakan *method* PUT dan nama alamat website untuk diakses pengguna adalah `{collection}/{id}/restore`, `{collection}` disini merupakan nama *model* atau nama tabel basis data yang sudah dibuat dan `{id}` disini merupakan *id* yang telah disimpan pada basis data di tabel `{collection}` yang dituju. Ketika mengakses *routing* ini maka untuk prosesnya akan diterukan ke *controller* bernama *ResourcesController* dengan nama *function restore*. Pada proses ini akan mengembalikan data yang sudah pernah melakukan *soft delete* sesuai dengan nama `{collection}` dan `{id}`. pada alamat website ini dapat diakses setelah melakukan *restore* pada halaman *trash*.  

contoh alamat website:
- `https://www.example.com/countries/1/restore`
- `https://www.example.com/provinces/2/restore`

pada contoh alamat website `https://www.example.com/countries/1/restore` mengembalikan data yang pernah melakukan *soft delete* pada table basis data *countries* dengan id 1.   
pada contoh alamat website `https://www.example.com/provinces/2/restore` mengembalikan data yang pernah melakukan *soft delete* pada table basis data *provinces* dengan id 2.  

15. Route::delete("{collection}/{id}/delete", 'ResourcesController@delete')  
  
*Routing* ini menggunakan *method* DELETE dan nama alamat website untuk diakses pengguna adalah `{collection}/{id}/delete`, `{collection}` disini merupakan nama *model* atau nama tabel basis data yang sudah dibuat dan `{id}` disini merupakan *id* yang telah disimpan pada basis data di tabel `{collection}` yang dituju. Ketika mengakses *routing* ini maka untuk prosesnya akan diterukan ke *controller* bernama *ResourcesController* dengan nama *function delete*. Pada proses ini akan melakukan *hard delete* atau *permanent delete* data yang pernah melakukan *soft delete* sesuai dengan data dengan nama `{collection}` dan `{id}`. pada alamat website ini dapat diakses setelah melakukan *delete permanent* pada halaman *trash*.  

contoh alamat website:
- `https://www.example.com/countries/1/delete`
- `https://www.example.com/provinces/2/delete`

pada contoh alamat website `https://www.example.com/countries/1/delete` akan melakukan *hard delete* atau *permanent delete* pada table basis data *countries* dengan id 1.   
pada contoh alamat website `https://www.example.com/provinces/2/delete` akan melakukan *hard delete* atau *permanent delete* pada table basis data *provinces* dengan id 2.

16. Route::delete("{collection}/trash/empty", 'ResourcesController@empty')
  
*Routing* ini menggunakan *method* DELETE dan nama alamat website untuk diakses pengguna adalah `{collection}/trash/empty`, `{collection}` disini merupakan nama *model* atau nama tabel basis data yang sudah dibuat dan `{id}` disini merupakan *id* yang telah disimpan pada basis data di tabel `{collection}` yang dituju. Ketika mengakses *routing* ini maka untuk prosesnya akan diterukan ke *controller* bernama *ResourcesController* dengan nama *function empty*. Pada proses ini akan melakukan *hard delete* atau *permanent delete* data yang pernah melakukan *soft delete* sesuai dengan data dengan nama `{collection}`. pada alamat website ini dapat diakses setelah melakukan *delete permanent* pada halaman *trash*.  

contoh alamat website:
- `https://www.example.com/countries/trash/delete`
- `https://www.example.com/provinces/trash/delete`

pada contoh alamat website `https://www.example.com/countries/trash/delete` akan melakukan *hard delete* atau *permanent delete* pada table basis data *countries*.   
pada contoh alamat website `https://www.example.com/provinces/trash/delete` akan melakukan *hard delete* atau *permanent delete* pada table basis data *provinces*.  
  
17. Route::put("{collection}/trash/restore", 'ResourcesController@putBack')  
  
*Routing* ini menggunakan *method* PUT dan nama alamat website untuk diakses pengguna adalah `{collection}/trash/restore`, `{collection}` disini merupakan nama *model* atau nama tabel basis data yang sudah dibuat. Ketika mengakses *routing* ini maka untuk prosesnya akan diterukan ke *controller* bernama *ResourcesController* dengan nama *function putBack*. Pada proses ini akan mengembalikan setiap data yang sudah pernah melakukan *soft delete* sesuai dengan nama `{collection}`. pada alamat website ini dapat diakses setelah melakukan *restore all* pada halaman *trash*.  

contoh alamat website:
- `https://www.example.com/countries/trash/restore`
- `https://www.example.com/provinces/trash/restore`

pada contoh alamat website `https://www.example.com/countries/trash/restore` akan mengembalikan setiap data yang pernah melakukan *soft delete* pada table basis data *countries*.   
pada contoh alamat website `https://www.example.com/provinces/trash/restore` akan mengembalikan setiap data yang pernah melakukan *soft delete* pada table basis data *provinces*.  
  
  
### Routing API

*Routing api* adalah daftar alamat website yang berupa *service*. setiap *routing* akan membaca setelah `https://www.example.com/api/`.

###### Daftar *routing web* yang terdaftar dengan menggunakan prefix *URI* v1/user:

1. Route::post('login', 'AuthController@login')
  
*Routing* ini menggunakan *method* POST dan nama alamat website disini adalah `v1/user/login`. Ketika mengakses *routing* ini maka untuk prosesnya akan diterukan ke *controller* bernama *AuthController* dengan nama *function login*. proses ini digunakan untuk melakukan *verify* user ketika melakukan *login*.  
  
contoh alamat website:
- `https://www.example.com/api/v1/user/login`

pada contoh alamat website `https://www.example.com/api/v1/user/login` akan melakukan *verify* user ketika melakukan *login*.  
  
2. Route::post('register', 'AuthController@signup')  
  
*Routing* ini menggunakan *method* POST dan nama alamat website disini adalah `v1/user/register`. Ketika mengakses *routing* ini maka untuk prosesnya akan diterukan ke *controller* bernama *AuthController* dengan nama *function signup*. proses ini digunakan untuk melakukan pendaftaran user.  
  
contoh alamat website:
- `https://www.example.com/api/v1/user/register`

pada contoh alamat website `https://www.example.com/api/v1/user/register` akan melakukan pendaftaran user.  
  
3. Route::patch('password/reset', 'AuthController@resetPassword')
  
*Routing* ini menggunakan *method* PATCH dan nama alamat website disini adalah `v1/user/password/reset`. Ketika mengakses *routing* ini maka untuk prosesnya akan diterukan ke *controller* bernama *AuthController* dengan nama *function resetPassword*. proses ini digunakan untuk melakukan *reset* password user.  
  
contoh alamat website:
- `https://www.example.com/api/v1/user/password/reset`

pada contoh alamat website `https://www.example.com/api/v1/user/password/reset` akan melakukan *reset* password user.  
  
4. Route::delete('logout', 'AuthController@logout')
  
*Routing* ini menggunakan *method* DELETE dan nama alamat website disini adalah `v1/user/logout`. Ketika mengakses *routing* ini maka untuk prosesnya akan diterukan ke *controller* bernama *AuthController* dengan nama *function logout*. proses ini digunakan untuk melakukan *logout* user.  
  
contoh alamat website:
- `https://www.example.com/api/v1/user/logout`

pada contoh alamat website `https://www.example.com/api/v1/user/logout` akan melakukan *logout* user.  

5. Route::get('profile', 'AuthController@profile')
  
*Routing* ini menggunakan *method* GET dan nama alamat website disini adalah `v1/user/profile`. Ketika mengakses *routing* ini maka untuk prosesnya akan diterukan ke *controller* bernama *AuthController* dengan nama *function profile*. proses ini digunakan untuk mengambil data *profile* user yang sedang *login*.  
  
contoh alamat website:
- `https://www.example.com/api/v1/user/profile`

pada contoh alamat website `https://www.example.com/api/v1/user/profile` akan mengambil data *profile* user yang sedang *login*.
  
6. Route::get('checkin', 'AuthController@checkin')
  
7. Route::patch('password', 'AuthController@changePassword')
  
*Routing* ini menggunakan *method* PATCH dan nama alamat website disini adalah `v1/user/password`. Ketika mengakses *routing* ini maka untuk prosesnya akan diterukan ke *controller* bernama *AuthController* dengan nama *function changePassword*. proses ini digunakan untuk melakukan ganti password user.  
  
contoh alamat website:
- `https://www.example.com/api/v1/user/password`

pada contoh alamat website `https://www.example.com/api/v1/user/password` akan melakukan ganti password user.  
  
8. Route::post('fcm', 'AuthController@createUpdateFCM')  
  
*Routing* ini menggunakan *method* POST dan nama alamat website disini adalah `v1/user/fcm`. Ketika mengakses *routing* ini maka untuk prosesnya akan diterukan ke *controller* bernama *AuthController* dengan nama *function createUpdateFCM*. proses ini digunakan untuk melakukan pembuatan / *update* FCM token.  
  
contoh alamat website:
- `https://www.example.com/api/v1/user/fcm`

pada contoh alamat website `https://www.example.com/api/v1/user/fcm` akan melakukan pembuatan / *update* FCM token.  
  
###### Daftar *routing web* yang terdaftar dengan menggunakan prefix *URI* v1:

1. Route::get("{collection}", 'Api\ApiResourcesController@index')
  
*Routing* ini menggunakan *method* GET dan nama alamat website disini adalah `v1/{collection}`. `{collection}` disini merupakan nama *model* atau nama tabel basis data yang sudah dibuat. Ketika mengakses *routing* ini maka untuk prosesnya akan diterukan ke *controller* bernama *ApiResourcesController* dengan nama *function index*. proses ini digunakan untuk mengambil data dari basis data dengan nama tabel `{collection}`.  
  
contoh alamat website:
- `https://www.example.com/api/v1/countries`
- `https://www.example.com/api/v1/provinces`

pada contoh alamat website `https://www.example.com/api/v1/countries` akan mengambil data dari basis data dengan nama tabel *countries*.  
pada contoh alamat website `https://www.example.com/api/v1/provinces` akan mengambil data dari basis data dengan nama tabel *provinces*.  
  
2. Route::post("{collection}", 'Api\ApiResourcesController@store')
  
*Routing* ini menggunakan *method* POST dan nama alamat website disini adalah `v1/{collection}`. `{collection}` disini merupakan nama *model* atau nama tabel basis data yang sudah dibuat. Ketika mengakses *routing* ini maka untuk prosesnya akan diterukan ke *controller* bernama *ApiResourcesController* dengan nama *function store*. proses ini digunakan untuk membuat data baru yang akan disimpan pada basis data dengan nama tabel `{collection}`.  
  
contoh alamat website:
- `https://www.example.com/api/v1/countries`
- `https://www.example.com/api/v1/provinces`

pada contoh alamat website `https://www.example.com/api/v1/countries` akan menyipan data pada basis data dengan nama tabel *countries*.  
pada contoh alamat website `https://www.example.com/api/v1/provinces` akan menyipan data pada basis data dengan nama tabel *provinces*.  
  
3. Route::get("{collection}/trash", 'Api\ApiResourcesController@trash')
  
*Routing* ini menggunakan *method* GET dan nama alamat website disini adalah `v1/{collection}/trash`. `{collection}` disini merupakan nama *model* atau nama tabel basis data yang sudah dibuat. Ketika mengakses *routing* ini maka untuk prosesnya akan diterukan ke *controller* bernama *ApiResourcesController* dengan nama *function trash*. proses ini digunakan untuk mengambil data dari basis data dengan nama tabel `{collection}` yang telah melakukan *soft delete*.  
  
contoh alamat website:
- `https://www.example.com/api/v1/countries/trash`
- `https://www.example.com/api/v1/provinces/trash`

pada contoh alamat website `https://www.example.com/api/v1/countries/trash` akan mengambil data dari basis data dengan nama tabel *countries* yang telah melakukan *soft delete*.  
pada contoh alamat website `https://www.example.com/api/v1/provinces/trash` akan mengambil data dari basis data dengan nama tabel *provinces* yang telah melakukan *soft delete*.  
  
4. Route::post("{collection}/import", 'Api\ApiResourcesController@import')  
5. Route::post("{collection}/export", 'Api\ApiResourcesController@export')
  
*Routing* ini menggunakan *method* POST dan nama alamat website disini adalah `v1/{collection}/export`. `{collection}` disini merupakan nama *model* atau nama tabel basis data yang sudah dibuat. Ketika mengakses *routing* ini maka untuk prosesnya akan diterukan ke *controller* bernama *ApiResourcesController* dengan nama *function export*. proses ini digunakan untuk mengambil data pada basis data dengan nama tabel `{collection}` kemudian akan dibentuk file dengan format csv atau xlsx dan dapat diundah.  
  
contoh alamat website:
- `https://www.example.com/api/v1/countries/export`
- `https://www.example.com/api/v1/provinces/export`

pada contoh alamat website `https://www.example.com/api/v1/countries/export` akan mengambil data pada basis data dengan nama tabel *countries* kemudian akan dibentuk file dengan format csv atau xlsx dan dapat diundah.  
pada contoh alamat website `https://www.example.com/api/v1/provinces/export` akan mengambil data pada basis data dengan nama tabel *provinces*kemudian akan dibentuk file dengan format csv atau xlsx dan dapat diundah.  
  
6. Route::get("{collection}/report", 'Api\ApiResourcesController@report')  
7. Route::get("{collection}/{id}/trashed", 'Api\ApiResourcesController@trashed')->where('id', '[a-zA-Z0-9]+')
  
*Routing* ini menggunakan *method* GET dan nama alamat website disini adalah `v1/{collection}/{id}/trashed`. `{collection}` disini merupakan nama *model* atau nama tabel basis data yang sudah dibuat. `{id}` disini merupakan *id* yang telah disimpan pada basis data di tabel `{collection}` yang dituju. Ketika mengakses *routing* ini maka untuk prosesnya akan diterukan ke *controller* bernama *ApiResourcesController* dengan nama *function trashed*. proses ini digunakan untuk mengambil data dari basis data dengan nama tabel `{collection}` dengan id `{id}` yang telah melakukan *soft delete*.  
  
contoh alamat website:
- `https://www.example.com/api/v1/countries/1/trashed`
- `https://www.example.com/api/v1/provinces/2/trashed`

pada contoh alamat website `https://www.example.com/api/v1/countries/1/trashed` akan mengambil data dari basis data dengan nama tabel *countries* dengan id 1 yang telah melakukan *soft delete*.  
pada contoh alamat website `https://www.example.com/api/v1/provinces/2/trashed` akan mengambil data dari basis data dengan nama tabel *provinces* dengan id 2 yang telah melakukan *soft delete*.  
  
8. Route::post("{collection}/{id}/restore", 'Api\ApiResourcesController@restore')->where('id', '[a-zA-Z0-9]+')
  
*Routing* ini menggunakan *method* POST dan nama alamat website disini adalah `v1/{collection}/{id}/restore`. `{collection}` disini merupakan nama *model* atau nama tabel basis data yang sudah dibuat. `{id}` disini merupakan *id* yang telah disimpan pada basis data di tabel `{collection}` yang dituju. Ketika mengakses *routing* ini maka untuk prosesnya akan diterukan ke *controller* bernama *ApiResourcesController* dengan nama *function restore*. proses ini digunakan untuk mengembalikan data yang telah melakukan *soft delete* pada basis data dengan nama tabel `{collection}` dan `{id}`.  
  
contoh alamat website:
- `https://www.example.com/api/v1/countries/1/restore`
- `https://www.example.com/api/v1/provinces/2/restore`

pada contoh alamat website `https://www.example.com/api/v1/countries/1/restore` akan mengembalikan data yang telah melakukan *soft delete* pada basis data dengan nama tabel *countries* dengan id 1.  
pada contoh alamat website `https://www.example.com/api/v1/provinces/2/restore` akan mengembalikan data yang telah melakukan *soft delete* pada basis data dengan nama tabel *provinces* dengan id 2.  
  
9. Route::delete("{collection}/{id}/delete", 'Api\ApiResourcesController@delete')->where('id', '[a-zA-Z0-9]+')
  
*Routing* ini menggunakan *method* DELETE dan nama alamat website disini adalah `v1/{collection}/{id}/delete`. `{collection}` disini merupakan nama *model* atau nama tabel basis data yang sudah dibuat. `{id}` disini merupakan *id* yang telah disimpan pada basis data di tabel `{collection}` yang dituju. Ketika mengakses *routing* ini maka untuk prosesnya akan diterukan ke *controller* bernama *ApiResourcesController* dengan nama *function delete*. proses ini digunakan untuk menghapus data secara *permanent* atau *hard delete* yang telah melakukan *soft delete* pada basis data dengan nama tabel `{collection}` dengan id `{id}`.  
  
contoh alamat website:
- `https://www.example.com/api/v1/countries/1/delete`
- `https://www.example.com/api/v1/provinces/2/delete`

pada contoh alamat website `https://www.example.com/api/v1/countries/1/delete` akan menghapus data secara *permanent* atau *hard delete* yang telah melakukan *soft delete* pada basis data dengan nama tabel *countries* dengan id 1.  
pada contoh alamat website `https://www.example.com/api/v1/provinces/2/delete` akan menghapus data secara *permanent* atau *hard delete* yang telah melakukan *soft delete* pada basis data dengan nama tabel *provinces* dengan id 2.  
  
10. Route::get("{collection}/{id}", 'Api\ApiResourcesController@show')->where('id', '[a-zA-Z0-9]+')
  
*Routing* ini menggunakan *method* GET dan nama alamat website disini adalah `v1/{collection}/{id}`. `{collection}` disini merupakan nama *model* atau nama tabel basis data yang sudah dibuat. `{id}` disini merupakan *id* yang telah disimpan pada basis data di tabel `{collection}` yang dituju. Ketika mengakses *routing* ini maka untuk prosesnya akan diterukan ke *controller* bernama *ApiResourcesController* dengan nama *function show*. proses ini digunakan untuk mengambil data dari basis data dengan nama tabel `{collection}` dengan id `{id}`.  
  
contoh alamat website:
- `https://www.example.com/api/v1/countries/1`
- `https://www.example.com/api/v1/provinces/2`

pada contoh alamat website `https://www.example.com/api/v1/countries/1` akan mengambil data dari basis data dengan nama tabel *countries* dengan id 1.  
pada contoh alamat website `https://www.example.com/api/v1/provinces/2` akan mengambil data dari basis data dengan nama tabel *provinces* dengan id 2.  
  
11. Route::put("{collection}/{id}", 'Api\ApiResourcesController@update')->where('id', '[a-zA-Z0-9]+')
  
*Routing* ini menggunakan *method* PUT dan nama alamat website disini adalah `v1/{collection}/{id}`. `{collection}` disini merupakan nama *model* atau nama tabel basis data yang sudah dibuat. `{id}` disini merupakan *id* yang telah disimpan pada basis data di tabel `{collection}` yang dituju. Ketika mengakses *routing* ini maka untuk prosesnya akan diterukan ke *controller* bernama *ApiResourcesController* dengan nama *function update*. proses ini digunakan untuk *update* data pada basis data dengan nama tabel `{collection}` dengan id `{id}`.  
  
contoh alamat website:
- `https://www.example.com/api/v1/countries/1`
- `https://www.example.com/api/v1/provinces/2`

pada contoh alamat website `https://www.example.com/api/v1/countries/1` akan *update* data pada basis data dengan nama tabel *countries* dengan id 1.  
pada contoh alamat website `https://www.example.com/api/v1/provinces/2` akan *update* data pada basis data dengan nama tabel *provinces* dengan id 2.  
  
12. Route::patch("{collection}/{id}", 'Api\ApiResourcesController@patch')->where('id', '[a-zA-Z0-9]+')
  
*Routing* ini menggunakan *method* PATCH dan nama alamat website disini adalah `v1/{collection}/{id}`. `{collection}` disini merupakan nama *model* atau nama tabel basis data yang sudah dibuat. `{id}` disini merupakan *id* yang telah disimpan pada basis data di tabel `{collection}` yang dituju. Ketika mengakses *routing* ini maka untuk prosesnya akan diterukan ke *controller* bernama *ApiResourcesController* dengan nama *function patch*. proses ini digunakan untuk *update* sebagian data pada basis data dengan nama tabel `{collection}` dengan id `{id}`.  
  
contoh alamat website:
- `https://www.example.com/api/v1/countries/1`
- `https://www.example.com/api/v1/provinces/2`

pada contoh alamat website `https://www.example.com/api/v1/countries/1` akan *update* sebagian data pada basis data dengan nama tabel *countries* dengan id 1.  
pada contoh alamat website `https://www.example.com/api/v1/provinces/2` akan *update* sebagian data pada basis data dengan nama tabel *provinces* dengan id 2.
  
13. Route::delete("{collection}/{id}", 'Api\ApiResourcesController@destroy')->where('id', '[a-zA-Z0-9]+')
  
*Routing* ini menggunakan *method* DELETE dan nama alamat website disini adalah `v1/{collection}/{id}`. `{collection}` disini merupakan nama *model* atau nama tabel basis data yang sudah dibuat. `{id}` disini merupakan *id* yang telah disimpan pada basis data di tabel `{collection}` yang dituju. Ketika mengakses *routing* ini maka untuk prosesnya akan diterukan ke *controller* bernama *ApiResourcesController* dengan nama *function destroy*. proses ini digunakan untuk menghapus data secara *soft delete* pada basis data dengan nama tabel `{collection}` dengan id `{id}`.  
  
contoh alamat website:
- `https://www.example.com/api/v1/countries/1`
- `https://www.example.com/api/v1/provinces/2`

pada contoh alamat website `https://www.example.com/api/v1/countries/1` akan menghapus data secara *soft delete* pada basis data dengan nama tabel *countries* dengan id 1.  
pada contoh alamat website `https://www.example.com/api/v1/provinces/2` akan menghapus data secara *soft delete* pada basis data dengan nama tabel *provinces* dengan id 2.  
  