# Access Control Level  
  
Access Control Level (ACL) yang digunakan adalah *laravel-permission spatie*. Spatie merupakan library yang digunakan untuk mengatur user permission dan user role dalam mengakses app yang dituju. 
  
Dalam pembuatan permission ada 3 domain level yang digunakan, yaitu:  
  
1. Level pertama  
  
Pada level pertama terdapat nama model yang dituju.  
Contoh:  
* *.*.* , menunjukan dapat melakukan seluruh kegiatan.
* countries.*.* , menunjukan dapat melakukan seluruh kegiatan pada model countries.
* provinces.*.* , menunjukan dapat melakukan seluruh kegiatan pada model provinces.
  
2. Level kedua
  
Pada level kedua terdapat tindakan yang dilakukan pada model yang dituju.  
contoh:  
* *.*.* , menunjukan dapat melakukan seluruh kegiatan.
* *.read.* , menunjukan dapat melakukan kegiatan read pada seluruh model.
* countries.create.* , menunjukan dapat melakukan kegiatan create pada model countries.
  
3. Level ketiga
  
Pada level ketika tedapat akses khusus terhadapat tindakan yang diijinkan.  
contoh:  
* *.*.* , menunjukan dapat melakukan seluruh kegiatan.
* *.read.id:1 , menunjukan hanya dapat melakukan kegiatan read pada id 1 pada seluruh model.
* countries.read.id:2 , menunjukan hanya dapat melakukan kegiatan read pada id 2 pada model countries.
  
Pada saat melakukan proses *seeder* secara default app akan menghasilkan default permission dan roles.  
  
#### List permissions:
  
1. Akses `"create"` ke setiap model yang ada.
  
Memberi ijin akses untuk melakukan pembuatan data terhadap suatu model.
  
2. Akses `"read"` ke setiap model yang ada.
  
Memberi ijin akses untuk melakukan pembacaan data terhadap suatu model.
  
3. Akses `"update"` ke setiap model yang ada.
  
Memberi iji akses untuk melakukan pengubahan data terhadap suatu model.

4. Akses `"restore"` ke setiap model yang ada.
  
Memberi iji akses untuk melakukan pengembalian data yang telah melakukan softdelete terhadap suatu model.

5. Akses `"destroy"` ke setiap model yang ada.
  
Memberi iji akses untuk melakukan softdelete data terhadap suatu model.

6. Akses `"delete"` ke setiap model yang ada.
  
Memberi iji akses untuk melakukan penghapusan data (harddelete) terhadapat data yang sudah melakukan softdelete terhadap suatu model.

7. Akses `"trash"` ke setiap model yang ada.
  
Memberi iji akses untuk melihat seluruh data yang telah melakukan softdelete terhadap suatu model.
  
8. Akses `"empty"` ke setiap model yang ada.
  
Memberi iji akses untuk melakukan penghapusan seluruh data yang sudah melakukan softdelete terhadap suatu model.

9. Akses `"import"` ke setiap model yang ada.
  
Memberi iji akses untuk melakukan import data terhadap suatu model.

10. Akses `"export"` ke setiap model yang ada.
  
Memberi iji akses untuk melakukan export data terhadap suatu model.

11. Akses `"report"` ke setiap model yang ada.
  
Memberi iji akses untuk melakukan report data terhadap suatu model.

12. Akses `"*"` atau seluruh ke setiap model yang ada.
  
Memberi iji akses untuk melakukan keseluruhan tindakan terhadap suatu model.
  
#### List roles:
  
1. superadmin
  
mendapat ijin akses `"*.*.*"`. Role ini mendapatkan ijin untuk melakukan seluruh tindakan pada seluruh model.
  
2. admin
  
mendapatkan ijin akses `"users.read.*" , "users.update.*"`. Role ini mendapatkan ijin melakukan *read* dan *update* pada model users.
  
3. operator
  
mendapatkan ijin akses `"users.read.*" , "users.update.*"`. Role ini mendapatkan ijin melakukan *read* dan *update* pada model users.
  
4. reporter
  
mendapatkan ijin akses `"users.read.*" , "users.update.*"`. Role ini mendapatkan ijin melakukan *read* dan *update* pada model users.

5. manager
  
mendapatkan ijin akses `"users.read.*" , "users.update.*"`. Role ini mendapatkan ijin melakukan *read* dan *update* pada model users.
  
6. hrd
  
mendapatkan ijin akses `"users.read.*" , "users.update.*"`. Role ini mendapatkan ijin melakukan *read* dan *update* pada model users.
  
7. author
  
mendapatkan ijin akses `"users.read.*" , "users.update.*"`. Role ini mendapatkan ijin melakukan *read* dan *update* pada model users.
  
8. editor
  
mendapatkan ijin akses `"users.read.*" , "users.update.*"`. Role ini mendapatkan ijin melakukan *read* dan *update* pada model users.
  
9. drafter
  
mendapatkan ijin akses `"users.read.*" , "users.update.*"`. Role ini mendapatkan ijin melakukan *read* dan *update* pada model users.
  
10. driver
  
mendapatkan ijin akses `"users.read.*" , "users.update.*"`. Role ini mendapatkan ijin melakukan *read* dan *update* pada model users.
  
11. user
  
mendapatkan ijin akses `"users.read.*" , "users.update.*"`. Role ini mendapatkan ijin melakukan *read* dan *update* pada model users.
  
  
  
```php
...
$user = Auth::user();
if($user->hasAnyPermission(['countries.read.isocode:ID'])) {
    $model->where('isocode', 'ID');
}
...
```

```php
...
$user = Auth::user();
if(!$user->hasAnyPermission(['countries.read.isocode-'.$data->isocode])) {
    abort(403);
}
...
```
