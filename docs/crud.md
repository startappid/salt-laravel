## CRUD  
  
CRUD adalah singkatan dan *create, read, update and delete*. *Create* berarti membuat sebuah data, *read* berarti membaca sebuat data, *update* berarti melakukan perubahan (penambahan / pengurangan) terhadap suatu data yang telah dibuat dan *delete* berarti menghapus suatu daya yang telah dibuat.  
  
Pada project ini terdapat 2 CRUD utama, yaitu CRUD pada *ResourcesController* dan *ApiResourcesController*.  
  
### ResourcesController  
  
ResourcesController ini berfungsi sebagai controller yang mengatur CRUD. serta mengatur pula untuk setiap tampilan maupun data yang akan diberikan sesuai dengan *routing* yang telah dibuat.  
  
#### Construct  
  
Construct ini merupakan fungsi yang selalu berjalan setiap ResourcesController ini digunakan.  
  
Construct ini berisi fungsi untuk melakukan pengecekan terhadap model atau nama tabel yang dituju, melakukan pengecekan permissions, pembuatan breadcrumbs page, pendeklarasian nama model atau nama tabel yang digunakan, pendeklarasian nama segments yang digunakan, dan juga pendeklarasian response yang dikirimkan.  
  
#### Index  
  
Index ini merupakan fungsi yang digunakan untuk memberikan tampilan list dari data.  
  
Index ini berisi fungsi pengecekan model, jika terdapat model maka fungsi akan dilanjutkan dengan mengambil structures dari model yang dituju. Pada fungsi index ini akan memberikan hasil view index, dengan ketentuan melakukan pengecekan terlebih dahulu ke folder `views/{models}/index` dengan `{models}` adalah nama model yang dituju, jika terdapat index pada folder tersebut maka tampilan akan berdasarkan pada file tersebut sedangkan jika tidak ada, maka tampilan akan berdasarkan pada folder `views/resources/index`.  
  
#### Create  
  
Create ini merupakan fungsi yang digunakan untuk memberikan tampilam halaman create.  
  
Create ini berisi fungsi pengecekan model, jika terdapat model maka fungsi akan dilanjutkan dengan mengambil structures dari model yang dituju. Pada fungsi create ini akan memberikan hasil view create, dengan ketentuan melakukan pengecekan terlebih dahulu ke folder `views/{models}/create` dengan `{models}` adalah nama model yang dituju, jika terdapat create pada folder tersebut maka tampilan akan berdasarkan pada file tersebut sedangkan jika tidak ada, maka tampilan akan berdasarkan pada folder `views/resources/create`.  
  
#### Store  
  
Store ini merupakan fungsi yang digunakan untuk menyimpan data.  
  
Store ini berisi fungsi pengecekan model, jika terdapat model maka fungsiakan akan dilanjutkan dengan melakukan validasi sesuai dengan yang dideklarasikan pada model yang dituju. setiap data dengan awalan `"_"` tidak ada di simpan pada basis data.  
  
#### Show  
  
Show ini merupakan fungsi yang digunakan untuk memberikan tampilan halaman show.  
  
Show ini berisi fungsi pengecekan model, jika terdapat model maka fungsi akan dilanjutkan dengan mengambil structures dari model yang dituju. Pada fungsi show ini akan memberikan hasil view show, dengan ketentuan melakukan pengecekan terlebih dahulu ke folder `views/{models}/show` dengan `{models}` adalah nama model yang dituju, jika terdapat show pada folder tersebut maka tampilan akan berdasarkan pada file tersebut sedangkan jika tidak ada, maka tampilan akan berdasarkan pada folder `views/resources/show`. 
  
#### trashed  
  
trashed ini merupakan fungsi yang digunakan untuk memberikan tampilan halaman trashed (data yang sudah dilakukan soft delete).  
  
trashed ini berisi fungsi pengecekan model, jika terdapat model maka fungsi akan dilanjutkan dengan mengambil structures dari model yang dituju. Pada fungsi trashed ini akan memberikan hasil view trashed, dengan ketentuan melakukan pengecekan terlebih dahulu ke folder `views/{models}/trashed` dengan `{models}` adalah nama model yang dituju, jika terdapat trashed pada folder tersebut maka tampilan akan berdasarkan pada file tersebut sedangkan jika tidak ada, maka tampilan akan berdasarkan pada folder `views/resources/trashed`. 
  
#### Edit  
  
Edit ini merupakan fungsi yang digunakan untuk memberikan tampilan halaman edit.  
    
Edit ini berisi fungsi pengecekan model, jika terdapat model maka fungsi akan dilanjutkan dengan melakukan pengecekan id data kemudian mengambil structures dari model yang dituju. Pada fungsi edit ini akan memberikan hasil view edit, dengan ketentuan melakukan pengecekan terlebih dahulu ke folder `views/{models}/edit` dengan `{models}` adalah nama model yang dituju, jika terdapat edit pada folder tersebut maka tampilan akan berdasarkan pada file tersebut sedangkan jika tidak ada, maka tampilan akan berdasarkan pada folder `views/resources/edit`. 
  
