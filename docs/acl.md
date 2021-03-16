# Access Control Level  
  
Access Control Level (ACL) yang digunakan adalah *laravel-permission spatie*. Spatie merupakan library yang digunakan untuk mengatur user permission dan user role dalam mengakses app yang dituju. 
  
Dalam pembuatan permission ada 3 domain level yang digunakan, yaitu:  
  
1. Level pertama  
  
Pada level pertama terdapat nama model atau nama tabel basis data yang dituju.  
Contoh:  
* *.*.* , menunjukan dapat melakukan seluruh kegiatan.
* countries.*.* , menunjukan dapat melakukan seluruh kegiatan pada model countries.
* provinces.*.* , menunjukan dapat melakukan seluruh kegiatan pada model provinces.
  
2. Level kedua
  
Pada level kedua terdapat tindakan yang dilakukan pada model atau nama tabel basis data yang dituju.  
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
  
1. Akses `"create"` ke setiap tabel basis data yang ada.
  
Memberi ijin akses untuk melakukan pembuatan data terhadap suatu tabel basis data.
  
2. Akses `"read"` ke setiap tabel basis data yang ada.
  
Memberi ijin akses untuk melakukan pembacaan data terhadap suatu tabel basis data.
  
3. Akses `"update"` ke setiap tabel basis data yang ada.
  
Memberi iji akses untuk melakukan pengubahan data terhadap suatu tabel basis data.

4. Akses `"restore"` ke setiap tabel basis data yang ada.
  
Memberi iji akses untuk melakukan pengembalian data yang telah melakukan softdelete terhadap suatu tabel basis data.

5. Akses `"destroy"` ke setiap tabel basis data yang ada.
  
Memberi iji akses untuk melakukan softdelete data terhadap suatu tabel basis data.

6. Akses `"delete"` ke setiap tabel basis data yang ada.
  
Memberi iji akses untuk melakukan penghapusan data (harddelete) terhadapat data yang sudah melakukan softdelete terhadap suatu tabel basis data.

7. Akses `"trash"` ke setiap tabel basis data yang ada.
  
Memberi iji akses untuk melihat seluruh data yang telah melakukan softdelete terhadap suatu tabel basis data.
  
8. Akses `"empty"` ke setiap tabel basis data yang ada.
  
Memberi iji akses untuk melakukan penghapusan seluruh data yang sudah melakukan softdelete terhadap suatu tabel basis data.

9. Akses `"import"` ke setiap tabel basis data yang ada.
  
Memberi iji akses untuk melakukan import data terhadap suatu tabel basis data.

10. Akses `"export"` ke setiap tabel basis data yang ada.
  
Memberi iji akses untuk melakukan export data terhadap suatu tabel basis data.

11. Akses `"report"` ke setiap tabel basis data yang ada.
  
Memberi iji akses untuk melakukan report data terhadap suatu tabel basis data.

12. Akses `"*"` atau seluruh ke setiap tabel basis data yang ada.
  
Memberi iji akses untuk melakukan keseluruhan tindakan terhadap suatu tabel basis data.
  
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
  
  
### Permission Model
  
Pada saat pembuatan model, pada setiap model akan mengatur ijin akses masing-masing. Setiap akses akan ditampung pada variabel bernama `$permissions` dalam bentuk *array*. Berikut merupakan list akses model:
  
1. 'create' => ['*.*.*', '*.create.*']
  
Dapat melakukan proses pembuatan data pada model ini.
  
2. 'read' => ['*.*.*', '*.read.*']
  
Dapat melakukan proses pembacaan data pada model ini.
  
3. 'update' => ['*.*.*', '*.update.*']
  
Dapat melakukan proses pengubahan data pada model ini.
  
4. 'restore' => ['*.*.*', '*.restore.*']
  
Dapat melakukan proses pengembalian data yang telah melakukan softdelete pada model ini.
  
5. 'destroy' => ['*.*.*', '*.destroy.*']
  
Dapat melakukan proses penghapusan data bersifat softdelete pada model ini.
  
6. 'trash' => ['*.*.*', '*.trash.*']
  
Dapat melakukan proses penglihatan list data yang sudah melakukan softdelete pada model ini.
  
7. 'delete' => ['*.*.*', '*.delete.*']
  
Dapat melakukan proses penghapusan data yang telah melakukan softdelete bersifat harddelete data pada model ini.
  
8. 'empty' => ['*.*.*', '*.empty.*']
  
Dapat melakukan proses penghapusan seluruh data yang telah melakukan softdelete bersifat harddelete data pada model ini.
  
9. 'import' => ['*.*.*', '*.import.*']
  
Dapat melakukan proses import data pada model ini.
  
10. 'export' => ['*.*.*', '*.export.*']
  
Dapat melakukan proses export data pada model ini.
  
11. 'report' => ['*.*.*', '*.report.*']
  
Dapat melakukan proses report data pada model ini.
  
### Permission Web & Api

Pada saat melakukan pengaksesan web atau api, diperlukan validasi user. Validasi tersebut melakukan checking pada saat fungsi *checkPermissions* digunakan, pada fungsi *checkPermissions* maka akan melakukan pencarian *permission* yang diijinkan pada model yang dituju, jika memerlukan ijin tertentu maka akan melakukan validasi user terhadap *permission* yang diijinkan. Validasi dilakukan dengan cara mencari role user dan menghasilkan list *permission* kemudian akan dicocokan dengan *permission* yang akan diakses oleh user tersebut. Jika validasi sukses user akan dijinkan melakukan tindakan yang akan dilakukan.
  

### Blade
  
Pada template blade, role dapat digunakan untuk membatasi sebuah text, button, header, navigasi, dan sebagaiannya yang akan di filter oleh role. Dalam penggunaannya dijelaskan sebagai berikut:
  
1. @role(`'role'`)
  
akan melakukan proses validasi user yang login dengan role yang akan dituju.  
contoh:  
@role(`'admin'`)  
  
Akan melakukan validasi user, apakah memiliki role admin.
  
2. @hasrole(`'role'`)

akan melakukan proses validasi user yang login dengan role yang akan dituju.  
contoh:  
@hasrole(`'superadmin'`)  
  
Akan melakukan validasi user, apakah memiliki role superadmin.
  
3. @hasanyrole(`'anyrole|anyrole'`)

akan melakukan proses validasi user yang login dengan salah satu role yang akan dituju.  
contoh:  
@hasanyrole(`'admin|superadmin'`)  
  
Akan melakukan validasi user, apakah memiliki role admin atau superadmin.
  
4. @hasallrole(`'anyrole|anyrole'`)

akan melakukan proses validasi user yang login dengan seluruh role yang akan dituju.  
contoh:  
@hasallrole(`'admin|superadmin'`)  
  
Akan melakukan validasi user, apakah memiliki role admin dan superadmin.
  
5. @unlessrole(`'role'`)

akan melakukan proses validasi user yang login dengan salah satu role yang akan dituju, tetapi validasi sukses jika user yang login tidak memiliki role yang dituju.  
contoh:  
@unlessrole(`'admin'`)  
  
Akan melakukan validasi user, apakah tidak memiliki role admin.
  
  
  
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
