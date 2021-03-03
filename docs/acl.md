# Access Control Level

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