#### Update  
  
Update ini merupakan fungsi yang digunakan untuk pengeditan data.  
  
Update ini berisi fungsi pengecekan model, jika terdapat model maka fungsi akan dilanjutkan dengan melakukan pengecekan id kemudian melakukan validasi sesuai dengan yang dideklarasikan pada model yang dituju. setiap data dengan awalan `"_"` tidak ada di simpan pada basis data.  
  
#### Destroy  
  
Destroy ini merupakan fungsi yang digunakan untuk melakukan soft delete data.  
  
Destroy ini berisi fungsi pengecekan model, jika terdapat model maka fungsi akan dilanjutkan dengan melakukan pengecekan id kemudian akan melakukan soft delete pada data dengan id yang dituju.
  
#### Import  
  
Import ini merupakan fungsi yang digunakan untuk menampilkan halaman import.  
  
Import ini berisi fungsi pengecekan model. Pada fungsi import ini akan memberikan hasil view import, dengan ketentuan melakukan pengecekan terlebih dahulu ke folder `views/{models}/import` dengan `{models}` adalah nama model yang dituju, jika terdapat import pada folder tersebut maka tampilan akan berdasarkan pada file tersebut sedangkan jika tidak ada, maka tampilan akan berdasarkan pada folder `views/resources/import`.  
  
#### doImport  
  
doImport ini merupakan fungsi yang digunakan untuk melakukan proses import.  
  
doImport ini berisi fungsi pengecekan model. Pada fungsi import ini akan melakukan validasi file dengan type csv atau txt. Kemudian data pada setiap file bertype csv atau txt tersebut diolah dengan mengambil row pertama sebagai header, dan row selajutnya sebagai isian data dari hader yang diambil. kemudian data tersebut akan disimpan ke basis data.
  
#### Export  
  
Export ini merupakan fungsi yang digunakan untuk menampilkan halaman export.  
  
Export ini berisi fungsi pengecekan model. Pada fungsi export ini akan memberikan hasil view export, dengan ketentuan melakukan pengecekan terlebih dahulu ke folder `views/{models}/export` dengan `{models}` adalah nama model yang dituju, jika terdapat export pada folder tersebut maka tampilan akan berdasarkan pada file tersebut sedangkan jika tidak ada, maka tampilan akan berdasarkan pada folder `views/resources/export`.  
  
#### doExport  
  
doExport ini merupakan fungsi yang digunakan untuk melakukan proses export.  
  
doExport ini berisi fungsi pengecekan model. kemudian akan mencari data dari model yang dituju. kemudian model tersebut akan dibentuk ke format file csv dengan isian dari data yang telah diambil sesuai dengan model yang dituju.

#### Trash  
  
Trash ini merupakan fungsi yang digunakan untuk memberikan tampilan halaman detail dari data trash (data yang telah melakukan softdelete).  
  
Trash ini berisi fungsi pengecekan model, jika terdapat model maka fungsi akan dilanjutkan dengan mengambil structures dari model yang dituju. Pada fungsi trash ini akan memberikan hasil view trash, dengan ketentuan melakukan pengecekan terlebih dahulu ke folder `views/{models}/trash` dengan `{models}` adalah nama model yang dituju, jika terdapat trash pada folder tersebut maka tampilan akan berdasarkan pada file tersebut sedangkan jika tidak ada, maka tampilan akan berdasarkan pada folder `views/resources/trash`. 
  
#### Restore  
  
Restore ini merupakan fungsi yang digunakan untuk mengembalikan data sesuai dengan id yang ditentukan yang telah dilakukan softdelete.  
  
Restore ini berisi fungsi pengecekan model, jika terdapat model maka fungsi akan dilanjutkan dengan melakukan proses pengembalian data dengan id yang sudah ditentukan yang telah melakukan softdelete menjadi data yang bersih (belum melakukan soft delete).  
  
#### putBack

putBack ini merupakan fungsi yang digunakan untuk mengembalikan data yang telah dilakukan softdelete.  
  
putBack ini berisi fungsi pengecekan model, jika terdapat model maka fungsi akan dilanjutkan dengan melakukan proses pengembalian seluruh data yang telah melakukan softdelete menjadi data yang bersih (belum melakukan soft delete).  
  
#### Delete  
  
Delete ini merupakan fungsi yang digunakan untuk menghapus data sesuai id yang ditentukan yang telah dilakukan softdelete.  
  
Delete ini berisi fungsi pengecekan model, jika terdapat model maka fungsi akan dilanjutkan dengan melakukan proses harddelete terhadap data dengan id yang sudah ditentukan yang telah melakukan softdelete.  
  
#### Empty

Empty ini merupakan fungsi yang digunakan untuk penghapusan (harddelete) data yang telah dilakukan softdelete.  
  
Empty ini berisi fungsi pengecekan model, jika terdapat model maka fungsi akan dilanjutkan dengan melakukan proses penghapusan seluruh data (harddelete) yang telah melakukan softdelete.  
  
### ApiResourcesController  
  
