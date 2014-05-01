Simple Photo
=========================================

Simple Photo Wrapper for Laravel 4. Simple photo is a library that simplifies handling of photos in your application.

##Installation

Add `morrelinko/laravel-simple-photo` to your `composer.json` dependencies:

```json
{
  "require": {
    "morrelinko/laravel-simple-photo": "dev-master"
  }
}
```

Afterwards, run `composer update` to update your dependencies or `composer install` to install them.

Add an entry for the service provider by editing `app/config/app.php` config file.

```php
	'providers' => array(

		// ...

		'Morrelinko\LaravelSimplePhoto\SimplePhotoServiceProvider',
	);
```

Add an entry in your 'aliases' for the `SimplePhoto` facade

```php
    'aliases' => array(

        // ...

        'SimplePhoto' => 'Morrelinko\LaravelSimplePhoto\SimplePhotoFacade'
    );
```

Run `php artisan config:publish morrelinko/laravel-simple-photo` to copy the default config file.

Copy the migration from `vendor/morrelinko/laravel-simple-photo/src/migrations to your migrations directory.

And run `php artisan migrate` to run the migration that will create the 'photos' table.

## SimplePhoto

```php
// ...

$source = new LaravelUploadSource($request->file('photo'));
$photoId = SimplePhoto::upload($source);

$user->photo_id = $photoId;
$user->save();
```

And to retrieve the photo later

```php
$user = User::find(1);
$photo = SimplePhoto::get($user->photo_id);

echo $photo->url();
echo $photo->fileSize();
echo $photo->fileExtension();
```

## SimplePhoto & Eloquent Models

If you are using php 5.4+, you should use the `SimplePhotoTrait`. 'Makes things easy!!' (o_o ).

Example:::

```php

use Morrelinko\LaravelSimplePhoto\SimplePhotoTrait;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $photos = array(
        'photo' => array('column' => 'photo_id')
    );

    use SimplePhotoTrait;
}
```

Of course, what this will do is that it will add a  'photo' property to this model. And whenever you try to get

this property, it will retrieve the photo just the same way as the above example shows.

The value is a set of options which the trait uses to build the photo of which the 'column' is the most important

as it is the field which contains the ID of the photo you wish to retrieve.

## Using the Class

```php

$user = User::find(1);

echo $user->photo->url();
echo $user->photo->fileSize();
echo $user->photo->fileExtension();

// .....

```

## Extra

If your entity has more than one photo, you can specify all of em like so:::

```php

use Morrelinko\LaravelSimplePhoto\SimplePhotoTrait;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $photos = array(
        'photo' => array('column' => 'photo_id'),
        'coverPhoto' => array('column' => 'cover_photo_id'),
        'profileBg' => array('column' => 'profile_bg_id')
    );

    use SimplePhotoTrait;
}

$user = User::find(1);
echo $user->photo->url();
echo $user->coverPhoto->url();
echo $user->profileBg->url();
```

Options such as transformations and fallback can be added.

```php

use Morrelinko\LaravelSimplePhoto\SimplePhotoTrait;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $photos = array(
        'photo' => array(
            'column' => 'photo_id',
            'fallback' => 'user_not_found.png',
            'transform' => array(
                'resize' => array(100, 100)
                'rotate' => array(180)
            )),
        'coverPhoto' => array(
            'column' => 'cover_photo_id',
            'fallback' => 'cover_default.png'
        ),
    );

    use SimplePhotoTrait;
}

$user = User::find(1);
echo $user->photo->url();
echo $user->coverPhoto->url();
```