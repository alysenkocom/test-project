# yii2-gallery
http://runashop.ithata.com/gallery

## Installation

### yii2 install 
More info: http://www.yiiframework.com/
```
composer create-project --prefer-dist yiisoft/yii2-app-basic basic
```
then download repository and put module into `your_app/modules/`


### Composer settings:
add 
```
"require": {
    ....
    "yiisoft/yii2-imagine": "*",  // for work with images
    "vyants/yii2-daemon": "*"     // for daemons
}
```
to the require section of your composer.json file and update it (`php composer.phar update`)

### Configuration

Configure the `Gallery` module:


```
# your_app/config/web.php
'modules' => [
  ....
  'gallery' => [
      'class' => 'app\modules\Gallery\Module',
  ]
],
  
...

'urlManager' => [
    .....
    'rules' => [
        '<module:gallery>/<albumId:\d+>' => '<module>/default/view',
        '<module:gallery>/page/<page:\d+>' => '<module>/default/index',
        '<module:gallery>/create' => '<module>/default/create',
        '<module:gallery>/<galleryId:\d+>/page/<page:\d+>' => '<module>/default/index',
        '<module:gallery>/image/<imageId:\d+>' => '<module>/image/view',
        '<module:gallery>/image/upload' => '<module>/image/upload',
        # '' => 'gallery/default/index', // if you want make module as main
    ],
]
```

then console config

```
'bootstrap' => [
  ....
  'gallery'
],

....

'modules' => [
  'gallery' => [
      'class' => 'app\modules\Gallery\Module',
  ]
],
```

also you should added new configuration for module:

```
'params' => [
    ....

    /** config for `app\modules\Gallery` */
    'galleryModule' => [
        'sourcePath' => 'web/uploads/source/',
        'sizes' => [
            'small' 	=> [ 'size' => 100, 'defaultImg' => 'http://placehold.it/100x100', 'path' => 'web/uploads/100/' ],
            'medium' 	=> [ 'size' => 360, 'defaultImg' => 'http://placehold.it/360x360', 'path' => 'web/uploads/360/' ],
            'large' 	=> [ 'size' => 720, 'defaultImg' => 'http://placehold.it/720x720', 'path' => 'web/uploads/720/' ],
        ]
    ],
]
```