ApiResourcesController berisi fungsi fungsi dari service. setiap routing pada api routing akan diteruskan ke controller ini sesuai dengan nama fungsi yang dituju.

#### Construct  
  
Construct ini merupakan fungsi yang selalu berjalan setiap ApiResourcesController ini digunakan.  
  
Construct ini berisi fungsi untuk melakukan pengecekan terhadap model atau nama tabel yang dituju, pendeklarasian structures, pendeklarasian nama model atau nama tabel yang digunakan, pendeklarasian nama segments yang digunakan, dan juga pendeklarasian response yang dikirimkan.  
  
#### Index  
  
Index ini merupakan fungsi untuk meminta data ke basis data.  
  
Index ini dimulai dengan melakukan pengecekan model dan permissions. Jika keduanya berhasil tervalidasi maka akan dilanjutkan melakukan pengambilan data sesuai model yang dituju, kemudian data tersebut akan dikirimkan melalui response dan data tersebut dapat diolah oleh pihak yang telah melakukan permintaan data.  
  
#### Store  
  
Store ini merupakan fungsi untuk menyimpan data ke basis data.  
  
Store ini dimulai dengan melakukan pengecekan model dan permissions. Jika keduanya berhasil tervalidasi maka akan dilanjutkan melakukan penyimpanan data sesuai ke tabel model yang dituju.
  
#### Show  
  
Show ini merupakan fungsi untuk meminta data ke basis data sesuai dengan id yang dituju.  
  
Show ini dimulai dengan melakukan pengecekan model dan permissions. Jika keduanya berhasil tervalidasi maka akan dilanjutkan melakukan pengambilan data sesuai model dan id yang dituju, kemudian data tersebut akan dikirimkan melalui response dan data tersebut dapat diolah oleh pihak yang telah melakukan permintaan data.  
  
#### Update  
  
Update ini merupakan fungsi untuk pengubahan data sesuai dengan id yang dituju.  
  
Update ini dimulai dengan melakukan pengecekan model dan permissions. Jika keduanya berhasil tervalidasi maka akan dilanjutkan melakukan pengubahan data sesuai ke tabel model dan id yang dituju.
  
#### Patch  
  
Patch ini merupakan fungsi untuk pengubahan data sesuai dengan id yang dituju.  
  
Patch ini dimulai dengan melakukan pengecekan model dan permissions. Jika keduanya berhasil tervalidasi maka akan dilanjutkan melakukan pengubahan data sesuai ke tabel model dan id yang dituju.
  
#### Destroy  
  
Destroy ini merupakan fungsi untuk melakukan proses softdelete data sesuai dengan id yang dituju.  
  
Destroy ini dimulai dengan melakukan pengecekan model dan permissions. Jika keduanya berhasil tervalidasi maka akan dilanjutkan melakukan softdelete data sesuai ke tabel model dan id yang dituju.
  
#### Trash  
  
Trash ini merupakan fungsi untuk meminta data yang telah melakukan softdelete ke basis data.  
  
Trash ini dimulai dengan melakukan pengecekan model dan permissions. Jika keduanya berhasil tervalidasi maka akan dilanjutkan melakukan pengambilan data yang telah melakukan softdelete sesuai model yang dituju, kemudian data tersebut akan dikirimkan melalui response dan data tersebut dapat diolah oleh pihak yang telah melakukan permintaan data.  
  
#### Trashed  
  
Trashed ini merupakan fungsi untuk meminta data yang telah melakukan softdelete ke basis data sesuai dengan id yang dituju.  
  
Trashed ini dimulai dengan melakukan pengecekan model dan permissions. Jika keduanya berhasil tervalidasi maka akan dilanjutkan melakukan pengambilan data yang telah melakukan softdelete sesuai model dan id yang dituju, kemudian data tersebut akan dikirimkan melalui response dan data tersebut dapat diolah oleh pihak yang telah melakukan permintaan data.  
  
#### Restore  
  
Restore ini merupakan fungsi untuk mengembalikan data yang telah melakukan softdelete ke basis data sesuai dengan id yang dituju.  
  
Restore ini dimulai dengan melakukan pengecekan model dan permissions. Jika keduanya berhasil tervalidasi maka akan dilanjutkan melakukan pengembalian data yang telah melakukan softdelete sesuai model dan id yang dituju.  
  
#### Delete  
  
Delete ini merupakan fungsi untuk menghapus data (harddelete) yang telah melakukan softdelete ke basis data sesuai dengan id yang dituju.  
  
Delete ini dimulai dengan melakukan pengecekan model dan permissions. Jika keduanya berhasil tervalidasi maka akan dilanjutkan melakukan penghapusan data (harddelete) yang telah melakukan softdelete sesuai model dan id yang dituju.  
  
#### Export  
  
Export ini merupakan fungsi yang digunakan untuk melakukan proses export.  
  
Export ini berisi fungsi pengecekan model dan permissions. Jika keduanya berhasil tervalidasi maka akan dilanjutkan melakukan pencari data dari model yang dituju. kemudian model tersebut akan dibentuk ke format file csv dengan isian dari data yang telah diambil sesuai dengan model yang dituju.