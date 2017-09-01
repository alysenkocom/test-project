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
        '<module:gallery>/<galleryId:\d+>' => '<module>/default/index',
        '<module:gallery>/page/<page:\d+>' => '<module>/default/index',
        '<module:gallery>/create' => '<module>/default/create',
        '<module:gallery>/<galleryId:\d+>/page/<page:\d+>' => '<module>/default/index',
        '<module:gallery>/image/<imageId:\d+>' => '<module>/image/index',
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